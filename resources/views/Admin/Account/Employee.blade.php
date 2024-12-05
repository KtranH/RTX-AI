@extends('Admin.Container')
@section('Content')
    <title>
        RTX-ADMIN: Nhân Viên</title>
    <div class="w-full h-full flex flex-col justify-between space-y-4 p-2 divide-y-4 divide-indigo-700 cursor-default">
        <!-- Header -->
        <div class="h-10 py-2 px-8 flex items-center text-2xl font-bold">NHÂN VIÊN</div>
        <!-- Content -->
        <div class="h-full overflow-hidden p-2">
            <!-- CRUD -->
            <div class="grid grid-cols-3 h-full space-x-4 p-2">
                <!-- Table -->
                <div
                    class="col-span-2 flex flex-col items-center justify-between rounded-2xl bg-white px-4 shadow-md border-2 border-gray-200 space-y-2 h-full">
                    <!-- Header -->
                    <div class="w-full flex flex-row items-center justify-between border-b-2 border-gray-200 py-2.5">
                        <div class="font-semibold text-2xl text-left">DANH SÁCH NHÂN VIÊN</div>
                        <!-- Search -->
                        <form action="" id="search-form" class="relative w-72 text-black">
                            <i id="search-icon"
                                class="fa-solid fa-magnifying-glass absolute inset-y-0 start-0 flex items-center pl-3 cursor-pointer text-current hover:text-indigo-700"></i>
                            <input type="text" id="search-input"
                                class="w-full py-2 px-10 border-2 border-gray-500 focus:outline-none focus:border-indigo-700 rounded w-full"
                                placeholder="Nhập tìm kiếm...">
                            <i id="clear-icon"
                                class="hidden fa-solid fa-xmark absolute inset-y-0 end-0 flex items-center pr-3 cursor-pointer text-current hover:text-indigo-700"></i>
                        </form>
                        <script>
                            $(document).ready(function() {
                                $('#search-form').on('submit', function(e) {
                                    e.preventDefault();
                                    performSearch(1);
                                });

                                $(document).on('click', '.pagination a', function(e) {
                                    e.preventDefault();
                                    var page = $(this).attr('href').split('page=')[1];
                                    performSearch(page);
                                });

                                function performSearch(page) {
                                    var searchTerm = $('#search-input').val();

                                    $.ajax({
                                        url: '{{ route('admin.searchemployee') }}',
                                        method: 'GET',
                                        data: {
                                            search: searchTerm,
                                            page: page
                                        },
                                        success: function(response) {
                                            $('tbody').replaceWith(response.table_html);

                                            $('.pagination').replaceWith(response.pagination_html);
                                        },
                                        error: function(xhr) {
                                            console.error('Lỗi tìm kiếm:', xhr.responseText);
                                            alert('Có lỗi xảy ra khi tìm kiếm');
                                        }
                                    });
                                }

                                $('#clear-icon').on('click', function() {
                                    $('#search-input').val('');
                                    performSearch(1);
                                });

                                $('#search-input').on('input', function() {
                                    $('#clear-icon').toggleClass('hidden', $(this).val().length === 0);
                                });
                            });
                        </script>
                    </div>
                    <!-- Table -->
                    <div class="w-full h-[679px] table-fixed overflow-auto pr-2">
                        <table class="relative w-full table-fixed border-collapse border-x-2">
                            <thead class="sticky top-0 bg-gray-200">
                                <tr class="text-center">
                                    <th class="w-1/12">ID</th>
                                    <th class="w-1/12">Avatar</th>
                                    <th class="w-2/12">Username</th>
                                    <th class="w-2/12">Email</th>
                                    <th class="w-2/12">Tình trạng</th>
                                    <th class="w-1/12">Ngày Tạo</th>
                                    <th class="w-1/12">Chức vụ</th>
                                    <th class="w-2/12">Action</th>
                                </tr>
                            </thead>
                            <tbody class="align-top">
                                @foreach ($listEmployee as $item)
                                    <tr class="even:bg-gray-100 hover:bg-indigo-200 border-b-2">
                                        <td class="p-1 text-center align-middle" id="id-table">{{ $item->id }}</td>
                                        <td class="px-1 pt-2 flex items-center justify-center h-[85.14px]"><img
                                                src="{{ $item->avatar_url }}" alt=""
                                                class="image-table cursor-pointer w-3/4 aspect-square rounded-full border-2 border-gray">
                                        </td>
                                        <td class="p-1 text-center align-middle" id="username-table">{{ $item->username }}
                                        </td>
                                        <td class="p-1 text-center align-middle" id="email-table">{{ $item->email }}</td>
                                        <td class="p-1 text-center align-middle">
                                            @if ($item->is_deleted == 1)
                                                <span id="status-account"
                                                    class="text-red-700 truncate hover:overflow-visible hover:whitespace-normal hover:text-ellipsis">Đã
                                                    khóa</span>
                                            @else
                                                <span id="status-account"
                                                    class="text-green-700 text-bold truncate hover:overflow-visible hover:whitespace-normal hover:text-ellipsis">Hoạt
                                                    động</span>
                                            @endif
                                        </td>
                                        <td class="p-1 text-center align-middle">
                                            {{ Date('d/m/Y', strtotime($item->created_at)) }}</td>
                                        <td class="p-1 text-center align-middle">{{ $item->adminRole->role_name }}</td>
                                        <td class="p-1">
                                            <div
                                                class="flex flex-row items-center justify-center space-x-2 w-full h-[85.14px]">
                                                <button data-id="{{ $item->id }}" data-name="{{ $item->username }}"
                                                    data-email="{{ $item->email }}"
                                                    class="edit-button flex items-center bg-yellow-700 border-2 border-yellow-700 hover:bg-white hover:!text-yellow-700 rounded p-2 text-white text-lg font-medium">
                                                    <i class="fa-solid fa-pen text-current text-xs"></i>
                                                </button>
                                                @if ($item->is_deleted == 1)
                                                    <button data-id="{{ $item->id }}"
                                                        class="unlock-button flex items-center bg-green-700 border-2 border-green-700 hover:bg-white hover:!text-green-700 rounded p-2 text-white text-lg font-medium">
                                                        <i class="fa-solid fa-unlock text-current text-xs"></i>
                                                    </button>
                                                    <button data-id="{{ $item->id }}"
                                                        class="hidden lock-button flex items-center bg-orange-700 border-2 border-orange-700 hover:bg-white hover:!text-orange-700 rounded p-2 text-white text-lg font-medium">
                                                        <i class="lock-icon fa-solid fa-lock text-current text-xs"></i>
                                                    </button>
                                                @else
                                                    <button data-id="{{ $item->id }}"
                                                        class="lock-button flex items-center bg-orange-700 border-2 border-orange-700 hover:bg-white hover:!text-orange-700 rounded p-2 text-white text-lg font-medium">
                                                        <i class="lock-icon fa-solid fa-lock text-current text-xs"></i>
                                                    </button>
                                                    <button data-id="{{ $item->id }}"
                                                        class="hidden unlock-button flex items-center bg-green-700 border-2 border-green-700 hover:bg-white hover:!text-green-700 rounded p-2 text-white text-lg font-medium">
                                                        <i class="fa-solid fa-unlock text-current text-xs"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- Pagination -->
                    <div class="mt-2 mb-4">
                        {{ $listEmployee->links('vendor.pagination.tailwind') }}
                    </div>
                </div>
                <div class="grid grid-rows-5 space-y-4">
                    <!-- Quick Information -->
                    <div
                        class="flex flex-row items-center justify-between rounded-2xl bg-white py-2 px-4 shadow-md border-2 border-gray-200">
                        <div class="basis-1/4 flex items-center justify-center">
                            <div class="flex items-center justify-center bg-yellow-600 rounded-full py-3 px-[16px]">
                                <i class="fa-solid fa-briefcase text-[50px] text-white"></i>
                            </div>
                        </div>
                        <div class="basis-3/4 text-center">
                            <div class="font-medium text-lg">SỐ LƯỢNG NHÂN VIÊN</div>
                            <div class="text-3xl" id="count-employee">{{ $countEmployee }}</div>
                        </div>
                    </div>
                    <div
                        class="flex flex-row items-center justify-between rounded-2xl bg-white py-2 px-4 shadow-md border-2 border-gray-200">
                        <div class="basis-1/4 flex items-center justify-center">
                            <div class="flex items-center justify-center bg-red-600 rounded-full py-3 px-[19.13px]">
                                <i class="fa-solid fa-lock text-[50px] text-white"></i>
                            </div>
                        </div>
                        <div class="basis-3/4 text-center">
                            <div class="font-medium text-lg">SỐ LƯỢNG NHÂN VIÊN BỊ KHÓA</div>
                            <div class="text-3xl" id="count-deleted-employee">{{ $countEmployeeDeleted }}</div>
                        </div>
                    </div>
                    <!-- Form -->
                    <div
                        class="row-span-3 flex flex-col items-center justify-start rounded-2xl bg-white px-4 shadow-md border-2 border-gray-200 space-y-2">
                        <div id="crud-title"
                            class="w-full text-left font-semibold text-2xl border-b-2 border-gray-200 py-3">THÊM MỚI NHÂN
                            VIÊN</div>
                        <form action="" id="crud-form"
                            class="w-full h-full flex flex-col items-center justify-between space-y-4 px-2">
                            <div class="w-full flex flex-col items-center space-y-4">
                                <div class="w-full space-y-1 text-black">
                                    <label for="id-input" class="font-medium">ID</label>
                                    <input type="text" name="id-input" id="id-input" disabled placeholder=""
                                        class="p-2 border-2 border-gray-500 focus:outline-none focus:border-indigo-700 rounded w-full">
                                </div>
                                <div class="w-full space-y-1 text-black">
                                    <label for="username-input" class="font-medium">Username</label>
                                    <input type="text" name="username-input" id="username-input" placeholder=""
                                        class="p-2 border-2 border-gray-500 focus:outline-none focus:border-indigo-700 rounded w-full">
                                </div>
                                <div class="w-full space-y-1 text-black">
                                    <label for="email-input" class="font-medium">Email</label>
                                    <input type="email" name="email-input" id="email-input" placeholder=""
                                        class="p-2 border-2 border-gray-500 focus:outline-none focus:border-indigo-700 rounded w-full">
                                </div>
                            </div>
                            <div
                                class="w-full flex flex-row items-center justify-center border-t-2 border-gray-200 py-3 space-x-2">
                                <button type="submit" id="insert-button"
                                    class="flex flex-row items-center space-x-2 bg-indigo-700 border-2 border-indigo-700 hover:bg-white hover:!text-indigo-700 rounded px-3 py-1 text-white text-lg font-medium">
                                    <i class="fa-solid fa-plus text-current"></i>
                                    <div>Thêm Mới</div>
                                </button>
                                <button type="submit" id="update-button"
                                    class="hidden flex flex-row items-center space-x-2 bg-yellow-700 border-2 border-yellow-700 hover:bg-white hover:!text-yellow-700 rounded px-3 py-1 text-white text-lg font-medium">
                                    <i class="fa-solid fa-pen text-current"></i>
                                    <div>Sửa Lại</div>
                                </button>
                                <button type="button" id="reset-button"
                                    class="flex flex-row items-center space-x-2 bg-green-700 border-2 border-green-700 hover:bg-white hover:!text-green-700 rounded px-3 py-1 text-white text-lg font-medium">
                                    <i class="fa-solid fa-rotate text-current"></i>
                                    <div>Làm Mới</div>
                                </button>
                                <button type="button" id="return-button"
                                    class="hidden flex flex-row items-center space-x-2 bg-indigo-700 border-2 border-indigo-700 hover:bg-white hover:!text-indigo-700 rounded px-3 py-1 text-white text-lg font-medium">
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
        $(document).ready(function() {
            $('#search-input').on('input', function() {
                if ($(this).val().length > 0) {
                    $('#clear-icon').removeClass('hidden');
                    console.log("a");
                } else {
                    $('#clear-icon').addClass('hidden');
                }
            });

            $('#clear-icon').on('click', function() {
                $('#search-input').val('');
                $('#clear-icon').addClass('hidden');
            });
        });

        //Table && form
        $(document).ready(function() {
            //Edit function
            function editEmployee(id, name, email) {
                $('#crud-title').text('SỬA LẠI NHÂN VIÊN');

                $('#id-input').val(id);
                $('#username-input').val(name);
                $('#email-input').val(email);

                $('#insert-button').addClass('hidden');
                $('#update-button').removeClass('hidden');
                $('#return-button').removeClass('hidden');
            }

            //Return function
            function returnEmployee(id, row) {
                Swal.fire({
                    icon: 'warning',
                    title: "Mở khóa nhân viên",
                    text: "Bạn có muốn mở khóa nhân viên này không?",
                    showCancelButton: true,
                    confirmButtonText: "Xác nhận",
                    cancelButtonText: "Hủy",
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {

                        $.ajax({
                            url: "{{ route('admin.activeemployee') }}",
                            method: "PUT",
                            data: {
                                id: id,
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(respone) {
                                if (respone.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        iconColor: 'white',
                                        title: 'Đã mở khóa nhân viên',
                                        text: respone.message,
                                        color: 'white',
                                        showConfirmButton: false,
                                        timer: 3000,
                                        toast: true,
                                        position: 'bottom-left',
                                        background: '#46DFB1'
                                    });

                                    row.find('#status-account').text('Hoạt động');
                                    row.find('#status-account').removeClass('text-red-700');
                                    row.find('#status-account').addClass('text-green-700');

                                    const countDeletedEmployee = parseInt($(
                                        '#count-deleted-employee').text());
                                    $('#count-deleted-employee').text(countDeletedEmployee - 1);

                                    row.find('.unlock-button').addClass('hidden');
                                    row.find('.lock-button').removeClass('hidden');


                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        iconColor: 'white',
                                        title: 'Có lỗi xảy ra',
                                        text: respone.message,
                                        color: 'white',
                                        showConfirmButton: false,
                                        timer: 3000,
                                        toast: true,
                                        position: 'bottom-left',
                                        background: '#F04770'
                                    });
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error(xhr.responseText);
                                swal.fire({
                                    icon: 'error',
                                    iconColor: 'white',
                                    title: 'Lỗi',
                                    text: "Đã xảy ra lỗi khi xử lý yêu cầu, hãy làm mới lại trang!",
                                    color: 'white',
                                    position: 'bottom-left',
                                    toast: true,
                                    timer: 3000,
                                    showConfirmButton: false,
                                    background: '#F04770'
                                });
                            }
                        })
                    }
                })
            }

            //Delete function
            function deleteEmployee(id, row) {
                Swal.fire({
                    icon: 'warning',
                    title: "Khóa nhân viên",
                    text: "Bạn có muốn khóa nhân viên này không?",
                    showCancelButton: true,
                    confirmButtonText: "Xác nhận",
                    cancelButtonText: "Hủy",
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('admin.deleteemployee') }}",
                            method: "PUT",
                            data: {
                                id: id,
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(respone) {
                                if (respone.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        iconColor: 'white',
                                        title: 'Đã khóa nhân viên',
                                        text: respone.message,
                                        color: 'white',
                                        showConfirmButton: false,
                                        timer: 3000,
                                        toast: true,
                                        position: 'bottom-left',
                                        background: '#46DFB1',
                                    });

                                    row.find('#status-account').text('Đã khóa');
                                    row.find('#status-account').removeClass('text-green-700');
                                    row.find('#status-account').addClass('text-red-700');

                                    const countDeletedEmployee = parseInt($(
                                        '#count-deleted-employee').text());
                                    $('#count-deleted-employee').text(countDeletedEmployee + 1);

                                    row.find('.lock-button').addClass('hidden');
                                    row.find('.unlock-button').removeClass('hidden');
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        iconColor: 'white',
                                        title: 'Có lỗi xảy ra',
                                        text: respone.message,
                                        color: 'white',
                                        showConfirmButton: false,
                                        timer: 3000,
                                        toast: true,
                                        position: 'bottom-left',
                                        background: '#F04770'
                                    });
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error(xhr.responseText);
                                swal.fire({
                                    icon: 'error',
                                    iconColor: 'white',
                                    title: 'Lỗi',
                                    text: "Đã xảy ra lỗi khi xử lý yêu cầu, hãy làm mới lại trang!",
                                    color: 'white',
                                    position: 'bottom-left',
                                    toast: true,
                                    timer: 3000,
                                    showConfirmButton: false,
                                    background: '#F04770'
                                });
                            }
                        })
                    }
                })
            }
            $('.image-table').on('click', function(e) {
                e.preventDefault();

                const image = $(this).attr('src');

                $('#image-dialog').removeClass('hidden');
                $('#image-imageDialog').attr('src', image);
            });

            //Edit Button
            $('.edit-button').on('click', function(e) {
                e.preventDefault();
                const id = $(this).data('id');
                const name = $(this).data('name');
                const email = $(this).data('email');
                editEmployee(id, name, email);
            });

            //Return Button
            $('.unlock-button').on('click', function(e) {
                e.preventDefault();
                const id = $(this).data('id');
                const row = $(this).closest('tr');
                returnEmployee(id, row);
            });

            //Delete Button
            $('.lock-button').on('click', function(e) {
                e.preventDefault();
                const id = $(this).data('id');
                const row = $(this).closest('tr');
                deleteEmployee(id, row);
            });

            //Insert Button
            $('#insert-button').on('click', function(e) {
                e.preventDefault();
                let username = $('#username-input').val();
                let email = $('#email-input').val();

                if (username == '' || email == '') {
                    Swal.fire({
                        icon: 'error',
                        iconColor: 'white',
                        title: 'Thông báo',
                        text: 'Vui lòng nhập thông tin!',
                        color: 'white',
                        position: 'bottom-left',
                        toast: true,
                        timer: 3000,
                        showConfirmButton: false,
                        background: '#F04770'
                    })
                } else {
                    $.ajax({
                        url: "{{ route('admin.insertemployee') }}",
                        method: "POST",
                        data: {
                            username: username,
                            email: email,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(respone) {
                            if (respone.success) {

                                $('#username-input').val('');
                                $('#email-input').val('');

                                let statusAccount = respone.employee.is_deleted == 1 ?
                                    `<span id="status-account" class="text-red-700 truncate hover:overflow-visible hover:whitespace-normal hover:text-ellipsis">Đã khóa</span>` :
                                    `<span id="status-account" class="text-green-700 text-bold truncate hover:overflow-visible hover:whitespace-normal hover:text-ellipsis">Hoạt động</span>`;

                                let lockButton = respone.employee.is_deleted == 1 ?
                                    `<button data-id="${respone.employee.id}" class="unlock-button flex items-center bg-green-700 border-2 border-green-700 hover:bg-white hover:!text-green-700 rounded p-2 text-white text-lg font-medium">
                                    <i class="fa-solid fa-unlock text-current text-xs"></i>
                                </button>
                                <button data-id="${respone.employee.id}" class="hidden lock-button flex items-center bg-orange-700 border-2 border-orange-700 hover:bg-white hover:!text-orange-700 rounded p-2 text-white text-lg font-medium">
                                    <i class="lock-icon fa-solid fa-lock text-current text-xs"></i>
                                </button>` :
                                    `<button data-id="${respone.employee.id}" class="lock-button flex items-center bg-orange-700 border-2 border-orange-700 hover:bg-white hover:!text-orange-700 rounded p-2 text-white text-lg font-medium">
                                    <i class="lock-icon fa-solid fa-lock text-current text-xs"></i>
                                </button>
                                <button data-id="${respone.employee.id}" class="hidden unlock-button flex items-center bg-green-700 border-2 border-green-700 hover:bg-white hover:!text-green-700 rounded p-2 text-white text-lg font-medium">
                                    <i class="fa-solid fa-unlock text-current text-xs"></i>
                                </button>`;

                                let newRow = `
                            <tr class="even:bg-gray-100 hover:bg-indigo-200 border-b-2">
                                <td class="p-1 text-center align-middle">${respone.employee.id}</td>
                                <td class="px-1 pt-2 flex items-center justify-center h-[85.14px]">
                                    <img src="${respone.employee.avatar_url}" alt="" class="image-table cursor-pointer w-3/4 aspect-square rounded-full border-2 border-gray">
                                </td>
                                <td class="p-1 text-center align-middle">${respone.employee.username}</td>
                                <td class="p-1 text-center align-middle">${respone.employee.email}</td>
                                <td class="p-1 text-center align-middle">${statusAccount}</td>
                                <td class="p-1 text-center align-middle">${new Date(respone.employee.created_at).toLocaleDateString('vi-VN')}</td>
                                <td class="p-1 text-center align-middle">${respone.role}</td>
                                <td class="p-1">
                                    <div class="flex flex-row items-center justify-center space-x-2 w-full h-[85.14px]">
                                        <button data-id="${respone.employee.id}" data-name="${respone.employee.username}" data-email="${respone.employee.email}" class="edit-button flex items-center bg-yellow-700 border-2 border-yellow-700 hover:bg-white hover:!text-yellow-700 rounded p-2 text-white text-lg font-medium">
                                            <i class="fa-solid fa-pen text-current text-xs"></i>
                                        </button>
                                        ${lockButton}
                                    </div>
                                </td>
                            </tr>
                            `;

                                $('table tbody').prepend(newRow);

                                let countEmployee = $('#count-employee').text();
                                countEmployee = parseInt(countEmployee) + 1;
                                $('#count-employee').text(countEmployee);


                                $('.lock-button').off('click').on('click', function(e) {
                                    e.preventDefault();
                                    const id = $(this).data('id');
                                    const row = $(this).closest('tr');
                                    deleteEmployee(id, row);
                                });

                                $('.unlock-button').off('click').on('click', function(e) {
                                    e.preventDefault();
                                    const id = $(this).data('id');
                                    const row = $(this).closest('tr');
                                    returnEmployee(id, row);
                                });

                                $('.edit-button').off('click').on('click', function(e) {
                                    e.preventDefault();
                                    var id = $(this).data('id');
                                    const name = $(this).data('name');
                                    const email = $(this).data('email');
                                    editEmployee(id, name, email);
                                });

                                Swal.fire({
                                    icon: 'success',
                                    iconColor: 'white',
                                    title: 'Thêm một nhân viên thành công',
                                    color: 'white',
                                    showConfirmButton: false,
                                    timer: 3000,
                                    toast: true,
                                    position: 'bottom-left',
                                    background: '#46DFB1'
                                })

                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    iconColor: 'white',
                                    title: 'Có lỗi xảy ra',
                                    text: respone.message,
                                    color: 'white',
                                    showConfirmButton: false,
                                    timer: 3000,
                                    toast: true,
                                    position: 'bottom-left',
                                    background: '#F04770'
                                })
                            }
                        }
                    });
                }
            });

            //Function Find Tr
            function findTr(id) {
                let foundTr = null;
                $('tbody tr').each(function() {
                    if ($(this).find('td:nth-child(1)').text() == id) {
                        foundTr = $(this);
                        return false;
                    }
                });
                return foundTr;
            }

            //Update Button
            $('#update-button').on('click', function(e) {
                e.preventDefault();

                const username = $('#username-input').val();
                const email = $('#email-input').val();

                if (username == '' || email == '') {
                    Swal.fire({
                        icon: 'error',
                        iconColor: 'white',
                        title: 'Thông báo',
                        text: 'Vui lòng nhập thông tin!',
                        color: 'white',
                        position: 'bottom-left',
                        toast: true,
                        timer: 3000,
                        showConfirmButton: false,
                        background: '#F04770'
                    })
                } else {
                    const id = $('#id-input').val();
                    const row = findTr(id);
                    const username = $('#username-input').val();
                    const email = $('#email-input').val();
                    $.ajax({
                        url: '/admin/updateemployee',
                        method: 'PUT',
                        data: {
                            id: id,
                            username: username,
                            email: email,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(respone) {
                            if (respone.success) {
                                Swal.fire({
                                    icon: 'success',
                                    iconColor: 'white',
                                    title: 'Câp nhật nhân viên',
                                    text: respone.message,
                                    color: 'white',
                                    showConfirmButton: false,
                                    timer: 3000,
                                    toast: true,
                                    position: 'bottom-left',
                                    background: '#46DFB1',
                                });

                                row.find('#username-table').text(username);
                                row.find('#email-table').text(email);

                                $('#crud-title').text('THÊM MỚI NHÂN VIÊN');
                                $('#username-input').val('');
                                $('#email-input').val('');

                                $('#insert-button').removeClass('hidden');
                                $('#update-button').addClass('hidden');
                                $('#return-button').addClass('hidden');
                                $(this).addClass('hidden');
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    iconColor: 'white',
                                    title: 'Có lỗi xảy ra',
                                    text: respone.message,
                                    color: 'white',
                                    showConfirmButton: false,
                                    timer: 3000,
                                    toast: true,
                                    position: 'bottom-left',
                                    background: '#F04770'
                                })
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                            swal.fire({
                                icon: 'error',
                                iconColor: 'white',
                                title: 'Lỗi',
                                text: "Đã xảy ra lỗi khi xử lý yêu cầu, hãy làm mới lại trang!",
                                color: 'white',
                                position: 'bottom-left',
                                toast: true,
                                timer: 3000,
                                showConfirmButton: false,
                                background: '#F04770'
                            });
                        }
                    });
                }
            });
            //Return Button
            $('#return-button').on('click', function(e) {
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
            $('#reset-button').on('click', function(e) {
                e.preventDefault();

                $('#username-input').val('');
                $('#email-input').val('');
            });
        });
    </script>

    <!-- Confirm Dialog -->
    <div id="confirm-dialog"
        class="hidden fixed top-0 left-0 w-full h-full bg-gray-800 bg-opacity-50 flex flex-col items-center justify-center">
        <div class="bg-white rounded-lg w-[500px]">
            <div class="bg-indigo-700 rounded-t-lg text-white font-bold text-center text-xl p-2">XÁC NHẬN</div>
            <div id="content-confirmDialog"
                class="flex flex-col items-center justify-center h-24 py-2 px-4 text-lg text-center"></div>
            <div class="flex flex-row items-center justify-center p-2 space-x-4">
                <button id="confirm-confirmDialog"
                    class="flex flex-row items-center space-x-2 bg-green-700 border-2 border-green-700 hover:bg-white hover:!text-green-700 rounded px-3 py-1 text-white text-lg font-medium">
                    <i class="fa-solid fa-circle-check text-xl text-current"></i>
                    <div>Xác Nhận</div>
                </button>
                <button id="cancel-confirmDialog"
                    class="flex flex-row items-center space-x-2 bg-red-700 border-2 border-red-700 hover:bg-white hover:!text-red-700 rounded px-3 py-1 text-white text-lg font-medium">
                    <i class="fa-solid fa-circle-xmark text-xl text-current"></i>
                    <div>Hủy Bỏ</div>
                </button>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#confirm-confirmDialog').on('click', function(e) {
                e.preventDefault();

                $('#confirm-dialog').addClass('hidden');
            });

            $('#cancel-confirmDialog').on('click', function(e) {
                e.preventDefault();

                $('#confirm-dialog').addClass('hidden');
            });
        });
    </script>
@endsection
