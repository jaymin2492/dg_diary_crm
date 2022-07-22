<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('public/assets/images/favicon.ico') }}">

    <link href="{{ asset('public/assets/libs/mohithg-switchery/switchery.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Plugins css -->
    <link href="{{ asset('public/assets/libs/flatpickr/flatpickr.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/assets/libs/selectize/css/selectize.bootstrap3.css') }}" rel="stylesheet" type="text/css" />

    <!-- Bootstrap css -->
    <link href="{{ asset('public/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App css -->
    <link href="{{ asset('public/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />
    <!-- icons -->
    <link href="{{ asset('public/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
     <!-- third party css -->
     <link href="{{ asset('public/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/assets/libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/assets/libs/datatables.net-select-bs5/css//select.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- custom -->
    <link href="{{ asset('public/css/custom.css') }}" rel="stylesheet" type="text/css" />
    <!-- Head js -->
    <script src="{{ asset('public/assets/js/head.js') }}"></script>

    <!-- Vendor js -->
    <script src="{{ asset('public/assets/js/vendor.min.js') }}"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.js"></script>
    <!-- third party js -->
    <script src="{{ asset('public/assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('public/assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('public/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('public/assets/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('public/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('public/assets/libs/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('public/assets/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('public/assets/libs/datatables.net-buttons/js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('public/assets/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('public/assets/libs/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>
    <script src="{{ asset('public/assets/libs/datatables.net-select/js/dataTables.select.min.js') }}"></script>




</head>

<body data-layout-mode="default" data-theme="light" data-layout-width="fluid" data-topbar-color="dark" data-menu-position="fixed" data-leftbar-color="light" data-leftbar-size='default' data-sidebar-user='false'>

    <!-- Begin page -->
    <div id="wrapper">
        <!-- Topbar Start -->
        <div class="navbar-custom">
            <div class="container-fluid">
                @include('common.navbar_right')
                <!-- LOGO -->
                <div class="logo-box">
                    <a href="{{ URL('/') }}" class="logo logo-dark text-center">
                        <span class="logo-sm">
                            <img src="{{ asset('public/assets/images/logo-sm.png') }}" alt="" height="22">
                            <!-- <span class="logo-lg-text-light">UBold</span> -->
                        </span>
                        <span class="logo-lg">
                            <img src="{{ asset('public/assets/images/logo-dark.png') }}" alt="" height="20">
                            <!-- <span class="logo-lg-text-light">U</span> -->
                        </span>
                    </a>
                    <a href="{{ URL('/') }}" class="logo logo-light text-center">
                        <span class="logo-sm">
                            <img src="{{ asset('public/assets/images/logo-sm.png') }}" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ asset('public/assets/images/logo-light.png') }}" alt="" height="20">
                        </span>
                    </a>
                </div>
                @include('common.navbar')
                <div class="clearfix"></div>
            </div>
        </div>
        <!-- end Topbar -->
        @include('common.left_sidebar')

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">
                <!-- Start Content-->
                <div class="container-fluid">
                    @yield('content')
                </div>
                <!-- content -->
                <!-- Footer Start -->
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                <script>
                                    document.write(new Date().getFullYear())
                                </script> &copy; DgDiary
                            </div>
                            <div class="col-md-6">
                                <div class="text-md-end footer-links d-none d-sm-block">
                                    <a href="javascript:void(0);">About Us</a>
                                    <a href="javascript:void(0);">Help</a>
                                    <a href="javascript:void(0);">Contact Us</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
                <!-- end Footer -->
            </div>
        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->



    </div>
    <!-- END wrapper -->



    
    <script src="{{ asset('public/assets/libs/mohithg-switchery/switchery.min.js') }}"></script>
    <script src="{{ asset('public/assets/libs/multiselect/js/jquery.multi-select.js') }}"></script>
    <script src="{{ asset('public/assets/libs/select2/js/select2.min.js') }}"></script>
    <!-- <script src="{{ asset('public/assets/libs/jquery-mockjax/jquery.mockjax.min.js') }}"></script> -->
    <script src="{{ asset('public/assets/libs/devbridge-autocomplete/jquery.autocomplete.min.js') }}"></script>
    <script src="{{ asset('public/assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>
    <script src="{{ asset('public/assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>

    <!-- Plugins js-->
    <script src="{{ asset('public/assets/libs/flatpickr/flatpickr.min.js') }}"></script>
    <!-- <script src="{{ asset('public/assets/libs/apexcharts/apexcharts.min.js') }}"></script> -->

    <script src="{{ asset('public/assets/libs/selectize/js/standalone/selectize.min.js') }}"></script>

    <!-- Dashboar 1 init js-->
    <!-- <script src="{{ asset('public/assets/js/pages/dashboard-1.init.js') }}"></script> -->

    <!-- Sweet Alerts js -->
    <script src="{{ asset('public/assets/libs/sweetalert2/sweetalert2.all.min.js') }}"></script>

    <!-- App js -->
    <script src="{{ asset('public/assets/js/app.min.js') }}"></script>

    <!-- Init js-->
    <script src="{{ asset('public/assets/js/pages/form-advanced.init.js') }}"></script>


</body>

</html>