<!doctype html>
<html lang="en" data-layout="vertical" data-layout-style="detached" data-sidebar="light" data-topbar="dark"
    data-sidebar-size="lg">
@include('layouts-login.head')

<body>

    <div class="auth-page-wrapper auth-bg-cover py-5 d-flex justify-content-center align-items-center min-vh-100">
            <div class="bg-overlay"></div>
        @yield('container')
        {{-- @include('layouts-login.content') --}}
        @include('layouts-login.footer')
        @include('layouts-login.js')
</body>

</html>
