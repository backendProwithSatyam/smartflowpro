<!DOCTYPE html>
<html lang="en">
<head>
    @include('website.include.head')
    @stack('styles')
</head>

<body>
    <div class="preLoader"></div>

    <!-- Main header -->
    @include('website.include.header')
    <!-- End of Main header -->

    {{-- Section --}}
    @yield('content')
    {{-- End of Sect --}}

    <!-- Footer -->
    @include('website.include.footer')
    <!-- End of Footer -->
    <div class="back-to-top">
        <a href="#"> <i class="fa fa-chevron-up"></i></a>
    </div>
    @include('website.include.foot')
    @stack('scripts')
</body>
</html>