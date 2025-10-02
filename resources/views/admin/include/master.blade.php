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