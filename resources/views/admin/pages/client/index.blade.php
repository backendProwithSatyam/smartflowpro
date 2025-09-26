@extends('admin.include.master')
@push('styles')
<link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css">
@endpush
@section('content')
<div class="d-flex justify-content-center align-items-center pt-2">
    <div class="container">
        {{-- <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold">Clients</h2>
                <a href="{{ route('clients.create') }}" class="btn btn-success">New Client</a>
    </div> --}}

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-0 fw-bold">Clients</h2>
            <p class="text-muted mb-0">Manage your Clients</p>
        </div>
        <a href="{{ route('clients.create') }}" class="btn btn-primary-custom">New Client</a>
    </div>
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card shadow-none">
                <div class="card-body">
                    <h6 class="fw-bold">New leads (Past 30 days)</h6>
                    <h4>{{ $clients->count() ?? 0 }}</h4>
                    {{-- <span class="badge bg-success">↑ 100%</span> --}}
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-none">
                <div class="card-body">
                    <h6 class="fw-bold">New clients (Past 30 days)</h6>
                    <h4>{{ $clients->count() ?? 0 }}</h4>
                    {{-- <span class="badge bg-secondary">0%</span> --}}
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-none">
                <div class="card-body">
                    <h6 class="fw-bold">Total new clients (YTD)</h6>
                    <h4>{{ $clients->count() ?? 0 }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-none">
                <div class="card-body">
                    <h6 class="fw-bold">Tips</h6>
                    <p class="small">Want free business advice? <a href="#">Learn more</a></p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <h4 class="fw-bold">Filtered clients

        </h4>
    </div>
  <div class="d-flex justify-content-start mb-2 pt-4 pb-4">
    <!-- Filter by tag -->
    <div class="filter-container me-2">
        <div class="dropdown">
            <button onclick="toggleDropdown('dropdownMenuTag')" class="filter-btn">Filter by tag +</button>
            <div id="dropdownMenuTag" class="dropdown-content">
                <input type="text" placeholder="Search tags">
                <p>You don't have any tags yet</p>
            </div>
        </div>
    </div>

    <!-- Status -->
    <div class="filter-container">
        <div class="dropdown">
            <button onclick="toggleDropdown('dropdownMenuStatus')" class="btn btn-status">
                Status: Leads and Active
            </button>
            <div id="dropdownMenuStatus" class="dropdown-content">
                <p><input type="checkbox"> Leads</p>
                <p><input type="checkbox"> Active</p>
                <p><input type="checkbox"> Inactive</p>
                <p><input type="checkbox"> Converted</p>
            </div>
        </div>
    </div>
</div>


    <div class="table-responsive">
        <table id="clientsTable" class="table">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Address</th>
                    <th scope="col">Tags</th>
                    <th scope="col" class="text-center">Status</th>
                    <th scope="col">Last Activity</th>
                    <th scope="col" style="display:none">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($clients as $client)
                <tr data-id="{{ $client->id }}">
                    <td class="fw-bold">
                        <input type="checkbox" class="row-checkbox" />
                        {{ $client->first_name }}
                    </td>
                    <td>{{ $client->address }}</td>
                    <td>
                        @if($client->tags)
                        @foreach(explode(',', $client->tags) as $tag)
                        <span class="badge bg-info text-dark">{{ trim($tag) }}</span>
                        @endforeach
                        @else
                        <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($client->status == 'lead')
                        <span class="badge bg-primary">Lead</span>
                        @elseif($client->status == 'active')
                        <span class="badge bg-success">Active</span>
                        @else
                        <span class="badge bg-secondary">{{ ucfirst($client->status ?? 'pending') }}</span>
                        @endif
                    </td>
                    <td>{{ $client->created_at ? $client->created_at->format('h:i A') : '-' }}</td>

                    <!-- Actions cell: contains the floating row-actions -->
                    <td class="actions-cell">
                        {{-- <button class="btn btn-sm btn-outline-info add-tag"><i class="fa fa-tag"
                                aria-hidden="true"></i></button> <a href="{{ route('clients.edit', $client->id) }}"
                        class="btn btn-sm btn-outline-warning"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                        <button class="btn btn-sm btn-outline-danger delete-client"><i class="fa fa-trash"
                                aria-hidden="true"></i></button> --}}
                        <!-- keep existing fallback buttons hidden (optional) -->
                        <div class="row-actions" role="group" aria-label="Row actions">
                            <!-- Folder icon -->
                            <button class="action-view add-tag"><i class="fa fa-tag" aria-hidden="true"></i></button>

                            <a href="{{ route('clients.edit', $client->id) }}" class="action-view"><i
                                    class="fa fa-pencil" aria-hidden="true"></i></a>
                            <button class="action-view delete-client"><i class="fa fa-trash"
                                    aria-hidden="true"></i></button>

                            <!-- Envelope (mail) icon -->
                            <button type="button" title="Mail" class="action-mail">
                                <svg viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v.217l-8 4.8-8-4.8V4z" />
                                    <path
                                        d="M0 6.383V12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6.383l-7.555 4.533a1 1 0 0 1-1.09 0L0 6.383z" />
                                </svg>
                            </button>

                            <!-- More / three dots -->
                            <a href="{{route('clients.view')}}" title="View" class="action-view">
                                <svg viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M8 3C3.5 3 1 8 1 8s2.5 5 7 5 7-5 7-5-2.5-5-7-5zM8 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6z" />
                                </svg>
                            </a>

                            <!-- optionally keep original inline action buttons but hidden via CSS if you don't need them -->
                            <div class="sr-only d-none">
                                <button class="btn btn-sm btn-outline-info add-tag">Add Tag</button>
                                <a href="{{ route('clients.edit', $client->id) }}"
                                    class="btn btn-sm btn-outline-warning">Edit</a>
                                <button class="btn btn-sm btn-outline-danger delete-client">Delete</button>
                            </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">No clients found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
</div>
<div class="modal fade" id="tagModal" tabindex="-1">
    <div class="modal-dialog">
        <form id="tagForm" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Tags</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="client_id" id="tagClientId">
                    <input id="tagInput" name="tags" placeholder="Type tags and press Enter" />
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Tags</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
<script>
    // Make checkbox selection persistently show actions
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('#clientsTable .row-checkbox').forEach(function(chk) {
            chk.addEventListener('change', function(e) {
                var tr = e.target.closest('tr');
                if (!tr) return;
                if (e.target.checked) tr.classList.add('selected');
                else tr.classList.remove('selected');
            });
            // if some rows are server-rendered as selected, apply the class on load
            if (chk.checked) {
                var tr = chk.closest('tr');
                if (tr) tr.classList.add('selected');
            }
        });
    });
</script>
<script>
    function toggleDropdown() {
        document.getElementById("dropdownMenu").classList.toggle("show");
    }
    // Dropdown band karne ke liye agar bahar click ho
    window.onclick = function(event) {
        if (!event.target.matches('.filter-btn')) {
            let dropdowns = document.getElementsByClassName("dropdown-content");
            for (let i = 0; i < dropdowns.length; i++) {
                let openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
            }
        }
    }
    function toggleDropdown(id) {
    // sabhi dropdown band karo pehle
    let dropdowns = document.getElementsByClassName("dropdown-content");
    for (let i = 0; i < dropdowns.length; i++) {
        dropdowns[i].classList.remove("show");
    }
    // jis button pe click hua uska dropdown open karo
    document.getElementById(id).classList.toggle("show");
}

// dropdown band karna agar bahar click kare
window.onclick = function(event) {
    if (!event.target.matches('.filter-btn') && !event.target.matches('.btn-status')) {
        let dropdowns = document.getElementsByClassName("dropdown-content");
        for (let i = 0; i < dropdowns.length; i++) {
            let openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
            }
        }
    }
}

    $(document).ready(function() {
        let table = $('#clientsTable').DataTable({
            pageLength: 5,
            dom: 'lrtip' // 'l' = length changing, 'r' = processing, 't' = table, 'i' = info, 'p' = pagination
        });
        // Check number of rows in the table
        let rowCount = table.data().count();
        // Show/hide pagination based on 10 rows
        if (rowCount >= 10) {
            $('.dataTables_paginate').show(); // show pagination only if 10 or more rows
        } else {
            $('.dataTables_paginate').hide(); // hide otherwise
        }
        let input = document.querySelector('#tagInput');
        let tagify = new Tagify(input);
        $(document).on('click', '.add-tag', function() {
            let clientId = $(this).closest('tr').data('id');
            $('#tagClientId').val(clientId);
            tagify.removeAllTags();
            $('#tagModal').modal('show');
        });
        $('#tagForm').on('submit', function(e) {
            e.preventDefault();
            let clientId = $('#tagClientId').val();
            let tags = tagify.value.map(t => t.value);
            $.ajax({
                url: "{{ route('clients.addTag') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    client_id: clientId,
                    tags: tags
                },
                success: function(res) {
                    Swal.fire('Success', 'Tags updated successfully', 'success').then(
                        () => {
                            location.reload();
                        });
                }
            });
        });
        $(document).on('click', '.delete-client', function() {
            let clientId = $(this).closest('tr').data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "This client will be deleted permanently!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "/clients/" + clientId,
                        type: "DELETE",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function() {
                            Swal.fire('Deleted!', 'Client has been deleted.',
                                'success').then(() => {
                                location.reload();
                            });
                        }
                    });
                }
            });
        });
    });
</script>
@endpush
@push('styles')
<style>
    .filter-btn {
        font-size: 14px;
        color: #3b3f5c;
        font-weight: 700;
        white-space: normal;
        word-wrap: break-word;
        transition: 0.2s ease-out;
        touch-action: manipulation;
        border-radius: 6px;
        cursor: pointer;
        background-color: #fff;
        will-change: opacity, transform;
        transition: all 0.3s ease-out;
        -webkit-transition: all 0.3s ease-out;
        border: 1px solid #d1d5db;
        border-radius: 30px;
    }

    .btn-status {
        font-size: 14px;
        color: #3b3f5c;
        font-weight: 700;
        white-space: normal;
        word-wrap: break-word;
        transition: 0.2s ease-out;
        touch-action: manipulation;
        border-radius: 6px;
        cursor: pointer;
        background-color: #f1f0e9;
        will-change: opacity, transform;
        transition: all 0.3s ease-out;
        -webkit-transition: all 0.3s ease-out;
        border: 1px solid #d1d5db;
        border-radius: 30px;
    }

    .btn-primary-custom {
        background-color: #388523;
        color: #fff;
        font-weight: bold;
    }

    #clientsTable thead th {
        border: none !important;
    }

    /* Table header style */
    #clientsTable thead th {
        background-color: #fff;
        color: #000;
        border-bottom: 2px solid #dee2e6;

    }

    /* tbody rows ka border-bottom */
    #clientsTable tbody td {
        border-bottom: 1px solid #dee2e6;
        vertical-align: middle;
    }

    /* hover effect */
    #clientsTable tbody tr:hover {
        background-color: #f8f9fa;
    }

    /* Checkbox initially hidden */
    #clientsTable .row-checkbox {
        display: none;
        margin-right: 6px;
    }

    /* Show checkbox on hover */
    #clientsTable tbody tr:hover .row-checkbox {
        display: inline-block;
    }

    #clientsTable thead th {
        border-bottom: 2px solid rgba(0, 0, 0, 0.107) !important;
    }

    #clientsTable thead th {
        color: #000000a8 !important;
        font-weight: 600 !important;
    }

    .row-actions {
        display: none;
        position: absolute;
        right: 200px;
        top: 50%;
        transform: translateY(-50%);
        background: #fff;
        border: 1px solid #dee2e6;
        border-radius: 6px;
        padding: 4px 8px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        z-index: 10;
    }

    /* Show on hover */
    #clientsTable tbody tr:hover .row-actions {
        display: flex;
        gap: 8px;
    }

    .row-checkbox {
        display: none;
        margin-right: 8px;
    }

    #clientsTable tbody tr:hover .row-checkbox,
    #clientsTable tbody tr.selected .row-checkbox {
        display: inline-block;
    }

    /* make the actions cell a positioned container */
    .actions-cell {
        position: relative;
        width: 1px;
        /* shrink-to-fit so absolute box floats over table edge if needed */
    }

    /* floating action box (hidden by default) */
    .row-actions {
        display: none;
        position: absolute;
        right: 100px;
        top: 50%;
        transform: translateY(-50%);
        background: #fff;
        border: 1px solid #e6e6e6;
        border-radius: 8px;
        padding: 6px 8px;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
        gap: 6px;
        align-items: center;
        z-index: 50;
        white-space: nowrap;
    }

    /* show on row hover or if row is selected */
    #clientsTable tbody tr:hover .row-actions,
    #clientsTable tbody tr.selected .row-actions {
        display: flex;
    }

    .row-actions button {
        border: none;
        background: transparent;
        cursor: pointer;
        padding: 6px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .row-actions button:hover {
        background: rgba(13, 110, 253, 0.08);
        color: #0d6efd;
    }

    /* tiny icon sizing */
    .row-actions svg {
        width: 18px;
        height: 18px;
    }

  .filter-container {
    position: relative;
}

.filter-btn, .btn-status {
    padding: 8px 16px;
    border: 1px solid #ccc;
    border-radius: 8px;
    background-color: #f8f8f8;
    cursor: pointer;
    font-size: 14px;
    font-weight: 500;
}

.dropdown-content {
    display: none;
    position: absolute;
    top: 110%;
    left: 0;
    background-color: #fff;
    min-width: 220px;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0px 4px 6px rgba(0,0,0,0.1);
    z-index: 1;
    padding: 8px;
}

.dropdown-content input {
    margin-right: 6px;
}

.dropdown-content.show {
    display: block;
}


</style>
@endpush