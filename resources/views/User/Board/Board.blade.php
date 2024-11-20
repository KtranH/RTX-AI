@extends('User.Container')
@section('Body')
    <?php
    $path = request()->path();
    $segments = explode('/', $path);
    $tab = end($segments);
    ?>

    <style>
        .featured-photos {}

        .featured-photos img {
            border-radius: 30px;
        }

        .featured-photos .slick-slide {
            margin: 0 4px;
        }

        .featured-photos .slick-list {
            margin: 0 -10px;
        }

        .featured-photos .slick-prev:before,
        .featured-photos .slick-next:before {
            font-size: 40px;
            color: white;
        }

        .featured-photos .slick-prev {
            left: -5px;
            z-index: 1000;
        }

        .featured-photos .slick-next {
            right: 15px;
            z-index: 1000;
        }
    </style>


    <title>RTX-AI: Tài Khoản</title>
    <main class="w-full h-full" style="margin-bottom:100px">
        <!-- Account -->
        <div class="flex items-center justify-center">
            <div class="absolute inset-x-0 -top-5 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-5" aria-hidden="true">
                <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]"
                    style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)">
                </div>
            </div>
            <div class="w-full max-w-2xl px-4 py-4 sm:px-6 sm:py-6 lg:max-w-7xl lg:px-16">
                <div
                    class="flex flex-col items-center lg:flex-row lg:items-center lg:justify-center space-y-6 lg:space-y-0 lg:space-x-6">
                    <!-- Avatar -->
                    <div class="relative text-center" data-aos="fade-up">
                        <img class="rounded-full w-40 h-40 object-cover" src="{{ $user->avatar_url }}" loading="lazy"
                            alt="User Avatar">
                        @if ($user->id == Auth::user()->id)
                            <div
                                class="absolute inset-0 flex items-center justify-center opacity-0 hover:opacity-100 hover:!opacity-100 transition-opacity duration-300">
                                <a href="{{ route('showaccount') }}"
                                    class="bg-white p-2 rounded-full shadow-md w-full h-full border-8 border-[#a000ff] flex items-center justify-center">
                                    <i class="fas fa-edit text-gray-700 text-5xl"></i>
                                </a>
                            </div>
                        @endif
                    </div>
                    <!-- Information -->
                    <div class="flex flex-col items-start">
                        <div class="flex items-center font-bold text-3xl space-x-2" data-aos="fade-up" data-aos-delay="100">

                            <div class="truncate hover:overflow-visible hover:whitespace-normal">
                                {{ $user->username }}
                            </div>
                            
                            <img src="/assets/img/icon.png" 
                                 alt="Icon" 
                                 class="w-8 h-8 text-purple-500 transform transition-transform duration-300 hover:scale-110" loading="lazy">
                        
                            @if ($user->id != Auth::user()->id)
                                    <button class="cancel-follow-btn bg-gradient-to-r from-purple-500 to-pink-500 text-xs text-white font-bold px-4 py-2 rounded-full transition-colors duration-300 hover:from-purple-600 hover:to-pink-600">
                                        Hủy theo dõi
                                    </button>  
                                    <button class="follow-btn bg-gradient-to-r from-purple-500 to-pink-500 text-xs text-white font-bold px-4 py-2 rounded-full transition-colors duration-300 hover:from-purple-600 hover:to-pink-600">
                                        Theo dõi
                                    </button>
                            @endif
                        </div>                        
                        <div class="text-gray-500 text-left truncate hover:overflow-visible hover:whitespace-normal" data-aos="fade-up" data-aos-delay="300">
                            {{ $user->email }}</div>
                        <div class="flex">
                            <div class="followers cursor-pointer no-underline hover:text-[#a000ff]"
                                onclick="openPopup('followers-popup')" data-aos="fade-up" data-aos-delay="400">
                                <span class="font-bold mr-1 followers-count">{{ $user->followers_count }}</span> Theo dõi
                            </div>
                            <div class="following cursor-pointer no-underline hover:text-[#a000ff] ml-5"
                                onclick="openPopup('following-popup')" data-aos="fade-up" data-aos-delay="450">
                                <span class="font-bold mr-1 following-count">{{ $user->following_count }}</span> Đang theo dõi
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                @if (!$isFollowing)
                    $('.cancel-follow-btn').hide();
                @else
                    $('.follow-btn').hide();
                @endif

                $('.follow-btn').click(function() {
                    var userId = {{ $user->id }};
                    var followButton = $(this);
                    var cancelFollowButton = $('.cancel-follow-btn');

                    $.ajax({
                        url: '/follow',
                        type: 'POST',
                        data: {
                            user_id: userId,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {

                                followButton.css('display', 'none');

                                cancelFollowButton.css('display', 'inline-block');

                                var followersCount = parseInt($('.followers-count').text()) + 1;
                                
                                $('.followers-count').text(followersCount);

                                const toast = Swal.mixin({
                                    toast: true,
                                    position: 'bottom-left',
                                    showConfirmButton: false,
                                    timer: 3000
                                });

                                toast.fire({
                                    title: 'Thông báo',
                                    color: 'white',
                                    text: 'Đã theo dõi người dùng!',
                                    icon: 'success',
                                    iconColor: 'white',
                                    background: '#46DFB1',
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', error);
                            alert('Có lỗi xảy ra khi theo dõi.');
                        }
                    });
                });

                $('.cancel-follow-btn').click(function() {
                    var userId = {{ $user->id }};
                    var cancelFollowButton = $(this);
                    var followButton = $('.follow-btn');

                    $.ajax({
                        url: '/unfollow',
                        type: 'DELETE',
                        data: {
                            user_id: userId,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {

                                cancelFollowButton.css('display', 'none');

                                followButton.css('display', 'inline-block');
                                
                                var followersCount = parseInt($('.followers-count').text()) - 1;
                                
                                $('.followers-count').text(followersCount);

                                const toast = Swal.mixin({
                                    toast: true,
                                    position: 'bottom-left',
                                    showConfirmButton: false,
                                    timer: 3000
                                });

                                toast.fire({
                                    title: 'Thông báo',
                                    color: 'white',
                                    text: 'Đã hủy theo dõi người dùng!',
                                    icon: 'success',
                                    iconColor: 'white',
                                    background: '#46DFB1'
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', error);
                            alert('Có lỗi xảy ra khi hủy theo dõi.');
                        }
                    });
                });
            });
        </script>   
        <!-- Followers Popup -->
        <div id="followers-popup"
            class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center hidden z-50">
            <div class="bg-white p-6 rounded-lg w-11/12 max-w-lg relative">
                <button onclick="closePopup('followers-popup')"
                    class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 flex items-center justify-center h-12 w-12">
                    <i class="fas fa-close text-2xl"></i>
                </button>
                <h2 class="text-xl font-bold mb-4">Theo Dõi</h2>
                <div class="max-h-64 overflow-y-auto">
                    <ul>
                        @foreach ($user->followers as $x)
                            <li class="py-2 flex">
                                <a href="{{ route("showboard", ["id" => $x->id]) }}" class="flex items-center w-full">
                                    <img class="h-8 w-8 rounded-full ring-2 ring-white mr-2 truncate hover:overflow-visible hover:whitespace-normal"
                                        src="{{ $x->avatar_url }}" alt="">
                                    <p
                                        class="hover:text-[#a000ff] font-semibold truncate hover:overflow-visible hover:whitespace-normal">
                                        {{ $x->username }}
                                    </p>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <!-- Following Popup -->
        <div id="following-popup"
            class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center hidden z-50">
            <div class="bg-white p-6 rounded-lg w-11/12 max-w-lg relative">
                <button onclick="closePopup('following-popup')"
                    class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 flex items-center justify-center h-12 w-12">
                    <i class="fas fa-close text-2xl"></i>
                </button>
                <h2 class="text-xl font-bold mb-4">Đang Theo Dõi</h2>
                <div class="max-h-64 overflow-y-auto">
                    <ul>
                        @foreach ($user->following as $x)
                            <li class="py-2 flex">
                                <a href="{{ route("showboard", ["id" => $x->id]) }}" class="flex items-center w-full">
                                    <img class="h-8 w-8 rounded-full ring-2 ring-white mr-2 truncate hover:overflow-visible hover:whitespace-normal"
                                        src="{{ $x->avatar_url }}" alt="">
                                    <p
                                        class="hover:text-[#a000ff] font-semibold truncate hover:overflow-visible hover:whitespace-normal">
                                        {{ $x->username }}
                                    </p>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <script>
            function openPopup(popupId) {
                document.getElementById(popupId).classList.remove('hidden');
            }

            function closePopup(popupId) {
                document.getElementById(popupId).classList.add('hidden');
            }
        </script>
        <!-- Features  -->
        <div class="flex items-center justify-center">
            <div class="w-full max-w-2xl px-4 py-4 sm:px-6 sm:py-6 lg:max-w-7xl lg:px-16">
                <div class="font-bold text-3xl" data-aos="fade-right" data-aos-delay="600">Ảnh nổi bật</div>
                @if (count($feature) == 0)
                    <div class="mt-2 grid gap-2" data-aos="fade-up" data-aos-delay="700">
                        <div class="flex items-center mt-2">
                            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="w-20 h-20 mr-4">
                                <path
                                    d="M22.71,6.29a1,1,0,0,0-1.42,0L20,7.59V2a1,1,0,0,0-2,0V7.59l-1.29-1.3a1,1,0,0,0-1.42,1.42l3,3a1,1,0,0,0,.33.21.94.94,0,0,0,.76,0,1,1,0,0,0,.33-.21l3-3A1,1,0,0,0,22.71,6.29ZM19,13a1,1,0,0,0-1,1v.38L16.52,12.9a2.79,2.79,0,0,0-3.93,0l-.7.7L9.41,11.12a2.85,2.85,0,0,0-3.93,0L4,12.6V7A1,1,0,0,1,5,6h8a1,1,0,0,0,0-2H5A3,3,0,0,0,2,7V19a3,3,0,0,0,3,3H17a3,3,0,0,0,3-3V14A1,1,0,0,0,19,13ZM5,20a1,1,0,0,1-1-1V15.43l2.9-2.9a.79.79,0,0,1,1.09,0l3.17,3.17,0,0L15.46,20Zm13-1a.89.89,0,0,1-.18.53L13.31,15l.7-.7a.77.77,0,0,1,1.1,0L18,17.21Z"
                                    fill="#6563ff" />
                            </svg>
                            <h3 class="text-gray-500 text-lg">Bạn chưa có ảnh nào được đặt làm ảnh nổi bật!</h3>
                        </div>
                    </div>
                @else
                    <div class="mt-2 grid-cols-1 gap-2 featured-photos" data-aos="fade-right" data-aos-delay="150">
                        @foreach ($feature as $x)
                            <div class="relative group">
                                <a href="{{ route('showimage', ['id' => $x->id]) }}">
                                    <div class="aspect-square group-hover:opacity-20 w-[407px] md:w-[307px]">
                                        <img 
                                            data-lazy="{{ $x->url }}" 
                                            loading="lazy" 
                                            alt="Image 1" 
                                            class="w-full h-full object-cover transition-opacity duration-300 group-hover:opacity-15 rounded-2xl"
                                        >
                                    </div>
                                    <div
                                        class="absolute inset-0 flex flex-col justify-between opacity-0 group-hover:opacity-50 group-hover:!opacity-100 transition-opacity duration-300">
                                        <div class="mt-2 text-left px-2 py-1">
                                            <div class="font-semibold text-lg truncate group-hover:text-[#000000]">
                                                {{ $x->title }}</div>
                                            <div class="text-sm text-gray-500 h-20 overflow-hidden">{{ $x->description }}
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="absolute inset-x-0 bottom-0 flex justify-center p-2 opacity-0 group-hover:opacity-50 group-hover:!opacity-100 transition-opacity duration-300">
                                        <div class="flex space-x-2">
                                           @if (Auth::user()->id == $x->album->user->id)
                                            @if ($x->is_feature)
                                                <a href=""
                                                    class="bg-white p-2 rounded-full shadow-md flex items-center justify-center w-10 h-10 feature-image" data-photo-id="{{ $x->id }}">
                                                    <i class="fas fa-star text-yellow-500 text-xl hover:text-[#a000ff]"></i>
                                                </a>
                                            @else
                                                <a href=""
                                                    class="bg-white p-2 rounded-full shadow-md flex items-center justify-center w-10 h-10 feature-image" data-photo-id="{{ $x->id }}">
                                                    <i class="fas fa-star text-gray-700 text-xl hover:text-[#a000ff]"></i>
                                                </a>
                                            @endif
                                           @endif
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
        <script>
            $(document).ready(function() {
                $('.featured-photos').slick({
                    lazyLoad: 'ondemand',
                    slidesToShow: 4,
                    slidesToScroll: 1,
                    variableWidth: true,
                    infinite: false,
                    arrows: true,
                    dots: false,
                    responsive: [{
                            breakpoint: 768,
                            settings: {
                                slidesToShow: 3,
                                slidesToScroll: 1,
                                arrows: true,
                                dots: false
                            }
                        },
                        {
                            breakpoint: 480,
                            settings: {
                                slidesToShow: 1,
                                slidesToScroll: 1,
                                arrows: true,
                                dots: false
                            }
                        }
                    ]
                });
                $(document).ready(function() {
                    $('.feature-image').click(function(e) {
                        e.preventDefault(); 
                        let photoId = $(this).data('photo-id');
                        let $slickSlide = $(this).closest('.relative.group');
                        let $slickSlider = $slickSlide.closest('.slick-slider');

                        if (!photoId) {
                            Swal.fire({
                                icon: 'error',
                                iconColor: 'white',
                                title: 'Lỗi: Không xác định ID ảnh.',
                                color: 'white',
                                showConfirmButton: false,
                                timer: 3000,
                                toast: true,
                                position: 'bottom-left',
                                background: '#F04770'
                            });
                            return;
                        }

                        $.ajax({
                            url: '/featureimage',
                            type: 'POST',
                            data: {
                                photo_id: photoId,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                let slideIndex = $slickSlide.data('slick-index');
                                $slickSlider.slick('slickRemove', slideIndex);
                                $slickSlider.slick('refresh');

                                Swal.fire({
                                    icon: 'success',
                                    iconColor: 'white',
                                    title: 'Đã cập nhật ảnh nổi bật',
                                    color: 'white',
                                    showConfirmButton: false,
                                    timer: 3000,
                                    toast: true,
                                    position: 'bottom-left',
                                    background: '#46DFB1'
                                });
                            },
                            error: function(xhr, status, error) {
                                console.error('Error:', error);
                                Swal.fire({
                                    icon: 'error',
                                    iconColor: 'white',
                                    title: 'Có lỗi xảy ra. Vui lòng thử lại sau.',
                                    color: 'white',
                                    showConfirmButton: false,
                                    timer: 3000,
                                    toast: true,
                                    position: 'bottom-left',
                                    background: '#F04770'
                                });
                            }
                        });
                    });
                });
            });
        </script>
        <!-- Tab -->
        <div class="flex items-center justify-center mt-5">
            <div class="w-full max-w-2xl px-4 py-4 sm:px-6 sm:py-6 lg:max-w-7xl lg:px-16 relative border-t">
                <div class="flex justify-center space-x-4 mt-[-20px]">
                    <button id="uploaded" onclick="ActivateTab('uploaded')"
                        class="text-xl px-4 py-2 text-gray-600 hover:text-black focus:outline-none relative">
                        Ảnh tải lên
                    </button>
                    <button id="saved" onclick="ActivateTab('saved')"
                        class="text-xl px-4 py-2 text-gray-600 hover:text-black focus:outline-none relative">
                        Ảnh đã lưu
                    </button>
                    <button id="created" onclick="ActivateTab('created')"
                        class="text-xl px-4 py-2 text-gray-600 hover:text-black focus:outline-none relative">
                        Ảnh AI
                    </button>
                </div>
            </div>
        </div>
        <script>
            function ChangeApperance(id) {
                const tabs = ['uploaded', 'saved', 'created'];

                tabs.forEach(tabId => {
                    const tab = document.getElementById(tabId);
                    tab.classList.remove('font-bold', 'text-black');
                    tab.style.borderTop = '';
                    tab.style.marginTop = '';
                });

                const active_tab = document.getElementById(id);
                active_tab.classList.add('font-bold', 'text-black');
                active_tab.style.borderTop = '4px solid black';
                active_tab.style.marginTop = '-4px';
            }

            function ActivateTab(id) {

                ChangeApperance(id);
                const contents = ['uploaded-content', 'saved-content', 'created-content'];

                contents.forEach(contentId => {
                    const content = document.getElementById(contentId);
                    if (contentId === `${id}-content`) {
                        content.classList.remove('hidden');
                    } else {
                        content.classList.add('hidden');
                    }
                    console.log(content)
                });
            }

            document.addEventListener('DOMContentLoaded', function () {
                const current_path = window.location.pathname; 
                let savedTab = localStorage.getItem('activeTab');

                if (current_path.endsWith('/uploaded') || savedTab === 'uploaded') {
                    ActivateTab('uploaded');
                } else if (current_path.endsWith('/created') || savedTab === 'created') {
                    ActivateTab('created');
                } else if (current_path.endsWith('/saved') || savedTab === 'saved') {
                    ActivateTab('saved'); 
                } else {
                    ActivateTab('uploaded');
                }
            });
        </script>
        <!-- Uploaded Content -->
        <div id="uploaded-content" class="tab-content">
            <style>
                #albums-section_board,
                #gallery-section_board {
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    width: 100%;
                    max-width: 1300px;
                    margin: auto;
                }
            </style>
            <!-- Albums -->
            <div id="albums-section_board" class="flex items-center justify-center">
                <div class="w-full max-w-2xl px-4 py-4 sm:px-6 sm:py-6 lg:max-w-7xl lg:px-16">
                    <div class="font-bold text-3xl text-left">Album</div>
                    @if (!$albums)
                       @if (Auth::user()->id == $user->id)
                        <div class="mt-2 flex justify-center">
                            <a href="{{ route('createalbum') }}"
                                class="block aspect-square bg-gray-200 flex items-center justify-center group-hover:bg-[#a000ff] transition-colors duration-300 w-32 h-32 rounded-2xl border-4 border-indigo-600">
                                <i
                                    class="fas fa-plus text-8xl text-gray-600 group-hover:text-white transition-colors duration-300">
                                </i>
                            </a>
                        </div>
                       @endif
                    @else
                        <div class="mt-2 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            @if (Auth::user()->id == $user->id)
                                <div class="relative group">
                                    <a href="{{ route('createalbum') }}"
                                        class="block aspect-square bg-gray-200 flex items-center justify-center group-hover:bg-[#a000ff] transition-colors duration-300 rounded-2xl border-4 border-[]">
                                        <i
                                            class="fas fa-plus text-8xl text-gray-600 group-hover:text-white transition-colors duration-300">
                                        </i>
                                    </a>
                                </div>
                            @endif
                            @foreach ($albums as $x)
                                <div class="relative group">
                                    @if ($x->is_private == 0)
                                        <a href="{{ route('showalbum', ['id' => $x->id]) }}">
                                    @else
                                        <a class="private-album" href="">
                                        <script>
                                            $(document).ready(function() {
                                                $('.private-album').click(function(event) {
                                                    event.preventDefault();
                                                    Swal.fire({
                                                        icon: 'error',
                                                        title: 'Thông báo',
                                                        text: 'Album này đang ở chế độ riêng tư!',
                                                        showCancelButton: false,
                                                        showConfirmButton: false,
                                                        timer: 1500
                                                    })
                                                });
                                            });
                                        </script>
                                    @endif
                                        <div class="aspect-square">
                                            <img src="{{ $x->cover_image }}" loading="lazy" alt="Image 1"
                                                class="w-full h-full object-cover rounded-2xl border-4 border-[]">
                                        </div>
                                        <div class="mt-2 text-left group-hover:text-[#a000ff]">
                                            <div class="font-semibold text-lg truncate">{{ $x->title }}</div>
                                            <div class="text-sm text-gray-500 truncate">{{ $x->description }}</div>
                                        </div>
                                        @if (Auth::user()->id == $x->user->id)
                                            <div class="absolute top-2 right-2 flex space-x-2 opacity-0 group-hover:opacity-100 group-hover:!opacity-100 transition-opacity duration-300">
                                                <a href="" class="bg-white p-2 rounded-full shadow-md flex items-center justify-center w-10 h-10 private-button" data-album-id="{{ $x->id }}">
                                                    <i class="fas {{ $x->is_private ? 'fa-lock text-indigo-600' : 'fa-lock-open text-gray-700' }} text-xl hover:text-[#a000ff]"></i>
                                                </a>
                                                <a href="{{ route('editalbum', ['id' => $x->id]) }}"
                                                    class="bg-white p-2 rounded-full shadow-md flex items-center justify-center w-10 h-10">
                                                    <i class="fas fa-edit text-gray-700 text-xl hover:text-[#a000ff]"></i>
                                                </a>
                                            </div>
                                            <script>
                                                $(document).ready(function() {
                                                    $('.private-button[data-album-id="{{ $x->id }}"]').click(function(e) {
                                                        e.preventDefault();
                                                        let $button = $(this); 
                                                        Swal.fire({
                                                            icon: 'warning',
                                                            title: 'Cảnh báo',
                                                            text: 'Bạn có muốn chuyển quyền riêng tư của album?',
                                                            showCancelButton: true,
                                                            confirmButtonColor: '#3085d6',
                                                            cancelButtonColor: '#d33',
                                                            confirmButtonText: 'Có, chuyển quyền riêng tư',
                                                            cancelButtonText: 'Hủy bỏ'
                                                        }).then((result) => {
                                                        if (result.isConfirmed) {
                                                            var albumId = $button.data('album-id');
                                                            $.ajax({
                                                                url: '/privatealbum',
                                                                method: 'POST', 
                                                                data: {
                                                                    album_id: albumId,
                                                                    _token: '{{ csrf_token() }}'
                                                                },
                                                                success: function(response) {
                                                                    let $icon = $button.find('i');
                                                                    if (response.is_private) {
                                                                        $icon.removeClass('fa-lock-open text-gray-700')
                                                                            .addClass('fa-lock text-indigo-600');
                                                                    } else {
                                                                        $icon.removeClass('fa-lock text-indigo-600')
                                                                            .addClass('fa-lock-open text-gray-700');
                                                                    }
                                                                    Swal.fire({
                                                                        icon: 'success',
                                                                        iconColor: 'white',
                                                                        title: 'Thành công',
                                                                        text: 'Chuyển quyền riêng tư của album',
                                                                        color: 'white',
                                                                        showConfirmButton: false,
                                                                        timer: 3000,
                                                                        toast: true,
                                                                        position: 'bottom-left',
                                                                        background: '#46DFB1'
                                                                    });
                                                                },
                                                                error: function(xhr, status, error) {
                                                                    console.error(error);
                                                                    Swal.fire({
                                                                        icon: 'error',
                                                                        iconColor: 'white',
                                                                        title: 'Thao tác thất bại!',
                                                                        text: 'Vui lòng thử lại',
                                                                        color: 'white',
                                                                        showConfirmButton: false,
                                                                        timer: 3000,
                                                                        toast: true,
                                                                        position: 'bottom-left',
                                                                        background: '#F04770'
                                                                    });
                                                                }
                                                            });
                                                        }
                                                        })
                                                    });
                                                });
                                            </script>
                                        @endif
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-2">
                            {{ $albums->links('vendor.pagination.simple-tailwind') }}
                        </div>
                    @endif
                </div>
            </div>
            <!-- Gallery -->
            <div id="gallery-section_board" class="flex items-center justify-center">
                <div class="w-full max-w-2xl px-4 py-4 sm:px-6 sm:py-6 lg:max-w-7xl lg:px-16 mt-2">
                    <div class="font-bold text-3xl text-left">Thư viện</div>
                    <div class="mt-2 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2"
                        id="photo-container">

                    </div>

                    <div id="loading" class="text-center my-4" style="display: none;">Đang tải thêm ảnh...</div>

                    <script>
                        var page = 1;
                        var isLoading = false;
                        var hasMore = true; 

                        function loadPhotosNormal(initialLoad = false) {
                            if (isLoading || !hasMore) return; 
                            isLoading = true;

                            document.getElementById('loading').style.display = 'block';

                            fetch(`/api/board/?page=${page}&userId={{ $user->id }}`)
                                .then(response => response.json())
                                .then(data => {
                                    const photoContainer = document.getElementById('photo-container');

                                    if (data.photos.length === 0) {
                                        hasMore = false;
                                        document.getElementById('loading').style.display = 'none';
                                        return;
                                    }

                                    data.photos.forEach(photo => {
                                        const photoHTML = `
                                            <div class="relative group">
                                                <a href="/image/${photo.id}">
                                                    <div class="aspect-square">
                                                        <img src="${photo.url}" loading="lazy" alt="Image" class="w-full h-full rounded-2xl object-cover transition-opacity duration-300 group-hover:opacity-15">
                                                    </div>
                                                    <div class="absolute inset-0 flex flex-col justify-between opacity-0 group-hover:opacity-100 group-hover:!opacity-100 transition-opacity duration-300">
                                                        <div class="mt-2 text-left px-2 py-1">
                                                            <div class="font-semibold text-lg truncate group-hover:text-[#000000]">${photo.title}</div>
                                                            <div class="text-sm text-gray-500 h-20 overflow-hidden">${photo.description}</div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>`;
                                        photoContainer.insertAdjacentHTML('beforeend', photoHTML);
                                    });

                                    isLoading = false;
                                    document.getElementById('loading').style.display = 'none';

                                    hasMore = data.hasMorePages;
                                    if (hasMore) {
                                        page++;
                                    } else {
                                        window.removeEventListener('scroll', scrollHandlerNormal);
                                        document.getElementById('loading').style.display = 'none';
                                    }

                                    if (initialLoad && data.photos.length === 0) {
                                        document.getElementById('loading').innerText = 'Không có ảnh nào để hiển thị.';
                                    }
                                })
                                .catch(error => {
                                    console.error('Lỗi khi tải ảnh:', error);
                                    isLoading = false;
                                    hasMore = false; 
                                    document.getElementById('loading').style.display = 'none';
                                });
                        }

                        function debounce(func, wait) {
                            let timeout;
                            return function executedFunction(...args) {
                                const later = () => {
                                    clearTimeout(timeout);
                                    func(...args);
                                };
                                clearTimeout(timeout);
                                timeout = setTimeout(later, wait);
                            };
                        }

                        function scrollHandlerNormal() {
                            if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 200) {
                                loadPhotosNormal();
                            }
                        }

                        const debouncedScrollHandler = debounce(scrollHandlerNormal, 250);

                        window.addEventListener('load', () => {
                            loadPhotosNormal(true);
                        });

                        window.addEventListener('scroll', debouncedScrollHandler);
                    </script>
                </div>
            </div>
        </div>
        <!-- Saved Content -->
        <div id="saved-content" class="tab-content hidden">
            <div id="saved-section_board" class="flex items-center justify-center">
                <div class="w-full max-w-2xl px-4 py-4 sm:px-6 sm:py-6 lg:max-w-7xl lg:px-16 mt-2">            
                    <h2 class="font-bold text-3xl text-left">Danh sách ảnh đã lưu lại</h2>
                    <div class="mt-2 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2"id="saved-container">
                    </div>
                    <div id="loading_saved_image" class="text-center my-4" style="display: none;">Đang tải thêm ảnh...</div>
                    <script>
                        var pageSaved = 1;
                        var isLoadingSaved = false;
                    
                        function loadPhotosSaved(initialLoad = false) {
                            if (isLoadingSaved) return;
                            isLoadingSaved = true;
                    
                            document.getElementById('loading_saved_image').style.display = 'block';
                    
                            fetch(`/api/Saved_Image/board/?pageSaved=${pageSaved}&userId={{ $user->id }}`)
                                .then(response => response.json())
                                .then(data => {
                                    const photoContainer = document.getElementById('saved-container');
                                    if (data.photos.length === 0) {
                                        document.getElementById('loading_saved_image').innerText = 'Không có ảnh nào để hiển thị.';
                                    }
                    
                                    data.photos.forEach(photo => {
                                        const photoHTML = `
                                           <div class="relative group">
                                                <a href="/image/${photo.photo.id}">
                                                    <div class="aspect-square">
                                                        <img src="${photo.photo.url}" loading="lazy" alt="Image" class="w-full h-full rounded-2xl object-cover transition-opacity duration-300 group-hover:opacity-15">
                                                    </div>
                                                    <div class="absolute inset-0 flex flex-col justify-between opacity-0 group-hover:opacity-100 group-hover:!opacity-100 transition-opacity duration-300">
                                                        <div class="mt-2 text-left px-2 py-1">
                                                            <div class="font-semibold text-lg truncate group-hover:text-[#000000]">${photo.photo.title}</div>
                                                            <div class="text-sm text-gray-500 h-20 truncate overflow-hidden">${photo.photo.description}</div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>`;
                                        photoContainer.insertAdjacentHTML('beforeend', photoHTML);
                                    });
                    
                                    isLoadingSaved = false;
                                    document.getElementById('loading_saved_image').style.display = 'none';
                    
                                    if (data.hasMorePages) {
                                        pageSaved++;
                                    } else {
                                        window.removeEventListener('scroll', scrollHandlerNormal);
                                    }
                                })
                                .catch(error => {
                                    console.error('Lỗi khi tải ảnh:', error);
                                    isLoadingSaved = false;
                                    document.getElementById('loading_saved_image').style.display = 'none';
                                });
                        }
                    
                        window.addEventListener('load', () => {
                            loadPhotosSaved(true);
                        });
                    
                        function scrollHandlerNormal() {
                            console.log('scroll event triggered'); 
                            if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 200) {
                                loadPhotosSaved();
                            }
                        }
                    
                        window.addEventListener('scroll', scrollHandlerNormal);
                    </script>                    
                </div>
            </div>
        </div>
        <!-- Created Content -->
        @if (Auth::user()->id == $user->id)
            <div id="created-content" class="tab-content hidden">
                <div class="flex items-center justify-center">
                    <div class="w-full max-w-2xl px-4 py-4 sm:px-6 sm:py-6 lg:max-w-7xl lg:px-16">
                        <h2 class="font-bold text-3xl text-left">Lịch sử tạo ảnh AI</h2>
                        <p class="text-gray-500 text-2xs text-left mt-2">Lưu ý chúng tôi chỉ lưu ảnh được tạo ra bởi AI trong
                            10 ngày!
                        </p>
                        <div class="mt-2 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2" id="AI-content"></div>
                        <div id="loading_AI_Image" class="text-center my-4" style="display: none;">Đang tải thêm ảnh...</div>
                        <script>
                            var pageAI = 1;
                            var isLoadingAI = false;
                            function loadPhotosAI(initialLoad = false) {
                                if (isLoadingAI) return;
                                isLoadingAI = true;

                                document.getElementById('loading_AI_Image').style.display = 'block';

                                fetch(`/api/AI_Image/board?pageAI=${pageAI}&userId={{ $user->id }}`)
                                    .then(response => response.json())
                                    .then(data => {
                                        const photoContainer = document.getElementById('AI-content');

                                        data.photos.forEach(photo => {
                                            const photoHTML = `
                                            <div class="relative group">
                                                <div class="aspect-square">
                                                    <img src="${photo.url}" loading="lazy" alt="AI Generated Image"
                                                        class="w-full h-full rounded-2xl object-cover transition-opacity duration-300 group-hover:opacity-50"
                                                        style="cursor: pointer;" onclick="openImageModal('${photo.url}')">
                                                </div>
                                            </div>`;
                                            photoContainer.insertAdjacentHTML('beforeend', photoHTML);
                                        });

                                        isLoadingAI = false;
                                        document.getElementById('loading_AI_Image').style.display = 'none';

                                        if (data.hasMorePages) {
                                            pageAI++;
                                        } else {
                                            window.removeEventListener('scroll', scrollHandlerAI);
                                        }

                                        if (initialLoad && data.photos.length === 0) {
                                            document.getElementById('loading_AI_Image').innerText = 'Không có ảnh nào để hiển thị.';
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Lỗi khi tải ảnh AI:', error);
                                        isLoadingAI = false;
                                        document.getElementById('loading_AI_Image').style.display = 'none';
                                    });
                            }

                            window.addEventListener('load', () => {
                                loadPhotosAI(true);
                            });

                            function scrollHandlerAI() {
                                if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 200) {
                                    loadPhotosAI();
                                }
                            }
                            window.addEventListener('scroll', scrollHandlerAI);
                        </script>
                    </div>
                </div>
            </div>
            <!-- Modal for Image -->
            <div id="image-modal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center hidden z-50"
                onclick="closeImageModal()">
                <div class="relative" onclick="event.stopPropagation();" style="margin-top: 1%; width:30%;">
                    <button onclick="closeImageModal()" class="absolute right-0 top-0 text-white text-2xl p-2"
                        style="transform: translate(50%, -50%);">
                        <p class="text-xl bg-white font-bold text-black p-2 rounded-full">X</p>
                    </button>
                    <img id="modal-image" src="" alt="Modal Image">
                </div>
            </div>
            <div class="mt-2 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2" id="main-content"></div>
            <script>
                function openImageModal(imageUrl) {
                    document.getElementById('modal-image').src = imageUrl;
                    document.getElementById('image-modal').classList.remove('hidden');
                }

                function closeImageModal() {
                    document.getElementById('image-modal').classList.add('hidden');
                }
            </script>
        @else
        <div id="created-content" class="tab-content hidden">
            <div class="flex items-center justify-center">
                <div class="w-full max-w-2xl px-4 py-4 sm:px-6 sm:py-6 lg:max-w-7xl lg:px-16">
                    <h2 class="font-bold text-3xl text-left">Bạn không được phép xem ảnh AI của người khác</h2>
                    <p class="text-gray-500 text-2xs text-left mt-2">Bạn chỉ có thể ảnh AI của chính mình
                    </p>
                </div>
            </div>
        </div>
        @endif
    </main>
@endsection
