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
                        <button id="shared" onclick="ActivateTab('shared')"
                            class="text-xl px-4 py-2 text-gray-600 hover:text-black focus:outline-none relative">
                            Chia Sẽ
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
                            <option value="shared">Chia Sẽ</option>
                        </select>
                    </div>
                </div>
            </div>
            <!-- Activity -->
            <div id="activity-content" class="tab-content">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0 my-4">
                    <div>
                        <div class="font-bold text-2xl mb-2">Ảnh Bạn Đã Ghim</div>
                        <div class="text-gray-500 text-xs">Ảnh bạn đã ghim trong những ngày gần đây</div>
                    </div>
                    <button class="sm:ml-auto rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 flex items-center justify-center">
                        Bỏ ghim hết
                    </button>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @for ($i = 0; $i <= 15; $i++)
                        <div class="relative group">
                            <a href="#">
                                <div class="aspect-square">
                                    <img src="https://picsum.photos/200" loading="lazy" alt="Image" class="w-full h-full rounded-2xl object-cover transition-opacity duration-300 group-hover:opacity-15">
                                </div>
                                <div class="absolute inset-0 flex flex-col justify-between opacity-0 group-hover:opacity-100 group-hover:!opacity-100 transition-opacity duration-300">
                                    <div class="mt-2 text-left px-2 py-1">
                                        <div class="font-semibold text-lg truncate group-hover:text-black">Ảnh</div>
                                        <div class="text-sm text-gray-500 h-20 truncate overflow-hidden">Ảnh</div>
                                    </div>
                                </div>
                            </a>
                            <!-- Button -->
                            <div class="w-full flex flex-col items-center">
                                <button class="mt-2 rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                    Bỏ ghim
                                </button>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
            <!-- Interests -->
            <div id="interests-content" class="tab-content hidden">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0 my-4">
                    <div>
                        <div class="font-bold text-2xl mb-2">Sở Thích Của Bạn</div>
                        <div class="text-gray-500 text-xs">Hệ thống tự tùy chỉnh sở thích của bạn tùy vào hoạt động gần đây</div>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @for ($i = 0; $i <= 15; $i++)
                        <div class="relative group">
                            <a href="#">
                                <div class="aspect-square">
                                    <img src="https://picsum.photos/200" loading="lazy" alt="Image" class="w-full h-full rounded-2xl object-cover transition-opacity duration-300 group-hover:opacity-15">
                                </div>
                                <div class="absolute inset-0 flex flex-col justify-between opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <div class="mt-2 text-left px-2 py-1">
                                        <div class="font-semibold text-lg truncate group-hover:text-black">Sở Thích</div>
                                        <div class="text-sm text-gray-500 h-20 truncate overflow-hidden">Sở Thích</div>
                                    </div>
                                </div>
                            </a>
                            <div class="w-full flex flex-col items-center">
                                <button class="mt-2 rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 w-auto">
                                    Bỏ quan tâm
                                </button>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
            <!-- Board -->
            <div id="board-content" class="tab-content hidden">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0 my-4">
                    <div>
                        <div class="font-bold text-2xl mb-2">Bảng của Bạn</div>
                        <div class="text-gray-500 text-xs">Tùy chỉnh những album được hiển thị</div>
                    </div>
                </div>
                <div class="grid grid-cols-1 gap-2">
                    @for ($i = 0; $i <= 15; $i++)
                        <div class="flex flex-row items-center justify-between space-y-2">
                            <div class="flex flex-row items-center space-x-4">
                                <div class="aspect-square w-16 h-16">
                                    <img src="https://picsum.photos/200" alt="Image" class="object-cover rounded-lg">
                                </div>
                                <div class="">
                                    <div class="font-semibold text-lg truncate group-hover:text-black">Album</div>
                                    <div class="text-sm text-gray-500 overflow-hidden truncate max-w-44">Album</div>
                                </div>
                            </div>
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="checkbox" value="" class="sr-only peer">
                                <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 dark:peer-focus:ring-indigo-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all dark:border-gray-600 peer-checked:bg-indigo-600"></div>
                            </label>
                        </div>
                    @endfor
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
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @for ($i = 0; $i <= 15; $i++)
                        <div class="relative group">
                            <!-- Two Featured Images -->
                            <a href="#">
                                <div class="aspect-square flex flex-row items-center space-x-1 relative">
                                    <img src="https://picsum.photos/200" loading="lazy" alt="Image" class="w-1/2 h-3/4 rounded-l-2xl object-cover transition-opacity duration-300 group-hover:opacity-15">
                                    <img src="https://picsum.photos/200" loading="lazy" alt="Image" class="w-1/2 h-3/4 rounded-r-2xl object-cover transition-opacity duration-300 group-hover:opacity-15">
                                </div>
                            </a>
                            <!-- Profile Image -->
                            <div class="absolute left-1/2 top-64 sm:top-52 transform -translate-x-1/2 z-10 mb-4">
                                <div class="w-20 h-20 bg-gray-300 rounded-full border-4 border-white overflow-hidden">
                                    <img src="https://picsum.photos/100" alt="Profile" class="w-full h-full object-cover">
                                </div>
                            </div>
                            <!-- Profile Information -->
                            <div class="text-center">
                                <div class="font-semibold text-lg truncate group-hover:text-black">Tài Khoản</div>
                                <div class="text-sm text-gray-500 overflow-hidden truncate">Lượt Theo Dõi</div>
                            </div>
                            <!-- Button -->
                            <div class="w-full flex flex-col items-center">
                                <button class="mt-2 rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                    Bỏ theo dõi
                                </button>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
            <!-- Shared -->
            <div id="shared-content" class="tab-content hidden">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0 my-4">
                    <div>
                        <div class="font-bold text-2xl mb-2">Ảnh Được Chia Sẻ</div>
                        <div class="text-gray-500 text-xs">Ảnh bạn đã được chia sẻ bởi người khác</div>
                    </div>
                    <button class="sm:ml-auto rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 flex items-center justify-center">
                        Xóa hết
                    </button>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @for ($i = 0; $i <= 15; $i++)
                        <div class="relative group">
                            <a href="#">
                                <div class="aspect-square">
                                    <img src="https://picsum.photos/200" loading="lazy" alt="Image" class="w-full h-full rounded-2xl object-cover transition-opacity duration-300 group-hover:opacity-15">
                                </div>
                                <div class="absolute inset-0 flex flex-col justify-between opacity-0 group-hover:opacity-100 group-hover:!opacity-100 transition-opacity duration-300">
                                    <div class="mt-2 text-left px-2 py-1">
                                        <div class="font-semibold text-lg truncate group-hover:text-black">Ảnh</div>
                                        <div class="text-sm text-gray-500 h-20 truncate overflow-hidden">Ảnh</div>
                                    </div>
                                </div>
                            </a>
                            <!-- Profile Image -->
                            <div class="absolute left-1/2 top-72 sm:top-60 transform -translate-x-1/2 translate-y-2 z-10 mb-4">
                                <div class="w-20 h-20 bg-gray-300 rounded-full border-4 border-white overflow-hidden">
                                    <img src="https://picsum.photos/100" alt="Profile" class="w-full h-full object-cover">
                                </div>
                            </div>
                            <!-- Profile Information -->
                            <div class="text-center mt-10">
                                <div class="font-semibold text-lg truncate group-hover:text-black">Profile</div>
                                <div class="text-sm text-gray-500 overflow-hidden truncate">Follower Count</div>
                            </div>
                            <!-- Button -->
                            <div class="w-full flex flex-col items-center">
                                <button class="mt-2 rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                    Xóa
                                </button>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>
</main>
<script>
    function ChangeApperance(id) {
        const tabs = ['activity', 'interests', 'board', 'following', 'shared'];

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
        const contents = ['activity-content', 'interests-content', 'board-content', 'following-content', 'shared-content'];

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

    document.addEventListener('DOMContentLoaded', function () {
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
        } else if (current_path.endsWith('/shared') || savedTab === 'shared') {
            ActivateTab('shared'); 
        }
        else {
            ActivateTab('shared');
        }
    });
</script>


@endsection