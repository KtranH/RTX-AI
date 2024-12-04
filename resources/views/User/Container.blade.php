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
    <!-- Link FrontEnd -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" rel="stylesheet" type="text/css" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" />
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jarallax@1.12.0/dist/jarallax.css">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&display=swap"
        rel="stylesheet">
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
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

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>

    <!-- Alpine JS -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.10.5/dist/cdn.min.js" defer></script>

    <!-- Pusher -->
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

    <style>
        body::-webkit-scrollbar {
            display: none;
        }
    </style>

    <script>
        function readNotification(element, event) {
            event.preventDefault();
            const id = element.getAttribute('data-id');
            const href = element.getAttribute('href');
            fetch(`/api/read-notification/${id}`).then(response => response.json())
                .then(data => {
                    window.location.href = href;
                });
        }
    </script>
</head>



<body class="{{ session('theme', 'theme-default') }}">
    <div style="height:80px;">
        @include('User.Header')
    </div>
    <div class="mt-2 mb-2">
        @include('sweetalert::alert')
        @yield('Body')
    </div>
    @include('User.Footer')
    <script>
        AOS.init({
            duration: 800,
            deplay: 500,
            once: false,
            offset: 150,
            easing: 'ease-in-sine',
        });
    </script>
</body>

@auth
    <script>
        const notificationCount = document.querySelector('#notification-count');

        const toast = Swal.mixin({
            toast: true,
            position: 'bottom-left',
            showConfirmButton: false,
            timer: 3000
        });

        var pusher = new Pusher('5d7aed0126981dfc615c', {
            cluster: 'ap1'
        });

        var channel = pusher.subscribe("user.{{ auth()->id() }}");

        channel.bind('pusher:subscription_succeeded', function(data) {
            console.log('Subscription succeeded!', data);
        });

        channel.bind('push-notification', function(data) {
            toast.fire({
                title: 'Thông báo',
                color: 'white',
                text: data.message,
                icon: 'success',
                iconColor: 'white',
                background: '#46DFB1'
            });
            setHtml({
                ...data,
                is_read: 0
            });
            notificationCount.textContent = parseInt(notificationCount.textContent) + 1;
        });

        const html = (item) => `
                <li class="py-2 flex">
                    <a 
                        data-id="${item.idNotification}"
                        onclick="readNotification(this, event)"
                        href="${item.url}" class="flex items-center w-full hover:bg-gray-100 p-2 rounded ${item.is_read == 0? "bg-red-100": ""}">
                        <img class="h-6 w-6 rounded-full ring-2 ring-white mr-2"
                            src="${item.avatar_url}" alt="">
                        <p class="font-semibold text-gray-700">${item.message}</p>
                    </a>
                </li>
                `;

        function setHtml(item) {
            const ul = document.querySelector('#js-notification-main');
            ul.insertAdjacentHTML('afterbegin', html(item));
            if (document.querySelector('#no-notification'))
                document.querySelector('#no-notification').remove();
        }

        var pageNotification = 2;

        function getNotification() {
            fetch(`/api/get-notification/{{ auth()->id() }}?page=${pageNotification}`)
                .then(response => response.json())
                .then(data => {
                    if (data.data.length > 0) {
                        const _data = data.data;
                        console.log(_data);

                        _data.forEach(item => {
                            const _item = {
                                ...item.data,
                                idNotification: item.id
                            };
                            setHtml(_item);
                        });
                        pageNotification++;
                    }
                });
        }
    </script>
@endauth


</html>
