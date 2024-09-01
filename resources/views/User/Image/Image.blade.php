@extends('User.Container')
@section('Body')

    <title>RTX-AI: Hình Ảnh</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <main class="w-full h-full" style="margin-bottom:10%">
        <!-- Image -->
        <div class="flex items-center justify-center">
            <div class="w-full max-w-2xl px-4 py-4 sm:px-6 sm:py-6 lg:max-w-7xl lg:px-16 shadow-md p-5"  style="box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px;border-radius:20px">
                <div class="grid grid-cols-12 gap-4">
                    <!-- Image -->
                    <div class="col-span-6 row-span-1 aspect-square">
                        <img src="{{ $image->url }}" alt="Image Cover" class="w-full h-full object-cover">
                    </div>
                    <!-- Details -->
                    <div class="col-span-6 row-span-1 flex flex-col">
                        <!-- Title and Description -->
                        <a
                            href="javascript:history.back()"
                            class="text-center w-48 h-14 relative font-sans text-black text-xl font-semibold group"
                            style="margin-bottom:10px"
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
                        <div class="mb-4">
                            <h1 class="text-4xl font-bold">{{ $image->title }}</h1>
                            <p class="text-lg text-gray-600">{{ $image->description }}</p>
                        </div>
                        <!-- Owner -->
                        <div class="flex items-center space-x-4 mb-4">
                            <img src="{{ $user->avatar_url }}" alt="Owner Avatar" class="w-10 h-10 rounded-full">
                            <div class="flex-1">
                                <p class="font-semibold">{{ $user->username }}</p>
                            </div>
                            <a href="#" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 flex items-center justify-center">Follow</a>
                        </div>
                        <!-- Action -->
                        <div class="flex justify-center space-x-4 mb-4">
                            <a href="#" class="bg-white p-2 rounded-full shadow-md flex items-center justify-center w-10 h-10">
                                <i class="fas fa-star text-gray-700 text-xl hover:text-[#a000ff]"></i>
                            </a>
                            <a href="#" class="bg-white p-2 rounded-full shadow-md flex items-center justify-center w-10 h-10">
                                <i class="fas fa-share text-gray-700 text-xl hover:text-[#a000ff]"></i>
                            </a>
                            <a href="#" class="bg-white p-2 rounded-full shadow-md flex items-center justify-center w-10 h-10">
                                <i class="fas fa-edit text-gray-700 text-xl hover:text-[#a000ff]"></i>
                            </a>
                            <a href="#" class="bg-white p-2 rounded-full shadow-md flex items-center justify-center w-10 h-10">
                                <i class="fas fa-trash text-gray-700 text-xl hover:text-[#a000ff]"></i>
                            </a>
                        </div>
                        <!-- Comment -->
                        <div class="flex flex-col mt-auto">
                            <div class="flex flex-col overflow-y-auto max-h-60 mb-4">
                                <div class="space-y-4">
                                    @for ($i = 0; $i <= 15; $i++)
                                        <div class="flex items-start space-x-4">
                                            <img src="https://randomuser.me/api/portraits/men/2.jpg" alt="Avatar" class="w-10 h-10 rounded-full">
                                            <div>
                                                <p class="font-semibold">Jane Smith</p>
                                                <p class="text-sm text-gray-700">This is a random comment. The layout looks great!</p>
                                            </div>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                            <textarea class="text-base w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-[#a000ff] focus:!border-[#a000ff] resize-none" rows="1" placeholder="Add a comment..."></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Suggestion -->
        <div class="flex items-center justify-center">
            <div class="w-full max-w-2xl px-4 py-4 sm:px-6 sm:py-6 lg:max-w-7xl lg:px-16 mt-2">
                <div class="font-bold text-3xl">Gợi Ý Ảnh</div>
                <div class="mt-2 grid grid-cols-12 gap-2">
                    @for ($i = 0; $i <= 5; $i++)
                        <div class="col-span-3 row-span-1 relative group">
                            <a href="">
                                <div class="aspect-square">
                                    <img src="https://picsum.photos/200" alt="Image 1" class="w-full h-full object-cover transition-opacity duration-300 group-hover:opacity-15">
                                </div>
                                <div class="absolute inset-0 flex flex-col justify-between opacity-0 group-hover:opacity-100 group-hover:!opacity-100 transition-opacity duration-300">
                                    <div class="mt-2 text-left px-2 py-1">
                                        <div class="font-semibold text-lg truncate group-hover:text-[#000000]">Image 1</div>
                                        <div class="text-sm text-gray-500 h-20 overflow-hidden">Description 1</div>
                                    </div>
                                </div>
                            </a>    
                            <div class="absolute inset-x-0 bottom-0 flex justify-center p-2 opacity-0 group-hover:opacity-100 group-hover:!opacity-100 transition-opacity duration-300">
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
                    @endfor
                </div>
            </div>
        </div>
    </main>

@endsection