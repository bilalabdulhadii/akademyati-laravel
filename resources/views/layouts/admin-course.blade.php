<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/home/images/favicon.png') }}" />
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/home/images/favicon.ico') }}">

    <!-- Bootstrap CSS -->
    <link href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <title>@yield('title')</title>

    <!-- template files start -->
    <!-- Fonts and icons -->
    <script src="{{ asset('dash/assets/js/plugin/webfont/webfont.min.js') }}"></script>
    <script>
        WebFont.load({
            google: { families: ["Public Sans:300,400,500,600,700"] },
            custom: {
                families: [
                    "Font Awesome 5 Solid",
                    "Font Awesome 5 Regular",
                    "Font Awesome 5 Brands",
                    "simple-line-icons",
                ],
                urls: ["{{ asset('dash/assets/css/fonts.min.css') }}"],
            },
            active: function () {
                sessionStorage.fonts = true;
            },
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('dash/assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('dash/assets/css/plugins.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('dash/assets/css/kaiadmin.css') }}" />

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="{{ asset('dash/assets/css/demo.css') }}" />
    <!-- template files end -->

    <!-- course CSS -->
    <link rel="stylesheet" href="{{ asset('dash/assets/css/course.css') }}" />

    <!-- Additional Files -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    @yield('head')

</head>
<body>

<div class="wrapper">
    @section('content')
    @show
</div>

<!-- template files start -->
<!--   Core JS Files   -->
<script src="{{ asset('dash/assets/js/core/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('dash/assets/js/core/popper.min.js') }}"></script>
<script src="{{ asset('dash/assets/js/core/bootstrap.min.js') }}"></script>

<!-- jQuery Scrollbar -->
<script src="{{ asset('dash/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>

<!-- Chart JS -->
<script src="{{ asset('dash/assets/js/plugin/chart.js/chart.min.js') }}"></script>

<!-- jQuery Sparkline -->
<script src="{{ asset('dash/assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>

<!-- Chart Circle -->
<script src="{{ asset('dash/assets/js/plugin/chart-circle/circles.min.js') }}"></script>

<!-- Datatables -->
<script src="{{ asset('dash/assets/js/plugin/datatables/datatables.min.js') }}"></script>

<!-- Bootstrap Notify -->
<script src="{{ asset('dash/assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>

<!-- jQuery Vector Maps -->
<script src="{{ asset('dash/assets/js/plugin/jsvectormap/jsvectormap.min.js') }}"></script>
<script src="{{ asset('dash/assets/js/plugin/jsvectormap/world.js') }}"></script>

{{--<!-- Sweet Alert -->
<script src="{{ asset('dash/assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>--}}

<!-- Kaiadmin JS -->
<script src="{{ asset('dash/assets/js/kaiadmin.min.js') }}"></script>

<!-- Kaiadmin DEMO methods, don't include it in your project! -->
<script src="{{ asset('dash/assets/js/setting-demo.js') }}"></script>
<script src="{{ asset('dash/assets/js/demo.js') }}"></script>
<!-- template files end -->
</body>
</html>
