<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobs = Job::where('user_id', 1)->orderBy('created_at', 'desc')->get();
        $hasJobs = $jobs->count() > 0;
        if (request()->wantsJson()) {
            return response()->json(['data' => $jobs, 'hasJobs' => $hasJobs]);
        }
        return view('admin.pages.jobs.jobs', compact('jobs', 'hasJobs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = Client::where('user_id', Auth::id())->latest()->get();
        if (request()->wantsJson()) {
            return response()->json(['clients' => $clients]);
        }
        return view('admin.pages.jobs.new-job', compact('clients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'client_id' => 'required|exists:clients,id',
            'job_number' => 'nullable|string|max:50',
            'salesperson' => 'nullable|string|max:255',
            'job_type' => 'required|in:one-off,recurring',
            'schedule_date' => 'nullable|date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i',
            'repeats' => 'nullable|string|max:255',
            'visit_instructions' => 'nullable|string',
            'notes' => 'nullable|string',
            'total_cost' => 'nullable|numeric|min:0',
            'total_price' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            if ($request->wantsJson()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Get the next job number if not provided
        $jobNumber = $request->job_number;
        if (empty($jobNumber)) {
            $lastJob = Job::orderBy('id', 'desc')->first();
            $jobNumber = $lastJob ? $lastJob->id + 1 : 1;
        }

        // Process product items
        $productItems = [];
        if ($request->has('product_items')) {
            $productItems = json_decode($request->product_items, true);
        }

        // Process attachments - store files and keep metadata with path (like requests/quotes)
        $attachments = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('job-attachments', $filename, 'public');
                $attachments[] = [
                    'filename' => $file->getClientOriginalName(),
                    'path' => $path,
                    'size' => $file->getSize(),
                    'type' => $file->getMimeType()
                ];
            }
        }

        $job = Job::create([
            'user_id' => 1,
            'client_id' => $request->input('client_id'),
            'title' => $request->title,
            'job_number' => $jobNumber,
            'salesperson' => $request->salesperson,
            'job_type' => $request->job_type,
            'schedule_date' => $request->schedule_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'schedule_later' => $request->has('schedule_later'),
            'anytime' => $request->has('anytime'),
            'repeats' => $request->repeats,
            'repeat_end_type' => $request->repeat_end_type,
            'repeat_end_after_number' => $request->repeat_end_after_number,
            'repeat_end_after_period' => $request->repeat_end_after_period,
            'repeat_end_on_date' => $request->repeat_end_on_date,
            'visit_instructions' => $request->visit_instructions,
            'email_team' => $request->has('email_team'),
            'send_invoice' => $request->has('send_invoice'),
            'product_items' => $productItems,
            'total_cost' => $request->total_cost ?? 0,
            'total_price' => $request->total_price ?? 0,
            'notes' => $request->notes,
            'attachments' => $attachments,
            'status' => 'pending'
        ]);

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Job created successfully!', 'data' => $job], 201);
        }
        return redirect()->route('jobs.index')->with('success', 'Job created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Job $job)
    {
        if (request()->wantsJson()) {
            return response()->json($job);
        }
        return view('admin.pages.jobs.job-details', compact('job'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Job $job)
    {
        $clients = Client::where('user_id', Auth::id())->latest()->get();
        if (request()->wantsJson()) {
            return response()->json(['job' => $job, 'clients' => $clients]);
        }
        return view('admin.pages.jobs.new-job', compact('job', 'clients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Job $job)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'nullable|string|max:255',
            'client_id' => 'nullable|exists:clients,id',
            'job_number' => 'nullable|string|max:50',
            'salesperson' => 'nullable|string|max:255',
            'job_type' => 'required|in:one-off,recurring',
            'schedule_date' => 'nullable|date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i',
            'repeats' => 'nullable|string|max:255',
            'visit_instructions' => 'nullable|string',
            'notes' => 'nullable|string',
            'total_cost' => 'nullable|numeric|min:0',
            'total_price' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            if ($request->wantsJson()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Process product items
        $productItems = [];
        if ($request->has('product_items')) {
            $productItems = json_decode($request->product_items, true);
        }

        // Process attachments - append newly uploaded files with stored paths
        $attachments = $job->attachments ?? [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('job-attachments', $filename, 'public');
                $attachments[] = [
                    'filename' => $file->getClientOriginalName(),
                    'path' => $path,
                    'size' => $file->getSize(),
                    'type' => $file->getMimeType()
                ];
            }
        }

        $job->update([
            'client_id' => $request->input('client_id', $job->client_id),
            'title' => $request->title,
            'job_number' => $request->job_number,
            'salesperson' => $request->salesperson,
            'job_type' => $request->job_type,
            'schedule_date' => $request->schedule_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'schedule_later' => $request->has('schedule_later'),
            'anytime' => $request->has('anytime'),
            'repeats' => $request->repeats,
            'repeat_end_type' => $request->repeat_end_type,
            'repeat_end_after_number' => $request->repeat_end_after_number,
            'repeat_end_after_period' => $request->repeat_end_after_period,
            'repeat_end_on_date' => $request->repeat_end_on_date,
            'visit_instructions' => $request->visit_instructions,
            'email_team' => $request->has('email_team'),
            'send_invoice' => $request->has('send_invoice'),
            'product_items' => $productItems,
            'total_cost' => $request->total_cost ?? 0,
            'total_price' => $request->total_price ?? 0,
            'notes' => $request->notes,
            'attachments' => $attachments,
        ]);

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Job updated successfully!', 'data' => $job]);
        }
        return redirect()->route('jobs.index')->with('success', 'Job updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Job $job)
    {
        $job->delete();
        if (request()->wantsJson()) {
            return response()->json(['message' => 'Job deleted successfully!']);
        }
        return redirect()->route('jobs.index')->with('success', 'Job deleted successfully!');
    }
}
