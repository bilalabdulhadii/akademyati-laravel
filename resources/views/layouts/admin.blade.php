<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="x-ua-compatible" content="ie=edge"/>
    <meta name="description" content=""/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/home/images/favicon.png') }}"/>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/home/images/favicon.ico') }}">

    <link rel="stylesheet" href="{{ asset('assets/general/css/inbox_2.css') }}"/>
    <link rel="stylesheet" href="{{ asset('ins/assets/css/style.css') }}"/>
    <!-- Bootstrap CSS -->
    <link href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <title>@yield('title')</title>

    <!-- template files start -->
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

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('ins/assets/css/bootstrap.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('ins/assets/css/plugins.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('ins/assets/css/kaiadmin.css') }}"/>

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="{{ asset('ins/assets/css/demo.css') }}"/>
    <!-- template files end -->


    {{-- textarea editor --}}
    <link href="{{ asset('vendor/froala-editor/css/froala_style.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('vendor/froala-editor/css/froala_editor.pkgd.min.css') }}" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{{ asset('vendor/froala-editor/js/froala_editor.pkgd.min.js') }}"></script>

</head>
<body>
<div class="wrapper">
    @section('sidebar')
        @include('admin.components.sidebar')
    @show
    <div class="main-panel">
        @section('header')
            @include('admin.components.header')
        @show

        @section('content')
        @show

        @section('footer')
            @include('admin.components.footer')
        @show
    </div>
</div>

<script type="text/javascript" src="{{ asset('vendor/froala-editor/js/froala_editor.pkgd.min.js') }}"></script>
<script>
    var editor = new FroalaEditor('.editor');
</script>

<!-- custom -->
<script src="{{ asset('ins/assets/js/main.js') }}"></script>

<!-- template files start -->
<!--   Core JS Files   -->
<script src="{{ asset('ins/assets/js/core/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('ins/assets/js/core/popper.min.js') }}"></script>
<script src="{{ asset('ins/assets/js/core/bootstrap.min.js') }}"></script>

<!-- jQuery Scrollbar -->
<script src="{{ asset('ins/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>

<!-- Chart JS -->
<script src="{{ asset('ins/assets/js/plugin/chart.js/chart.min.js') }}"></script>

<!-- jQuery Sparkline -->
<script src="{{ asset('ins/assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>

<!-- Chart Circle -->
<script src="{{ asset('ins/assets/js/plugin/chart-circle/circles.min.js') }}"></script>

<!-- Datatables -->
<script src="{{ asset('ins/assets/js/plugin/datatables/datatables.min.js') }}"></script>

<!-- Bootstrap Notify -->
<script src="{{ asset('ins/assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>

<!-- jQuery Vector Maps -->
<script src="{{ asset('ins/assets/js/plugin/jsvectormap/jsvectormap.min.js') }}"></script>
<script src="{{ asset('ins/assets/js/plugin/jsvectormap/world.js') }}"></script>

<!-- Sweet Alert -->
<script src="{{ asset('ins/assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>

<!-- Kaiadmin JS -->
<script src="{{ asset('ins/assets/js/kaiadmin.min.js') }}"></script>

<!-- Kaiadmin DEMO methods, don't include it in your project! -->
<script src="{{ asset('ins/assets/js/setting-demo.js') }}"></script>
<script src="{{ asset('ins/assets/js/demo.js') }}"></script>
<script>
    $(document).ready(function () {
        $("#basic-datatables").DataTable({});

        $("#multi-filter-select").DataTable({
            pageLength: 5,
            initComplete: function () {
                this.api()
                    .columns()
                    .every(function () {
                        var column = this;
                        var select = $(
                            '<select class="form-select"><option value=""></option></select>'
                        )
                            .appendTo($(column.footer()).empty())
                            .on("change", function () {
                                var val = $.fn.dataTable.util.escapeRegex($(this).val());

                                column
                                    .search(val ? "^" + val + "$" : "", true, false)
                                    .draw();
                            });

                        column
                            .data()
                            .unique()
                            .sort()
                            .each(function (d, j) {
                                select.append(
                                    '<option value="' + d + '">' + d + "</option>"
                                );
                            });
                    });
            },
        });

        // Add Row
        $("#add-row").DataTable({
            pageLength: 5,
        });

        var action =
            '<td> <div class="form-button-action"> <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';

        $("#addRowButton").click(function () {
            $("#add-row")
                .dataTable()
                .fnAddData([
                    $("#addName").val(),
                    $("#addPosition").val(),
                    $("#addOffice").val(),
                    action,
                ]);
            $("#addRowModal").modal("hide");
        });
    });
</script>
<!-- template files end -->
</body>
</html>
