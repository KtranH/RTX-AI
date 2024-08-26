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
                   <div class="mt-2 grid gap-2">
                    <div style="display:flex;margin-top:2%">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="width:80px; margin-right:1%">
                            <path d="M22.71,6.29a1,1,0,0,0-1.42,0L20,7.59V2a1,1,0,0,0-2,0V7.59l-1.29-1.3a1,1,0,0,0-1.42,1.42l3,3a1,1,0,0,0,.33.21.94.94,0,0,0,.76,0,1,1,0,0,0,.33-.21l3-3A1,1,0,0,0,22.71,6.29ZM19,13a1,1,0,0,0-1,1v.38L16.52,12.9a2.79,2.79,0,0,0-3.93,0l-.7.7L9.41,11.12a2.85,2.85,0,0,0-3.93,0L4,12.6V7A1,1,0,0,1,5,6h8a1,1,0,0,0,0-2H5A3,3,0,0,0,2,7V19a3,3,0,0,0,3,3H17a3,3,0,0,0,3-3V14A1,1,0,0,0,19,13ZM5,20a1,1,0,0,1-1-1V15.43l2.9-2.9a.79.79,0,0,1,1.09,0l3.17,3.17,0,0L15.46,20Zm13-1a.89.89,0,0,1-.18.53L13.31,15l.7-.7a.77.77,0,0,1,1.1,0L18,17.21Z" fill="#6563ff"/>
                        </svg>
                        <h3 style="margin-top:30px;font-size:20px;" class="text-gray-500"> Bạn chưa có bất kì ảnh nào. Hãy thêm ảnh vào album ngay!</h3>
                    </div>
                   @else
                   <div class="mt-2 grid grid-cols-12 gap-2">
                        @foreach ($photo as $x)
                        <div class="relative col-span-3 row-span-1 aspect-square group">
                            <img src="{{ $x->url }}" alt="Image 1" style="border-radius:10px" class="w-full h-full object-cover transition-opacity duration-300 group-hover:opacity-50">
                            <div class="absolute inset-0 flex flex-col justify-between opacity-0 group-hover:opacity-100 group-hover:!opacity-100 transition-opacity duration-300">
                                <div class="mt-2 text-left px-2 py-1">
                                    <div class="font-semibold text-lg truncate">{{ $x->title}}</div>
                                    <div class="text-sm text-gray-500 h-20 overflow-hidden">{{ $x->description}}</div>
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
                        @endforeach
                        </div>
                        <div style="w-full mt-2">
                            {{ $photo->links("vendor.pagination.simple-tailwind") }}
                        </div>
                    </div>
                   @endif
                </div>
            </div>
        </div>
        <!-- Suggestion -->
        <div class="flex items-center justify-center">
            <div class="w-full max-w-2xl px-4 py-4 sm:px-6 sm:py-6 lg:max-w-7xl lg:px-16 mt-2">
                <div class="font-bold text-3xl">Thêm vào album</div>
                <div class="mt-2 grid grid-cols-12 gap-2">
                    <div class="col-span-3 row-span-1 relative group">
                        <a href="{{ route('createimage', ['id' => $album->id]) }}" style="border-radius:10px" class="block aspect-square bg-gray-200 flex items-center justify-center group-hover:bg-[#a000ff] transition-colors duration-300">
                            <i class="fas fa-plus text-8xl text-gray-600 group-hover:text-white transition-colors duration-300"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection