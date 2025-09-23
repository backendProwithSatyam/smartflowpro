@extends('admin.include.master')
@push('styles')
<style>
    body{
        font-family: 'Inter', sans-serif;

    }
    .form-container {
        max-width: 100%;
        margin: 2rem auto;
        padding: 2rem;
        background: white;
        border-radius: 8px;
        position: relative;
        padding-bottom: 6rem;
    }

    .section-divider {
        border-top: 1px solid #e9ecef;
        margin: 2rem 0 1.5rem 0;
        padding-top: 1.5rem;
    }

    .text-muted-custom {
        color: #6c757d !important;
        font-size: 0.875rem;
        line-height: 1.5;
    }

    .form-actions-fixed {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 1rem 2rem;
        background: #f8f9fa;
        border-top: 1px solid #dee2e6;
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
    }

       .btn-primary-custom {
  background-color: #388523;
  color:#fff;
  font-weight: bold;
}
    .btn-primary-custom:hover {
        background-color: #fff;
        color:#388523;
        border: #388523 solid 1px;
    }
.btn-custom-secondary{
  background-color: #fff;
        color:#388523;
        border: #388523 solid 1px;
}
.btn-custom-secondary:hover {
    background-color: #388523;
  color:#fff;
}
    /* .modal-content {
            background: none !important;
        } */
</style>
@endpush
@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-10">
                   <div class="form-container">
            <h2 class="mb-4 fw-bold">New Client</h2>
            <form id="clientForm" method="POST"
                action="{{ $editMode ? route('clients.update', $client) : route('clients.store') }}">
                @csrf
                @if($editMode)
                @method('PUT')
                @endif
                <div class="row">
                    <div class="col-lg-4">
                        <h5 class="fw-bold text-dark mb-2">Primary contact details</h5>
                        <p class="text-muted-custom mb-4">Provide the main point of contact to ensure smooth
                            communication
                            and
                            reliable client records.</p>
                    </div>
                    <div class="col-lg-8">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label for="title" class="form-label">Title</label>
                                <select class="form-select" id="title" name="title">
                                    <option value="">No title</option>
                                    <option value="Mr" {{ $editMode && $client->title === 'Mr' ? 'selected' : '' }}>Mr
                                    </option>
                                    <option value="Mrs" {{ $editMode && $client->title === 'Mrs' ? 'selected' : '' }}>
                                        Mrs
                                    </option>
                                    <option value="Miss" {{ $editMode && $client->title === 'Miss' ? 'selected' : '' }}>
                                        Miss
                                    </option>
                                    <option value="Ms" {{ $editMode && $client->title === 'Ms' ? 'selected' : '' }}>Ms
                                    </option>
                                    <option value="Dr" {{ $editMode && $client->title === 'Dr' ? 'selected' : '' }}>Dr
                                    </option>
                                    <option value="Prof" {{ $editMode && $client->title === 'Prof' ? 'selected' : '' }}>
                                        Prof
                                    </option>
                                </select>
                                @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="firstName" class="form-label">First name</label>
                                <input type="text" class="form-control" id="firstName" name="firstName"
                                    placeholder="First name" value="{{ old('firstName', $client->first_name) }}">
                                @error('firstName') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-5">
                                <label for="lastName" class="form-label">Last name</label>
                                <input type="text" class="form-control" id="lastName" name="lastName"
                                    placeholder="Last name" value="{{ old('lastName', $client->last_name) }}">
                                @error('lastName') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="row g-3 mt-2">
                                <div class="col-12">
                                    <label for="companyName" class="form-label">Company name</label>
                                    <input type="text" class="form-control" id="companyName" name="companyName"
                                        placeholder="Company name"
                                        value="{{ old('companyName', $client->company_name ?? '') }}">
                                    @error('companyName') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="section-divider">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="phoneNumber" class="form-label">Phone number</label>
                                        <input type="tel" class="form-control" id="phoneNumber" name="phoneNumber"
                                            placeholder="Phone number"
                                            value="{{ old('phoneNumber', $client->phone_number ?? '') }}">
                                        @error('phoneNumber') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            placeholder="Email" value="{{ old('email', $client->email ?? '') }}">
                                        @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>

                        </div>
                              <div class="section-divider">
                        <h5 class="fw-bold text-dark mb-3">Lead information</h5>
                        <div class="row g-3">
                            <div class="col-md-12">
                                @include('admin.partials.lead_source', ['value' => old('lead_source', $client->lead_source)])
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
                 <div class="row section-divider">
                        <div class="col-lg-4 pt-5">
                              <h5 class="fw-bold text-dark mb-2">Property Address Details</h5>
                              <p>Enter the primary service address, billing address, or any additional locations where services may take place.</p>
                        </div>
                        <div class="col-lg-8">
                       <div class="section-divider-1">

                        <div id="addressContainer">
                            @forelse(old('addresses', $client->addresses->where('type', 'property')->toArray()) as $i => $addr)
                                @include('admin.pages.client.partials.address', ['index' => $i, 'address' => $addr, 'taxRates' => $taxRates])
                            @empty
                                @include('admin.pages.client.partials.address', ['index' => 0, 'address' => [], 'taxRates' => $taxRates])
                            @endforelse
                        </div>
                        <button type="button" id="addAddressBtn" class="btn btn-custom-secondary mt-2">
                            <i class="bi bi-plus-circle"></i> Add More Address
                        </button>
                    </div>
                    <div class="form-check mt-4">
                        <input class="form-check-input" type="checkbox" name="same_as_billing" id="same_as_billing" {{ old('same_as_billing', $client->same_as_billing ?? false) ? 'checked' : '' }}>
                        <label class="form-check-label">Billing address same as property</label>
                    </div>
                      <div id="billingAddressSection"
                    style="{{ old('same_as_billing', $client->same_as_billing) ? 'display:none;' : '' }}">
                    <h5 class="mt-3">Billing Address</h5>
                    @include('admin.pages.client.partials.address', ['index' => 'billing', 'address' =>
                    $client->addresses->where('type', 'billing')->first() ?? [], 'taxRates' => $taxRates, 'billing' =>
                    true])
                </div>
                <div class="row mt-4">
                    <div class="form-actions-fixed">
                        <button type="submit"
                            class="btn btn-primary-custom me-2">{{ $editMode ? 'Update Client' : 'Create Client' }}</button>
                        <button type="button" class="btn btn-custom-secondary">Cancel</button>
                    </div>
                </div>
                        </div>
                    </div>

              
            </form>
        </div>
            </div>
        </div>
     
    </div>
</div>
<div class="modal fade" id="taxRateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('tax-rates.store') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="taxRateLabel">New Tax Rate</h5>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Rate (%)</label>
                        <input type="number" step="0.01" name="rate" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Cancel</button>
                    <button class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const addressContainer = document.getElementById('addressContainer');
        const addAddressBtn = document.getElementById('addAddressBtn');
        let addressCount = document.querySelectorAll('#addressContainer .address-group').length;
        addAddressBtn.addEventListener('click', function() {
            addAddressGroup();
        });
        addressContainer.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-address-btn') || e.target.closest(
                    '.remove-address-btn')) {
                const addressGroup = e.target.closest('.address-group');
                addressGroup.remove();
                updateAddressLabels();
            }
        });

        function addAddressGroup() {
            const newAddressHtml = createAddressGroupHtml(addressCount);
            addressContainer.insertAdjacentHTML('beforeend', newAddressHtml);
            addressCount++;
            updateAddressLabels();
        }
        const sameAsBillingCheckbox = document.getElementById('same_as_billing');
        const billingAddressSection = document.getElementById('billingAddressSection');
        sameAsBillingCheckbox.addEventListener('change', function() {
            if (this.checked) {
                billingAddressSection.style.display = 'none';
            } else {
                billingAddressSection.style.display = 'block';
            }
        });

        function createAddressGroupHtml(index) {
            return `
                                                                    <div class="address-group mb-4" data-address-index="${index}">
                                                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                                                            <h6 class="fw-semibold text-secondary mb-0">Address ${index + 1}</h6>
                                                                            <button type="button" class="btn btn-outline-danger btn-sm remove-address-btn">
                                                                                <i class="bi bi-trash me-1"></i>Remove
                                                                            </button>
                                                                        </div>

                                                                        <div class="row g-3">
                                                                            <div class="col-12">
                                                                                <label class="form-label">Street 1</label>
                                                                                <input type="text" class="form-control" name="addresses[${index}][street1]" placeholder="Street 1">
                                                                            </div>
                                                                            <div class="col-12">
                                                                                <label class="form-label">Street 2</label>
                                                                                <input type="text" class="form-control" name="addresses[${index}][street2]" placeholder="Street 2">
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <label class="form-label">City</label>
                                                                                <input type="text" class="form-control" name="addresses[${index}][city]" placeholder="City">
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <label class="form-label">Province</label>
                                                                                <input type="text" class="form-control" name="addresses[${index}][province]" placeholder="Province">
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <label class="form-label">Postal code</label>
                                                                                <input type="text" class="form-control" name="addresses[${index}][postal_code]" placeholder="Postal code">
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <label class="form-label">Country</label>
                                                                                <select class="form-select" name="addresses[${index}][country]">
                                                                                    <option value="">Select Country</option>
                                                                                    <option value="Afghanistan">Afghanistan</option>
                                                                                    <option value="Australia">Australia</option>
                                                                                    <option value="Canada">Canada</option>
                                                                                    <option value="India">India</option>
                                                                                    <option value="United Kingdom">United Kingdom</option>
                                                                                    <option value="United States">United States</option>
                                                                                </select>
                                                                            </div>
                                                                            <div class="col-12">
                                                                                <label class="form-label">Tax Rate</label>
                                                                                <select class="form-select" name="addresses[${index}][tax_rate_id]">
                                                                                    <option value="">Select Tax Rate</option>
                                                                                    @foreach($taxRates as $taxRate)
                                                                                        <option value="{{ $taxRate->id }}">{{ $taxRate->name }} ({{ $taxRate->rate }}%)</option>
                                                                                    @endforeach
                                                                                </select>
                                                                                <button type="button" class="btn btn-link p-0 ms-2" data-bs-toggle="modal" data-bs-target="#taxRateModal">
                                                                                    <i class="bi bi-plus-circle"></i> Add new tax rate
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                `;
        }

        function updateAddressLabels() {
            const addressGroups = addressContainer.querySelectorAll('.address-group');
            addressGroups.forEach((group, index) => {
                const label = group.querySelector('h6');
                label.textContent = `Address ${index + 1}`;
                group.setAttribute('data-address-index', index);
                const inputs = group.querySelectorAll('input, select');
                inputs.forEach(input => {
                    const name = input.getAttribute('name');
                    if (name) {
                        const updatedName = name.replace(/addresses\[\d+\]/,
                            `addresses[${index}]`);
                        input.setAttribute('name', updatedName);
                    }
                });
            });
        }
        document.getElementById('clientForm').addEventListener('submit', function(e) {
            const sameAsBilling = document.getElementById('same_as_billing').checked;
            if (sameAsBilling) {
                // Copy first property address to billing
                const firstAddress = document.querySelector('#addressContainer .address-group');
                if (firstAddress) {
                    const fields = ['street1', 'street2', 'city', 'province', 'postal_code', 'country'];
                    fields.forEach(field => {
                        const propInput = firstAddress.querySelector(
                            `input[name="addresses[0][${field}]"], select[name="addresses[0][${field}]"]`
                            );
                        const billInput = document.querySelector(
                            `input[name="billing_address[${field}]"], select[name="billing_address[${field}]"]`
                            );
                        if (propInput && billInput) {
                            billInput.value = propInput.value;
                        }
                    });
                    // For tax_rate_id
                    const propTax = firstAddress.querySelector(
                        'select[name="addresses[0][tax_rate_id]"]');
                    const billTax = document.querySelector(
                        'select[name="billing_address[tax_rate_id]"]');
                    if (propTax && billTax) {
                        billTax.value = propTax.value;
                    }
                }
            }
            // Allow form to submit normally
        });
    });
</script>
@endpush