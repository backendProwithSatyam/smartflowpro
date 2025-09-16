@extends('admin.include.master')
@section('content')
<div class="container mt-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Job Details</h3>
        <div class="btn-group">
            <a href="{{ route('jobs.edit', $job->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit me-1"></i>Edit</a>
            <button class="btn btn-danger btn-sm" onclick="deleteJob({{ $job->id }})"><i class="fas fa-trash me-1"></i>Delete</button>
            <a href="{{ route('jobs.index') }}" class="btn btn-secondary btn-sm">Back</a>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-3">Summary</h5>
                    <div class="row mb-2">
                        <div class="col-md-6"><strong>Job #:</strong> #{{ $job->job_number }}</div>
                        <div class="col-md-6"><strong>Status:</strong> {{ ucfirst($job->status) }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-6"><strong>Title:</strong> {{ $job->title }}</div>
                        <div class="col-md-6"><strong>Client:</strong> {{ isset($job->client) && $job->client->title ? $job->client->title.' - '.$job->client->first_name.' '.$job->client->last_name : 'No Client' }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-6"><strong>Salesperson:</strong> {{ $job->salesperson ?? '-' }}</div>
                        <div class="col-md-6"><strong>Job type:</strong> {{ $job->job_type }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-6"><strong>Date:</strong> {{ $job->schedule_date ? $job->schedule_date->format('M d, Y') : '-' }}</div>
                        <div class="col-md-6"><strong>Time:</strong>
                            @if($job->anytime)
                                Anytime
                            @elseif($job->start_time)
                                {{ \Carbon\Carbon::parse($job->start_time)->format('g:i A') }} - {{ $job->end_time ? \Carbon\Carbon::parse($job->end_time)->format('g:i A') : '-' }}
                            @else
                                -
                            @endif
                        </div>
                    </div>

                    <hr>
                    <h5 class="card-title mb-3">Products / Services</h5>
                    @if(is_array($job->product_items) && count($job->product_items))
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th class="text-end">Qty</th>
                                        <th class="text-end">Unit Cost</th>
                                        <th class="text-end">Unit Price</th>
                                        <th class="text-end">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($job->product_items as $item)
                                        <tr>
                                            <td>{{ $item['name'] ?? '' }}</td>
                                            <td class="text-end">{{ $item['quantity'] ?? 0 }}</td>
                                            <td class="text-end">${{ number_format((float)($item['unit_cost'] ?? 0), 2) }}</td>
                                            <td class="text-end">${{ number_format((float)($item['unit_price'] ?? 0), 2) }}</td>
                                            <td class="text-end">${{ number_format((float)($item['total'] ?? 0), 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">No items added.</p>
                    @endif

                    <div class="d-flex justify-content-end gap-4 mt-3">
                        <div><strong>Total Cost:</strong> ${{ number_format($job->total_cost, 2) }}</div>
                        <div><strong>Total Price:</strong> ${{ number_format($job->total_price, 2) }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-3">
                <div class="card-body">
                    <h6 class="mb-2">Notes</h6>
                    <div class="text-muted" style="white-space: pre-wrap;">{{ $job->notes ?: '—' }}</div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h6 class="mb-2">Attachments</h6>
                    @if(is_array($job->attachments) && count($job->attachments))
                        <ul class="list-unstyled mb-0">
                            @foreach($job->attachments as $file)
                                <li class="mb-2 d-flex align-items-center justify-content-between">
                                    <div>
                                        <i class="fas fa-paperclip me-1"></i>
                                        {{ $file['filename'] ?? ($file['name'] ?? 'file') }}
                                        <small class="text-muted">{{ isset($file['size']) ? '(' . number_format($file['size']/1024, 1) . ' KB)' : '' }}</small>
                                    </div>
                                    @php($url = isset($file['path']) ? \Illuminate\Support\Facades\Storage::url($file['path']) : null)
                                    @if($url)
                                        <a href="{{ $url }}" target="_blank" class="btn btn-sm btn-outline-primary">View</a>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted mb-0">No attachments.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function deleteJob(jobId) {
    if (!confirm('Are you sure to delete this job?')) return;
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `/jobs/${jobId}`;
    const csrfToken = document.createElement('input');
    csrfToken.type = 'hidden';
    csrfToken.name = '_token';
    csrfToken.value = '{{ csrf_token() }}';
    form.appendChild(csrfToken);
    const methodField = document.createElement('input');
    methodField.type = 'hidden';
    methodField.name = '_method';
    methodField.value = 'DELETE';
    form.appendChild(methodField);
    document.body.appendChild(form);
    form.submit();
}
</script>
@endpush
@endsection


