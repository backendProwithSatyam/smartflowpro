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
        padding-top: 20px;
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
        font-size: 24px;
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
</style>
@endpush

@section('content')
<div class="container mt-4">
    <!-- Quote Form -->

    <div class="quote-form container my-4 shadow-sm p-3">
        <form id="quoteForm" enctype="multipart/form-data">
            @csrf

            <!-- Header -->
            <div class="row border-bottom pb-3 mb-4">
                <div class="col-md-8">
                    <h3 class="fw-bold mb-2">
                        Quote for <span class="text-dark">Client Name</span>
                        <button type="button" class="btn btn-success btn-sm ms-2" data-bs-toggle="modal"
                            data-bs-target="#clientSelectModal">
                            <i class="fa-solid fa-plus"></i>
                        </button>

                    </h3>
                    <div class="mb-3 mt-4">
                        <label class="form-label fw-semibold">Job title</label>
                        <input type="text" name="title" class="form-control" placeholder="Title" />
                    </div>
                </div>
                <div class="col-md-4 border-start ps-4 mt-5">
                    <label for="">Quote details</label>
                    <div class="d-flex justify-content-between align-items-center border-bottom pb-2 pt-2"
                        id="quoteSection">
                        <label class="form-label small fw-semibold" id="quoteLabel">Quote number #1</label>
                        <a href="#" class="change-btn" id="changeQuoteBtn">Change</a>
                    </div>

                    <div class="d-flex justify-content-between border-bottom pb-2 pt-2 align-items-center">
                        <label class="form-label small fw-semibold">Rate opportunity</label>
                        <span class="text-warning fs-5">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-regular fa-star"></i>
                            <i class="fa-regular fa-star"></i>
                            <i class="fa-regular fa-star"></i>
                            <i class="fa-regular fa-star"></i>
                        </span>
                    </div>
                    <div class="border-bottom pb-2 pt-2 d-flex justify-content-between align-items-center">
                        <label class="form-label small fw-semibold">Salesperson</label>
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-secondary rounded-circle">U</span> Ustahub
                        </div>
                    </div>
                    <div class="pb-2 pt-2 d-flex justify-content-between align-items-center">
                        <label class="form-label small fw-semibold">Test</label>
                        <input type="text" class="form-control form-control-sm w-50" value="test">
                    </div>
                    <button type="button" class="btn-outline-custom" data-bs-toggle="modal"
                        data-bs-target="#exampleModal">
                        Add Custom Field
                    </button>
                </div>
            </div>

            <!-- Product / Service -->
            <div class="mb-4">
                <button type="button" id="addSectionBtn" class="btn">
                    <i class="fa-solid fa-plus"></i> Add Section <span class="btn">Introduction</span>
                </button>

                <!-- Hidden Form -->
                <!-- Hidden Form -->
                <div id="introForm" class="col-lg-12 card mt-4 p-3" style="display: none;">
                    <h5 class="mb-3">Section Introduction</h5>
                    <form id="sectionIntroForm" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label>Upload Image</label>
                            <input type="file" class="form-control" id="image" name="image">
                        </div>

                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Enter title">
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"
                                placeholder="Enter description"></textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-success">Save</button>
                            <button type="button" class="btn btn-secondary" id="cancelBtn">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="mb-4">
                <div class="row">
                    <div class="col-md-6">

                        <label for=""> Product / Service</label>
                        <input type="text" class="form-control" placeholder="Name">
                        <textarea class="form-control" placeholder="Description"></textarea>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-4">
                                <label for=""> Qty.</label>
                                <input type="number" class="form-control text-center" value="1">
                            </div>
                            <div class="col-md-4">
                                <label for=""> Unit Price</label>
                                <input type="text" class="form-control text-center" value="₹0.00">
                            </div>
                            <div class="col-md-4">
                                <label for=""> Total</label>
                                <input type="text" class="form-control text-center" value="₹0.00">
                            </div>
                            <div class="col-md-4 mt-2">
                                <div id="uploadBox" class="border rounded text-center"
                                    style="height: 55px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: green;">

                                    <i class="fa-regular fa-camera" style="font-size: 18px;"></i>
                                    <span class="ms-2" style="font-size: 0.9em;"></span>

                                    <input type="file" id="fileInput" style="display: none;"
                                        onchange="handleFileChange(this)">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="lineItemsContainer"></div>
            </div>

            <div class="d-flex gap-2 mt-3 mb-3">
                <button type="button" class="btn btn-success btn-sm" id="addLineItemBtn">+ Add Line Item</button>
                <button type="button" class="btn btn-outline-custom btn-sm" id="addOptionalLineItemBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" data-testid="checkbox"
                        style="fill: #2f6b2f; display: inline-block; vertical-align: middle; width: 24px; height: 24px;">
                        <path
                            d="M8.72 11.211a1 1 0 1 0-1.415 1.414l2.68 3.086a1 1 0 0 0 1.414 0l5.274-4.992a1 1 0 1 0-1.414-1.414l-4.567 4.285-1.973-2.379Z">
                        </path>
                        <path
                            d="M5 3a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2H5Zm14 2v14H5V5h14Z">
                        </path>
                    </svg> Add Optional Line Item</button>
                <button type="button" class="btn btn-outline-dark btn-sm" id="addTextBtn">+ Add Text</button>
            </div>

            <!-- Summary -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="d-flex justify-content-between align-items-center py-2">
                        <a href="#" class="text-muted small d-flex align-items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                style="width: 20px; height: 20px; fill: currentColor;">
                                <path d="M16 12a4 4 0 1 1-8 0 4 4 0 0 1 8 0Zm-2 0a2 2 0 1 0-4 0 2 2 0 0 0 4 0Z"></path>
                                <path
                                    d="M21.863 12.477C20.794 14.2 16.703 20 12 20c-4.702 0-8.795-5.8-9.863-7.523a.903.903 0 0 1 0-.954C3.205 9.8 7.297 4 12 4c4.703 0 8.794 5.8 9.863 7.523a.903.903 0 0 1 0 .954ZM20 12s-3.582-6-8-6-8 6-8 6 3.582 6 8 6 8-6 8-6Z">
                                </path>
                            </svg> Client view
                        </a>

                        <!-- Ek hi button, text aur color toggle honge -->
                        <a href="#" id="toggleBtn" class="text-success fw-semibold">Change</a>
                    </div>

                    <!-- Hidden Section -->
                    <div id="clientAdjust" class="mt-2 d-none p-2 rounded bg-light">
                        <p class="small mb-2">
                            Adjust what your client will see on this quote.<br>
                            To change the default for all future quotes, visit the PDF Style.
                        </p>
                        <div class="d-flex gap-3 flex-wrap">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="quantities">
                                <label class="form-check-label" for="quantities">Quantities</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="unitPrices">
                                <label class="form-check-label" for="unitPrices">Unit prices</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="lineTotals">
                                <label class="form-check-label" for="lineTotals">Line item totals</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="totals">
                                <label class="form-check-label" for="totals">Totals</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex justify-content-between border-bottom py-1 pt-2 pb-2">
                        <span>Subtotal</span> <span id="subtotalValue">₹0.00</span>
                    </div>

                    <!-- Discount section -->
                    <div id="discountRow">
                        <div class="d-flex justify-content-between align-items-center border-bottom py-1 pt-2 pb-2">
                            <span>Discount</span>
                            <a href="#" class="change-btn" id="addDiscountBtn">Add Discount</a>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between border-bottom py-1 pt-2 pb-2">
                        <span>Tax</span>
                        <a href="#" class="change-btn">Add Tax</a>
                    </div>

                    <div class="d-flex justify-content-between fw-bold pt-2 pb-2">
                        <span>Total</span> <span id="totalValue">₹0.00</span>
                    </div>

                    <a href="#" class="change-btn" data-bs-toggle="modal" data-bs-target="#AddDepositModal">
                        Add deposit or payment schedule
                    </a>
                </div>

            </div>

            <!-- Client message -->
            <div class="mb-4">
                <h4 class="fw-bold">Client message</h4>
                <textarea class="form-control" rows="3"></textarea>
            </div>

            .

            <!-- Contract Disclaimer -->
            <div class="mb-4">
                <h4 class="fw-bold">Contract / Disclaimer</h4>
                <textarea class="form-control"
                    rows="2">This quote is valid for the next 30 days, after which values may be subject to change.</textarea>
            </div>

            <!-- Internal Notes -->
            <div class="p-3 border rounded bg-light mb-4">
                <h3 class="fw-bold">Internal notes</h3>
                <p class="text-muted small">Internal notes will only be seen by your team</p>
                <textarea class="form-control mb-2" rows="3" placeholder="Note details"></textarea>
                <div class="border border-dashed p-3 text-center rounded">
                    Drag your files here or
                    <a href="#" class="fw-semibold text-success">Select a File</a>
                    <input type="file" class="d-none" id="fileInput">
                </div>
                <div class="form-check form-check-inline mt-2">
                    <input class="form-check-input" type="checkbox" checked> Jobs
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" checked> Invoices
                </div>
            </div>

        </form>
    </div>
</div>

<!-- Fixed Bottom Bar -->
<div class="bottom-bar fixed-bottom-bar">
    <div class="container d-flex justify-content-end gap-2">
        <button type="button" class="btn btn-custom me-2"
            onclick="window.location.href='{{ route('quotes.index') }}'">Cancel</button>
        <button type="button" class="btn btn-custom" id="saveQuoteBtn">
            <span class="btn-text">Save Quote</span>
            <span class="spinner-border spinner-border-sm d-none" id="loadingSpinner"></span>
        </button>
    </div>
</div>
</div>
<!-- Client Modal -->
<!-- Client Select/Create Modal -->
<div class="modal fade" id="clientSelectModal" tabindex="-1" aria-labelledby="clientSelectModalLabel"
    aria-hidden="true">

    <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Select or create a client</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="col-lg-12 p-4 rounded" style="border:1px solid #ccc">
        <div class="mb-3">
          <p class="fw-semibold">Which client would you like to create this for?</p>
        </div>

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

        <div class="rounded p-3" style="max-height: 300px; overflow-y: auto;">
      <div id="clientList"></div>
      <div class="text-center text-muted mt-3 d-none" id="noResults">
  <p>No results found. You can search by first name, last name, or company name.</p>
</div>

        </div>
            </div>
      </div>
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

<!-- Custom Field Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="width: 600px;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New Custom Field</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <!-- Applies to -->
                    <div class="mb-3">
                        <label class="form-label">Applies to</label>
                        <select class="form-select" disabled>
                            <option>All properties</option>
                            <option>All clients</option>
                            <option>All quotes</option>
                            <option>All jobs</option>
                            <option>All invoices</option>
                            <option>Team</option>
                        </select>
                    </div>

                    <!-- Transferable field -->
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="transferable">
                        <label class="form-check-label" for="transferable">
                            Transferable field
                        </label>
                    </div>

                    <!-- Custom field name -->
                    <div class="mb-3">
                        <label class="form-label" for="customFieldName">Custom field name</label>
                        <input type="text" class="form-control" id="customFieldName" placeholder="Enter field name">
                    </div>

                    <!-- Field type -->
                    <div class="mb-3">
                        <label class="form-label" for="fieldType">Field type</label>
                        <select id="fieldType" class="form-select" onchange="toggleFieldInputs()">
                            <option value="TEXT">Text</option>
                            <option value="NUMERIC">Numeric</option>
                            <option value="TRUE_FALSE">True/False</option>
                            <option value="AREA">Area (length x width)</option>
                            <option value="DROPDOWN">Dropdown</option>
                        </select>
                    </div>

                    <!-- Dynamic Inputs Section -->
                    <div id="dynamicFields" class="mb-3"></div>

                    <!-- Info -->
                    <p class="small text-muted">
                        All custom fields can be edited and reordered in
                        <a href="#">Settings &gt; Custom Fields.</a>
                    </p>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-custom" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline-custom">Save changes</button>
            </div>
        </div>

    </div>
</div>
<!--Add Deposit-->

<div class="modal fade" id="AddDepositModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="width: 600px;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Deposit or payment schedule</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="col-lg-12">
                    <!-- Deposit Only Section -->
                    <div class="diposit-section">
                        <input type="radio" name="depositType" id="depositRadio">
                        <div>
                            <h6 class="fw-bold mb-1">Deposit only</h6>
                            <p class="text-muted mb-0">Collect an upfront payment on quote approval</p>
                        </div>
                    </div>

                    <div class="diposit-hide-section hidden mt-2">
                        <div class="row align-items-center">
                            <div class="col-lg-8 d-flex gap-2">
                                <button type="button" id="percentBtn" class="btn btn-outline-primary active">Percentage
                                    %</button>
                                <button type="button" id="amountBtn" class="btn btn-outline-primary">Fixed Amount
                                    ₹</button>
                            </div>
                            <div class="col-lg-4">
                                <input type="text" id="toggle_amount" class="form-control" value="0%">
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="col-lg-12">
                    <!-- Payment Schedule Section -->
                    <div class="diposit-section">
                        <input type="radio" name="depositType" id="paymentScheduleRadio">
                        <div>
                            <h6 class="fw-bold mb-1">Payment schedule</h6>
                            <p class="text-muted mb-0">Break the job into multiple invoices over time</p>
                        </div>
                    </div>

                    <div class="payment-schedule-section hidden mt-2">
                        <div class="row align-items-center">
                            <div class="col-lg-4">
                                <h6 class="mb-2">Split payments by</h6>
                            </div>
                            <div class="col-lg-8 text-end">
                                <button type="button" id="schedulePercentBtn"
                                    class="btn btn-outline-primary active">Percentage %</button>
                                <button type="button" id="scheduleAmountBtn" class="btn btn-outline-primary">Fixed
                                    Amount ₹</button>
                            </div>
                        </div>

                        <div class="mt-3" id="scheduleRowsContainer"></div>

                        <div class="text-end mt-2">
                            <button type="button" id="addScheduleRow" class="btn btn-outline-primary btn-sm">
                                + Add Invoice Payment Schedule
                            </button>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-custom" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline-custom">Save changes</button>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
     const nores=`<div class="text-center pt-5 pb-5 mt-5 mb-5">
        <h5>No results</h5>
        <strong> You can search by first name, last name,<br/> or company name. Remember to check your spelling. </strong></div>`;
       $('#clientList').html(nores);
    $('#clientSearch').on('keyup', function() {
        let query = $(this).val().trim();

        if (query.length > 0) {
            $.ajax({
              url: "{{ route('clients.search') }}",
                type: "GET",
                data: { query: query },
                success: function(clients) {
                    let html = '';
                    if (clients.length > 0) {
                        clients.forEach(function(client) {
                            html += ` <div class="client-item d-flex align-items-center p-2" data-id="${client.id}"
                            style="cursor:pointer;">
                            <div class="me-3">
                                <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" alt="User Icon" class="rounded-circle"
                                    width="40" height="40">
                            </div>
                            <div>
                                <p class="mb-1 fw-bold">${client.first_name} ${client.last_name} <span
                                        class="text-muted">(${client.company_name})</span></p>
                                <p class="mb-0 text-sm"><span class="fw-semibold">1 Property</span> | ${client.phone || 'N/A'}</p>
                            </div>
                        </div>`;
                        });
                        $('#clientList').html(html);
                        $('#noResults').addClass('d-none');
                    } else {
                        $('#clientList').empty();
                        $('#noResults').removeClass('d-none');
                    }
                },
                error: function() {
                    console.error('Error fetching clients.');
                }
            });
        } else {
            $('#clientList').empty();
            $('#noResults').addClass('d-none');
        }
    });

    // Optional: click to select client
    $(document).on('click', '.client-item', function() {
        let clientId = $(this).data('id');
        let clientName = $(this).text();
        console.log('Selected client:', clientId, clientName);
        // You can set the value somewhere or close the modal
        $('#clientSelectModal').modal('hide');
    });
});
</script>

<script>
document.addEventListener("DOMContentLoaded", () => {

    // ========== INTRO FORM TOGGLE ==========
    const addSectionBtn = document.getElementById("addSectionBtn");
    const introForm = document.getElementById("introForm");
    const cancelBtn = document.getElementById("cancelBtn");

    if (addSectionBtn && introForm && cancelBtn) {
        addSectionBtn.addEventListener("click", () => {
            introForm.style.display = "block";
            addSectionBtn.style.display = "none";
        });

        cancelBtn.addEventListener("click", () => {
            introForm.style.display = "none";
            addSectionBtn.style.display = "inline-block";
        });
    }

    // ========== CLIENT ADJUST TOGGLE ==========
    const toggleBtn = document.getElementById("toggleBtn");
    const clientAdjust = document.getElementById("clientAdjust");

    if (toggleBtn && clientAdjust) {
        let isOpen = false;
        toggleBtn.addEventListener("click", (e) => {
            e.preventDefault();
            isOpen = !isOpen;
            if (isOpen) {
                toggleBtn.textContent = "Cancel";
                toggleBtn.classList.replace("text-success", "text-danger");
                clientAdjust.classList.remove("d-none");
            } else {
                toggleBtn.textContent = "Change";
                toggleBtn.classList.replace("text-danger", "text-success");
                clientAdjust.classList.add("d-none");
            }
        });
    }

    // ========== DISCOUNT SECTION ==========
    const discountRow = document.getElementById('discountRow');
    let addDiscountBtn = document.getElementById('addDiscountBtn');

    function attachDiscountEvents() {
        const applyBtn = document.getElementById('applyDiscountBtn');
        const cancelBtn = document.getElementById('cancelDiscountBtn');

        if (applyBtn) {
            applyBtn.addEventListener('click', () => {
                const valInput = document.getElementById('discountInput');
                const val = valInput ? valInput.value.trim() || '0' : '0';
                discountRow.innerHTML = `
                    <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                        <span class="fw-semibold">Discount</span>
                        <div class="d-flex align-items-center gap-2">
                            <span>${val.startsWith('₹') || val.endsWith('%') ? val : '₹' + val}</span>
                            <a href="#" class="change-btn" id="editDiscountBtn">Edit</a>
                        </div>
                    </div>`;
                document.getElementById('editDiscountBtn').addEventListener('click', (e) => {
                    e.preventDefault();
                    addDiscountBtn.click();
                });
            });
        }

        if (cancelBtn) {
            cancelBtn.addEventListener('click', () => {
                discountRow.innerHTML = `
                    <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                        <span class="fw-semibold">Discount</span>
                        <div class="d-flex align-items-center gap-2">
                            <a href="#" class="change-btn" id="addDiscountBtn">Add Discount</a>
                        </div>
                    </div>`;
                addDiscountBtn = document.getElementById('addDiscountBtn');
                addDiscountBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    addDiscountBtn.click();
                });
            });
        }
    }

    if (discountRow && addDiscountBtn) {
        addDiscountBtn.addEventListener('click', (e) => {
            e.preventDefault();
            discountRow.innerHTML = `
                <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                    <span class="fw-semibold">Discount</span>
                    <div class="d-flex align-items-center gap-2">
                        <input type="text" id="discountInput" class="form-control form-control-sm text-end"
                            placeholder="Enter % or ₹" style="width: 120px;">
                        <button type="button" id="applyDiscountBtn" class="btn btn-sm btn-outline-success">Apply</button>
                        <button type="button" id="cancelDiscountBtn" class="btn btn-sm btn-outline-secondary">Cancel</button>
                    </div>
                </div>`;
            attachDiscountEvents();
        });
    }

    // ========== QUOTE CHANGE SECTION ==========
    const quoteSection = document.getElementById('quoteSection');
    const quoteLabel = document.getElementById('quoteLabel');
    const changeBtn = document.getElementById('changeQuoteBtn');

    if (changeBtn && quoteSection && quoteLabel) {
        changeBtn.addEventListener('click', (e) => {
            e.preventDefault();
            quoteSection.innerHTML = `
                <input type="number" id="quoteInput" class="form-control form-control-sm me-2"
                    style="max-width: 200px;"
                    value="${quoteLabel.textContent.replace('Quote number #', '')}">
                <button type="button" id="cancelQuoteBtn" class="btn btn-outline-primary">Cancel</button>`;
            document.getElementById('cancelQuoteBtn').addEventListener('click', () => {
                quoteSection.innerHTML = `
                    <label class="form-label small fw-semibold" id="quoteLabel">Quote number #1</label>
                    <a href="#" class="change-btn" id="changeQuoteBtn">Change</a>`;
                document.getElementById('changeQuoteBtn').addEventListener('click', (e) => {
                    e.preventDefault();
                    changeBtn.click();
                });
            });
        });
    }

    // ========== PAYMENT SCHEDULE / DEPOSIT LOGIC ==========
    const depositRadio = document.getElementById('depositRadio');
    const paymentScheduleRadio = document.getElementById('paymentScheduleRadio');
    const depositHideSection = document.querySelector('.diposit-hide-section');
    const paymentScheduleSection = document.querySelector('.payment-schedule-section');
    const percentBtn = document.getElementById('percentBtn');
    const amountBtn = document.getElementById('amountBtn');
    const toggleAmount = document.getElementById('toggle_amount');
    const schedulePercentBtn = document.getElementById('schedulePercentBtn');
    const scheduleAmountBtn = document.getElementById('scheduleAmountBtn');
    const scheduleRowsContainer = document.getElementById('scheduleRowsContainer');
    const addScheduleRowBtn = document.getElementById('addScheduleRow');
    let scheduleMode = 'percentage';

    function addScheduleRow() {
        if (!scheduleRowsContainer) return;
        const row = document.createElement('div');
        row.classList.add('payment-row');
        row.innerHTML = (scheduleMode === 'percentage') ?
            `<input type="number" class="form-control amount-input" placeholder="Amount (%)" min="0">
             <input type="text" class="form-control desc-input" placeholder="Description">
             <input type="text" class="form-control total-input" placeholder="Total ₹">
             <button type="button" class="delete-row">✖</button>` :
            `<input type="text" class="form-control desc-input" placeholder="Description">
             <input type="text" class="form-control total-input" placeholder="Total ₹">
             <button type="button" class="delete-row">✖</button>`;
        scheduleRowsContainer.appendChild(row);
        row.querySelector('.delete-row').addEventListener('click', () => row.remove());
    }

    if (depositRadio && paymentScheduleRadio) {
        depositRadio.addEventListener('change', () => {
            if (depositRadio.checked) {
                depositHideSection?.classList.remove('hidden');
                paymentScheduleSection?.classList.add('hidden');
                percentBtn?.classList.add('active');
                amountBtn?.classList.remove('active');
                if (toggleAmount) toggleAmount.value = '0%';
            }
        });

        paymentScheduleRadio.addEventListener('change', () => {
            if (paymentScheduleRadio.checked) {
                paymentScheduleSection?.classList.remove('hidden');
                depositHideSection?.classList.add('hidden');
                scheduleMode = 'percentage';
                schedulePercentBtn?.classList.add('active');
                scheduleAmountBtn?.classList.remove('active');
                if (scheduleRowsContainer) scheduleRowsContainer.innerHTML = '';
                addScheduleRow();
            }
        });
    }

    if (percentBtn && amountBtn && toggleAmount) {
        percentBtn.addEventListener('click', () => {
            percentBtn.classList.add('active');
            amountBtn.classList.remove('active');
            toggleAmount.value = '0%';
        });
        amountBtn.addEventListener('click', () => {
            amountBtn.classList.add('active');
            percentBtn.classList.remove('active');
            toggleAmount.value = '0 Rs';
        });
    }

    if (schedulePercentBtn && scheduleAmountBtn && scheduleRowsContainer) {
        schedulePercentBtn.addEventListener('click', () => {
            scheduleMode = 'percentage';
            schedulePercentBtn.classList.add('active');
            scheduleAmountBtn.classList.remove('active');
            scheduleRowsContainer.innerHTML = '';
            addScheduleRow();
        });
        scheduleAmountBtn.addEventListener('click', () => {
            scheduleMode = 'amount';
            scheduleAmountBtn.classList.add('active');
            schedulePercentBtn.classList.remove('active');
            scheduleRowsContainer.innerHTML = '';
            addScheduleRow();
        });
    }

    if (addScheduleRowBtn) addScheduleRowBtn.addEventListener('click', addScheduleRow);

    // ========== FILE UPLOAD BOX ==========
    const uploadBox = document.getElementById("uploadBox");
    const fileInput = document.getElementById("fileInput");

    if (uploadBox && fileInput) {
        uploadBox.addEventListener("click", () => fileInput.click());
        fileInput.addEventListener("change", () => {
            if (fileInput.files && fileInput.files[0]) {
                const fileName = fileInput.files[0].name;
                uploadBox.querySelector("span").textContent = fileName;
                uploadBox.style.color = "green";
            }
        });
    }

    // ========== DYNAMIC LINE ITEM CREATION ==========
    function createLineItemForm() {
        const div = document.createElement('div');
        div.classList.add('mb-4', 'pt-2', 'rounded', 'position-relative');
        div.innerHTML = `
            <div class="row">
                <div class="col-md-6">
                    <label>Product / Service</label>
                    <input type="text" class="form-control mb-2" placeholder="Name">
                    <textarea class="form-control" placeholder="Description"></textarea>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-4">
                            <label>Qty.</label>
                            <input type="number" class="form-control text-center" value="1">
                        </div>
                        <div class="col-md-4">
                            <label>Unit Price</label>
                            <input type="text" class="form-control text-center" value="₹0.00">
                        </div>
                        <div class="col-md-4">
                            <label>Total</label>
                            <input type="text" class="form-control text-center" value="₹0.00">
                        </div>
                        <div class="col-md-4 mt-2">
                            <div class="border rounded text-center uploadBox"
                                style="height: 55px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: green;">
                                <i class="fa-regular fa-camera" style="font-size: 18px;"></i>
                                <span class="ms-2" style="font-size: 0.9em;"></span>
                                <input type="file" class="fileInput" style="display: none;">
                            </div>
                        </div>
                        <div class="col-md-8 text-end">
                            <button type="button" class="btn btn-outline-danger btn-sm end-0 m-2 removeBtn">Delete</button>
                        </div>
                    </div>
                </div>
            </div>`;
        div.querySelector('.removeBtn').addEventListener('click', () => div.remove());
        return div;
    }

    const container = document.getElementById('lineItemsContainer');
    const addBtns = ['addLineItemBtn', 'addOptionalLineItemBtn', 'addTextBtn'];
    addBtns.forEach(id => {
        const btn = document.getElementById(id);
        if (btn && container) {
            btn.addEventListener('click', () => container.appendChild(createLineItemForm()));
        }
    });

    // Make file input clickable for dynamic boxes
    document.addEventListener('click', (e) => {
        const box = e.target.closest('.uploadBox');
        if (box) {
            const input = box.querySelector('.fileInput');
            if (input) input.click();
        }
    });

});
</script>

@endpush