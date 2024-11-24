@extends('Admin.Container')
@section('Content')

<title>RTX-ADMIN: Thể Loại</title>

<div class="w-full h-full flex flex-col justify-between space-y-4 p-2 divide-y-4 divide-indigo-700 cursor-default">
    <!-- Header -->
    <div class="h-10 py-2 px-8 flex items-center text-2xl font-bold">THỂ LOẠI</div>
    <!-- Content -->
    <div class="h-full overflow-y-auto p-2 scroll-smooth">
        <!-- Charts -->
        <div class="grid grid-cols-2 h-[720px] space-x-4 p-2">
            <!-- Statistic -->
            <div class="flex flex-col items-center rounded-2xl bg-white px-4 shadow-md border-2 border-gray-200 space-y-2">
                <div class="w-full text-left font-semibold text-2xl border-b-2 border-gray-200 py-3">SỐ ẢNH THEO THỂ LOẠI</div>
                <div id="statistic-container" class="w-full h-full py-3"></div>
            </div>
            <!-- Quick Information -->
            <div class="grid grid-rows-4 space-y-4">
                <div class="flex flex-row items-center justify-between rounded-2xl bg-white py-2 px-4 shadow-md border-2 border-gray-200">
                    <div class="basis-1/4 flex items-center justify-center">
                        <div class="flex items-center justify-center bg-green-600 rounded-full py-3 px-[12.88px]">
                            <i class="fa-solid fa-layer-group text-[50px] text-white"></i>
                        </div>
                    </div>
                    <div class="basis-3/4 text-center">
                        <div class="font-medium text-lg">SỐ THỂ LOẠI</div>
                        <div class="text-3xl">1000</div>
                    </div>
                </div>
                <div class="flex flex-row items-center justify-between rounded-2xl bg-white py-2 px-4 shadow-md border-2 border-gray-200">
                    <div class="basis-1/4 flex items-center justify-center">
                        <div class="flex items-center justify-center bg-pink-600 rounded-full p-3">
                            <i class="fa-solid fa-heart text-[50px] text-white"></i>
                        </div>
                    </div>
                    <div class="basis-3/4 text-center">
                        <div class="font-medium text-lg">THỂ LOẠI ĐƯỢC YÊU THÍCH NHẤT</div>
                        <div class="text-3xl">BÁNH NGỌT</div>
                    </div>
                </div>
                <div class="flex flex-row items-center justify-between rounded-2xl bg-white py-2 px-4 shadow-md border-2 border-gray-200">
                    <div class="basis-1/4 flex items-center justify-center">
                        <div class="flex items-center justify-center bg-cyan-600 rounded-full p-3">
                            <i class="fa-solid fa-heart-crack text-[50px] text-white"></i>
                        </div>
                    </div>
                    <div class="basis-3/4 text-center">
                        <div class="font-medium text-lg">THỂ LOẠI ÍT ẢNH NHẤT</div>
                        <div class="text-3xl">KHUNG CẢNH</div>
                    </div>
                </div>
                <div class="flex flex-row items-center justify-between rounded-2xl bg-white py-2 px-4 shadow-md border-2 border-gray-200">
                    <div class="basis-1/4 flex items-center justify-center">
                        <div class="flex items-center justify-center bg-amber-600 rounded-full py-3 px-[12.88px]">
                            <i class="fa-solid fa-trophy text-[50px] text-white"></i>
                        </div>
                    </div>
                    <div class="basis-3/4 text-center">
                        <div class="font-medium text-lg">THỂ LOẠI NHIỀU ẢNH NHẤT</div>
                        <div class="text-3xl">CHÂN DUNG</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- CRUD -->
        <div class="grid grid-cols-2 h-[720px] space-x-4 p-2">
            <!-- Table -->
            <div class="flex flex-col items-center justify-between rounded-2xl bg-white px-4 shadow-md border-2 border-gray-200 space-y-2 h-[720px]">
                <!-- Header -->
                <div class="w-full flex flex-row items-center justify-between border-b-2 border-gray-200 py-2.5">
                    <div class="font-semibold text-2xl text-left">BẢNG THỂ LOẠI</div>
                    <!-- Search -->
                    <form action="" id="search-form" class="relative w-72 text-black">
                        <i id="search-icon" class="fa-solid fa-magnifying-glass absolute inset-y-0 start-0 flex items-center pl-3 cursor-pointer text-current hover:text-indigo-700"></i>
                        <input type="text" id="search-input" class="w-full py-2 px-10 border-2 border-gray-500 focus:outline-none focus:border-indigo-700 rounded w-full" placeholder="Nhập tìm kiếm...">
                        <i id="clear-icon" class="hidden fa-solid fa-xmark absolute inset-y-0 end-0 flex items-center pr-3 cursor-pointer text-current hover:text-indigo-700"></i>
                    </form>
                </div>
                <!-- Table -->
                <div class="w-full h-full table-fixed overflow-auto pr-2">
                    <table class="relative w-full table-fixed border-collapse border-x-2">
                        <thead class="sticky top-0 bg-gray-200">
                            <tr class="text-center">
                                <th class="w-1/12">ID</th>
                                <th class="w-2/12">Name</th>
                                <th class="w-7/12">Description</th>
                                <th class="w-2/12">Action</th>
                            </tr>
                        </thead>
                        <tbody class="align-top">
                            @for($i = 0; $i < 150; $i++)
                                <tr class="even:bg-gray-100 hover:bg-indigo-200 border-b-2">
                                    <td class="p-1 text-center align-middle">{{$i}}</td>
                                    <td class="p-1 text-center align-middle">ABC</td>
                                    <td class="p-1 align-middle truncate hover:overflow-visible hover:whitespace-normal hover:text-ellipsis text-justify">Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatum voluptas esse incidunt deleniti voluptate error itaque, unde sed obcaecati corrupti expedita? Corporis quos placeat earum error similique itaque aperiam amet?</td>
                                    <td class="flex flex-row items-center justify-center space-x-2 p-1">
                                        <button data-id="{{$i}}" data-name="{{'ABC'}}" data-description="{{'Lorem'}}" class="edit-button flex items-center bg-yellow-700 border-2 border-yellow-700 hover:bg-white hover:!text-yellow-700 rounded p-2 text-white text-lg font-medium">
                                            <i class="fa-solid fa-pen text-current text-xs"></i>
                                        </button>
                                        <button data-id="{{$i}}" data-name="{{'ABC'}}" class="delete-button flex items-center bg-red-700 border-2 border-red-700 hover:bg-white hover:!text-red-700 rounded p-2 text-white text-lg font-medium">
                                            <i class="fa-solid fa-trash text-current text-xs"></i>
                                        </button>
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
            <!-- Form -->
            <div class="flex flex-col items-center justify-start rounded-2xl bg-white px-4 shadow-md border-2 border-gray-200 space-y-2 h-full">
                <div id="crud-title" class="w-full text-left font-semibold text-2xl border-b-2 border-gray-200 py-3">THÊM MỚI THỂ LOẠI</div>
                <form action="" id="crud-form" class="w-full h-full flex flex-col items-center justify-between space-y-4 px-2">
                    <div class="w-full h-1/2 flex flex-col items-center space-y-4">
                        <div class="w-full space-y-1 text-black">
                            <label for="name-input" class="font-medium">Name</label>
                            <input type="text" name="name-input" id="name-input" placeholder="" class="p-2 border-2 border-gray-500 focus:outline-none focus:border-indigo-700 rounded w-full">
                        </div>
                        <div class="w-full h-full space-y-1 text-black">
                            <label for="description-input" class="font-medium">Description</label>
                            <textarea name="description-input" id="description-input" class="resize-none p-2 border-2 border-gray-500 focus:outline-none focus:border-indigo-700 rounded w-full h-full"></textarea>
                        </div>
                    </div>
                    <div class="w-full flex flex-row items-center justify-center border-t-2 border-gray-200 py-3 space-x-8">
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
                            <div>Quay Về Thêm Mới</div>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    //Charts Container
    var statisticContainer = document.getElementById('statistic-container');

    //Charts
    var statisticChart = echarts.init(statisticContainer);

    //Options
    var statisticOptions = {
        tooltip: {
            trigger: 'item'
        },
        legend: {
            top: '5%',
            left: 'center'
        },
        series: [
        {
            name: 'Access From',
            type: 'pie',
            radius: ['40%', '70%'],
            avoidLabelOverlap: false,
            label: {
                show: false,
                position: 'center'
            },
            emphasis: {
                label: {
                show: true,
                fontSize: 40,
                fontWeight: 'bold'
                }
            },
            labelLine: {
                show: false
            },
            data: [
                { value: 1048, name: 'Search Engine' },
                { value: 735, name: 'Direct' },
                { value: 580, name: 'Email' },
                { value: 484, name: 'Union Ads' },
                { value: 300, name: 'Video Ads' }
            ]
        }]
    };

    //Add Options
    statisticChart.setOption(statisticOptions);

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

    //CRUD Form
    $(document).ready(function () 
    {
        //Edit Button
        $('.edit-button').on('click', function (e) 
        {
            e.preventDefault();

            const id = $(this).data('id');
            const name = $(this).data('name');
            const description = $(this).data('description');

            $('#crud-title').text('SỬA LẠI THỂ LOẠI');
            $('#name-input').val(name);
            $('#description-input').val(description);

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
            $('#content-confirmDialog').html('Bạn có chắc chắn muốn xóa thể loại ' + name + ' này không?');
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

            $('#crud-title').text('THÊM MỚI THỂ LOẠI');
            $('#name-input').val('');
            $('#description-input').val('');

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

@endsection