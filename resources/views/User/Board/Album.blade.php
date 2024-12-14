@extends('User.Container')
@section('Body')
    <title>RTX-AI: Album</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <main class="w-full h-full">
        <!-- Album -->
        <div class="flex items-center justify-center">
            <div class="absolute inset-x-0 -top-5 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-5" aria-hidden="true">
                <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]"
                    style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)">
                </div>
            </div>
            <div class="w-full max-w-2xl px-4 py-4 sm:px-6 sm:py-6 lg:max-w-7xl lg:px-16">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-center lg:space-x-6">
                    <!-- Cover -->
                    <div class="relative text-center lg:text-left w-full lg:w-80 mb-4 lg:mb-0">
                        <img class="w-full h-full object-cover rounded-2xl border-8 border-[]"
                            src="{{ $album->cover_image }}" loading="lazy" alt="Album Cover">
                        @if (Auth::user()->id == $album->user->id)
                            <div
                                class="absolute inset-0 flex opacity-0 hover:opacity-100 hover:!opacity-100 transition-opacity duration-300">
                                <a href="{{ route('editalbum', ['id' => $album->id]) }}"
                                    class="bg-white p-2 shadow-md w-full h-full border-8 border-[#a000ff] flex items-center justify-center rounded-2xl">
                                    <i class="fas fa-edit text-gray-700 text-5xl"></i>
                                </a>
                            </div>
                        @endif
                    </div>
                    <!-- Information -->
                    <div class="flex flex-col w-full max-w-full lg:max-w-72">
                        <div class="font-bold text-3xl flex items-center">
                            <div class="truncate hover:overflow-visible hover:whitespace-normal">{{ $album->title }}</div>
                            <span class="text-[#a000ff] text-xl ml-3" style="color: #B197FC;">{{ $countPhoto }}</span>
                            <i class="fa-regular fa-images text-[#a000ff] text-xl ml-3" style="color: #B197FC;"></i>
                        </div>
                        <div
                            class="font-semibold text-xl text-gray-500 truncate hover:overflow-visible hover:whitespace-normal">
                            {{ $album->description }}</div>
                        <a href="{{ route('showboard', ['id' => $album->user->id]) }}" class="font-semibold text-xl text-gray-500 flex mt-4 cursor-pointer group">
                            <img class="h-8 w-8 rounded-full ring-2 ring-white mr-2" src="{{ $user->avatar_url }}"
                                alt="">
                            <p
                                class="group-hover:text-[#a000ff] font-semibold truncate hover:overflow-visible hover:whitespace-normal">
                                {{ $user->username }}</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Return -->
        <div class="flex justify-center">
            <a href="{{ route('showboard', ['id' => $album->user->id]) }}"
                class="text-center w-48 h-14 relative font-sans text-black text-xl font-semibold group">
                <div
                    class="bg-black h-12 w-1/4 flex items-center justify-center absolute left-1 top-[4px] group-hover:!bg-[#a000ff] group-hover:w-[184px] z-10 duration-500 rounded-2xl">
                    <svg width="25px" height="25px" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg">
                        <path fill="#ffffff" d="M224 480h640a32 32 0 1 1 0 64H224a32 32 0 0 1 0-64z"></path>
                        <path fill="#ffffff"
                            d="m237.248 512 265.408 265.344a32 32 0 0 1-45.312 45.312l-288-288a32 32 0 0 1 0-45.312l288-288a32 32 0 1 1 45.312 45.312L237.248 512z">
                        </path>
                    </svg>
                </div>
                <p class="translate-x-2" style="margin-top:12px">Quay lại</p>
            </a>
        </div>
        @if (Auth::user()->id == $album->user->id)
        <!-- Suggestion -->
         <div class="flex items-center justify-center">
            <div class="w-full max-w-2xl px-4 py-4 sm:px-6 sm:py-6 lg:max-w-7xl lg:px-16 mt-2">
                <div class="font-bold text-3xl text-left">Thêm Ảnh</div>
                <div class="mt-2 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <div class="relative group">
                        <a href="{{ route('createimage', ['id' => $album->id]) }}" class="block aspect-square bg-gray-200 flex items-center justify-center group-hover:bg-[#a000ff] transition-colors duration-300 rounded-2xl">
                            <i class="fas fa-plus text-8xl text-gray-600 group-hover:text-white transition-colors duration-300"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endif
        <!-- Gallery -->
        <div class="flex items-center justify-center">
            <div class="w-full max-w-2xl px-4 py-4 sm:px-6 sm:py-6 lg:max-w-7xl lg:px-16 mt-2">
                <div class="font-bold text-3xl">Thư Viện</div>
                <div class="mt-2 columns-1 sm:columns-2 md:columns-3 lg:columns-4 space-y-4" id="main-content">
                </div>
            </div>
        </div>
    </main>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const mainContent = document.getElementById('main-content');
            let currentPage = 1;
            let isLoading = false;
            let lastPage = false;
    
            // Implementing debounce function if not defined
            function debounce(func, wait) {
                let timeout;
                return function() {
                    const context = this;
                    const args = arguments;
                    clearTimeout(timeout);
                    timeout = setTimeout(() => func.apply(context, args), wait);
                };
            }
    
            function loadPhotos(page) {
                if (isLoading || lastPage) return;
    
                isLoading = true;
    
                const apiUrl = "{{ url('/') }}/api/album/{{ request()->id }}?page=" + page;
    
                fetch(apiUrl, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        renderPhotos(data.photos);
                        currentPage = data.current_page;
                        lastPage = currentPage >= data.last_page;
                        isLoading = false;
                    })
                    .catch(error => {
                        console.error("Error loading photos:", error);
                        isLoading = false;
                    });
            }
    
            function renderPhotos(photos) {
                let html = '';
                photos.forEach(photo => {
                    html += `
                        <div class="relative group">
                            <a href="/image/${photo.id}">
                                <img src="${photo.url}" loading="lazy" alt="Image" class="w-full h-full rounded-2xl object-cover transition-opacity duration-300 group-hover:opacity-15">
                                <div class="absolute inset-0 flex flex-col justify-between opacity-0 group-hover:opacity-100 group-hover:!opacity-100 transition-opacity duration-300">
                                    <div class="mt-2 text-left px-2 py-1">
                                        <div class="font-semibold text-lg truncate group-hover:text-[#000000]">${photo.title}</div>
                                        <div class="text-sm text-gray-500 h-20 overflow-hidden">${photo.description}</div>
                                    </div>
                                </div>
                            </a>
                            ${photo.album.user.id != "{{ Auth::user()->id }}" ? '' : `
                                <div class="absolute inset-x-0 bottom-0 flex justify-center p-2 opacity-0 group-hover:opacity-100 group-hover:!opacity-100 transition-opacity duration-300">
                                    <div class="flex space-x-2">
                                        ${photo.is_feature ? `
                                            <a href="" class="bg-white p-2 rounded-full shadow-md flex items-center justify-center w-10 h-10 feature-image" data-photo-id="${photo.id}">
                                                <i class="fas fa-star text-yellow-500 text-xl hover:text-[#a000ff]"></i>
                                            </a>
                                        ` : `
                                            <a href="" class="bg-white p-2 rounded-full shadow-md flex items-center justify-center w-10 h-10 feature-image" data-photo-id="${photo.id}">
                                                <i class="fas fa-star text-gray-700 text-xl hover:text-[#a000ff]"></i>
                                            </a>
                                        `}
                                        <a href="/edit_image/${photo.id}" class="bg-white p-2 rounded-full shadow-md flex items-center justify-center w-10 h-10">
                                            <i class="fas fa-edit text-gray-700 text-xl hover:text-[#a000ff]"></i>
                                        </a>
                                        <a href="#" class="bg-white p-2 rounded-full shadow-md flex items-center justify-center w-10 h-10">
                                            <i class="fas fa-sort text-gray-700 text-xl hover:text-[#a000ff]"></i>
                                        </a>
                                    </div>
                                </div>`
                            }
                        </div>
                    `;
                });
                mainContent.insertAdjacentHTML('beforeend', html);
            }
    
            loadPhotos(currentPage);
    
            window.addEventListener('scroll', debounce(() => {
                if (!lastPage) {
                    if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight - 850) {
                        loadPhotos(currentPage + 1);
                    }
                }
            }, 200));

            document.addEventListener('click', function (event) {
                const target = event.target.closest('.feature-image');
                if (target) {
                    event.preventDefault();
                    const photoId = target.getAttribute('data-photo-id');
                    if (!photoId) {
                        console.error("Photo ID không hợp lệ");
                        return;
                    }

                    const apiUrl = "/featureimage";

                    fetch(apiUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}' 
                        },
                        body: JSON.stringify({ photo_id: photoId })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                iconColor: 'white',
                                title: 'Đã cập nhật ảnh nổi bật',
                                color: 'white',
                                showConfirmButton: false,
                                timer: 3000,
                                toast: true,
                                position: 'bottom-left',
                                background: '#46DFB1'
                            });
                        } 
                        else {
                            Swal.fire({
                                icon: 'error',
                                iconColor: 'white',
                                title: 'Có lỗi xảy ra',
                                text: 'Không thể cập nhật ảnh nổi bật',
                                color: 'white',
                                showConfirmButton: false,
                                timer: 3000,
                                toast: true,
                                position: 'bottom-left',
                                background: '#F04770'
                            });
                        }
                        if (data.is_feature) {
                            target.querySelector('i').classList.remove('text-gray-700');
                            target.querySelector('i').classList.add('text-yellow-500');
                        }
                        if (!data.is_feature) {
                            target.querySelector('i').classList.remove('text-yellow-500');
                            target.querySelector('i').classList.add('text-gray-700');
                        } 
                    })
                    .catch(error => {
                        console.error("Error updating feature:", error);
                        Swal.fire({
                            icon: 'error',
                            iconColor: 'white',
                            title: 'Lỗi kết nối',
                            text: 'Không thể gửi yêu cầu đến server',
                            color: 'white',
                            showConfirmButton: false,
                            timer: 3000,
                            toast: true,
                            position: 'bottom-left',
                            background: 'red'
                        });
                    });
                }
            });
        });
    </script>
@endsection
