@extends('User.Container')
@section('Body')
    <title>RTX-AI: Hình Ảnh</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <main class="w-full h-full">
        <!-- Container -->
        <div class="flex flex-col items-center">
            <div class="w-full max-w-2xl px-4 py-4 sm:px-6 sm:py-6 lg:max-w-7xl lg:px-16 rounded-2xl p-5"
                style="box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Photo -->
                    <div class="relative md:col-span-1 aspect-square group">
                        <img src="{{ $image->url }}" alt="Image Cover" class="w-full h-full object-cover rounded-2xl">
                        <a href="{{ $image->url }}" target="_blank" class="absolute top-4 left-4 text-black bg-white px-4 py-2 font-semibold text-xl rounded-lg hidden group-hover:flex items-center space-x-2">
                            <i class="fa-solid fa-circle-chevron-right"></i>
                            <span>Mở ảnh</span>
                        </a>
                    </div>                                       
                    <!-- Details -->
                    <div class="md:col-span-1 flex flex-col">
                        <!-- Return -->
                        <a href="{{ route('showalbum', ['id' => $image->album_id]) }}"
                            class="text-center w-48 h-14 relative font-sans text-black text-xl font-semibold group"
                            style="margin-bottom:10px">
                            <div
                                class="bg-black h-12 w-1/4 flex items-center justify-center absolute left-1 top-[4px] group-hover:!bg-[#a000ff] group-hover:w-[184px] z-10 duration-500 rounded-2xl">
                                <svg width="25px" height="25px" viewBox="0 0 1024 1024"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill="#ffffff" d="M224 480h640a32 32 0 1 1 0 64H224a32 32 0 0 1 0-64z"></path>
                                    <path fill="#ffffff"
                                        d="m237.248 512 265.408 265.344a32 32 0 0 1-45.312 45.312l-288-288a32 32 0 0 1 0-45.312l288-288a32 32 0 1 1 45.312 45.312L237.248 512z">
                                    </path>
                                </svg>
                            </div>
                            <p class="translate-x-2 relative" style="margin-top:12px">Quay lại</p>             
                        </a>
                        <!-- Title and Description -->
                        <div class="mb-4">
                            <h1 class="text-4xl font-bold truncate overflow-visible">{{ $image->title }}</h1>
                            <p class="text-lg mt-2 text-gray-600 truncate hover:overflow-visible hover:whitespace-normal">{{ $image->description }}</p>
                        </div>
                        <!-- Categories -->
                        <div class="flex flex-wrap gap-2 mb-4 max-w-screen-sm">
                            @foreach ($listcate as $item)
                                <a href="#" class="text-sm text-white p-2 bg-indigo-600 hover:bg-gray-400 text-center rounded-xl w-1/3 sm:w-1/4 md:w-auto">
                                    {{ $item->name }}
                                </a>
                            @endforeach
                        </div>
                        <!-- Owner -->
                        <div class="flex items-center space-x-2 mb-4">
                            <a href="#" class="flex items-center space-x-2 flex-grow group">
                                <img src="{{ $user->avatar_url }}" alt="Owner Avatar" class="w-10 h-10 rounded-full">
                                <p class="font-semibold group-hover:!text-[#a000ff]">{{ $user->username }}</p>
                            </a>
                            @if (auth()->user()->id != $album->user_id)
                                <a href="#"
                                    class="rounded-md bg-[#a00fff] px-3 py-2 text-sm font-semibold text-white shadow-sm hover:!bg-gray-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 flex items-center justify-center">Follow</a>
                            @endif
                        <!-- Action -->
                        <div class="flex justify-center space-x-4 mb-4">
                            @if($checkUserLikedImage != null)
                            <a href="#" data-id="{{ $image->id }}" class="like-button bg-white p-2 rounded-full shadow-md flex items-center justify-center w-10 h-10">
                                <i class="fas fa-heart text-red-500 text-xl hover:text-[#a000ff]"></i>
                            </a>
                            @else
                            <a href="#" data-id="{{ $image->id }}" class="like-button bg-white p-2 rounded-full shadow-md flex items-center justify-center w-10 h-10">
                                <i class="fas fa-heart text-gray-700 text-xl hover:text-[#a000ff]"></i>
                            </a>
                            @endif
                            <script>
                                $(document).ready(function() {
                                    $('.like-button').click(function(e) {
                                        e.preventDefault(); 
                            
                                        var imageId = $(this).data('id');
                            
                                        $.ajax({
                                            url: '{{ route('likeimage', ['id' => '__id__']) }}'.replace('__id__', imageId), 
                                            type: 'GET',
                                            success: function(response) {
                                                var icon = $('.like-button i');
                                                if (icon.hasClass('text-red-500')) {
                                                    icon.removeClass('text-red-500').addClass('text-gray-700');
                                                } else {
                                                    icon.removeClass('text-gray-700').addClass('text-red-500');
                                                }
                                                var statusSpan = $('#like-status');
                                                var text = statusSpan.html().trim();

                                                if (text === 'Hãy là người đầu tiên thích ảnh này <i class="fa-solid fa-heart" style="color: #ff5252;"></i>.') {
                                                    statusSpan.html('Mọi người cũng thích <i class="fa-solid fa-heart" style="color: #ff5252;"></i> : Bạn');
                                                } else {
                                                    if (text.includes('Bạn')) {
                                                        text = text.replace('Bạn', '').trim();
                                                        if(text !== 'Mọi người cũng thích <i class="fa-solid fa-heart" style="color: #ff5252;"></i> :')
                                                        {
                                                            statusSpan.html(text);
                                                        }
                                                        else
                                                        {
                                                            statusSpan.html('Hãy là người đầu tiên thích ảnh này <i class="fa-solid fa-heart" style="color: #ff5252;"></i>.');
                                                        }
                                                    } else {
                                                        text = 'Bạn ' + text;
                                                        statusSpan.html(text);
                                                    }
                                                }
                                            },
                                            error: function(xhr) {
                                                console.error('Đã xảy ra lỗi: ' + xhr.responseText);
                                            }
                                        });
                                    });
                                });
                            </script>
                                       
                            @if(Session::has("Owner"))
                                @if($image->is_feature == true)
                                    <a href="{{ route('featureimage', ['id' => $image->id]) }}" class="bg-white p-2 rounded-full shadow-md flex items-center justify-center w-10 h-10">
                                        <i class="fas fa-star text-yellow-500 text-xl hover:text-[#a000ff]"></i>
                                    </a>
                                @else
                                    <a href="{{ route('featureimage', ['id' => $image->id]) }}" class="bg-white p-2 rounded-full shadow-md flex items-center justify-center w-10 h-10">
                                        <i class="fas fa-star text-gray-700 text-xl hover:text-[#a000ff]"></i>
                                    </a>

                                @endif
                                <a href="{{ route('editimage', ['id' => $image->id]) }}" class="bg-white p-2 rounded-full shadow-md flex items-center justify-center w-10 h-10">
                                    <i class="fas fa-edit text-gray-700 text-xl hover:text-[#a000ff]"></i>
                                </a>
                                <a href="{{ route('deleteimage', $image->id) }}" id="delete" class="bg-white p-2 rounded-full shadow-md flex items-center justify-center w-10 h-10">
                                    <i class="fas fa-trash text-gray-700 text-xl hover:text-[#a000ff]"></i>
                                </a>
                            @else
                                <a href="#" class="bg-white p-2 rounded-full shadow-md flex items-center justify-center w-10 h-10">
                                    <i class="fa-solid fa-flag text-gray-700 text-xl hover:text-[#a000ff]"></i>
                                </a>
                                <a href="#" class="bg-white p-2 rounded-full shadow-md flex items-center justify-center w-10 h-10">
                                    <i class="fas fa-share text-gray-700 text-xl hover:text-[#a000ff]"></i>
                                </a>
                            @endif
                            <script>
                                document.getElementById('delete').addEventListener('click', function(e) {
                                    e.preventDefault();
                                    Swal.fire({
                                        title: 'Chắc chắn xóa ảnh?',
                                        text: "Ảnh sẽ bị xóa và không thể khôi phục!",
                                        icon: 'warning',
                                        showCancelButton: true,
                                        confirmButtonText: 'Tiếp tục',
                                        cancelButtonText: 'Hủy',
                                        reverseButtons: true
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
                    </div>
                        <!-- Number of likes -->
                        @php
                            $count = count($listUserLiked);
                        @endphp
                        @if($count == 0)
                            <span id="like-status" class="text-4xs text-gray-600 font-semibold mb-4">Hãy là người đầu tiên thích ảnh này <i class="fa-solid fa-heart" style="color: #ff5252;"></i>.</span>
                        @elseif ($count <= 2 && $count > 0)
                            <span id="like-status" class="text-4xs text-gray-600 font-semibold mb-4">Mọi người cũng thích <i class="fa-solid fa-heart" style="color: #ff5252;"></i> : 
                            @if($checkUserLikedImage != null) Bạn
                                @foreach ($listUserLiked as $l)
                                    @if($l->name != $user->name)
                                    {
                                        {{ $l->name }}, 
                                    }
                                    @endif
                                @endforeach 
                            @endif</span>
                        @else
                            <span id="like-status" class="text-4xs text-gray-600 font-semibold mb-4">Mọi người cũng thích <i class="fa-solid fa-heart" style="color: #ff5252;"></i> : 
                                @if($checkUserLikedImage != null) 
                                    Bạn và {{ $count }} người khác.
                                @endif</span>
                        @endif
                        <!-- Comment -->
                        <h3 class="font-semibold text-xl mb-2">Bình luận: </h3>
                        <div class="flex flex-col mt-auto">
                            <div class="flex flex-col overflow-y-auto overflow-x-hidden mb-4" style="max-height: 450px;">
                                <div class="space-y-6">
                                    @for ($i = 0; $i <= 1; $i++)
                                        <div class="flex items-start space-x-4">
                                            <img src="https://randomuser.me/api/portraits/men/2.jpg" alt="Avatar"
                                                class="w-10 h-10 rounded-full">
                                            <div>
                                                <p
                                                    class="font-semibold truncate hover:overflow-visible hover:whitespace-normal">
                                                    Jane Smith</p>
                                                <p
                                                    class="text-sm text-gray-700 truncate hover:overflow-visible hover:whitespace-normal">
                                                    This is a random comment. The layout looks great!</p>
                                            </div>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                            <textarea
                                class="text-base w-full p-2 bg-gray-100 shadow-sm focus:outline-none focus:border-[#a000ff] focus:!border-[#a000ff] resize-none"
                                style="border-radius:30px;" rows="1" placeholder="Thêm bình luận..."></textarea>
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
                    @foreach ($photos as $photo)
                        <div class="col-span-12 sm:col-span-12 md:col-span-12 lg:col-span-3 row-span-1 relative group">
                            <a href="{{ route('showimage', ['id' => $photo->id]) }}">
                                <div class="aspect-square">
                                    <img src="{{ $photo->url }}" alt="Image 1"
                                        class="w-full h-full rounded-2xl object-cover transition-opacity duration-300 group-hover:opacity-15">
                                </div>
                                <div
                                    class="absolute inset-0 flex flex-col justify-between opacity-0 group-hover:opacity-100 group-hover:!opacity-100 transition-opacity duration-300">
                                    <div class="mt-2 text-left px-2 py-1">
                                        <div class="font-semibold text-lg truncate group-hover:text-[#000000]">
                                            {{ $photo->title }}</div>
                                        <div class="text-sm text-gray-500 h-20 overflow-hidden truncate">
                                            {{ $photo->description }} </div>
                                    </div>
                                </div>
                            </a>
                            <div
                                class="absolute inset-x-0 bottom-0 flex justify-center p-2 opacity-0 group-hover:opacity-100 group-hover:!opacity-100 transition-opacity duration-300">
                                <div class="flex space-x-2">
                                    <a href="{{ route('showimage', ['id' => $photo->id]) }}"
                                        class="bg-white p-2 rounded-full shadow-md flex items-center justify-center w-10 h-10">
                                        <i class="fas fa-star text-gray-700 text-xl hover:text-[#a000ff]"></i>
                                    </a>
                                    <a href="{{ route('showimage', ['id' => $photo->id]) }}"
                                        class="bg-white p-2 rounded-full shadow-md flex items-center justify-center w-10 h-10">
                                        <i class="fas fa-share text-gray-700 text-xl hover:text-[#a000ff]"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </main>
@endsection
