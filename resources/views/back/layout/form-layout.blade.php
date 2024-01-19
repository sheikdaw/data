
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>@yield('pagetitle')</title>

    <!-- Custom fonts for this template-->
    <link href="{{ assets('/public/back/vendor/fontawesome-free/css/all.min.css'}}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ assets('/public/back/css/sb-admin-2.min.css'}}" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    @livewireStyles
    @stack('stylesheet')

</head>

<body class="bg-primary">

                            @yield('content')


    <!-- Bootstrap core JavaScript-->
    <script src="{{ assets('/public/back/vendor/jquery/jquery.min.js'}}"></script>
    <script src="{{ assets('/public/back/vendor/bootstrap/js/bootstrap.bundle.min.js'}}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ assets('/public/back/vendor/jquery-easing/jquery.easing.min.js'}}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ assets('/public/back/js/sb-admin-2.min.js'}}"></script>
    @livewireScripts
    @stack('script')

</body>

</html>
