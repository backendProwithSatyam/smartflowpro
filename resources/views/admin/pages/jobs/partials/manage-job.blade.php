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

<div class="card-no-data">
<div class="card">
    <div class="text-center py-5 card-middle">
        <img src="/img/job.jpg" alt="" height="200px">
              <i class="fas fa-clipboard-list" style="font-size: 55px"></i>
        <h3 class="card-heading">Create winning jobs</h3>
        <p>Build Residential Cleaning quotes in seconds with tailored descriptions and line items that will help you win
            work.</p>
        <a href="{{ route('jobs.create') }}" class="btn btn-custom">
            <i class="fas fa-plus-circle me-1"></i>
            Create Your First Job
        </a>
    </div>
</div>
</div>
