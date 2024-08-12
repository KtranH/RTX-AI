@extends('User.Container')
@section('Body')

    <title>RTX-AI: Tạo Album</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <main class="w-full h-full">
        <!-- Title -->
        <div class="flex items-center justify-center">
            <div class="w-full max-w-2xl px-4 py-4 sm:px-6 sm:py-6 lg:max-w-7xl lg:px-16 text-center">
                <div class="font-bold text-3xl">Tạo Album</div>
                <div class="text-gray-500">Thỏa Sức Sáng Tạo - Truyền Đầy Cảm Hứng</div>
            </div>
        </div>
        <!-- Form -->
        <div class="flex items-center justify-center">
            <div class="w-full max-w-2xl px-4 py-4 sm:px-6 sm:py-6 lg:max-w-7xl lg:px-16">
                <form class="grid grid-cols-12 gap-4">
                    <div class="col-span-4 row-span-1 aspect-square relative group">
                        <img id="album-cover" src="https://via.placeholder.com/600x600" alt="Album Cover" class="w-full h-full object-cover rounded-lg">
                        <label for="cover" class="absolute inset-0 flex items-center justify-center bg-white bg-opacity-50 opacity-0 group-hover:opacity-100 group-hover:!opacity-100 transition-opacity duration-300 cursor-pointer">
                            <i class="fas fa-upload text-gray-700 text-8xl"></i>
                        </label>
                        <input type="file" id="cover" class="absolute inset-0 opacity-0 cursor-pointer">
                    </div>
                    <div class="col-span-8 row-span-1 p-4 bg-gray-100 rounded-lg shadow-md">
                        <div class="mb-4">
                            <label for="title" class="block text-xl font-medium mb-1">Tiêu Đề</label>
                            <input type="text" id="title" name="title" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-[#a000ff] focus:!border-[#a000ff] sm:text-sm" placeholder="Nhập tiêu đề">
                        </div>
                        <div class="mb-4">
                            <label for="description" class="block text-xl font-medium mb-1">Mô Tả</label>
                            <textarea id="description" name="description" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-[#a000ff] focus:!border-[#a000ff] sm:text-sm" placeholder="Nhập mô tả"></textarea>
                        </div>
                        <div class="mb-4 flex items-center">
                            <input type="checkbox" id="private" name="private" class="h-5 w-5 border-gray-300 rounded accent-[#a000ff]">
                            <label for="private" class="ml-2 block text-xl font-medium text-gray-700">Riêng Tư</label>
                        </div>
                        <div class="flex justify-center mt-4">
                            <button type="submit" class="bg-[#a000ff] text-white font-bold px-5 py-2 rounded-md border border-[#a000ff] hover:bg-white hover:text-[#a000ff] hover:!text-[#a000ff] hover:border-[#a000ff] hover:border-![#a000ff]">
                                Lưu
                            </button>
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
        <!-- Photo -->
        <div class="flex items-center justify-center">
            <div class="w-full max-w-2xl px-4 py-4 sm:px-6 sm:py-6 lg:max-w-7xl lg:px-16">
                <div class="font-bold text-3xl">Thêm Hình vào Album</div>
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
                                        <i class="fas fa-plus text-gray-700 text-xl hover:text-[#a000ff]"></i>
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
                                        <i class="fas fa-plus text-gray-700 text-xl hover:text-[#a000ff]"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="relative col-span-3 row-span-1 aspect-square group">
                        <img src="https://via.placeholder.com/800x600" alt="Image 3" class="w-full h-full object-cover transition-opacity duration-300 group-hover:opacity-50">
                        <div class="absolute inset-0 flex flex-col justify-between opacity-0 group-hover:opacity-100 group-hover:!opacity-100 transition-opacity duration-300">
                            <div class="mt-2 text-left px-2 py-1">
                                <div class="font-semibold text-lg truncate">Hình 3</div>
                                <div class="text-sm text-gray-500 h-20 overflow-hidden">Mô Tả 3</div>
                            </div>    
                            <div class="flex justify-center p-2">
                                <div class="flex space-x-2">
                                    <a href="#" class="bg-white p-2 rounded-full shadow-md flex items-center justify-center w-10 h-10">
                                        <i class="fas fa-plus text-gray-700 text-xl hover:text-[#a000ff]"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="relative col-span-3 row-span-1 aspect-square group">
                        <img src="https://via.placeholder.com/800x600" alt="Image 4" class="w-full h-full object-cover transition-opacity duration-300 group-hover:opacity-50">
                        <div class="absolute inset-0 flex flex-col justify-between opacity-0 group-hover:opacity-100 group-hover:!opacity-100 transition-opacity duration-300">
                            <div class="mt-2 text-left px-2 py-1">
                                <div class="font-semibold text-lg truncate">Hình 4</div>
                                <div class="text-sm text-gray-500 h-20 overflow-hidden">Mô Tả 4</div>
                            </div>    
                            <div class="flex justify-center p-2">
                                <div class="flex space-x-2">
                                    <a href="#" class="bg-white p-2 rounded-full shadow-md flex items-center justify-center w-10 h-10">
                                        <i class="fas fa-plus text-gray-700 text-xl hover:text-[#a000ff]"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="relative col-span-3 row-span-1 aspect-square group">
                        <img src="https://via.placeholder.com/800x600" alt="Image 5" class="w-full h-full object-cover transition-opacity duration-300 group-hover:opacity-50">
                        <div class="absolute inset-0 flex flex-col justify-between opacity-0 group-hover:opacity-100 group-hover:!opacity-100 transition-opacity duration-300">
                            <div class="mt-2 text-left px-2 py-1">
                                <div class="font-semibold text-lg truncate">Hình 5</div>
                                <div class="text-sm text-gray-500 h-20 overflow-hidden">Mô Tả 5</div>
                            </div>    
                            <div class="flex justify-center p-2">
                                <div class="flex space-x-2">
                                    <a href="#" class="bg-white p-2 rounded-full shadow-md flex items-center justify-center w-10 h-10">
                                        <i class="fas fa-plus text-gray-700 text-xl hover:text-[#a000ff]"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="relative col-span-3 row-span-1 aspect-square group">
                        <img src="https://via.placeholder.com/800x600" alt="Image 6" class="w-full h-full object-cover transition-opacity duration-300 group-hover:opacity-50">
                        <div class="absolute inset-0 flex flex-col justify-between opacity-0 group-hover:opacity-100 group-hover:!opacity-100 transition-opacity duration-300">
                            <div class="mt-2 text-left px-2 py-1">
                                <div class="font-semibold text-lg truncate">Hình 6</div>
                                <div class="text-sm text-gray-500 h-20 overflow-hidden">Mô Tả 6</div>
                            </div>    
                            <div class="flex justify-center p-2">
                                <div class="flex space-x-2">
                                    <a href="#" class="bg-white p-2 rounded-full shadow-md flex items-center justify-center w-10 h-10">
                                        <i class="fas fa-plus text-gray-700 text-xl hover:text-[#a000ff]"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection