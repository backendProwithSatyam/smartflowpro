<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQuoteRequest;
use App\Models\Client;
use App\Models\FormField;
use App\Models\Quote;
use App\Models\TaxRate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class QuoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $quotes = Quote::with(['client', 'salespersonUser', 'taxRate'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('admin.pages.quotes.index', compact('quotes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = Client::where('user_id', Auth::id())->latest()->get();
        $users = User::where('id', '!=', Auth::id())->get();
        $taxRates = TaxRate::where('user_id', Auth::id())->get();
        $quoteNumber = Quote::generateQuoteNumber();
        $customFields = FormField::where('user_id', Auth::id())
            ->where('current_page_name', 'quotes')
            ->orWhere('transferrable', true)
            ->get();
        return view('admin.pages.quotes.create', compact('clients', 'users', 'taxRates', 'quoteNumber','customFields'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreQuoteRequest $request)
    {
        try {
            $data = $request->validated();
            $data['user_id'] = Auth::id();

            // Generate quote number if not provided
            if (empty($data['quote_number'])) {
                $data['quote_number'] = Quote::generateQuoteNumber();
            }

            // Calculate totals
            $this->calculateTotals($data);
            // dd($data);
            // Handle file uploads
            if ($request->hasFile('attachments')) {
                $attachments = [];
                foreach ($request->file('attachments') as $file) {
                    $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('quote-attachments', $filename, 'public');
                    $attachments[] = [
                        'filename' => $file->getClientOriginalName(),
                        'path' => $path,
                        'size' => $file->getSize(),
                        'type' => $file->getMimeType()
                    ];
                }
                $data['attachments'] = $attachments;
            }
            $quote = Quote::create($data);
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Quote created successfully!',
                    'data' => $quote
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Quote created successfully!',
                'data' => $quote
            ]);
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error creating quote: ' . $e->getMessage()
                ], 500);
            }

            return back()->withInput()
                ->with('error', 'Error creating quote: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $quote = Quote::with(['client', 'salespersonUser', 'taxRate'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('admin.pages.quotes.show', compact('quote'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $quote = Quote::where('user_id', Auth::id())->findOrFail($id);
        $clients = Client::where('user_id', Auth::id())->latest()->get();
        $users = User::where('id', '!=', Auth::id())->get();
        $taxRates = TaxRate::where('user_id', Auth::id())->get();

        return view('admin.pages.quotes.edit', compact('quote', 'clients', 'users', 'taxRates'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreQuoteRequest $request, string $id)
    {
        try {
            $quote = Quote::where('user_id', Auth::id())->findOrFail($id);

            $data = $request->validated();

            // Calculate totals
            $this->calculateTotals($data);

            // Handle file uploads
            if ($request->hasFile('attachments')) {
                $attachments = $quote->attachments ?? [];
                foreach ($request->file('attachments') as $file) {
                    $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('quote-attachments', $filename, 'public');
                    $attachments[] = [
                        'filename' => $file->getClientOriginalName(),
                        'path' => $path,
                        'size' => $file->getSize(),
                        'type' => $file->getMimeType()
                    ];
                }
                $data['attachments'] = $attachments;
            }

            $quote->update($data);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Quote updated successfully!',
                    'data' => $quote
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Quote updated successfully!',
                'data' => $quote
            ]);
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error updating quote: ' . $e->getMessage()
                ], 500);
            }

            return back()->withInput()
                ->with('error', 'Error updating quote: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $quote = Quote::where('user_id', Auth::id())->findOrFail($id);

            // Delete associated files
            if ($quote->attachments) {
                foreach ($quote->attachments as $attachment) {
                    if (Storage::disk('public')->exists($attachment['path'])) {
                        Storage::disk('public')->delete($attachment['path']);
                    }
                }
            }

            $quote->delete();

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Quote deleted successfully!'
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Quote deleted successfully!'
            ]);
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error deleting quote: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Error deleting quote: ' . $e->getMessage());
        }
    }

    /**
     * Calculate totals for the quote
     */
    private function calculateTotals(&$data)
    {
        $subtotal = 0;

        if (isset($data['line_items']) && is_array($data['line_items'])) {
            foreach ($data['line_items'] as $item) {
                if (isset($item['quantity']) && isset($item['unit_price'])) {
                    $itemTotal = $item['quantity'] * $item['unit_price'];
                    $subtotal += $itemTotal;
                }
            }
        }

        $data['subtotal'] = $subtotal;

        // Calculate discount
        $discountAmount = 0;
        if (isset($data['discount_amount']) && $data['discount_amount'] > 0) {
            if ($data['discount_type'] === 'percentage') {
                $discountAmount = ($subtotal * $data['discount_amount']) / 100;
            } else {
                $discountAmount = $data['discount_amount'];
            }
        }

        // Calculate tax
        $taxAmount = 0;
        if (isset($data['tax_rate_id']) && $data['tax_rate_id']) {
            $taxRate = TaxRate::find($data['tax_rate_id']);
            if ($taxRate) {
                $taxableAmount = $subtotal - $discountAmount;
                $taxAmount = ($taxableAmount * $taxRate->rate) / 100;
            }
        }

        $data['tax_amount'] = $taxAmount;

        // Calculate total
        $data['total'] = $subtotal - $discountAmount + $taxAmount;
    }
}
