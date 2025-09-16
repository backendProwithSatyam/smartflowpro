{{-- <div class="create-first-job-overlay">
    <div class="create-first-job-content">
        <div class="create-first-job-section">
            <div class="job-icon">
                <i class="fas fa-clipboard-list"></i>
            </div>
            <h3 class="modal-title">Manage your jobs</h3>
            <p class="modal-text">
                Stay on top of your Residential Cleaning work by creating jobs and adding them to your schedule.
            </p>
            <div class="btn-group-custom">
                <a href="{{ route('jobs.create') }}" class="btn btn-primary-custom">
                    Create Your First Job
                </a>
            </div>
        </div>
    </div>
</div> --}}
<div class="card">
    <div class="card-body">
        <div class="text-center py-5">
            <i class="fas fa-clipboard-list display-1 text-muted"></i>
            <h4 class="mt-3 text-muted">No Job found</h4>
            <p class="text-muted">Stay on top of your Residential Cleaning work by creating jobs and adding them to your
                schedule.</p>
            <a href="{{ route('jobs.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle me-1"></i>
                Create Your First Job
            </a>
        </div>
    </div>
</div>