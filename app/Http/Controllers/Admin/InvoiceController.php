<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInvoiceRequest;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\TaxRate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = Invoice::with(['client', 'salespersonUser', 'taxRate'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('admin.pages.invoices.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = Client::where('user_id', Auth::id())->latest()->get();
        return view('admin.pages.invoices.select-client', compact('clients'));
    }

    /**
     * Show the form for creating invoice for specific client.
     */
    public function createForClient($clientId)
    {
        $client = Client::where('user_id', Auth::id())->findOrFail($clientId);
        $users = User::where('id', '!=', Auth::id())->get();
        $taxRates = TaxRate::where('user_id', Auth::id())->get();
        $invoiceNumber = Invoice::generateInvoiceNumber();

        return view('admin.pages.invoices.create', compact('client', 'users', 'taxRates', 'invoiceNumber'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInvoiceRequest $request)
    {
        try {
            $data = $request->validated();
            $data['user_id'] = Auth::id();

            // Generate invoice number if not provided
            if (empty($data['invoice_number'])) {
                $data['invoice_number'] = Invoice::generateInvoiceNumber();
            }

            // Calculate totals
            $this->calculateTotals($data);

            // Handle file uploads
            if ($request->hasFile('attachments')) {
                $attachments = [];
                foreach ($request->file('attachments') as $file) {
                    $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('invoice-attachments', $filename, 'public');
                    $attachments[] = [
                        'filename' => $file->getClientOriginalName(),
                        'path' => $path,
                        'size' => $file->getSize(),
                        'type' => $file->getMimeType()
                    ];
                }
                $data['attachments'] = $attachments;
            }

            $invoice = Invoice::create($data);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Invoice created successfully!',
                    'data' => $invoice
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Invoice created successfully!',
                'data' => $invoice
            ]);
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error creating invoice: ' . $e->getMessage()
                ], 500);
            }

            return back()->withInput()
                ->with('error', 'Error creating invoice: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $invoice = Invoice::with(['client', 'salespersonUser', 'taxRate'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('admin.pages.invoices.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $invoice = Invoice::where('user_id', Auth::id())->findOrFail($id);
        $client = $invoice->client;
        $users = User::where('id', '!=', Auth::id())->get();
        $taxRates = TaxRate::where('user_id', Auth::id())->get();

        return view('admin.pages.invoices.edit', compact('invoice', 'client', 'users', 'taxRates'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreInvoiceRequest $request, string $id)
    {
        try {
            $invoice = Invoice::where('user_id', Auth::id())->findOrFail($id);

            $data = $request->validated();

            // Calculate totals
            $this->calculateTotals($data);

            // Handle file uploads
            if ($request->hasFile('attachments')) {
                $attachments = $invoice->attachments ?? [];
                foreach ($request->file('attachments') as $file) {
                    $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('invoice-attachments', $filename, 'public');
                    $attachments[] = [
                        'filename' => $file->getClientOriginalName(),
                        'path' => $path,
                        'size' => $file->getSize(),
                        'type' => $file->getMimeType()
                    ];
                }
                $data['attachments'] = $attachments;
            }

            $invoice->update($data);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Invoice updated successfully!',
                    'data' => $invoice
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Invoice updated successfully!',
                'data' => $invoice
            ]);
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error updating invoice: ' . $e->getMessage()
                ], 500);
            }

            return back()->withInput()
                ->with('error', 'Error updating invoice: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $invoice = Invoice::where('user_id', Auth::id())->findOrFail($id);

            // Delete associated files
            if ($invoice->attachments) {
                foreach ($invoice->attachments as $attachment) {
                    if (Storage::disk('public')->exists($attachment['path'])) {
                        Storage::disk('public')->delete($attachment['path']);
                    }
                }
            }

            $invoice->delete();

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Invoice deleted successfully!'
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Invoice deleted successfully!'
            ]);
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error deleting invoice: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Error deleting invoice: ' . $e->getMessage());
        }
    }

    /**
     * Update invoice status
     */
    public function updateStatus(Request $request, string $id)
    {
        try {
            $invoice = Invoice::where('user_id', Auth::id())->findOrFail($id);

            $request->validate([
                'status' => 'required|in:draft,sent,paid,overdue,cancelled'
            ]);

            $invoice->update(['status' => $request->status]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Invoice status updated successfully!'
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Invoice status updated successfully!'
            ]);
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error updating invoice status: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Error updating invoice status: ' . $e->getMessage());
        }
    }

    /**
     * Calculate totals for the invoice
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
