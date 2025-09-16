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
        .status-paid { background-color: #d1fae5; color: #065f46; }
        .status-overdue { background-color: #fee2e2; color: #991b1b; }
        .status-cancelled { background-color: #fef3c7; color: #92400e; }
        
        .table-actions {
            white-space: nowrap;
        }
        
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
        }
    </style>
@endpush

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-0">Invoices</h2>
            <p class="text-muted mb-0">Manage your invoices and billing</p>
        </div>
        <a href="{{ route('invoices.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i>
            New Invoice
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
            @if($invoices->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Invoice #</th>
                                <th>Client</th>
                                <th>Subject</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Issued Date</th>
                                <th>Due Date</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoices as $invoice)
                                <tr>
                                    <td>
                                        <div class="fw-bold">{{ $invoice->invoice_number }}</div>
                                    </td>
                                    <td>
                                        @if($invoice->client)
                                            <div>{{ $invoice->client->title }} {{ $invoice->client->first_name }} {{ $invoice->client->last_name }}</div>
                                            <small class="text-muted">{{ $invoice->client->email }}</small>
                                        @else
                                            <span class="text-muted">No client</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="fw-bold">{{ $invoice->invoice_subject }}</div>
                                    </td>
                                    <td>
                                        <div class="fw-bold">₹{{ number_format($invoice->total, 2) }}</div>
                                    </td>
                                    <td>
                                        <span class="status-badge status-{{ $invoice->status }}">
                                            {{ ucfirst($invoice->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div>{{ $invoice->issued_date->format('M j, Y') }}</div>
                                    </td>
                                    <td>
                                        @if($invoice->due_date)
                                            <div>{{ $invoice->due_date->format('M j, Y') }}</div>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="table-actions">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('invoices.show', $invoice->id) }}" class="btn btn-outline-info btn-sm" title="View">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('invoices.edit', $invoice->id) }}" class="btn btn-outline-primary btn-sm" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button" class="btn btn-outline-danger btn-sm" title="Delete" 
                                                    onclick="deleteInvoice({{ $invoice->id }}, this)">
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
                    {{ $invoices->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-file-earmark-text display-1 text-muted"></i>
                    <h4 class="mt-3 text-muted">No invoices found</h4>
                    <p class="text-muted">You haven't created any invoices yet.</p>
                    <a href="{{ route('invoices.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-1"></i>
                        Create Your First Invoice
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function deleteInvoice(id, buttonElement) {
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
                return fetch(`/invoices/${id}`, {
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
                                    <h4 class="mt-3 text-muted">No invoices found</h4>
                                    <p class="text-muted">You haven't created any invoices yet.</p>
                                    <a href="{{ route('invoices.create') }}" class="btn btn-primary">
                                        <i class="bi bi-plus-circle me-1"></i>
                                        Create Your First Invoice
                                    </a>
                                </div>
                            `;
                        }
                    }, 300);
                    
                    Swal.fire({
                        title: 'Deleted!',
                        text: 'Invoice has been deleted successfully.',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: result.value ? result.value.message : 'An error occurred while deleting the invoice.',
                        icon: 'error'
                    });
                }
            }
        });
    }
</script>
@endpush
