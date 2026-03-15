<!doctype html>
<html lang="en" data-layout="horizontal" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg">
@include('layouts.head')
{{-- @include('layouts.style') --}}

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">
        @include('layouts.header')
        @include('layouts.sidebar')
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    {{-- <x-partials.breadcrumb></x-partials> --}}
                    {{-- @include('layouts.content') --}}
                    @yield('content')

                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            @include('layouts.footer')

        </div>
        <!-- END layout-wrapper -->
        @include('layouts.jquery')
        @include('layouts.js')
        @stack('scripts')
</body>

</html>
