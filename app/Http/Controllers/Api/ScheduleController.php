<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\Request as ServiceRequest;
use App\Models\Quote;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    /**
     * Get all schedule events for the calendar
     */
    public function getEvents(Request $request)
    {
        $userId = Auth::id();
        $events = [];

        // Get jobs
        $jobs = Job::where('user_id', $userId)
            ->whereNotNull('schedule_date')
            ->get();

        foreach ($jobs as $job) {
            $events[] = [
                'id' => 'job-' . $job->id,
                'title' => $job->title,
                'start' => $job->schedule_date,
                'className' => 'job-event',
                'extendedProps' => [
                    'type' => 'job',
                    'status' => $job->status,
                    'client' => $job->client->title ?? 'Unknown Client',
                    'time' => $job->start_time ? Carbon::parse($job->start_time)->format('g:i A') : null
                ]
            ];
        }

        // Get requests
        $requests = ServiceRequest::where('user_id', $userId)
            ->whereNotNull('onsite_date')
            ->get();

        foreach ($requests as $request) {
            $events[] = [
                'id' => 'request-' . $request->id,
                'title' => $request->title,
                'start' => $request->onsite_date,
                'className' => 'request-event',
                'extendedProps' => [
                    'type' => 'request',
                    'status' => $request->status,
                    'client' => $request->client->title ?? 'Unknown Client',
                    'time' => $request->onsite_time ? Carbon::parse($request->onsite_time)->format('g:i A') : null
                ]
            ];
        }

        // Get quotes (using created_at as schedule date for now)
        $quotes = Quote::where('user_id', $userId)
            ->whereDate('created_at', '>=', Carbon::now()->subDays(30))
            ->get();

        foreach ($quotes as $quote) {
            $events[] = [
                'id' => 'quote-' . $quote->id,
                'title' => $quote->title,
                'start' => $quote->created_at->format('Y-m-d'),
                'className' => 'quote-event',
                'extendedProps' => [
                    'type' => 'quote',
                    'status' => $quote->status,
                    'client' => $quote->client->title ?? 'Unknown Client'
                ]
            ];
        }

        // Get invoices
        $invoices = Invoice::where('user_id', $userId)
            ->whereNotNull('issued_date')
            ->get();

        foreach ($invoices as $invoice) {
            $events[] = [
                'id' => 'invoice-' . $invoice->id,
                'title' => $invoice->invoice_subject,
                'start' => $invoice->issued_date,
                'className' => 'invoice-event',
                'extendedProps' => [
                    'type' => 'invoice',
                    'status' => $invoice->status,
                    'client' => $invoice->client->title ?? 'Unknown Client'
                ]
            ];
        }

        return response()->json(['events' => $events]);
    }

    /**
     * Get data counts for a specific date
     */
    public function getDateData(Request $request, $date)
    {
        $userId = Auth::id();
        $date = Carbon::parse($date);

        $jobsCount = Job::where('user_id', $userId)
            ->whereDate('schedule_date', $date)
            ->count();

        $requestsCount = ServiceRequest::where('user_id', $userId)
            ->whereDate('onsite_date', $date)
            ->count();

        $quotesCount = Quote::where('user_id', $userId)
            ->whereDate('created_at', $date)
            ->count();

        $invoicesCount = Invoice::where('user_id', $userId)
            ->whereDate('issued_date', $date)
            ->count();

        return response()->json([
            'counts' => [
                'jobs' => $jobsCount,
                'requests' => $requestsCount,
                'quotes' => $quotesCount,
                'invoices' => $invoicesCount
            ]
        ]);
    }

    /**
     * Get detailed items for a specific date
     */
    public function getDateDetails(Request $request, $date)
    {
        $userId = Auth::id();
        $date = Carbon::parse($date);
        $items = [];

        // Get jobs for the date
        $jobs = Job::with('client')
            ->where('user_id', $userId)
            ->whereDate('schedule_date', $date)
            ->get();

        foreach ($jobs as $job) {
            $items[] = [
                'id' => $job->id,
                'title' => $job->title,
                'type' => 'job',
                'status' => $job->status,
                'client' => $job->client->title ?? 'Unknown Client',
                'time' => $job->start_time ? Carbon::parse($job->start_time)->format('g:i A') : null,
                'url' => route('jobs.show', $job->id)
            ];
        }

        // Get requests for the date
        $requests = ServiceRequest::with('client')
            ->where('user_id', $userId)
            ->whereDate('onsite_date', $date)
            ->get();

        foreach ($requests as $request) {
            $items[] = [
                'id' => $request->id,
                'title' => $request->title,
                'type' => 'request',
                'status' => $request->status,
                'client' => $request->client->title ?? 'Unknown Client',
                'time' => $request->onsite_time ? Carbon::parse($request->onsite_time)->format('g:i A') : null,
                'url' => route('requests.show', $request->id)
            ];
        }

        // Get quotes for the date
        $quotes = Quote::with('client')
            ->where('user_id', $userId)
            ->whereDate('created_at', $date)
            ->get();

        foreach ($quotes as $quote) {
            $items[] = [
                'id' => $quote->id,
                'title' => $quote->title,
                'type' => 'quote',
                'status' => $quote->status,
                'client' => $quote->client->title ?? 'Unknown Client',
                'url' => route('quotes.show', $quote->id)
            ];
        }

        // Get invoices for the date
        $invoices = Invoice::with('client')
            ->where('user_id', $userId)
            ->whereDate('issued_date', $date)
            ->get();

        foreach ($invoices as $invoice) {
            $items[] = [
                'id' => $invoice->id,
                'title' => $invoice->invoice_subject,
                'type' => 'invoice',
                'status' => $invoice->status,
                'client' => $invoice->client->title ?? 'Unknown Client',
                'url' => route('invoices.show', $invoice->id)
            ];
        }

        return response()->json(['items' => $items]);
    }
}
