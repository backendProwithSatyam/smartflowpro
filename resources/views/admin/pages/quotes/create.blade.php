@extends('admin.include.master')
@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css"
    rel="stylesheet">
<style>
    body {
        color: #233d48;
    }

    .quote-form {
        max-width: 1200px;
        margin: 0 auto;
    }

    .client-selector {
        background: #f8f9fa;
        border: 2px dashed #dee2e6;
        border-radius: 8px;
        padding: 20px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .client-selector:hover {
        border-color: #28a745;
        background: #f0fdf4;
    }

    .client-selected {
        background: #e8f5e8;
        border: 2px solid #28a745;
    }

    .client-info {
        display: none;
    }

    .client-info.show {
        display: block;
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

    .btn-custom-secondary {
        background-color: #fff;
        color: #388523;
        border: #388523 solid 1px;
    }

    .btn-custom-secondary:hover {
        background-color: #388523;
        color: #fff;
    }

    .quotedetails {
        padding-bottom: 8px;
        border-bottom: 1px solid #dadfe2;
    }

    /* Custom Jobber Style */
    .quote-form h3 {
        border-bottom: 2px dotted #ccc;
        padding-bottom: 8px;
    }

    .form-control {
        border-radius: 6px;
    }

    textarea.form-control {
        resize: none;
    }

    .btn-success {
        background-color: #2f6b2f !important;
        border: none;
    }

    .btn-outline-success {
        border: 1px solid #2f6b2f;
        color: #2f6b2f;
    }

    .border-dashed {
        border: 2px dashed #ccc !important;
    }

    h3,
    h5,
    h6 {
        color: #1a1a1a;
    }

    a {
        text-decoration: none;
    }

    a.text-success {
        color: #2f6b2f !important;
        font-weight: 500;
    }

    /* ===== Top Border ===== */
    .quote-form {
        border-top: 6px solid #7d2236;
        /* maroon top border */
        /* padding-top: 20px; */
        border-right: 1px solid #0000002b;
        border-left: 1px solid #0000002b;
        border-bottom: 1px solid #0000002b;
        border-radius: 8px;
    }

    /* ===== Headings ===== */


    .quote-form h6 {
        font-size: 15px;
        font-weight: 600;
        margin-bottom: 12px;
    }

    /* ===== Inputs ===== */
    .form-control {
        border-radius: 6px;
        border: 1px solid #d8d8d8;
        padding: 10px 12px;
        font-size: 14px;
    }

    .form-control:focus {
        border-color: #2f6b2f;
        box-shadow: 0 0 0 0.2rem rgba(47, 107, 47, 0.2);
    }

    textarea.form-control {
        resize: none;
    }

    /* ===== Buttons ===== */
    .btn {
        font-size: 14px;
        font-weight: 500;
        border-radius: 6px;
    }

    .btn-success {
        background-color: #2f6b2f !important;
        border-color: #2f6b2f !important;
        color: #fff;
    }

    .btn-success:hover {
        background-color: #255525 !important;
    }

    .btn-outline-success {
        border: 1px solid #2f6b2f;
        color: #2f6b2f;
        background: #fff;
    }

    .btn-outline-success:hover {
        background-color: #f6faf6;
    }

    /* Light grey pill tabs (like "Add Section") */
    .btn-outline-dark,
    .pill-btn {
        border: 1px solid #d8d8d8;
        background: #f8f8f8;
        border-radius: 25px;
        padding: 4px 12px;
        font-size: 13px;
        font-weight: 500;
        color: #555;
    }

    /* ===== Summary Section ===== */
    .summary-section div {
        font-size: 14px;
    }

    .summary-section a {
        font-size: 13px;
        font-weight: 500;
    }

    .summary-section .fw-bold {
        font-size: 15px;
        color: #000;
    }

    /* ===== Internal Notes ===== */
    .internal-notes-box {
        background: #fafaf8;
        border: 1px solid #ececec;
        border-radius: 8px;
        padding: 16px;
    }

    .border-dashed {
        border: 2px dashed #d8d8d8 !important;
        border-radius: 8px;
        padding: 14px;
        font-size: 14px;
        color: #555;
    }

    .border-dashed a {
        color: #2f6b2f;
        font-weight: 600;
    }

    /* ===== Checkbox style ===== */
    .form-check-input:checked {
        background-color: #2f6b2f;
        border-color: #2f6b2f;
    }

    .quote-form h3 {
        font-size: 36px;
        font-weight: 800;
        font-family: Jobber Pro, Poppins, Helvetica, Arial, sans-serif;
        line-height: 2.5rem;
        color: 032b3a;
        margin-bottom: 24px;
    }

    label {
        margin-bottom: 8px;
        font-size: 14px;
        line-height: 1.25rem;
        font-weight: 700;
        font-family: Inter, Helvetica, Arial, sans-serif;
        color: #032b3a;
    }

    .change-btn {
        text-decoration: underline;
        color: #155724;
        font-weight: 800;
        font-size: 14px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    label {
        font-size: 14px;
        display: block;
        margin-bottom: 5px;
    }

    input[type="text"],
    select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 14px;
    }

    .checkbox {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }

    .checkbox input {
        margin-right: 8px;
    }

    .example {
        font-size: 13px;
        color: #555;
        margin: 5px 0;
    }

    /* {
  font-size: 22px;
  font-weight: 700;
  border-bottom: 2px dotted #c7c7c7;
  padding-bottom: 8px;
  margin-bottom: 16px;
} */
    #addSectionBtn {
        color: #000000 !important;
        background-color: #f1f0e9 !important;
        border-color: #0e172642;
    }

    #addSectionBtn span {
        background-color: #fff !important;
        color: #000000;
    }

    .radio_btn {
        height: 20px;
        width: 20px;
        color: #155724 !important;
    }

    input:checked {
        color: #155724 !important;
    }

    .deposit-options {
        display: none;
        margin-top: 10px;
    }

    .btn-group button {
        margin-right: 10px;
        padding: 5px 10px;
        cursor: pointer;
        border: 1px solid #ccc;
        background-color: #f9f9f9;
        border-radius: 4px;
    }

    .btn-group button.active {
        background-color: #007bff;
        color: #fff;
        border-color: #007bff;
    }

    .hidden {
        display: none;
    }

    input {
        padding: 5px;
        width: 100px;
        margin-top: 5px;
    }

    #clientList {
        border: 1px solid rgba(0, 0, 0, 0.176);
        /* padding-left: 11px; */
        padding-top: 10px;
        border-radius: 5px;
    }

    .card {
        box-shadow: none;
        border: none;
    }

    #clientSelector {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    #clientInfo {
        display: flex;
        align-items: center;
    }

    #clientSelector {
        position: relative;
        bottom: 5px;
    }

    .client-item {
        border-bottom: 1px solid #d1d5db;
        display: flex
    }

    .client-item h6 {
        font-size: 15px;
        font-weight: 800;
        margin-bottom: 4px;
    }

    .client-item {
        cursor: pointer;
        transition: background 0.2s, box-shadow 0.2s;
    }

    .client-item:hover {
        background: #f8f9fa;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    /* Optional: make icon vertically centered */
    .client-row i {
        flex-shrink: 0;
    }
    .form-label {
    font-weight: 600;
    color: #1a1a1a;
    margin-bottom: 0.5rem;
}
</style>

@endpush

@section('content')
<div class="container mt-4">
    <div class="quote-form">
        <form id="quoteForm" enctype="multipart/form-data">
            @csrf
            <!-- Header Section -->
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">

                            <!-- Select Client Button (inline flex style) -->
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <h3 class="mb-3">
                                    Quote for
                                    <span id="clientName">Client Name</span>
                                </h3>
                                <button type="button" class="btn btn-success d-flex align-items-center gap-2"
                                    id="clientSelector" onclick="showClientModal()">
                                    <i class="bi bi-plus fs-5"></i>
                                </button>

                                <!-- Hidden by default: will show after selection -->
                                <div class="client-info d-none" id="clientInfo">
                                    <div class="d-flex align-items-center gap-3">
                                        <div>
                                            <h6 class="mb-0" id="selectedClientName">John Doe</h6>
                                            <p class="text-muted mb-0 small" id="selectedClientEmail">
                                                john@example.com</p>
                                        </div>
                                        <button type="button" class="change-btn" style="background:none; border:none;"
                                            onclick="changeClient()">Change</button>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" name="client_id" id="client_id">
                        </div>
                        <div class="col-md-8">
                            <div class="mt-3">
                                <label class="form-label">Title</label>
                                <input type="text" name="title" class="form-control" placeholder="Enter quote title"
                                    required>
                                <div class="error-message" id="title-error"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card" style="border-left:1px solid #000; border-radius:0;">
                                <div class="card-body">
                                    <h6 class="fw-bold mb-3">Quote details</h6>

                                    <!-- Quote number inline -->
                                    <div class="mb-3 d-flex align-items-center justify-content-between pb-2"
                                        style="border-bottom:1px solid #cccccc;">
                                        <label class="form-label mb-0 me-2">Quote number</label>
                                        <div class="d-flex align-items-center gap-2">
                                            <span>#{{ $quoteNumber }}</span>
                                            <button type="button" class="change-btn"
                                                style="background:none; border:none;">Change</button>
                                        </div>
                                        <input type="hidden" name="quote_number" value="{{ $quoteNumber }}">
                                    </div>

                                    <!-- Rate opportunity inline -->
                                    <div class="mb-3 d-flex align-items-center justify-content-between pb-2"
                                        style="border-bottom:1px solid #cccccc;">
                                        <label class="form-label mb-0 me-2">Rate opportunity</label>
                                        <div class="d-flex align-items-center gap-1" id="rateStars"
                                            style="color:#FFD700">
                                            <i class="bi bi-star-fill" data-rating="1"></i>
                                            <i class="bi bi-star-fill" data-rating="2"></i>
                                            <i class="bi bi-star-fill" data-rating="3"></i>
                                            <i class="bi bi-star" data-rating="4"></i>
                                            <i class="bi bi-star" data-rating="5"></i>
                                        </div>
                                        <input type="hidden" name="rate_opportunity" value="3">
                                    </div>

                                    <!-- Salesperson inline -->
                                    <div class="mb-3 d-flex align-items-center justify-content-between pb-2"
                                        style="border-bottom:1px solid #cccccc;">
                                        <label class="form-label mb-0 me-2">Salesperson</label>
                                        <select name="salesperson" class="form-control w-auto">
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
            <div class="row">
                <div class="col-lg-6"></div>
                <div class="col-lg-6"></div>
            </div>
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
                        <button type="button" class="btn btn-outline-custom btn-sm" onclick="addLineItem('optional')">
                            <i class="bi bi-plus"></i> Add Optional Line Item
                        </button>
                        <button type="button" class="btn btn-outline-custom btn-sm" onclick="addLineItem('text')">
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
                            <span id="subtotal">$0.00</span>
                        </div>
                        <div class="summary-row">
                            <span>Discount <a href="#" onclick="addDiscount()">Add Discount</a></span>
                            <span id="discount">$0.00</span>
                        </div>
                        <div class="summary-row">
                            <span>Tax <a href="#" onclick="addTax()">Add Tax</a></span>
                            <span id="tax">$0.00</span>
                        </div>
                        <div class="summary-row">
                            <span>Required deposit <a href="#" onclick="addDeposit()">Add Required Deposit</a></span>
                            <span id="deposit">$0.00</span>
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
                        placeholder="Enter contract terms and disclaimer...">This quote is valid for the next 30 days, after which values may be subject to change.</textarea>
                </div>
            </div>

            <!-- Internal Notes -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-3" style="font-size: 2rem;">Internal notes</h5>
                    <p class="text-muted small">Internal notes will only be seen by your team</p>
                    <div class="mb-3">
                        <label class="form-label">Note details</label>
                        <textarea name="internal_notes" class="form-control" rows="4"
                            placeholder="Enter internal notes..."></textarea>
                    </div>
                    <div class="file-upload-area" onclick="document.getElementById('fileInput').click()">
                        <i class="bi bi-paperclip me-2"></i>
                        Drag your files here or <a href="#" onclick="event.preventDefault()">Select a File</a>
                        <input type="file" id="fileInput" name="attachments[]" multiple accept="image/*,.pdf,.doc,.docx"
                            style="display: none;">
                    </div>
                    <div id="selectedFiles" class="mt-3"></div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Fixed Bottom Bar -->
<div class="bottom-bar fixed-bottom-bar">
    <div class="container d-flex justify-content-end gap-2">
        <button type="button" class="btn btn-outline-custom btn-custom-secondary"
            onclick="window.location.href='{{ route('quotes.index') }}'">Cancel</button>
        <button type="button" class="btn btn-success" id="saveQuoteBtn">
            <span class="btn-text">Save Quote</span>
            <span class="spinner-border spinner-border-sm d-none" id="loadingSpinner"></span>
        </button>
    </div>
</div>
</div>

<!-- Client Selection Modal -->
<div class="modal fade" id="clientModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select Client</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <p class="fw-semibold">Which client would you like to create this for?</p>
                </div>
                {{-- <div class="mb-3">
                    <input type="text" class="form-control" id="clientSearch" placeholder="Search clients...">
                </div> --}}
                <div class="row align-items-center mb-3">
                    <div class="col-md-6 mb-2 mb-md-0">
                        <input type="text" id="clientSearch" class="form-control" placeholder="Search clients...">
                    </div>
                    <div class="col-md-2 text-center">
                        <p>OR</p>
                    </div>
                    <div class="col-md-4 text-md-end text-center">
                        <a href="{{ route('clients.create') }}" class="btn btn-success w-100 w-md-auto">
                            <i class="fa-solid fa-plus me-1"></i> Create New Client
                        </a>
                    </div>
                </div>
                <div class="col-lg-12">
                    <h5 style="    color: #007bff;
    font-weight: 800;
    font-size: 15px;
">Leads</h5>
                </div>
                <div id="clientList">
                    @foreach($clients as $client)
                    <div class="d-flex align-items-center mb-2 client-row"
                        style="border-bottom: 1px solid #ccc;padding-left:10px;">

                        <div class="client-item p-2 flex-grow-1"
                            data-name="{{ strtolower($client->title . ' ' . $client->first_name . ' ' . $client->last_name) }}"
                            data-email="{{ strtolower($client->email) }}"
                            onclick="selectClient({{ $client->id }}, '{{ $client->title }} {{ $client->first_name }} {{ $client->last_name }}', '{{ $client->email }}')">
                            <i class="fa-regular fa-user fs-4 me-2" style="color:#000"></i>
                            <div>
                                <h6 class="mb-1">{{ $client->title }} {{ $client->first_name }} {{ $client->last_name }}
                                </h6>
                                <small class="text-muted">{{ $client->email }}</small>
                            </div>

                        </div>
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
    let lineItemCount = 0;
    let selectedFiles = [];
    // Initialize with one line item
    document.addEventListener('DOMContentLoaded', function() {
        addLineItem('product');
    });
    // Client selection
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

    function changeClient() {
        document.getElementById('clientSelector').style.display = 'block';
        document.getElementById('clientInfo').classList.remove('show');
        document.getElementById('client_id').value = '';
    }
    // Rate stars
    document.querySelectorAll('#rateStars i').forEach(star => {
        star.addEventListener('click', function() {
            const rating = parseInt(this.dataset.rating);
            // Set hidden input value
            document.querySelector('input[name="rate_opportunity"]').value = rating;
            // Update stars
            document.querySelectorAll('#rateStars i').forEach((s, index) => {
                if (index < rating) {
                    s.className = 'bi bi-star-fill star'; // filled star
                    s.style.color = '#FFD700'; // yellow
                } else {
                    s.className = 'bi bi-star star'; // empty star
                    s.style.color = '#ccc'; // gray
                }
            });
        });
    });
    // Line items
    function addLineItem(type) {
        lineItemCount++;
        const lineItemsContainer = document.getElementById('lineItems');
        let typeClass = '';
        let typeText = '';
        let required = true;
        switch (type) {
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
        <!-- Left side: Name & Description -->
        <div class="col-lg-6">
            <div class="mb-2">
                <label class="form-label">Name</label>
                <input type="text" name="line_items[${lineItemCount}][name]" class="form-control" required>
            </div>
            <div class="mb-2">
                <label class="form-label">Description</label>
                <textarea name="line_items[${lineItemCount}][description]" class="form-control" rows="2"></textarea>
            </div>
        </div>

        <!-- Right side: Qty, Unit Price, Total, Image -->
        <div class="col-lg-6">
            <div class="row">
                <div class="col-md-4 mb-2">
                    <label class="form-label">Qty.</label>
                    <input type="number" name="line_items[${lineItemCount}][quantity]" class="form-control quantity" value="1" min="0" step="0.01" onchange="calculateLineTotal(this)" required>
                </div>
                <div class="col-md-4 mb-2">
                    <label class="form-label">Unit Price</label>
                    <input type="number" name="line_items[${lineItemCount}][unit_price]" class="form-control unit-price" value="0" min="0" step="0.01" onchange="calculateLineTotal(this)" ${type === 'text' ? 'style="display:none"' : ''} required>
                </div>
                <div class="col-md-4 mb-2">
                    <label class="form-label">Total</label>
                    <input type="number" name="line_items[${lineItemCount}][total]" class="form-control total" value="0" min="0" step="0.01" readonly ${type === 'text' ? 'style="display:none"' : ''}>
                </div>
                <div class="col-md-4 mb-2">
                    <label class="form-label">Image</label>
                    <div class="rounded p-2 text-center line-item-image-area" style="    height: 61px;
    display: flex
;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    border: 1px solid #2f6b2f;" onclick="triggerLineItemImageInput(this)">
                    <i class="fa-solid fa-camera" style="    font-size: 20px;
    color: #2f6b2f;"></i>
                        <span class="line-item-image-name ms-2" style="font-size: 0.9em;"></span>
                        <input type="file" name="line_items[${lineItemCount}][image]" accept="image/*" style="display:none;" onchange="handleLineItemImageChange(this)">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" name="line_items[${lineItemCount}][type]" value="${type}">
    <input type="hidden" name="line_items[${lineItemCount}][required]" value="${required === true ? 1 : 0}">
</div>
`;

        lineItemsContainer.insertAdjacentHTML('beforeend', lineItemHtml);
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
                fileItem.className =
                    'd-flex justify-content-between align-items-center p-2 border rounded mb-2';
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
        btnText.textContent = 'Saving...';
        loadingSpinner.classList.remove('d-none');
        // Add selected files to form data
        selectedFiles.forEach((file, index) => {
            formData.append('attachments[]', file);
        });
        fetch('{{ route("quotes.store") }}', {
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
                showAlert('danger', 'An error occurred while saving the quote.');
            })
            .finally(() => {
                saveBtn.disabled = false;
                btnText.textContent = 'Save Quote';
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
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('clientSearch');
        const clientList = document.getElementById('clientList');
        const notFound = document.getElementById('clientNotFound');
        searchInput.addEventListener('input', function() {
            const query = this.value.trim().toLowerCase();
            let found = false;
            clientList.querySelectorAll('.client-item').forEach(function(item) {
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
</script>
@endpush