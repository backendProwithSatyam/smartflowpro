<!-- Jobs List Section -->
<div class="ui-section jobs-list-section">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">
            <i class="fas fa-briefcase me-2"></i>Your Jobs
        </h3>
        <a href="{{ route('jobs.create') }}" class="btn btn-primary-custom">
            <i class="fas fa-plus me-2"></i>Create New Job
        </a>
    </div>
    
    <!-- Search and Filter Section -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
                <input type="text" class="form-control" placeholder="Search jobs..." id="jobSearch">
            </div>
        </div>
        <div class="col-md-4">
            <select class="form-select" id="statusFilter">
                <option value="">All Status</option>
                <option value="pending">Pending</option>
                <option value="in_progress">In Progress</option>
                <option value="completed">Completed</option>
                <option value="cancelled">Cancelled</option>
            </select>
        </div>
    </div>
    
    <!-- Jobs List (Table) -->
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Job #</th>
                    <th>Title</th>
                    <th>Client</th>
                    <th>Schedule</th>
                    <th>Status</th>
                    <th>Total</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jobs as $job)
                    <tr class="job-card">
                        <td>#{{ $job->job_number }}</td>
                        <td>{{ $job->title ?? 'Untitled Job' }}</td>
                        <td>{{ isset($job->client) && $job->client->title ? $job->client->title.' - '.$job->client->first_name.' '.$job->client->last_name : 'No Client' }}</td>
                        <td>
                            {{ $job->schedule_date ? $job->schedule_date->format('M d, Y') : 'No Date' }}
                            @if($job->start_time)
                                • {{ \Carbon\Carbon::parse($job->start_time)->format('g:i A') }}
                            @endif
                        </td>
                        <td>
                            @switch($job->status)
                                @case('pending')
                                    <span class="badge bg-warning">Pending</span>
                                    @break
                                @case('in_progress')
                                    <span class="badge bg-primary">In Progress</span>
                                    @break
                                @case('completed')
                                    <span class="badge bg-success">Completed</span>
                                    @break
                                @case('cancelled')
                                    <span class="badge bg-danger">Cancelled</span>
                                    @break
                                @default
                                    <span class="badge bg-secondary">{{ ucfirst($job->status) }}</span>
                            @endswitch
                        </td>
                        <td>${{ number_format($job->total_price, 2) }}</td>
                        <td class="text-end">
                            <div class="btn-group" role="group">
                                <a href="{{ route('jobs.show', $job->id) }}" class="btn btn-sm btn-outline-secondary" title="View Job">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('jobs.edit', $job->id) }}" class="btn btn-sm btn-outline-primary" title="Edit Job">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteJob({{ $job->id }})" title="Delete Job">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">
                            <div class="text-center py-5">
                                <i class="fas fa-briefcase fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No jobs found</h5>
                                <p class="text-muted">Create your first job to get started.</p>
                                <a href="{{ route('jobs.create') }}" class="btn btn-primary-custom">
                                    <i class="fas fa-plus me-2"></i>Create New Job
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Empty State (hidden by default) -->
    <div class="empty-state text-center py-5" style="display: none;">
        <i class="fas fa-search fa-3x text-muted mb-3"></i>
        <h5 class="text-muted">No jobs found</h5>
        <p class="text-muted">Try adjusting your search or filter criteria.</p>
    </div>
</div>