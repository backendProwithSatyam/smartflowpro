@extends('admin.include.master')
@push('styles')
<link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css">
@endpush
@section('content')

<div class="container">
  <div class="left">
 <div class="d-flex align-items-center">
  <i class="fa-solid fa-user d-flex justify-content-center align-items-center"
     style="background-color: #f0f0f0; border-radius: 50%; padding: 12px; font-size: 38px; margin-right: 10px;height:80px; width:80px;">
  </i>
  <h1 class="mb-0" style="font-size: 36px;
    font-weight: 900;
    color: #000;">Miss. Kajal Kushwaha</h1>
</div>

    <div class="section">
      <h2>Properties <button class="btn">+ New Property</button></h2>
      <p>No properties listed for this client yet</p>
    </div>

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
          <td colspan="4">No contacts found</td>
        </tr>
      </table>
    </div>

    <div class="section">
      <h2>Overview</h2>
      <div class="tab-menu">
        <div class="active">Active Work</div>
        <div>Requests</div>
        <div>Quotes</div>
        <div>Jobs</div>
        <div>Invoices</div>
      </div>
      <p>No active jobs, invoices or quotes for this client yet</p>
    </div>

    <div class="section">
      <h2>Schedule</h2>
      <p>Nothing is scheduled for this client yet</p>
    </div>
  </div>

  <div class="right">
    <div class="section">
      <h2>Contact Info</h2>
      <p>Main: 9170176039</p>
      <p>Main: kajalparshdigital111@gmail.com</p>
      <p>Lead Source: Add</p>
    </div>

    <div class="section">
      <h2>Tags <button class="btn">+ New Tag</button></h2>
      <p>This client has no tags</p>
    </div>

    <div class="section">
      <h2>Last Client Communication</h2>
      <p>You haven't sent any client communications yet</p>
    </div>

    <div class="section">
      <h2>Billing History <button class="btn">New</button></h2>
      <p>No billing history</p>
      <p>Current balance ₹0.00</p>
    </div>

    <div class="section internal-notes">
      <h2>Internal Notes</h2>
      <textarea rows="4" placeholder="Note details"></textarea>
      <div class="drag-file">Drag your files here or <strong>Select a File</strong></div>
    </div>
  </div>
</div>
@endsection
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>

@endpush
@push('styles')
<style>
    .container {
        display: flex;
        margin: 20px auto;
        gap: 20px;
    }

    .left,
    .right {
        background-color: #fff;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .left {
        flex: 3;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .right {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .profile {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .profile i {
        font-size: 40px;
        background-color: #f0f0f0;
        padding: 15px;
        border-radius: 50%;
    }

    .profile h1 {
        margin: 0;
        font-size: 24px;
    }

    .badge {
        background-color: #cce5ff;
        color: #004085;
        padding: 2px 8px;
        border-radius: 4px;
        font-size: 12px;
        margin-left: 10px;
    }

    .section {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 15px;
    }

    .section h2 {
      -webkit-box-flex: 1;
    -webkit-flex: 1 1 0%;
    -ms-flex: 1 1 0%;
    flex: 1 1 0%;
    overflow: hidden;
    margin: 0;
    font-family: Inter,Helvetica,Arial,sans-serif;
    font-weight: 700;
    font-size: 24px;
    line-height: 1.75rem;
    -webkit-font-smoothing: antialiased;
    color:#032b3a;
    text-overflow: ellipsis;
    white-space: nowrap;
    }

    .section p {
        margin: 5px 0;
        font-size: 14px;
        color: #6c757d;
    }

    .section button {
           color: #388523;
    background-color: transparent;
    border-color: #dadfe2;
            float: right;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }

    table th,
    table td {
        text-align: left;
        padding: 8px;
        border-bottom: 1px solid #e0e0e0;
    }

    .action-buttons {
        display: flex;
        gap: 10px;
        margin-top: 10px;
    }

    .action-buttons button {
        background-color: #007bff;
        color: white;
        border: none;
        padding: 6px 12px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
    }

    .internal-notes textarea {
        width: 100%;
        border-radius: 5px;
        border: 1px solid #ccc;
        padding: 8px;
        font-size: 14px;
        resize: vertical;
    }

    .drag-file {
        margin-top: 10px;
        padding: 15px;
        border: 2px dashed #ccc;
        text-align: center;
        color: #6c757d;
        border-radius: 5px;
        cursor: pointer;
    }

    .tab-menu {
        display: flex;
        gap: 15px;
        margin-bottom: 10px;
        border-bottom: 1px solid #e0e0e0;
    }

    .tab-menu div {
        padding: 5px 10px;
        cursor: pointer;
        font-size: 14px;
        color: #418b2d;
    }

    .tab-menu .active {
         border-bottom: 2px solid #418b2d;
        font-weight: bold;
    }
</style>
@endpush