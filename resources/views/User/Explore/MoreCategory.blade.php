@extends('User.Container')
@section('Body')
<title>RTX-AI: Hình Ảnh</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<main class="w-full h-full" style="margin-bottom:100px">
    <!-- Title -->
    <div class="flex items-center justify-center">
        <div class="w-full max-w-7xl px-4 py-4 sm:px-6 sm:py-6 lg:max-w-7xl lg:px-16 text-center">
            <div class="font-bold text-4xl">Danh sách các thể loại</div>
            <div class="text-gray-500 text-2xs">Thỏa Sức Sáng Tạo - Truyền Đầy Cảm Hứng</div>
        </div>
    </div>
    <!-- Return -->
    <div class="flex justify-center">
        <a href="{{ route('showexplore') }}"
            class="text-center w-48 h-14 relative font-sans text-black text-xl font-semibold group">
            <div
                class="bg-black h-12 w-1/4 flex items-center justify-center absolute left-1 top-[4px] group-hover:!bg-[#a000ff] group-hover:w-[184px] z-10 duration-500 rounded-2xl">
                <svg width="25px" height="25px" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg">
                    <path fill="#ffffff" d="M224 480h640a32 32 0 1 1 0 64H224a32 32 0 0 1 0-64z"></path>
                    <path fill="#ffffff"
                        d="m237.248 512 265.408 265.344a32 32 0 0 1-45.312 45.312l-288-288a32 32 0 0 1 0-45.312l288-288a32 32 0 1 1 45.312 45.312L237.248 512z">
                    </path>
                </svg>
            </div>
            <p class="translate-x-2" style="margin-top:12px">Quay lại</p>
        </a>
    </div>
    <!-- List Category -->
    <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8 flex flex-col">
        <div class="grid grid-cols-3 gap-4">
            @foreach ($results as $letter => $categories)
                <div class="flex flex-col items-center mb-4">
                    <h2 class="text-3xl font-bold tracking-tight text-gray-900 mb-4">{{ $letter }}</h2>
                    <ul class="space-y-2">
                        @foreach ($categories as $item)
                            <li><a href="/explore/?category={{$item->id}}"
                                    class="text-lg font-medium text-gray-700 hover:text-indigo-600">{{ $item->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
    </div>
</main>
@endsection