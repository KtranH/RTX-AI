@extends('User.Container')
@section('Body')

    <?php
    
        $cookie = request()->cookie("token_account");
        $account = DB::select("SELECT * FROM users WHERE email = ?", [$cookie])[0];

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
                <div class="flex items-center justify-center space-x-6">
                    <div class="relative text-center">
                        <img class="rounded-full w-40 h-40 object-cover" src="{{ $account->avatar_url }}" alt="User Avatar">
                        <div class="absolute inset-0 flex items-center justify-center opacity-0 hover:opacity-100 hover:!opacity-100 transition-opacity duration-300">
                            <a href="{{ route('showaccount') }}" class="bg-white p-2 rounded-full shadow-md w-full h-full border-8 border-[#a000ff] flex items-center justify-center">
                                <i class="fas fa-edit text-gray-700 text-5xl"></i>
                            </a>
                        </div>
                    </div>
                    <div class="flex flex-col">
                        <div class="font-bold text-3xl flex items-center">
                            {{ $account->username }}
                            <img src="/assets/img/icon.png" alt="" class="w-10 ml-2">
                        </div>
                        <div class="text-gray-500">
                            {{ $account->email }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Features  -->
        <div class="flex items-center justify-center">
            <div class="w-full max-w-2xl px-4 py-4 sm:px-6 sm:py-6 lg:max-w-7xl lg:px-16">
                <div class="font-bold text-3xl">Ảnh Đặc Trưng</div>
                <div class="mt-2 grid grid-cols-12 gap-2">
                    <div class="relative col-span-3 row-span-1 aspect-square group">
                        <img src="https://via.placeholder.com/600x800" alt="Image 1" class="w-full h-full object-cover transition-opacity duration-300 group-hover:opacity-50">
                        <div class="absolute inset-0 flex flex-col justify-between opacity-0 group-hover:opacity-100 group-hover:!opacity-100 transition-opacity duration-300">
                            <div class="mt-2 text-left px-2 py-1">
                                <div class="font-semibold text-lg truncate">Hình 1</div>
                                <div class="text-sm text-gray-500 h-20 overflow-hidden">Mô Tả 1</div>
                            </div>    
                            <div class="flex justify-center p-2">
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
                    </div>
                    <div class="relative col-span-3 row-span-1 aspect-square group">
                        <img src="https://via.placeholder.com/800x600" alt="Image 2" class="w-full h-full object-cover transition-opacity duration-300 group-hover:opacity-50">
                        <div class="absolute inset-0 flex flex-col justify-between opacity-0 group-hover:opacity-100 group-hover:!opacity-100 transition-opacity duration-300">
                            <div class="mt-2 text-left px-2 py-1">
                                <div class="font-semibold text-lg truncate">Hình 2</div>
                                <div class="text-sm text-gray-500 h-20 overflow-hidden">Mô Tả 2</div>
                            </div>   
                            <div class="flex justify-center p-2">
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
                    </div>
                </div>
            </div>
        </div>
        <!-- Tab -->
        <div class="flex items-center justify-center mt-5">
            <div class="w-full max-w-2xl px-4 py-4 sm:px-6 sm:py-6 lg:max-w-7xl lg:px-16 relative border-t">
                <div class="flex justify-center space-x-4 mt-[-20px]">
                    <button id="saved" onclick="ActivateTab('saved')" class="text-xl px-4 py-2 text-gray-600 hover:text-black focus:outline-none relative">
                        Saved
                    </button>
                    <button id="created" onclick="ActivateTab('created')" class="text-xl px-4 py-2 text-gray-600 hover:text-black focus:outline-none relative">
                        Created
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
                <div class="font-bold text-3xl">Album</div>
                <div class="mt-2 grid grid-cols-12 gap-2">
                    <div class="col-span-3 row-span-1 relative group">
                        <div class="aspect-square">
                            <img src="https://via.placeholder.com/600x6100" alt="Image 1" class="w-full h-full object-cover rounded-lg">
                            <div class="absolute top-2 right-2 flex space-x-2 opacity-0 group-hover:opacity-100 group-hover:!opacity-100 transition-opacity duration-300">
                                <a href="#" class="bg-white p-2 rounded-full shadow-md flex items-center justify-center w-10 h-10">
                                    <i class="fas fa-lock text-gray-700 text-xl hover:text-[#a000ff]"></i>
                                </a>
                                <a href="#" class="bg-white p-2 rounded-full shadow-md flex items-center justify-center w-10 h-10">
                                    <i class="fas fa-edit text-gray-700 text-xl hover:text-[#a000ff]"></i>
                                </a>
                            </div>
                        </div>
                        <div class="mt-2 text-left">
                            <div class="font-semibold text-lg truncate">Tiêu Đề 1</div>
                            <div class="text-sm text-gray-500 truncate">Bán Tiêu Đề 1</div>
                        </div>
                    </div>
                    <div class="col-span-3 row-span-1 relative group">
                        <div class="aspect-square">
                            <img src="https://via.placeholder.com/6100x600" alt="Image 2" class="w-full h-full object-cover rounded-lg">
                            <div class="absolute top-2 right-2 flex space-x-2 opacity-0 group-hover:opacity-100 group-hover:!opacity-100 transition-opacity duration-300">
                                <a href="#" class="bg-white p-2 rounded-full shadow-md flex items-center justify-center w-10 h-10">
                                    <i class="fas fa-lock text-gray-700 text-xl hover:text-[#a000ff]"></i>
                                </a>
                                <a href="#" class="bg-white p-2 rounded-full shadow-md flex items-center justify-center w-10 h-10">
                                    <i class="fas fa-edit text-gray-700 text-xl hover:text-[#a000ff]"></i>
                                </a>
                            </div>
                        </div>
                        <div class="mt-2 text-left">
                            <div class="font-semibold text-lg truncate">Tiêu Đề 2</div>
                            <div class="text-sm text-gray-500 truncate">Bán Tiêu Đề 2</div>
                        </div>
                    </div>
                    <div class="col-span-3 row-span-1 relative group">
                        <a href="{{ route('createalbum') }}" class="block aspect-square bg-gray-200 flex items-center justify-center rounded-lg group-hover:bg-[#a000ff] transition-colors duration-300">
                            <i class="fas fa-plus text-8xl text-gray-600 group-hover:text-white transition-colors duration-300"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Gallery -->
        <div class="flex items-center justify-center">
            <div class="w-full max-w-2xl px-4 py-4 sm:px-6 sm:py-6 lg:max-w-7xl lg:px-16 mt-2">
                <div class="font-bold text-3xl">Thư Viện</div>
                <div class="mt-2 grid grid-cols-12 gap-2">
                    <div class="col-span-3 row-span-1 aspect-square">
                        <img src="https://via.placeholder.com/600x600" alt="Image 1" class="w-full h-full object-cover">
                    </div>
                    <div class="col-span-3 row-span-1 aspect-square">
                        <img src="https://via.placeholder.com/600x600" alt="Image 2" class="w-full h-full object-cover">
                    </div>
                    <div class="col-span-3 row-span-1 aspect-square">
                        <img src="https://via.placeholder.com/600x600" alt="Image 3" class="w-full h-full object-cover">
                    </div>
                    <div class="col-span-3 row-span-1 aspect-square">
                        <img src="https://via.placeholder.com/600x600" alt="Image 4" class="w-full h-full object-cover">
                    </div>
                    <div class="col-span-3 row-span-1 aspect-square">
                        <img src="https://via.placeholder.com/600x600" alt="Image 1" class="w-full h-full object-cover">
                    </div>
                    <div class="col-span-3 row-span-1 aspect-square">
                        <img src="https://via.placeholder.com/600x600" alt="Image 2" class="w-full h-full object-cover">
                    </div>
                    <div class="col-span-3 row-span-1 aspect-square">
                        <img src="https://via.placeholder.com/600x600" alt="Image 3" class="w-full h-full object-cover">
                    </div>
                    <div class="col-span-3 row-span-1 aspect-square">
                        <img src="https://via.placeholder.com/600x600" alt="Image 4" class="w-full h-full object-cover">
                    </div>
                    <div class="col-span-3 row-span-1 aspect-square">
                        <img src="https://via.placeholder.com/600x600" alt="Image 1" class="w-full h-full object-cover">
                    </div>
                    <div class="col-span-3 row-span-1 aspect-square">
                        <img src="https://via.placeholder.com/600x600" alt="Image 2" class="w-full h-full object-cover">
                    </div>
                    <div class="col-span-3 row-span-1 aspect-square">
                        <img src="https://via.placeholder.com/600x600" alt="Image 3" class="w-full h-full object-cover">
                    </div>
                    <div class="col-span-3 row-span-1 relative group">
                        <a href="#" class="block aspect-square bg-gray-200 flex items-center justify-center group-hover:bg-[#a000ff] transition-colors duration-300">
                            <i class="fas fa-plus text-8xl text-gray-600 group-hover:text-white transition-colors duration-300"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection