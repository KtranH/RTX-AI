@extends('Admin.Container')
@section('Content')

<title>RTX-ADMIN: Hình Ảnh</title>

<div class="w-full h-full flex flex-col justify-between space-y-4 p-2 divide-y-4 divide-indigo-700 cursor-default">
    <!-- Header -->
    <div class="h-10 py-2 px-8 flex items-center text-2xl font-bold">HÌNH ẢNH</div>
    <!-- Content -->
    <div class="h-full overflow-y-auto p-2 scroll-smooth">
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
                <!-- Display -->
                <div class="w-full h-[730px] table-fixed overflow-auto pr-4">
                    <div class="grid grid-cols-4 gap-3 py-3">
                        @for($i = 0; $i < 15; $i++)
                            <div class="display-component group relative w-full h-full cursor-pointer" data-id="{{$i}}" data-image="{{"https://picsum.photos/id/" . $i * 10 . "/200"}}" data-quantity="{{$i}}">
                                <img src="https://picsum.photos/id/{{$i * 10}}/200" alt="Image" class="image-display w-full h-full rounded-2xl border-2 border-gray-200 group-hover:!opacity-50">
                                <div class="count-display absolute -top-3 -right-3 rounded-full w-8 h-8 flex items-center justify-center bg-orange-700 text-white font-medium border-2 border-gray-200 group-hover:!bg-indigo-700">{{$i}}</div>
                            </div>
                        @endfor
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
                <!-- Form -->
                <div class="row-span-4 flex flex-col items-center justify-between rounded-2xl bg-white px-4 shadow-md border-2 border-gray-200 space-y-2">
                    <div class="w-full text-left font-semibold text-2xl border-b-2 border-gray-200 py-3">THÔNG TIN BÁO CÁO</div>
                    <div class="w-full flex flex-col items-center justify-start space-y-4 px-2">
                        <img id="image-approvalForm" src="https://picsum.photos/id/237/200" alt="Image" class="w-1/2 aspect-square rounded-2xl border-2 border-gray-200 cursor-pointer">
                        <div class="w-full space-y-1 text-black">
                            <label for="quantity-approvalForm" class="font-medium">Số Lượng</label>
                            <input type="number" name="quantity-approvalForm" id="quantity-approvalForm" disabled placeholder="" class="p-2 border-2 border-gray-500 focus:outline-none focus:border-indigo-700 rounded w-full">
                        </div>
                        <div class="w-full space-y-1 text-black">
                            <label for="content-approvalForm" class="font-medium">Nội Dung</label>
                            <textarea name="content-approvalForm" id="content-approvalForm" disabled class="resize-none p-2 border-2 border-gray-500 focus:outline-none focus:border-indigo-700 rounded w-full"></textarea>
                        </div>
                    </div>
                    <div class="w-full flex flex-row items-center justify-center border-t-2 border-gray-200 py-3 space-x-8">
                        <button type="submit" id="approve-button" class="flex flex-row items-center space-x-2 bg-green-700 border-2 border-green-700 hover:bg-white hover:!text-green-700 rounded px-3 py-1 text-white text-lg font-medium">
                            <i class="fa-solid fa-circle-check text-current"></i>
                            <div>Tán Thành</div>
                        </button>
                        <button type="button" id="disapprove-button" class="flex flex-row items-center space-x-2 bg-red-700 border-2 border-red-700 hover:bg-white hover:!text-red-700 rounded px-3 py-1 text-white text-lg font-medium">
                            <i class="fa-solid fa-xmark text-current"></i>
                            <div>Không Tán Tành</div>
                        </button>
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

    //Display
    $(document).ready(function () 
    {
        $('.display-component').on('click', function (e) 
        {
            e.preventDefault();

            const id = $(this).data('id');
            const image = $(this).data('image');
            const quantity = $(this).data('quantity');

            $('#image-approvalForm').attr('src', image);
            $('#quantity-approvalForm').val(quantity);

            $('.image-display').removeClass('border-indigo-700');
            $('.count-display').removeClass('bg-indigo-700');

            $(this).find('.image-display').addClass('border-4 border-indigo-700');
            $(this).find('.count-display').addClass('bg-indigo-700');
        });
    });

    //Form
    $(document).ready(function () 
    {
        $('#image-approvalForm').on('click', function (e) 
        {
            e.preventDefault();

            const image = $(this).attr('src');

            $('#image-dialog').removeClass('hidden');
            $('#image-imageDialog').attr('src', image);
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