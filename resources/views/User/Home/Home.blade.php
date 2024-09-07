@extends('User.Container')
@section('Body')
    <title>
        RTX-AI: Trang chủ
    </title>
    <link rel="stylesheet" href="{{ url('assets/css/homeButton.css') }}">
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
                        <div
                            class="relative rounded-full px-3 py-1 text-sm leading-6 text-gray-600 ring-1 ring-gray-900/10 hover:ring-gray-900/20" data-aos="zoom-out-up">
                            Chào mừng bạn đến với. <a href="#" class="font-semibold text-indigo-600"><span
                                    class="absolute inset-0" aria-hidden="true"></span>RTX-AI<span
                                    aria-hidden="true">&rarr;</span></a>
                        </div>
                    </div>
                    <div class="text-center" data-aos="zoom-out-up" data-aos-delay="300">
                        <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">Sáng tạo và chia sẻ hình ảnh
                            của bạn</h1>
                        <p class="mt-6 text-lg leading-8 text-gray-600">Tạo các bộ album hình ảnh để chia sẻ với bạn bè và
                            người thân. Khám phá những khoảnh khắc tuyệt vời của cuộc sống.</p>
                        <div class="mt-10 flex items-center justify-center gap-x-6">
                            <a href="{{ route('showboard') }}"
                                class="rounded-md bg-black px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" data-aos="zoom-in-up" data-aos-delay="300">Bắt
                                đầu</a>
                            <a href="#" class="text-sm font-semibold leading-6 text-gray-900" data-aos="zoom-in-up" data-aos-delay="600">Khám phá <span
                                    aria-hidden="true">→</span></a>
                        </div>
                    </div>
                </div>
                <div style="margin-bottom:100px">
                    <h2 class="text-4xl font-bold tracking-tight text-gray-900 text-center mb-2" data-aos="fade-up">Khám phá cùng RTX-AI</h2>
                    <p class="text-2xs tracking-tight text-gray-500 text-center mt-2" data-aos="fade-up" data-aos-delay="300">Chia sẻ và tìm
                        kiếm những bức ảnh nổi bật</p>
                </div>
                <div data-aos="fade-up" data-aos-delay="100">
                    <div class="jarallax" data-jarallax data-speed="0.1" style="height:100vh;">
                        <img src="/images/landscape.png" class="jarallax-img" alt="Image 1">
                        <div class="content"
                            style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                            <div style="width:100%;border-radius:30px; backdrop-filter: blur(5px); padding:5%; background-color:rgba(49, 49, 49, 0.5)"
                                class="bg-" data-aos="zoom-in-up" data-aos-delay="100">
                                <h2 class="text-5xl font-bold text-white text-center" data-aos="fade-up" data-aos-delay="200">
                                    @foreach ($landscape as $x)
                                        <?php echo $x->name; ?>
                                    @endforeach
                                </h2>
                                <p class="text-white text-center mt-2" data-aos="fade-up" data-aos-delay="400">
                                    @foreach ($landscape as $x)
                                        <?php echo $x->description; ?>
                                    @endforeach
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="jarallax" data-jarallax data-speed="0.1" style="height: 100vh;">
                        <img src="/images/animal.png" class="jarallax-img" alt="Image 2">
                        <div class="content"
                            style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                            <div style="width:100%;border-radius:30px; backdrop-filter: blur(5px); padding:5%; background-color:rgba(49, 49, 49, 0.5)"
                                class="bg-" data-aos="zoom-in-up" data-aos-delay="100">
                                <h2 class="text-5xl font-bold text-white text-center" data-aos="fade-up" data-aos-delay="200">
                                    @foreach ($animal as $x)
                                        <?php echo $x->name; ?>
                                    @endforeach
                                </h2>
                                <p class="text-white text-center mt-2" data-aos="fade-up" data-aos-delay="400">
                                    @foreach ($animal as $x)
                                        <?php echo $x->description; ?>
                                    @endforeach
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="jarallax" data-jarallax data-speed="0.1" style="height: 100vh;">
                        <img src="/images/travel.png" class="jarallax-img" alt="Image 2">
                        <div class="content"
                            style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                            <div style="width:100%;border-radius:30px; backdrop-filter: blur(5px); padding:5%; background-color:rgba(49, 49, 49, 0.5)"
                                class="bg-" data-aos="zoom-in-up" data-aos-delay="100">
                                <h2 class="text-5xl font-bold text-white text-center" data-aos="fade-up" data-aos-delay="200">
                                    @foreach ($travel as $x)
                                        <?php echo $x->name; ?>
                                    @endforeach
                                </h2>
                                <p class="text-white text-center mt-2" data-aos="fade-up" data-aos-delay="400">
                                    @foreach ($travel as $x)
                                        <?php echo $x->description; ?>
                                    @endforeach
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="jarallax" data-jarallax data-speed="0.1" style="height: 100vh;">
                        <img src="/images/tech.png" class="jarallax-img" alt="Image 2">
                        <div class="content"
                            style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                            <div style="width:100%;border-radius:30px; backdrop-filter: blur(5px); padding:5%; background-color:rgba(49, 49, 49, 0.5)"
                                class="bg-" data-aos="zoom-in-up" data-aos-delay="100">
                                <h2 class="text-5xl font-bold text-white text-center" data-aos="fade-up" data-aos-delay="200">
                                  @foreach ($tech as $x)
                                      <?php echo $x->name; ?>
                                  @endforeach
                              </h2>
                              <p class="text-white text-center mt-2" data-aos="fade-up" data-aos-delay="400">
                                  @foreach ($tech as $x)
                                      <?php echo $x->description; ?>
                                  @endforeach
                              </p>
                            </div>
                        </div>
                    </div>
                    <div class="jarallax" data-jarallax data-speed="0.1" style="height: 100vh;">
                        <img src="/images/fashion.png" class="jarallax-img" alt="Image 2">
                        <div class="content"
                            style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                            <div style="width:100%;border-radius:30px; backdrop-filter: blur(5px); padding:5%; background-color:rgba(49, 49, 49, 0.5)"
                                class="bg-" data-aos="zoom-in-up" data-aos-delay="100">
                                <h2 class="text-5xl font-bold text-white text-center" data-aos="fade-up" data-aos-delay="100">
                                  @foreach ($fashion as $x)
                                      <?php echo $x->name; ?>
                                  @endforeach
                              </h2>
                              <p class="text-white text-center mt-2" data-aos="fade-up" data-aos-delay="200">
                                  @foreach ($fashion as $x)
                                      <?php echo $x->description; ?>
                                  @endforeach
                              </p>
                            </div>
                        </div>
                    </div>
                    <div class="jarallax" data-jarallax data-speed="0.1" style="height: 100vh;">
                        <img src="/images/city.png" class="jarallax-img" alt="Image 2">
                        <div class="content"
                            style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                            <div style="width:100%;border-radius:30px; backdrop-filter: blur(5px); padding:5%; background-color:rgba(49, 49, 49, 0.5)"
                                class="bg-" data-aos="zoom-in-up" data-aos-delay="100">
                                <h2 class="text-5xl font-bold text-white text-center" data-aos="fade-up" data-aos-delay="200">
                                  @foreach ($city as $x)
                                      <?php echo $x->name; ?>
                                  @endforeach
                              </h2>
                              <p class="text-white text-center mt-2" data-aos="fade-up" data-aos-delay="400">
                                  @foreach ($city as $x)
                                      <?php echo $x->description; ?>
                                  @endforeach
                              </p>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    document.addEventListener('scroll', function() {
                        const jarallaxElements = document.querySelectorAll('.jarallax');
                        jarallaxElements.forEach(element => {
                            const rect = element.getBoundingClientRect();
                            if (rect.top < window.innerHeight && rect.bottom > 0) {
                                element.classList.add('in-view');
                            } else {
                                element.classList.remove('in-view');
                            }
                        });
                    });

                    jarallax(document.querySelectorAll('.jarallax'));
                </script>

                <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-16">
                    <div
                        class="mt-6 grid grid-cols-1 gap-x-8 gap-y-10 sm:grid-cols-2 lg:grid-cols-3 xl:gap-x-16"data-aos="fade-up-right">
                        <div class="group relative">
                            <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md bg-gray-200 lg:aspect-none group-hover:opacity-75 lg:h-80"
                                style="height: 400px">
                                <img src="/images/landscape.png" alt="Front of men&#039;s Basic Tee in black."
                                    class="h-full w-full object-cover object-center lg:h-full lg:w-full">
                            </div>
                            <div class="mt-4 flex justify-between">
                                <div>
                                    <h3 class="text-sm text-gray-700">
                                        <a href="#">
                                            <span aria-hidden="true" class="absolute inset-0"></span>
                                            <p class="font-bold">
                                                @foreach ($landscape as $x)
                                                    <?php echo $x->name; ?>
                                                @endforeach
                                            </p>
                                        </a>
                                    </h3>
                                    <p class="mt-1 text-sm text-gray-500">
                                        @foreach ($landscape as $x)
                                            <?php echo $x->description; ?>
                                        @endforeach
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="group relative">
                            <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md bg-gray-200 lg:aspect-none group-hover:opacity-75 lg:h-80"
                                style="height: 400px">
                                <img src="/images/animal.png" alt="Front of men&#039;s Basic Tee in black."
                                    class="h-full w-full object-cover object-center lg:h-full lg:w-full">
                            </div>
                            <div class="mt-4 flex justify-between">
                                <div>
                                    <h3 class="text-sm text-gray-700">
                                        <a href="#">
                                            <span aria-hidden="true" class="absolute inset-0"></span>
                                            <p class="font-bold">
                                                @foreach ($animal as $x)
                                                    <?php echo $x->name; ?>
                                                @endforeach
                                            </p>
                                        </a>
                                    </h3>
                                    <p class="mt-1 text-sm text-gray-500">
                                        @foreach ($animal as $x)
                                            <?php echo $x->description; ?>
                                        @endforeach
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="group relative">
                            <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md bg-gray-200 lg:aspect-none group-hover:opacity-75 lg:h-80"
                                style="height: 400px">
                                <img src="/images/travel.png" alt="Front of men&#039;s Basic Tee in black."
                                    class="h-full w-full object-cover object-center lg:h-full lg:w-full">
                            </div>
                            <div class="mt-4 flex justify-between">
                                <div>
                                    <h3 class="text-sm text-gray-700">
                                        <a href="#">
                                            <span aria-hidden="true" class="absolute inset-0"></span>
                                            <p class="font-bold">
                                                @foreach ($travel as $x)
                                                    <?php echo $x->name; ?>
                                                @endforeach
                                            </p>
                                        </a>
                                    </h3>
                                    <p class="mt-1 text-sm text-gray-500">
                                        @foreach ($travel as $x)
                                            <?php echo $x->description; ?>
                                        @endforeach
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="group relative">
                            <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md bg-gray-200 lg:aspect-none group-hover:opacity-75 lg:h-80"
                                style="height: 400px">
                                <img src="/images/tech.png" alt="Front of men&#039;s Basic Tee in black."
                                    class="h-full w-full object-cover object-center lg:h-full lg:w-full">
                            </div>
                            <div class="mt-4 flex justify-between">
                                <div>
                                    <h3 class="text-sm text-gray-700">
                                        <a href="#">
                                            <span aria-hidden="true" class="absolute inset-0"></span>
                                            <p class="font-bold">
                                                @foreach ($tech as $x)
                                                    <?php echo $x->name; ?>
                                                @endforeach
                                            </p>
                                        </a>
                                    </h3>
                                    <p class="mt-1 text-sm text-gray-500">
                                        @foreach ($tech as $x)
                                            <?php echo $x->description; ?>
                                        @endforeach
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="group relative">
                            <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md bg-gray-200 lg:aspect-none group-hover:opacity-75 lg:h-80"
                                style="height: 400px">
                                <img src="/images/fashion.png" alt="Front of men&#039;s Basic Tee in black."
                                    class="h-full w-full object-cover object-center lg:h-full lg:w-full">
                            </div>
                            <div class="mt-4 flex justify-between">
                                <div>
                                    <h3 class="text-sm text-gray-700">
                                        <a href="#">
                                            <span aria-hidden="true" class="absolute inset-0"></span>
                                            <p class="font-bold">
                                                @foreach ($fashion as $x)
                                                    <?php echo $x->name; ?>
                                                @endforeach
                                            </p>
                                        </a>
                                    </h3>
                                    <p class="mt-1 text-sm text-gray-500">
                                        @foreach ($fashion as $x)
                                            <?php echo $x->description; ?>
                                        @endforeach
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="group relative">
                            <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md bg-gray-200 lg:aspect-none group-hover:opacity-75 lg:h-80"
                                style="height: 400px">
                                <img src="/images/city.png" alt="Front of men&#039;s Basic Tee in black."
                                    class="h-full w-full object-cover object-center lg:h-full lg:w-full">
                            </div>
                            <div class="mt-4 flex justify-between">
                                <div>
                                    <h3 class="text-sm text-gray-700">
                                        <a href="#">
                                            <span aria-hidden="true" class="absolute inset-0"></span>
                                            <p class="font-bold">
                                                @foreach ($city as $x)
                                                    <?php echo $x->name; ?>
                                                @endforeach
                                            </p>
                                        </a>
                                    </h3>
                                    <p class="mt-1 text-sm text-gray-500">
                                        @foreach ($city as $x)
                                            <?php echo $x->description; ?>
                                        @endforeach
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <script></script>
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
                                    class="rounded-lg bg-gray-100 w-full h-full object-cover object-center">
                                @php
                                    $count = $count + 1;
                                @endphp
                            @endwhile
                        </div>
                        <div>

                            <div data-aos="fade-left">
                                <h2 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-4xl">Sáng tạo ảnh bằng
                                    AI</h2>
                                <p class="mt-4 text-2xs text-gray-500">Chúng tôi cung cấp hơn 20 chức năng tạo ảnh với công nghệ AI
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
                                                    <div
                                                        class="h-64 w-44 overflow-hidden rounded-lg sm:opacity-0 lg:opacity-100">
                                                        @php
                                                            $count = 1;
                                                        @endphp
                                                        <img src="https://pub-d9195d29f33243c7a4d4c49fe887131e.r2.dev/AI_home/{{ $count }}.png"
                                                            alt=""
                                                            class="h-full w-full object-cover object-center">
                                                    </div>
                                                    <div class="h-64 w-44 overflow-hidden rounded-lg">
                                                        <img src="https://pub-d9195d29f33243c7a4d4c49fe887131e.r2.dev/AI_home/{{ $count + 1 }}.png"
                                                            alt=""
                                                            class="h-full w-full object-cover object-center">
                                                    </div>
                                                </div>
                                                <div class="grid flex-shrink-0 grid-cols-1 gap-y-6 lg:gap-y-8">
                                                    <div class="h-64 w-44 overflow-hidden rounded-lg">
                                                        <img src="https://pub-d9195d29f33243c7a4d4c49fe887131e.r2.dev/AI_home/{{ $count + 2 }}.png"
                                                            alt=""
                                                            class="h-full w-full object-cover object-center">
                                                    </div>
                                                    <div class="h-64 w-44 overflow-hidden rounded-lg">
                                                        <img src="https://pub-d9195d29f33243c7a4d4c49fe887131e.r2.dev/AI_home/{{ $count + 3 }}.png"
                                                            alt=""
                                                            class="h-full w-full object-cover object-center">
                                                    </div>
                                                    <div class="h-64 w-44 overflow-hidden rounded-lg">
                                                        <img src="https://pub-d9195d29f33243c7a4d4c49fe887131e.r2.dev/AI_home/{{ $count + 4 }}.png"
                                                            alt=""
                                                            class="h-full w-full object-cover object-center">
                                                    </div>
                                                </div>
                                                <div class="grid flex-shrink-0 grid-cols-1 gap-y-6 lg:gap-y-8">
                                                    <div class="h-64 w-44 overflow-hidden rounded-lg">
                                                        <img src="https://pub-d9195d29f33243c7a4d4c49fe887131e.r2.dev/AI_home/{{ $count + 5 }}.png"
                                                            alt=""
                                                            class="h-full w-full object-cover object-center">
                                                    </div>
                                                    <div class="h-64 w-44 overflow-hidden rounded-lg">
                                                        <img src="https://pub-d9195d29f33243c7a4d4c49fe887131e.r2.dev/AI_home/{{ $count }}.png"
                                                            alt=""
                                                            class="h-full w-full object-cover object-center">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button><span class="text" style="font-weight: bold">Tạo ảnh ngay</span><span
                                            style="font-weight: bold">Bắt đầu!</span></button>
                                    <script>
                                        document.querySelector('button').addEventListener('click', function() {
                                            window.location.href = "{{ route('showworkflow') }}";
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
