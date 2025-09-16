@extends('admin.include.master')
@section('content')
    <div class="d-flex justify-content-center align-items-center" style="min-height: 70vh;">
        <div class="card shadow-lg">
            <div class="card-body">
                <div class="empty-state text-center">
                    <div class="empty-state-icon bg-danger d-flex justify-content-center align-items-center mx-auto mb-3" style="width: 80px; height: 80px; border-radius: 50%;">
                        <i class="fa fa-user-times text-white" style="font-size: 2.5rem;"></i>
                    </div>
                    <h2>All your clients in one place</h2>
                    <p class="lead">
                        Keep your client details organized and your day running smoothly with SmartFlow's Residential
                        Cleaning client tools.
                    </p>
                    <a href="#" class="btn btn-primary mt-4">
                        <i class="fa fa-plus mr-2"></i> Add New Client
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection