@extends('admin.include.master')
@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        .quote-form {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .client-info {
            background: #e8f5e8;
            border: 2px solid #28a745;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }
        
        .line-item {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            background: #fff;
            position: relative;
        }
        
        .line-item.dragging {
            opacity: 0.5;
        }
        
        .drag-handle {
            cursor: move;
            color: #6c757d;
            font-size: 18px;
        }
        
        .line-item-header {
            display: flex;
            justify-content: between;
            align-items: center;
            margin-bottom: 10px;
        }
        
        .line-item-type {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 12px;
            padding: 2px 8px;
            border-radius: 12px;
            background: #e9ecef;
            color: #495057;
        }
        
        .line-item-type.required {
            background: #d4edda;
            color: #155724;
            margin-right: 30px;
        }
        
        .line-item-type.optional {
            background: #fff3cd;
            color: #856404;
            margin-right: 30px;
        }
        
        .line-item-type.text {
            background: #d1ecf1;
            color: #0c5460;
            margin-right: 30px;
        }
        
        .remove-line-item {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 12px;
        }
        
        .summary-section {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin-top: 20px;
        }
        
        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            padding: 5px 0;
        }
        
        .summary-row.total {
            border-top: 2px solid #dee2e6;
            padding-top: 15px;
            margin-top: 15px;
            font-weight: bold;
            font-size: 18px;
        }
        
        .error-message {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
        
        .is-invalid {
            border-color: #dc3545;
        }
        
        .loading {
            opacity: 0.6;
            pointer-events: none;
        }
        
        .file-upload-area {
            border: 2px dashed #d1d5db;
            border-radius: 0.5rem;
            padding: 1rem;
            text-align: center;
            margin-top: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .file-upload-area:hover {
            border-color: #16a34a;
            background-color: #f0fdf4;
        }

        .fixed-bottom-bar {
            position: fixed;
            bottom: 0;
            left: 14.2rem;
            right: 0;
            background-color: white;
            border-top: 1px solid #e5e7eb;
            padding: .7rem 2rem;
            box-shadow: 0 -4px 6px -1px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }
    </style>
@endpush

@section('content')
<div class="container mt-4">
    <div class="quote-form">
        <form id="quoteForm" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <!-- Header Section -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h3 class="mb-3">Quote for <span id="clientName">{{ $quote->client->title }} {{ $quote->client->first_name }} {{ $quote->client->last_name }}</span></h3>
                            <div class="client-selector" style="display: {{ $quote->client ? 'none' : 'block'}}" id="clientSelector" onclick="showClientModal()">
                                <i class="bi bi-plus-circle fs-1 text-success"></i>
                                <p class="mt-2 mb-0">Select Client</p>
                            </div>
                            <div class="client-info {{ $quote->client ? 'show' : '' }}" id="clientInfo">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5>{{ $quote->client->title }} {{ $quote->client->first_name }} {{ $quote->client->last_name }}</h5>
                                        <p class="text-muted mb-0">{{ $quote->client->email }}</p>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="changeClient()">
                                        Change
                                    </button>
                                </div>
                            </div>
                            <input type="hidden" name="client_id" id="client_id" value="{{ $quote->client_id }}">
                            
                            <div class="mt-3">
                                <label class="form-label">Title</label>
                                <input type="text" name="title" class="form-control" value="{{ old('title', $quote->title) }}" required>
                                <div class="error-message" id="title-error"></div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="fw-bold mb-3">Quote details</h6>
                                    <div class="mb-3">
                                        <label class="form-label">Quote number</label>
                                        <div class="d-flex align-items-center">
                                            <span class="me-2">#{{ $quote->quote_number }}</span>
                                            {{-- <button type="button" class="btn btn-sm btn-link">Change</button> --}}
                                        </div>
                                        <input type="hidden" name="quote_number" value="{{ $quote->quote_number }}">
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Rate opportunity</label>
                                        <div class="stars" id="rateStars">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="bi bi-star{{ $i <= $quote->rate_opportunity ? '-fill' : '' }}" data-rating="{{ $i }}"></i>
                                            @endfor
                                        </div>
                                        <input type="hidden" name="rate_opportunity" value="{{ $quote->rate_opportunity }}">
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Salesperson</label>
                                        <div class="d-flex">
                                            <select name="salesperson" class="form-control">
                                                <option value="">Select salesperson...</option>
                                                @foreach($users as $user)
                                                    <option value="{{ $user->id }}" {{ $quote->salesperson == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Product/Service Section -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Product / Service</h5>
                    <div id="lineItems">
                        @if($quote->line_items && count($quote->line_items) > 0)
                            @foreach($quote->line_items as $index => $item)
                                <div class="line-item" data-type="{{ $item['type'] ?? 'product' }}" data-required="{{ $item['required'] ?? true }}">
                                    <div class="line-item-type {{ $item['type'] === 'optional' ? 'optional' : ($item['type'] === 'text' ? 'text' : 'required') }}">
                                        {{ $item['type'] === 'optional' ? 'Optional' : ($item['type'] === 'text' ? 'Text' : 'Required') }}
                                    </div>
                                    <button type="button" class="remove-line-item" onclick="removeLineItem(this)">
                                        <i class="bi bi-x"></i>
                                    </button>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label">Name</label>
                                            <input type="text" name="line_items[{{ $index }}][name]" class="form-control" value="{{ $item['name'] ?? '' }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Description</label>
                                            <textarea name="line_items[{{ $index }}][description]" class="form-control" rows="2">{{ $item['description'] ?? '' }}</textarea>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-3">
                                            <label class="form-label">Qty.</label>
                                            <input type="number" name="line_items[{{ $index }}][quantity]" class="form-control quantity" value="{{ $item['quantity'] ?? 1 }}" min="0" step="0.01" onchange="calculateLineTotal(this)" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Unit Price</label>
                                            <input type="number" name="line_items[{{ $index }}][unit_price]" class="form-control unit-price" value="{{ $item['unit_price'] ?? 0 }}" min="0" step="0.01" onchange="calculateLineTotal(this)" {{ ($item['type'] ?? 'product') === 'text' ? 'style="display:none"' : '' }} required>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Total</label>
                                            <input type="number" name="line_items[{{ $index }}][total]" class="form-control total" value="{{ $item['total'] ?? 0 }}" min="0" step="0.01" readonly {{ ($item['type'] ?? 'product') === 'text' ? 'style="display:none"' : '' }}>
                                        </div>
                                    </div>
                                    <input type="hidden" name="line_items[{{ $index }}][type]" value="{{ $item['type'] ?? 'product' }}">
                                    <input type="hidden" name="line_items[{{ $index }}][required]" value="{{ $item['required'] ?? true }}">
                                </div>
                            @endforeach
                        @else
                            <!-- Add default line item if none exist -->
                            <div class="line-item" data-type="product" data-required="true">
                                <div class="line-item-type required">Required</div>
                                <button type="button" class="remove-line-item" onclick="removeLineItem(this)">
                                    <i class="bi bi-x"></i>
                                </button>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label">Name</label>
                                        <input type="text" name="line_items[0][name]" class="form-control" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Description</label>
                                        <textarea name="line_items[0][description]" class="form-control" rows="2"></textarea>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-3">
                                        <label class="form-label">Qty.</label>
                                        <input type="number" name="line_items[0][quantity]" class="form-control quantity" value="1" min="0" step="0.01" onchange="calculateLineTotal(this)" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Unit Price</label>
                                        <input type="number" name="line_items[0][unit_price]" class="form-control unit-price" value="0" min="0" step="0.01" onchange="calculateLineTotal(this)" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Total</label>
                                        <input type="number" name="line_items[0][total]" class="form-control total" value="0" min="0" step="0.01" readonly>
                                    </div>
                                </div>
                                <input type="hidden" name="line_items[0][type]" value="product">
                                <input type="hidden" name="line_items[0][required]" value="1">
                            </div>
                        @endif
                    </div>
                    
                    <div class="d-flex gap-2 mt-3">
                        <button type="button" class="btn btn-success" onclick="addLineItem('product')">
                            <i class="bi bi-plus"></i> Add Line Item
                        </button>
                        <button type="button" class="btn btn-warning" onclick="addLineItem('optional')">
                            <i class="bi bi-plus"></i> Add Optional Line Item
                        </button>
                        <button type="button" class="btn btn-info" onclick="addLineItem('text')">
                            <i class="bi bi-plus"></i> Add Text
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Summary Section -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="summary-section">
                        <div class="summary-row">
                            <span>Subtotal</span>
                            <span id="subtotal">${{ number_format($quote->subtotal, 2) }}</span>
                        </div>
                        <div class="summary-row">
                            <span>Discount <a href="#" onclick="addDiscount()">Add Discount</a></span>
                            <span id="discount">${{ number_format($quote->discount_amount, 2) }}</span>
                        </div>
                        <div class="summary-row">
                            <span>Tax <a href="#" onclick="addTax()">Add Tax</a></span>
                            <span id="tax">${{ number_format($quote->tax_amount, 2) }}</span>
                        </div>
                        <div class="summary-row">
                            <span>Required deposit <a href="#" onclick="addDeposit()">Add Required Deposit</a></span>
                            <span id="deposit">${{ number_format($quote->required_deposit, 2) }}</span>
                        </div>
                        <div class="summary-row total">
                            <span>Total</span>
                            <span id="total">${{ number_format($quote->total, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Client Message -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Client message</h5>
                    <textarea name="client_message" class="form-control" rows="4" 
                              placeholder="Enter message for client...">{{ old('client_message', $quote->client_message) }}</textarea>
                </div>
            </div>
            
            <!-- Contract/Disclaimer -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Contract / Disclaimer</h5>
                    <textarea name="contract_disclaimer" class="form-control" rows="3" 
                              placeholder="Enter contract terms and disclaimer...">{{ old('contract_disclaimer', $quote->contract_disclaimer) }}</textarea>
                </div>
            </div>
            
            <!-- Internal Notes -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Internal notes</h5>
                    <p class="text-muted small">Internal notes will only be seen by your team</p>
                    <div class="mb-3">
                        <label class="form-label">Note details</label>
                        <textarea name="internal_notes" class="form-control" rows="4" 
                                  placeholder="Enter internal notes...">{{ old('internal_notes', $quote->internal_notes) }}</textarea>
                    </div>
                    <div class="file-upload-area" onclick="document.getElementById('fileInput').click()">
                        <i class="bi bi-paperclip me-2"></i>
                        Drag your files here or <a href="#" onclick="event.preventDefault()">Select a File</a>
                        <input type="file" id="fileInput" name="attachments[]" multiple 
                               accept="image/*,.pdf,.doc,.docx" style="display: none;">
                    </div>
                    <div id="selectedFiles" class="mt-3">
                        @if($quote->attachments && count($quote->attachments) > 0)
                            @foreach($quote->attachments as $attachment)
                                <div class="d-flex justify-content-between align-items-center p-2 border rounded mb-2">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-file-earmark me-2"></i>
                                        <span>{{ $attachment['filename'] }}</span>
                                        <small class="text-muted ms-2">({{ number_format($attachment['size'] / 1024, 1) }} KB)</small>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeExistingFile(this)">
                                        <i class="bi bi-x"></i>
                                    </button>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </form>
    </div>
    
    <!-- Fixed Bottom Bar -->
    <div class="bottom-bar fixed-bottom-bar">
        <div class="container d-flex justify-content-end gap-2">
            <button type="button" class="btn btn-secondary" onclick="window.location.href='{{ route('quotes.index') }}'">Cancel</button>
            <button type="button" class="btn btn-success" id="saveQuoteBtn">
                <span class="btn-text">Update Quote</span>
                <span class="spinner-border spinner-border-sm d-none" id="loadingSpinner"></span>
            </button>
        </div>
    </div>
</div>
    <div class="modal fade" id="clientModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Select Client</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <input type="text" class="form-control" id="clientSearch" placeholder="Search clients...">
                    </div>
                    <div id="clientList">
                        @foreach($clients as $client)
                            <div class="client-item p-3 border rounded mb-2"
                                data-name="{{ strtolower($client->title . ' ' . $client->first_name . ' ' . $client->last_name) }}"
                                data-email="{{ strtolower($client->email) }}"
                                onclick="selectClient({{ $client->id }}, '{{ $client->title }} {{ $client->first_name }} {{ $client->last_name }}', '{{ $client->email }}')">
                                <h6 class="mb-1">{{ $client->title }} {{ $client->first_name }} {{ $client->last_name }}</h6>
                                <small class="text-muted">{{ $client->email }}</small>
                            </div>
                        @endforeach
                    </div>
                    <div id="clientNotFound" class="text-center text-muted mt-3" style="display:none;">
                        No clients found.
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    let lineItemCount = {{ $quote->line_items ? count($quote->line_items) : 1 }};
    let selectedFiles = [];
    
    // Initialize calculations
    document.addEventListener('DOMContentLoaded', function() {
        calculateTotals();
    });
    
    // Rate stars
    document.querySelectorAll('#rateStars i').forEach(star => {
        star.addEventListener('click', function() {
            const rating = parseInt(this.dataset.rating);
            document.querySelector('input[name="rate_opportunity"]').value = rating;
            
            document.querySelectorAll('#rateStars i').forEach((s, index) => {
                if (index < rating) {
                    s.className = 'bi bi-star-fill';
                } else {
                    s.className = 'bi bi-star';
                }
            });
        });
    });
    
    // Line items (same functions as create page)
    function addLineItem(type) {
        lineItemCount++;
        const lineItemsContainer = document.getElementById('lineItems');
        
        let typeClass = '';
        let typeText = '';
        let required = true;
        
        switch(type) {
            case 'product':
                typeClass = 'required';
                typeText = 'Required';
                required = true;
                break;
            case 'optional':
                typeClass = 'optional';
                typeText = 'Optional';
                required = false;
                break;
            case 'text':
                typeClass = 'text';
                typeText = 'Text';
                required = false;
                break;
        }
        
        const lineItemHtml = `
            <div class="line-item" data-type="${type}" data-required="${required}">
                <div class="line-item-type ${typeClass}">${typeText}</div>
                <button type="button" class="remove-line-item" onclick="removeLineItem(this)">
                    <i class="bi bi-x"></i>
                </button>
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label">Name</label>
                        <input type="text" name="line_items[${lineItemCount}][name]" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Description</label>
                        <textarea name="line_items[${lineItemCount}][description]" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-3">
                        <label class="form-label">Qty.</label>
                        <input type="number" name="line_items[${lineItemCount}][quantity]" class="form-control quantity" value="1" min="0" step="0.01" onchange="calculateLineTotal(this)" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Unit Price</label>
                        <input type="number" name="line_items[${lineItemCount}][unit_price]" class="form-control unit-price" value="0" min="0" step="0.01" onchange="calculateLineTotal(this)" ${type === 'text' ? 'style="display:none"' : ''} required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Total</label>
                        <input type="number" name="line_items[${lineItemCount}][total]" class="form-control total" value="0" min="0" step="0.01" readonly ${type === 'text' ? 'style="display:none"' : ''}>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Image</label>
                        <div class="border rounded p-2 text-center" style="height: 38px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-image text-muted"></i>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="line_items[${lineItemCount}][type]" value="${type}">
                <input type="hidden" name="line_items[${lineItemCount}][required]" value="${required}">
            </div>
        `;
        
        lineItemsContainer.insertAdjacentHTML('beforeend', lineItemHtml);
    }
    
    function removeLineItem(button) {
        button.closest('.line-item').remove();
        calculateTotals();
    }
    
    function calculateLineTotal(input) {
        const lineItem = input.closest('.line-item');
        const quantity = parseFloat(lineItem.querySelector('.quantity').value) || 0;
        const unitPrice = parseFloat(lineItem.querySelector('.unit-price').value) || 0;
        const total = quantity * unitPrice;
        
        lineItem.querySelector('.total').value = total.toFixed(2);
        calculateTotals();
    }
    
    function calculateTotals() {
        let subtotal = 0;
        
        document.querySelectorAll('.line-item').forEach(item => {
            const total = parseFloat(item.querySelector('.total').value) || 0;
            subtotal += total;
        });
        
        document.getElementById('subtotal').textContent = '$' + subtotal.toFixed(2);
        document.getElementById('total').textContent = '$' + subtotal.toFixed(2);
    }
    
    // File handling
    document.getElementById('fileInput').addEventListener('change', function(e) {
        handleFiles(e.target.files);
    });
    
    function handleFiles(files) {
        selectedFiles = [...selectedFiles, ...Array.from(files)];
        displaySelectedFiles();
    }
    
    function displaySelectedFiles() {
        const container = document.getElementById('selectedFiles');
        // Keep existing files and add new ones
        const existingFiles = container.querySelectorAll('.existing-file');
        container.innerHTML = '';
        
        // Re-add existing files
        existingFiles.forEach(file => container.appendChild(file));
        
        // Add new files
        selectedFiles.forEach((file, index) => {
            const fileItem = document.createElement('div');
            fileItem.className = 'd-flex justify-content-between align-items-center p-2 border rounded mb-2';
            fileItem.innerHTML = `
                <div class="d-flex align-items-center">
                    <i class="bi bi-file-earmark me-2"></i>
                    <span>${file.name}</span>
                    <small class="text-muted ms-2">(${(file.size / 1024).toFixed(1)} KB)</small>
                </div>
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeFile(${index})">
                    <i class="bi bi-x"></i>
                </button>
            `;
            container.appendChild(fileItem);
        });
    }
    
    function removeFile(index) {
        selectedFiles.splice(index, 1);
        displaySelectedFiles();
    }
    
    function removeExistingFile(button) {
        button.closest('.d-flex').remove();
    }
    
    // Form submission
    document.getElementById('saveQuoteBtn').addEventListener('click', function() {
        submitForm();
    });
    
    function submitForm() {
        const form = document.getElementById('quoteForm');
        const formData = new FormData(form);
        const saveBtn = document.getElementById('saveQuoteBtn');
        const btnText = document.querySelector('.btn-text');
        const loadingSpinner = document.getElementById('loadingSpinner');
        
        // Clear previous errors
        clearErrors();
        
        // Show loading state
        saveBtn.disabled = true;
        btnText.textContent = 'Updating...';
        loadingSpinner.classList.remove('d-none');
        
        // Add selected files to form data
        selectedFiles.forEach((file, index) => {
            formData.append('attachments[]', file);
        });
        
        fetch('{{ route("quotes.update", $quote->id) }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('success', data.message);
                setTimeout(() => {
                    window.location.href = '{{ route("quotes.index") }}';
                }, 1500);
            } else {
                showAlert('danger', data.message);
                if (data.errors) {
                    showValidationErrors(data.errors);
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('danger', 'An error occurred while updating the quote.');
        })
        .finally(() => {
            saveBtn.disabled = false;
            btnText.textContent = 'Update Quote';
            loadingSpinner.classList.add('d-none');
        });
    }
    
    function clearErrors() {
        const errorElements = document.querySelectorAll('.error-message');
        errorElements.forEach(element => {
            element.textContent = '';
        });
        
        const invalidElements = document.querySelectorAll('.is-invalid');
        invalidElements.forEach(element => {
            element.classList.remove('is-invalid');
        });
    }
    
    function showValidationErrors(errors) {
        Object.keys(errors).forEach(field => {
            const errorElement = document.getElementById(field + '-error');
            const inputElement = document.querySelector(`[name="${field}"]`);
            
            if (errorElement) {
                errorElement.textContent = errors[field][0];
            }
            
            if (inputElement) {
                inputElement.classList.add('is-invalid');
            }
        });
    }
    
    function showAlert(type, message) {
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        const container = document.querySelector('.container');
        container.insertBefore(alertDiv, container.firstChild);
        
        setTimeout(() => {
            if (alertDiv.parentNode) {
                alertDiv.remove();
            }
        }, 5000);
    }
    function changeClient() {
        document.getElementById('clientSelector').style.display = 'block';
        document.getElementById('clientInfo').classList.remove('show');
        document.getElementById('client_id').value = '';
    }
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('clientSearch');
        const clientList = document.getElementById('clientList');
        const notFound = document.getElementById('clientNotFound');
        searchInput.addEventListener('input', function () {
            const query = this.value.trim().toLowerCase();
            let found = false;
            clientList.querySelectorAll('.client-item').forEach(function (item) {
                const name = item.getAttribute('data-name');
                const email = item.getAttribute('data-email');
                if (name.includes(query) || email.includes(query)) {
                    item.style.display = '';
                    found = true;
                } else {
                    item.style.display = 'none';
                }
            });
            notFound.style.display = found ? 'none' : '';
        });
    });
    function showClientModal() {
        const modal = new bootstrap.Modal(document.getElementById('clientModal'));
        modal.show();
    }

    function selectClient(id, name, email) {
        document.getElementById('client_id').value = id;
        document.getElementById('clientName').textContent = name;
        document.getElementById('selectedClientName').textContent = name;
        document.getElementById('selectedClientEmail').textContent = email;

        document.getElementById('clientSelector').style.display = 'none';
        document.getElementById('clientInfo').classList.add('show');

        const modal = bootstrap.Modal.getInstance(document.getElementById('clientModal'));
        modal.hide();
    }

</script>
@endpush
