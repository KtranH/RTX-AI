@extends('User.Container')
@section('Body')
    <title>RTX-AI: Tạo Hình Ảnh</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <main class="w-full h-full" style="margin-bottom:10%">
        <!-- Title -->
        <div class="flex items-center justify-center">
            <div class="w-full max-w-2xl px-4 py-4 sm:px-6 sm:py-6 lg:max-w-7xl lg:px-16 text-center">
                <div class="font-bold text-3xl">Chỉnh Sửa Hình Ảnh</div>
                <div class="text-gray-500">Thỏa Sức Sáng Tạo - Truyền Đầy Cảm Hứng</div>
            </div>
        </div>
        <!-- Form -->
        <div class="flex items-center justify-center mb-5">
            <div class="w-full max-w-2xl px-4 py-4 sm:px-6 sm:py-6 lg:max-w-7xl lg:px-16">
                <form class="grid grid-cols-12 gap-4" id="editimageform" method="POST" action="" enctype="multipart/form-data">
                    @csrf
                    <div class="col-span-4 row-span-1 aspect-square relative group">
                        <img id="image-cover" src="{{ $image->url }}" style="border-radius:10px" alt="Image Cover" class="w-full h-full object-cover">
                        <label for="cover" class="absolute inset-0 flex items-center justify-center bg-white bg-opacity-50 opacity-0 group-hover:opacity-100 group-hover:!opacity-100 transition-opacity duration-300 cursor-pointer">
                            <i class="fas fa-upload text-gray-700 text-8xl"></i>
                        </label>
                        <input type="file" name="cover" id="cover" class="absolute inset-0 opacity-0 cursor-pointer form-control @error('cover') is-invalid @enderror" required>
                        @error('cover')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-span-8 row-span-1 p-4 shadow-md"  style="box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px;border-radius:20px">
                        <div class="mb-4">
                            <label for="album" class="block text-xl font-medium mb-1">Album</label>
                            <div class="relative">
                                <select id="album" name="album" class="appearance-none w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-[#a000ff] focus:!border-[#a000ff] sm:text-sm pr-10" required>
                                    <option value="{{ $album->id }}" selected>{{ $album->title }}</option>
                                    <option value="1">Album 1</option>
                                    <option value="2">Album 2</option>
                                    <option value="3">Album 3</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3">
                                    <svg class="w-4 h-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="title" class="block text-xl font-medium mb-1">Tiêu Đề</label>
                            <input type="text" id="title" name="title" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-[#a000ff] focus:!border-[#a000ff] sm:text-sm" placeholder="{{ $image->title }}" required>
                        </div>
                        <div class="mb-4">
                            <label for="description" class="block text-xl font-medium mb-1">Mô Tả</label>
                            <textarea id="description" name="description" rows="1" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-[#a000ff] focus:!border-[#a000ff] sm:text-sm" placeholder="{{ $image->description }}" required></textarea>
                        </div>
                        <div class="mb-4">
                            <label for="description" class="block text-xl font-medium mb-1">Chọn thể loại</label>
                            <input name="categories" class="form-control @error('categories') is-invalid @enderror" id="categories" value="" placeholder="Lựa chọn các thể loại cho hình ảnh">
                            @error('categories')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <script>
                            var input = document.querySelector('input[name=categories]');
                            var tagify = new Tagify(input, {
                                whitelist: @json($category->pluck('name')->toArray()),
                                maxTags: 10,
                                dropdown: {
                                    maxItems: 20,           
                                    classname: "tags-look", 
                                    enabled: 0,            
                                    closeOnSelect: false    
                                }
                            });
                        
                            var selectedCategories = @json($selectedCategories ?? []);
                        
                            if (selectedCategories.length) {
                                tagify.addTags(selectedCategories);
                            }
                        </script>
                        <div class="flex justify-center mt-4">
                            <button type="submit" id="edit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Chỉnh Ảnh</button>
                        </div>
                        <script>
                            document.getElementById('editimageform').addEventListener('submit', function() {
                                var submitButton = document.getElementById('edit');
                                submitButton.disabled = true; 
                                submitButton.innerText = 'Đang thực hiện...'; 
                            });
                        </script>   
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
                        document.getElementById('image-cover').src = e.target.result;
                    }
                    reader.readAsDataURL(file);
                }
            });
        </script>
    </main>

@endsection