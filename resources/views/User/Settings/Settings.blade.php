@extends('User.Container')
@section('Body')
    <title>RTX-AI: Cài Đặt</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/datepicker.min.js"></script>

    <main class="w-full h-full">
        <div class="flex items-center justify-center">
            <div class="w-full max-w-7xl px-4 py-4 sm:px-6 sm:py-6 lg:max-w-7xl lg:px-16">
                <!-- Title -->
                <div class="text-center">
                    <div class="font-bold text-4xl mb-2">Cài Đặt</div>
                    <div class="text-gray-500 text-2xs">Chỉnh Sửa Feed của Bạn</div>
                </div>
                <!-- Tabs -->
                <div class="flex items-center justify-center mt-4">
                    <div class="w-full max-w-2xl px-4 py-4 sm:px-6 sm:py-6 lg:max-w-7xl lg:px-16 relative">
                        <!-- Laptop -->
                        <div class="hidden sm:flex justify-center space-x-4 mt-2">
                            <button id="activity" onclick="ActivateTab('activity')"
                                class="text-xl px-4 py-2 text-gray-600 hover:text-black focus:outline-none relative">
                                Hoạt Động
                            </button>
                            <button id="interests" onclick="ActivateTab('interests')"
                                class="text-xl px-4 py-2 text-gray-600 hover:text-black focus:outline-none relative">
                                Sở Thích
                            </button>
                            <button id="board" onclick="ActivateTab('board')"
                                class="text-xl px-4 py-2 text-gray-600 hover:text-black focus:outline-none relative">
                                Bảng
                            </button>
                            <button id="following" onclick="ActivateTab('following')"
                                class="text-xl px-4 py-2 text-gray-600 hover:text-black focus:outline-none relative">
                                Theo Dõi
                            </button>
                        </div>
                        <!-- Mobile -->
                        <div class="sm:hidden mt-2">
                            <select id="mobile-tab-select" onchange="ActivateTab(this.value)"
                                class="block w-full px-4 py-2 text-gray-600 bg-white border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-300 focus:border-indigo-300">
                                <option value="activity">Hoạt Động</option>
                                <option value="interests">Sở Thích</option>
                                <option value="board">Bảng</option>
                                <option value="following">Theo Dõi</option>
                            </select>
                        </div>
                    </div>
                </div>
                <!-- Activity -->
                <div id="activity-content" class="tab-content">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0 my-4">
                        <div>
                            <div class="font-bold text-2xl mb-2">Ảnh Bạn Đã Thích</div>
                            <div class="text-gray-500 text-xs">Ảnh bạn đã thích trong những ngày gần đây</div>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 js-liked">
                    </div>
                </div>
                <!-- Interests -->
                <div id="interests-content" class="tab-content hidden">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0 my-4">
                        <div>
                            <div class="font-bold text-2xl mb-2">Sở Thích Của Bạn</div>
                            <div class="text-gray-500 text-xs">Cài đặt những sở thích phù hợp cho chúng tôi gợi ý nội dung
                                cho bạn</div>
                        </div>
                    </div>
                    <div x-data="preferencesHandler({{ $selectedCategories }}, {{ $availableCategories }})" class="w-full mx-auto mt-10 p-6 bg-gray-100 rounded-lg shadow-md">
                        <p class="text-sm text-gray-600 mb-4">Chọn các sở thích phù hợp để chúng tôi gợi ý nội dung cho bạn.
                        </p>
                        <!-- Preferences selected -->
                        <div class="flex flex-wrap gap-2 mb-4">
                            <template x-for="(category, index) in selectedCategories" :key="category.id">
                                <div
                                    class="flex items-center bg-indigo-500 text-white px-4 py-2 rounded-full shadow-md hover:shadow-lg transition-shadow">
                                    <span x-text="category.name"></span>
                                    <button @click="removeCategory(index)"
                                        class="ml-3 text-white text-xl font-bold leading-none hover:text-red-300 transition-colors"
                                        id="remove-category">&times;</button>
                                </div>
                            </template>
                        </div>
                        <!-- List of available categories -->
                        <div class="relative">
                            <select x-model="selected" @change="addCategory()"
                                class="form-control w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                                <option value="" disabled selected hidden>Chọn sở thích...</option>
                                <template x-for="category in availableCategories" :key="category.id">
                                    <option :value="category.id" x-text="category.name"></option>
                                </template>
                            </select>
                            <div x-show="!availableCategories.length"
                                class="absolute inset-x-0 bottom-0 mt-2 text-sm text-gray-500">Tất cả sở thích đã được chọn.
                            </div>
                        </div>
                        <!-- Save -->
                        <button @click="savePreferences"
                            class="mt-6 px-6 py-3 bg-indigo-500 text-white font-bold rounded-lg shadow-md hover:bg-indigo-600 hover:shadow-lg transition-all">
                            Lưu
                        </button>
                    </div>
                    <script>
                        function preferencesHandler(selectedCategories, availableCategories) {
                            return {
                                availableCategories: availableCategories,
                                selectedCategories: selectedCategories,
                                selected: null,
                                showToast: false,
                                toastMessage: '',

                                addCategory() {
                                    if (!this.selected) return;
                                    const category = this.availableCategories.find(cat => cat.id == this.selected);
                                    if (category) {
                                        this.selectedCategories.push(category);
                                        this.availableCategories = this.availableCategories.filter(cat => cat.id != this.selected);
                                        this.selected = null;
                                    }
                                },

                                removeCategory(index) {
                                    const category = this.selectedCategories[index];
                                    if (category) {
                                        this.selectedCategories.splice(index, 1);
                                        this.availableCategories.push(category);
                                    }
                                },

                                savePreferences() {
                                    const selectedIds = this.selectedCategories.map(category => category.id);
                                    fetch('{{ route('updatepreferences') }}', {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                            },
                                            body: JSON.stringify({
                                                categories: selectedIds
                                            })
                                        })
                                        .then(response => response.json())
                                        .then(() => {
                                            Swal.fire({
                                                icon: 'success',
                                                iconColor: 'white',
                                                title: 'Đã cập nhật sở thích!',
                                                color: 'white',
                                                showConfirmButton: false,
                                                timer: 3000,
                                                toast: true,
                                                position: 'bottom-left',
                                                background: '#46DFB1'
                                            })
                                        })
                                        .catch(error => {
                                            console.error('Error:', error);
                                        });
                                }
                            };
                        }
                    </script>
                </div>
                <!-- Board -->
                <div id="board-content" class="tab-content hidden">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0 my-4">
                        <div>
                            <div class="font-bold text-2xl mb-2">Bảng của Bạn</div>
                            <div class="text-gray-500 text-xs">Tùy chỉnh những album được hiển thị</div>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 gap-2 js-album">

                    </div>
                </div>
                <!-- Following -->
                <div id="following-content" class="tab-content hidden">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0 my-4">
                        <div>
                            <div class="font-bold text-2xl mb-2">Người Bạn Theo Dõi</div>
                            <div class="text-gray-500 text-xs">Tùy chỉnh người mà bạn theo dõi</div>
                        </div>
                    </div>
                    <div class="js-following grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4" style="margin-top: -35px">
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="{{ asset('assets/js/helper.js') }}"></script>
    <script>
        function ChangeApperance(id) {
            const tabs = ['activity', 'interests', 'board', 'following'];

            tabs.forEach(tabId => {
                const tab = document.getElementById(tabId);
                tab.classList.remove('font-bold', 'text-black', 'border-b-4', 'border-black');
            });

            const active_tab = document.getElementById(id);
            active_tab.classList.add('font-bold', 'text-black', 'border-b-4', 'border-black');
        }

        function ActivateTab(id) {
            ChangeApperance(id);
            console.log(id);
            const contents = ['activity-content', 'interests-content', 'board-content', 'following-content'];

            contents.forEach(contentId => {
                const content = document.getElementById(contentId);
                if (contentId === `${id}-content`) {
                    content.classList.remove('hidden');
                } else {
                    content.classList.add('hidden');
                }
                console.log(content)
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            const current_path = window.location.pathname;
            let savedTab = localStorage.getItem('activeTab');

            if (current_path.endsWith('/activity') || savedTab === 'activity') {
                ActivateTab('activity');
            } else if (current_path.endsWith('/board') || savedTab === 'board') {
                ActivateTab('board');
            } else if (current_path.endsWith('/interests') || savedTab === 'interests') {
                ActivateTab('interests');
            } else if (current_path.endsWith('/following') || savedTab === 'following') {
                ActivateTab('following');
            } else {
                ActivateTab('activity');
            }
        });

        var page = 1;
        var maxLastPage = -1;

        const htmlLiked = (item) => {
            const url = '{{ route('showimage', ['id' => '__id__']) }}'.replace('__id__', item.photo_id);
            return `
           <div class="relative group">
                <div>
                    <a href="${url}">
                        <div class="aspect-square">
                            <img src="${item.photo.url}" loading="lazy" alt="Image" class="w-full h-full rounded-2xl object-cover transition-opacity duration-300 group-hover:opacity-15">
                        </div>
                    </a>
                </div>
                <div class="w-full flex flex-col items-center liked">
                    <button class="mt-2 rounded-md bg-red-500 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 unlike-btn" data-id="${item.photo_id}">
                        <i class="fa-solid fa-heart-crack"></i> Bỏ thích
                    </button>
                </div>
            </div>
            `;
        }
        const htmlAlbum = (item) => {
            const url = '{{ route('showalbum', ['id' => '__id__']) }}'.replace('__id__', item.id);
            return `
                <div class="flex flex-row items-center justify-between space-y-2 mb-2">
                    <div class="flex flex-row items-center space-x-4">
                        <a href="${url}" class="flex flex-row items-center space-x-4 group">
                            <div class="aspect-square w-16 h-16">
                                <img src="${item.cover_image}" alt="Image" class="w-16 h-16 object-cover rounded-lg" loading="lazy">
                            </div>
                            <div class="">
                                <div class="font-semibold text-lg truncate group-hover:text-black">${item.title}</div>
                                <div class="text-sm text-gray-500 overflow-hidden truncate max-w-44">${item.description}</div>
                            </div>
                        </a>
                    </div>
                    <label class="inline-flex items-center cursor-pointer">
                           <input type="checkbox" value="" class="sr-only peer toggle-album" data-id="${item.id}" 
                            ${item.is_private !== 1 ? 'checked' : ''}>
                            <div
                                class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 dark:peer-focus:ring-indigo-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all dark:border-gray-600 peer-checked:bg-indigo-600">
                            </div>
                    </label>
                </div>`;
        }

        const htmlFollowing = (item) => {
            const url = '{{ route('showboard', ['id' => '__id__']) }}'.replace('__id__', item.id);
            return `
                <div class="relative group">
                    <div class="aspect-square flex flex-row items-center space-x-1 relative">
                        <img src="https://static.vecteezy.com/system/resources/thumbnails/008/606/557/small_2x/dynamic-liquid-abstract-background-with-modern-ultra-violet-colors-vector.jpg" loading="lazy" alt="Image" class="w-1/2 h-3/4 rounded-l-2xl object-cover transition-opacity duration-300 group-hover:opacity-15">
                        <img src="https://static.vecteezy.com/system/resources/thumbnails/008/606/557/small_2x/dynamic-liquid-abstract-background-with-modern-ultra-violet-colors-vector.jpg" loading="lazy" alt="Image" class="w-1/2 h-3/4 rounded-l-2xl object-cover transition-opacity duration-300 group-hover:opacity-15 transform rotate-360 scale-x-[-1]">
                    </div>
                    <a href="${url}" class="w-full flex flex-col items-center">
                        <div class="absolute left-1/2 top-64 sm:top-52 transform -translate-x-1/2 z-10 mb-4">
                            <div class="w-20 h-20 bg-gray-300 rounded-full border-4 border-white overflow-hidden">
                                <img src="${item.avatar_url}" alt="Profile"
                                    class="w-full h-full object-cover" loading="lazy">
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="font-semibold text-lg truncate group-hover:text-black">${item.username}</div>
                            <div class="text-sm text-gray-500 overflow-hidden truncate">${item.email}</div>
                        </div>
                    </a>
                    <div class="w-full flex flex-col items-center">
                        <button class="cancel-follow-btn bg-gradient-to-r mt-2 from-purple-500 to-pink-500 text-xs text-white font-bold px-4 py-2 rounded-full transition-colors duration-300 hover:from-purple-600 hover:to-pink-600" data-id="${item.id}">
                            Bỏ theo dõi
                        </button>
                    </div>
                </div>
            `;
        }

        function loadData(url, container, htmlBuilder) {
            fetch(url, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then((data) => {
                    if (data.success) {
                        if (data.data.data.length === 0) {
                            return;
                        }
                        maxLastPage = data.data.last_page > maxLastPage ? data.data.last_page : maxLastPage;
                        data.data.data.forEach(item => {
                            container.insertAdjacentHTML('beforeend', htmlBuilder(item));
                        });
                    }
                })
        }

        document.addEventListener('DOMContentLoaded', function() {
            const eLiked = document.querySelector('.js-liked');
            const eAlbum = document.querySelector('.js-album');
            const eFollowing = document.querySelector('.js-following');

            loadData(`{{ route('apiDataLiked') }}?page=${page}`, eLiked, htmlLiked);
            loadData(`{{ route('apiDataAlbum') }}?page=${page}`, eAlbum, htmlAlbum);
            loadData(`{{ route('apiDataFollow') }}?page=${page}`, eFollowing, htmlFollowing);
            page++;
            window.addEventListener('scroll', debounce(() => {
                if ((window.innerHeight + window.scrollY) >=
                    document.body.offsetHeight - 850) {
                    if (page > maxLastPage)
                        return;

                    loadData(`{{ route('apiDataLiked') }}?page=${page}`, eLiked, htmlLiked);
                    loadData(`{{ route('apiDataAlbum') }}?page=${page}`, eAlbum, htmlAlbum);
                    loadData(`{{ route('apiDataFollow') }}?page=${page}`, eFollowing, htmlFollowing);
                    page++;
                }
            }, 500));

        });
    </script>
    <script>
        $(document).ready(function() {
            $(document).on('click', '.cancel-follow-btn', function(e) {
                e.preventDefault();
                Swal.fire({
                    icon: 'question',
                    title: 'Bỏ theo dõi',
                    text: 'Bạn chắc chắn muốn bỏ theo dõi người dùng không?',
                    showCancelButton: true,
                    confirmButtonText: 'Xác nhận',
                    cancelButtonText: 'Hủy',
                }).then((result) => {
                    if (result.isConfirmed) {
                        var userId = $(this).data('id');
                        var parentElement = $(this).closest('.relative.group');
                        $.ajax({
                            url: '/unfollow',
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}',
                                user_id: userId
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        iconColor: 'white',
                                        title: 'Bỏ theo dõi người dùng thành công',
                                        color: 'white',
                                        showConfirmButton: false,
                                        timer: 3000,
                                        toast: true,
                                        position: 'bottom-left',
                                        background: '#46DFB1'
                                    });
                                    parentElement.remove();
                                }
                                else {
                                    Swal.fire({
                                        icon: 'error',
                                        iconColor: 'white',
                                        title: 'Bỏ theo dõi người dùng không thành công',
                                        color: 'white',
                                        showConfirmButton: false,
                                        timer: 3000,
                                        toast: true,
                                        position: 'bottom-left',
                                        background: '#FF0000'
                                    });
                                }
                            }
                        });
                    }
                })
            });
            $(document).on('change', '.toggle-album', function(e) {
                var albumId = $(this).data('id');
                $.ajax({
                    url: '/privatealbum',
                    type: 'POST',
                    data: {
                        album_id: albumId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                iconColor: 'white',
                                title: 'Cập nhật thành công',
                                color: 'white',
                                showConfirmButton: false,
                                timer: 3000,
                                toast: true,
                                position: 'bottom-left',
                                background: '#46DFB1'
                            });
                            if (response.is_private) {
                                $(`.toggle-album[data-id="${response.album_id}"]`).prop('checked', true);
                            } else {
                                $(`.toggle-album[data-id="${response.album_id}"]`).prop('checked', false);
                            }
                        }
                        else {
                            Swal.fire({
                                icon: 'error',
                                iconColor: 'white',
                                title: 'Có lỗi xảy ra',
                                text: 'Không thể cập nhật',
                                color: 'white',
                                showConfirmButton: false,
                                timer: 3000,
                                toast: true,
                                position: 'bottom-left',
                                background: '#F04770'
                            });
                        }
                    }
                });
            });
            $(document).on('click', '.unlike-btn', function(e) {
                e.preventDefault();
                console.log('Clicked');
                var imageId = $(this).data('id');
                var parentElement = $(this).closest('.relative.group');
                $.ajax({
                    url: '/likeimage/' + imageId,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                            icon: 'success',
                            iconColor: 'white',
                            title: 'Đã bỏ thích ảnh',
                            color: 'white',
                            showConfirmButton: false,
                            timer: 1500,
                            toast: true,
                            position: 'bottom-left',
                            background: '#46DFB1'
                        }).then(() => {
                            parentElement.remove(); 
                        });
                        }
                        else {
                            Swal.fire({
                                icon: 'error',
                                iconColor: 'white',
                                title: 'Có lỗi xảy ra',
                                text: 'Không thể bỏ thích ảnh',
                                color: 'white',
                                showConfirmButton: false,
                                timer: 3000,
                                toast: true,
                                position: 'bottom-left',
                                background: '#F04770'
                            });
                        }
                    }
                });
            });
        })
    </script>
@endsection
