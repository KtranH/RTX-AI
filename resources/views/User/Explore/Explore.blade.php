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
        <div class="flex items-center justify-center sticky z-50 bg-white">
            <div class="w-full max-w-2xl px-4 py-4 sm:px-6 sm:py-6 lg:max-w-7xl lg:px-16 mt-2">
                <div class="relative w-full">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <i id="search-icon" class="fas fa-search text-gray-500"></i>
                    </span>
                    <input id="search-bar" type="text" placeholder="Search..." class="w-full bg-gray-100 rounded-lg pl-10 pr-10 py-3 focus:outline-none" 
                        oninput="toggleCloseIcon()" onfocus="toggleCloseIcon()" onblur="checkCloseIcon()" onclick="toggleExtension(event)" style="border-radius: 30px;" />
                    <span id="close-icon" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 cursor-pointer hidden" onclick="clearSearchBar()">
                        <i class="text-xl fas fa-times"></i>
                    </span>
                    <div id="search-extension" class="absolute mt-2 w-full max-h-64 sm:max-h-48 lg:max-h-96 overflow-y-auto rounded-2xl bg-white shadow-lg p-4 hidden z-50" style="box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px;" onclick="event.stopPropagation();">
                        <!-- Search History -->
                        <div id="search-history-title" class="text-lg font-semibold mb-2 hidden">Lịch Sử</div>
                        <div id="search-history" class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 gap-3 mb-4"></div>
                        <!-- Text-Only Categories -->
                        <div class="text-lg font-semibold mb-2">Thể Loại</div>
                        <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 gap-3 mb-4">
                            @for ($i = 0; $i <= 10; $i++)
                                <div class="text-sm text-white p-2 bg-[#a00fff] hover:bg-gray-400 text-center rounded-xl cursor-pointer truncate hover:overflow-visible hover:whitespace-normal">Category {{ $i }}</div>
                            @endfor
                        </div>
                        <!-- Categories -->
                        <div class="text-lg font-semibold mb-2">Thể Loại</div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3 mb-4">
                            @for ($i = 0; $i <= 5; $i++)
                                <div class="flex items-center hover:bg-[#a00fff] bg-[#f5f5f5] rounded-2xl cursor-pointer border-2 border-[#f5f5f5] group">
                                    <img src="https://picsum.photos/200" alt="Category Image" class="w-24 h-24 object-cover rounded-2xl">
                                    <div class="ml-3 text-2xs text-black group-hover:!text-white leading-tight">Category Lorem Lorem Lorem {{ $i }}</div>
                                </div>
                            @endfor
                        </div>
                        <!-- Suggestions -->
                        <div class="text-lg font-semibold mb-2">Gợi Ý</div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3 mb-4">
                            @for ($i = 0; $i <= 5; $i++)
                                <div class="flex items-center hover:bg-[#a00fff] bg-[#f5f5f5] rounded-2xl cursor-pointer border-2 border-[#f5f5f5] group">
                                    <img src="https://picsum.photos/200" alt="Category Image" class="w-24 h-24 object-cover rounded-2xl">
                                    <div class="ml-3 text-2xs text-black group-hover:!text-white leading-tight">Suggestion {{ $i }}</div>
                                </div>
                            @endfor
                        </div>
                    </div>
                    <div id="overlay" class="fixed inset-0 bg-black opacity-0 hidden z-40"></div>
                </div>
            </div>
        </div>
        <script>
            const MAX_HISTORY = 10;

            function toggleExtension(event) 
            {
                event.stopPropagation();
                const extension = document.getElementById('search-extension');
                const overlay = document.getElementById('overlay');
                extension.classList.remove('hidden');
                overlay.classList.remove('hidden');
                overlay.classList.add('opacity-50');
            }

            function toggleCloseIcon()
            {
                const searchBar = document.getElementById('search-bar');
                const closeIcon = document.getElementById('close-icon');

                if (searchBar.value.trim() !== "") 
                {
                    closeIcon.classList.remove('hidden');
                } 
                else
                {
                    closeIcon.classList.add('hidden');
                }
            }

            function checkCloseIcon() 
            {
                const searchBar = document.getElementById('search-bar');
                const closeIcon = document.getElementById('close-icon');

                if (searchBar.value.trim() === "") 
                {
                    closeIcon.classList.add('hidden');
                }
            }

            function clearSearchBar() 
            {
                const searchBar = document.getElementById('search-bar');
                searchBar.value = "";
                checkCloseIcon();
                searchBar.focus();
            }

            function addSearchHistory(term) 
            {
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

            function removeSearchHistory(index) 
            {
                let history = JSON.parse(localStorage.getItem('searchHistory')) || [];
                history.splice(index, 1);
                localStorage.setItem('searchHistory', JSON.stringify(history));
                renderSearchHistory();
            }

            function renderSearchHistory() 
            {
                const historyContainer = document.getElementById('search-history');
                const historyTitle = document.getElementById('search-history-title');
                historyContainer.innerHTML = '';
                let history = JSON.parse(localStorage.getItem('searchHistory')) || [];

                if (history.length > 0) 
                {
                    historyTitle.classList.remove('hidden');
                    history.forEach((term, index) => 
                    {
                        const historyItem = document.createElement('div');
                        historyItem.className = 'flex items-center justify-between text-sm text-white p-2 hover:bg-[#a00fff] bg-gray-400 rounded-xl cursor-pointer truncate hover:overflow-visible hover:whitespace-normal';
                        historyItem.innerHTML = `
                            <div class="ml-2 truncate">${term}</div>
                            <i class="mr-2 text-xl fas fa-times text-white hover:!text-yellow-100 cursor-pointer" onclick="removeSearchHistory(${index}); event.stopPropagation();"></i>
                        `;
                        historyItem.onclick = () => 
                        {
                            document.getElementById('search-bar').value = term;
                            toggleCloseIcon();
                        };
                        historyContainer.appendChild(historyItem);
                    });
                } 
                else 
                {
                    historyTitle.classList.add('hidden');
                }
            }

            function handleSearch() 
            {
                const searchBar = document.getElementById('search-bar');
                const term = searchBar.value.trim();
                if (term) 
                {
                    addSearchHistory(term);
                }
            }

            document.addEventListener('click', function(event) 
            {
                const searchBar = document.getElementById('search-bar');
                const extension = document.getElementById('search-extension');
                const overlay = document.getElementById('overlay');

                if (!searchBar.contains(event.target) && !extension.contains(event.target)) {
                    extension.classList.add('hidden');
                    overlay.classList.add('hidden');
                }
            });

            document.getElementById('search-extension').addEventListener('click', function(event)
            {
                event.stopPropagation();
            });

            renderSearchHistory();

            document.getElementById('search-bar').addEventListener('keyup', function(event) 
            {
                if (event.key === 'Enter') 
                {
                    handleSearch();
                }
            });
        </script>
        <!-- Library -->
        <div class="flex items-center justify-center">
            <div class="w-full max-w-2xl px-4 py-4 sm:px-6 sm:py-6 lg:max-w-7xl lg:px-16 mt-2">
                <div class="mt-2 grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-12 gap-2">
                    @for ($i = 0; $i <= 30; $i++)
                        <div class="col-span-12 sm:col-span-12 md:col-span-12 lg:col-span-3 row-span-1 relative group mt-2 mr-2">
                            <a href="">
                                <div class="aspect-square">
                                    <img src="https://picsum.photos/200" alt="Image 1" class="w-full h-full object-cover transition-opacity duration-300 group-hover:opacity-15" style="border-radius: 30px;">
                                </div>
                                <div class="absolute inset-0 flex flex-col justify-between opacity-0 group-hover:opacity-100 group-hover:!opacity-100 transition-opacity duration-300">
                                    <div class="mt-2 text-left px-2 py-1">
                                        <div class="font-semibold text-lg truncate group-hover:text-[#000000]">Image {{ $i }}</div>
                                        <div class="text-sm text-gray-500 h-20 overflow-hidden truncate">Description {{ $i }}</div>
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