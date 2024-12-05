<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta property="og:image" content="{{ asset('images/imageWeb.png') }}">
    <meta property="og:title" content="RTX_AI: Sáng tạo và chia sẻ hình ảnh">
    <meta property="og:description" content="RTX_AI là một trang web cho phép người dùng tạo ra những hình ảnh bằng AI tạo sinh đẹp mắt và chia sẻ chúng với bạn bè và gia đình.">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Icon -->
    <link rel="icon" href="/assets/img/icon.png" type="image/png">
     <!-- Link FrontEnd -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" rel="stylesheet" type="text/css" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jarallax@1.12.0/dist/jarallax.css">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/css/headers.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/theme.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/homeButton.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/home.css') }}">
    <!-- JS link -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-parallax-js@5.6.2/dist/simpleParallax.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jarallax@1.12.0/dist/jarallax.min.js"></script>
    <!-- JS link for charts -->
    <script type="text/javascript" src="https://fastly.jsdelivr.net/npm/echarts@5.5.1/dist/echarts.min.js"></script>
</head>

<body>
    <div class="hidden lg:block">
        <div class="w-screen h-screen flex flex-row overflow-hidden space-x-2">
            <div class="basis-[15%] h-full p-2">
                @include("Admin.Sidebar")
            </div>
            <div class="basis-[85%] h-full overflow-hidden p-2">
                @include('sweetalert::alert')
                @yield("Content")
            </div>
        </div>
        @include("Admin.Dialog")
    </div>
    <div class="block lg:hidden">
        <div class="w-screen h-screen flex flex-col items-center justify-center text-xl text-indigo-700 font-bold space-y-8">
            <div>NO RESPONSIVE!!!</div>
            <div class="flex flex-row items-center justify-center space-x-4">
                <img src="/assets/img/icon.png" alt="Logo" class="w-10">
                <div>RTX-ADMIN</div>
            </div>
            <div>USE LARGE RESOLUTION!!!</div>
        </div>
    </div>
</body>