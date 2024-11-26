<div class="flex flex-col justify-between bg-white h-full font-medium">
    <div class="flex flex-col space-y-4 divide-y-4 divide-indigo-700 p-2">
        <a href="{{ route('admin') }}" class="flex flex-row items-center text-inherit hover:text-inherit space-x-2">
            <img src="/assets/img/icon.png" alt="Logo" class="w-10">
            <div class="text-2xl font-bold">RTX-ADMIN</div>
        </a>
        <div class="flex flex-col pt-3 space-y-1">
            <a id="home-sidebar" href="{{ route('admin') }}" class="flex flex-row items-center hover:bg-gray-200 hover:text-indigo-700 rounded-lg p-2 text-lg space-x-2">
                <i class="fa-solid fa-house text-current"></i>
                <div>Tổng Quan</div>
            </a>
        </div>
        <div class="flex flex-col pt-3 space-y-1">
            <div class="mb-2 font-semibold text-indigo-700 cursor-default">Quản Lý</div>
            <a id="category-sidebar" href="{{ route('admin.category') }}" class="flex flex-row items-center hover:bg-gray-200 hover:text-indigo-700 rounded-lg p-2 text-lg space-x-2">
                <i class="fa-solid fa-layer-group text-current"></i>
                <div>Thể Loại</div>
            </a>
            <a id="image-sidebar" href="{{ route('admin.image') }}" class="flex flex-row items-center hover:bg-gray-200 hover:text-indigo-700 rounded-lg p-2 text-lg space-x-2">
                <i class="fa-solid fa-image text-current"></i>
                <div>Hình Ảnh</div>
            </a>
            <a id="ai-sidebar" href="{{ route('admin.ai') }}" class="flex flex-row items-center hover:bg-gray-200 hover:text-indigo-700 rounded-lg p-2 text-lg space-x-2">
                <i class="fa-solid fa-robot text-current"></i>
                <div>Ảnh AI</div>
            </a>
            <a id="comment-sidebar" href="{{ route('admin.comment') }}" class="flex flex-row items-center hover:bg-gray-200 hover:text-indigo-700 rounded-lg p-2 text-lg space-x-2">
                <i class="fa-solid fa-comment text-current"></i>
                <div>Bình Luận</div>
            </a>
        </div>  
        <div class="flex flex-col pt-3 space-y-1">
            <div class="mb-2 font-semibold text-indigo-700 cursor-default">Tài Khoản</div>
            <a id="information-sidebar" href="{{ route('admin.information') }}" class="flex flex-row items-center hover:bg-gray-200 hover:text-indigo-700 rounded-lg p-2 text-lg space-x-2">
                <i class="fa-solid fa-circle-info text-current"></i>
                <div>Thông Tin</div>
            </a>
            <a id="employee-sidebar" href="{{ route('admin.employee') }}" class="flex flex-row items-center hover:bg-gray-200 hover:text-indigo-700 rounded-lg p-2 text-lg space-x-2">
                <i class="fa-solid fa-briefcase text-current"></i>
                <div>Nhân Viên</div>
            </a>
        </div>
        <div class="flex flex-row justify-center space-x-8 pt-3">
            <a id="setting-sidebar" href="" class="flex flex-row items-center hover:bg-gray-200 hover:text-indigo-700 hover:border-indigo-700 border-2 border-gray-700 rounded-full p-2 text-lg space-x-2">
                <i class="fa-solid fa-gear text-current"></i>
            </a>
            <a id="theme-sidebar" href="" class="flex flex-row items-center hover:bg-gray-200 hover:text-indigo-700 hover:border-indigo-700 border-2 border-gray-700 rounded-full p-2 text-lg space-x-2">
                <i class="fa-solid fa-wand-magic text-current"></i>
            </a>
            <a href="/" class="flex flex-row items-center hover:bg-gray-200 hover:text-indigo-700 hover:border-indigo-700 border-2 border-gray-700 rounded-full p-2 text-lg space-x-2">
                <i class="fa-solid fa-rocket text-current"></i>
            </a>
        </div>   
    </div>
    <div class="flex flex-col space-y-2 p-2">
        <div class="flex flex-col space-y-2 pt-3">
            <a href="" class="flex flex-row items-center hover:bg-gray-200 hover:text-indigo-700 rounded-lg p-2 text-lg space-x-3">
                <img src="https://picsum.photos/id/237/200" alt="Avatar" class="rounded-full w-10 h-10 border border-gray-400">
                <div>
                    <div class="text-gray-400 text-xs">Admin</div>
                    <div class="text-current">Username</div>
                </div>
            </a>
            <a href="" class="flex flex-row items-center justify-center border-4 border-red-700 text-inherit hover:bg-red-700 hover:text-white rounded-lg p-2 text-lg space-x-2">
                <i class="fa-solid fa-right-from-bracket"></i>
                <div>Đăng Xuất</div>
            </a>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () 
    {
        var links = 
        {
            '/admin': $('#home-sidebar'),
            '/admin/category': $('#category-sidebar'),
            '/admin/image': $('#image-sidebar'),
            '/admin/ai': $('#ai-sidebar'),
            '/admin/comment': $('#comment-sidebar'),
            '/admin/information': $('#information-sidebar'),
            '/admin/employee': $('#employee-sidebar')
        };

        var currentPath = window.location.pathname;

        $.each(links, function (path, element) 
        {
            if (currentPath === path) 
            {
                element.addClass('bg-gray-200 text-indigo-700 font-bold');
            } 
            else 
            {
                element.removeClass('bg-gray-200 text-indigo-700 font-bold');
            }
        });
    });
</script>