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
        <div class="flex flex-col items-center">
            <div class="w-full max-w-2xl px-4 py-4 sm:px-6 sm:py-6 lg:max-w-7xl lg:px-16 rounded-2xl p-5 shadow-md">
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
                        <!-- Title and Description -->
                        <div class="mb-2">
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
                        <div class="flex items-center space-x-4 mb-4">
                            <a href="#" class="flex items-center space-x-2 group">
                                <img src="{{ $image->album->user->avatar_url }}" loading="lazy" alt="Owner Avatar" class="w-10 h-10 rounded-full">
                                <p class="font-semibold group-hover:!text-indigo-700">{{ $image->album->user->username }}</p>
                            </a>
                            @if ($image->album->user->id != Auth::user()->id)
                                <a href="#"
                                    class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:!bg-gray-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 flex items-center justify-center">Theo dõi
                                </a>
                            @endif
                            <div class="flex-grow"></div>
                        <!-- Action -->
                        <div class="flex justify-center space-x-4 mb-2 mt-2">
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
                            @if($image->album->user->id == Auth::user()->id)
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
                                <a href="#" class="bg-white p-2 rounded-full shadow-md flex items-center justify-center w-10 h-10">
                                    <i class="fas fa-share text-gray-700 text-xl hover:text-indigo-700"></i>
                                </a>
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
                                        @if($l->user->username != $checkUserNow->username)
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
                    @if($countComment == 0)
                        <p id="noCommentsMessage">Chưa có bình luận nào!</p>
                    @endif
                        <div id="comment" class="flex flex-col mt-auto">
                            <div class="space-y-4 mb-4 max-h-64">
                                <div class="space-y-6">
                                    <div id="commentList" class="space-y-4 overflow-y-auto overflow-x-hidden mb-4 max-h-64 p-4 hover-scrollbar">

                                    </div>
                                </div>
                            </div>
                            <!-- Add Comment -->
                            <div class="flex items-center space-x-4">
                                <form id="commentForm" class="flex w-full" enctype="multipart/form-data" method="POST" action="{{ route('addcomment', $image->id) }}">
                                    @csrf
                                    <input type="text" id="addComment" name="comment" class="flex-grow px-4 py-2 text-gray-700 bg-gray-100 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Thêm bình luận">
                                    <button type="submit" class="ml-4 p-2 text-white bg-blue-500 rounded-full hover:bg-blue-600 focus:ring-2 focus:ring-blue-300">
                                        <i class="fas fa-paper-plane"></i>
                                    </button>
                                </form>
                            </div>
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
                                                    <div class="comment-item space-y-2 relative">
                                                        <div class="flex items-start space-x-4">
                                                            <img src="${comment.user.avatar_url}" alt="Avatar" class="w-10 h-10 rounded-full">
                                                            <div class="flex-grow">
                                                                <div class="bg-gray-100 p-2 rounded-lg w-full">
                                                                     <div class="font-semibold truncate hover:overflow-visible hover:whitespace-normal">${comment.user.username}</div>
                                                                     <div class="text-sm text-gray-700 truncate hover:overflow-visible hover:whitespace-normal">${comment.content}</div>
                                                                </div>
                                                                <div class="flex items-center space-x-4 text-sm text-gray-500">
                                                                    <p class="font-semibold hover:text-indigo-700 hover:font-semibold">${comment.time_ago}</p>
                                                                    <button class="reply-button font-bold hover:text-indigo-700 hover:font-bold">Phản hồi</button>
                                                                    ${(comment.user_id == '{{ Auth::user()->id }}') ?
                                                                        `<button class="hover:text-indigo-700 font-bold hover:font-semibold update-button" data-comment-id="${comment.id}">Chỉnh sửa</button>
                                                                         <button class="hover:text-indigo-700 font-bold hover:font-semibold delete-button" data-comment-id="${comment.id}">Xóa</button>`
                                                                        : ''}
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
                            $('#commentForm').on('submit', function(e) {
                                e.preventDefault();
                                
                                var comment = $('#addComment').val();
                                var idImage = '{{ $image->id }}';
                                
                                if (!comment) {
                                    alert('Vui lòng nhập bình luận');
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
                                            var newCommentHtml = `
                                                    <div class="comment-item space-y-2 relative">
                                                        <div class="flex items-start space-x-4">
                                                            <img src="${response.comment.user_avatar}" alt="Avatar" class="w-10 h-10 rounded-full">
                                                            <div class="flex-grow">
                                                                <div class="bg-gray-100 p-2 rounded-lg w-full">
                                                                    <div class="font-semibold truncate hover:overflow-visible hover:whitespace-normal">${response.comment.user_name}</div>
                                                                    <div class="text-sm text-gray-700 truncate hover:overflow-visible hover:whitespace-normal">${response.comment.content}</div>
                                                                </div>
                                                                <div class="flex items-center space-x-4 text-sm text-gray-500">
                                                                <p class="font-semibold hover:text-indigo-700 hover:font-semibold">${response.comment.created_at}</p>
                                                                    <button class="reply-button font-bold hover:text-indigo-700 hover:font-bold">Phản hồi</button>
                                                                    ${(response.comment.user_id == '{{ Auth::user()->id }}') ?
                                                                    `<button class="hover:text-indigo-700 font-bold hover:font-semibold">Chỉnh sửa</button>
                                                                    <button class="hover:text-indigo-700 font-bold hover:font-semibold">Xóa</button>`
                                                                    : ''}
                                                                </div>
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
                                            alert('Đã xảy ra lỗi, vui lòng thử lại');
                                        }
                                    },
                                    error: function(xhr) {
                                        if (xhr.status === 422) {
                                            var errors = xhr.responseJSON.errors;
                                            alert(errors.comment[0]); 
                                        }
                                    }
                                });
                            });
                        });
                    </script>                     
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
    <script>
        //Comment's Script
        document.addEventListener('DOMContentLoaded', () => 
        {

            // -- Comment Section
            const comment = document.getElementById('comment');
            const commentList = document.getElementById('commentList');
            const addComment = document.getElementById('addComment');
            let isExpanded = false;

            const expandedClasses = ['absolute', 'top-0', 'w-full', 'h-full', 'bg-white', 'z-40', 'transition-all', 'duration-0'];

            // Expand Comment
            /*function expandComment() 
            {
                if (!isExpanded) {
                    comment.classList.add(...expandedClasses);
                    commentList.classList.remove('max-h-40');
                    isExpanded = true;
                }
            }*/

            // Collapse Comment and Hide all replies
            function collapseComment() 
            {
                if (isExpanded) 
                {
                    comment.classList.remove(...expandedClasses);
                    commentList.classList.add('max-h-40');
                    isExpanded = false;

                    const replyContainers = document.querySelectorAll('.reply-container');
                    replyContainers.forEach(replyContainer => {
                        replyContainer.classList.add('hidden');
                        replyContainer.innerHTML = '';
                    });
                }
            }

            // Handle scroll event to expand/collapse
            commentList.addEventListener('scroll', () => 
            {
                const scrollThreshold = 1;
                if (commentList.scrollTop > scrollThreshold && !isExpanded) {
                    expandComment();
                } else if (commentList.scrollTop <= scrollThreshold && isExpanded) {
                    collapseComment();
                }
            });

            // Expand when addComment is focused
            addComment.addEventListener('focus', () => 
            {
                expandComment();
            });

            // Collapse when clicking outside of the comment area
            document.addEventListener('click', (e) => 
            {
                if (!comment.contains(e.target) && isExpanded) {
                    collapseComment();
                    commentList.scrollTop = 0;
                }
            });

            // Close expanded view on Escape key
            document.addEventListener('keydown', (e) => 
            {
                if (e.key === 'Escape' && isExpanded) 
                {
                    collapseComment();
                    commentList.scrollTop = 0;
                }
            });

            // -- Reply Section
            const replyButtons = document.querySelectorAll('.reply-button');

            replyButtons.forEach(button => 
            {
                button.addEventListener('click', (event) => 
                {
                    // Expand the commentList
                    expandComment();

                    const commentItem = event.target.closest('.comment-item');
                    const replyContainer = commentItem.querySelector('.reply-container');

                    if (replyContainer.classList.contains('hidden')) 
                    {
                        replyContainer.classList.remove('hidden');

                        // Reply
                        const childComment = `@include('User.Component.Comment')`;

                        // Add Replies
                        for (let i = 0; i < 2; i++) 
                        {
                            const replyCommentDiv = document.createElement('div');
                            replyCommentDiv.innerHTML = childComment;
                            replyContainer.appendChild(replyCommentDiv);
                        }

                        // Add Reply Input
                        const replyInput = document.createElement('input');
                        replyInput.setAttribute('type', 'text');
                        replyInput.setAttribute('placeholder', 'Trả lời bình luận');
                        replyInput.classList.add('w-full', 'px-4', 'py-2', 'bg-gray-200', 'placeholder:text-gray-700', 'shadow-sm', 'resize-none', 'rounded-2xl');

                        replyContainer.appendChild(replyInput);

                        // Automatic add handler
                        replyInput.value = '@commentUserHanlder';

                        // Click on Reply's Reply Button
                        const replyChildButtons = replyContainer.querySelectorAll('.reply-button');
                        replyChildButtons.forEach(replyButton => {
                            replyButton.addEventListener('click', (replyEvent) =>
                            {
                                // Automatic add handler
                                replyInput.value = '@replyUserHandler';
                            });
                        });
                    } 
                    else 
                    {
                        // Hide reply if shown
                        replyContainer.classList.add('hidden');
                        replyContainer.innerHTML = '';
                    }
                });
            });
        });
    </script>
@endsection
