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
        <div class="text-center py-5 card-middle">
            <img src="/img/job.jpg" alt="" height="200px">
            <h3 class="card-heading">Create winning quotes</h3>
            <p>Build Residential Cleaning quotes in seconds with tailored descriptions and line items that will help you win work.</p>
            <a href="{{ route('jobs.create') }}" class="btn btn-custom">
                <i class="fas fa-plus-circle me-1"></i>
                Create Your First Job
            </a>
        </div>
    </div>
</div>


<style>
    .card{
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

    .btn-custom{
        background-color: #388523;
        color:#fff;
    }

       .btn-custom:hover{
      background-color: #fff;
      color:#2e6e1c;
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