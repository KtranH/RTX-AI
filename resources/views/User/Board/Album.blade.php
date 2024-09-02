@extends('User.Container')
@section('Body')

    <title>RTX-AI: Album</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <main class="w-full h-full" style="margin-bottom:10%">
        <!-- Album -->
        <div class="relative isolate px-6 pt-14 lg:px-8">
            <div class="absolute inset-x-0 -top-5 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-5" aria-hidden="true">
              <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
            </div>
            <div class="flex items-center justify-center">
                <div class="w-full max-w-2xl px-4 py-4 sm:px-6 sm:py-6 lg:max-w-7xl lg:px-16">
                    <div class="flex items-center justify-center space-x-6">
                        <a
                            href="{{ route("showboard") }}"
                            class="text-center w-48 h-14 relative font-sans text-black text-xl font-semibold group"
                            >
                            <div
                                class="bg-black h-12 w-1/4 flex items-center justify-center absolute left-1 top-[4px] group-hover:w-[184px] z-10 duration-500"
                                style="border-radius: 30px;"
                            >
                                <svg
                                width="25px"
                                height="25px"
                                viewBox="0 0 1024 1024"
                                xmlns="http://www.w3.org/2000/svg"
                                >
                                <path
                                    fill="#ffffff"
                                    d="M224 480h640a32 32 0 1 1 0 64H224a32 32 0 0 1 0-64z"
                                ></path>
                                <path
                                    fill="#ffffff"
                                    d="m237.248 512 265.408 265.344a32 32 0 0 1-45.312 45.312l-288-288a32 32 0 0 1 0-45.312l288-288a32 32 0 1 1 45.312 45.312L237.248 512z"
                                ></path>
                                </svg>
                            </div>
                            <p class="translate-x-2" style="margin-top:12px">Quay lại</p>
                        </a>
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
                            <div class="font-semibold text-xl text-gray-500 flex mt-4 cursor-pointer">
                                <img class="h-8 w-8 rounded-full ring-2 ring-white mr-2" src="{{ $user->avatar_url }}" alt="">
                                <p class="hover:text-[#a000ff] font-semibold">{{ $user->username }}</p>
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
        </div>
    </main>

@endsection