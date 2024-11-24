@extends('Admin.Container')
@section('Content')

<title>RTX-ADMIN: Nhân Viên</title>

<div class="w-full h-full flex flex-col justify-between space-y-4 p-2 divide-y-4 divide-indigo-700 cursor-default">
    <!-- Header -->
    <div class="h-10 py-2 px-8 flex items-center text-2xl font-bold">NHÂN VIÊN</div>
    <!-- Content -->
    <div class="h-full overflow-hidden p-2">
        <!-- CRUD -->
        <div class="grid grid-cols-3 h-full space-x-4 p-2">
            <!-- Table -->
            <div class="col-span-2 flex flex-col items-center justify-between rounded-2xl bg-white px-4 shadow-md border-2 border-gray-200 space-y-2 h-full">
                <!-- Header -->
                <div class="w-full flex flex-row items-center justify-between border-b-2 border-gray-200 py-2.5">
                    <div class="font-semibold text-2xl text-left">DANH SÁCH NHÂN VIÊN</div>
                    <!-- Search -->
                    <form action="" id="search-form" class="relative w-72 text-black">
                        <i id="search-icon" class="fa-solid fa-magnifying-glass absolute inset-y-0 start-0 flex items-center pl-3 cursor-pointer text-current hover:text-indigo-700"></i>
                        <input type="text" id="search-input" class="w-full py-2 px-10 border-2 border-gray-500 focus:outline-none focus:border-indigo-700 rounded w-full" placeholder="Nhập tìm kiếm...">
                        <i id="clear-icon" class="hidden fa-solid fa-xmark absolute inset-y-0 end-0 flex items-center pr-3 cursor-pointer text-current hover:text-indigo-700"></i>
                    </form>
                </div>
                <!-- Table -->
                <div class="w-full h-[679px] table-fixed overflow-auto pr-2">
                    <table class="relative w-full table-fixed border-collapse border-x-2">
                        <thead class="sticky top-0 bg-gray-200">
                            <tr class="text-center">
                                <th class="w-1/12 p-3">ID</th>
                                <th class="w-1/12">Avatar</th>
                                <th class="w-2/12">Username</th>
                                <th class="w-2/12">Email</th>
                                <th class="w-2/12">Status</th>
                                <th class="w-1/12">Ngày Tạo</th>
                                <th class="w-1/12">Ngày Sửa</th>
                                <th class="w-2/12">Action</th>
                            </tr>
                        </thead>
                        <tbody class="align-top">
                            @for($i = 0; $i < 150; $i++)
                                <tr class="even:bg-gray-100 hover:bg-indigo-200 border-b-2">
                                    <td class="p-1 text-center align-middle">{{$i}}</td>
                                    <td class="px-1 pt-2 flex items-center justify-center h-[85.14px]"><img src="https://picsum.photos/id/{{$i + 10}}/200" alt="" class="image-table cursor-pointer w-3/4 aspect-square rounded-full border-2 border-gray"></td>
                                    <td class="p-1 text-center align-middle">ABC</td>
                                    <td class="p-1 text-center align-middle">ABC</td>
                                    <td class="p-1 text-center align-middle">ABC</td>
                                    <td class="p-1 text-center align-middle">ABC</td>
                                    <td class="p-1 text-center align-middle">ABC</td>
                                    <td class="p-1">
                                        <div class="flex flex-row items-center justify-center space-x-2 w-full h-[85.14px]">
                                            <button data-id="{{$i}}" data-name="{{'ABC'}}" data-email="{{'ABC'}}" class="edit-button flex items-center bg-yellow-700 border-2 border-yellow-700 hover:bg-white hover:!text-yellow-700 rounded p-2 text-white text-lg font-medium">
                                                <i class="fa-solid fa-pen text-current text-xs"></i>
                                            </button>
                                            <button data-id="{{$i}}" data-name="{{'ABC'}}" class="delete-button flex items-center bg-red-700 border-2 border-red-700 hover:bg-white hover:!text-red-700 rounded p-2 text-white text-lg font-medium">
                                                <i class="fa-solid fa-trash text-current text-xs"></i>
                                            </button>
                                            <button data-id="{{$i}}" data-name="{{'ABC'}}" data-lock="{{false}}" class="lock-button flex items-center bg-orange-700 border-2 border-orange-700 hover:bg-white hover:!text-orange-700 rounded p-2 text-white text-lg font-medium">
                                                <i class="lock-icon fa-solid fa-lock text-current text-xs"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
                <!-- Footer -->
                <div class="w-full flex flex-row items-center justify-between border-t-2 border-gray-200 py-3 space-x-8 max-h-[74px]">
                    <form action="" id="pagination-form" class="space-x-1 text-black">
                        <label for="pagination-select" class="font-medium">Số Trang</label>
                        <select name="pagination-select" id="pagination-select" class="px-3.5 py-1.5 border border-gray-300 focus:outline-none focus:border-indigo-700 rounded">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="15">15</option>
                            <option selected value="20">20</option>
                            <option value="All">All</option>
                        </select>
                    </form>
                    <div class="flex flex-row items-center space-x-2 text-black">
                        <div>Hiện <span class="font-semibold">20</span> với tổng <span class="font-semibold">150</span></div>
                        <div class="flex flex-row items-center font-medium">
                            <a href="" class="rounded-l-lg border-y border-l border-gray-300 py-2 px-2.5 hover:text-indigo-700 hover:bg-gray-200"><i class="fa-solid fa-arrow-left text-current"></i></a>
                            <a href="" class="border-y border-l border-gray-300 py-2 px-3 hover:text-indigo-700 hover:bg-gray-200">1</a>
                            <a href="" class="border-y border-l border-gray-300 py-2 px-3 hover:text-indigo-700 hover:bg-gray-200">2</a>
                            <a href="" class="border-y border-l border-gray-300 py-2 px-3 hover:text-indigo-700 hover:bg-gray-200">3</a>
                            <a href="" class="border-y border-l border-gray-300 py-2 px-3 hover:text-indigo-700 hover:bg-gray-200">4</a>
                            <a href="" class="border-y border-l border-gray-300 py-2 px-3 hover:text-indigo-700 hover:bg-gray-200">5</a>
                            <a href="" class="rounded-r-lg border-y border-x border-l border-gray-300 py-2 px-2.5 hover:text-indigo-700 hover:bg-gray-200"><i class="fa-solid fa-arrow-right text-current"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="grid grid-rows-5 space-y-4">
                <!-- Quick Information -->
                <div class="flex flex-row items-center justify-between rounded-2xl bg-white py-2 px-4 shadow-md border-2 border-gray-200">
                    <div class="basis-1/4 flex items-center justify-center">
                        <div class="flex items-center justify-center bg-yellow-600 rounded-full py-3 px-[16px]">
                            <i class="fa-solid fa-briefcase text-[50px] text-white"></i>
                        </div>
                    </div>
                    <div class="basis-3/4 text-center">
                        <div class="font-medium text-lg">SỐ LƯỢNG NHÂN VIÊN</div>
                        <div class="text-3xl">12</div>
                    </div>
                </div>
                <div class="flex flex-row items-center justify-between rounded-2xl bg-white py-2 px-4 shadow-md border-2 border-gray-200">
                    <div class="basis-1/4 flex items-center justify-center">
                        <div class="flex items-center justify-center bg-red-600 rounded-full py-3 px-[19.13px]">
                            <i class="fa-solid fa-lock text-[50px] text-white"></i>
                        </div>
                    </div>
                    <div class="basis-3/4 text-center">
                        <div class="font-medium text-lg">SỐ LƯỢNG NHÂN VIÊN BỊ KHÓA</div>
                        <div class="text-3xl">10</div>
                    </div>
                </div>        
                <!-- Form -->
                <div class="row-span-3 flex flex-col items-center justify-start rounded-2xl bg-white px-4 shadow-md border-2 border-gray-200 space-y-2">
                    <div id="crud-title" class="w-full text-left font-semibold text-2xl border-b-2 border-gray-200 py-3">THÊM MỚI NHÂN VIÊN</div>
                    <form action="" id="crud-form" class="w-full h-full flex flex-col items-center justify-between space-y-4 px-2">
                        <div class="w-full flex flex-col items-center space-y-4">
                            <div class="w-full space-y-1 text-black">
                                <label for="username-input" class="font-medium">Username</label>
                                <input type="text" name="username-input" id="username-input" placeholder="" class="p-2 border-2 border-gray-500 focus:outline-none focus:border-indigo-700 rounded w-full">
                            </div>
                            <div class="w-full space-y-1 text-black">
                                <label for="email-input" class="font-medium">Email</label>
                                <input type="text" name="email-input" id="email-input" placeholder="" class="p-2 border-2 border-gray-500 focus:outline-none focus:border-indigo-700 rounded w-full">
                            </div>  
                        </div>
                        <div class="w-full flex flex-row items-center justify-center border-t-2 border-gray-200 py-3 space-x-2">
                            <button type="submit" id="insert-button" class="flex flex-row items-center space-x-2 bg-indigo-700 border-2 border-indigo-700 hover:bg-white hover:!text-indigo-700 rounded px-3 py-1 text-white text-lg font-medium">
                                <i class="fa-solid fa-plus text-current"></i>
                                <div>Thêm Mới</div>
                            </button>
                            <button type="submit" id="update-button" class="hidden flex flex-row items-center space-x-2 bg-yellow-700 border-2 border-yellow-700 hover:bg-white hover:!text-yellow-700 rounded px-3 py-1 text-white text-lg font-medium">
                                <i class="fa-solid fa-pen text-current"></i>
                                <div>Sửa Lại</div>
                            </button>
                            <button type="button" id="reset-button" class="flex flex-row items-center space-x-2 bg-green-700 border-2 border-green-700 hover:bg-white hover:!text-green-700 rounded px-3 py-1 text-white text-lg font-medium">
                                <i class="fa-solid fa-rotate text-current"></i>
                                <div>Làm Mới</div>
                            </button>
                            <button type="button" id="return-button" class="hidden flex flex-row items-center space-x-2 bg-indigo-700 border-2 border-indigo-700 hover:bg-white hover:!text-indigo-700 rounded px-3 py-1 text-white text-lg font-medium">
                                <i class="fa-solid fa-backward text-current"></i>
                                <div>Quay Về</div>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    //Search
    $(document).ready(function () 
    {
        $('#search-input').on('input', function () 
        {
            if ($(this).val().length > 0) 
            {
                $('#clear-icon').removeClass('hidden');
                console.log("a");
            } 
            else 
            {
                $('#clear-icon').addClass('hidden');
            }
        });

        $('#clear-icon').on('click', function () 
        {
            $('#search-input').val('');
            $('#clear-icon').addClass('hidden');
        });
    });

    //Form
    $(document).ready(function () 
    {
        $('.image-table').on('click', function (e) 
        {
            e.preventDefault();

            const image = $(this).attr('src');

            $('#image-dialog').removeClass('hidden');
            $('#image-imageDialog').attr('src', image);
        });

        //Edit Button
        $('.edit-button').on('click', function (e) 
        {
            e.preventDefault();

            const id = $(this).data('id');
            const name = $(this).data('name');
            const email = $(this).data('email');

            $('#crud-title').text('SỬA LẠI NHÂN VIÊN');
            $('#username-input').val(name);
            $('#email-input').val(email);

            $('#insert-button').addClass('hidden');
            $('#update-button').removeClass('hidden');
            $('#return-button').removeClass('hidden');
        });

        //Delete Button
        $('.delete-button').on('click', function (e) 
        {
            e.preventDefault();

            const id = $(this).data('id');
            const name = $(this).data('name');

            $('#confirm-dialog').removeClass('hidden');
            $('#content-confirmDialog').html('Bạn có chắc chắn muốn xóa nhân viên' + name + ' này không?');
        });

        //Lock Button
        $('.lock-button').on('click', function (e) 
        {
            e.preventDefault();

            const id = $(this).data('id');
            const name = $(this).data('name');
            const lock = $(this).data('lock');

            if(!lock)
            {
                $(this).find('.lock-icon').removeClass('fa-lock').addClass('fa-unlock');
                SetNotificationDialog('success', 'Đã khóa nhân viên ' + name);
            }
            else
            {
                $(this).find('.lock-icon').removeClass('fa-unlock').addClass('fa-lock');
                SetNotificationDialog('success', 'Đã mở khóa nhân viên ' + name);
            }
            
        });

        //Insert Button
        $('#insert-button').on('click', function (e) 
        {
            e.preventDefault();

            SetNotificationDialog('success', 'abc');
        });

        //Update Button
        $('#update-button').on('click', function (e) 
        {
            e.preventDefault();

            SetNotificationDialog('failure', 'abc');
        });

        //Return Button
        $('#return-button').on('click', function (e) 
        {
            e.preventDefault();

            $('#crud-title').text('THÊM MỚI NHÂN VIÊN');
            $('#username-input').val('');
            $('#email-input').val('');

            $('#insert-button').removeClass('hidden');
            $('#update-button').addClass('hidden');
            $('#return-button').addClass('hidden');
            $(this).addClass('hidden');
        });

        //Reset Button
        $('#reset-button').on('click', function (e) 
        {
            e.preventDefault();

            $('#name-input').val('');
            $('#description-input').val('');
        });
    });
</script>

<!-- Confirm Dialog -->
<div id="confirm-dialog" class="hidden fixed top-0 left-0 w-full h-full bg-gray-800 bg-opacity-50 flex flex-col items-center justify-center">
    <div class="bg-white rounded-lg w-[500px]">
        <div class="bg-indigo-700 rounded-t-lg text-white font-bold text-center text-xl p-2">XÁC NHẬN</div>
        <div id="content-confirmDialog" class="flex flex-col items-center justify-center h-24 py-2 px-4 text-lg text-center"></div>
        <div class="flex flex-row items-center justify-center p-2 space-x-4">
            <button id="confirm-confirmDialog" class="flex flex-row items-center space-x-2 bg-green-700 border-2 border-green-700 hover:bg-white hover:!text-green-700 rounded px-3 py-1 text-white text-lg font-medium"> 
                <i class="fa-solid fa-circle-check text-xl text-current"></i>
                <div>Xác Nhận</div>
            </button>
            <button id="cancel-confirmDialog" class="flex flex-row items-center space-x-2 bg-red-700 border-2 border-red-700 hover:bg-white hover:!text-red-700 rounded px-3 py-1 text-white text-lg font-medium">
                <i class="fa-solid fa-circle-xmark text-xl text-current"></i>
                <div>Hủy Bỏ</div>
            </button>
        </div>
    </div>
</div>  
<script>
    $(document).ready(function () 
    {
        $('#confirm-confirmDialog').on('click', function (e) 
        {
            e.preventDefault();

            $('#confirm-dialog').addClass('hidden');
        });

        $('#cancel-confirmDialog').on('click', function (e) 
        {
            e.preventDefault();

            $('#confirm-dialog').addClass('hidden');
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

<!-- Image Dialog -->
<div id="image-dialog" class="hidden fixed top-0 left-0 w-full h-full bg-gray-800 bg-opacity-50 flex flex-col items-center justify-center">
    <div class="bg-white rounded-2xl w-[500px] h-[600px] flex flex-col items-center justify-between space-y-4 border-[7px] border-indigo-700">
        <div class="w-[500px] h-[500px] p-4">   
            <img id="image-imageDialog" src="https://picsum.photos/id/237/200" alt="Image" class="aspect-square w-full h-full rounded-2xl border-2 border-gray-200">
        </div>
        <div class="flex flex-row items-center justify-center px-4 pb-10">
            <button id="confirm-imageDialog" class="flex flex-row items-center space-x-2 bg-indigo-700 border-2 border-indigo-700 hover:bg-white hover:!text-indigo-700 rounded px-3 py-1 text-white text-lg font-medium"> 
                <i class="fa-solid fa-circle-check text-xl text-current"></i>
                <div>Xác Nhận</div>
            </button>
        </div>
    </div>
</div>  
<script>
    $(document).ready(function () 
    {
        $('#confirm-imageDialog').on('click', function (e) 
        {
            e.preventDefault();

            $('#image-dialog').addClass('hidden');
        });
    });
</script>

@endsection