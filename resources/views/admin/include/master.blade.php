<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.include.head')
    @stack('styles')
</head>

<body class="layout-boxed">
    <div id="load_screen">
        <div class="loader">
            <div class="loader-content">
                <div class="spinner-grow align-self-center"></div>
            </div>
        </div>
    </div>
    {{-- @include('admin.include.header') --}}
    <div class="main-container" id="container">
        <div class="overlay"></div>
        <div class="search-overlay"></div>
        @include('admin.include.sidebar')
        <div id="content" class="main-content">
            <div class="layout-px-spacing">
                <div class="middle-content container-xxl p-0">
                    @include('admin.include.breadcrumb')
                      {{-- Conditional Add Fields Button + Modal --}}
@if(!Request::is('dashboard') && !Request::is('schedule')){{-- dashboard ke route ke liye exclude --}}
  <div class="col-lg-12 text-end">
 <button type="button" class="btn btn-primary fixed-bottom m-4" data-bs-toggle="modal" data-bs-target="#addFieldsModal">
      Add Fields
    </button>
  </div>
    {{-- Modal Partial --}}
 <div class="modal fade" id="addFieldsModal" tabindex="-1" aria-labelledby="addFieldsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addFieldsModalLabel">Add Fields</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          @include('admin.partials.add_fields')
      </div>
    </div>
  </div>
</div>
  @endif
                    <!-- Add Fields Modal -->


              

                    @yield('content')
                </div>
            </div>
            @include('admin.include.footer')
        </div>
    </div>
    @include('admin.include.foot')
    @stack('scripts')
</body>

</html>