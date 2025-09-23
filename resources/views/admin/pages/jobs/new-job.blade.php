@extends('admin.include.master')
@push('styles')
    @include('admin.pages.jobs.partials.new-job-style')
@endpush
@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="container">
        <!-- Page Header -->
        <div class="new-job-page-header">
            <h1 class="page-title">
                <i class="fas fa-leaf"></i>{{ isset($job) ? 'Edit Job' : 'New Job' }}
            </h1>
            <a href="{{ route('jobs.index') }}" class="back-btn">
                <i class="fas fa-arrow-left me-2"></i>Back to Jobs
            </a>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form id="jobForm" method="POST"
            action="{{ isset($job) ? route('jobs.update', $job->id) : route('jobs.store') }}"
            enctype="multipart/form-data">
            @csrf
            @if(isset($job))
                @method('PUT')
            @endif

            <!-- Header Section -->
            <div class="form-section">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title"
                            value="{{ old('title', $job->title ?? '') }}" placeholder="Enter job title">
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="icon-input">
                            @include('admin.partials.search_client', ['clients' => $clients ?? null])
                            <i class="fas fa-search pt-4"></i>
                        </div>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="jobNumber" class="form-label">Job #</label>
                        <input type="text" class="form-control" id="jobNumber" name="job_number"
                            value="{{ old('job_number', $job->job_number ?? '1') }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="salesperson" class="form-label">Salesperson</label>
                        <select class="form-select" id="salesperson" name="salesperson">
                            <option value="">Salesperson</option>
                            <option value="john" {{ old('salesperson', $job->salesperson ?? '') == 'john' ? 'selected' : '' }}>John Doe</option>
                            <option value="jane" {{ old('salesperson', $job->salesperson ?? '') == 'jane' ? 'selected' : '' }}>Jane Smith</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Job Type Section -->
            <div class="form-section">
                <h3 class="section-title">
                    Job type
                    <i class="fas fa-info-circle" style="font-size: 0.8rem; color: #6b7280;"></i>
                </h3>
                <div class="toggle-buttons">
                    <button type="button"
                        class="toggle-btn {{ old('job_type', $job->job_type ?? 'one-off') == 'one-off' ? 'active' : '' }}"
                        data-type="one-off">One-off</button>
                    <button type="button"
                        class="toggle-btn {{ old('job_type', $job->job_type ?? 'one-off') == 'recurring' ? 'active' : '' }}"
                        data-type="recurring">Recurring</button>
                </div>
                <input type="hidden" id="jobType" name="job_type"
                    value="{{ old('job_type', $job->job_type ?? 'one-off') }}">
            </div>

            <!-- Schedule Section -->
            <div class="form-section">
                <h3 class="section-title">Schedule</h3>

                <!-- One-off Schedule Section -->
                <div id="oneOffSchedule">
                    <div class="mb-3">
                        <span class="text-muted">Total visits 1 | On {{ request('date') ? \Carbon\Carbon::parse(request('date'))->format('F j, Y') : date('F j, Y') }}</span>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="scheduleDate" class="form-label">Date</label>
                            <div class="icon-input">
                                <input type="date" class="form-control" id="scheduleDate" name="schedule_date"
                                    value="{{ request('date') ?? date('Y-m-d') }}">
                                <i class="fas fa-calendar"></i>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="startTime" class="form-label">Start Time</label>
                            <div class="icon-input">
                                <input type="time" class="form-control" id="startTime" name="start_time">
                                <i class="fas fa-clock"></i>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="endTime" class="form-label">End Time</label>
                            <div class="icon-input">
                                <input type="time" class="form-control" id="endTime" name="end_time">
                                <i class="fas fa-clock"></i>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="form-check mt-4">
                                <input class="form-check-input" type="checkbox" id="scheduleLater"
                                    name="schedule_later">
                                <label class="form-check-label" for="scheduleLater">Schedule later</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="anytime" name="anytime"
                                    onchange="toggleTimeFields()">
                                <label class="form-check-label" for="anytime">Anytime</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="repeats" class="form-label">Repeats</label>
                            <select class="form-select" id="repeats" name="repeats" onchange="toggleRepeatOptions()">
                                <option value="none">Does not repeat</option>
                                <option value="daily">Daily</option>
                                <option value="weekly">Weekly on Saturday</option>
                                <option value="biweekly">Every 2 Week on Saturday</option>
                                <option value="monthly">Monday on the 13th</option>
                                <option value="asneeded">As needed (you won't prompt you)</option>
                            </select>

                            <!-- Repeat End Options (hidden by default) -->
                            <div id="repeatEndOptions" class="mt-3" style="display: none;">
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="repeat_end_type"
                                            id="endsAfter" value="after" checked onchange="toggleEndFields()">
                                        <label class="form-check-label" for="endsAfter">Ends after</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="repeat_end_type" id="endsOn"
                                            value="on" onchange="toggleEndFields()">
                                        <label class="form-check-label" for="endsOn">Ends on</label>
                                    </div>
                                </div>

                                <!-- Ends After Fields -->
                                <div id="endsAfterFields" class="row">
                                    <div class="col-md-6 mb-3">
                                        <input type="number" class="form-control" name="repeat_end_after_number"
                                            value="1" min="1" placeholder="Number">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <select class="form-select" name="repeat_end_after_period">
                                            <option value="days">days</option>
                                            <option value="weeks">weeks</option>
                                            <option value="months">months</option>
                                            <option value="years">years</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Ends On Field -->
                                <div id="endsOnField" class="mb-3" style="display: none;">
                                    <input type="date" class="form-control" name="repeat_end_on_date">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            @include('admin.partials.assigned')
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="visitInstructions" class="form-label">Visit instructions</label>
                            <textarea class="form-control" id="visitInstructions" name="visit_instructions"
                                rows="3"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Recurring Schedule Section -->
                <div id="recurringSchedule" style="display: none;">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="recurringStartDate" class="form-label">Start Date</label>
                            <div class="icon-input">
                                <input type="date" class="form-control" id="recurringStartDate"
                                    name="recurring_start_date" value="2020-09-15">
                                <i class="fas fa-calendar"></i>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="recurringStartTime" class="form-label">Start Time</label>
                            <div class="icon-input">
                                <input type="time" class="form-control" id="recurringStartTime"
                                    name="recurring_start_time">
                                <i class="fas fa-clock"></i>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="recurringEndTime" class="form-label">End Time</label>
                            <div class="icon-input">
                                <input type="time" class="form-control" id="recurringEndTime" name="recurring_end_time">
                                <i class="fas fa-clock"></i>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="form-check mt-4">
                                <input class="form-check-input" type="checkbox" id="recurringAnytime"
                                    name="recurring_anytime" onchange="toggleRecurringTimeFields()">
                                <label class="form-check-label" for="recurringAnytime">Anytime</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="recurringRepeats" class="form-label">Repeats</label>
                            <select class="form-select" id="recurringRepeats" name="recurring_repeats"
                                onchange="toggleRecurringRepeatOptions()">
                                <option value="daily">Daily</option>
                                <option value="weekly">Weekly on Saturday</option>
                                <option value="biweekly">Every 2 weeks on Saturday</option>
                                <option value="monthly">Monthly on today</option>
                                <option value="asneeded">As needed (you prompt)</option>
                            </select>
                            <div id="recurringRepeatEndOptions" class="mt-3">
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="recurring_repeat_end_type"
                                            id="recurringEndsAfter" value="after" checked
                                            onchange="toggleRecurringEndFields()">
                                        <label class="form-check-label" for="recurringEndsAfter">Ends after</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="recurring_repeat_end_type"
                                            id="recurringEndsOn" value="on" onchange="toggleRecurringEndFields()">
                                        <label class="form-check-label" for="recurringEndsOn">Ends on</label>
                                    </div>
                                </div>
                                <div id="recurringEndsAfterFields" class="row">
                                    <div class="col-md-6 mb-3">
                                        <input type="number" class="form-control"
                                            name="recurring_repeat_end_after_number" value="1" min="1"
                                            placeholder="Number">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <select class="form-select" name="recurring_repeat_end_after_period">
                                            <option value="days">days</option>
                                            <option value="weeks">weeks</option>
                                            <option value="months">months</option>
                                            <option value="years">years</option>
                                        </select>
                                    </div>
                                </div>
                                <div id="recurringEndsOnField" class="mb-3" style="display: none;">
                                    <input type="date" class="form-control" name="recurring_repeat_end_on_date">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Assign to</label>
                            <div class="d-flex flex-wrap gap-2 mb-2">
                                <span class="badge bg-secondary">Indigent <i class="fas fa-times ms-1"></i></span>
                                <span class="badge bg-secondary">Puppy Lane <i class="fas fa-times ms-1"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="recurringVisitInstructions" class="form-label">Visit instructions</label>
                            <textarea class="form-control" id="recurringVisitInstructions"
                                name="recurring_visit_instructions" rows="3"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-section">
                <h3 class="section-title">Product / Service</h3>
                <p class="text-muted mb-3">Keep everything on track by adding products and services.</p>

                <div id="productItems">

                </div>

                <button type="button" class="btn btn-primary-custom" onclick="addProductItem()">
                    <i class="fas fa-plus me-2"></i>Add New Item
                </button>

                <div class="total-summary">
                    <div class="total-row">
                        <span>Total cost</span>
                        <input type="hidden" name="total_cost" id="totalCostInput" value="0.00">
                        <span id="totalCost">$0.00</span>
                    </div>
                    <div class="total-row">
                        <span>Total price</span>
                        <input type="hidden" name="total_price" id="totalPriceInput" value="0.00">
                        <span id="totalPrice">$0.00</span>
                    </div>
                </div>
            </div>

            <!-- Notes Section -->
            <div class="form-section">
                <h3 class="section-title">Notes</h3>
                <div class="notes-area" onclick="showNotesForm()">
                    <div class="add-note-icon">
                        <i class="fas fa-plus"></i>
                    </div>
                </div>
                <div class="notes-form" id="notesForm">
                    <textarea class="form-control" id="notes" name="notes" rows="4"
                        placeholder="Leave an internal note for yourself or a team member"></textarea>
                    <div class="file-upload-area" onclick="document.getElementById('fileUpload').click()">
                        <i class="fas fa-paperclip me-2"></i>
                        Attach files or photos
                        <input type="file" id="fileUpload" name="attachments[]" multiple
                            accept="image/*,.pdf,.doc,.docx" style="display: none;">
                    </div>
                    <div id="fileList" class="mt-2"></div>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="fixed-bottom-bar">
    <div class="d-flex justify-content-end gap-3">
        <button type="button" class="btn btn-custom"
            onclick="window.location.href='{{ route('jobs.index') }}'">
            Cancel
        </button>
        <button type="button" class="btn btn-primary-custom" onclick="saveJob()">
            <i class="fas fa-save me-2"></i>{{ isset($job) ? 'Update Job' : 'Save Job' }}
        </button>
    </div>
</div>
@endsection
@push('scripts')
<script>
    let productItemCount = 0;
    document.querySelectorAll('.toggle-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.toggle-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            document.getElementById('jobType').value = this.dataset.type;
            toggleScheduleSections();
        });
    });
    function toggleScheduleSections() {
        const jobType = document.getElementById('jobType').value;
        const oneOffSchedule = document.getElementById('oneOffSchedule');
        const recurringSchedule = document.getElementById('recurringSchedule');
        if (jobType === 'one-off') {
            oneOffSchedule.style.display = 'block';
            recurringSchedule.style.display = 'none';
        } else if (jobType === 'recurring') {
            oneOffSchedule.style.display = 'none';
            recurringSchedule.style.display = 'block';
        }
    }

    // Toggle time fields for one-off schedule
    function toggleTimeFields() {
        const anytime = document.getElementById('anytime');
        const startTime = document.getElementById('startTime');
        const endTime = document.getElementById('endTime');

        if (anytime.checked) {
            startTime.disabled = true;
            endTime.disabled = true;
        } else {
            startTime.disabled = false;
            endTime.disabled = false;
        }
    }

    // Toggle time fields for recurring schedule
    function toggleRecurringTimeFields() {
        const recurringAnytime = document.getElementById('recurringAnytime');
        const recurringStartTime = document.getElementById('recurringStartTime');
        const recurringEndTime = document.getElementById('recurringEndTime');

        if (recurringAnytime.checked) {
            recurringStartTime.disabled = true;
            recurringEndTime.disabled = true;
        } else {
            recurringStartTime.disabled = false;
            recurringEndTime.disabled = false;
        }
    }

    // Toggle recurring repeat options (always visible for recurring)
    function toggleRecurringRepeatOptions() {
        // For recurring, the end options are always visible
        // This function is kept for consistency but doesn't need to do anything
    }

    // Toggle recurring end fields
    function toggleRecurringEndFields() {
        const recurringEndsAfter = document.getElementById('recurringEndsAfter');
        const recurringEndsOn = document.getElementById('recurringEndsOn');
        const recurringEndsAfterFields = document.getElementById('recurringEndsAfterFields');
        const recurringEndsOnField = document.getElementById('recurringEndsOnField');

        if (recurringEndsAfter.checked) {
            recurringEndsAfterFields.style.display = 'flex';
            recurringEndsOnField.style.display = 'none';
        } else if (recurringEndsOn.checked) {
            recurringEndsAfterFields.style.display = 'none';
            recurringEndsOnField.style.display = 'block';
        }
    }

    // Add product item function
    function addProductItem() {
        productItemCount++;
        const productItemsContainer = document.getElementById('productItems');

        const productItem = document.createElement('div');
        productItem.className = 'product-item';
        productItem.innerHTML = `
                <button type="button" class="delete-item-btn" onclick="removeProductItem(this)">
                    <i class="fas fa-times"></i>
                </button>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" name="product_name_${productItemCount}" placeholder="Enter product/service name">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Quantity</label>
                        <input type="number" class="form-control" name="product_quantity_${productItemCount}" value="1" min="1" onchange="calculateTotals()">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Unit Cost</label>
                        <input type="number" class="form-control" name="product_unit_cost_${productItemCount}" step="0.01" placeholder="0.00" onchange="calculateTotals()">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Unit Price</label>
                        <input type="number" class="form-control" name="product_unit_price_${productItemCount}" step="0.01" placeholder="0.00" onchange="calculateTotals()">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Total</label>
                        <input type="number" class="form-control" name="product_total_${productItemCount}" step="0.01" readonly>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="product_description_${productItemCount}" rows="2" placeholder="Enter description"></textarea>
                    </div>
                </div>
            `;

        productItemsContainer.appendChild(productItem);
        calculateTotals();
    }

    // Remove product item function
    function removeProductItem(button) {
        button.parentElement.remove();
        calculateTotals();
    }

    // Calculate totals function
    function calculateTotals() {
        let totalCost = 0;
        let totalPrice = 0;

        document.querySelectorAll('.product-item').forEach(item => {
            const quantity = parseFloat(item.querySelector('input[name*="quantity"]').value) || 0;
            const unitCost = parseFloat(item.querySelector('input[name*="unit_cost"]').value) || 0;
            const unitPrice = parseFloat(item.querySelector('input[name*="unit_price"]').value) || 0;

            const total = quantity * unitPrice;
            item.querySelector('input[name*="total"]').value = total.toFixed(2);

            totalCost += quantity * unitCost;
            totalPrice += total;
        });

        document.getElementById('totalCost').textContent = '$' + totalCost.toFixed(2);
        document.getElementById('totalPrice').textContent = '$' + totalPrice.toFixed(2);
        document.getElementById('totalCostInput').value = totalCost.toFixed(2);
        document.getElementById('totalPriceInput').value = totalPrice.toFixed(2);
    }

    // Show notes form function
    function showNotesForm() {
        const notesForm = document.getElementById('notesForm');
        const notesArea = document.querySelector('.notes-area');

        notesForm.classList.add('active');
        notesArea.style.display = 'none';
    }

    // File upload handling
    document.getElementById('fileUpload').addEventListener('change', function (e) {
        const fileList = document.getElementById('fileList');
        fileList.innerHTML = '';

        Array.from(e.target.files).forEach(file => {
            const fileItem = document.createElement('div');
            fileItem.className = 'd-flex align-items-center justify-content-between p-2 border rounded mb-2';
            fileItem.innerHTML = `
                    <div class="d-flex align-items-center">
                        <i class="fas fa-file me-2"></i>
                        <span>${file.name}</span>
                        <small class="text-muted ms-2">(${(file.size / 1024).toFixed(1)} KB)</small>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeFile(this)">
                        <i class="fas fa-times"></i>
                    </button>
                `;
            fileList.appendChild(fileItem);
        });
    });

    // Remove file function
    function removeFile(button) {
        button.parentElement.remove();
    }

    // Save job via AJAX
    async function saveJob() {
        const form = document.getElementById('jobForm');
        const formData = new FormData(form);

        // collect product items into JSON
        const productItems = [];
        document.querySelectorAll('.product-item').forEach(item => {
            productItems.push({
                name: item.querySelector('input[name*="name"]').value,
                quantity: item.querySelector('input[name*="quantity"]').value,
                unit_cost: item.querySelector('input[name*="unit_cost"]').value,
                unit_price: item.querySelector('input[name*="unit_price"]').value,
                total: item.querySelector('input[name*="total"]').value,
                description: item.querySelector('textarea[name*="description"]').value
            });
        });
        formData.set('product_items', JSON.stringify(productItems));

        const url = form.getAttribute('action');
        const isEdit = {{ isset($job) ? 'true' : 'false' }};
        if (isEdit) {
            formData.set('_method', 'PUT');
        }

        // Clear previous validation states
        clearFieldErrors(form);

        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: formData
            });

            const data = await response.json();
            if (!response.ok) {
                if (data && data.errors) {
                    showFieldErrors(form, data.errors);
                } else {
                    alert(data.message || 'Validation error');
                }
                return;
            }
            window.location.href = "{{ route('jobs.index') }}";
        } catch (e) {
            alert('Something went wrong while saving the job.');
        }
    }

    function clearFieldErrors(form) {
        // remove is-invalid classes
        form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        // remove previous feedback nodes we added
        form.querySelectorAll('.js-validation-error').forEach(el => el.remove());
    }

    function showFieldErrors(form, errors) {
        Object.keys(errors).forEach(fieldName => {
            const messages = Array.isArray(errors[fieldName]) ? errors[fieldName] : [String(errors[fieldName])];
            const field = form.querySelector(`[name="${CSS.escape(fieldName)}"]`);
            if (field) {
                field.classList.add('is-invalid');
                const feedback = document.createElement('div');
                feedback.className = 'invalid-feedback js-validation-error d-block';
                feedback.textContent = messages[0];
                const container = field.parentElement || field;
                container.appendChild(feedback);
            }
        });
        // Focus first invalid field
        const firstInvalid = form.querySelector('.is-invalid');
        if (firstInvalid) firstInvalid.focus();
    }

    // Auto-calculate total when quantity or price changes
    document.addEventListener('input', function (e) {
        if (e.target.name && (e.target.name.includes('quantity') || e.target.name.includes('unit_price'))) {
            const item = e.target.closest('.product-item');
            if (item) {
                const quantity = parseFloat(item.querySelector('input[name*="quantity"]').value) || 0;
                const unitPrice = parseFloat(item.querySelector('input[name*="unit_price"]').value) || 0;
                const total = quantity * unitPrice;
                item.querySelector('input[name*="total"]').value = total.toFixed(2);
                calculateTotals();
            }
        }
    });

    // Toggle repeat options based on selection
    function toggleRepeatOptions() {
        const repeatsSelect = document.getElementById('repeats');
        const repeatEndOptions = document.getElementById('repeatEndOptions');

        if (repeatsSelect.value === 'none') {
            repeatEndOptions.style.display = 'none';
        } else {
            repeatEndOptions.style.display = 'block';
        }
    }

    // Toggle end fields based on radio button selection
    function toggleEndFields() {
        const endsAfter = document.getElementById('endsAfter');
        const endsOn = document.getElementById('endsOn');
        const endsAfterFields = document.getElementById('endsAfterFields');
        const endsOnField = document.getElementById('endsOnField');

        if (endsAfter.checked) {
            endsAfterFields.style.display = 'flex';
            endsOnField.style.display = 'none';
        } else if (endsOn.checked) {
            endsAfterFields.style.display = 'none';
            endsOnField.style.display = 'block';
        }
    }

    // Set default time for both sections
    const now = new Date();
    now.setHours(now.getHours() + 1);
    const startTime = now.toTimeString().slice(0, 5);
    now.setHours(now.getHours() + 2);
    const endTime = now.toTimeString().slice(0, 5);

    // Set default times for one-off schedule
    document.getElementById('startTime').value = startTime;
    document.getElementById('endTime').value = endTime;

    // Set default times for recurring schedule
    document.getElementById('recurringStartTime').value = startTime;
    document.getElementById('recurringEndTime').value = endTime;

    // Populate form on edit via AJAX if needed
    document.addEventListener('DOMContentLoaded', async function () {
        const isEdit = {{ isset($job) ? 'true' : 'false' }};
        if (!isEdit) return;
        try {
            const res = await fetch("{{ isset($job) ? route('jobs.edit', $job->id) : '' }}", {
                headers: { 'Accept': 'application/json' }
            });
            if (!res.ok) return;
            const payload = await res.json();
            const job = payload && payload.job ? payload.job : payload;
            const clients = payload && payload.clients ? payload.clients : [];
            if (job) {
                document.getElementById('title').value = job.title || '';
                const hiddenClientId = document.getElementById('client_id');
                if (hiddenClientId) hiddenClientId.value = job.client_id || '';
                // Prefer stored client name; if empty and client_id present, try to infer from clients list
                const clientInput = document.getElementById('client');
                let clientName = job.client || '';
                if (!clientName && job.client_id && Array.isArray(clients)) {
                    const found = clients.find(c => String(c.id) === String(job.client_id));
                    if (found) clientName = `${found.title ?? ''} ${found.first_name ?? ''} ${found.last_name ?? ''}`.trim();
                }
                if (clientInput) clientInput.value = clientName;
                document.getElementById('jobNumber').value = job.job_number || '';
                document.getElementById('salesperson').value = job.salesperson || '';
                document.getElementById('jobType').value = job.job_type || 'one-off';
                toggleScheduleSections();
                // Dates and times: handle either ISO strings or plain HH:MM
                const schedDate = job.schedule_date ? String(job.schedule_date) : '';
                document.getElementById('scheduleDate').value = schedDate.includes('T') ? schedDate.substring(0,10) : schedDate;
                const startTime = job.start_time ? String(job.start_time) : '';
                const endTime = job.end_time ? String(job.end_time) : '';
                document.getElementById('startTime').value = startTime.length >= 5 ? startTime.substring(0,5) : '';
                document.getElementById('endTime').value = endTime.length >= 5 ? endTime.substring(0,5) : '';
                document.getElementById('anytime').checked = !!job.anytime;
                document.getElementById('scheduleLater').checked = !!job.schedule_later;
                document.getElementById('repeats').value = job.repeats || 'none';
                toggleRepeatOptions();
                if (job.product_items && Array.isArray(job.product_items)) {
                    document.getElementById('productItems').innerHTML = '';
                    job.product_items.forEach(pi => {
                        addProductItem();
                        const items = document.querySelectorAll('.product-item');
                        const last = items[items.length - 1];
                        last.querySelector('input[name*="name"]').value = pi.name || '';
                        last.querySelector('input[name*="quantity"]').value = pi.quantity || 1;
                        last.querySelector('input[name*="unit_cost"]').value = pi.unit_cost || 0;
                        last.querySelector('input[name*="unit_price"]').value = pi.unit_price || 0;
                        last.querySelector('input[name*="total"]').value = pi.total || 0;
                        last.querySelector('textarea[name*="description"]').value = pi.description || '';
                    });
                    calculateTotals();
                }
                document.getElementById('visitInstructions').value = job.visit_instructions || '';
                document.getElementById('notes').value = job.notes || '';
            }
        } catch {}
    });
</script>
@endpush