@extends('admin.include.master')
@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        .client-selection-container {
            margin: 0 auto;
            padding: 2rem 0;
        }
        
        .search-section {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            /* box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); */
            margin-bottom: 2rem;
            border:1px solid #dadfe2;
        }
        
        .search-input {
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .search-input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        
        .create-client-btn {
            background: #10b981;
            border: none;
            border-radius: 8px;
            padding: 0.75rem 1.5rem;
            color: white;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .create-client-btn:hover {
            background: #059669;
            transform: translateY(-1px);
        }
        
        .client-item {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 0.75rem;
            cursor: pointer;
            transition: all 0.3s ease;
            background: white;
        }
        
        .client-item:hover {
            border-color: #3b82f6;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transform: translateY(-1px);
        }
        
        .client-item.selected {
            border-color: #3b82f6;
            background: #eff6ff;
        }
        
        .client-avatar {
            width: 40px;
            height: 40px;
            background: #f3f4f6;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6b7280;
            font-size: 1.2rem;
        }
        
        .client-info h6 {
            margin: 0;
            color: #111827;
            font-weight: 600;
        }
        
        .client-info small {
            color: #6b7280;
        }
        
        .activity-text {
            color: #6b7280;
            font-size: 0.875rem;
        }
        
        .no-clients {
            text-align: center;
            padding: 3rem 1rem;
            color: #6b7280;
        }
        
        .no-clients .bi-person-x{
            font-size: 4rem;
            margin-bottom: 1rem;
            color: #d1d5db;
        }

        h1{
            font-weight: 800;
            font-size: 36px;
            color:#032b3a;
        }

       .btn-custom{
        background-color: #388523;
        color:#fff;
        }

    .btn-custom:hover{
        background-color: #fff;
        color:#2e6e1c;
        }

    </style>
@endpush

@section('content')
<div class="container">
    <div class="client-selection-container">
        <div class="mb-4">
            <h1 class="fw-800">New Invoice</h1>
            <p class="text-muted">Which client would you like to create this invoice for?</p>
        </div>

        <div class="search-section">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <input type="text" class="form-control search-input" id="clientSearch" placeholder="Search clients...">
                </div>
                <div class="col-md-1 text-center">
                    <span class="text-muted">or</span>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('clients.create') }}" class="btn btn-custom w-100">
                        <i class="bi bi-plus-circle me-1"></i>
                        Create New Client
                    </a>
                </div>
                <div class="col-lg-12">

            <h5 class="text-primary mb-3 mt-3 fw-bold">Leads</h5>
            <div id="clientList">
                @if($clients->count() > 0)
                    @foreach($clients as $client)
                        <div class="client-item" 
                             data-name="{{ strtolower($client->title . ' ' . $client->first_name . ' ' . $client->last_name) }}"
                             data-email="{{ strtolower($client->email) }}"
                             onclick="selectClient({{ $client->id }}, '{{ $client->title }} {{ $client->first_name }} {{ $client->last_name }}', '{{ $client->email }}')">
                            <div class="d-flex align-items-center">
                                <div class="client-avatar me-3">
                                    <i class="bi bi-person"></i>
                                </div>
                                <div class="client-info flex-grow-1">
                                    <h6>{{ $client->title }} {{ $client->first_name }} {{ $client->last_name }}</h6>
                                    <small>{{ $client->email }}</small>
                                </div>
                                <div class="activity-text">
                                    Activity 3 days ago
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="no-clients">
                        <i class="bi bi-person-x"></i>
                        <h5>No clients found</h5>
                        <p>You haven't added any clients yet.</p>
                        <a href="{{ route('clients.create') }}" class="btn btn-custom">
                            <i class="bi bi-plus-circle"></i>
                            Create Your First Client
                        </a>
                    </div>
                @endif
            </div>
            <div id="noResults" class="no-clients" style="display: none;">
                <i class="bi bi-search"></i>
                <h5>No clients found</h5>
                <p>Try adjusting your search terms.</p>
            </div>
     
                </div>
            </div>
        </div>

     
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Client search functionality
    document.getElementById('clientSearch').addEventListener('input', function() {
        const query = this.value.trim().toLowerCase();
        const clientItems = document.querySelectorAll('.client-item');
        const noResults = document.getElementById('noResults');
        let hasResults = false;

        clientItems.forEach(function(item) {
            const name = item.getAttribute('data-name');
            const email = item.getAttribute('data-email');
            
            if (name.includes(query) || email.includes(query)) {
                item.style.display = 'block';
                hasResults = true;
            } else {
                item.style.display = 'none';
            }
        });

        noResults.style.display = hasResults ? 'none' : 'block';
    });

    function selectClient(clientId, clientName, clientEmail) {
        // Redirect to create invoice page for this client
        window.location.href = `/invoices/create-for-client/${clientId}`;
    }
</script>
@endpush
