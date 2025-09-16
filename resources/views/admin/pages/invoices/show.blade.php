@extends('admin.include.master')
@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        .invoice-container {
            max-width: 1000px;
            margin: 0 auto;
        }
        
        .invoice-header {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 2rem;
            margin-bottom: 2rem;
        }
        
        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 1rem;
            font-size: 0.875rem;
            font-weight: 500;
        }
        
        .status-draft { background-color: #f3f4f6; color: #374151; }
        .status-sent { background-color: #dbeafe; color: #1e40af; }
        .status-paid { background-color: #d1fae5; color: #065f46; }
        .status-overdue { background-color: #fee2e2; color: #991b1b; }
        .status-cancelled { background-color: #fef3c7; color: #92400e; }
        
        .line-item {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1rem;
            background: #fff;
        }
        
        .summary-section {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 1.5rem;
            margin-top: 2rem;
        }
        
        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.75rem;
            padding: 0.5rem 0;
        }
        
        .summary-row.total {
            border-top: 2px solid #dee2e6;
            padding-top: 1rem;
            margin-top: 1rem;
            font-weight: bold;
            font-size: 1.125rem;
        }
        
        .attachment-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.75rem;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            margin-bottom: 0.5rem;
            background: #f8f9fa;
        }
    </style>
@endpush

@section('content')
<div class="container mt-4">
    <div class="invoice-container">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-0">Invoice Details</h2>
                <p class="text-muted mb-0">Invoice #{{ $invoice->invoice_number }}</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('invoices.edit', $invoice->id) }}" class="btn btn-primary">
                    <i class="bi bi-pencil me-1"></i>
                    Edit Invoice
                </a>
                <a href="{{ route('invoices.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i>
                    Back to Invoices
                </a>
            </div>
        </div>

        <!-- Invoice Header -->
        <div class="invoice-header">
            <div class="row">
                <div class="col-md-8">
                    <h3 class="mb-3">Invoice for {{ $invoice->client->title }} {{ $invoice->client->first_name }} {{ $invoice->client->last_name }}</h3>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="fw-bold">Billing address</h6>
                            <p class="mb-0">{{ $invoice->client->address ?? 'No address provided' }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold">Contact details</h6>
                            <p class="mb-0">{{ $invoice->client->phone ?? 'No phone provided' }}</p>
                            <p class="mb-0">{{ $invoice->client->email }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="text-end">
                        <h4 class="mb-3">{{ $invoice->invoice_subject }}</h4>
                        <div class="mb-2">
                            <strong>Invoice #{{ $invoice->invoice_number }}</strong>
                        </div>
                        <div class="mb-2">
                            <span class="status-badge status-{{ $invoice->status }}">
                                {{ ucfirst($invoice->status) }}
                            </span>
                        </div>
                        <div class="mb-2">
                            <strong>Issued:</strong> {{ $invoice->issued_date ? $invoice->issued_date->format('M j, Y') : 'Not set' }}
                        </div>
                        @if($invoice->due_date)
                            <div class="mb-2">
                                <strong>Due:</strong> {{ $invoice->due_date->format('M j, Y') }}
                            </div>
                        @endif
                        @if($invoice->salespersonUser)
                            <div class="mb-2">
                                <strong>Salesperson:</strong> {{ $invoice->salespersonUser->name }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Line Items -->
        @if($invoice->line_items && count($invoice->line_items) > 0)
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Product / Service</h5>
                    @foreach($invoice->line_items as $index => $item)
                        <div class="line-item">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="fw-bold">{{ $item['name'] ?? 'Unnamed Item' }}</h6>
                                    @if($item['description'])
                                        <p class="text-muted mb-0">{{ $item['description'] }}</p>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <div class="row text-end">
                                        <div class="col-4">
                                            <strong>Qty:</strong> {{ $item['quantity'] ?? 1 }}
                                        </div>
                                        <div class="col-4">
                                            <strong>Unit Price:</strong> ${{ number_format($item['unit_price'] ?? 0, 2) }}
                                        </div>
                                        <div class="col-4">
                                            <strong>Total:</strong> ${{ number_format($item['total'] ?? 0, 2) }}
                                        </div>
                                    </div>
                                    @if($item['service_date'])
                                        <div class="mt-2">
                                            <small class="text-muted">
                                                <i class="bi bi-calendar me-1"></i>
                                                Service Date: {{ \Carbon\Carbon::parse($item['service_date'])->format('M j, Y') }}
                                            </small>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Summary -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="summary-section">
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span>${{ number_format($invoice->subtotal, 2) }}</span>
                    </div>
                    @if($invoice->discount_amount > 0)
                        <div class="summary-row">
                            <span>Discount ({{ $invoice->discount_type === 'percentage' ? $invoice->discount_amount . '%' : 'Fixed' }})</span>
                            <span>-${{ number_format($invoice->discount_amount, 2) }}</span>
                        </div>
                    @endif
                    @if($invoice->tax_amount > 0)
                        <div class="summary-row">
                            <span>Tax @if($invoice->taxRate) ({{ $invoice->taxRate->name }}) @endif</span>
                            <span>${{ number_format($invoice->tax_amount, 2) }}</span>
                        </div>
                    @endif
                    <div class="summary-row total">
                        <span>Total</span>
                        <span>${{ number_format($invoice->total, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Client Message -->
        @if($invoice->client_message)
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Client Message</h5>
                    <p class="mb-0">{{ $invoice->client_message }}</p>
                </div>
            </div>
        @endif

        <!-- Contract/Disclaimer -->
        @if($invoice->contract_disclaimer)
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Contract / Disclaimer</h5>
                    <p class="mb-0">{{ $invoice->contract_disclaimer }}</p>
                </div>
            </div>
        @endif

        <!-- Internal Notes -->
        @if($invoice->internal_notes)
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Internal Notes</h5>
                    <p class="text-muted small mb-2">Internal notes will only be seen by your team</p>
                    <p class="mb-0">{{ $invoice->internal_notes }}</p>
                </div>
            </div>
        @endif

        <!-- Attachments -->
        @if($invoice->attachments && count($invoice->attachments) > 0)
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Attachments</h5>
                    @foreach($invoice->attachments as $attachment)
                        <div class="attachment-item">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-file-earmark me-2"></i>
                                <span>{{ $attachment['filename'] }}</span>
                                <small class="text-muted ms-2">({{ number_format($attachment['size'] / 1024, 1) }} KB)</small>
                            </div>
                            <a href="{{ Storage::url($attachment['path']) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye me-1"></i>
                                View
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Invoice Actions -->
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fw-bold mb-1">Invoice Actions</h6>
                        <p class="text-muted mb-0">Manage this invoice</p>
                    </div>
                    <div class="d-flex gap-2">
                        @if($invoice->status === 'draft')
                            <button class="btn btn-success" onclick="updateStatus('sent')">
                                <i class="bi bi-send me-1"></i>
                                Send Invoice
                            </button>
                        @endif
                        
                        @if($invoice->status === 'sent')
                            <button class="btn btn-success" onclick="updateStatus('paid')">
                                <i class="bi bi-check-circle me-1"></i>
                                Mark as Paid
                            </button>
                        @endif
                        
                        @if($invoice->status === 'paid')
                            <button class="btn btn-warning" onclick="updateStatus('sent')">
                                <i class="bi bi-arrow-counterclockwise me-1"></i>
                                Mark as Unpaid
                            </button>
                        @endif
                        
                        <button class="btn btn-danger" onclick="deleteInvoice()">
                            <i class="bi bi-trash me-1"></i>
                            Delete Invoice
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function updateStatus(status) {
        const statusText = status.charAt(0).toUpperCase() + status.slice(1);
        
        Swal.fire({
            title: 'Update Status',
            text: `Are you sure you want to mark this invoice as ${statusText}?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: `Yes, mark as ${statusText}`,
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/invoices/{{ $invoice->id }}/status`, {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ status: status })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: 'Success!',
                            text: `Invoice status updated to ${statusText}`,
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: data.message || 'Failed to update status',
                            icon: 'error'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        title: 'Error!',
                        text: 'An error occurred while updating the status',
                        icon: 'error'
                    });
                });
            }
        });
    }

    function deleteInvoice() {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('/invoices/{{ $invoice->id }}', {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: 'Deleted!',
                            text: 'Invoice has been deleted successfully.',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href = '{{ route("invoices.index") }}';
                        });
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: data.message || 'Failed to delete invoice',
                            icon: 'error'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        title: 'Error!',
                        text: 'An error occurred while deleting the invoice',
                        icon: 'error'
                    });
                });
            }
        });
    }
</script>
@endpush
