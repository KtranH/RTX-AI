@extends('User.Container')
@section('Body')

    <title>RTX-AI: Hình Ảnh</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <main class="w-full h-full">
        <!-- Container -->
        <div class="flex flex-col items-center">
            <div class="w-full max-w-2xl px-4 py-4 sm:px-6 sm:py-6 lg:max-w-7xl lg:px-16 shadow-md p-5" style="box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px; border-radius:20px">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Photo -->
                    <div class="aspect-square md:col-span-1">
                        <img src="{{ $image->url }}" alt="Image Cover" class="w-full h-full object-cover">
                    </div>
                    <!-- Details -->
                    <div class="md:col-span-1 flex flex-col">
                        <!-- Return -->
                        <a href="{{ route('showalbum', ['id' => $image->album_id]) }}" class="text-center w-48 h-14 relative font-sans text-black text-xl font-semibold group">
                            <div class="bg-black h-12 w-1/4 flex items-center justify-center absolute left-1 top-[4px] group-hover:!bg-[#a000ff] group-hover:w-[184px] z-10 duration-500 rounded-2xl">
                                <svg width="25px" height="25px" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg">
                                    <path fill="#ffffff" d="M224 480h640a32 32 0 1 1 0 64H224a32 32 0 0 1 0-64z"></path>
                                    <path fill="#ffffff" d="m237.248 512 265.408 265.344a32 32 0 0 1-45.312 45.312l-288-288a32 32 0 0 1 0-45.312l288-288a32 32 0 1 1 45.312 45.312L237.248 512z"></path>
                                </svg>
                            </div>
                            <p class="translate-x-2" style="margin-top:12px">Quay lại</p>
                        </a>
                        <!-- Title and Description -->
                        <div class="mb-2">
                            <h1 class="text-4xl font-bold truncate hover:overflow-visible hover:whitespace-normal">{{ $image->title }}</h1>
                            <p class="text-lg text-gray-600 truncate hover:overflow-visible hover:whitespace-normal">{{ $image->description }}</p>
                        </div>
                        <!-- Categories -->
                        <div class="flex flex-wrap space-x-2 mb-4">
                            @foreach ($listcate as $item)
                                <a href="#" class="text-sm text-white p-2 bg-black hover:!bg-[#a000ff] rounded-xl">{{ $item->name }}</a>
                            @endforeach
                        </div>
                        <!-- Owner -->
                        <div class="flex items-center space-x-2 mb-4">
                            <img src="{{ $user->avatar_url }}" alt="Owner Avatar" class="w-10 h-10 rounded-full">
                            <div class="flex-1">
                                <p class="font-semibold">{{ $user->username }}</p>
                            </div>
                            <a href="#" class="rounded-md bg-black px-3 py-2 text-sm font-semibold text-white shadow-sm hover:!bg-[#a000ff] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 flex items-center justify-center">Follow</a>
                        </div>
                        <!-- Action -->
                        <div class="flex justify-center space-x-4 mb-4">
                            <a href="#" class="bg-white p-2 rounded-full shadow-md flex items-center justify-center w-10 h-10">
                                <i class="fas fa-star text-gray-700 text-xl hover:text-[#a000ff]"></i>
                            </a>
                            <a href="#" class="bg-white p-2 rounded-full shadow-md flex items-center justify-center w-10 h-10">
                                <i class="fas fa-share text-gray-700 text-xl hover:text-[#a000ff]"></i>
                            </a>
                            <a href="{{ route('editimage', ['id' => $image->id]) }}" class="bg-white p-2 rounded-full shadow-md flex items-center justify-center w-10 h-10">
                                <i class="fas fa-edit text-gray-700 text-xl hover:text-[#a000ff]"></i>
                            </a>
                            <a href="{{ route('deleteimage', $image->id) }}" id="delete" class="bg-white p-2 rounded-full shadow-md flex items-center justify-center w-10 h-10">
                                <i class="fas fa-trash text-gray-700 text-xl hover:text-[#a000ff]"></i>
                            </a>
                            <script>
                                document.getElementById('delete').addEventListener('click', function (e) {
                               e.preventDefault();
    
                               Swal.fire({ title: 'Chắc chắn xóa ảnh?', text: "Ảnh sẽ bị xóa và không thể khôi phục!", icon: 'warning', showCancelButton: true, confirmButtonText: 'Tiếp tục', cancelButtonText: 'Hủy', reverseButtons: true
                               }).then((result) => {
                                   if (result.isConfirmed) {
                                       window.location.href = "{{ route('deleteimage', $image->id) }}"; 
                                   } else {
                                       Swal.close();
                                   }
                               });
                           });
                           </script>
                        </div>
                        <!-- Comment -->
                        <div class="flex flex-col mt-auto">
                            <div class="flex flex-col overflow-y-auto overflow-x-hidden max-h-44 mb-4">
                                <div class="space-y-4">
                                    @for ($i = 0; $i <= 15; $i++)
                                        <div class="flex items-start space-x-4">
                                            <img src="https://randomuser.me/api/portraits/men/2.jpg" alt="Avatar" class="w-10 h-10 rounded-full">
                                            <div>
                                                <p class="font-semibold truncate hover:overflow-visible hover:whitespace-normal">Jane Smith</p>
                                                <p class="text-sm text-gray-700 truncate hover:overflow-visible hover:whitespace-normal">This is a random comment. The layout looks great!</p>
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
                <div class="mt-2 grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-12 gap-2">
                    @for ($i = 0; $i <= 5; $i++)
                        <div class="col-span-12 sm:col-span-12 md:col-span-12 lg:col-span-3 row-span-1 relative group">
                            <a href="">
                                <div class="aspect-square">
                                    <img src="https://picsum.photos/200" alt="Image 1" class="w-full h-full object-cover transition-opacity duration-300 group-hover:opacity-15">
                                </div>
                                <div class="absolute inset-0 flex flex-col justify-between opacity-0 group-hover:opacity-100 group-hover:!opacity-100 transition-opacity duration-300">
                                    <div class="mt-2 text-left px-2 py-1">
                                        <div class="font-semibold text-lg truncate group-hover:text-[#000000]">Image 1</div>
                                        <div class="text-sm text-gray-500 h-20 overflow-hidden truncate">Description 1</div>
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
