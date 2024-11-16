@extends('User.Container')
@section('Body')

<style>
    .hover-scrollbar::-webkit-scrollbar {
        width: 6px;
        opacity: 0;
    }
    
    .hover-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    
    .hover-scrollbar::-webkit-scrollbar-thumb {
        background: transparent;
        border-radius: 3px;
        transition: background 0.3s ease;
    }
    
    .hover-scrollbar:hover::-webkit-scrollbar-thumb {
        background: rgba(156, 163, 175, 0.5);
    }
    
    .hover-scrollbar:hover::-webkit-scrollbar-thumb:hover {
        background: rgba(107, 114, 128, 0.7);
    }

    .hover-scrollbar {
        scrollbar-width: thin;
        scrollbar-color: transparent transparent;
        transition: scrollbar-color 0.3s ease;
    }

    .hover-scrollbar:hover {
        scrollbar-color: rgba(156, 163, 175, 0.5) transparent;
    }
</style>

@php
$count = count($listUserLiked);
@endphp
    <title>RTX-AI: Hình Ảnh</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <main class="w-full h-full" style="scroll-behavior: smooth">
        <!-- Container -->
        <div class="flex flex-col items-center mt-4">
            <div class="w-full max-w-2xl px-4 py-4 sm:px-6 sm:py-6 lg:max-w-7xl lg:px-16 rounded-2xl p-5 shadow-md" style="box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Photo -->
                    <div class="relative md:col-span-1 aspect-square group">
                        <img src="{{ $image->url }}" id="photo" loading="lazy" alt="Image Cover" class="w-full h-full object-cover rounded-2xl">
                        <label for="photo" class="absolute inset-0 bg-white bg-opacity-50 opacity-0 group-hover:opacity-100 group-hover:!opacity-100 transition-opacity duration-300 cursor-pointer">
                            <a href="{{ $image->url }}" target="_blank" class="w-full h-full flex items-center justify-center">
                                <i class="fas fa-image text-indigo-700 text-8xl"></i>
                            </a>
                        </label>
                    </div>                             
                    <!-- Details -->
                    <div class="md:col-span-1 flex flex-col relative">
                        <!-- Return -->
                        <a href="{{ route("showexplore") }}"
                            class="text-center w-48 h-14 relative font-sans text-black text-xl font-semibold group mb-2">
                            <div
                                class="bg-black h-12 w-1/4 flex items-center justify-center absolute left-1 top-[4px] group-hover:!bg-indigo-700 group-hover:w-[184px] z-10 duration-500 rounded-2xl">
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
                        <div class="flex flex-col overflow-y-auto overflow-x-hidden hover-scrollbar">
                            <!-- Title and Description -->
                                <div class="mb-2">
                                    <h1 class="text-4xl font-bold truncate overflow-visible">{{ $image->title }}</h1>
                                    <p class="text-lg mt-2 text-gray-600 truncate" id="description-{{ $image->id }}">
                                        {{ \Illuminate\Support\Str::limit($image->description, 1000) }}
                                        
                                        @if (strlen($image->description) > 1000)
                                            <span class="text-blue-500 cursor-pointer" onclick="showFullDescription({{ $image->id }})" id="show-more-{{ $image->id }}">
                                                Xem thêm
                                            </span>
                                        @endif
                                    </p>
                                    <script>
                                        function showFullDescription(id) {
                                            var descriptionElement = document.getElementById('description-' + id);
                                            var showMoreElement = document.getElementById('show-more-' + id);
                                    
                                            descriptionElement.innerHTML = `{{ $image->description }}`;
                                            showMoreElement.style.display = 'none';
                                        }
                                    </script>                        
                                </div>
                                <!-- Categories -->
                                <div class="flex flex-wrap gap-2 mb-4 max-w-screen-sm">
                                    @foreach ($listcate as $item)
                                        <a href="#" class="text-sm text-white p-2 bg-indigo-600 hover:bg-gray-400 text-center rounded-xl w-1/3 sm:w-1/4 md:w-auto">
                                            {{ $item->name }}
                                        </a>
                                    @endforeach
                                </div>
                                <hr class="mt-4 mb-3">
                                <!-- Owner -->
                                <div class="flex items-center space-x-4 mb-2">
                                    <a href="{{ route("showboard", ["id" => $image->album->user->id]) }}" class="flex items-center space-x-2 group">
                                        <img src="{{ $image->album->user->avatar_url }}" loading="lazy" alt="Owner Avatar" class="w-10 h-10 rounded-full">
                                        <p class="font-semibold group-hover:!text-indigo-700">{{ $image->album->user->username }}</p>
                                    </a>
                                    @if ($image->album->user->id != Auth::user()->id)
                                        <a href=""
                                            class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:!bg-gray-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 flex items-center justify-center unfollow-button" data-id="{{ $image->album->user->id }}">Hủy theo dõi
                                        </a>
                                        <a href=""
                                            class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:!bg-gray-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 flex items-center justify-center follow-button" data-id="{{ $image->album->user->id }}">Theo dõi
                                        </a>
                                        <script>
                                            $(document).ready(function() {
                                                @if(Auth::user()->isFollowing($image->album->user->id))
                                                    $('.follow-button').hide();
                                                @else
                                                    $('.unfollow-button').hide();
                                                @endif

                                                $('.follow-button').click(function(e) {
                                                    e.preventDefault();
                                                    var userId = $(this).data('id');
                                                    $.ajax({
                                                        url: '/follow',
                                                        type: 'POST',
                                                        data: {
                                                            user_id: userId,
                                                            _token: '{{ csrf_token() }}'
                                                        },
                                                        success: function(response) {
                                                            if (response.success) {
                                                                $('.follow-button').hide(); 
                                                                $('.unfollow-button').show();
                                                                Swal.fire({
                                                                    icon: 'success',
                                                                    title: 'Đã theo dõi người dùng!',
                                                                    timer: 3000,
                                                                    position: 'bottom-end',
                                                                    toast: true,
                                                                    showConfirmButton: false
                                                                })
                                                            }
                                                            else
                                                            {
                                                                Swal.fire({
                                                                    icon: 'error',
                                                                    title: 'Theo dõi người dùng thất bại!',
                                                                    timer: 3000,
                                                                    position: 'bottom-end',
                                                                    toast: true,
                                                                    showConfirmButton: false
                                                                })
                                                            }
                                                        }
                                                    });
                                                });
                                                $('.unfollow-button').click(function(e) {
                                                    e.preventDefault();
                                                    var userId = $(this).data('id');
                                                    $.ajax({
                                                        url: '/unfollow',
                                                        type: 'DELETE',
                                                        data: {
                                                            user_id: userId,
                                                            _token: '{{ csrf_token() }}'
                                                        },
                                                        success: function(response) {
                                                            if (response.success) {
                                                                $('.unfollow-button').hide();
                                                                $('.follow-button').show();
                                                                Swal.fire({
                                                                    icon: 'success',
                                                                    title: 'Đã hủy theo dõi người dùng!',
                                                                    timer: 3000,
                                                                    position: 'bottom-end',
                                                                    toast: true,
                                                                    showConfirmButton: false
                                                                })
                                                            }
                                                            else
                                                            {
                                                                Swal.fire({
                                                                    icon: 'error',
                                                                    title: 'Hủy theo dõi người dùng thất bại!',
                                                                    timer: 3000,
                                                                    position: 'bottom-end',
                                                                    toast: true,
                                                                    showConfirmButton: false
                                                                })
                                                            }
                                                        }
                                                    });
                                                });
                                            });
                                        </script>
                                    @endif
                                    <div class="flex-grow"></div>
                                <!-- Action -->
                                <div class="flex justify-center space-x-4 mt-2">
                                    @if($checkUserLikedImage != null)
                                        <a href="#" data-id="{{ $image->id }}" class="like-button bg-white p-2 rounded-full shadow-md flex items-center justify-center w-10 h-10">
                                            <i class="fas fa-heart text-red-500 text-xl hover:text-indigo-700"></i>
                                        </a>
                                    @else
                                        <a href="#" data-id="{{ $image->id }}" class="like-button bg-white p-2 rounded-full shadow-md flex items-center justify-center w-10 h-10">
                                            <i class="fas fa-heart text-gray-700 text-xl hover:text-indigo-700"></i>
                                        </a>
                                    @endif
                                    <script>
                                        $(document).ready(function() 
                                        {
                                            $('.like-button').click(function(e) 
                                            {
                                                e.preventDefault(); 
                                    
                                                var imageId = $(this).data('id');
                                    
                                                $.ajax({
                                                    url: '{{ route('likeimage', ['id' => '__id__']) }}'.replace('__id__', imageId), 
                                                    type: 'POST',
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
                                                            if (text.includes('Bạn,') || text.includes('Bạn')) {
                                                                text = text.replace('Bạn', '').trim();
                                                                text = text.replace(',', '').trim();
                                                                text = text.replace('và', "").trim();
                                                                if(text.endsWith('.'))
                                                                {
                                                                    statusSpan.html(text);
                                                                }
                                                                else
                                                                {
                                                                    statusSpan.html('Hãy là người đầu tiên thích ảnh này <i class="fa-solid fa-heart" style="color: #ff5252;"></i>.');
                                                                }
                                                            } else {
                                                                if(text.includes('Mọi người cũng thích <i class="fa-solid fa-heart" style="color: #ff5252;"></i> :') && !text.includes('người khác'))
                                                                {
                                                                    text = text.replace('Mọi người cũng thích <i class="fa-solid fa-heart" style="color: #ff5252;"></i> :', 'Mọi người cũng thích <i class="fa-solid fa-heart" style="color: #ff5252;"></i> : Bạn, ');
                                                                }
                                                                else 
                                                                {
                                                                    text = text.replace('Mọi người cũng thích <i class="fa-solid fa-heart" style="color: #ff5252;"></i> :', 'Mọi người cũng thích <i class="fa-solid fa-heart" style="color: #ff5252;"></i> : Bạn và ');
                                                                }
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
                                    @if(Auth::user()->id == $image->album->user->id)
                                        @if($image->is_feature == true)
                                            <a href="{{ route('featureimage', ['id' => $image->id]) }}" class="bg-white p-2 rounded-full shadow-md flex items-center justify-center w-10 h-10 feature-image">
                                                <i class="fas fa-star text-yellow-500 text-xl hover:text-indigo-700"></i>
                                            </a>
                                        @else
                                            <a href="{{ route('featureimage', ['id' => $image->id]) }}" class="bg-white p-2 rounded-full shadow-md flex items-center justify-center w-10 h-10 feature-image">
                                                <i class="fas fa-star text-gray-700 text-xl hover:text-indigo-700"></i>
                                            </a>
                                        @endif
                                        <a href="{{ route('editimage', ['id' => $image->id]) }}" class="bg-white p-2 rounded-full shadow-md flex items-center justify-center w-10 h-10">
                                            <i class="fas fa-edit text-gray-700 text-xl hover:text-indigo-700"></i>
                                        </a>
                                        <a href="{{ route('deleteimage', $image->id) }}" id="delete" class="bg-white p-2 rounded-full shadow-md flex items-center justify-center w-10 h-10">
                                            <i class="fas fa-trash text-gray-700 text-xl hover:text-indigo-700"></i>
                                        </a>
                                        <script>
                                            document.getElementById('delete').addEventListener('click', function(e)
                                            {
                                                e.preventDefault();
                                                Swal.fire({
                                                    title: 'Chắc chắn xóa ảnh?',
                                                    text: "Ảnh sẽ bị xóa và không thể khôi phần một!",
                                                    icon: 'warning',
                                                    showCancelButton: true,
                                                    confirmButtonText: 'Tiếp tục',
                                                    cancelButtonText: 'Hủy',
                                                    reverseButtons: true
                                                }).then((result) => {
                                                    if (result.isConfirmed) {
                                                        Swal.fire(
                                                            'Đã xóa!',
                                                            'Ảnh không bị xóa.',
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
                                                            window.location.href = "{{ route('showexplore') }}";
                                                        }
                                                    }
                                                });
                                            });
                                        </script>
                                    @else
                                        <a href="#" class="bg-white p-2 rounded-full shadow-md flex items-center justify-center w-10 h-10">
                                            <i class="fa-solid fa-flag text-gray-700 text-xl hover:text-indigo-700"></i>
                                        </a>
                                        <a href="#" class="bg-white p-2 rounded-full shadow-md flex items-center justify-center w-10 h-10 saved_button">
                                            <i class="fa-solid fa-bookmark text-gray-700 text-xl hover:text-indigo-700"></i>
                                        </a>                                        
                                        <a href="#" class="bg-white p-2 rounded-full shadow-md flex items-center justify-center w-10 h-10">
                                            <i class="fas fa-share text-gray-700 text-xl hover:text-indigo-700"></i>
                                        </a>
                                    <script>
                                       $(document).ready(function() {
                                            @if (Auth::user()->savedImg($image->id))
                                                $('.saved_button').find('i')
                                                    .removeClass('text-gray-700')
                                                    .addClass('text-blue-700');
                                            @endif
                                            $('.saved_button').click(function(e) {
                                                e.preventDefault(); 

                                                var $this = $(this); 

                                                $.ajax({
                                                    url: "{{ route('savedimage') }}", 
                                                    method: "POST", 
                                                    data: {
                                                        _token: "{{ csrf_token() }}", 
                                                        image_id: "{{ $image->id }}" 
                                                    },
                                                    success: function(response) {
                                                        if (response.saved) {
                                                            $this.find('i')
                                                                .removeClass('text-gray-700')
                                                                .addClass('text-blue-700');
                                                        } else {
                                                            $this.find('i')
                                                                .removeClass('text-blue-700')
                                                                .addClass('text-gray-700');
                                                        }

                                                        Swal.fire({
                                                            icon: 'success',
                                                            title: 'Thao tác thành công',
                                                            timer: 3000,
                                                            position: 'bottom-end',
                                                            toast: true,
                                                            showConfirmButton: false
                                                        });
                                                    },
                                                    error: function(xhr) {
                                                        console.error('Đã xảy ra lỗi: ' + xhr.responseText);

                                                        Swal.fire({
                                                            icon: 'error',
                                                            title: 'Thao tác thất bại!',
                                                            timer: 3000,
                                                            position: 'bottom-end',
                                                            toast: true,
                                                            showConfirmButton: false
                                                        });
                                                    }
                                                });
                                            });
                                        });
                                    </script>
                                    @endif
                                    <script>
                                        document.getElementById('delete').addEventListener('click', function(e)
                                        {
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
                            <hr class="mb-4 mt-3">
                            <!-- Number of likes -->
                            @if($count == 0)
                                <span id="like-status" class="text-4xs text-gray-600 font-semibold mb-4">Hãy là người đầu tiên thích ảnh này <i class="fa-solid fa-heart" style="color: #ff5252;"></i>.</span>
                            @elseif ($count == 1)
                                <span id="like-status" class="text-4xs text-gray-600 font-semibold mb-4">Mọi người cũng thích <i class="fa-solid fa-heart" style="color: #ff5252;"></i> : 
                                    @if($checkUserLikedImage != null) 
                                        Bạn
                                    @endif
                                </span>
                            @elseif ($count <= 2 && $count > 0)
                                <span id="like-status" class="text-4xs text-gray-600 font-semibold mb-4">Mọi người cũng thích <i class="fa-solid fa-heart" style="color: #ff5252;"></i> : 
                                @if($checkUserLikedImage != null) 
                                    Bạn,
                                @endif
                                    @foreach ($listUserLiked as $l)
                                        @if(Auth::user()->id != $l->user_id)
                                            {{ $l->user->username }}{{ $loop->last ? '.' : ', ' }}
                                        @endif
                                    @endforeach 
                                </span>
                            @else
                                <span id="like-status" class="text-4xs text-gray-600 font-semibold mb-4">Mọi người cũng thích <i class="fa-solid fa-heart" style="color: #ff5252;"></i> : 
                                    @if($checkUserLikedImage != null) 
                                        Bạn và {{ $count }} người khác.
                                    @else
                                        {{ $count }} người khác.
                                    @endif
                                </span>
                            @endif
                            <!-- Comment -->
                            <h3 class="font-semibold text-xl mb-2" id="commentCount">Bình luận ({{ $countComment }}) 
                                @if ($countComment > 3)
                                    <!-- Want More -->
                                    <span id="loadMoreContainer" class="text-center">
                                        <button id="loadMoreButton" class="text-indigo-700 text-sm">Xem thêm</button>
                                    </span>
                                @endif
                            </h3>
                            <div class="flex-grow flex items-center justify-center"> 
                            </div>
                            <div id="comment" class="flex flex-col">
                                <div class="space-y-2 mb-4">
                                    <div id="commentList" class="space-y-4 max-h-80 min-h-32">
                                        @if($countComment == 0)
                                            <p id="noCommentsMessage" class="text-gray-400 text-2xs">Chưa có bình luận nào...!</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Add Comment -->
                        <div class="flex items-center space-x-4 mt-2">
                            <form id="commentForm" class="flex w-full" enctype="multipart/form-data" method="POST" action="{{ route('addcomment', $image->id) }}">
                                @csrf
                                <input type="text" id="addComment" name="comment" class="placeholder-gray-600 flex-grow px-4 py-2 text-gray-700 bg-gray-200 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Thêm bình luận">
                                <button type="submit" class="ml-4 pl-3 pr-4 py-2  text-white bg-indigo-500 rounded-full hover:bg-blue-600 focus:ring-2 focus:ring-blue-300">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </form>
                        </div>
                        <script>
                            $(document).ready(function() {
                                var skip = 0; 
                                var idImage = '{{ $image->id }}';

                                function loadComments() {
                                    $.ajax({
                                        url: "{{ route('loadmorecomment', ['idImage' => $image->id]) }}",
                                        method: "GET",
                                        data: {
                                            skip: skip,
                                        },
                                        success: function(response) {
                                            if (response.success) {
                                                var comments = response.comments;

                                                if (comments.length === 0) {
                                                    $('#loadMoreButton').hide(); 
                                                }

                                                $.each(comments, function(index, comment) {
                                                    var newCommentHtml = `
                                                        <div class="comment-item space-y-2 relative" data-comment-id="${comment.id}" data-reply-count="${comment.replies_count}">
                                                            <div class="flex items-start space-x-4">
                                                                <img src="${comment.user.avatar_url}" alt="Avatar" class="w-10 h-10 rounded-full">
                                                                <div class="flex-grow">
                                                                    <div class="bg-gray-100 p-3 rounded-lg w-full">
                                                                        <div class="font-semibold truncate hover:overflow-visible hover:whitespace-normal">${comment.user.username}</div>
                                                                        <div class="text-sm text-gray-700 truncate hover:overflow-visible hover:whitespace-normal comment-content">${comment.content}</div>
                                                                        ${(comment.user_id == '{{ Auth::user()->id }}') ?
                                                                        `<form class="edit-form hidden mt-2">
                                                                            <input type="text" 
                                                                                class="edit-input w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm text-gray-700 placeholder-gray-400"
                                                                                value="${comment.content}" 
                                                                                placeholder="Viết bình luận...">
                                                                                <div class="flex justify-end mt-2 space-x-2">
                                                                                    <button type="button" class="cancel-edit px-4 py-1.5 text-sm font-medium text-gray-700 hover:text-gray-900 rounded-md hover:bg-gray-100 transition duration-200">Hủy</button>
                                                                                    <button type="submit" class="save-edit px-4 py-1.5 text-sm font-medium text-white bg-blue-500 rounded-md hover:bg-blue-600 focus:ring-2 focus:ring-blue-300 disabled:opacity-50 disabled:cursor-not-allowed transition duration-200">Lưu</button>
                                                                                </div>
                                                                            </form>`
                                                                        : ''}
                                                                        </div>
                                                                    <div class="flex items-center space-x-4 text-sm text-gray-500">
                                                                        <p class="font-semibold hover:text-indigo-700 hover:font-semibold">${comment.time_ago}</p>
                                                                        <button class="reply-button font-bold hover:text-indigo-700 hover:font-bold" data-original-comment-id="${comment.id}">Phản hồi</button>
                                                                        ${(comment.user_id == '{{ Auth::user()->id }}') ?
                                                                            `<button class="hover:text-indigo-700 font-bold hover:font-semibold update-button" data-comment-id="${comment.id}">Chỉnh sửa</button>
                                                                            <button class="hover:text-indigo-700 font-bold hover:font-semibold delete-button" data-comment-id="${comment.id}">Xóa</button>`
                                                                            : ''}
                                                                        ${(new Date(comment.updated_at).getTime() !== new Date(comment.created_at).getTime()) ? `<p class="font-bold hover:text-indigo-700 hover:font-semibold">Đã chỉnh sửa</p>` : ''}
                                                                    </div>
                                                                    <form class="reply-form hidden mt-2">
                                                                            <div class="flex items-start space-x-2">
                                                                                <i class="fa-solid fa-repeat text-gray-400 text-lg"></i>
                                                                                <img src="{{ Auth::user()->avatar_url }}" alt="Avatar" class="w-8 h-8 rounded-full">
                                                                                <div class="flex-grow">
                                                                                    <div class="relative">
                                                                                        <input type="text" 
                                                                                            class="reply-input w-full px-4 py-2 rounded-lg border border-gray-200 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm text-gray-700 placeholder-gray-400"
                                                                                            placeholder="Viết phản hồi...">
                                                                                    </div>
                                                                                    <span class="text-xs text-gray-400 font-semibold">Đang trả lời <b>${comment.user.username}</b></span>
                                                                                    <div class="flex justify-end mt-2 space-x-2">
                                                                                        <button type="button" 
                                                                                            class="cancel-reply px-4 py-1.5 text-sm font-medium text-gray-700 hover:text-gray-900 rounded-md hover:bg-gray-100 transition duration-200">
                                                                                            Hủy
                                                                                        </button>
                                                                                        <button type="submit" 
                                                                                            class="submit-reply px-4 py-1.5 text-sm font-medium text-white bg-blue-500 rounded-md hover:bg-blue-600 focus:ring-2 focus:ring-blue-300 disabled:opacity-50 disabled:cursor-not-allowed transition duration-200">
                                                                                            Phản hồi
                                                                                        </button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                    </form>
                                                                    ${(parseInt(comment.replies_count) > 0) ? '<i class="fa-solid fa-arrow-right-arrow-left mr-2 text-gray-400"></i><button class="view-replies text-sm text-gray-400 font-bold hover:text-indigo-700 pt-2 hover:font-semibold">Xem ' + comment.replies_count + ' phản hồi </button>' : ''}
                                                                    <div class="replies-container ml-8 mt-2">

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    `;
                                                    $('#commentList').append(newCommentHtml);
                                                });

                                                skip += comments.length;
                                            } else {
                                                alert('Đã xảy ra lỗi, vui lòng thử lại');
                                            }
                                        }
                                    });
                                }

                                loadComments();

                                $('#loadMoreButton').on('click', function() {
                                    loadComments();
                                    const toast = Swal.mixin({
                                        toast: true,
                                        position: 'top-end',
                                        showConfirmButton: false,
                                        timer: 1500
                                    });

                                    toast.fire({
                                        title: 'Thông báo',
                                        text: 'Đã thêm bình luận',
                                        icon: 'success'
                                    });
                                });
                                $(document).on('click', '.delete-button', function() {
                                    var commentItem = $(this).closest('.comment-item');
                                    var commentId = $(this).data('comment-id');
                                    
                                    Swal.fire({
                                        title: 'Bạn có chắc chắn?',
                                        text: "Bạn không thể hoàn tác hành động này!",
                                        icon: 'warning',
                                        showCancelButton: true,
                                        confirmButtonColor: '#3085d6',
                                        cancelButtonColor: '#d33',
                                        confirmButtonText: 'Có, xóa nó!',
                                        cancelButtonText: 'Hủy'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            $.ajax({
                                                url: `/deletecomment/${commentId}`,
                                                type: 'DELETE',
                                                data: {
                                                    _token: '{{ csrf_token() }}'
                                                },
                                                success: function(response) {
                                                    if (response.success) {
                                                        Swal.fire(
                                                            'Đã xóa!',
                                                            'Bình luận đã được xóa.',
                                                            'success'
                                                        );
                                                        commentItem.remove();
                                                        var currentCount = parseInt($('#commentCount').text().match(/\d+/)[0]); 
                                                        $('#commentCount').text(`Bình luận (${currentCount - 1})`);
                                                        loadComments();
                                                    } else {
                                                        Swal.fire(
                                                            'Lỗi!',
                                                            'Có lỗi xảy ra khi xóa bình luận.',
                                                            'error'
                                                        );
                                                    }
                                                },
                                                error: function() {
                                                    Swal.fire(
                                                        'Lỗi!',
                                                        'Có lỗi xảy ra khi xóa bình luận.',
                                                        'error'
                                                    );
                                                }
                                            });
                                        }
                                    });
                                });
                                let lastCommentTime = 0;
                                const COMMENT_COOLDOWN = 3000;

                                $('#commentForm').on('submit', function(e) {
                                    e.preventDefault();
                                    
                                    const currentTime = Date.now();
                                    const timeSinceLastComment = currentTime - lastCommentTime;
                                    
                                    if (timeSinceLastComment < COMMENT_COOLDOWN) {
                                        const remainingTime = Math.ceil((COMMENT_COOLDOWN - timeSinceLastComment) / 1000);
                                        Swal.fire({
                                            title: 'Bình luận quá nhanh!',
                                            text: `Vui lòng đợi ${remainingTime} giây trước khi bình luận tiếp.`,
                                            icon: 'warning',
                                            confirmButtonText: 'Đồng ý',
                                            confirmButtonColor: '#3085d6'
                                        });
                                        return;
                                    }
                                    
                                    var comment = $('#addComment').val();
                                    var idImage = '{{ $image->id }}';
                                    
                                    if (!comment) {
                                        Swal.fire({
                                            title: 'Lỗi',
                                            text: 'Vui lòng nhập bình luận',
                                            icon: 'error',
                                            confirmButtonText: 'Đồng ý',
                                            confirmButtonColor: '#3085d6'
                                        });
                                        return;
                                    }

                                    $.ajax({
                                        url: "{{ route('addcomment', ['idImage' => $image->id]) }}",
                                        method: "POST",
                                        enctype: 'multipart/form-data',
                                        data: {
                                            comment: comment,
                                            _token: "{{ csrf_token() }}" 
                                        },
                                        success: function(response) {
                                            if (response.success) {
                                                console.log('Response:', response);
                                                lastCommentTime = Date.now();
                                                
                                                const comment = response.comment;
                                                
                                                var newCommentHtml = `
                                                    <div class="comment-item space-y-2 relative" data-comment-id="${comment.id}" data-reply-count="${comment.replies_count}">
                                                        <div class="flex items-start space-x-4">
                                                            <img src="${comment.user.avatar_url}" alt="Avatar" class="w-10 h-10 rounded-full">
                                                            <div class="flex-grow">
                                                                <div class="bg-gray-100 p-3 rounded-lg w-full">
                                                                    <div class="font-semibold truncate hover:overflow-visible hover:whitespace-normal">${comment.user.username}</div>
                                                                    <div class="text-sm text-gray-700 truncate hover:overflow-visible hover:whitespace-normal comment-content">${comment.content}</div>
                                                                    ${(comment.user_id == '{{ Auth::user()->id }}') ?
                                                                        `<form class="edit-form hidden mt-2">
                                                                            <input type="text" 
                                                                                class="edit-input w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm text-gray-700 placeholder-gray-400"
                                                                                value="${comment.content}" 
                                                                                placeholder="Viết bình luận...">
                                                                                <div class="flex justify-end mt-2 space-x-2">
                                                                                    <button type="button" class="cancel-edit px-4 py-1.5 text-sm font-medium text-gray-700 hover:text-gray-900 rounded-md hover:bg-gray-100 transition duration-200">Hủy</button>
                                                                                    <button type="submit" class="save-edit px-4 py-1.5 text-sm font-medium text-white bg-blue-500 rounded-md hover:bg-blue-600 focus:ring-2 focus:ring-blue-300 disabled:opacity-50 disabled:cursor-not-allowed transition duration-200">Lưu</button>
                                                                                </div>
                                                                        </form>`
                                                                    : ''}
                                                                </div>
                                                                <div class="flex items-center space-x-4 text-sm text-gray-500">
                                                                    <p class="font-semibold hover:text-indigo-700 hover:font-semibold">${comment.time_ago}</p>
                                                                    <button class="reply-button font-bold hover:text-indigo-700 hover:font-bold" data-original-comment-id="${comment.id}">Phản hồi</button>
                                                                    ${(comment.user_id == '{{ Auth::user()->id }}') ?
                                                                        `<button class="hover:text-indigo-700 font-bold hover:font-semibold update-button" data-comment-id="${comment.id}">Chỉnh sửa</button>
                                                                        <button class="hover:text-indigo-700 font-bold hover:font-semibold delete-button" data-comment-id="${comment.id}">Xóa</button>`
                                                                    : ''}
                                                                    ${(new Date(comment.updated_at).getTime() !== new Date(comment.created_at).getTime()) ? 
                                                                        `<p class="font-bold hover:text-indigo-700 hover:font-semibold">Đã chỉnh sửa</p>` : 
                                                                    ''}
                                                                </div>
                                                                <form class="reply-form hidden mt-2">
                                                                    <div class="flex items-start space-x-2">
                                                                        <i class="fa-solid fa-repeat text-gray-400 text-lg"></i>
                                                                        <img src="{{ Auth::user()->avatar_url }}" alt="Avatar" class="w-8 h-8 rounded-full">
                                                                        <div class="flex-grow">
                                                                            <div class="relative">
                                                                                <input type="text" 
                                                                                    class="reply-input w-full px-4 py-2 rounded-lg border border-gray-200 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm text-gray-700 placeholder-gray-400"
                                                                                    placeholder="Viết phản hồi...">
                                                                            </div>
                                                                            <span class="text-xs text-gray-400 font-semibold">Đang trả lời <b>${comment.user.username}</b></span>
                                                                            <div class="flex justify-end mt-2 space-x-2">
                                                                                <button type="button" 
                                                                                    class="cancel-reply px-4 py-1.5 text-sm font-medium text-gray-700 hover:text-gray-900 rounded-md hover:bg-gray-100 transition duration-200">
                                                                                    Hủy
                                                                                </button>
                                                                                <button type="submit" 
                                                                                    class="submit-reply px-4 py-1.5 text-sm font-medium text-white bg-blue-500 rounded-md hover:bg-blue-600 focus:ring-2 focus:ring-blue-300 disabled:opacity-50 disabled:cursor-not-allowed transition duration-200">
                                                                                    Phản hồi
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                                ${(parseInt(comment.replies_count) > 0) ? 
                                                                    '<i class="fa-solid fa-arrow-right-arrow-left mr-2 text-gray-400"></i><button class="view-replies text-sm text-gray-400 font-bold hover:text-indigo-700 pt-2 hover:font-semibold">Xem ' + comment.replies_count + ' phản hồi </button>' : 
                                                                ''}
                                                                <div class="replies-container ml-8 mt-2"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                `;
                                                
                                                $('#commentList').prepend(newCommentHtml);
                                                $('#addComment').val('');
                                                $('#noCommentsMessage').remove();
                                                var currentCount = parseInt($('#commentCount').text().match(/\d+/)[0]); 
                                                $('#commentCount').text(`Bình luận (${currentCount + 1})`);
                                            } else {
                                                Swal.fire({
                                                    title: 'Lỗi',
                                                    text: 'Đã xảy ra lỗi, vui lòng thử lại',
                                                    icon: 'error',
                                                    confirmButtonText: 'Đồng ý',
                                                    confirmButtonColor: '#3085d6'
                                                });
                                            }
                                        },
                                        error: function(xhr) {
                                            if (xhr.status === 422) {
                                                var errors = xhr.responseJSON.errors;
                                                Swal.fire({
                                                    title: 'Lỗi',
                                                    text: errors.comment[0],
                                                    icon: 'error',
                                                    confirmButtonText: 'Đồng ý',
                                                    confirmButtonColor: '#3085d6'
                                                });
                                            }
                                        }
                                    });
                                });
                                $(document).on('click', '.update-button', function() {
                                    var commentItem = $(this).closest('.comment-item');
                                    var content = commentItem.find('.comment-content').text();
                                    var form = commentItem.find('.edit-form');
                                    var input = form.find('.edit-input');
                                    
                                    commentItem.find('.comment-content').hide();
                                    form.removeClass('hidden');
                                    input.val(content).focus();
                                });

                                $(document).on('click', '.cancel-edit', function() {
                                    var form = $(this).closest('.edit-form');
                                    var commentItem = form.closest('.comment-item');
                                    
                                    form.addClass('hidden');
                                    commentItem.find('.comment-content').show();
                                });

                                $(document).on('submit', '.edit-form', function(e) {
                                    e.preventDefault();
                                    var form = $(this);
                                    var commentItem = form.closest('.comment-item');
                                    var commentId = commentItem.find('.update-button').data('comment-id');
                                    var newContent = form.find('.edit-input').val();

                                    $.ajax({
                                        url: `/updatecomment/${commentId}`,
                                        type: 'PATCH',
                                        data: {
                                            content: newContent,
                                            _token: '{{ csrf_token() }}'
                                        },
                                        success: function(response) {
                                            if (response.success) {
                                                commentItem.find('.comment-content').text(newContent).show();
                                                form.addClass('hidden');
                                                
                                                Swal.fire({
                                                    icon: 'success',
                                                    title: 'Đã cập nhật bình luận',
                                                    showConfirmButton: false,
                                                    timer: 1500
                                                });
                                            }
                                        },
                                        error: function() {
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Có lỗi xảy ra',
                                                text: 'Không thể cập nhật bình luận'
                                            });
                                        }
                                    });
                                });
                                $('.replies-container').hide();
                                $(document).on('click', '.reply-button', function(e) {
                                    e.preventDefault();
                                    const commentItem = $(this).closest('.comment-item, .reply-item');
                                    const replyForm = commentItem.find('.reply-form');
                                    
                                    $('.reply-form').not(replyForm).addClass('hidden');
                                    
                                    replyForm.toggleClass('hidden');
                                    
                                    if (!replyForm.hasClass('hidden')) {
                                        replyForm.find('.reply-input').focus();
                                    }
                                });

                                $(document).on('click', '.cancel-reply', function(e) {
                                    e.preventDefault();
                                    const form = $(this).closest('.reply-form');
                                    form.addClass('hidden');
                                    form.find('.reply-input').val('');
                                });

                                $(document).on('submit', '.reply-form', function(e) {
                                    e.preventDefault();
                                    const form = $(this);
                                    const commentItem = form.closest('.comment-item');
                                    const content = form.find('.reply-input').val();
                                    const parentId = commentItem.data('comment-id');

                                    if (!content) {
                                        Swal.fire({
                                            icon: 'warning',
                                            title: 'Vui lòng nhập nội dung phản hồi'
                                        });
                                        return;
                                    }

                                    $.ajax({
                                        url: `/api/comments/${parentId}/replies`,
                                        method: 'POST',
                                        data: {
                                            content: content,
                                            _token: '{{ csrf_token() }}'
                                        },
                                        success: function(response) {
                                            if (response.success) {
                                                const replyHtml = createReplyHTML(response.reply);
                                                
                                                let repliesContainer = commentItem.find('.replies-container');
                                                if (repliesContainer.length === 0) {
                                                    commentItem.append('<div class="replies-container mt-2"></div>');
                                                    repliesContainer = commentItem.find('.replies-container');
                                                }

                                                repliesContainer.prepend(replyHtml);
                                                
                                                repliesContainer.show();
                                                
                                                form.addClass('hidden').find('.reply-input').val('');
                                    
                                                Swal.fire({
                                                    icon: 'success',
                                                    title: 'Đã thêm phản hồi',
                                                    showConfirmButton: false,
                                                    timer: 1500
                                                });
                                            }
                                        },
                                        error: function(xhr) {
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Có lỗi xảy ra',
                                                text: xhr.responseJSON?.message || 'Vui lòng thử lại sau'
                                            });
                                        }
                                    });
                                });
                                function loadReplies(commentId, container, skip = 0) {
                                    $.ajax({
                                        url: `/api/getcomments/${commentId}/replies`,
                                        method: 'GET',
                                        data: { skip: skip },
                                        success: function(response) {
                                            if (response.success) {
                                                if (skip === 0) {
                                                    container.empty();
                                                }
                                                
                                                container.find('.load-more-replies').remove();
                                                
                                                const repliesHtml = response.replies.map(reply => createReplyHTML(reply)).join('');
                                                container.append(repliesHtml);
                                                
                                                if (response.hasMore) {
                                                    const loadMoreBtn = $(`
                                                        <button class="load-more-replies text-sm text-gray-400 font-bold hover:text-indigo-700 mt-2 w-full text-left">
                                                            <i class="fa-solid fa-arrow-right-arrow-left mr-2 text-gray-400"></i>Xem thêm phản hồi
                                                        </button>
                                                    `);
                                                    
                                                    loadMoreBtn.on('click', function() {
                                                        $(this).html('<i class="fas fa-spinner fa-spin mr-2"></i>Đang tải...');
                                                        $(this).prop('disabled', true);
                                                        
                                                        loadReplies(commentId, container, skip + 3);
                                                    });
                                                    
                                                    container.append(loadMoreBtn);
                                                }
                                                
                                                if (skip > 0) {
                                                    container.find('.reply-item').slice(-response.replies.length).hide().slideDown(300);
                                                } else {
                                                    container.slideDown(300);
                                                }
                                            }
                                        },
                                        error: function(error) {
                                            console.error('Error loading replies:', error);
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Có lỗi xảy ra',
                                                text: 'Không thể tải phản hồi. Vui lòng thử lại sau.'
                                            });
                                        }
                                    });
                                }
                                $(document).on('click', '.view-replies', function(e) {
                                    e.preventDefault();
                                    const commentItem = $(this).closest('.comment-item');
                                    const repliesContainer = commentItem.find('.replies-container');
                                    const commentId = commentItem.data('comment-id');
                                    
                                    if (repliesContainer.is(':visible')) {
                                        repliesContainer.slideUp(function() {
                                            repliesContainer.empty();
                                            const replyCount = commentItem.data('reply-count');
                                            commentItem.find('.view-replies').text(`Xem ${replyCount} phản hồi`);
                                        });
                                    } else {
                                        loadReplies(commentId, repliesContainer);
                                        $(this).text('Ẩn phản hồi');
                                        repliesContainer.slideDown();
                                    }
                                });
                                function createReplyHTML(reply) {
                                    return `
                                        <div class="reply-item mt-2" data-reply-id="${reply.id}" data-original-comment-id="${reply.original_comment_id}">
                                            <div class="flex items-start space-x-2">
                                                <img src="${reply.user.avatar_url}" alt="Avatar" class="w-8 h-8 rounded-full">
                                                <div class="flex-grow">
                                                    <div class="bg-gray-100 p-3 rounded-2xl">
                                                        <div class="font-semibold text-sm hover:underline cursor-pointer">
                                                            ${reply.user.username}
                                                        </div>
                                                        <div class="text-sm text-gray-700 mt-1">
                                                            <a href="#" class="text-blue-500">${reply.reply_reply.id ? (reply.reply_reply.id != reply.user.id ? '@' + reply.reply_reply.username : '') : (reply.comment_id.id ? (reply.comment_id.id != reply.user.id ? '@' + reply.comment_id.username : '') : '')}</a><span class="reply-content"> ${reply.content}</span>
                                                            ${reply.user.id == '{{ Auth::user()->id }}' ? `
                                                            <form class="edit-reply-form hidden mt-2">
                                                                <div class="flex items-start space-x-2">    
                                                                    <img src="{{ Auth::user()->avatar_url }}" class="w-8 h-8 rounded-full">
                                                                    <div class="flex-grow">
                                                                        <div class="relative">
                                                                            <input type="text" 
                                                                                class="edit-reply-input w-full px-4 py-2 rounded-lg border border-gray-200 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                                                placeholder="Viết phản hồi...">
                                                                        </div>
                                                                        <span class="text-xs text-gray-400 font-semibold">Đang trả lời <b>${reply.user.username}</b></span>
                                                                        <div class="flex justify-end mt-2 space-x-2">   
                                                                            <button type="button" class="cancel-edit px-4 py-1.5 text-sm font-medium text-gray-700 hover:bg-gray-100">
                                                                                Hủy
                                                                            </button>
                                                                            <button type="submit" class="px-4 py-1.5 text-sm font-medium text-white bg-blue-500 rounded-md hover:bg-blue-600">
                                                                                Chỉnh sửa
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        ` : ''}
                                                        </div>
                                                    </div>
                                                    <div class="flex items-center space-x-4 text-sm text-gray-500">
                                                        <span class="font-semibold hover:text-indigo-700 hover:font-semibold">${reply.time_ago}</span>
                                                        <button class="reply-reply-button font-bold hover:text-indigo-700 hover:font-bold hover:text-blue-600">Phản hồi</button>
                                                        ${reply.user.id == '{{ Auth::user()->id }}' ? `
                                                            <button class="edit-reply-reply font-bold hover:text-indigo-700 hover:font-bold hover:text-blue-600">Chỉnh sửa</button>
                                                            <button class="delete-reply-reply font-bold hover:text-indigo-700 hover:font-bold hover:text-red-600">Xóa</button>
                                                        ` : ''}
                                                        ${(new Date(reply.updated_at).getTime() !== new Date(reply.created_at).getTime()) ?  
                                                        `<span class="font-bold hover:text-indigo-700 hover:font-semibold">Đã chỉnh sửa</span>`
                                                        : ''}
                                                    </div>
                                                <form class="reply-reply-form hidden mt-2">
                                                        <div class="flex items-start space-x-2">
                                                            <i class="fa-solid fa-repeat text-gray-400 text-lg"></i>
                                                            
                                                            <img src="{{ Auth::user()->avatar_url }}" 
                                                                alt="Avatar" 
                                                                class="w-8 h-8 rounded-full">
                                                            
                                                            <div class="flex-grow">
                                                                <div class="relative">
                                                                    <input type="text" 
                                                                        class="reply-reply-input w-full px-4 py-2 rounded-lg border border-gray-200 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm text-gray-700 placeholder-gray-400"
                                                                        placeholder="Viết phản hồi...">
                                                                </div>
                                                                
                                                                <span class="text-xs text-gray-400 font-semibold">
                                                                    Đang trả lời <b>${reply.user.username}</b>
                                                                </span>
                                                                
                                                                <div class="flex justify-end mt-2 space-x-2">
                                                                    <button type="button" 
                                                                            class="cancel-reply-reply px-4 py-1.5 text-sm font-medium text-gray-700 hover:text-gray-900 rounded-md hover:bg-gray-100 transition duration-200">
                                                                        Hủy
                                                                    </button>
                                                                    
                                                                    <button type="submit" 
                                                                            class="submit-reply-reply px-4 py-1.5 text-sm font-medium text-white bg-blue-500 rounded-md hover:bg-blue-600 focus:ring-2 focus:ring-blue-300 disabled:opacity-50 disabled:cursor-not-allowed transition duration-200">
                                                                        Phản hồi
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    `;
                                }
                                function deleteReply(replyId) {
                                    const $deleteBtn = $(`.reply-item[data-reply-id="${replyId}"] .delete-reply-reply`);
                                    $deleteBtn.prop('disabled', true);

                                    $.ajax({
                                        url: `/api/deletereply/${replyId}`,
                                        method: 'DELETE',
                                        data: {
                                            _token: '{{ csrf_token() }}'
                                        },
                                        success: function(response) {
                                            if (response && response.success) {
                                                $(`.reply-item[data-reply-id="${replyId}"]`).fadeOut('fast', function() {
                                                    $(this).remove();
                                                });
                                                Swal.fire({
                                                    icon: 'success',
                                                    title: 'Đã xóa phản hồi thành công'
                                                });
                                            } else {
                                                Swal.fire({
                                                    icon: 'error',
                                                    title: 'Có lỗi xảy ra',
                                                    text: response.message || 'Không thể xóa phản hồi'
                                                });
                                            }
                                        },
                                        error: function(error) {
                                            console.error('Error deleting reply:', error);
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Có lỗi xảy ra',
                                                text: 'Không thể xóa phản hồi. Vui lòng thử lại sau.'
                                            });
                                        },
                                        complete: function() {
                                            $deleteBtn.prop('disabled', false);
                                        }
                                    });
                                }
                                $(document).on('click', '.delete-reply-reply', function() {
                                    const replyId = $(this).closest('.reply-item').data('reply-id');
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Xóa phản hồi bình luận',
                                        text: 'Bạn sẽ không thể khôi phục lại quyết định này!',
                                        showCancelButton: true,
                                        confirmButtonText: 'Xóa',
                                        cancelButtonText: 'Hủy',

                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            deleteReply(replyId);
                                        }
                                    })
                                });
                                $(document).on('click', '.edit-reply-reply', function(e) {                                
                                    var replyItem = $(this).closest('.reply-item');
                                    var content = replyItem.find('.reply-content').text();
                                    var form = replyItem.find('.edit-reply-form');
                                    var input = form.find('.edit-reply-input');
                                    
                                    replyItem.find('.reply-content').hide();
                                    form.removeClass('hidden');
                                    input.val(content).focus();
                                });

                                $(document).on('click', '.cancel-edit', function(e) {
                                    var form = $(this).closest('.edit-reply-form');
                                    var replyItem = form.closest('.reply-item');
                                    
                                    form.addClass('hidden');
                                    replyItem.find('.reply-content').show();
                                });

                                $(document).on('submit', '.edit-reply-form', function(e) {
                                    e.preventDefault();
                                    var form = $(this);
                                    const replyItem = $(this).closest('.reply-item');
                                    const replyId = replyItem.data('reply-id');
                                    var newContent = form.find('.edit-reply-input').val();

                                    $.ajax({
                                        url: `/api/updatereply/${replyId}`,
                                        type: 'PATCH',
                                        data: {
                                            content: newContent,
                                            _token: '{{ csrf_token() }}'
                                        },
                                        success: function(response) {
                                            if (response.success) {
                                                replyItem.find('.reply-content').text(newContent).show();
                                                form.addClass('hidden');
                                                
                                                Swal.fire({
                                                    icon: 'success',
                                                    title: 'Đã cập nhật bình luận',
                                                    showConfirmButton: false,
                                                    timer: 1500
                                                });
                                            }
                                        },
                                        error: function() {
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Có lỗi xảy ra',
                                                text: 'Không thể cập nhật bình luận'
                                            });
                                        }
                                    });
                                });
                                $(document).on('click', '.reply-reply-button', function(e) {
                                    e.preventDefault();
                                    const commentItem = $(this).closest('.reply-item');
                                    const replyForm = commentItem.find('.reply-reply-form');
                                    
                                    $('.reply-reply-form').not(replyForm).addClass('hidden');
                                    
                                    replyForm.toggleClass('hidden');
                                    
                                    if (!replyForm.hasClass('hidden')) {
                                        replyForm.find('.reply-reply-input').focus();
                                    }
                                });

                                $(document).on('click', '.cancel-reply-reply', function(e) {
                                    e.preventDefault();
                                    const form = $(this).closest('.reply-reply-form');
                                    form.addClass('hidden');
                                    form.find('.reply-reply-input').val('');
                                });

                                $(document).on('submit', '.reply-reply-form', function(e) {
                                    e.preventDefault();
                                    const form = $(this);
                                    const commentItem = form.closest('.reply-item');
                                    const content = form.find('.reply-reply-input').val();
                                    const parentId = commentItem.data('reply-id');

                                    if (!content) {
                                        Swal.fire({
                                            icon: 'warning',
                                            title: 'Vui lòng nhập nội dung phản hồi'
                                        });
                                        return;
                                    }

                                    $.ajax({
                                        url: `/api/reply/${parentId}/replies`,
                                        method: 'POST',
                                        data: {
                                            content: content,
                                            _token: '{{ csrf_token() }}'
                                        },
                                        success: function(response) {
                                            if (response.success) {
                                                console.log('Response:', response);
                                                const replyHtml = createReplyHTML(response.reply);
                                                
                                                let repliesContainer = commentItem.find('.replies-container');
                                                if (repliesContainer.length === 0) {
                                                    commentItem.append('<div class="replies-container mt-2"></div>');
                                                    repliesContainer = commentItem.find('.replies-container');
                                                }

                                                repliesContainer.prepend(replyHtml);
                                                
                                                repliesContainer.show();
                                                
                                                form.addClass('hidden').find('.reply-reply-input').val('');
                                    
                                                Swal.fire({
                                                    icon: 'success',
                                                    title: 'Đã thêm phản hồi',
                                                    showConfirmButton: false,
                                                    timer: 1500
                                                });
                                            }
                                        },
                                        error: function(xhr) {
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Có lỗi xảy ra',
                                                text: xhr.responseJSON?.message || 'Vui lòng thử lại sau'
                                            });
                                        }
                                    });
                                });
                            });
                        </script>       
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
                                    <img src="{{ $photo->url }}" loading="lazy" alt="Image 1"
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
                                        <i class="fas fa-star text-gray-700 text-xl hover:text-indigo-700"></i>
                                    </a>
                                    <a href="{{ route('showimage', ['id' => $photo->id]) }}"
                                        class="bg-white p-2 rounded-full shadow-md flex items-center justify-center w-10 h-10">
                                        <i class="fas fa-share text-gray-700 text-xl hover:text-indigo-700"></i>
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
