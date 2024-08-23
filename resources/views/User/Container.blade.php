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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" rel="stylesheet" type="text/css" />
    <!-- Link Icons -->

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
    <!-- CSS Files -->
    <link rel="stylesheet" href="{{url('assets/css/header.css')}}">
    <link rel="stylesheet" href="{{url('assets/css/login.css')}}">
    <!-- JS Files -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>

    <!-- Tagify CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tagify/4.9.5/tagify.css">
    <!-- Tagify JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tagify/4.9.5/tagify.min.js"></script>

</head>
<body>
    @include('User.Header')
    @yield('Body')
    @include('User.Footer')
</body>
</html>