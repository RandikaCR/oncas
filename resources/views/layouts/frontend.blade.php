<!DOCTYPE html>
<html lang="zxx">
<head>
    @include('partials.frontend.head')
</head>

<body>
<!-- Preloader -->
<div id="preloader">
    <div class="preloader">
        <span></span>
        <span></span>
    </div>
</div>


@include('partials.frontend.header')

@yield('content')

@include('partials.frontend.footer')

<!-- Back to top -->
<div class="back-top"><i class="feather-icon icon-chevron-up"></i></div>

@include('partials.frontend.script')

</body>
</html>
