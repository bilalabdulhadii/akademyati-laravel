<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/home/images/favicon.png') }}" />
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/home/images/favicon.ico') }}">

    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, max-age=0">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">

    <!-- Bootstrap CSS -->
    <link href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
{{--    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">--}}

    <title>@yield('title')</title>

    <!-- template files -->

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Bootstrap core CSS -->
    {{--<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">--}}

    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/home/css/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/home/css/templatemo-cyborg-gaming.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/home/css/owl.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/home/css/flex-slider.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/home/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/home/css/auth.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/home/css/material-design-iconic-font.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>


    </head>
    <body>
    @section('content')
    @show

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


    {{--<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>--}}




    {{--Slider--}}

    <script src="{{ asset('assets/home/js/main.js') }}"></script>
    <script src="{{ asset('assets/home/js/tiny-slider.js') }}"></script>

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
                }
                /*0: {
                    items: 1,
                },
                540: {
                    items: 2,
                },
                768: {
                    items: 4,
                },
                992: {
                    items: 5,
                },
                1170: {
                    items: 6,
                }*/
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
                }
                /*0: {
                    items: 1,
                },
                540: {
                    items: 2,
                },
                768: {
                    items: 4,
                },
                992: {
                    items: 5,
                },
                1170: {
                    items: 6,
                }*/
            }
        });
        tns({
            container: '.category3-slider',
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
                }
                /*0: {
                    items: 1,
                },
                540: {
                    items: 2,
                },
                768: {
                    items: 4,
                },
                992: {
                    items: 5,
                },
                1170: {
                    items: 6,
                }*/
            }
        });
    </script>
</body>
</html>
