<!-- Jobs List Section -->
<div class="ui-section jobs-list-section">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">
            <i class="fas fa-briefcase me-2"></i>Your Jobs
        </h3>
        <a href="{{ route('requests.create') }}" class="btn btn-primary-custom">
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
    
    <!-- Jobs List -->
    <div class="jobs-list">
        @forelse($jobs as $job)
            <div class="job-card mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-7">
                                <h6 class="card-title mb-1">{{ $job->title ?? 'Untitled Job' }}</h6>
                                <p class="card-text text-muted mb-1">
                                    <i class="fas fa-user me-1"></i>{{ $job->client ?? 'No Client' }}
                                    <span class="mx-2">•</span>
                                    <i class="fas fa-hashtag me-1"></i>#{{ $job->job_number }}
                                </p>
                                <small class="text-muted">
                                    <i class="fas fa-calendar me-1"></i>{{ $job->schedule_date ? $job->schedule_date->format('M d, Y') : 'No Date' }}
                                    @if($job->start_time)
                                        <span class="mx-2">•</span>
                                        <i class="fas fa-clock me-1"></i>{{ \Carbon\Carbon::parse($job->start_time)->format('g:i A') }}
                                    @endif
                                </small>
                            </div>
                            <div class="col-md-5 text-end">
                                <div class="d-flex align-items-center justify-content-end gap-2 mb-2">
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
                                    
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('jobs.edit', $job->id) }}" class="btn btn-sm btn-outline-primary" title="Edit Job">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteJob({{ $job->id }})" title="Delete Job">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                <div>
                                    <small class="text-muted">${{ number_format($job->total_price, 2) }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-5">
                <i class="fas fa-briefcase fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">No jobs found</h5>
                <p class="text-muted">Create your first job to get started.</p>
                <a href="{{ route('requests.create') }}" class="btn btn-primary-custom">
                    <i class="fas fa-plus me-2"></i>Create New Request
                </a>
            </div>
        @endforelse
    </div>
    
    <!-- Empty State (hidden by default) -->
    <div class="empty-state text-center py-5" style="display: none;">
        <i class="fas fa-search fa-3x text-muted mb-3"></i>
        <h5 class="text-muted">No Request found</h5>
        <p class="text-muted">Try adjusting your search or filter criteria.</p>
    </div>
</div>