<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <!-- Icon -->
        <link rel="icon" href="/assets/img/icon.png" type="image/png">

        <!-- Link FrontEnd -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <link href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" rel="stylesheet" type="text/css" />
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css"/>
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jarallax@1.12.0/dist/jarallax.css">
        <!-- Link Icons -->

        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
        <!-- CSS Files -->
        <link rel="stylesheet" href="{{url('assets/css/header.css')}}">
        <link rel="stylesheet" href="{{url('assets/css/login.css')}}">
        <link rel="stylesheet" href="{{url('assets/css/theme.css')}}">
        <!-- JS Files -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://kit.fontawesome.com/a076d05399.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
        <script src="https://cdn.tailwindcss.com"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script> 
        <script src="https://cdn.jsdelivr.net/npm/simple-parallax-js@5.6.2/dist/simpleParallax.min.js"></script>    
        <script src="https://cdn.jsdelivr.net/npm/jarallax@1.12.0/dist/jarallax.min.js"></script>
        <!-- Tagify CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tagify/4.9.5/tagify.css">
        <!-- Tagify JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tagify/4.9.5/tagify.min.js"></script>
        <style>
           body::-webkit-scrollbar
           {
                display: none;
           }
        </style>
    </head>

    <body class="{{ session('theme', 'theme-default') }}">
        @include('User.Header')
        @yield('Body')
        @include('User.Footer')
        <script>
            AOS.init({
            duration: 1000, 
            deplay: 500,
            once: false,
            offset: 200,
            easing: 'ease-in-sine',
            });
        </script>      
    </body>
</html>