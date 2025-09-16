@extends('admin.include.master')
@push('styles')
    <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css">
@endpush
@section('content')
    <div class="d-flex justify-content-center align-items-center" style="min-height: 70vh;">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold">Clients</h2>
                <a href="{{ route('clients.create') }}" class="btn btn-success">New Client</a>
            </div>
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h6 class="text-muted">New leads (Past 30 days)</h6>
                            <h4>{{ $clients->count() ?? 0 }}</h4>
                            {{-- <span class="badge bg-success">↑ 100%</span> --}}
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h6 class="text-muted">New clients (Past 30 days)</h6>
                            <h4>{{ $clients->count() ?? 0 }}</h4>
                            {{-- <span class="badge bg-secondary">0%</span> --}}
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h6 class="text-muted">Total new clients (YTD)</h6>
                            <h4>{{ $clients->count() ?? 0 }}</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h6 class="text-muted">Tips</h6>
                            <p class="small">Want free business advice? <a href="#">Learn more</a></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <div>
                    <button class="btn btn-outline-secondary btn-sm">Filter by tag</button>
                    <span class="badge bg-light text-dark border">Status: Leads and Active</span>
                </div>
            </div>
            <div class="table-responsive">
                <table id="clientsTable" class="table align-middle table-hover">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Address</th>
                            <th scope="col">Tags</th>
                            <th scope="col">Status</th>
                            <th scope="col">Last Activity</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($clients as $client)
                            <tr data-id="{{ $client->id }}">
                                <td class="fw-bold">{{ $client->first_name }}</td>
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
                                <td>
                                    @if($client->status == 'lead')
                                        <span class="badge bg-primary">Lead</span>
                                    @elseif($client->status == 'active')
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">{{ ucfirst($client->status ?? 'pending') }}</span>
                                    @endif
                                </td>
                                <td>{{ $client->created_at ? $client->created_at->format('h:i A') : '-' }}</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-info add-tag">Add Tag</button>
                                    <a href="{{ route('clients.edit', $client->id) }}"
                                        class="btn btn-sm btn-outline-warning">Edit</a>
                                    <button class="btn btn-sm btn-outline-danger delete-client">Delete</button>
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
        $(document).ready(function () {
            let table = $('#clientsTable').DataTable({
                pageLength: 5
            });
            let input = document.querySelector('#tagInput');
            let tagify = new Tagify(input);
            $(document).on('click', '.add-tag', function () {
                let clientId = $(this).closest('tr').data('id');
                $('#tagClientId').val(clientId);
                tagify.removeAllTags();
                $('#tagModal').modal('show');
            });
            $('#tagForm').on('submit', function (e) {
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
                    success: function (res) {
                        Swal.fire('Success', 'Tags updated successfully', 'success').then(() => {
                            location.reload();
                        });
                    }
                });
            });
            $(document).on('click', '.delete-client', function () {
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
                            data: { _token: "{{ csrf_token() }}" },
                            success: function () {
                                Swal.fire('Deleted!', 'Client has been deleted.', 'success').then(() => {
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