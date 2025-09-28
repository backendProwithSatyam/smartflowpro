@extends('admin.include.master')
@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 1rem;
            font-size: 0.75rem;
            font-weight: 500;
        }
        .status-pending { background-color: #fef3c7; color: #92400e; }
        .status-in_progress { background-color: #dbeafe; color: #1e40af; }
        .status-completed { background-color: #d1fae5; color: #065f46; }
        .status-cancelled { background-color: #fee2e2; color: #991b1b; }
        
        .table-actions {
            white-space: nowrap;
        }
        
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
        }
         .btn-primary-custom {
  background-color: #388523;
  color:#fff
}
.btn-primary-custom:hover{
    background-color: #fff;
    color:#388523;
    border: 1px solid #388523;
}

 .card-no-data{
 background-image: url('https://secure.getjobber.com/assets_remix/zeroStateBackgroundLight-BZNBrncU.webp');
 height: 100%;
 background-repeat: no-repeat;
 background-position: center;
 background-size: cover;
 border: none;
 box-shadow: none;
 }
 .card{
    border: none;
    box-shadow: none;
 }
  .card-middle{
        background-color: hsl(45, 20%, 97%);
        border-radius: 10px;
        margin: auto;
        width: 50%;
      
    }
   
    .btn-primary-custom{
        background-color: #388523;
    }

    .card-heading{
        color: #111827;
        font-weight: 700;
        font-size: 20px;
        margin-top: 1rem;
        margin-bottom: 0.5rem;
        font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif
    }
    .card-middle p{
        font-size: 16px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        font-weight: 400;
         color: #111827;
         padding:10px 40px;
    }
    </style>
@endpush

@section('content')
<div class="container mt-2">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0">Service Requests</h4>
            <p class="text-muted mb-0">Manage your service requests</p>
        </div>
        <a href="{{ route('requests.create') }}" class="btn btn-primary-custom">
            <i class="bi bi-plus-circle me-1"></i>
            New Request
        </a>
    </div>
      
        </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            @if($requests->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Client</th>
                                <th>Status</th>
                                <th>Preferred Date</th>
                                <th>Onsite Assessment</th>
                                <th>Assigned To</th>
                                <th>Created</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($requests as $request)
                                <tr>
                                    <td>
                                        <div class="fw-bold">{{ $request->title }}</div>
                                        <small class="text-muted">{{ Str::limit($request->service_details, 50) }}</small>
                                    </td>
                                    <td>
                                        @if($request->client)
                                            <div>{{ $request->client->title }} {{ $request->client->first_name }} {{ $request->client->last_name }}</div>
                                            <small class="text-muted">{{ $request->client->email }}</small>
                                        @else
                                            <span class="text-muted">No client</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="status-badge status-{{ $request->status }}">
                                            {{ ucfirst(str_replace('_', ' ', $request->status)) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($request->preferred_date_1)
                                            <div>{{ $request->preferred_date_1->format('M j, Y') }}</div>
                                            @if($request->preferred_date_2)
                                                <small class="text-muted">Alt: {{ $request->preferred_date_2->format('M j, Y') }}</small>
                                            @endif
                                        @else
                                            <span class="text-muted">Not set</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($request->onsite_assessment)
                                            <span class="badge bg-info">
                                                <i class="bi bi-calendar-check me-1"></i>
                                                Yes
                                            </span>
                                            @if($request->onsite_date)
                                                <div class="small text-muted">{{ $request->onsite_date->format('M j, Y') }}</div>
                                            @endif
                                        @else
                                            <span class="text-muted">No</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($request->assignedUser)
                                            <div>{{ $request->assignedUser->name }}</div>
                                        @else
                                            <span class="text-muted">Unassigned</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div>{{ $request->created_at->format('M j, Y') }}</div>
                                        <small class="text-muted">{{ $request->created_at->format('g:i A') }}</small>
                                    </td>
                                    <td class="table-actions">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('requests.show', $request->id) }}" class="btn btn-outline-info btn-sm" title="View">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('requests.edit', $request->id) }}" class="btn btn-outline-primary btn-sm" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button" class="btn btn-outline-danger btn-sm" title="Delete" 
                                                    onclick="deleteRequest({{ $request->id }}, this)">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $requests->links() }}
                </div>
            @else
                <div class="card-no-data text-center">
            <div class="card-middle py-5">
                  <img src="/img/job.jpg" alt="" height="200px">
                       <i class="fas fa-clipboard-list" style="font-size: 55px"></i>
                <h4 class="card-heading">No requests found</h4>
                <p>You haven't created any service requests yet.</p>
                <a href="{{ route('requests.create') }}" class="btn btn-primary-custom">
                    <i class="bi bi-plus-circle me-1"></i>
                    Create Your First Request
                </a>
            </div>

           </div>
            @endif
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function deleteRequest(id, buttonElement) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
            showLoaderOnConfirm: true,
            preConfirm: () => {
                return fetch(`/requests/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .catch(error => {
                    Swal.showValidationMessage(`Request failed: ${error.message}`);
                });
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed) {
                if (result.value && result.value.success) {
                    // Remove the row from the table
                    const row = buttonElement.closest('tr');
                    row.style.transition = 'opacity 0.3s ease';
                    row.style.opacity = '0';
                    
                    setTimeout(() => {
                        row.remove();
                        
                        // Check if table is empty and show message
                        const tbody = document.querySelector('tbody');
                        if (tbody && tbody.children.length === 0) {
                            const tableContainer = document.querySelector('.table-responsive');
                            tableContainer.innerHTML = `
                                <div class="text-center py-5">
                                    <i class="bi bi-inbox display-1 text-muted"></i>
                                    <h4 class="mt-3 text-muted">No requests found</h4>
                                    <p class="text-muted">You haven't created any service requests yet.</p>
                                    <a href="{{ route('requests.create') }}" class="btn btn-primary">
                                        <i class="bi bi-plus-circle me-1"></i>
                                        Create Your First Request
                                    </a>
                                </div>
                            `;
                        }
                    }, 300);
                    
                    Swal.fire({
                        title: 'Deleted!',
                        text: 'Request has been deleted successfully.',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: result.value ? result.value.message : 'An error occurred while deleting the request.',
                        icon: 'error'
                    });
                }
            }
        });
    }
</script>
@endpush
