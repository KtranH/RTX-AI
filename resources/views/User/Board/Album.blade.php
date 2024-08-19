@extends('User.Container')
@section('Body')

    <title>RTX-AI: Album</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <main class="w-full h-full">
        <!-- Album -->
        <div class="flex items-center justify-center">
            <div class="w-full max-w-2xl px-4 py-4 sm:px-6 sm:py-6 lg:max-w-7xl lg:px-16">
                <div class="flex items-center justify-center space-x-6">
                    <div class="relative text-center">
                        <img class="w-full h-full object-cover rounded-lg" src="{{ $album->cover_image }}" alt="User Avatar">
                        <div class="absolute inset-0 flex items-center justify-center opacity-0 hover:opacity-100 hover:!opacity-100 transition-opacity duration-300">
                            <a href="{{ route('editalbum', ['id' => $album->id]) }}" class="bg-white p-2 rounded-lg shadow-md w-full h-full border-8 border-[#a000ff] flex items-center justify-center">
                                <i class="fas fa-edit text-gray-700 text-5xl"></i>
                            </a>
                        </div>
                    </div>
                    <div class="flex flex-col">
                        <div class="font-bold text-3xl flex items-center">
                            {{ $album->title }}
                            <i class="fas fa-lock text-[#a000ff] text-xl ml-3"></i>
                        </div>
                        <div class="font-semibold text-xl text-gray-500">
                            {{ $album->user->username }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Gallery -->
        <div class="flex items-center justify-center">
            <div class="w-full max-w-2xl px-4 py-4 sm:px-6 sm:py-6 lg:max-w-7xl lg:px-16 mt-2">
                <div class="font-bold text-3xl">Thư Viện</div>
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
                                        <i class="fas fa-edit text-gray-700 text-xl hover:text-[#a000ff]"></i>
                                    </a>
                                    <a href="#" class="bg-white p-2 rounded-full shadow-md flex items-center justify-center w-10 h-10">
                                        <i class="fas fa-trash text-gray-700 text-xl hover:text-[#a000ff]"></i>
                                    </a>
                                    <a href="#" class="bg-white p-2 rounded-full shadow-md flex items-center justify-center w-10 h-10">
                                        <i class="fas fa-sort text-gray-700 text-xl hover:text-[#a000ff]"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="relative col-span-3 row-span-1 aspect-square group">
                        <img src="https://via.placeholder.com/600x800" alt="Image 2" class="w-full h-full object-cover transition-opacity duration-300 group-hover:opacity-50">
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
                                        <i class="fas fa-edit text-gray-700 text-xl hover:text-[#a000ff]"></i>
                                    </a>
                                    <a href="#" class="bg-white p-2 rounded-full shadow-md flex items-center justify-center w-10 h-10">
                                        <i class="fas fa-trash text-gray-700 text-xl hover:text-[#a000ff]"></i>
                                    </a>
                                    <a href="#" class="bg-white p-2 rounded-full shadow-md flex items-center justify-center w-10 h-10">
                                        <i class="fas fa-sort text-gray-700 text-xl hover:text-[#a000ff]"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Suggestion -->
        <div class="flex items-center justify-center">
            <div class="w-full max-w-2xl px-4 py-4 sm:px-6 sm:py-6 lg:max-w-7xl lg:px-16 mt-2">
                <div class="font-bold text-3xl">Gợi Ý Thêm</div>
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
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="relative col-span-3 row-span-1 aspect-square group">
                        <img src="https://via.placeholder.com/600x800" alt="Image 2" class="w-full h-full object-cover transition-opacity duration-300 group-hover:opacity-50">
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
                                </div>
                            </div>
                        </div>
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