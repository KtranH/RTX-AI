@extends('User.Container')
@section('Body')
    <style>
        .btn-12,
        .btn-12 *,
        .btn-12 :after,
        .btn-12 :before,
        .btn-12:after,
        .btn-12:before {
            border: 0 solid;
            box-sizing: border-box;
        }

        .btn-12 {
            -webkit-tap-highlight-color: transparent;
            -webkit-appearance: button;
            background-color: #000;
            background-image: none;
            color: #fff;
            cursor: pointer;
            font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont,
                Segoe UI, Roboto, Helvetica Neue, Arial, Noto Sans, sans-serif,
                Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol, Noto Color Emoji;
            font-size: 100%;
            font-weight: 900;
            line-height: 1.5;
            margin: 0;
            -webkit-mask-image: -webkit-radial-gradient(#000, #fff);
            padding: 0;
            text-transform: uppercase;
        }

        .btn-12:disabled {
            cursor: default;
        }

        .btn-12:-moz-focusring {
            outline: auto;
        }

        .btn-12 svg {
            display: block;
            vertical-align: middle;
        }

        .btn-12 [hidden] {
            display: none;
        }

        .btn-12 {
            border-radius: 99rem;
            border-width: 2px;
            overflow: hidden;
            padding: 0.8rem 3rem;
            position: relative;
        }

        .btn-12 span {
            mix-blend-mode: difference;
        }

        .btn-12:after,
        .btn-12:before {
            background: linear-gradient(90deg,
                    #fff 25%,
                    transparent 0,
                    transparent 50%,
                    #fff 0,
                    #fff 75%,
                    transparent 0);
            content: "";
            inset: 0;
            position: absolute;
            transform: translateY(var(--progress, 100%));
            transition: transform 0.2s ease;
        }

        .btn-12:after {
            --progress: -100%;
            background: linear-gradient(90deg,
                    transparent 0,
                    transparent 25%,
                    #fff 0,
                    #fff 50%,
                    transparent 0,
                    transparent 75%,
                    #fff 0);
            z-index: -1;
        }

        .btn-12:hover:after,
        .btn-12:hover:before {
            --progress: 0;
        }
    </style>
    <title>
        RTX-AI: Trang chủ 
    </title>
    <main>
        <div class="bg-white">
            <div class="relative isolate px-6 pt-14 lg:px-8">
                <div class="absolute inset-x-0 -top-5 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-5"
                    aria-hidden="true">
                    <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]"
                        style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)">
                    </div>
                </div>
                <div class="mx-auto max-w-2xl py-32 sm:py-48 lg:py-56">
                    <div class="hidden sm:mb-8 sm:flex sm:justify-center">
                        <div class="relative rounded-full px-3 py-1 text-sm leading-6 text-gray-600 ring-1 ring-gray-900/10 hover:ring-gray-900/20"
                            data-aos="zoom-out-up">
                            Chào mừng bạn đến với. <a href="#" class="font-semibold text-indigo-600"><span
                                    class="absolute inset-0" aria-hidden="true"></span>RTX-AI<span
                                    aria-hidden="true">&rarr;</span></a>
                        </div>
                    </div>
                    <div class="text-center" data-aos="zoom-out-up" data-aos-delay="300" style="height: 50vh">
                        <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">Sáng tạo và chia sẻ hình ảnh
                            của bạn</h1>
                        <p class="mt-6 text-lg leading-8 text-gray-600">Tạo các bộ album hình ảnh để chia sẻ với bạn bè và
                            người thân. Khám phá những khoảnh khắc tuyệt vời của cuộc sống.</p>
                        <div class="mt-10 flex items-center justify-center gap-x-6">
                            <a href="{{ route('showboard') }}"
                                class="rounded-md bg-black px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                                data-aos="zoom-in-up" data-aos-delay="300">Bắt
                                đầu</a>
                            <a href="#" class="text-sm font-semibold leading-6 text-gray-900" data-aos="zoom-in-up"
                                data-aos-delay="600">Khám phá <span aria-hidden="true">→</span></a>
                        </div>
                    </div>
                </div>
                <div style="margin-bottom:100px">
                    <h2 class="text-4xl font-bold tracking-tight text-gray-900 text-center mb-2" data-aos="fade-up">Khám phá
                        cùng RTX-AI</h2>
                    <p class="text-2xs tracking-tight text-gray-500 text-center mt-2" data-aos="fade-up"
                        data-aos-delay="300">Chia sẻ và tìm
                        kiếm những bức ảnh nổi bật</p>
                </div>
                <div class="w-[80%] h-[800px] bg-white mx-auto slide_image_home" data-aos="fade-up-right" data-aos-delay="300">
                    <div class="container_slide overflow-hidden" style="border-radius: 30px">
                        <div id="slide">
                            <div class="item" style="background-image: url('{{ asset('images/city.png') }}');">
                            <div class="content">
                                    <div class="name">{{ $city->name }}</div>
                                    <div class="des">{{ $city->description }}</div>
                                </div>
                            </div>
                            <div class="item" style="background-image: url('{{ asset('images/animal.png') }}');">
                                <div class="content">
                                    <div class="name">{{ $animal->name }}</div>
                                    <div class="des">{{ $animal->description }}</div>
                                </div>
                            </div>
                            <div class="item" style="background-image: url('{{ asset('images/travel.png') }}');"> 
                                <div class="content">
                                    <div class="name">{{ $travel->name }}</div>
                                    <div class="des">{{ $travel->description }}</div>
                                </div>
                            </div>
                            <div class="item" style="background-image: url('{{ asset('images/landscape.png') }}');">
                                <div class="content">
                                    <div class="name">{{ $landscape->name }}</div>
                                    <div class="des">{{ $landscape->description }}</div>
                                </div>
                            </div>
                            <div class="item" style="background-image: url('{{ asset('images/fashion.png') }}');">
                                <div class="content">
                                    <div class="name">{{ $fashion->name }}</div>
                                    <div class="des">{{ $fashion->description }}</div>
                                </div>
                            </div>
                            <div class="item" style="background-image: url('{{ asset('images/tech.png') }}');">
                                <div class="content">
                                    <div class="name">{{ $tech->name }}</div>
                                    <div class="des">{{ $tech->description }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="buttons">
                            <button id="prev"><i class="fa-solid fa-angle-left"></i></button>
                            <button id="next"><i class="fa-solid fa-angle-right"></i></button>
                        </div>
                    </div>
                </div>                
                <script>
                   document.getElementById('next').onclick = function(){
                        let lists = document.querySelectorAll('.item');
                        document.getElementById('slide').appendChild(lists[0]);
                    }

                    document.getElementById('prev').onclick = function(){
                        let lists = document.querySelectorAll('.item');
                        document.getElementById('slide').prepend(lists[lists.length - 1]);
                    }

                    // Thêm biến để theo dõi vị trí click ban đầu
                    let startX = 0;
                    let isDragging = false;

                    // Thêm sự kiện click cho từng item
                    document.querySelectorAll('.item').forEach(item => {
                        // Bắt sự kiện mouse down
                        item.addEventListener('mousedown', (e) => {
                            isDragging = true;
                            startX = e.clientX;
                        });

                        // Bắt sự kiện mouse up
                        item.addEventListener('mouseup', (e) => {
                            if (!isDragging) return;
                            
                            isDragging = false;
                            const endX = e.clientX;
                            const threshold = 50; // Ngưỡng để xác định hướng trượt
                            
                            // Nếu di chuyển chuột ít hơn ngưỡng, xem như là click
                            if (Math.abs(endX - startX) < threshold) {
                                let lists = document.querySelectorAll('.item');
                                document.getElementById('slide').appendChild(lists[0]);
                            } 
                            // Nếu kéo sang phải
                            else if (endX - startX > threshold) {
                                let lists = document.querySelectorAll('.item');
                                document.getElementById('slide').prepend(lists[lists.length - 1]);
                            }
                            // Nếu kéo sang trái
                            else if (startX - endX > threshold) {
                                let lists = document.querySelectorAll('.item');
                                document.getElementById('slide').appendChild(lists[0]);
                            }
                        });

                        // Hủy sự kiện kéo khi di chuột ra khỏi item
                        item.addEventListener('mouseleave', () => {
                            isDragging = false;
                        });
                    });

                    // Ngăn chặn kéo chuột mặc định của trình duyệt
                    document.addEventListener('dragstart', (e) => {
                        e.preventDefault();
                    });
                </script>
                <div class="bg-white">
                    <div
                        class="mx-auto grid max-w-2xl grid-cols-1 items-center gap-x-8 gap-y-16 px-4 py-24 sm:px-6 sm:py-32 lg:max-w-7xl lg:grid-cols-2 lg:px-8">
                        <div class="grid grid-cols-2 grid-rows-2 gap-4 sm:gap-6 lg:gap-8" data-aos="fade-up">
                            @php
                                $count = 1;
                            @endphp
                            @while ($count <= 4)
                                <img src="https://pub-d9195d29f33243c7a4d4c49fe887131e.r2.dev/G{{ $count + 16 }}.png"
                                    alt="AI - Images"
                                    class="rounded-lg bg-gray-100 w-full h-full object-cover object-center" loading="lazy">
                                @php
                                    $count = $count + 1;
                                @endphp
                            @endwhile
                        </div>
                        <div>

                            <div data-aos="fade-left">
                                <h2 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-4xl">Sáng tạo ảnh bằng
                                    AI</h2>
                                <p class="mt-4 text-2xs text-gray-500">Chúng tôi cung cấp hơn 20 chức năng tạo ảnh với công
                                    nghệ AI
                                    tạo sinh hình ảnh mới lạ và độc đáo. Bạn có thể tạo ảnh theo ý muốn và chia sẻ với bạn
                                    bè và người thân.</p>

                                <dl class="mt-16 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 sm:gap-y-16 lg:gap-x-8">
                                    <div class="border-t border-gray-200 pt-4">
                                        <dt class="font-medium text-gray-900">Mô tả</dt>
                                        <dd class="mt-2 text-sm text-gray-500">Tạo ảnh bằng mô tả ngắn gọn và chính xác.
                                        </dd>
                                    </div>
                                    <div class="border-t border-gray-200 pt-4">
                                        <dt class="font-medium text-gray-900">Hình ảnh</dt>
                                        <dd class="mt-2 text-sm text-gray-500">Bạn có thể cung cấp hình ảnh mà bạn muốn sao
                                            chép phong cách của ảnh đó.</dd>
                                    </div>
                                    <div class="border-t border-gray-200 pt-4">
                                        <dt class="font-medium text-gray-900">Kiến trúc</dt>
                                        <dd class="mt-2 text-sm text-gray-500">Tạo ra ảnh kiến trúc theo ý muốn.</dd>
                                    </div>
                                    <div class="border-t border-gray-200 pt-4">
                                        <dt class="font-medium text-gray-900">Độ phân giải</dt>
                                        <dd class="mt-2 text-sm text-gray-500">800px x 900px. Là độ phân giải chuẩn để tạo
                                            ảnh.</dd>
                                    </div>
                                    <div class="border-t border-gray-200 pt-4">
                                        <dt class="font-medium text-gray-900">Người mẫu ảo</dt>
                                        <dd class="mt-2 text-sm text-gray-500">Chúng tôi cung cấp nhiều người mẫu ảo để bạn
                                            có thể tạo ảnh thời trang theo ý muốn.</dd>
                                    </div>
                                    <div class="border-t border-gray-200 pt-4">
                                        <dt class="font-medium text-gray-900">Đổi phong cảnh</dt>
                                        <dd class="mt-2 text-sm text-gray-500">Nếu bạn cần phong cảnh cho sản phẩm của
                                            mình, bạn có thể đổi phong cảnh cho ảnh bằng AI.</dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]"
                    aria-hidden="true">
                    <div class="relative left-[calc(50%+3rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%+36rem)] sm:w-[72.1875rem]"
                        style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)">
                    </div>
                </div>
                <div class="relative overflow-hidden" style="margin-top:2%; margin-bottom:5%; padding: 5%"
                    data-aos="zoom-in">
                    <div class="pb-80 pt-16 sm:pb-40 sm:pt-24 lg:pb-48 lg:pt-40">
                        <div class="relative mx-auto max-w-7xl px-4 sm:static sm:px-6 lg:px-8">
                            <div class="sm:max-w-lg">
                                <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">Nơi sáng tạo và
                                    chia sẻ</h1>
                                <p class="mt-4 text-2xs text-gray-500">Chúng tôi sẽ biến những ý tưởng, sáng tạo của bạn
                                    thành hình ảnh với công nghệ AI tạo sinh hình ảnh.</p>
                            </div>
                            <div>
                                <div class="mt-10">
                                    <!-- Decorative image grid -->
                                    <div aria-hidden="true"
                                        class="pointer-events-none lg:absolute lg:inset-y-0 lg:mx-auto lg:w-full lg:max-w-7xl">
                                        <div
                                            class="absolute transform sm:left-1/2 sm:top-0 sm:translate-x-8 lg:left-1/2 lg:top-1/2 lg:-translate-y-1/2 lg:translate-x-8">
                                            <div class="flex items-center space-x-6 lg:space-x-8">
                                                <div class="grid flex-shrink-0 grid-cols-1 gap-y-6 lg:gap-y-8">
                                                    @php
                                                        $count = 1;
                                                        $images = range($count, $count + 6);
                                                    @endphp
                                                    <div
                                                        class="h-64 w-44 overflow-hidden rounded-lg sm:opacity-0 lg:opacity-100">
                                                        @php
                                                            $count = 1;
                                                        @endphp
                                                        <img src="https://pub-d9195d29f33243c7a4d4c49fe887131e.r2.dev/AI_home/{{ $count }}.png"
                                                            alt=""
                                                            class="h-full w-full object-cover object-center" loading="lazy">
                                                    </div>
                                                    <div class="h-64 w-44 overflow-hidden rounded-lg">
                                                        <img src="https://pub-d9195d29f33243c7a4d4c49fe887131e.r2.dev/AI_home/{{ $count + 1 }}.png"
                                                            alt=""
                                                            class="h-full w-full object-cover object-center" loading="lazy">
                                                    </div>
                                                </div>
                                                <div class="grid flex-shrink-0 grid-cols-1 gap-y-6 lg:gap-y-8">
                                                    <div class="h-64 w-44 overflow-hidden rounded-lg">
                                                        <img src="https://pub-d9195d29f33243c7a4d4c49fe887131e.r2.dev/AI_home/{{ $count + 2 }}.png"
                                                            alt=""
                                                            class="h-full w-full object-cover object-center" loading="lazy">
                                                    </div>
                                                    <div class="h-64 w-44 overflow-hidden rounded-lg">
                                                        <img src="https://pub-d9195d29f33243c7a4d4c49fe887131e.r2.dev/AI_home/{{ $count + 3 }}.png"
                                                            alt=""
                                                            class="h-full w-full object-cover object-center" loading="lazy">
                                                    </div>
                                                    <div class="h-64 w-44 overflow-hidden rounded-lg">
                                                        <img src="https://pub-d9195d29f33243c7a4d4c49fe887131e.r2.dev/AI_home/{{ $count + 4 }}.png"
                                                            alt=""
                                                            class="h-full w-full object-cover object-center" loading="lazy">
                                                    </div>
                                                </div>
                                                <div class="grid flex-shrink-0 grid-cols-1 gap-y-6 lg:gap-y-8">
                                                    <div class="h-64 w-44 overflow-hidden rounded-lg">
                                                        <img src="https://pub-d9195d29f33243c7a4d4c49fe887131e.r2.dev/AI_home/{{ $count + 5 }}.png"
                                                            alt=""
                                                            class="h-full w-full object-cover object-center" loading="lazy">
                                                    </div>
                                                    <div class="h-64 w-44 overflow-hidden rounded-lg">
                                                        <img src="https://pub-d9195d29f33243c7a4d4c49fe887131e.r2.dev/AI_home/{{ $count + 6 }}.png"
                                                            alt=""
                                                            class="h-full w-full object-cover object-center" loading="lazy">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn-12"><span>Bắt đầu!</span></button>
                                    <script>
                                        document.querySelector('button').addEventListener('click', function() {
                                            window.location.href = "{{ route('showcreativity') }}";
                                        });
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
