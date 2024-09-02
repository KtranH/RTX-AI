@extends('User.Container')
@section('Body')

    <?php
    
        $cookie = request()->cookie("token_account");
        $user = DB::select("SELECT * FROM users WHERE email = ?", [$cookie])[0];

        $path = request()->path();
        $segments = explode('/', $path);
        $tab = end($segments);    
        
        // echo $tab;
        
    ?>

    <title>RTX-AI: Tài Khoản</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <main class="w-full h-full">
        <!-- Account -->
        <div class="flex items-center justify-center">
            <div class="w-full max-w-2xl px-4 py-4 sm:px-6 sm:py-6 lg:max-w-7xl lg:px-16">
                <div class="flex flex-col items-center lg:flex-row lg:items-center lg:justify-center space-y-6 lg:space-y-0 lg:space-x-6">
                    <!-- Avatar -->
                    <div class="relative text-center">
                        <img class="rounded-full w-40 h-40 object-cover" src="{{ $user->avatar_url }}" alt="User Avatar">
                        <div class="absolute inset-0 flex items-center justify-center opacity-0 hover:opacity-100 hover:!opacity-100 transition-opacity duration-300">
                            <a href="{{ route('showaccount') }}" class="bg-white p-2 rounded-full shadow-md w-full h-full border-8 border-[#a000ff] flex items-center justify-center">
                                <i class="fas fa-edit text-gray-700 text-5xl"></i>
                            </a>
                        </div>
                    </div>
                    <!-- Information -->
                    <div class="flex flex-col items-start">
                        <div class="font-bold text-3xl flex">
                            <div class="truncate hover:overflow-visible hover:whitespace-normal">{{ $user->username }}</div>
                            <img src="/assets/img/icon.png" alt="" class="w-10 ml-2">
                        </div>
                        <div class="text-gray-500 text-left truncate hover:overflow-visible hover:whitespace-normal">{{ $user->email }}</div>
                        <div class="flex">
                            <div class="cursor-pointer no-underline hover:text-[#a000ff]" onclick="openPopup('followers-popup')">
                                <span class="font-bold mr-1">5</span> Theo dõi
                            </div>
                            <div class="cursor-pointer no-underline hover:text-[#a000ff] ml-5" onclick="openPopup('following-popup')">
                                <span class="font-bold mr-1">10</span> Đang theo dõi
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Followers Popup -->
        <div id="followers-popup" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center hidden z-50">
            <div class="bg-white p-6 rounded-lg w-11/12 max-w-lg relative">
                <button onclick="closePopup('followers-popup')" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 flex items-center justify-center h-12 w-12">
                    <i class="fas fa-close text-2xl"></i>
                </button>
                <h2 class="text-xl font-bold mb-4">Theo Dõi</h2>
                <div class="max-h-64 overflow-y-auto">
                    <ul>
                        @for ($i = 0; $i <= 5; $i++)
                            <li class="py-2 flex">
                                <a href="#" class="flex items-center w-full">
                                    <img class="h-8 w-8 rounded-full ring-2 ring-white mr-2 truncate hover:overflow-visible hover:whitespace-normal" src="{{ $user->avatar_url }}" alt="">
                                    <p class="hover:text-[#a000ff] font-semibold truncate hover:overflow-visible hover:whitespace-normal">{{ $user->username }}</p>
                                </a>
                            </li>
                        @endfor
                    </ul>
                </div>
            </div>
        </div>
        <!-- Following Popup -->
        <div id="following-popup" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center hidden z-50">
            <div class="bg-white p-6 rounded-lg w-11/12 max-w-lg relative">
                <button onclick="closePopup('following-popup')" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 flex items-center justify-center h-12 w-12">
                    <i class="fas fa-close text-2xl"></i>
                </button>
                <h2 class="text-xl font-bold mb-4">Đang Theo Dõi</h2>
                <div class="max-h-64 overflow-y-auto">
                    <ul>
                        @for ($i = 0; $i <= 5; $i++)
                            <li class="py-2 flex">
                                <a href="#" class="flex items-center w-full">
                                    <img class="h-8 w-8 rounded-full ring-2 ring-white mr-2 truncate hover:overflow-visible hover:whitespace-normal" src="{{ $user->avatar_url }}" alt="">
                                    <p class="hover:text-[#a000ff] font-semibold truncate hover:overflow-visible hover:whitespace-normal">{{ $user->username }}</p>
                                </a>
                            </li>
                        @endfor
                    </ul>
                </div>
            </div>
            <script>
                function openPopup(popupId) 
                {
                    document.getElementById(popupId).classList.remove('hidden');
                }
                function closePopup(popupId) 
                {
                    document.getElementById(popupId).classList.add('hidden');
                }
            </script>
            <!-- Features  -->
            <div class="flex items-center justify-center">
                <div class="w-full max-w-2xl px-4 py-4 sm:px-6 sm:py-6 lg:max-w-7xl lg:px-16">
                    <div class="font-bold text-3xl">Ảnh nổi bật</div>
                    @if (count($feature) == 0)
                        <div class="mt-2 grid gap-2">
                            <div style="display:flex;margin-top:2%">
                                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="width:80px; margin-right:1%">
                                    <path d="M22.71,6.29a1,1,0,0,0-1.42,0L20,7.59V2a1,1,0,0,0-2,0V7.59l-1.29-1.3a1,1,0,0,0-1.42,1.42l3,3a1,1,0,0,0,.33.21.94.94,0,0,0,.76,0,1,1,0,0,0,.33-.21l3-3A1,1,0,0,0,22.71,6.29ZM19,13a1,1,0,0,0-1,1v.38L16.52,12.9a2.79,2.79,0,0,0-3.93,0l-.7.7L9.41,11.12a2.85,2.85,0,0,0-3.93,0L4,12.6V7A1,1,0,0,1,5,6h8a1,1,0,0,0,0-2H5A3,3,0,0,0,2,7V19a3,3,0,0,0,3,3H17a3,3,0,0,0,3-3V14A1,1,0,0,0,19,13ZM5,20a1,1,0,0,1-1-1V15.43l2.9-2.9a.79.79,0,0,1,1.09,0l3.17,3.17,0,0L15.46,20Zm13-1a.89.89,0,0,1-.18.53L13.31,15l.7-.7a.77.77,0,0,1,1.1,0L18,17.21Z" fill="#6563ff"/>
                                </svg>
                                <h3 style="margin-top:30px;font-size:20px;" class="text-gray-500">Bạn chưa có ảnh nào được đặt làm ảnh nổi bật!</h3>
                            </div>
                        </div>
                    @else
                        <div class="mt-2 gap-2 featured-photos">
                            @foreach ($feature as $x)
                                <div class="col-span-3 row-span-1 relative group">
                                    <a href="{{ route('showimage', ['id' => $x->id]) }}">
                                        <div class="aspect-square">
                                            <img src="{{ $x->url }}" alt="Image 1" class="w-full h-full object-cover transition-opacity duration-300 group-hover:opacity-15">
                                        </div>
                                        <div class="absolute inset-0 flex flex-col justify-between opacity-0 group-hover:opacity-100 group-hover:!opacity-100 transition-opacity duration-300">
                                            <div class="mt-2 text-left px-2 py-1">
                                                <div class="font-semibold text-lg truncate group-hover:text-[#000000]">{{ $x->title }}</div>
                                                <div class="text-sm text-gray-500 h-20 overflow-hidden">{{ $x->description }}</div>
                                            </div>
                                        </div>
                                    </a>    
                                </div>
                            @endforeach
                        </div>
                        <script>
                            $(document).ready(function(){
                                $('.featured-photos').slick({
                                    slidesToShow: 4,    
                                    slidesToScroll: 4,    
                                    infinite: true,       
                                    arrows: true,         
                                    dots: false        
                                });
                            });
                        </script>
                        <style>
                            .featured-photos
                            {
                                
                            }
                            .featured-photos img
                            {
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
                                color: black;
                            }
                            .featured-photos .slick-prev {
                                left: -50px; 
                            }

                            .featured-photos .slick-next {
                                right: -32px; 
                            }
                        </style>
                    @endif
                </div>
            </div>
            <!-- Tab -->
            <div class="flex items-center justify-center mt-5">
                <div class="w-full max-w-2xl px-4 py-4 sm:px-6 sm:py-6 lg:max-w-7xl lg:px-16 relative border-t">
                    <div class="flex justify-center space-x-4 mt-[-20px]">
                        <button id="saved" onclick="ActivateTab('saved')" class="text-xl px-4 py-2 text-gray-600 hover:text-black focus:outline-none relative">
                            Ảnh tải lên
                        </button>
                        <button id="created" onclick="ActivateTab('created')" class="text-xl px-4 py-2 text-gray-600 hover:text-black focus:outline-none relative">
                            Ảnh AI
                        </button>
                    </div>
                @endif
            </div>
        </div>
        <!-- Tab -->
        <div class="flex items-center justify-center mt-5">
            <div class="w-full max-w-2xl px-4 py-4 sm:px-6 sm:py-6 lg:max-w-7xl lg:px-16 relative border-t">
                <div class="flex justify-center space-x-4 mt-[-20px]">
                    <button id="saved" onclick="ActivateTab('saved')" class="text-xl px-4 py-2 text-gray-600 hover:text-black focus:outline-none relative">
                        Ảnh tải lên
                    </button>
                    <button id="created" onclick="ActivateTab('created')" class="text-xl px-4 py-2 text-gray-600 hover:text-black focus:outline-none relative">
                        Ảnh AI
                    </button>
                </div>
            </div>
        </div>
        <script>
            function ChangeApperance(id)
            {
                document.getElementById('created').classList.remove('font-bold', 'text-black');
                document.getElementById('saved').classList.remove('font-bold', 'text-black');
                document.getElementById('created').style.borderTop = '';
                document.getElementById('saved').style.borderTop = '';
                
                const active_tab = document.getElementById(id);
                active_tab.classList.add('font-bold', 'text-black');
                active_tab.style.borderTop = '4px solid black';
                active_tab.style.marginTop = '-4px';
            }
            
            function ActivateTab(id)
            {
                ChangeApperance(id);

                const new_path = `/board/${id}`;
                window.location.href = new_path;
            }
            const current_path = window.location.pathname;
            if (current_path.endsWith('/created')) 
            {
                ChangeApperance('created');
            } 
            else 
            {
                ChangeApperance('saved');
            }
        </script>
        <!-- Albums -->
        <div class="flex items-center justify-center">
            <div class="w-full max-w-2xl px-4 py-4 sm:px-6 sm:py-6 lg:max-w-7xl lg:px-16">
                <div class="font-bold text-3xl text-left">Album</div>
                @if (!$albums)
                    <div class="mt-2 flex justify-center">
                        <a href="{{ route('createalbum') }}" class="block aspect-square bg-gray-200 flex items-center justify-center rounded-lg group-hover:bg-[#a000ff] transition-colors duration-300 w-32 h-32">
                            <i class="fas fa-plus text-8xl text-gray-600 group-hover:text-white transition-colors duration-300"></i>
                        </a>
                    </div>
                @else
                    <div class="mt-2 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        <div class="relative group">
                            <a href="{{ route('createalbum') }}" class="block aspect-square bg-gray-200 flex items-center justify-center rounded-lg group-hover:bg-[#a000ff] transition-colors duration-300">
                                <i class="fas fa-plus text-8xl text-gray-600 group-hover:text-white transition-colors duration-300"></i>
                            </a>
                        </div>
                        @foreach ($albums as $x)
                            <div class="relative group">
                                <a href="{{ route('showalbum', ['id' => $x->id]) }}">
                                    <div class="aspect-square">
                                        <img src="{{ $x->cover_image }}" alt="Image 1" class="w-full h-full object-cover rounded-lg">
                                    </div>
                                    <div class="mt-2 text-left group-hover:text-[#a000ff]">
                                        <div class="font-semibold text-lg truncate">{{ $x->title }}</div>
                                        <div class="text-sm text-gray-500 truncate">{{ $x->description }}</div>
                                    </div>
                                    <div class="absolute top-2 right-2 flex space-x-2 opacity-0 group-hover:opacity-100 group-hover:!opacity-100 transition-opacity duration-300">
                                        <a href="#" class="bg-white p-2 rounded-full shadow-md flex items-center justify-center w-10 h-10">
                                            <i class="fas fa-lock text-gray-700 text-xl hover:text-[#a000ff]"></i>
                                        </a>
                                        <a href="{{ route('editalbum', ['id' => $x->id]) }}" class="bg-white p-2 rounded-full shadow-md flex items-center justify-center w-10 h-10">
                                            <i class="fas fa-edit text-gray-700 text-xl hover:text-[#a000ff]"></i>
                                        </a>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-2">
                        {{ $albums->links("vendor.pagination.simple-tailwind") }}
                    </div>
                @endif
            </div>
        </div>
        <!-- Gallery -->
        <div class="flex items-center justify-center">
            <div class="w-full max-w-2xl px-4 py-4 sm:px-6 sm:py-6 lg:max-w-7xl lg:px-16 mt-2">
                <div class="font-bold text-3xl text-left">Thư viện</div>
                @if (count($photos) == 0)
                    <div class="mt-2 flex justify-center items-center">
                        <div class="flex items-center">
                            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="w-20 h-20 mr-4">
                                <path d="M22.71,6.29a1,1,0,0,0-1.42,0L20,7.59V2a1,1,0,0,0-2,0V7.59l-1.29-1.3a1,1,0,0,0-1.42,1.42l3,3a1,1,0,0,0,.33.21.94.94,0,0,0,.76,0,1,1,0,0,0,.33-.21l3-3A1,1,0,0,0,22.71,6.29ZM19,13a1,1,0,0,0-1,1v.38L16.52,12.9a2.79,2.79,0,0,0-3.93,0l-.7.7L9.41,11.12a2.85,2.85,0,0,0-3.93,0L4,12.6V7A1,1,0,0,1,5,6h8a1,1,0,0,0,0-2H5A3,3,0,0,0,2,7V19a3,3,0,0,0,3,3H17a3,3,0,0,0,3-3V14A1,1,0,0,0,19,13ZM5,20a1,1,0,0,1-1-1V15.43l2.9-2.9a.79.79,0,0,1,1.09,0l3.17,3.17,0,0L15.46,20Zm13-1a.89.89,0,0,1-.18.53L13.31,15l.7-.7a.77.77,0,0,1,1.1,0L18,17.21Z" fill="#6563ff"/>
                            </svg>
                            <h3 class="text-gray-500 text-lg">Bạn chưa có bất kì ảnh nào. Hãy tạo album và đăng ảnh ngay!</h3>
                        </div>
                    @else
                        <div class="mt-2 grid grid-cols-12 gap-2">
                            @foreach ($photos as $x)
                                <div class="col-span-3 row-span-1 relative group">
                                    <a href="{{ route('showimage', ['id' => $x->id]) }}">
                                        <div class="aspect-square">
                                            <img src="{{ $x->url }}" style="border-radius:30px" alt="Image 1" class="w-full h-full object-cover transition-opacity duration-300 group-hover:opacity-15">
                                        </div>
                                        <div class="absolute inset-0 flex flex-col justify-between opacity-0 group-hover:opacity-100 group-hover:!opacity-100 transition-opacity duration-300">
                                            <div class="mt-2 text-left px-2 py-1">
                                                <div class="font-semibold text-lg truncate group-hover:text-[#000000]">{{ $x->title }}</div>
                                                <div class="text-sm text-gray-500 h-20 overflow-hidden">{{ $x->description }}</div>
                                            </div>
                                        </div>
                                    </a>    
                                    <div class="absolute inset-x-0 bottom-0 flex justify-center p-2 opacity-0 group-hover:opacity-100 group-hover:!opacity-100 transition-opacity duration-300">
                                        <div class="flex space-x-2">
                                            @if ($x->is_feature)
                                                <a href="{{ route('featureimage', ['id' => $x->id]) }}" class="bg-white p-2 rounded-full shadow-md flex items-center justify-center w-10 h-10">
                                                    <i class="fas fa-star text-yellow-500 text-xl hover:text-[#a000ff]"></i>
                                                </a>                                                
                                            @else
                                                <a href="{{ route('featureimage', ['id' => $x->id]) }}" class="bg-white p-2 rounded-full shadow-md flex items-center justify-center w-10 h-10">
                                                    <i class="fas fa-star text-gray-700 text-xl hover:text-[#a000ff]"></i>
                                                </a>    
                                            @endif
                                            <a href="#" class="bg-white p-2 rounded-full shadow-md flex items-center justify-center w-10 h-10">
                                                <i class="fas fa-share text-gray-700 text-xl hover:text-[#a000ff]"></i>
                                            </a>
                                        </div>
                                    </div>
                                </a>
                                <div class="absolute inset-x-0 bottom-0 flex justify-center p-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <div class="flex space-x-2">
                                        <a href="#" class="bg-white p-2 rounded-full shadow-md flex items-center justify-center w-10 h-10">
                                            <i class="fas fa-star text-gray-700 text-xl hover:text-[#a000ff]"></i>
                                        </a>
                                        <a href="#" class="bg-white p-2 rounded-full shadow-md flex items-center justify-center w-10 h-10">
                                            <i class="fas fa-share text-gray-700 text-xl hover:text-[#a000ff]"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </main>
@endsection