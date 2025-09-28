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
        .status-draft { background-color: #f3f4f6; color: #374151; }
        .status-sent { background-color: #dbeafe; color: #1e40af; }
        .status-accepted { background-color: #d1fae5; color: #065f46; }
        .status-rejected { background-color: #fee2e2; color: #991b1b; }
        .status-expired { background-color: #fef3c7; color: #92400e; }
        
        .table-actions {
            white-space: nowrap;
        }
        
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
        }

        .stars {
            color: #fbbf24;
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
    .card-middle{
        background-color: hsl(45, 20%, 97%);
        border-radius: 10px;
        margin: auto;
        width: 50%;
    }
    .card-middle .fa-clipboard-list{
    color: #388523 !important;
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
    .card{
        border: none;
        box-shadow: none
    }

        .btn-primary-custom {
            background-color: #388523;
            border: none;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            margin-right: 1rem;
            transition: background-color 0.3s ease;
        }

        .btn-primary-custom:hover {
            background-color: #388523;
            color: white;
        }


    </style>
@endpush

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-0">Quotes</h2>
            <p class="text-muted mb-0">Manage your quotes and estimates</p>
        </div>
        <a href="{{ route('quotes.create') }}" class="btn btn-primary-custom">
            <i class="bi bi-plus-circle me-1"></i>
            New Quote
        </a>
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
            @if($quotes->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Quote #</th>
                                <th>Client</th>
                                <th>Title</th>
                                <th>Rate</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Salesperson</th>
                                <th>Created</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($quotes as $quote)
                                <tr>
                                    <td>
                                        <div class="fw-bold">{{ $quote->quote_number }}</div>
                                    </td>
                                    <td>
                                        @if($quote->client)
                                            <div>{{ $quote->client->title }} {{ $quote->client->first_name }} {{ $quote->client->last_name }}</div>
                                            <small class="text-muted">{{ $quote->client->email }}</small>
                                        @else
                                            <span class="text-muted">No client</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="fw-bold">{{ $quote->title }}</div>
                                    </td>
                                    <td>
                                        <div class="stars">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="bi bi-star{{ $i <= $quote->rate_opportunity ? '-fill' : '' }}"></i>
                                            @endfor
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-bold">₹{{ number_format($quote->total, 2) }}</div>
                                    </td>
                                    <td>
                                        <span class="status-badge status-{{ $quote->status }}">
                                            {{ ucfirst($quote->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($quote->salespersonUser)
                                            <div>{{ $quote->salespersonUser->name }}</div>
                                        @else
                                            <span class="text-muted">Unassigned</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div>{{ $quote->created_at->format('M j, Y') }}</div>
                                        <small class="text-muted">{{ $quote->created_at->format('g:i A') }}</small>
                                    </td>
                                    <td class="table-actions">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('quotes.show', $quote->id) }}" class="btn btn-outline-info btn-sm" title="View">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('quotes.edit', $quote->id) }}" class="btn btn-outline-primary btn-sm" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button" class="btn btn-outline-danger btn-sm" title="Delete" 
                                                    onclick="deleteQuote({{ $quote->id }}, this)">
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
                    {{ $quotes->links() }}
                </div>
            @else
                <div class="card-no-data text-center">
                    <div class="card-middle py-5">
                      <img src="/img/job.jpg" alt="" height="200px">
                           <i class="fas fa-clipboard-list" style="font-size: 55px"></i>
                    <h4 class="card-heading">No quotes found</h4>
                    <p>You haven't created any quotes yet.</p>
                    <a href="{{ route('quotes.create') }}" class="btn btn-primary-custom">
                        <i class="bi bi-plus-circle me-1"></i>
                        Create Your First Quote
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
    function deleteQuote(id, buttonElement) {
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
                return fetch(`/quotes/${id}`, {
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
                                    <i class="bi bi-file-earmark-text display-1 text-muted"></i>
                                    <h4 class="mt-3 text-muted">No quotes found</h4>
                                    <p class="text-muted">You haven't created any quotes yet.</p>
                                    <a href="{{ route('quotes.create') }}" class="btn btn-primary">
                                        <i class="bi bi-plus-circle me-1"></i>
                                        Create Your First Quote
                                    </a>
                                </div>
                            `;
                        }
                    }, 300);
                    
                    Swal.fire({
                        title: 'Deleted!',
                        text: 'Quote has been deleted successfully.',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: result.value ? result.value.message : 'An error occurred while deleting the quote.',
                        icon: 'error'
                    });
                }
            }
        });
    }
</script>
@endpush
