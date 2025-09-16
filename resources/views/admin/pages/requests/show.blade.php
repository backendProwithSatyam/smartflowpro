@extends('admin.include.master')
@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .request-container {
            max-width: 1000px;
            margin: 0 auto;
        }
        
        .request-header {
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
        
        .status-pending { background-color: #fef3c7; color: #92400e; }
        .status-in_progress { background-color: #dbeafe; color: #1e40af; }
        .status-completed { background-color: #d1fae5; color: #065f46; }
        .status-cancelled { background-color: #fee2e2; color: #991b1b; }
        
        .info-card {
            background: #fff;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid #f8f9fa;
        }
        
        .info-row:last-child {
            border-bottom: none;
        }
        
        .info-label {
            font-weight: 600;
            color: #495057;
            min-width: 150px;
        }
        
        .info-value {
            color: #212529;
            flex: 1;
            text-align: right;
        }
        
        .preferred-times {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }
        
        .time-badge {
            background: #e9ecef;
            color: #495057;
            padding: 0.25rem 0.75rem;
            border-radius: 1rem;
            font-size: 0.75rem;
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
        
        .onsite-details {
            background: #e7f3ff;
            border: 1px solid #b3d9ff;
            border-radius: 6px;
            padding: 1rem;
            margin-top: 0.5rem;
        }
        
        .notes-section {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 6px;
            padding: 1rem;
            margin-top: 0.5rem;
        }
    </style>
@endpush

@section('content')
<div class="container mt-4">
    <div class="request-container">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-0">Request Details</h2>
                <p class="text-muted mb-0">Service Request #{{ $request->id }}</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('requests.edit', $request->id) }}" class="btn btn-primary">
                    <i class="bi bi-pencil me-1"></i>
                    Edit Request
                </a>
                <a href="{{ route('requests.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i>
                    Back to Requests
                </a>
            </div>
        </div>

        <!-- Request Header -->
        <div class="request-header">
            <div class="row">
                <div class="col-md-8">
                    <h3 class="mb-3">{{ $request->title }}</h3>
                    <p class="text-muted mb-0">{{ $request->service_details }}</p>
                </div>
                
                <div class="col-md-4">
                    <div class="text-end">
                        <div class="mb-2">
                            <span class="status-badge status-{{ $request->status }}">
                                {{ ucfirst(str_replace('_', ' ', $request->status)) }}
                            </span>
                        </div>
                        <div class="mb-2">
                            <strong>Created:</strong> {{ $request->created_at->format('M j, Y g:i A') }}
                        </div>
                        @if($request->updated_at != $request->created_at)
                            <div class="mb-2">
                                <strong>Updated:</strong> {{ $request->updated_at->format('M j, Y g:i A') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Client Information -->
        <div class="info-card">
            <h5 class="fw-bold mb-3">
                <i class="bi bi-person me-2"></i>
                Client Information
            </h5>
            @if($request->client)
                <div class="info-row">
                    <span class="info-label">Name:</span>
                    <span class="info-value">{{ $request->client->title }} {{ $request->client->first_name }} {{ $request->client->last_name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Email:</span>
                    <span class="info-value">{{ $request->client->email }}</span>
                </div>
                @if($request->client->phone)
                    <div class="info-row">
                        <span class="info-label">Phone:</span>
                        <span class="info-value">{{ $request->client->phone }}</span>
                    </div>
                @endif
                @if($request->client->address)
                    <div class="info-row">
                        <span class="info-label">Address:</span>
                        <span class="info-value">{{ $request->client->address }}</span>
                    </div>
                @endif
            @else
                <p class="text-muted">No client information available</p>
            @endif
        </div>

        <!-- Service Details -->
        <div class="info-card">
            <h5 class="fw-bold mb-3">
                <i class="bi bi-gear me-2"></i>
                Service Details
            </h5>
            <div class="info-row">
                <span class="info-label">Service Details:</span>
                <span class="info-value">{{ $request->service_details }}</span>
            </div>
            
            @if($request->preferred_date_1)
                <div class="info-row">
                    <span class="info-label">Preferred Date 1:</span>
                    <span class="info-value">{{ $request->preferred_date_1->format('M j, Y') }}</span>
                </div>
            @endif
            
            @if($request->preferred_date_2)
                <div class="info-row">
                    <span class="info-label">Preferred Date 2:</span>
                    <span class="info-value">{{ $request->preferred_date_2->format('M j, Y') }}</span>
                </div>
            @endif
            
            @if($request->preferred_times && count($request->preferred_times) > 0)
                <div class="info-row">
                    <span class="info-label">Preferred Times:</span>
                    <div class="info-value">
                        <div class="preferred-times">
                            @foreach($request->preferred_times as $time)
                                <span class="time-badge">{{ ucfirst(str_replace('_', ' ', $time)) }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Onsite Assessment -->
        @if($request->onsite_assessment)
            <div class="info-card">
                <h5 class="fw-bold mb-3">
                    <i class="bi bi-calendar-check me-2"></i>
                    Onsite Assessment
                </h5>
                <div class="info-row">
                    <span class="info-label">Required:</span>
                    <span class="info-value">
                        <span class="badge bg-info">Yes</span>
                    </span>
                </div>
                
                @if($request->onsite_instructions)
                    <div class="info-row">
                        <span class="info-label">Instructions:</span>
                        <span class="info-value">{{ $request->onsite_instructions }}</span>
                    </div>
                @endif
                
                @if($request->onsite_schedule_later)
                    <div class="info-row">
                        <span class="info-label">Schedule Later:</span>
                        <span class="info-value">
                            <span class="badge bg-warning">Yes</span>
                        </span>
                    </div>
                @endif
                
                @if($request->onsite_anytime)
                    <div class="info-row">
                        <span class="info-label">Anytime:</span>
                        <span class="info-value">
                            <span class="badge bg-success">Yes</span>
                        </span>
                    </div>
                @endif
                
                @if($request->onsite_date)
                    <div class="info-row">
                        <span class="info-label">Scheduled Date:</span>
                        <span class="info-value">{{ $request->onsite_date->format('M j, Y') }}</span>
                    </div>
                @endif
                
                @if($request->onsite_time)
                    <div class="info-row">
                        <span class="info-label">Scheduled Time:</span>
                        <span class="info-value">{{ $request->onsite_time }}</span>
                    </div>
                @endif
                
                @if($request->onsite_start_time && $request->onsite_end_time)
                    <div class="info-row">
                        <span class="info-label">Time Range:</span>
                        <span class="info-value">{{ $request->onsite_start_time }} - {{ $request->onsite_end_time }}</span>
                    </div>
                @endif
            </div>
        @endif

        <!-- Assignment -->
        <div class="info-card">
            <h5 class="fw-bold mb-3">
                <i class="bi bi-person-check me-2"></i>
                Assignment
            </h5>
            <div class="info-row">
                <span class="info-label">Assigned To:</span>
                <span class="info-value">
                    @if($request->assignedUser)
                        {{ $request->assignedUser->name }}
                    @else
                        <span class="text-muted">Unassigned</span>
                    @endif
                </span>
            </div>
        </div>

        <!-- Notes -->
        @if($request->notes)
            <div class="info-card">
                <h5 class="fw-bold mb-3">
                    <i class="bi bi-sticky me-2"></i>
                    Notes
                </h5>
                <div class="notes-section">
                    <p class="mb-0">{{ $request->notes }}</p>
                </div>
            </div>
        @endif

        <!-- Attachments -->
        @if($request->attachments && count($request->attachments) > 0)
            <div class="info-card">
                <h5 class="fw-bold mb-3">
                    <i class="bi bi-paperclip me-2"></i>
                    Attachments
                </h5>
                @foreach($request->attachments as $attachment)
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
        @endif

        <!-- Request Actions -->
        <div class="info-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="fw-bold mb-1">Request Actions</h6>
                    <p class="text-muted mb-0">Manage this service request</p>
                </div>
                <div class="d-flex gap-2">
                    @if($request->status === 'pending')
                        <button class="btn btn-primary" onclick="updateStatus('in_progress')">
                            <i class="bi bi-play-circle me-1"></i>
                            Start Work
                        </button>
                    @endif
                    
                    @if($request->status === 'in_progress')
                        <button class="btn btn-success" onclick="updateStatus('completed')">
                            <i class="bi bi-check-circle me-1"></i>
                            Mark Complete
                        </button>
                    @endif
                    
                    @if($request->status === 'completed')
                        <button class="btn btn-warning" onclick="updateStatus('in_progress')">
                            <i class="bi bi-arrow-counterclockwise me-1"></i>
                            Reopen
                        </button>
                    @endif
                    
                    @if($request->status !== 'cancelled')
                        <button class="btn btn-danger" onclick="updateStatus('cancelled')">
                            <i class="bi bi-x-circle me-1"></i>
                            Cancel Request
                        </button>
                    @endif
                    
                    <button class="btn btn-outline-danger" onclick="deleteRequest()">
                        <i class="bi bi-trash me-1"></i>
                        Delete Request
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function updateStatus(status) {
        const statusText = status.charAt(0).toUpperCase() + status.slice(1).replace('_', ' ');
        
        Swal.fire({
            title: 'Update Status',
            text: `Are you sure you want to change the status to ${statusText}?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: `Yes, change to ${statusText}`,
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/requests/{{ $request->id }}/status`, {
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
                            text: `Request status updated to ${statusText}`,
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

    function deleteRequest() {
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
                fetch('/requests/{{ $request->id }}', {
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
                            text: 'Request has been deleted successfully.',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href = '{{ route("requests.index") }}';
                        });
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: data.message || 'Failed to delete request',
                            icon: 'error'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        title: 'Error!',
                        text: 'An error occurred while deleting the request',
                        icon: 'error'
                    });
                });
            }
        });
    }
</script>
@endpush

