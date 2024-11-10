@extends('User.Container')
@section('Body')

    <title>RTX-AI: Tạo Hình Ảnh</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <main class="w-full h-full">
        <!-- Title -->
        <div class="flex items-center justify-center">
            <div class="w-full max-w-2xl px-4 py-4 sm:px-6 sm:py-6 lg:max-w-7xl lg:px-16 text-center">
                <div class="font-bold text-3xl">Chỉnh Sửa Hình Ảnh</div>
                <div class="text-gray-500">Thỏa Sức Sáng Tạo - Truyền Đầy Cảm Hứng</div>
            </div>
        </div>
        <!-- Form -->
        <div class="flex items-center justify-center mb-4">
            <div class="w-full max-w-2xl px-4 py-4 sm:px-6 sm:py-6 lg:max-w-7xl lg:px-16">
                <form class="grid grid-cols-1 md:grid-cols-12 gap-4" id="editimageform" method="POST" action="{{ route('updateimage', $image->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <!-- Return -->
                    <div class="col-span-1 md:col-span-12">
                        <div class="flex justify-center">
                            <a href="{{ route('showimage', ['id' => $image->id]) }}" class="text-center w-48 h-14 relative font-sans text-black text-xl font-semibold group">
                                <div class="bg-black h-12 w-1/4 flex items-center justify-center absolute left-1 top-[4px] group-hover:!bg-[#a000ff] group-hover:w-[184px] z-10 duration-500 rounded-2xl">
                                    <svg width="25px" height="25px" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg">
                                        <path fill="#ffffff" d="M224 480h640a32 32 0 1 1 0 64H224a32 32 0 0 1 0-64z"></path>
                                        <path fill="#ffffff" d="m237.248 512 265.408 265.344a32 32 0 0 1-45.312 45.312l-288-288a32 32 0 0 1 0-45.312l288-288a32 32 0 1 1 45.312 45.312L237.248 512z"></path>
                                    </svg>
                                </div>
                                <p class="translate-x-2" style="margin-top:12px">Quay lại</p>
                            </a>
                        </div>
                    </div>
                    <!-- Image -->
                    <div class="col-span-1 md:col-span-4 row-span-1 aspect-square relative group">
                        <img id="image-cover" src="{{ $image->url }}" loading="lazy" alt="Image Cover" class="w-full h-full object-cover rounded-2xl">
                        <label for="cover" class="absolute inset-0 flex items-center justify-center bg-white bg-opacity-50 opacity-0 group-hover:opacity-100 group-hover:!opacity-100 transition-opacity duration-300 cursor-pointer">
                            <i class="fas fa-upload text-gray-700 text-8xl"></i>
                        </label>
                        <input type="file" name="cover" id="cover" class="absolute inset-0 opacity-0 cursor-pointer form-control @error('cover') is-invalid @enderror">
                        @error('cover')
                            <div class="text-danger w-100">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- Data -->
                    <div class="col-span-1 md:col-span-8 row-span-1 p-4 rounded-2xl" style="box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px">
                        <div class="mb-4">
                            <label for="album" class="block text-xl font-medium mb-1">Album</label>
                            <div class="relative">
                                <select id="album" name="album" class="appearance-none w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-[#a000ff] focus:!border-[#a000ff] sm:text-sm pr-10" required>
                                    <option value="{{ $image->album->id }}" selected>{{ $image->album->title }}</option>
                                    @foreach ($allAlbum as $item)
                                        @if ($item->id != $image->album->id)
                                            <option value="{{ $item->id }}">{{ $item->title }}</option>
                                        @endif
                                    @endforeach
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
                            <input type="text" id="title" maxlength="29" name="title" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-[#a000ff] focus:!border-[#a000ff] sm:text-sm form-control @error('title') is-invalid @enderror" value="{{ $image->title }}">
                            @error('title')
                                <div class="text-danger w-100">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="description" class="block text-xl font-medium mb-1">Mô Tả</label>
                            <textarea id="description" name="description" rows="1" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-[#a000ff] focus:!border-[#a000ff] sm:text-sm form-control @error('description') is-invalid @enderror">{{ $image->description }}</textarea>
                            @error('description')
                                <div class="text-danger w-100">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="description" class="block text-xl font-medium mb-1">Thể loại ảnh</label>
                            <input name="categories" class="form-control @error('categories') is-invalid @enderror" id="categories" value="" placeholder="Lựa chọn các thể loại cho hình ảnh">
                            @error('categories')
                                <div class="text-danger w-100">{{ $message }}</div>
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
                            @foreach ($listcate as $item)
                                tagify.addTags(["{{ $item->name }}"]);
                            @endforeach
                        </script>
                        <div class="flex justify-center mt-4">
                            <button type="submit" id="edit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Cập nhật</button>
                            <a href="" id="delete" style="cursor:pointer" class="rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 ml-5">Xóa ảnh</a>
                        </div>
                        @if($errors->has("ManyTime"))
                            <script>
                                Swal.fire({ title: 'Thông báo', text: "Bạn chỉ có thể cập nhật nội dung 2 lần trong 1 tuần.", icon: 'warning', showCancelButton: false,
                                });
                            </script>
                            <div class="flex justify-center mt-4">
                                <p class="text-red-500">Bạn chỉ có thể cập nhật nội dung 2 lần trong 1 tuần.</p>
                            </div>
                        @endif
                        <script>
                            document.getElementById('delete').addEventListener('click', function(event) {
                                event.preventDefault(); 
                                Swal.fire({ title: 'Bạn có chắc chắn muốn xóa ảnh này không?', text: "Bạn sẽ không thể khôi phục lại hình ảnh đã xóa!", icon: 'warning', showCancelButton: true, confirmButtonColor: '#3085d6', cancelButtonColor: '#d33', confirmButtonText: 'Có, xóa ảnh!', cancelButtonText: 'Hủy bỏ'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        Swal.fire(
                                            'Đã xóa!',
                                            'Ảnh của bạn đã được xóa.',
                                            'success'
                                        );
                                        setTimeout(() => {
                                        Swal.close();
                                        }, 2000);
                                        fetch('{{ route("deleteimage", $image->id) }}', {
                                        method: 'DELETE',
                                        headers: {
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                        }
                                        })
                                        .then()
                                        {
                                            window.location.href = "{{ route('showboard') }}";
                                        }
                                    }
                                });
                            });
                        </script>
                    </div>
                </form>
            </div>
        </div>
    </main>

@endsection
