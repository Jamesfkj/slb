<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SLB</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>SLB</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <!-- Favicons -->
    <link href="{{asset('assets/temp/img/favicon.png')}}" rel="icon">
    <link href="{{asset('assets/temp/img/apple-touch-icon.png')}}" rel="apple-touch-icon">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <!-- Vendor CSS Files -->
    <link href="{{asset('assets/temp/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/temp/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
    <link href="{{asset('assets/temp/vendor/aos/aos.css')}}" rel="stylesheet">
    <link href="{{asset('assets/temp/vendor/glightbox/css/glightbox.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/temp/vendor/swiper/swiper-bundle.min.css')}}" rel="stylesheet">
    <!-- Main CSS File -->
    <link href="{{asset('assets/temp/css/main.css')}}" rel="stylesheet">
    <script src="{{ asset('assets/temp/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ asset('assets/temp/vendor/php-email-form/validate.js')}}"></script>
    <script src="{{ asset('assets/temp/vendor/aos/aos.js')}}"></script>
    <script src="{{ asset('assets/temp/vendor/glightbox/js/glightbox.min.js')}}"></script>
    <script src="{{ asset('assets/temp/vendor/purecounter/purecounter_vanilla.js')}}"></script>
    <script src="{{ asset('assets/temp/vendor/imagesloaded/imagesloaded.pkgd.min.js')}}"></script>
    <script src="{{ asset('assets/temp/vendor/isotope-layout/isotope.pkgd.min.js')}}"></script>
    <script src="{{ asset('assets/temp/vendor/swiper/swiper-bundle.min.js')}}"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <!-- Main JS File -->
    <script src="{{ asset('assets/temp/js/main.js')}}"></script>
    <!-- Vendor CSS Files -->
    <link href="{{asset('assets/temp/css/index.css')}}" rel="stylesheet">


    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased form-gest">

    <div class=" hero flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        <div class="">
            <a href="" class="logo d-flex align-items-center me-auto">
                <img src="{{asset('assets/temp/img/logo.png')}}" alt="">
                <h1 class="" style="font-size : 35px">SLB</h1>
            </a>
        </div>
            <div class="w-full sm:max-w-md mt-6 px-6 py-4 shadow-md overflow-hidden sm:rounded-lg ">
                {{ $slot }}
            </div>
    </div>
</body>

</html>