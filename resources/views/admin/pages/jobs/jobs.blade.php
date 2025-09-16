@extends('admin.include.master')
@push('styles')
    <style>
        .jobs-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #1e3a8a;
            margin: 0;
        }

        .new-job-btn {
            background-color: #22c55e;
            border: none;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .new-job-btn:hover {
            background-color: #16a34a;
            color: white;
        }

        .ui-section {
            background-color: white;
            border-radius: 1rem;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .create-first-job-section {
            text-align: center;
            max-width: 600px;
            margin: 2rem auto;
            position: relative;
            z-index: 10;
        }

        .jobs-list-section {
            max-width: 100%;
        }

        .create-first-job-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.3);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 10;
        }

        .create-first-job-content {
            background-color: white;
            border-radius: 1rem;
            padding: 2rem;
            max-width: 600px;
            width: 90%;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            position: relative;
        }

        .search-icon {
            width: 20px;
            height: 20px;
            background-color: #9ca3af;
            border-radius: 0.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 12px;
            font-weight: bold;
        }

        .job-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem auto;
            position: relative;
        }

        .job-icon::before {
            content: '';
            position: absolute;
            width: 100px;
            height: 100px;
            background: rgba(34, 197, 94, 0.1);
            border-radius: 50%;
            z-index: -1;
        }

        .job-icon i {
            font-size: 2rem;
            color: #22c55e;
        }

        .btn-primary-custom {
            background-color: #22c55e;
            border: none;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            margin-right: 1rem;
            transition: background-color 0.3s ease;
        }

        .btn-primary-custom:hover {
            background-color: #16a34a;
            color: white;
        }

        .btn-secondary-custom {
            background-color: white;
            border: 2px solid #22c55e;
            color: #22c55e;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-secondary-custom:hover {
            background-color: #22c55e;
            color: white;
        }

        .learn-link {
            color: #3b82f6;
            text-decoration: underline;
            font-size: 0.9rem;
            margin-top: 1rem;
            display: inline-block;
        }

        .learn-link:hover {
            color: #1d4ed8;
        }

        .btn-group-custom {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            align-items: center;
        }

        @media (min-width: 768px) {
            .btn-group-custom {
                flex-direction: row;
                justify-content: center;
            }
        }
    </style>
@endpush
@section('content')
<div class="container mt-2">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-0">Jobs</h2>
            <p class="text-muted mb-0">Manage your Jobs</p>
        </div>
        <a href="{{ route('jobs.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle me-1"></i>
            New Job
        </a>
    </div>
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Main Content Area -->
    <div class="position-relative">
        @if(!$hasJobs)
            <!-- Create First Job Overlay (not modal) -->
            @include('admin.pages.jobs.partials.manage-job')
        @else
            <!-- Job List when jobs exist -->
            @include('admin.pages.jobs.partials.job-list')
        @endif
    </div>
</div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function deleteJob(jobId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel'
            }).then((result) => {
                if (result.isConfirmed) {
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
            });
        }

        document.addEventListener('DOMContentLoaded', function () {
            // Handle New Job button click - both buttons redirect to same page
            document.querySelector('.new-job-btn').addEventListener('click', function (e) {
                e.preventDefault();
                window.location.href = "{{ route('jobs.create') }}";
            });

            // Search functionality for jobs list
            @if($hasJobs)
                document.getElementById('jobSearch').addEventListener('input', function () {
                    filterJobs();
                });

                document.getElementById('statusFilter').addEventListener('change', function () {
                    filterJobs();
                });

                function filterJobs() {
                    const searchTerm = document.getElementById('jobSearch').value.toLowerCase();
                    const statusFilter = document.getElementById('statusFilter').value;
                    const jobCards = document.querySelectorAll('.job-card');
                    const emptyState = document.querySelector('.empty-state');
                    let visibleCount = 0;

                    jobCards.forEach(card => {
                        const title = card.querySelector('.card-title').textContent.toLowerCase();
                        const status = card.querySelector('.badge').textContent.toLowerCase();

                        const matchesSearch = title.includes(searchTerm);
                        const matchesStatus = !statusFilter || status.includes(statusFilter);

                        if (matchesSearch && matchesStatus) {
                            card.style.display = 'block';
                            visibleCount++;
                        } else {
                            card.style.display = 'none';
                        }
                    });

                    // Show/hide empty state
                    if (visibleCount === 0) {
                        emptyState.style.display = 'block';
                    } else {
                        emptyState.style.display = 'none';
                    }
                }
            @endif
                                    });
    </script>
@endpush