<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta property="og:image" content="{{ asset('images/imageWeb.png') }}">
    <meta property="og:title" content="RTX_AI: Sáng tạo và chia sẻ hình ảnh">
    <meta property="og:description"
        content="RTX_AI là một trang web cho phép người dùng tạo ra những hình ảnh bằng AI tạo sinh đẹp mắt và chia sẻ chúng với bạn bè và gia đình.">

    <!-- Icon -->
    <link rel="icon" href="/assets/img/icon.png" type="image/png">
        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
        <!-- CSS Files -->
        <link rel="stylesheet" href="{{url('assets/css/header.css')}}">
        <link rel="stylesheet" href="{{url('assets/css/login.css')}}">
        <link rel="stylesheet" href="{{url('assets/css/theme.css')}}">
        <link rel="stylesheet" href="{{ url('assets/css/homeButton.css') }}">
        <!-- JS link -->
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
        <link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />
        <!-- Tagify JS -->
        <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
        <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.polyfills.min.js"></script>
        <style>
            body::-webkit-scrollbar
            {
                display: none;
            }
        </style>
    </head>

    <body class="{{ session('theme', 'theme-default') }}">
        <div style="height:80px;">
            @include('User.Header')
        </div>
        <div class="mt-10 mb-10">
            @yield('Body')
        </div>
        @include('User.Footer')
        <script>
            AOS.init({
            duration: 1000,
            deplay: 500,
            once: false,
            offset: 150,
            easing: 'ease-in-sine',
        });
    </script>
    <script src="{{ asset('assets/js/helper.js') }}"></script>
</body>

</html>
