@extends('User.Container')
@section('Body')

    <title>RTX-AI: Chỉnh Album</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <main class="w-full h-full">
        <!-- Title -->
        <div class="flex items-center justify-center">
            <div class="w-full max-w-7xl px-4 py-4 sm:px-6 sm:py-6 lg:max-w-7xl lg:px-16 text-center">
                <div class="font-bold text-3xl">Cập nhật Album</div>
                <div class="text-gray-500">Thỏa Sức Sáng Tạo - Truyền Đầy Cảm Hứng</div>
            </div>
        </div>
        <!-- Return -->
        <div class="flex justify-center">
            <a href="{{ route('showalbum', ['id' => $album->id]) }}" class="text-center w-48 h-14 relative font-sans text-black text-xl font-semibold group">
                <div class="bg-black h-12 w-1/4 flex items-center justify-center absolute left-1 top-[4px] group-hover:!bg-[#a000ff] group-hover:w-[184px] z-10 duration-500 rounded-2xl">
                    <svg width="25px" height="25px" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg">
                        <path fill="#ffffff" d="M224 480h640a32 32 0 1 1 0 64H224a32 32 0 0 1 0-64z"></path>
                        <path fill="#ffffff" d="m237.248 512 265.408 265.344a32 32 0 0 1-45.312 45.312l-288-288a32 32 0 0 1 0-45.312l288-288a32 32 0 1 1 45.312 45.312L237.248 512z"></path>
                    </svg>
                </div>
                <p class="translate-x-2" style="margin-top:12px">Quay lại</p>
            </a>
        </div>
        <!-- Form -->
        <div class="flex items-center justify-center mb-5">
            <div class="w-full max-w-2xl px-4 py-4 sm:px-6 sm:py-6 lg:max-w-7xl lg:px-16 mb-5">
                <form class="grid grid-cols-1 md:grid-cols-12 gap-4" method="POST" action="{{ route('updatealbum', $album->id) }}" enctype="multipart/form-data">
                    @csrf
                    <!-- Cover -->
                    <div class="md:col-span-4 aspect-square relative group">
                        <img id="album-cover" src="{{ $album->cover_image }}" alt="Album Cover" class="w-full h-full object-cover rounded-2xl border-4 border-[#a000ff]">
                        <label for="cover" class="absolute inset-0 flex items-center justify-center bg-white bg-opacity-50 opacity-0 group-hover:opacity-100 group-hover:!opacity-100 transition-opacity duration-300 cursor-pointer">
                            <i class="fas fa-upload text-gray-700 text-8xl"></i>
                        </label>
                        <input type="file" name="cover" id="cover" class="absolute inset-0 opacity-0 cursor-pointer form-control @error('cover') is-invalid @enderror">
                        @error('cover')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- Data -->
                    <div class="md:col-span-8 p-4 rounded-2xl" style="box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px">
                        <div class="mb-4">
                            <label for="title" class="block text-xl font-medium mb-1">Tiêu Đề</label>
                            <input type="text" id="title" name="title" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-[#a000ff] focus:!border-[#a000ff] sm:text-sm form-control @error('title') is-invalid @enderror" value="{{ $album->title }}">
                            @error('title')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="description" class="block text-xl font-medium mb-1">Mô Tả</label>
                            <textarea id="description" name="description" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-[#a000ff] focus:!border-[#a000ff] sm:text-sm form-control @error('description') is-invalid @enderror">{{ $album->description }}</textarea>
                            @error('description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-4 flex items-center">
                            <input type="checkbox" id="private" name="private" class="h-5 w-5 border-gray-300 rounded accent-[#a000ff]">
                            <label for="private" class="ml-2 block text-xl font-medium text-gray-700">Riêng Tư</label>
                        </div>
                        <div class="flex justify-center mt-4">
                            <button type="submit" id="update" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Cập Nhật Album</button>
                            <a href="{{ route('deletealbum', $album->id) }}" id="delete" style="cursor:pointer" class="rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 ml-5">Xóa Album</a>
                        </div>
                        @if(Session::has('Manytimes'))
                            <script>
                                Swal.fire({ title: 'Thông báo', text: "Bạn chỉ có thể cập nhật nội dung 1 lần trong 1 tuần.", icon: 'warning', showCancelButton: false,
                                });
                            </script>
                             <div class="flex justify-center mt-4">
                                <p class="text-red-500">Bạn chỉ có thể cập nhật nội dung 1 lần trong 1 tuần.</p>
                             </div>
                        @endif
                        <script>
                             document.getElementById('delete').addEventListener('click', function (e) {
                            e.preventDefault();

                            Swal.fire({ title: 'Chắc chắn xóa album?', text: "Tất cả ảnh trong album sẽ bị xóa và không thể khôi phục!", icon: 'warning', showCancelButton: true, confirmButtonText: 'Tiếp tục', cancelButtonText: 'Hủy', reverseButtons: true
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "{{ route('deletealbum', $album->id) }}"; 
                                } else {
                                    Swal.close();
                                }
                            });
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
                        document.getElementById('album-cover').src = e.target.result;
                    }
                    reader.readAsDataURL(file);
                }
            });
        </script>
    </main>

@endsection
