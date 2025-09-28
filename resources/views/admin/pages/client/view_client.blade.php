@extends('admin.include.master')
@push('styles')
<link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css">
@endpush
@section('content')
@php
// $properties = [
// (object) ["title" => "2BHK Apartment", "type" => "Flat", "location" => "Noida Sector 62", "price" => 4500000],
// (object) ["title" => "Luxury Villa", "type" => "Villa", "location" => "Greater Noida", "price" => 12500000],
// ];
@endphp
<div class="col-lg-12 container-div">
  <div class="left">
    {{-- Profile Header --}}
    <div class="d-flex align-items-center">
      <i class="fa-solid fa-user d-flex justify-content-center align-items-center"
        style="background-color: #f0f0f0; border-radius: 50%; padding: 12px; font-size: 38px; margin-right: 10px;height:80px; width:80px;">
      </i>
      <h1 class="mb-0" style="font-size: 36px; font-weight: 900;">
        {{ $client->title }} {{ $client->first_name }} {{ $client->last_name }}
      </h1>
    </div>

    {{-- Properties --}}
    <div class="section">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 style="margin:0;">Properties</h2>
        {{-- <a href="{{ route('properties.create', $client->id) }}" class="btn btn-success">+ New Property</a> --}}
      </div>

      <div class="properties-grid">
        @forelse($client->properties as $property)
        <div class="property-card">
          <h3>{{ $property->title }}</h3>
          <p><strong>Type:</strong> {{ ucfirst($property->type) }}</p>
          <p><strong>Location:</strong> {{ $property->location }}</p>
          <p><strong>Price:</strong> ₹{{ number_format($property->price, 2) }}</p>
          {{--
        <div class="action-buttons mt-2">
          <a href="{{ route('properties.show', $property->id) }}" class="btn btn-primary btn-sm">View</a>
          <a href="{{ route('properties.edit', $property->id) }}" class="btn btn-secondary btn-sm">Edit</a>
        </div> --}}
      </div>
      @empty
      <p>No properties listed for this client yet</p>
      @endforelse
    </div>
  </div>

  {{-- Contacts --}}
  <div class="section">
    <h2>Contacts</h2>
    <table>
      <tr>
        <th>Name</th>
        <th>Role</th>
        <th>Phone</th>
        <th>Email</th>
      </tr>

      <tr>
        <td>{{ $client->first_name  }}</td>
        <td>{{ $client->role ?? '--' }}</td>
        <td>{{ $client->phone_number }}</td>
        <td>{{ $client->email }}</td>
      </tr>

      {{-- @endif --}}
    </table>
  </div>

  {{-- Overview Tabs --}}
  <div class="section">
    <h2>Overview</h2>
    <div class="tab-menu">
      <div class="tab active" data-tab="active-work">Active Work</div>
      <div class="tab" data-tab="requests">Requests</div>
      <div class="tab" data-tab="quotes">Quotes</div>
      <div class="tab" data-tab="jobs">Jobs</div>
      <div class="tab" data-tab="invoices">Invoices</div>
    </div>

    <div class="tab-content active" id="active-work">
      <p>No active jobs, invoices or quotes for this client yet</p>
    </div>
    <div class="tab-content" id="requests">
      <p>No requests yet</p>
    </div>
    <div class="tab-content" id="quotes">
      <p>No quotes yet</p>
    </div>
    <div class="tab-content" id="jobs">
      <p>No jobs yet</p>
    </div>
    <div class="tab-content" id="invoices">
      <p>No invoices yet</p>
    </div>
  </div>

  {{-- Schedule --}}
  <div class="section">
    <h2>Schedule</h2>
    <p>Nothing is scheduled for this client yet</p>
  </div>
</div>

<div class="right">
  {{-- Contact Info --}}
  <div class="section">
    <div class="d-flex justify-content-between align-items-center">
      <h2 style="margin:0;">Contact Info</h2>
      <a href="{{ route('clients.edit', $client->id) }}" class="btn edit-btn">Edit</a>
    </div>
    <p><strong>Phone:</strong> {{ $client->phone_number }}</p>
    <p><strong>Email:</strong> {{ $client->email }}</p>
    <p><strong>Company:</strong> {{ $client->company_name ?? 'N/A' }}</p>
    <p><strong>Lead Source:</strong> {{ $client->lead_source ?? 'N/A' }}</p>
    <p><strong>Same as Billing:</strong> {{ $client->same_as_billing ? 'Yes' : 'No' }}</p>
  </div>

  {{-- Tags --}}
  <div class="section">
    <h2>Tags
      <button class="btn add-tag" data-bs-toggle="modal" data-bs-target="#tagModal">+ New Tag</button>
    </h2>
    @if(!empty($client->tags))
    <p>{{ $client->tags }}</p>
    @else
    <p>This client has no tags</p>
    @endif
  </div>

  {{-- Last Communication --}}
  <div class="section">
    <h2>Last Client Communication</h2>
    <p>You haven't sent any client communications yet</p>
  </div>

  {{-- Billing History --}}
  <div class="section">
    <h2>Billing History <button class="btn">New</button></h2>
    <p>No billing history</p>
    <p>Current balance ₹0.00</p>
  </div>

  {{-- Internal Notes --}}
  <div class="section internal-notes">
    <h2>Internal Notes</h2>
    <div class="form-section">
      <h3 class="section-title">Notes</h3>
    </div>
    <div class="form-section">
      <div class="notes-area" onclick="showNotesForm()">
        <div class="add-note-icon">
          <i class="fas fa-plus"></i>
        </div>
      </div>
      <div class="notes-form" id="notesForm">
        <textarea class="form-control" id="notes" name="notes" rows="4"
          placeholder="Leave an internal note for yourself or a team member"></textarea>
        <div class="file-upload-area" onclick="document.getElementById('fileUpload').click()">
          <i class="fas fa-paperclip me-2"></i>
          Attach files or photos
          <input type="file" id="fileUpload" name="attachments[]" multiple accept="image/*,.pdf,.doc,.docx"
            style="display: none;">
        </div>
        <div id="fileList" class="mt-2"></div>
      </div>
    </div>
  </div>
</div>
</div>

<div class="modal fade" id="tagModal" tabindex="-1">
  <div class="modal-dialog">
    <form id="tagForm" method="POST">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Tags</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="client_id" id="tagClientId">
          <input id="tagInput" name="tags" placeholder="Type tags and press Enter" />
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save Tags</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
<script>
  $(document).ready(function() {
    $(".tab-menu .tab").on("click", function() {
      // Remove active class from all tabs
      $(".tab-menu .tab").removeClass("active");
      // Add active to clicked tab
      $(this).addClass("active");
      // Hide all tab contents
      $(".tab-content").removeClass("active");
      // Show selected tab content
      let tabId = $(this).data("tab");
      $("#" + tabId).addClass("active");
    });
  });

  function showNotesForm() {
    const notesForm = document.getElementById('notesForm');
    const notesArea = document.querySelector('.notes-area');
    notesForm.classList.add('active');
    notesArea.style.display = 'none';
  }
  // File upload handling
  document.getElementById('fileUpload').addEventListener('change', function(e) {
    const fileList = document.getElementById('fileList');
    fileList.innerHTML = '';
    Array.from(e.target.files).forEach(file => {
      const fileItem = document.createElement('div');
      fileItem.className = 'd-flex align-items-center justify-content-between p-2 border rounded mb-2';
      fileItem.innerHTML = `
                    <div class="d-flex align-items-center">
                        <i class="fas fa-file me-2"></i>
                        <span>${file.name}</span>
                        <small class="text-muted ms-2">(${(file.size / 1024).toFixed(1)} KB)</small>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeFile(this)">
                        <i class="fas fa-times"></i>
                    </button>
                `;
      fileList.appendChild(fileItem);
    });
  });
</script>

@endpush