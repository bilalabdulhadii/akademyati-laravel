<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/home/images/favicon.png') }}" />
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/home/images/favicon.ico') }}">

    <!-- Bootstrap CSS -->
    <link href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- CSS -->
    <link href="{{ asset('assets/step/css/style.css') }}" rel="stylesheet">

    {{--<link rel="stylesheet" href="{{ asset('assets/home/css/fontawesome.css') }}">--}}

    <script src="https://kit.fontawesome.com/250ad262b5.js" crossorigin="anonymous"></script>

    {{-- textarea editor --}}
    <link href="{{ asset('vendor/froala-editor/css/froala_style.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('vendor/froala-editor/css/froala_editor.pkgd.min.css') }}" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{{ asset('vendor/froala-editor/js/froala_editor.pkgd.min.js') }}"></script>

    <!-- Fonts and icons -->
    <script src="{{ asset('ins/assets/js/plugin/webfont/webfont.min.js') }}"></script>
    <script>
        WebFont.load({
            google: {families: ["Public Sans:300,400,500,600,700"]},
            custom: {
                families: [
                    "Font Awesome 5 Solid",
                    "Font Awesome 5 Regular",
                    "Font Awesome 5 Brands",
                    "simple-line-icons",
                ],
                urls: ["{{ asset('ins/assets/css/fonts.min.css') }}"],
            },
            active: function () {
                sessionStorage.fonts = true;
            },
        });
    </script>

    <title>@yield('title')</title>
    <title>@yield('head')</title>

</head>
<body>

@section('content')
@show

<!-- Bootstrap JS and dependencies -->
<script src="{{ asset('dash/assets/js/core/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('dash/assets/js/core/popper.min.js') }}"></script>
<script src="{{ asset('dash/assets/js/core/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/step/js/main.js') }}"></script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function() {
        $('#v-pills-tab a').on('click', function(e) {
            e.preventDefault();
            $(this).tab('show');

            if (window.innerWidth < 992) {
                document.querySelector('.collapse-button').classList.add('collapsed');
                document.querySelector('#sidebarMenu').classList.remove('show');
            }
        });
    });
</script>
</body>
</html>
