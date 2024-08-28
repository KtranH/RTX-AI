@extends('User.Container')
@section('Body')
    <title>RTX-AI: Tạo Hình Ảnh</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <main class="w-full h-full">
        <!-- Title -->
        <div class="flex items-center justify-center">
            <div class="w-full max-w-2xl px-4 py-4 sm:px-6 sm:py-6 lg:max-w-7xl lg:px-16 text-center">
                <div class="font-bold text-3xl">Thêm Hình Ảnh</div>
                <div class="text-gray-500">Thỏa Sức Sáng Tạo - Truyền Đầy Cảm Hứng</div>
            </div>
        </div>
        <!-- Form -->
        <div class="flex items-center justify-center mb-5">

            <div class="w-full max-w-2xl px-4 py-4 sm:px-6 sm:py-6 lg:max-w-7xl lg:px-16">
                <form class="grid grid-cols-12 gap-4" id="addimageform" method="POST" action="{{ route("addimage2album",["id" => $Id]) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="col-span-4 row-span-1 aspect-square relative group">
                        <img id="image-cover" src="/images/image.png" style="border-radius:10px" alt="Image Cover" class="w-full h-full object-cover">
                        <label for="cover" class="absolute inset-0 flex items-center justify-center bg-white bg-opacity-50 opacity-0 group-hover:opacity-100 group-hover:!opacity-100 transition-opacity duration-300 cursor-pointer">
                            <i class="fas fa-upload text-gray-700 text-8xl"></i>
                        </label>
                        <input type="file" name="cover" id="cover" class="absolute inset-0 opacity-0 cursor-pointer form-control @error('cover') is-invalid @enderror" required>
                        @error('cover')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-span-8 row-span-1 p-4 bg-gray-100 rounded-lg shadow-md">
                        <div class="mb-4">
                            <label for="title" class="block text-xl font-medium mb-1">Tiêu Đề</label>
                            <input type="text" id="title" name="title" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-[#a000ff] focus:!border-[#a000ff] sm:text-sm" placeholder="Nhập tiêu đề" required>
                        </div>
                        <div class="mb-4">
                            <label for="description" class="block text-xl font-medium mb-1">Mô Tả</label>
                            <textarea id="description" name="description" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-[#a000ff] focus:!border-[#a000ff] sm:text-sm" placeholder="Nhập mô tả" required></textarea>
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
                                whitelist: @json($Category->pluck('name')->toArray()),
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
                            <button type="submit" id="create" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Tạo Ảnh</button>
                        </div>
                        <script>
                            document.getElementById('addimageform').addEventListener('submit', function() {
                                var submitButton = document.getElementById('create');
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