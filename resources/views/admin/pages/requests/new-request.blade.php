@extends('admin.include.master')
@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css"
        rel="stylesheet">
    @include('admin.pages.requests.partials.new-request-style')
    <style>
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
    </style>
@endpush
@php
    $serviceRequest = $serviceRequest ?? null;
    $client_name = isset($serviceRequest) && $serviceRequest->client ? $serviceRequest->client->title . ' ' . $serviceRequest->client->first_name . ' ' . $serviceRequest->client->last_name : '';
@endphp
@section('content')
    <div class="container mt-4">
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <i class="bi bi-file-earmark-{{ isset($serviceRequest) ? 'text' : 'plus' }} text-warning me-2"></i>
                <span>{{ isset($serviceRequest) ? 'Edit Request' : 'New Request' }}</span>
            </div>
            <div class="card-body">
                <form id="requestForm" enctype="multipart/form-data">
                    @csrf
                    @if(isset($serviceRequest))
                        @method('PUT')
                    @endif
                <div class="mb-4">
                    <label class="form-label">Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" placeholder="Enter title" 
                           value="{{ old('title', $serviceRequest->title ?? '') }}" required>
                    <div class="error-message" id="title-error"></div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Client <span class="text-danger">*</span></label>
                    <div class="dropdown-search">
                        <input type="text" class="form-control" id="client" name="client_display"
                            placeholder="Search or select client..." autocomplete="off" data-bs-toggle="dropdown"
                            aria-expanded="false" value="{{ old('client_display', $client_name ?? '') }}">
                        <input type="hidden" name="client_id" id="client_id" value="{{ old('client_id', $serviceRequest->client_id ?? '') }}">
                        <ul class="dropdown-menu" id="clientDropdown">
                            @foreach ($clients as $client)
                                <li><a class="dropdown-item" href="#" data-value="{{ $client->id }}" 
                                       data-text="{{ $client->title }} {{ $client->first_name }} {{ $client->last_name }}">{{ $client->title }} {{ $client->first_name }} {{ $client->last_name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="error-message" id="client_id-error"></div>
                </div>

                <div class="mb-4">
                    <small class="text-muted">
                        Requested on<br>
                        {{ date('F j, Y') }}
                    </small>
                </div>
                <div class="mb-4">
                    <h6 class="fw-bold mb-3">Overview</h6>
                    <div>
                        <label class="form-label">Service Details <span class="text-danger">*</span></label>
                        <small class="text-muted d-block mb-2">Please provide as much information as you can</small>
                        <textarea name="service_details" class="form-control" rows="4" 
                                  placeholder="Enter service details..." required>{{ old('service_details', $serviceRequest->service_details ?? '') }}</textarea>
                        <div class="error-message" id="service_details-error"></div>
                    </div>
                </div>
                <div class="mb-4">
                    <h6 class="fw-bold mb-3">Your Availability</h6>
                    <div class="mb-3">
                        <label class="form-label">Which day would be best for an assessment of the work?</label>
                        <input type="date" name="preferred_date_1" class="form-control" 
                               value="{{ old('preferred_date_1', $serviceRequest->preferred_date_1 ?? '') }}">
                        <div class="error-message" id="preferred_date_1-error"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">What is another day that works for you?</label>
                        <input type="date" name="preferred_date_2" class="form-control" 
                               value="{{ old('preferred_date_2', $serviceRequest->preferred_date_2 ?? '') }}">
                        <div class="error-message" id="preferred_date_2-error"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">What are your preferred arrival times?</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="anytime" id="anytime" name="preferred_times[]"
                                   {{ (is_array(old('preferred_times', $serviceRequest->preferred_times ?? [])) && in_array('anytime', old('preferred_times', $serviceRequest->preferred_times ?? []))) ? 'checked' : '' }}>
                            <label class="form-check-label" for="anytime">Any time</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="morning" id="morning" name="preferred_times[]"
                                   {{ (is_array(old('preferred_times', $serviceRequest->preferred_times ?? [])) && in_array('morning', old('preferred_times', $serviceRequest->preferred_times ?? []))) ? 'checked' : '' }}>
                            <label class="form-check-label" for="morning">Morning</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="afternoon" id="afternoon" name="preferred_times[]"
                                   {{ (is_array(old('preferred_times', $serviceRequest->preferred_times ?? [])) && in_array('afternoon', old('preferred_times', $serviceRequest->preferred_times ?? []))) ? 'checked' : '' }}>
                            <label class="form-check-label" for="afternoon">Afternoon</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="evening" id="evening" name="preferred_times[]"
                                   {{ (is_array(old('preferred_times', $serviceRequest->preferred_times ?? [])) && in_array('evening', old('preferred_times', $serviceRequest->preferred_times ?? []))) ? 'checked' : '' }}>
                            <label class="form-check-label" for="evening">Evening</label>
                        </div>
                        <div class="error-message" id="preferred_times-error"></div>
                    </div>
                </div>

                <!-- On-site Assessment -->
                <div class="mb-4">
                    <h6 class="fw-bold mb-3">On-site assessment</h6>
                    <div class="hoverable-section" id="onsiteSection" onclick="toggleOnsiteForm()" 
                         style="{{ old('onsite_assessment', $serviceRequest->onsite_assessment ?? false) ? 'display: none;' : '' }}">
                        <div class="add-icon">
                            <i class="bi bi-plus-circle"></i>
                        </div>
                        <div class="content" id="onsiteContent">
                            <div class="text-center text-muted">
                                <i class="bi bi-calendar-check" style="font-size: 24px;"></i>
                                <p class="mt-2">Visit the property to assess the job before you do the work</p>
                            </div>
                        </div>
                    </div>
                    <div class="inline-form" id="onsiteForm" style="{{ old('onsite_assessment', $serviceRequest->onsite_assessment ?? false) ? 'display: block;' : 'display: none;' }}">
                        <h6 class="fw-bold mb-3">On-site Assessment Details</h6>
                        <input type="hidden" name="onsite_assessment" value="0">
                        <input type="checkbox" name="onsite_assessment" class="d-none" value="1" 
                               {{ old('onsite_assessment', $serviceRequest->onsite_assessment ?? false) ? 'checked' : '' }}>

                        <div class="mb-3">
                            <label class="form-label">Instructions</label>
                            <textarea name="onsite_instructions" class="form-control" rows="3"
                                placeholder="Add instructions for the assessment...">{{ old('onsite_instructions', $serviceRequest->onsite_instructions ?? '') }}</textarea>
                            <div class="error-message" id="onsite_instructions-error"></div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Schedule</label>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="scheduleOption" id="scheduleNow" 
                                       {{ old('onsite_schedule_later', $serviceRequest->onsite_schedule_later ?? false) ? '' : 'checked' }}
                                       onclick="toggleScheduleOptions()">
                                <label class="form-check-label" for="scheduleNow">
                                    Schedule now
                                </label>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="scheduleOption" id="scheduleLater"
                                       {{ old('onsite_schedule_later', $serviceRequest->onsite_schedule_later ?? false) ? 'checked' : '' }}
                                       onclick="toggleScheduleOptions()">
                                <label class="form-check-label" for="scheduleLater">
                                    I'll schedule this later
                                </label>
                            </div>

                            <div id="scheduleInputs" class="{{ old('onsite_schedule_later', $serviceRequest->onsite_schedule_later ?? false) ? 'schedule-disabled' : '' }}">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Date</label>
                                        <input type="date" name="onsite_date" class="form-control" 
                                               value="{{ request('date') ?? old('onsite_date', $serviceRequest->onsite_date ?? '') }}">
                                        <div class="error-message" id="onsite_date-error"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Time</label>
                                        <input type="time" name="onsite_time" class="form-control" 
                                               value="{{ old('onsite_time', $serviceRequest->onsite_time ?? '') }}">
                                        <div class="error-message" id="onsite_time-error"></div>
                                    </div>
                                </div>

                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="anytimeSchedule" name="onsite_anytime"
                                           {{ old('onsite_anytime', $serviceRequest->onsite_anytime ?? false) ? 'checked' : '' }}
                                           onclick="toggleTimeInputs()">
                                    <label class="form-check-label" for="anytimeSchedule">
                                        Any time
                                    </label>
                                </div>

                                <div id="timeInputs" style="{{ old('onsite_anytime', $serviceRequest->onsite_anytime ?? false) ? 'display: none;' : '' }}">
                                    <label class="form-label">Preferred Time Range</label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="time" name="onsite_start_time" class="form-control" 
                                                   placeholder="Start time" value="{{ old('onsite_start_time', $serviceRequest->onsite_start_time ?? '') }}">
                                            <div class="error-message" id="onsite_start_time-error"></div>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="time" name="onsite_end_time" class="form-control" 
                                                   placeholder="End time" value="{{ old('onsite_end_time', $serviceRequest->onsite_end_time ?? '') }}">
                                            <div class="error-message" id="onsite_end_time-error"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Assign to</label>
                            <select name="assigned_to" class="form-control">
                                <option value="">Select user...</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" 
                                            {{ old('assigned_to', $serviceRequest->assigned_to ?? '') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="error-message" id="assigned_to-error"></div>
                        </div>
                    </div>
                </div>

                <!-- Notes -->
                <div class="mb-4">
                    <h6 class="fw-bold mb-3">Notes</h6>
                    <div class="hoverable-section" id="notesSection" onclick="toggleNotesForm()" 
                         style="{{ old('notes', $serviceRequest->notes ?? '') ? 'display: none;' : '' }}">
                        <div class="add-icon">
                            <i class="bi bi-plus-circle"></i>
                        </div>
                        <div class="content" id="notesContent">
                            <div class="text-center text-muted">
                                <i class="bi bi-chat-square-text" style="font-size: 24px;"></i>
                                <p class="mt-2">Add notes or attach files</p>
                            </div>
                        </div>
                    </div>
                    <div class="inline-form" id="notesForm" style="{{ old('notes', $serviceRequest->notes ?? '') ? 'display: block;' : 'display: none;' }}">
                        <div class="mb-3">
                            <label class="form-label">Notes</label>
                            <textarea name="notes" id="noteText" class="form-control" rows="4" 
                                      placeholder="Leave an internal note for yourself or a team member">{{ old('notes', $serviceRequest->notes ?? '') }}</textarea>
                            <div class="error-message" id="notes-error"></div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Attachments</label>
                            <div class="file-upload-area" onclick="document.getElementById('fileInput').click()">
                                <i class="bi bi-paperclip me-2"></i>
                                Attach files or photos
                                <input type="file" id="fileInput" name="attachments[]" multiple 
                                       accept="image/*,.pdf,.doc,.docx" style="display: none;">
                            </div>
                            <div id="selectedFiles"></div>
                            <div class="error-message" id="attachments-error"></div>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Fixed Bottom Bar -->
    <div class="bottom-bar">
        <div class="container d-flex justify-content-end gap-2">
            <button type="button" class="btn btn-secondary" onclick="window.location.href='{{ route('requests.index') }}'">Cancel</button>
            <button type="button" class="btn btn-success" id="saveRequestBtn">
                <span class="btn-text">{{ isset($serviceRequest) ? 'Update Request' : 'Save Request' }}</span>
                <span class="spinner-border spinner-border-sm d-none" id="loadingSpinner"></span>
            </button>
        </div>
    </div>

@endsection
@push('scripts')
    <script>
        let selectedFiles = [];

        // Client dropdown functionality
        document.addEventListener('DOMContentLoaded', function () {
            const clientInput = document.getElementById('client');
            const clientIdInput = document.getElementById('client_id');
            const dropdown = document.getElementById('clientDropdown');
            const dropdownItems = dropdown.querySelectorAll('.dropdown-item');

            clientInput.addEventListener('focus', function () {
                showDropdown();
            });

            clientInput.addEventListener('input', function () {
                const searchTerm = this.value.toLowerCase();
                filterDropdownItems(searchTerm);
                showDropdown();
            });

            dropdownItems.forEach(item => {
                item.addEventListener('click', function (e) {
                    e.preventDefault();
                    clientInput.value = this.dataset.text;
                    clientIdInput.value = this.dataset.value;
                    hideDropdown();
                });
            });

            document.addEventListener('click', function (e) {
                if (!e.target.closest('.dropdown-search')) {
                    hideDropdown();
                }
            });

            function showDropdown() {
                dropdown.classList.add('show');
                clientInput.setAttribute('aria-expanded', 'true');
            }

            function hideDropdown() {
                dropdown.classList.remove('show');
                clientInput.setAttribute('aria-expanded', 'false');
            }

            function filterDropdownItems(searchTerm) {
                let hasVisibleItems = false;
                dropdownItems.forEach(item => {
                    if (item.dataset.text.toLowerCase().includes(searchTerm)) {
                        item.style.display = 'block';
                        hasVisibleItems = true;
                    } else {
                        item.style.display = 'none';
                    }
                });
            }
        });

        // Toggle forms
        function toggleOnsiteForm() {
            const onSiteForm = document.getElementById('onsiteForm');
            const onSiteArea = document.getElementById('onsiteSection');
            const onsiteCheckbox = document.querySelector('input[name="onsite_assessment"][value="1"]');

            onSiteForm.style.display = 'block';
            onSiteArea.style.display = 'none';
            onsiteCheckbox.checked = true;
        }

        function toggleNotesForm() {
            const notesForm = document.getElementById('notesForm');
            const notesArea = document.getElementById('notesSection');

            notesForm.style.display = 'block';
            notesArea.style.display = 'none';
        }
        

        function toggleScheduleOptions() {
            const scheduleLater = document.getElementById('scheduleLater');
            const scheduleInputs = document.getElementById('scheduleInputs');
            const anytimeSchedule = document.getElementById('anytimeSchedule');

            if (scheduleLater.checked) {
                scheduleInputs.classList.add('schedule-disabled');
                anytimeSchedule.checked = false;
            } else {
                scheduleInputs.classList.remove('schedule-disabled');
            }
        }

        function toggleTimeInputs() {
            const anytimeSchedule = document.getElementById('anytimeSchedule');
            const timeInputs = document.getElementById('timeInputs');
            const scheduleLater = document.getElementById('scheduleLater');

            if (anytimeSchedule.checked) {
                timeInputs.style.display = 'none';
                scheduleLater.checked = false;
                document.getElementById('scheduleInputs').classList.remove('schedule-disabled');
            } else {
                timeInputs.style.display = 'block';
            }
        }

        // File handling
        function handleFiles(files) {
            selectedFiles = [...selectedFiles, ...Array.from(files)];
            displaySelectedFiles();
        }

        function displaySelectedFiles() {
            const container = document.getElementById('selectedFiles');
            container.innerHTML = '';

            if (selectedFiles.length > 0) {
                const title = document.createElement('h6');
                title.className = 'fw-bold mb-2';
                title.textContent = 'Selected Files:';
                container.appendChild(title);

                selectedFiles.forEach((file, index) => {
                    const fileItem = document.createElement('div');
                    fileItem.className = 'file-item d-flex justify-content-between align-items-center p-2 border rounded mb-2';
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

        // File drag and drop
        const fileUploadArea = document.querySelector('.file-upload-area');
        if (fileUploadArea) {
            fileUploadArea.addEventListener('dragover', (e) => {
                e.preventDefault();
                fileUploadArea.style.borderColor = '#007bff';
            });

            fileUploadArea.addEventListener('dragleave', (e) => {
                e.preventDefault();
                fileUploadArea.style.borderColor = '#dee2e6';
            });

            fileUploadArea.addEventListener('drop', (e) => {
                e.preventDefault();
                fileUploadArea.style.borderColor = '#dee2e6';
                const files = e.dataTransfer.files;
                handleFiles(files);
            });
        }

        // File input change
        document.getElementById('fileInput').addEventListener('change', function(e) {
            handleFiles(e.target.files);
        });

        // Form submission
        document.getElementById('saveRequestBtn').addEventListener('click', function() {
            submitForm();
        });

        function submitForm() {
            const form = document.getElementById('requestForm');
            const formData = new FormData(form);
            const saveBtn = document.getElementById('saveRequestBtn');
            const btnText = document.querySelector('.btn-text');
            const loadingSpinner = document.getElementById('loadingSpinner');

            // Clear previous errors
            clearErrors();

            // Show loading state
            saveBtn.disabled = true;
            btnText.textContent = '{{ isset($serviceRequest) ? "Updating..." : "Saving..." }}';
            loadingSpinner.classList.remove('d-none');

            // Add selected files to form data
            selectedFiles.forEach((file, index) => {
                formData.append('attachments[]', file);
            });

            const url = '{{ isset($serviceRequest) ? route("requests.update", $serviceRequest->id) : route("requests.store") }}';
            const method = '{{ isset($serviceRequest) ? "PUT" : "POST" }}';

            fetch(url, {
                method: method,
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message
                    showAlert('success', data.message);
                    
                    // Redirect to index page after a short delay
                    setTimeout(() => {
                        window.location.href = '{{ route("requests.index") }}';
                    }, 1500);
                } else {
                    // Show error message
                    showAlert('danger', data.message);
                    
                    // Show validation errors if any
                    if (data.errors) {
                        showValidationErrors(data.errors);
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('danger', 'An error occurred while saving the request.');
            })
            .finally(() => {
                // Reset button state
                saveBtn.disabled = false;
                btnText.textContent = '{{ isset($serviceRequest) ? "Update Request" : "Save Request" }}';
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
            
            // Auto remove after 5 seconds
            setTimeout(() => {
                if (alertDiv.parentNode) {
                    alertDiv.remove();
                }
            }, 5000);
        }
    </script>
@endpush