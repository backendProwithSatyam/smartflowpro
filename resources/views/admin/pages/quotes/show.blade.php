@extends('admin.include.master')
@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        .quote-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem;
            border-radius: 10px;
            margin-bottom: 2rem;
        }
        
        .quote-details {
            background: white;
            border-radius: 10px;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .client-info {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .line-item {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1rem;
            background: #fff;
        }
        
        .line-item-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
        }
        
        .line-item-type {
            font-size: 12px;
            padding: 4px 8px;
            border-radius: 12px;
            background: #e9ecef;
            color: #495057;
        }
        
        .line-item-type.required {
            background: #d4edda;
            color: #155724;
        }
        
        .line-item-type.optional {
            background: #fff3cd;
            color: #856404;
        }
        
        .line-item-type.text {
            background: #d1ecf1;
            color: #0c5460;
        }
        
        .summary-section {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 1.5rem;
            margin: 2rem 0;
        }
        
        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
            padding: 0.5rem 0;
        }
        
        .summary-row.total {
            border-top: 2px solid #dee2e6;
            padding-top: 1rem;
            margin-top: 1rem;
            font-weight: bold;
            font-size: 1.2rem;
        }
        
        .stars {
            color: #fbbf24;
            font-size: 1.2rem;
        }
        
        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 500;
            font-size: 0.9rem;
        }
        
        .status-draft { background-color: #f3f4f6; color: #374151; }
        .status-sent { background-color: #dbeafe; color: #1e40af; }
        .status-accepted { background-color: #d1fae5; color: #065f46; }
        .status-rejected { background-color: #fee2e2; color: #991b1b; }
        .status-expired { background-color: #fef3c7; color: #92400e; }
        
        .attachment-item {
            display: flex;
            align-items: center;
            padding: 0.5rem;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            margin-bottom: 0.5rem;
        }
    </style>
@endpush

@section('content')
<div class="container mt-4">
    <!-- Quote Header -->
    <div class="quote-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="mb-2">{{ $quote->title }}</h1>
                <p class="mb-0 fs-5">Quote #{{ $quote->quote_number }}</p>
            </div>
            <div class="col-md-4 text-end">
                <span class="status-badge status-{{ $quote->status }}">
                    {{ ucfirst($quote->status) }}
                </span>
            </div>
        </div>
    </div>

    <!-- Quote Details -->
    <div class="quote-details">
        <!-- Client Information -->
        <div class="client-info">
            <h5 class="fw-bold mb-3">Client Information</h5>
            <div class="row">
                <div class="col-md-6">
                    <h6>{{ $quote->client->title }} {{ $quote->client->first_name }} {{ $quote->client->last_name }}</h6>
                    <p class="text-muted mb-1">{{ $quote->client->email }}</p>
                    @if($quote->client->phone_number)
                        <p class="text-muted mb-0">{{ $quote->client->phone_number }}</p>
                    @endif
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-6">
                            <small class="text-muted">Rate Opportunity</small>
                            <div class="stars">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="bi bi-star{{ $i <= $quote->rate_opportunity ? '-fill' : '' }}"></i>
                                @endfor
                            </div>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">Salesperson</small>
                            <div>
                                @if($quote->salespersonUser)
                                    {{ $quote->salespersonUser->name }}
                                @else
                                    <span class="text-muted">Unassigned</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Line Items -->
        @if($quote->line_items && count($quote->line_items) > 0)
            <h5 class="fw-bold mb-3">Products / Services</h5>
            @foreach($quote->line_items as $item)
                <div class="line-item">
                    <div class="line-item-header">
                        <h6 class="mb-0">{{ $item['name'] ?? 'Unnamed Item' }}</h6>
                        <span class="line-item-type {{ $item['type'] === 'optional' ? 'optional' : ($item['type'] === 'text' ? 'text' : 'required') }}">
                            {{ $item['type'] === 'optional' ? 'Optional' : ($item['type'] === 'text' ? 'Text' : 'Required') }}
                        </span>
                    </div>
                    
                    @if($item['description'])
                        <p class="text-muted mb-2">{{ $item['description'] }}</p>
                    @endif
                    
                    <div class="row">
                        <div class="col-md-3">
                            <small class="text-muted">Quantity</small>
                            <div>{{ $item['quantity'] ?? 1 }}</div>
                        </div>
                        @if(($item['type'] ?? 'product') !== 'text')
                            <div class="col-md-3">
                                <small class="text-muted">Unit Price</small>
                                <div>₹{{ number_format($item['unit_price'] ?? 0, 2) }}</div>
                            </div>
                            <div class="col-md-3">
                                <small class="text-muted">Total</small>
                                <div class="fw-bold">₹{{ number_format($item['total'] ?? 0, 2) }}</div>
                            </div>
                        @endif
                        <div class="col-md-3">
                            <small class="text-muted">Image</small>
                            <div class="text-muted">
                                <i class="bi bi-image"></i> No image
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif

        <!-- Summary -->
        <div class="summary-section">
            <h5 class="fw-bold mb-3">Quote Summary</h5>
            <div class="summary-row">
                <span>Subtotal</span>
                <span>₹{{ number_format($quote->subtotal, 2) }}</span>
            </div>
            @if($quote->discount_amount > 0)
                <div class="summary-row">
                    <span>Discount ({{ $quote->discount_type === 'percentage' ? $quote->discount_amount . '%' : 'Fixed' }})</span>
                    <span>-₹{{ number_format($quote->discount_amount, 2) }}</span>
                </div>
            @endif
            @if($quote->tax_amount > 0)
                <div class="summary-row">
                    <span>Tax @if($quote->taxRate) ({{ $quote->taxRate->name }} - {{ $quote->taxRate->rate }}%) @endif</span>
                    <span>₹{{ number_format($quote->tax_amount, 2) }}</span>
                </div>
            @endif
            @if($quote->required_deposit > 0)
                <div class="summary-row">
                    <span>Required Deposit ({{ $quote->deposit_type === 'percentage' ? $quote->required_deposit . '%' : 'Fixed' }})</span>
                    <span>₹{{ number_format($quote->required_deposit, 2) }}</span>
                </div>
            @endif
            <div class="summary-row total">
                <span>Total</span>
                <span>₹{{ number_format($quote->total, 2) }}</span>
            </div>
        </div>

        <!-- Client Message -->
        @if($quote->client_message)
            <div class="mb-4">
                <h5 class="fw-bold mb-3">Client Message</h5>
                <div class="p-3 bg-light rounded">
                    {{ $quote->client_message }}
                </div>
            </div>
        @endif

        <!-- Contract/Disclaimer -->
        @if($quote->contract_disclaimer)
            <div class="mb-4">
                <h5 class="fw-bold mb-3">Contract / Disclaimer</h5>
                <div class="p-3 bg-light rounded">
                    {{ $quote->contract_disclaimer }}
                </div>
            </div>
        @endif

        <!-- Internal Notes -->
        @if($quote->internal_notes)
            <div class="mb-4">
                <h5 class="fw-bold mb-3">Internal Notes</h5>
                <div class="p-3 bg-warning bg-opacity-10 rounded">
                    {{ $quote->internal_notes }}
                </div>
            </div>
        @endif

        <!-- Attachments -->
        @if($quote->attachments && count($quote->attachments) > 0)
            <div class="mb-4">
                <h5 class="fw-bold mb-3">Attachments</h5>
                @foreach($quote->attachments as $attachment)
                    <div class="attachment-item">
                        <i class="bi bi-file-earmark me-2"></i>
                        <span>{{ $attachment['filename'] }}</span>
                        <small class="text-muted ms-2">({{ number_format($attachment['size'] / 1024, 1) }} KB)</small>
                        <a href="{{ Storage::url($attachment['path']) }}" target="_blank" class="btn btn-sm btn-outline-primary ms-auto">
                            <i class="bi bi-download"></i> Download
                        </a>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Quote Meta Information -->
        <div class="row mt-4 pt-3 border-top">
            <div class="col-md-6">
                <small class="text-muted">Created on</small>
                <div>{{ $quote->created_at->format('F j, Y \a\t g:i A') }}</div>
            </div>
            <div class="col-md-6">
                <small class="text-muted">Last updated</small>
                <div>{{ $quote->updated_at->format('F j, Y \a\t g:i A') }}</div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="d-flex justify-content-between mt-4">
        <div>
            <a href="{{ route('quotes.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i> Back to Quotes
            </a>
        </div>
        <div>
            <a href="{{ route('quotes.edit', $quote->id) }}" class="btn btn-primary">
                <i class="bi bi-pencil me-1"></i> Edit Quote
            </a>
            <button type="button" class="btn btn-success" onclick="sendQuote()">
                <i class="bi bi-send me-1"></i> Send Quote
            </button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function sendQuote() {
        // This would typically open a modal or redirect to a send quote page
        alert('Send quote functionality would be implemented here. This could include email sending, PDF generation, etc.');
    }
</script>
@endpush
