@extends('Admin.Container')
@section('Content')

<title>RTX-ADMIN: Nhân Viên</title>

<div class="w-full h-full flex flex-col justify-between space-y-4 p-2 divide-y-4 divide-indigo-700 cursor-default">
    <!-- Header -->
    <div class="h-10 py-2 px-8 flex items-center text-2xl font-bold">BÌNH LUẬN</div>
    <!-- Content -->
    <div class="h-full overflow-hidden p-2">
        <!-- CRUD -->
        <div class="grid grid-cols-3 h-full space-x-4 p-2">
            <!-- Approve -->
            <div class="col-span-2 flex flex-col items-center justify-start rounded-2xl bg-white px-4 shadow-md border-2 border-gray-200 space-y-2 h-full">
                <!-- Header -->
                <div class="w-full flex flex-row items-center justify-between border-b-2 border-gray-200 py-2.5">
                    <div class="font-semibold text-2xl text-left">DUYỆT BÁO CÁO</div>
                    <div class="flex flex-row items-center justify-end space-x-4">
                        <!-- Date -->
                        <form action="" id="date-form" class="w-72 text-black">
                            <input type="date" id="search-input" class="w-full p-2 border-2 border-gray-500 focus:outline-none focus:border-indigo-700 rounded w-full" placeholder="Nhập tìm kiếm...">
                        </form>
                        <!-- Search -->
                        <form action="" id="search-form" class="relative w-72 text-black">
                            <i id="search-icon" class="fa-solid fa-magnifying-glass absolute inset-y-0 start-0 flex items-center pl-3 cursor-pointer text-current hover:text-indigo-700"></i>
                            <input type="text" id="search-input" class="w-full py-2 px-10 border-2 border-gray-500 focus:outline-none focus:border-indigo-700 rounded w-full" placeholder="Nhập tìm kiếm...">
                            <i id="clear-icon" class="hidden fa-solid fa-xmark absolute inset-y-0 end-0 flex items-center pr-3 cursor-pointer text-current hover:text-indigo-700"></i>
                        </form>
                    </div>
                </div>
                <!-- Table -->
                <div class="w-full h-[679px] table-fixed overflow-auto pr-2">
                    <table class="relative w-full table-fixed border-collapse border-x-2">
                        <thead class="sticky top-0 bg-gray-200">
                            <tr class="text-center">
                                <th class="w-1/12 p-3">ID</th>
                                <th class="w-1/12">Avatar</th>
                                <th class="w-2/12">Username</th>
                                <th class="w-4/12">Content</th>
                                <th class="w-2/12">Time</th>
                                <th class="w-2/12">Action</th>
                            </tr>
                        </thead>
                        <tbody class="align-top">
                            @for($i = 0; $i < 150; $i++)
                                <tr class="even:bg-gray-100 hover:bg-indigo-200 border-b-2">
                                    <td class="p-1 text-center align-middle">{{$i}}</td>
                                    <td class="px-1 pt-2 flex items-center justify-center h-[85.14px]"><img src="https://picsum.photos/id/{{$i + 10}}/200" alt="" class="image-table cursor-pointer w-3/4 aspect-square rounded-full border-2 border-gray"></td>
                                    <td class="p-1 text-center align-middle">ABC</td>
                                    <td class="p-1 align-middle truncate hover:overflow-visible hover:whitespace-normal hover:text-ellipsis text-justify">Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatum voluptas esse incidunt deleniti voluptate error itaque, unde sed obcaecati corrupti expedita? Corporis quos placeat earum error similique itaque aperiam amet?</td>
                                    <td class="p-1 text-center align-middle">ABC</td>
                                    <td class="p-1">
                                        <div class="flex flex-row items-center justify-center space-x-2 w-full h-[85.14px]">
                                            <button data-id="{{$i}}" data-name="{{'ABC'}}" class="approve-button flex items-center bg-green-700 border-2 border-green-700 hover:bg-white hover:!text-green-700 rounded p-2 text-white text-lg font-medium">
                                                <i class="fa-solid fa-check-circle text-current text-normal"></i>
                                            </button>
                                            <button data-id="{{$i}}" data-name="{{'ABC'}}" class="disapprove-button flex items-center bg-red-700 border-2 border-red-700 hover:bg-white hover:!text-red-700 rounded p-2 text-white text-lg font-medium">
                                                <i class="fa-solid fa-circle-xmark text-current text-normal"></i>
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
                        <div class="flex items-center justify-center bg-red-600 rounded-full py-3 px-[22.265px]">
                            <i class="fa-solid fa-hourglass-half text-[50px] text-white"></i>
                        </div>
                    </div>
                    <div class="basis-3/4 text-center">
                        <div class="font-medium text-lg">SỐ BÀI CẦN DUYỆT</div>
                        <div class="text-3xl">12</div>
                    </div>
                </div>   
                <!-- Cute Dog -->
                <div class="row-span-4 flex flex-col items-center justify-start rounded-2xl bg-white px-4 shadow-md border-2 border-gray-200 space-y-2">
                    <div class="w-full text-left font-semibold text-2xl border-b-2 border-gray-200 py-3">CHÚ CÚN ĐÁNG YÊU</div>
                    <div class="flex items-center justify-center w-full h-full">
                        <img src="https://picsum.photos/id/237/200" alt="Cute Dog" class="rounded-full w-3/4 aspect-square border border-gray-400">
                    </div>
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

    //Table
    $(document).ready(function () 
    {
        $('.image-table').on('click', function (e) 
        {
            e.preventDefault();

            const image = $(this).attr('src');

            $('#image-dialog').removeClass('hidden');
            $('#image-imageDialog').attr('src', image);

            
        });

        //Approve Button
        $('.approve-button').on('click', function (e) 
        {
            e.preventDefault();

            const id = $(this).data('id');
            const name = $(this).data('name');

            SetNotificationDialog('success', name)
        });

        //Disapprove Button
        $('.disapprove-button').on('click', function (e) 
        {
            e.preventDefault();

            const id = $(this).data('id');
            const name = $(this).data('name');

            SetNotificationDialog('success', name)
        });
    });
</script>

@endsection