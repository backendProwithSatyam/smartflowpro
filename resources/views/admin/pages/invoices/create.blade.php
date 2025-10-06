@extends('admin.include.master')
@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
           .card{
       box-shadow: none;
       border:none;
        }
      .invoice-form h3{
                margin-bottom: 24px;
    font-size: 36px;
    font-family: Jobber Pro,Poppins,Helvetica,Arial,sans-serif;
    font-weight: 800;
    line-height: 2.5rem;
    color: #032b3a;
        }
        .invoice-form h5{
     font-weight: 700;
     font-size: 20px;
     color:#032b3a;
     }
     .card-headerTitle{
    font-family: Inter,Helvetica,Arial,sans-serif;
    font-weight: 700;
    font-size:26px !important;
    line-height: 1.75rem;
    -webkit-font-smoothing: antialiased;
    color: #032b3a;
    text-overflow: ellipsis;
    white-space: nowrap;
     }
        .invoice-form {
                 border-top: 5px solid #225c8c !important;
            max-width: 1200px;
            margin: 0 auto;
            border:1px solid #cccc;
        }

        .client-details {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1rem;
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

        .editable-field {
            cursor: pointer;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            transition: all 0.3s ease;
        }

        .editable-field:hover {
            background-color: #f8f9fa;
        }

        .editable-field.editing {
            background-color: white;
            border: 1px solid #007bff;
        }

        .service-options {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            max-height: 200px;
            overflow-y: auto;
        }

        .service-option {
            padding: 0.5rem 1rem;
            cursor: pointer;
            border-bottom: 1px solid #f8f9fa;
        }

        .service-option:hover {
            background-color: #f8f9fa;
        }

        .service-option:last-child {
            border-bottom: none;
        }

        .modal-backdrop {
            background-color: rgba(0, 0, 0, 0.5);
        }
    </style>
@endpush

@section('content')
<div class="container mt-4">
    <div class="invoice-form card">
        <form id="invoiceForm" enctype="multipart/form-data">
            @csrf

            <!-- Header Section -->
            <div class="mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h3 class="mb-3">Invoice for {{ $client->title }} {{ $client->first_name }} {{ $client->last_name }}</h3>
                            <div class="client-details">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="fw-bold">Billing address</h6>
                                        <p class="mb-0">{{ $client->address ?? 'No address provided' }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="fw-bold">Contact details</h6>
                                        <p class="mb-0">{{ $client->phone ?? 'No phone provided' }}</p>
                                        <p class="mb-0">{{ $client->email }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3">
                                <label class="form-label">Invoice subject</label>
                                <input type="text" name="invoice_subject" class="form-control" placeholder="For Services Rendered" required>
                                <div class="error-message" id="invoice_subject-error"></div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="fw-bold mb-3">Invoice details</h6>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Invoice number</label>
                                        <div class="d-flex align-items-center">
                                            <span class="me-2">#{{ $invoiceNumber }}</span>
                                        </div>
                                        <input type="hidden" name="invoice_number" value="{{ $invoiceNumber }}">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Issued date</label>
                                        <div class="editable-field" onclick="editField(this, 'issued_date')">
                                            <span id="issued_date_display">Date Sent</span>
                                            <input type="date" name="issued_date" class="form-control d-none" value="{{ request('date') ?? date('Y-m-d') }}">
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Payment due</label>
                                        <div class="editable-field" onclick="editPaymentDue(this)">
                                            <span id="payment_due_display">Net 30</span>
                                            <select name="payment_due" class="form-control d-none" onchange="updatePaymentDue()">
                                                <option value="upon_receipt">Upon Receipt</option>
                                                <option value="net_15">Net 15</option>
                                                <option value="net_30" selected>Net 30</option>
                                                <option value="net_45">Net 45</option>
                                                <option value="custom">Custom</option>
                                            </select>
                                        </div>
                                        <div id="custom_due_date" class="mt-2 d-none">
                                            <input type="date" name="due_date" class="form-control" placeholder="Select due date">
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Salesperson</label>
                                        <select name="salesperson" class="form-control">
                                            <option value="">Select salesperson...</option>
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
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
                        <!-- Line items will be added here dynamically -->
                    </div>

                    <div class="d-flex gap-2 mt-3">
                        <button type="button" class="btn btn-success" onclick="addLineItem('product')">
                            <i class="bi bi-plus"></i> Add Line Item
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
                            <span id="subtotal">$0.00</span>
                        </div>
                        <div class="summary-row">
                            <span>Discount <a href="#" onclick="editDiscount()">Add Discount</a></span>
                            <span id="discount">$0.00</span>
                        </div>
                        <div class="summary-row">
                            <span>Tax <a href="#" onclick="editTax()">Add Tax</a></span>
                            <span id="tax">$0.00</span>
                        </div>
                        <div class="summary-row total">
                            <span>Total</span>
                            <span id="total">$0.00</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Client Message -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Client message</h5>
                    <textarea name="client_message" class="form-control" rows="4" 
                              placeholder="Enter message for client..."></textarea>
                </div>
            </div>

            <!-- Contract/Disclaimer -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Contract / Disclaimer</h5>
                    <textarea name="contract_disclaimer" class="form-control" rows="3" 
                              placeholder="Enter contract terms and disclaimer...">Thank you for your business. Please contact us with any questions regarding this invoice.</textarea>
                </div>
            </div>

            <!-- Internal Notes -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-3 card-headerTitle">Internal notes</h5>
                    <p class="text-muted small">Internal notes will only be seen by your team</p>
                    <div class="mb-3">
                        <label class="form-label">Note details</label>
                        <textarea name="internal_notes" class="form-control" rows="4" 
                                  placeholder="Enter internal notes..."></textarea>
                    </div>
                    <div class="file-upload-area" onclick="document.getElementById('fileInput').click()">
                        <i class="bi bi-paperclip me-2"></i>
                        Drag your files here or <a href="#" onclick="event.preventDefault()">Select a File</a>
                        <input type="file" id="fileInput" name="attachments[]" multiple 
                               accept="image/*,.pdf,.doc,.docx" style="display: none;">
                    </div>
                    <div id="selectedFiles" class="mt-3"></div>
                </div>
            </div>

            <input type="hidden" name="client_id" value="{{ $client->id }}">
        </form>
    </div>

    <!-- Fixed Bottom Bar -->
    <div class="bottom-bar fixed-bottom-bar">
        <div class="container d-flex justify-content-end gap-2">
            <button type="button" class="btn btn-secondary" 
                    onclick="window.location.href='{{ route('invoices.index') }}'">Cancel</button>
            <button type="button" class="btn btn-success" id="saveInvoiceBtn">
                <span class="btn-text">Save Invoice</span>
                <span class="spinner-border spinner-border-sm d-none" id="loadingSpinner"></span>
            </button>
        </div>
    </div>
</div>

<!-- Tax Rate Modal -->
<div class="modal fade" id="taxRateModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create New Tax Rate</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="taxRateForm">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Tax Rate Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Rate (%)</label>
                        <input type="number" name="rate" class="form-control" step="0.01" min="0" max="100" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="saveTaxRate()">Save Tax Rate</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let lineItemCount = 0;
    let selectedFiles = [];
    let serviceOptions = [
        'Pore Nourishment',
        'Initial Clean',
        'Weekly Cleaning',
        'Bi-Weekly Cleaning',
        'Monthly Cleaning',
        'Deep Cleaning',
        'Window Cleaning',
        'Carpet Cleaning'
    ];

    // Initialize with one line item
    document.addEventListener('DOMContentLoaded', function() {
        addLineItem('product');
    });

    // Editable field functions
    function editField(element, fieldName) {
        const span = element.querySelector('span');
        const input = element.querySelector('input');
        
        span.classList.add('d-none');
        input.classList.remove('d-none');
        input.focus();
        
        element.classList.add('editing');
        
        input.addEventListener('blur', function() {
            span.textContent = input.value || 'Date Sent';
            span.classList.remove('d-none');
            input.classList.add('d-none');
            element.classList.remove('editing');
        });
    }

    function editPaymentDue(element) {
        const span = element.querySelector('span');
        const select = element.querySelector('select');
        
        span.classList.add('d-none');
        select.classList.remove('d-none');
        select.focus();
        
        element.classList.add('editing');
        
        select.addEventListener('blur', function() {
            updatePaymentDueDisplay();
            span.classList.remove('d-none');
            select.classList.add('d-none');
            element.classList.remove('editing');
        });
    }

    function updatePaymentDue() {
        const select = document.querySelector('select[name="payment_due"]');
        const customDiv = document.getElementById('custom_due_date');
        
        if (select.value === 'custom') {
            customDiv.classList.remove('d-none');
        } else {
            customDiv.classList.add('d-none');
        }
        
        updatePaymentDueDisplay();
    }

    function updatePaymentDueDisplay() {
        const select = document.querySelector('select[name="payment_due"]');
        const display = document.getElementById('payment_due_display');
        
        const options = {
            'upon_receipt': 'Upon Receipt',
            'net_15': 'Net 15',
            'net_30': 'Net 30',
            'net_45': 'Net 45',
            'custom': 'Custom'
        };
        
        display.textContent = options[select.value] || 'Net 30';
    }

    // Line items
    function addLineItem(type) {
        lineItemCount++;
        const lineItemsContainer = document.getElementById('lineItems');
        
        const lineItemHtml = `
            <div class="line-item" data-type="${type}">
                <div class="line-item-type required">Required</div>
                <button type="button" class="remove-line-item" onclick="removeLineItem(this)">
                    <i class="bi bi-x"></i>
                </button>
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label">Name</label>
                        <div class="position-relative">
                            <input type="text" name="line_items[${lineItemCount}][name]" class="form-control" 
                                   placeholder="Select or enter service name" required
                                   onfocus="showServiceOptions(this)" onblur="hideServiceOptions(this)">
                            <div class="service-options" id="serviceOptions_${lineItemCount}" style="display: none;">
                                ${serviceOptions.map(option => `<div class="service-option" onclick="selectService('${option}', this)">${option}</div>`).join('')}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Description</label>
                        <textarea name="line_items[${lineItemCount}][description]" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-2">
                        <label class="form-label">Qty.</label>
                        <input type="number" name="line_items[${lineItemCount}][quantity]" class="form-control quantity" 
                               value="1" min="0" step="0.01" onchange="calculateLineTotal(this)" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Unit Price</label>
                        <input type="number" name="line_items[${lineItemCount}][unit_price]" class="form-control unit-price" 
                               value="0" min="0" step="0.01" onchange="calculateLineTotal(this)" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Total</label>
                        <input type="number" name="line_items[${lineItemCount}][total]" class="form-control total" 
                               value="0" min="0" step="0.01" readonly>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Service Date</label>
                        <div class="editable-field" onclick="editServiceDate(this, ${lineItemCount})">
                            <span id="service_date_${lineItemCount}_display">Set Service Date</span>
                            <input type="date" name="line_items[${lineItemCount}][service_date]" class="form-control d-none">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Image</label>
                        <div class="border rounded p-2 text-center line-item-image-area" 
                             style="height: 38px; display: flex; align-items: center; justify-content: center; cursor:pointer;" 
                             onclick="triggerLineItemImageInput(this)">
                            <i class="bi bi-image text-muted"></i>
                            <span class="line-item-image-name ms-2" style="font-size: 0.9em;"></span>
                            <input type="file" name="line_items[${lineItemCount}][image]" accept="image/*" 
                                   style="display:none;" onchange="handleLineItemImageChange(this)">
                        </div>
                    </div>
                </div>
                <input type="hidden" name="line_items[${lineItemCount}][type]" value="${type}">
            </div>
        `;
        
        lineItemsContainer.insertAdjacentHTML('beforeend', lineItemHtml);
    }

    function showServiceOptions(input) {
        const options = input.parentElement.querySelector('.service-options');
        options.style.display = 'block';
    }

    function hideServiceOptions(input) {
        setTimeout(() => {
            const options = input.parentElement.querySelector('.service-options');
            options.style.display = 'none';
        }, 200);
    }

    function selectService(serviceName, optionElement) {
        const input = optionElement.closest('.position-relative').querySelector('input');
        input.value = serviceName;
        const options = optionElement.closest('.service-options');
        options.style.display = 'none';
    }

    function editServiceDate(element, lineItemCount) {
        const span = element.querySelector('span');
        const input = element.querySelector('input');
        
        span.classList.add('d-none');
        input.classList.remove('d-none');
        input.focus();
        
        element.classList.add('editing');
        
        input.addEventListener('blur', function() {
            span.textContent = input.value ? new Date(input.value).toLocaleDateString() : 'Set Service Date';
            span.classList.remove('d-none');
            input.classList.add('d-none');
            element.classList.remove('editing');
        });
    }

    function triggerLineItemImageInput(element) {
        const fileInput = element.querySelector('input[type="file"]');
        if (fileInput) {
            fileInput.click();
        }
    }

    function handleLineItemImageChange(input) {
        const file = input.files[0];
        const imageNameSpan = input.closest('.line-item-image-area').querySelector('.line-item-image-name');
        if (file && imageNameSpan) {
            imageNameSpan.textContent = file.name;
        } else if (imageNameSpan) {
            imageNameSpan.textContent = '';
        }
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

    // Discount editing
    function editDiscount() {
        const currentDiscount = document.getElementById('discount').textContent;
        const newDiscount = prompt('Enter discount amount:', currentDiscount.replace('$', ''));
        
        if (newDiscount !== null) {
            const amount = parseFloat(newDiscount) || 0;
            document.getElementById('discount').textContent = '$' + amount.toFixed(2);
            
            // Add hidden inputs for discount
            let discountInput = document.querySelector('input[name="discount_amount"]');
            if (!discountInput) {
                discountInput = document.createElement('input');
                discountInput.type = 'hidden';
                discountInput.name = 'discount_amount';
                document.getElementById('invoiceForm').appendChild(discountInput);
            }
            discountInput.value = amount;
            
            calculateTotals();
        }
    }

    // Tax editing
    function editTax() {
        const taxModal = new bootstrap.Modal(document.getElementById('taxRateModal'));
        taxModal.show();
    }

    function saveTaxRate() {
        const form = document.getElementById('taxRateForm');
        const formData = new FormData(form);
        
        fetch('{{ route("tax-rates.store") }}', {
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
                // Add tax rate to select options
                const taxSelect = document.querySelector('select[name="tax_rate_id"]');
                if (taxSelect) {
                    const option = document.createElement('option');
                    option.value = data.tax_rate.id;
                    option.textContent = data.tax_rate.name + ' (' + data.tax_rate.rate + '%)';
                    taxSelect.appendChild(option);
                }
                
                bootstrap.Modal.getInstance(document.getElementById('taxRateModal')).hide();
                form.reset();
            } else {
                alert('Error creating tax rate: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while creating the tax rate.');
        });
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
        container.innerHTML = '';
        
        if (selectedFiles.length > 0) {
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
    }

    function removeFile(index) {
        selectedFiles.splice(index, 1);
        displaySelectedFiles();
    }

    // Form submission
    document.getElementById('saveInvoiceBtn').addEventListener('click', function() {
        submitForm();
    });

    function submitForm() {
        const form = document.getElementById('invoiceForm');
        const formData = new FormData(form);
        const saveBtn = document.getElementById('saveInvoiceBtn');
        const btnText = document.querySelector('.btn-text');
        const loadingSpinner = document.getElementById('loadingSpinner');
        
        // Clear previous errors
        clearErrors();
        
        // Show loading state
        saveBtn.disabled = true;
        btnText.textContent = 'Saving...';
        loadingSpinner.classList.remove('d-none');
        
        // Add selected files to form data
        selectedFiles.forEach((file, index) => {
            formData.append('attachments[]', file);
        });
        
        fetch('{{ route("invoices.store") }}', {
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
                    window.location.href = '{{ route("invoices.index") }}';
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
            showAlert('danger', 'An error occurred while saving the invoice.');
        })
        .finally(() => {
            saveBtn.disabled = false;
            btnText.textContent = 'Save Invoice';
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
</script>
@endpush