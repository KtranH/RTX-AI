@extends('User.Container')
@section('Body')

    <title>RTX-AI: Album</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <main class="w-full h-full">
        <!-- Album -->
        <div class="flex items-center justify-center">
            <div class="w-full max-w-2xl px-4 py-4 sm:px-6 sm:py-6 lg:max-w-7xl lg:px-16">
                <div class="flex items-center justify-center space-x-6">
                    <div class="relative text-center w-80">
                        <img class="w-80 h-full object-cover rounded-lg" src="{{ $album->cover_image }}" alt="User Avatar">
                        <div class="absolute inset-0 flex opacity-0 hover:opacity-100 hover:!opacity-100 transition-opacity duration-300">
                            <a href="{{ route('editalbum', ['id' => $album->id]) }}" class="bg-white p-2 rounded-lg shadow-md w-80 h-full border-8 border-[#a000ff] flex items-center justify-center">
                                <i class="fas fa-edit text-gray-700 text-5xl"></i>
                            </a>
                        </div>
                    </div>
                    <div class="flex flex-col">
                        <div class="font-bold text-3xl flex items-center">
                            {{ $album->title }}
                            <i class="fa-regular fa-images text-[#a000ff] text-xl ml-3" style="color: #B197FC;"></i>
                        </div>
                        <div class="font-semibold text-xl text-gray-500">
                            {{ $album->description }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Gallery -->
        <div class="flex items-center justify-center">
            <div class="w-full max-w-2xl px-4 py-4 sm:px-6 sm:py-6 lg:max-w-7xl lg:px-16 mt-2">
                <div class="font-bold text-3xl">Thư Viện</div>
                @if (count($photo) == 0)
                    <div class="col-span-3 row-span-1 relative group">
                        <a href="{{ route('createimage', ['id' => $album->id]) }}" class="block aspect-square bg-gray-200 flex items-center justify-center group-hover:bg-[#a000ff] transition-colors duration-300">
                            <i class="fas fa-plus text-8xl text-gray-600 group-hover:text-white transition-colors duration-300"></i>
                        </a>
                    </div>
                @else
                    <div class="mt-2 grid grid-cols-12 gap-2">
                        <div class="col-span-3 row-span-1 relative group">
                            <a href="{{ route('createimage', ['id' => $album->id]) }}" class="block aspect-square bg-gray-200 flex items-center justify-center group-hover:bg-[#a000ff] transition-colors duration-300">
                                <i class="fas fa-plus text-8xl text-gray-600 group-hover:text-white transition-colors duration-300"></i>
                            </a>
                        </div>
                        @foreach ($photo as $x)
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
                                <div class="absolute inset-x-0 bottom-0 flex justify-center p-2 opacity-0 group-hover:opacity-100 group-hover:!opacity-100 transition-opacity duration-300">
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
                        @endforeach
                    </div>
                    <div style="w-full mt-2">
                        {{ $photo->links("vendor.pagination.simple-tailwind") }}
                    </div>
                @endif
            </div>
        </div>
        <!-- Suggestion -->
        <div class="flex items-center justify-center">
            <div class="w-full max-w-2xl px-4 py-4 sm:px-6 sm:py-6 lg:max-w-7xl lg:px-16 mt-2">
                <div class="font-bold text-3xl">Gợi Ý Ảnh</div>
                <div class="mt-2 grid grid-cols-12 gap-2">
                    <div class="col-span-3 row-span-1 relative group">
                        <a href="{{ route('createimage', ['id' => $album->id]) }}" class="block aspect-square bg-gray-200 flex items-center justify-center group-hover:bg-[#a000ff] transition-colors duration-300">
                            <i class="fas fa-plus text-8xl text-gray-600 group-hover:text-white transition-colors duration-300"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection