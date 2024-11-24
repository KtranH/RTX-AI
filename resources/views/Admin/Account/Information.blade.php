@extends('Admin.Container')
@section('Content')

<title>RTX-ADMIN: Thông Tin</title>

<div class="w-full h-full flex flex-col justify-between space-y-4 p-2 divide-y-4 divide-indigo-700 cursor-default">
    <!-- Header -->
    <div class="h-10 py-2 px-8 flex items-center text-2xl font-bold">THÔNG TIN</div>
    <!-- Content -->
    <div class="h-full overflow-y-auto p-2 scroll-smooth">
        <div class="grid grid-cols-2 h-full space-x-4 p-2">
            <!-- Form -->
            <div class="flex flex-col items-center justify-start rounded-2xl bg-white px-4 shadow-md border-2 border-gray-200 space-y-2 h-full">
                <div class="w-full text-left font-semibold text-2xl border-b-2 border-gray-200 py-3">THÔNG TIN TÀI KHOẢN</div>
                <form action="" id="account-form" class="w-full h-full flex flex-col items-center justify-between space-y-4 px-2">
                    <div class="w-full h-3/4 flex flex-col items-center space-y-4">
                        <div class="w-full space-y-1 text-black">
                            <label for="username-input" class="font-medium">Username</label>
                            <input type="text" name="username-input" id="username-input" placeholder="" class="p-2 border-2 border-gray-500 focus:outline-none focus:border-indigo-700 rounded w-full">
                        </div>
                        <div class="w-full space-y-1 text-black">
                            <label for="email-input" class="font-medium">Email</label>
                            <input type="email" name="email-input" id="email-input" placeholder="" class="p-2 border-2 border-gray-500 focus:outline-none focus:border-indigo-700 rounded w-full">
                        </div>
                        <div class="w-full space-y-1 text-black">
                            <label for="password-input" class="font-medium">Password</label>
                            <div class="w-full flex flex-row items-center justify-between space-x-4">
                                <input type="password" name="password-input" id="password-input" placeholder="" class="p-2 border-2 border-gray-500 focus:outline-none focus:border-indigo-700 rounded w-full">
                                <i id="toggle-icon" class="fa-solid fa-eye flex items-center cursor-pointer text-gray-500 hover:text-indigo-700 border-2 border-gray-500 hover:border-indigo-700 py-[12px] px-[12px] rounded w-12"></i>
                            </div>
                        </div>
                        <div class="w-full space-y-1 text-black">
                            <label for="role-select" class="font-medium">Quyền</label>
                            <select name="role-select" id="role-select" class="disabled:bg-gray-300 p-2 outline outline-2 outline-gray-500 focus:outline-indigo-700 rounded-[3px] w-full border-r-[12px] border-transparent">
                                <option selected value="ABC">ABC</option>
                                <option value="ABC">ABC</option>
                                <option value="ABC">ABC</option>
                                <option value="ABC">ABC</option>
                                <option value="ABC">ABC</option>
                            </select>
                        </div>
                        <div class="w-full space-y-1 text-black">
                            <label for="create-input" class="font-medium">Ngày Vào</label>
                            <input type="text" name="create-input" id="create-input" placeholder="" disabled class="disabled:bg-gray-300 p-2 border-2 border-gray-500 focus:outline-none focus:border-indigo-700 rounded w-full">
                        </div>
                        <div class="w-full space-y-1 text-black">
                            <label for="update-input" class="font-medium">Ngày Cập Nhật</label>
                            <input type="text" name="update-input" id="update-input" placeholder="" disabled class="disabled:bg-gray-300 p-2 border-2 border-gray-500 focus:outline-none focus:border-indigo-700 rounded w-full">
                        </div>
                    </div>
                    <div class="w-full flex flex-row items-center justify-center border-t-2 border-gray-200 py-3 space-x-8">
                        <button type="submit" id="update-button" class="flex flex-row items-center space-x-2 bg-yellow-700 border-2 border-yellow-700 hover:bg-white hover:!text-yellow-700 rounded px-3 py-1 text-white text-lg font-medium">
                            <i class="fa-solid fa-pen text-current"></i>
                            <div>Sửa Lại</div>
                        </button>
                        <button type="button" id="reset-button" class="flex flex-row items-center space-x-2 bg-green-700 border-2 border-green-700 hover:bg-white hover:!text-green-700 rounded px-3 py-1 text-white text-lg font-medium">
                            <i class="fa-solid fa-rotate text-current"></i>
                            <div>Làm Mới</div>
                        </button>
                    </div>
                </form>
            </div>
            <div class="grid grid-rows-4 space-y-4">
                <!-- Information -->
                <div class="row-span-3 flex flex-col items-center justify-center rounded-2xl bg-white px-4 shadow-md border-2 border-gray-200 h-full">
                    <div class="aspect-square relative group w-[350px] h-[350px] flex items-center justify-center px-2">
                        <img id="avatar-image" src="https://picsum.photos/id/237/350" alt="Avatar" class="w-full h-full object-cover rounded-full border-4 border-gray-200">
                        <label for="avatar-input" class="absolute inset-0 flex items-center justify-center bg-white bg-opacity-50 opacity-0 group-hover:opacity-100 group-hover:!opacity-100 transition-opacity duration-300 cursor-pointer">
                            <i class="fas fa-upload text-indigo-700 text-8xl"></i>
                        </label>
                        <input type="file" name="avatar-input" id="avatar-input" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer">
                    </div>
                    <div class="w-full text-center font-semibold text-2xl pt-3 pb-2">USERNAME</div>
                    <div class="w-full text-center font-medium text-gray-500 text-xl pb-3">EMAIL</div>
                </div>
                <!-- Quick Information -->
                <div class="grid grid-cols-2 space-x-4">
                    <div class="flex flex-row items-center justify-between rounded-2xl bg-white py-2 px-4 shadow-md border-2 border-gray-200">
                        <div class="basis-1/4 flex items-center justify-center">
                            <div class="flex items-center justify-center bg-red-600 rounded-full py-3 px-[22.265px]">
                                <i class="fa-solid fa-hourglass-half text-[50px] text-white"></i>
                            </div>
                        </div>
                        <div class="basis-3/4 text-center">
                            <div class="font-medium text-lg">SỐ BÀI CẦN DUYỆT</div>
                            <div class="text-3xl">12</div>
                        </div>
                    </div>
                    <div class="flex flex-row items-center justify-between rounded-2xl bg-white py-2 px-4 shadow-md border-2 border-gray-200">
                        <div class="basis-1/4 flex items-center justify-center">
                            <div class="flex items-center justify-center bg-green-600 rounded-full p-3">
                                <i class="fa-solid fa-feather text-[50px] text-white"></i>
                            </div>
                        </div>
                        <div class="basis-3/4 text-center">
                            <div class="font-medium text-lg">SỐ BÀI ĐÃ DUYỆT</div>
                            <div class="text-3xl">2000</div>
                        </div>
                    </div>
                </div>                
            </div>
        </div>
    </div>
</div>
<script>
    //Form
    $(document).ready(function () 
    {
        //Toggle Icon
        $('#toggle-icon').on('click', function (e) 
        {
            const passwordInput = $('#password-input');
            const icon = $('#toggle-icon');

            if (passwordInput.attr('type') === 'password') 
            {
                passwordInput.attr('type', 'text');
                icon.removeClass('fa-eye px-[12px]').addClass('fa-eye-slash px-[11px]');
            } 
            else 
            {
                passwordInput.attr('type', 'password');
                icon.removeClass('fa-eye-slash px-[11px]').addClass('fa-eye px-[12px]');
            }
        });

        //Update Button
        $('#update-button').on('click', function (e) 
        {
            e.preventDefault();

            SetNotificationDialog('failure', 'abc');
        });

        //Reset Button
        $('#reset-button').on('click', function (e) 
        {
            e.preventDefault();

            $('#username-input').val('');
            $('#email-input').val('');
            $('#password-input').val('');
        });
    });
</script>

<!-- Notification Dialog -->
<div id="notification-dialog" class="hidden fixed top-0 left-0 w-full h-full bg-gray-800 bg-opacity-50 flex flex-col items-center justify-center">
    <div class="bg-white rounded-lg w-[500px]">
        <div id="title-notificationDialog" class="bg-green-700 rounded-t-lg text-white font-bold text-center text-xl p-2"></div>
        <div id="content-notificationDialog" class="flex flex-col items-center justify-center h-24 py-2 px-4 text-lg text-center"></div>
        <div class="flex flex-row items-center justify-center p-2 space-x-4">
            <button id="confirm-notificationDialog" class="flex flex-row items-center space-x-2 bg-green-700 border-2 border-green-700 hover:bg-white hover:!text-green-700 rounded px-3 py-1 text-white text-lg font-medium"> 
                <i class="fa-solid fa-circle-check text-xl text-current"></i>
                <div>Xác Nhận</div>
            </button>
        </div>
    </div>
</div>  
<script>
    function SetNotificationDialog(state, message) 
    {
        const dialog = $('#notification-dialog');
        const title = $('#title-notificationDialog');
        const content = $('#content-notificationDialog');
        const confirmButton = $('#confirm-notificationDialog');

        title.removeClass('bg-green-700 bg-red-700 bg-yellow-700');
        confirmButton.removeClass('bg-green-700 border-green-700 hover:!text-green-700');
        confirmButton.removeClass('bg-red-700 border-red-700 hover:!text-red-700');
        confirmButton.removeClass('bg-yellow-700 border-yellow-700 hover:!text-yellow-700');

        if (state === 'success') 
        {
            title.addClass('bg-green-700').text('THÀNH CÔNG');
            confirmButton.addClass('bg-green-700 border-green-700 hover:!text-green-700');
        } 
        else if (state === 'failure') 
        {
            title.addClass('bg-red-700').text('THẤT BẠI');
            confirmButton.addClass('bg-red-700 border-red-700 hover:!text-red-700');
        } 
        else if (state === 'warning') 
        {
            title.addClass('bg-yellow-700').text('CẢNH BÁO');
            confirmButton.addClass('bg-yellow-700 border-yellow-700 hover:!text-yellow-700');
        }

        content.text(message);

        dialog.removeClass('hidden');
    }

    $(document).ready(function () 
    {
        $('#confirm-notificationDialog').on('click', function (e) 
        {
            e.preventDefault();

            $('#notification-dialog').addClass('hidden');
        });
    });
</script>

@endsection