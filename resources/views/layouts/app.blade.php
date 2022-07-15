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

    <!-- Bootstrap css -->
    <link href="{{ asset('public/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App css -->
    <link href="{{ asset('public/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />
    <!-- icons -->
    <link href="{{ asset('public/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Head js -->
    <script src="{{ asset('public/assets/js/head.js') }}"></script>

    <!-- Vendor js -->
    <script src="{{ asset('public/assets/js/vendor.min.js') }}"></script>



</head>

<body class="authentication-bg authentication-bg-pattern">




    <div class="account-pages mt-5 mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-4">
                    <div class="card bg-pattern">

                        <div class="card-body p-4">

                            <div class="text-center w-75 m-auto">
                                <div class="auth-logo">
                                    <a href="{{ URL('/') }}" class="logo logo-dark text-center">
                                        <span class="logo-lg">
                                            <img src="{{ asset('public/assets/images/logo-dark.png') }}" alt="" height="22">
                                        </span>
                                    </a>

                                    <a href="{{ URL('/') }}" class="logo logo-light text-center">
                                        <span class="logo-lg">
                                            <img src="{{ asset('public/assets/images/logo-light.png') }}" alt="" height="22">
                                        </span>
                                    </a>
                                </div>
                            </div>

                            @yield('content')

                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->

                    <!-- end row -->

                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end page -->
    <footer class="footer footer-alt text-white">
        2022 - <script>
            document.write(new Date().getFullYear())
        </script> &copy; DgDiary
    </footer>

    

    <script src="{{ asset('public/assets/libs/mohithg-switchery/switchery.min.js') }}"></script>

    <!-- App js -->
    <script src="{{ asset('public/assets/js/app.min.js') }}"></script>


</body>

</html>