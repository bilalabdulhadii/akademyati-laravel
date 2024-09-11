<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/home/images/favicon.png') }}" />
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/home/images/favicon.ico') }}">

    <link rel="stylesheet" href="{{ asset('assets/general/css/chat.css') }}"/>

    <!-- Bootstrap CSS -->
    <link href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <title>@yield('title')</title>

    <!-- template files -->

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Bootstrap core CSS -->
    {{--<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">--}}

    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/home/css/learning.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/home/css/fontawesome.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="{{ asset('assets/home/css/templatemo-cyborg-gaming.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/home/css/owl.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/home/css/flex-slider.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/home/css/animate.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>


    <!-- Fonts and icons -->
    {{-- <script src="{{ asset('ins/assets/js/plugin/webfont/webfont.min.js') }}"></script>
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
    </script> --}}


    {{--slider--}}
    <link rel="stylesheet" href="{{ asset('assets/home/css/LineIcons.2.0.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/home/css/tiny-slider.css') }}">
    {{--<link rel="stylesheet" href="{{ asset('assets/home/css/main.css') }}">--}}
    <link rel="stylesheet" href="{{ asset('assets/home/css/glightbox.min.css') }}">

    @yield('head')
    </head>
    <body>
    @section('header')
        @include('home.components.header')
    @show

    @section('content')
    @show

    @section('footer')
        @include('home.components.footer')
    @show

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Select all the containers that have a rating component
            const ratingContainers = document.querySelectorAll('.course-rating-container');

            // Initialize the rating functionality for each container
            ratingContainers.forEach(container => {
                initializeRating(container);
            });
        });
    </script>

    <script src="{{ asset('assets/general/js/chat.js') }}"></script>
    <script src="{{ asset('assets/home/js/main.js') }}"></script>

    <!-- Bootstrap JS -->
    <script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Custom JS -->
    {{--<script src="{{ asset('js/custom.js') }}"></script>--}}


    <!-- ========================= template files ========================= -->
    <!-- Scripts -->
    <!-- Bootstrap core JavaScript -->
    <script src="{{ asset('assets/home/jquery/jquery.min.js') }}"></script>
    {{--<script src="vendor/bootstrap/js/bootstrap.min.js"></script>--}}

    <script src="{{ asset('assets/home/js/isotope.min.js') }}"></script>
    <script src="{{ asset('assets/home/js/owl-carousel.js') }}"></script>
    <script src="{{ asset('assets/home/js/tabs.js') }}"></script>
    <script src="{{ asset('assets/home/js/popup.js') }}"></script>
    <script src="{{ asset('assets/home/js/custom.js') }}"></script>
    <script src="{{ asset('assets/home/js/tiny-slider.js') }}"></script>

    {{-- learning page tabs --}}
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>

    <script type="text/javascript">
        tns({
            container: '.category1-slider',
            items: 3,
            slideBy: 'page',
            autoplay: false,
            mouseDrag: true,
            gutter: 0,
            nav: false,
            controls: true, /*<i class="lni lni-chevron-left">P</i>', '<i class="lni lni-chevron-right">N</i>*/
            controlsText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
            responsive: {
                0: {
                    items: 1,
                },
                540: {
                    items: 2,
                },
                768: {
                    items: 3,
                },
                992: {
                    items: 4,
                },
                1200: {
                    items: 5,
                },
                2000: {
                    items: 7,
                }
            }
        });
        tns({
            container: '.category2-slider',
            items: 3,
            slideBy: 'page',
            autoplay: false,
            mouseDrag: true,
            gutter: 0,
            nav: false,
            controls: true, /*<i class="lni lni-chevron-left">P</i>', '<i class="lni lni-chevron-right">N</i>*/
            controlsText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
            responsive: {
                0: {
                    items: 1,
                },
                540: {
                    items: 2,
                },
                768: {
                    items: 3,
                },
                992: {
                    items: 4,
                },
                1200: {
                    items: 5,
                },
                2000: {
                    items: 7,
                }
            }
        });
    </script>
</body>
</html>
