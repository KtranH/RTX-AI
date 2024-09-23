@extends('User.Container')
@section('Body')
    <title>RTX-AI: Hình Ảnh</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <main class="w-full h-full">
        <!-- Title -->
        <div class="flex items-center justify-center">
            <div class="w-full max-w-7xl px-4 py-4 sm:px-6 sm:py-6 lg:max-w-7xl lg:px-16 text-center">
                <div class="font-bold text-4xl">Khám Phá</div>
                <div class="text-gray-500 text-2xs">Thỏa Sức Sáng Tạo - Truyền Đầy Cảm Hứng</div>
            </div>
        </div>
        <!-- Search -->
        <style>
            ::-webkit-scrollbar {
                width: 12px;
            }

            ::-webkit-scrollbar-thumb {
                background-color: #3949AB;
                border-radius: 10px;
            }

            ::-webkit-scrollbar-track {
                background: #f1f1f1;
                border-radius: 10px;
            }
        </style>
        <div class="flex items-center justify-center sticky z-50 bg-white">
            <div class="w-full max-w-2xl px-4 py-4 sm:px-6 sm:py-6 lg:max-w-7xl lg:px-16 mt-2">
                <div class="relative w-full">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <i id="search-icon" class="fas fa-search text-gray-700"></i>
                    </span>
                    <div id="overlay" class="fixed inset-0 bg-black opacity-0 hidden z-40"></div>
                    <input id="search-bar" type="text" placeholder="Tìm kiếm..."
                        class="w-full bg-gray-100 focus:border-indigo-500 rounded-lg pl-10 pr-10 py-3 focus:outline-none focus:shadow-md transition duration-300 ease-in-out"
                        oninput="toggleCloseIcon()" onfocus="toggleOverlay(true)" onblur="toggleOverlay(false)"
                        onclick="toggleExtension(event)" style="border-radius: 30px;" />
                    <span id="close-icon"
                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 cursor-pointer hidden"
                        onclick="clearSearchBar()">
                        <i class="text-xl fas fa-times"></i>
                    </span>
                    <div id="search-extension"
                        class="absolute mt-2 w-full max-h-64 sm:max-h-48 lg:max-h-96 overflow-y-auto rounded-2xl bg-white shadow-lg p-4 hidden z-50"
                        style="box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px;" onclick="event.stopPropagation();">
                        <!-- Search History -->
                        <div id="search-history-title" class="text-lg font-semibold mb-2 hidden">Lịch Sử</div>
                        <div id="search-history" class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 gap-3 mb-4"></div>
                        <!-- Text-Only Categories -->
                        <div class="text-lg font-semibold mb-2">Thể Loại</div>
                        <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 gap-3 mb-4">
                            @foreach ($categories as $each)
                                <div
                                    class="text-sm text-white p-2 bg-indigo-600 hover:bg-indigo-400 text-center cursor-pointer truncate hover:overflow-visible hover:whitespace-normal" style="border-radius: 30px">
                                    <a class="font-semibold" href="/explore/?category={{ $each->id }}">
                                        {{ $each->name }}
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        <!-- More categories -->
                        <div class="text-center" style="cursor: pointer">
                            <a href="{{ route("morecategories") }}" class="text-2xs text-gray-500 font-semibold mb-2 hover:text-indigo-600 more_categories">
                                Xem thêm <i class="fa-solid fa-caret-down"></i>
                            </a>
                        </div>
                        <style>
                            .more_categories i {
                                transition: transform 0.3s ease;
                            }
                        
                            .more_categories:hover i {
                                transform: rotate(180deg);
                            }
                        </style>
                        <!-- Categories -->
                        <div class="text-lg font-semibold mb-2">Thể Loại</div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3 mb-4">
                            @for ($i = 0; $i <= 5; $i++)
                                <div
                                    class="flex items-center hover:bg-[#a00fff] bg-[#f5f5f5] rounded-2xl cursor-pointer border-2 border-[#f5f5f5] group">
                                    <img src="https://picsum.photos/200" alt="Category Image"
                                        class="w-24 h-24 object-cover rounded-2xl">
                                    <div class="ml-3 text-2xs text-black group-hover:!text-white leading-tight">Category
                                        Lorem Lorem Lorem {{ $i }}</div>
                                </div>
                            @endfor
                        </div>
                        <!-- Suggestions -->
                        <div class="text-lg font-semibold mb-2">Gợi Ý</div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3 mb-4">
                            @for ($i = 0; $i <= 5; $i++)
                                <div
                                    class="flex items-center hover:bg-[#a00fff] bg-[#f5f5f5] rounded-2xl cursor-pointer border-2 border-[#f5f5f5] group">
                                    <img src="https://picsum.photos/200" alt="Category Image"
                                        class="w-24 h-24 object-cover rounded-2xl">
                                    <div class="ml-3 text-2xs text-black group-hover:!text-white leading-tight">Suggestion
                                        {{ $i }}</div>
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            const MAX_HISTORY = 10;

            function toggleExtension(event) {
                event.stopPropagation();
                const extension = document.getElementById('search-extension');
                extension.classList.remove('hidden');
            }

            function toggleCloseIcon() {
                const searchBar = document.getElementById('search-bar');
                const closeIcon = document.getElementById('close-icon');

                if (searchBar.value.trim() !== "") {
                    closeIcon.classList.remove('hidden');
                } else {
                    closeIcon.classList.add('hidden');
                }
            }

            function checkCloseIcon() {
                const searchBar = document.getElementById('search-bar');
                const closeIcon = document.getElementById('close-icon');

                if (searchBar.value.trim() === "") {
                    closeIcon.classList.add('hidden');
                }
            }

            function clearSearchBar() {
                const searchBar = document.getElementById('search-bar');
                searchBar.value = "";
                checkCloseIcon();
                searchBar.focus();
            }

            function addSearchHistory(term) {
                let history = JSON.parse(localStorage.getItem('searchHistory')) || [];
                if (!history.includes(term)) {
                    history.unshift(term);
                    if (history.length > MAX_HISTORY) {
                        history.pop();
                    }
                    localStorage.setItem('searchHistory', JSON.stringify(history));
                    renderSearchHistory();
                }
            }

            function removeSearchHistory(index) {
                let history = JSON.parse(localStorage.getItem('searchHistory')) || [];
                history.splice(index, 1);
                localStorage.setItem('searchHistory', JSON.stringify(history));
                renderSearchHistory();
            }

            function renderSearchHistory() {
                const historyContainer = document.getElementById('search-history');
                const historyTitle = document.getElementById('search-history-title');
                historyContainer.innerHTML = '';
                let history = JSON.parse(localStorage.getItem('searchHistory')) || [];

                if (history.length > 0) {
                    historyTitle.classList.remove('hidden');
                    history.forEach((term, index) => {
                        const historyItem = document.createElement('div');
                        historyItem.className =
                            'flex items-center justify-between text-sm text-white p-2 hover:bg-[#a00fff] bg-gray-400 rounded-xl cursor-pointer truncate hover:overflow-visible hover:whitespace-normal';
                        historyItem.innerHTML = `
                            <div class="ml-2 truncate">${term}</div>
                            <i class="mr-2 text-xl fas fa-times text-white hover:!text-yellow-100 cursor-pointer" onclick="removeSearchHistory(${index}); event.stopPropagation();"></i>
                        `;
                        historyItem.onclick = () => {
                            document.getElementById('search-bar').value = term;
                            toggleCloseIcon();
                        };
                        historyContainer.appendChild(historyItem);
                    });
                } else {
                    historyTitle.classList.add('hidden');
                }
            }

            function handleSearch() {
                const searchBar = document.getElementById('search-bar');
                const term = searchBar.value.trim();
                if (term) {
                    addSearchHistory(term);
                }
            }

            document.addEventListener('click', function(event) {
                const searchBar = document.getElementById('search-bar');
                const extension = document.getElementById('search-extension');

                if (!searchBar.contains(event.target) && !extension.contains(event.target)) {
                    extension.classList.add('hidden');
                }
            });

            document.getElementById('search-extension').addEventListener('click', function(event) {
                event.stopPropagation();
            });

            renderSearchHistory();

            document.getElementById('search-bar').addEventListener('keyup', function(event) {
                if (event.key === 'Enter') {
                    handleSearch();
                }
            });
        </script>
        <!-- Library -->
        <div class="flex items-center justify-center">
            <div class="w-full max-w-2xl px-4 py-4 sm:px-6 sm:py-6 lg:max-w-7xl lg:px-16 mt-2">
                <div class="mt-2 grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-12 gap-2" id="main-content">
                </div>
            </div>
        </div>

    </main>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mainContent = document.getElementById('main-content');
            let currentPage = 1;
            let isLoading = false;
            let lastPage = false;

            // const urlParams = new URLSearchParams(window.location.search);
            // const category = urlParams.get('category');

            function loadPhotos(page) {
                if (isLoading || lastPage) return;

                isLoading = true;

                fetch(`{{ route('indexApi') }}?page=${page}`, {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.last_page == currentPage) {
                            lastPage = true;
                        }
                        renderPhotos(data.data);
                        currentPage++;
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
                <div class="col-span-12 sm:col-span-12 md:col-span-12 lg:col-span-3 row-span-1 relative group mt-2 mr-2">
                    <a href="/image/${photo.id}">
                        <div class="aspect-square">
                            <img src="${photo.url}" alt="Image 1" class="w-full h-full object-cover transition-opacity duration-300 group-hover:opacity-15" style="border-radius: 30px;">
                        </div>
                        <div class="absolute inset-0 flex flex-col justify-between opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <div class="mt-2 text-left px-2 py-1">
                                <div class="font-semibold text-lg truncate group-hover:text-[#000000]">${photo.title}</div>
                                <div class="text-sm text-gray-500 h-20 overflow-hidden truncate">${photo.description}</div>
                            </div>
                        </div>
                        <div class="flex space-x-3 account-mobile mt-4 mb-1">
                            <div class="flex justify-start">
                                <img class="inline-block h-8 w-8 rounded-full ring-2 ring-white avatar" src="${photo.avatar_user}" alt="">
                                <div>
                                    <a href="/board" class="nav-link link-dark nav_name font-semibold ml-2">${photo.name_user}</a>
                                </div>
                            </div>
                            <div class="flex-grow"></div>
                            <div style="cursor: none">
                                <span><i class="fas fa-heart text-red-500 text-xl hover:text-[#a000ff]"></i> <span class="font-bold">${photo.count_like}</span></span>
                            </div>
                        </div>
                    </a>
                </div>
            `;
                });
                mainContent.insertAdjacentHTML('beforeend', html);
            }

            loadPhotos(currentPage);

            function debounce(func, wait = 100) {
                let timeout;
                return function(...args) {
                    const later = () => {
                        clearTimeout(timeout);
                        func(...args);
                    };
                    clearTimeout(timeout);
                    timeout = setTimeout(later, wait);
                };
            }

            window.addEventListener('scroll', debounce(() => {
                if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight - 750) {
                    loadPhotos(currentPage);
                }
            }, 200));
        });
    </script>
@endsection
