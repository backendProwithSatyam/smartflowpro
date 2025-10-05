@extends('admin.include.master')
@section('content')
    <div class="card-no-data">
        <div class="card">
            <div class="text-center py-5 card-middle">
                <img src="/img/job.jpg" alt="" height="200px">
                <i class="fas fa-clipboard-list" style="font-size: 55px"></i>
                <h3 class="card-heading">All your clients in one place</h3>
                <p>Keep your client details organized and your day running smoothly with Jobber's Bin Cleaning client tools.</p>
                <a href="{{ route('clients.create') }}" class="btn btn-custom">
                    <i class="fas fa-plus-circle me-1"></i>
                    Create Your First Client
                </a>
            </div>
        </div>
    </div>
@endsection
