<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <title>Home</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/cover/">

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('/public/back/css/sb-admin-2.min.css') }}" rel="stylesheet">


        <style>
        .bd-placeholder-img {
            font-size: 6.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
        /* Adjust display-4 size for different screen sizes */
        @media (max-width: 576px) {
            .display-4 {
                font-size: 2rem;
            }
        }

        @media (min-width: 576px) and (max-width: 768px) {
            .display-4 {
                font-size: 3rem;
            }
        }

        @media (min-width: 768px) and (max-width: 992px) {
            .display-4 {
                font-size: 4rem;
            }
        }

        @media (min-width: 992px) {
            .display-4 {
                font-size: 5rem;
            }
        }
        body {
            /* Use a specific image as a background */
            background-image: url("{{asset('/public/images/landing.jpg')}}");
            /* Set background properties */
            background-size: cover;
            background-repeat: no-repeat;
            zoom: 120%;
            /* You can also adjust other properties like background-position if needed */
        }
        .navbar-brand{
        font-size: 5.5em;
        margin: 0;
        -webkit-text-stroke: 2px #1c87c9;
      }
      .nav-link{
        font-size: 1em;
      }
    </style>

    <!-- Custom styles for this template -->
    <link href="{{ asset('/public/back/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/public/back/css/landing.css') }}" rel="stylesheet">
</head>

<body class="d-flex h-100 text-center text-white ">
    <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
        <header class="mb-auto">
            <div class="justify-content-center">
                <nav class="navbar navbar-expand-md navbar-light">
                    <div class="container">
                        <a class="navbar-brand mb-0 text-light" href="#"><img src="{{ asset('/public/icon/logo.png')}}" alt=""  height="70"></a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link text-white" href="{{ route('admin.login') }}">Admin</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link text-white" href="{{route('client.login')}}">Surveyor</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-white" href="#">Client</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </header>

        <main class="px-3">
            <h1>SGT SOLUTIONs</h1>
            <p class=" display-5 font-weight-bold text-capitalize" >it is a geospatial firm. SGT was founded with the intention of serving the nation's needs.</p>
            <p class="lead">
                <a href="#" class="btn btn-lg btn-secondary fw-bold border-white bg-white">Learn more</a>
            </p>
        </main>

        <footer class="mt-auto text-white-50">
            <p>Created by <a href="https://sgtsolutions.in" class="text-white">@sgt</a>.</p>
        </footer>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>
