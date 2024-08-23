@extends('User.Container')
@section('Body')

    <title>RTX-AI: Chỉnh Album</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <main class="w-full h-full">
        <!-- Title -->
        <div class="flex items-center justify-center">
            <div class="w-full max-w-2xl px-4 py-4 sm:px-6 sm:py-6 lg:max-w-7xl lg:px-16 text-center">
                <div class="font-bold text-3xl">Chỉnh Album</div>
                <div class="text-gray-500">Thỏa Sức Sáng Tạo - Truyền Đầy Cảm Hứng</div>
            </div>
        </div>
        <!-- Form -->
        <div class="flex items-center justify-center">
            <div class="w-full max-w-2xl px-4 py-4 sm:px-6 sm:py-6 lg:max-w-7xl lg:px-16 mb-5">
                <form class="grid grid-cols-12 gap-4" method="POST" action="" enctype="multipart/form-data">
                    @csrf
                    <div class="col-span-4 row-span-1 aspect-square relative group">
                        <img id="album-cover" src="{{ $album->cover_image }}" alt="Album Cover" class="w-full h-full object-cover rounded-lg">
                        <label for="cover" class="absolute inset-0 flex items-center justify-center bg-white bg-opacity-50 opacity-0 group-hover:opacity-100 group-hover:!opacity-100 transition-opacity duration-300 cursor-pointer">
                            <i class="fas fa-upload text-gray-700 text-8xl"></i>
                        </label>
                        <input type="file" name="cover" id="cover" class="absolute inset-0 opacity-0 cursor-pointer" required>
                    </div>
                    <div class="col-span-8 row-span-1 p-4 bg-gray-100 rounded-lg shadow-md">
                        <div class="mb-4">
                            <label for="title" class="block text-xl font-medium mb-1">Tiêu Đề</label>
                            <input type="text" id="title" name="title" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-[#a000ff] focus:!border-[#a000ff] sm:text-sm" placeholder="{{ $album->title }}" required>
                        </div>
                        <div class="mb-4">
                            <label for="description" class="block text-xl font-medium mb-1">Mô Tả</label>
                            <textarea id="description" name="description" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-[#a000ff] focus:!border-[#a000ff] sm:text-sm" placeholder="{{ $album->description }}" required></textarea>
                        </div>
                        <div class="mb-4 flex items-center">
                            <input type="checkbox" id="private" name="private" class="h-5 w-5 border-gray-300 rounded accent-[#a000ff]">
                            <label for="private" class="ml-2 block text-xl font-medium text-gray-700">Riêng Tư</label>
                        </div>
                        <div class="flex justify-center mt-4">
                            <button type="submit" id="update" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Cập Nhật Album</button>
                            <button type="submit" id="delete" class="rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 ml-5">Xóa Album</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <script>
            document.getElementById('cover').addEventListener('change', function(event) 
            {
                const file = event.target.files[0];
                if (file) 
                {
                    const reader = new FileReader();
                    reader.onload = function(e) 
                    {
                        document.getElementById('album-cover').src = e.target.result;
                    }
                    reader.readAsDataURL(file);
                }
            });
        </script>
    </main>

@endsection