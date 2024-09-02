@extends('User.Container')
@section('Body')

    <title>RTX-AI: Album</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <main class="w-full h-full" style="margin-bottom:10%">
        <!-- Return -->
        <div class="flex justify-center">
            <a href="{{ route('showboard') }}" class="text-center w-48 h-14 relative font-sans text-black text-xl font-semibold group">
                <div class="bg-black h-12 w-1/4 flex items-center justify-center absolute left-1 top-[4px] group-hover:!bg-[#a000ff] group-hover:w-[184px] z-10 duration-500 rounded-2xl">
                    <svg width="25px" height="25px" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg">
                        <path fill="#ffffff" d="M224 480h640a32 32 0 1 1 0 64H224a32 32 0 0 1 0-64z"></path>
                        <path fill="#ffffff" d="m237.248 512 265.408 265.344a32 32 0 0 1-45.312 45.312l-288-288a32 32 0 0 1 0-45.312l288-288a32 32 0 1 1 45.312 45.312L237.248 512z"></path>
                    </svg>
                </div>
                <p class="translate-x-2" style="margin-top:12px">Quay lại</p>
            </a>
        </div>
        <!-- Album -->
        <div class="flex items-center justify-center">
            <div class="w-full max-w-2xl px-4 py-4 sm:px-6 sm:py-6 lg:max-w-7xl lg:px-16">
                <!-- Wrapper for centering content horizontally on large screens -->
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-center lg:space-x-6">
                    <!-- Cover -->
                    <div class="relative text-center lg:text-left w-full lg:w-80 mb-4 lg:mb-0">
                        <img class="w-full h-full object-cover rounded-lg" src="{{ $album->cover_image }}" alt="Album Cover">
                        <div class="absolute inset-0 flex opacity-0 hover:opacity-100 hover:!opacity-100 transition-opacity duration-300">
                            <a href="{{ route('editalbum', ['id' => $album->id]) }}" class="bg-white p-2 rounded-lg shadow-md w-full h-full border-8 border-[#a000ff] flex items-center justify-center">
                                <i class="fas fa-edit text-gray-700 text-5xl"></i>
                            </a>
                        </div>
                    </div>
                    <!-- Information -->
                    <div class="flex flex-col w-full max-w-full lg:max-w-72">
                        <div class="font-bold text-3xl flex items-center">
                            <div class="truncate hover:overflow-visible hover:whitespace-normal">{{ $album->title }}</div>
                            <span class="text-[#a000ff] text-xl ml-3" style="color: #B197FC;">{{ $countPhoto }}</span>
                            <i class="fa-regular fa-images text-[#a000ff] text-xl ml-3" style="color: #B197FC;"></i>
                        </div>
                        <div class="font-semibold text-xl text-gray-500 truncate hover:overflow-visible hover:whitespace-normal">{{ $album->description }}</div>
                        <a href="#" class="font-semibold text-xl text-gray-500 flex mt-4 cursor-pointer group">
                            <img class="h-8 w-8 rounded-full ring-2 ring-white mr-2" src="{{ $user->avatar_url }}" alt="">
                            <p class="group-hover:text-[#a000ff] font-semibold truncate hover:overflow-visible hover:whitespace-normal">{{ $user->username }}</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
            <!-- Gallery -->
            <div class="flex items-center justify-center">
                <div class="w-full max-w-2xl px-4 py-4 sm:px-6 sm:py-6 lg:max-w-7xl lg:px-16 mt-2">
                    <div class="font-bold text-3xl">Thư Viện</div>
                    @if (count($photo) == 0)
                        <div style="display:flex;margin-top:2%">
                            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="width:80px; margin-right:1%">
                                <path d="M22.71,6.29a1,1,0,0,0-1.42,0L20,7.59V2a1,1,0,0,0-2,0V7.59l-1.29-1.3a1,1,0,0,0-1.42,1.42l3,3a1,1,0,0,0,.33.21.94.94,0,0,0,.76,0,1,1,0,0,0,.33-.21l3-3A1,1,0,0,0,22.71,6.29ZM19,13a1,1,0,0,0-1,1v.38L16.52,12.9a2.79,2.79,0,0,0-3.93,0l-.7.7L9.41,11.12a2.85,2.85,0,0,0-3.93,0L4,12.6V7A1,1,0,0,1,5,6h8a1,1,0,0,0,0-2H5A3,3,0,0,0,2,7V19a3,3,0,0,0,3,3H17a3,3,0,0,0,3-3V14A1,1,0,0,0,19,13ZM5,20a1,1,0,0,1-1-1V15.43l2.9-2.9a.79.79,0,0,1,1.09,0l3.17,3.17,0,0L15.46,20Zm13-1a.89.89,0,0,1-.18.53L13.31,15l.7-.7a.77.77,0,0,1,1.1,0L18,17.21Z" fill="#6563ff"/>
                            </svg>
                            <h3 style="margin-top:30px;font-size:20px;" class="text-gray-500"> Bạn chưa có bất kì ảnh nào. Hãy thêm ảnh vào album ngay!</h3>
                        </div>
                    @else
                        <div class="mt-2 grid grid-cols-12 gap-2">
                            @foreach ($photo as $x)
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
                                            <a href="{{ route("editimage", ['id' => $x->id]) }}" class="bg-white p-2 rounded-full shadow-md flex items-center justify-center w-10 h-10">
                                                <i class="fas fa-edit text-gray-700 text-xl hover:text-[#a000ff]"></i>
                                            </a>
                                            <a href="#" class="bg-white p-2 rounded-full shadow-md flex items-center justify-center w-10 h-10">
                                                <i class="fas fa-sort text-gray-700 text-xl hover:text-[#a000ff]"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                        @endforeach
                    </div>
                    <div class="w-full mt-4">
                        {{ $photo->links("vendor.pagination.simple-tailwind") }}
                    </div>
                @endif
            </div>
        </div>
        <!-- Suggestion -->
        <div class="flex items-center justify-center">
            <div class="w-full max-w-2xl px-4 py-4 sm:px-6 sm:py-6 lg:max-w-7xl lg:px-16 mt-2">
                <div class="font-bold text-3xl text-left">Thêm Ảnh</div>
                <div class="mt-2 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <div class="relative group">
                        <a href="{{ route('createimage', ['id' => $album->id]) }}" class="block aspect-square bg-gray-200 flex items-center justify-center group-hover:bg-[#a000ff] transition-colors duration-300">
                            <i class="fas fa-plus text-8xl text-gray-600 group-hover:text-white transition-colors duration-300"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection