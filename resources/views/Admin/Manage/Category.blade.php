@extends('Admin.Container')
@section('Content')

<title>RTX-ADMIN: Thể Loại</title>

<div class="w-full h-full flex flex-col justify-between space-y-4 p-2 divide-y-4 divide-indigo-700 cursor-default">
    <!-- Header -->
    <div class="h-10 py-2 px-8 flex items-center text-2xl font-bold">THỂ LOẠI</div>
    <!-- Content -->
    <div class="h-full overflow-y-auto p-2 space-y-4 snap-y snap-mandatory scroll-smooth">
        <!-- Charts -->
        <div class="grid grid-cols-2 h-full space-x-4 p-2 snap-start snap-always">
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
                        <div class="text-3xl" id="count-category">{{ $countCategory }}</div>
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
                        <div class="text-3xl">{{ $mostPreferredCategory->name }}</div>
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
                        <div class="text-3xl">{{ $leastPhotosCategory->name }} ({{ $leastPhotosCategory->photos_count }} ảnh)</div>
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
                        <div class="text-3xl">{{ $mostPhotosCategory->name }} ({{ $mostPhotosCategory->photos_count }} ảnh)</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- CRUD -->
        <div class="grid grid-cols-3 h-full space-x-4 p-2 snap-start snap-always">
            <!-- Table -->
            <div class="col-span-2 flex flex-col items-center justify-between rounded-2xl bg-white px-4 shadow-md border-2 border-gray-200 space-y-2 h-full">
                <!-- Header -->
                <div class="w-full flex flex-row items-center justify-between border-b-2 border-gray-200 py-2.5">
                    <div class="font-semibold text-2xl text-left">DANH SÁCH THỂ LOẠI</div>
                    <!-- Search -->
                    <form action="" id="search-form" class="relative w-72 text-black">
                        <i id="search-icon" class="fa-solid fa-magnifying-glass absolute inset-y-0 start-0 flex items-center pl-3 cursor-pointer text-current hover:text-indigo-700"></i>
                        <input type="text" id="search-input" class="w-full py-2 px-10 border-2 border-gray-500 focus:outline-none focus:border-indigo-700 rounded w-full" placeholder="Nhập tìm kiếm...">
                        <i id="clear-icon" class="hidden fa-solid fa-xmark absolute inset-y-0 end-0 flex items-center pr-3 cursor-pointer text-current hover:text-indigo-700"></i>
                    </form>
                    <script>
                        $(document).ready(function() {
                            // Xử lý tìm kiếm
                            $('#search-form').on('submit', function(e) {
                                e.preventDefault();
                                performSearch(1);
                            });

                            // Xử lý phân trang Ajax
                            $(document).on('click', '.pagination a', function(e) {
                                e.preventDefault();
                                var page = $(this).attr('href').split('page=')[1];
                                performSearch(page);
                            });

                            // Hàm thực hiện tìm kiếm
                            function performSearch(page) {
                                var searchTerm = $('#search-input').val();
                                
                                $.ajax({
                                    url: '{{ route("admin.searchcategory") }}',
                                    method: 'GET',
                                    data: {
                                        search: searchTerm,
                                        page: page
                                    },
                                    success: function(response) {
                                        // Cập nhật bảng
                                        $('tbody').replaceWith(response.table_html);
                                        
                                        // Cập nhật phân trang
                                        $('.pagination').replaceWith(response.pagination_html);
                                    },
                                    error: function(xhr) {
                                        console.error('Lỗi tìm kiếm:', xhr.responseText);
                                        alert('Có lỗi xảy ra khi tìm kiếm');
                                    }
                                });
                            }

                            // Xử lý icon xóa tìm kiếm
                            $('#clear-icon').on('click', function() {
                                $('#search-input').val('');
                                performSearch(1); // Reload danh sách ban đầu
                            });

                            // Hiển thị/ẩn icon xóa
                            $('#search-input').on('input', function() {
                                $('#clear-icon').toggleClass('hidden', $(this).val().length === 0);
                            });
                        });
                    </script>
                </div>
                <!-- Table -->
                <div class="w-full h-[700px] table-fixed overflow-auto pr-2">
                    <table class="relative w-full table-fixed border-collapse border-x-2">
                        <thead class="sticky top-0 bg-gray-200">
                            <tr class="text-center">
                                <th class="w-1/12 p-3">ID</th>
                                <th class="w-2/12">Tên thể loại</th>
                                <th class="w-7/12">Mô tả</th>
                                <th class="w-2/12">Hành động</th>
                            </tr>
                        </thead>
                        <tbody class="align-top">
                            @foreach ($allCategory as $item)
                                <tr class="even:bg-gray-100 hover:bg-indigo-200 border-b-2">
                                    <td class="p-1 text-center align-middle">{{$item->id}}</td>
                                    <td class="p-1 text-center align-middle">{{ $item->name }}</td>
                                    <td class="p-1 align-middle truncate hover:overflow-visible hover:whitespace-normal hover:text-ellipsis text-justify">{{ $item->description }}</td>
                                    <td class="flex flex-row items-center justify-center space-x-2 p-1">
                                        <button data-id="{{$item->id}}" data-name="{{$item->name}}" data-description="{{$item->description}}" class="edit-button flex items-center bg-yellow-700 border-2 border-yellow-700 hover:bg-white hover:!text-yellow-700 rounded p-2 text-white text-lg font-medium">
                                            <i class="fa-solid fa-pen text-current text-xs"></i>
                                        </button>
                                        <button data-id="{{$item->id}}" data-name="{{$item->name}}" data-description="{{$item->description}}" class="delete-button flex items-center bg-red-700 border-2 border-red-700 hover:bg-white hover:!text-red-700 rounded p-2 text-white text-lg font-medium">
                                            <i class="fa-solid fa-trash text-current text-xs"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                <div class="mt-2 mb-4">
                    {{ $allCategory->links('vendor.pagination.tailwind') }}
                </div>
            </div>
            <!-- Form -->
            <div class="flex flex-col items-center justify-start rounded-2xl bg-white px-4 shadow-md border-2 border-gray-200 space-y-2 h-full">
                <div id="crud-title" class="w-full text-left font-semibold text-2xl border-b-2 border-gray-200 py-3">THÊM MỚI THỂ LOẠI</div>
                <form action="" method="POST" id="crud-form" class="w-full h-full flex flex-col items-center justify-between space-y-4 px-2">
                    @csrf
                    <div class="w-full h-1/2 flex flex-col items-center space-y-4">
                        <div class="w-full space-y-1 text-black">
                            <label for="name-input" class="font-medium">Tên thể loại</label>
                            <input type="text" name="name-input" id="name-input" required placeholder="Nhập tên thể loại..." class="p-2 border-2 border-gray-500 focus:outline-none focus:border-indigo-700 rounded w-full">
                        </div>
                        <div class="w-full h-full space-y-1 text-black">
                            <label for="description-input" class="font-medium">Mô tả</label>
                            <textarea name="description-input" id="description-input" required class="resize-none p-2 border-2 border-gray-500 focus:outline-none focus:border-indigo-700 rounded w-full h-full"></textarea>
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
                <script>
                    $(document).ready(function() {
                        //Function delete 
                        function deleteCategory(id, row) {
                            Swal.fire({
                                icon: 'question',
                                title: 'XÓA THỂ LOẠI',
                                text: 'Bạn có chắc muốn xóa thể loại này không?',
                                showCancelButton: true,
                                confirmButtonText: 'Xác Nhận',
                                cancelButtonText: 'Hủy Bỏ',
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                reverseButtons: true
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $.ajax({
                                        url: "/admin/deletecategory",
                                        type: "DELETE",
                                        data: {
                                            id: id,
                                            _token: "{{ csrf_token() }}"
                                        },
                                        success: function(response) {
                                            if(response.success) {
                                                Swal.fire({
                                                    icon: 'success',
                                                    iconColor: 'white',
                                                    title: 'Đã xoá thể loại',
                                                    color: 'white',
                                                    showConfirmButton: false,
                                                    timer: 3000,
                                                    toast: true,
                                                    position: 'bottom-left',
                                                    background: '#46DFB1'
                                                });
                                                row.remove(); 
                                            }
                                        },
                                        error: function(response) {
                                                console.log(response);
                                                Swal.fire({
                                                    icon: 'error',
                                                    iconColor: 'white',
                                                    title: 'Có lỗi xảy ra. Vui lòng thử lại sau.',
                                                    color: 'white',
                                                    showConfirmButton: false,
                                                    timer: 3000,
                                                    toast: true,
                                                    position: 'bottom-left',
                                                    background: '#F04770'
                                                }); 
                                            }
                                        }
                                    );
                                }
                            })
                        }
                        //Delete Button
                        $('.delete-button').click(function(e) {
                            let id = $(this).data('id');
                            let row = $(this).closest('tr');
                            let countCategory = $('#count-category').text();
                            e.preventDefault();
                            deleteCategory(id, row);
                            countCategory = parseInt(countCategory) - 1;
                            $('#count-category').text(countCategory);
                        })
                        //Insert Button
                        $('#insert-button').click(function(e) {
                            e.preventDefault();
                            let countCategory = $('#count-category').text();
                            Swal.fire({
                                icon: 'question',
                                title: 'THÊM MỚI THỂ LOẠI',
                                text: 'Bạn có chắc muốn thêm mới thể loại không?',
                                showCancelButton: true,
                                confirmButtonText: 'Xác Nhận',
                                cancelButtonText: 'Hủy Bỏ',
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                reverseButtons: true
                            }).then((result) => {
                                if (result.isConfirmed) {
                                   let name = $('#name-input').val();
                                   let description = $('#description-input').val();
                                   $.ajax({
                                       url: "/admin/addcategory",
                                       type: "POST",
                                       data: {
                                           name: name,
                                           description: description,
                                           _token: "{{ csrf_token() }}"
                                       },
                                       success: function(response) {
                                            if(response.success) {
                                                let newRow = `
                                                <tr class="even:bg-gray-100 hover:bg-indigo-200 border-b-2">
                                                    <td class="p-1 text-center align-middle">${response.category.id}</td>
                                                    <td class="p-1 text-center align-middle">${response.category.name}</td>
                                                    <td class="p-1 align-middle truncate hover:overflow-visible hover:whitespace-normal hover:text-ellipsis text-justify">${response.category.description}</td>
                                                    <td class="flex flex-row items-center justify-center space-x-2 p-1">
                                                        <button data-id="${response.category.id}" data-name="${response.category.name}" data-description="${response.category.description}" class="edit-button flex items-center bg-yellow-700 border-2 border-yellow-700 hover:bg-white hover:!text-yellow-700 rounded p-2 text-white text-lg font-medium">
                                                            <i class="fa-solid fa-pen text-current text-xs"></i>
                                                        </button>
                                                        <button data-id="${response.category.id}" data-name="${response.category.name}" data-description="${response.category.description}" class="delete-button flex items-center bg-red-700 border-2 border-red-700 hover:bg-white hover:!text-red-700 rounded p-2 text-white text-lg font-medium">
                                                            <i class="fa-solid fa-trash text-current text-xs"></i>
                                                        </button>
                                                    </td>
                                                </tr>`;

                                            $('table tbody').prepend(newRow);

                                            $('.delete-button').off('click').on('click', function(e) {
                                                let id = $(this).data('id');
                                                let row = $(this).closest('tr');
                                                e.preventDefault();
                                                deleteCategory(id, row);
                                            });

                                            $('.edit-button').off('click').on('click', function(e) {
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
                                            Swal.fire({
                                                icon: 'success',
                                                iconColor: 'white',
                                                title: 'Thành công',
                                                text: 'Thêm mới thể loại thành công',
                                                color: 'white',
                                                showConfirmButton: false,
                                                timer: 3000,
                                                toast: true,
                                                position: 'bottom-left',
                                                background: '#46DFB1'
                                            });

                                            countCategory = parseInt(countCategory) + 1;
                                            $('#count-category').text(countCategory);

                                            } else {
                                                Swal.fire({
                                                    icon: 'error',
                                                    iconColor: 'white',
                                                    title: 'Có lỗi xảy ra',
                                                    text: response.message,
                                                    color: 'white',
                                                    showConfirmButton: false,
                                                    timer: 3000,
                                                    toast: true,
                                                    position: 'bottom-left',
                                                    background: '#F04770'
                                                });
                                            }
                                        },
                                        error: function () {
                                            Swal.fire('Lỗi', 'Đã xảy ra lỗi, vui lòng thử lại!', 'error');
                                        },
                                   })
                                }
                            })        
                        });
                    })
                </script>
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
                @foreach($randomCategory as $category)
                    { value: {{ $category->photos_count }}, name: '{{ $category->name }}' },
                @endforeach
            ]
        }]
    };

    //Add Options
    statisticChart.setOption(statisticOptions);
    //Form
    $(document).ready(function () 
    {
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

@endsection