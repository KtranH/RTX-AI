@extends('Admin.Container')
@section('Content')
    <title>RTX-ADMIN: Hình Ảnh</title>

    <div class="w-full h-full flex flex-col justify-between space-y-4 p-2 divide-y-4 divide-indigo-700 cursor-default">
        <!-- Header -->
        <div class="h-10 py-2 px-8 flex items-center text-2xl font-bold">HÌNH ẢNH</div>
        <!-- Content -->
        <div class="h-full overflow-hidden p-2">
            <div class="grid grid-cols-3 h-full space-x-4 p-2">
                <!-- Approve -->
                <div
                    class="col-span-2 flex flex-col items-center justify-start rounded-2xl bg-white px-4 shadow-md border-2 border-gray-200 space-y-2 h-full">
                    <!-- Header -->
                    <div class="w-full flex flex-row items-center justify-between border-b-2 border-gray-200 py-2.5">
                        <div class="font-semibold text-2xl text-left flex flex-row items-center">
                            <span class="mr-4">DUYỆT BÁO CÁO</span>
                            <button id="refresh"
                                class="flex flex-row items-center space-x-2 bg-green-700 border-2 border-green-700 hover:bg-white hover:!text-green-700 rounded px-3 py-1 text-white text-lg font-medium">
                                <i class="fa-solid fa-rotate-right mr-2"></i>
                                Làm mới
                            </button>
                        </div>
                        <div class="flex flex-row items-center justify-end space-x-4">
                            <!-- ComboBox -->
                            <div class="relative w-72 text-black">
                                <label for="status" class="block text-lg font-medium text-gray-700 mb-2">Chọn trạng
                                    thái</label>
                                <select id="status" name="status"
                                    class="block w-full px-4 py-2 text-lg border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out">
                                    <option value="pending">Chưa duyệt</option>
                                    <option value="approved">Đã đồng ý</option>
                                    <option value="rejected">Từ chối</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- Display -->
                    <div class="w-full h-[730px] overflow-auto pr-4">
                        <div class="grid grid-cols-4 gap-3 py-3" id="review-container">
                        </div>
                        <div id="loading-approve" class="text-center my-4" style="display: none;">Đang tải thêm ảnh...</div>
                        <h1 id="no-report">
                            @if ($countReview == 0)
                                Không có báo cáo nào cần xét duyệt
                            @endif
                        </h1>
                    </div>
                    <script>
                        var page = 1;
                        var isLoading = false;

                        $('#status').on('change', function() {
                            loadReport();
                            let approve = $('#approve-button');
                            let disapprove = $('#disapprove-button');
                            if ($(this).val() === 'approved') {
                                approve.addClass('hidden');
                                disapprove.removeClass('hidden');
                            } else if ($(this).val() === 'rejected') {
                                approve.removeClass('hidden');
                                disapprove.addClass('hidden');
                            } else {
                                approve.removeClass('hidden');
                                disapprove.removeClass('hidden');
                            }
                        });

                        $('#refresh').on('click', function() {
                            loadReport();
                        });

                        function loadReport(initialLoad = false) {
                            if (isLoading) return;
                            isLoading = true;

                            $('#loading-approve').show();

                            var status = $('#status').val();
                            var url = '';

                            if (status === 'approved') {
                                url = `/api/admin/acceptimage?page=${page}`;
                                $('#no-report').hide();
                            } else if (status === 'rejected') {
                                url = `/api/admin/rejectimage?page=${page}`;
                                $('#no-report').hide();
                            } else {
                                url = `/api/admin/image?page=${page}`;
                                $('#no-report').show();
                            }

                            fetch(url)
                                .then(response => response.json())
                                .then(data => {

                                    const photoContainer = $('#review-container');
                                    photoContainer.empty();

                                    if (data.photos.length === 0) {
                                        $('#loading-approve').text('Không có ảnh nào để hiển thị.');
                                    }
                                    data.photos.forEach(photo => {
                                        const adminInfo = photo.status !== 'pending' ?
                                            `<span class="text-sm text-gray-500">Đã thực hiện bởi: ${photo.admin.username}</span>` :
                                            '';
                                        const photoHTML = `
                                        <div class="display-component group relative w-full h-full cursor-pointer" data-id="${photo.id}" data-image="${photo.photo.url}" data-quantity="${photo.report_count}" data-content="${photo.review_content}">
                                            <img src="${photo.photo.url}" loading="lazy" alt="Image" class="image-display w-full h-full rounded-2xl border-2 border-gray-200 group-hover:!opacity-50" style="max-width: 300px; max-height: 300px; object-fit: cover;">
                                            <div class="count-display absolute -top-3 -right-3 rounded-full w-8 h-8 flex items-center justify-center bg-orange-700 text-white font-medium border-2 border-gray-200 group-hover:!bg-indigo-700">${photo.report_count}</div>
                                            <div>
                                                ${adminInfo}
                                            </div>
                                        </div>`;
                                        photoContainer.append(photoHTML);
                                    });

                                    $('.display-component').off('click').on('click', function(e) {
                                        e.preventDefault();

                                        const id = $(this).data('id');
                                        const image = $(this).data('image');
                                        const quantity = $(this).data('quantity');
                                        const content = $(this).data('content');

                                        $('#image-approvalForm').attr('src', image);
                                        $('#quantity-approvalForm').val(quantity);
                                        $('#id-approvalForm').val(id);
                                        $('#content-approvalForm').val(content);

                                        $('.image-display').removeClass('border-indigo-700');
                                        $('.count-display').removeClass('bg-indigo-700');

                                        $(this).find('.image-display').addClass('border-4 border-indigo-700');
                                        $(this).find('.count-display').addClass('bg-indigo-700');
                                    });

                                    isLoading = false;
                                    $('#loading-approve').hide();

                                    if (data.hasMorePages) {
                                        page++;
                                    } else {
                                        window.removeEventListener('scroll', scrollHandlerNormal);
                                    }
                                })
                                .catch(error => {
                                    console.error('Lỗi khi tải ảnh:', error);
                                    isLoading = false;
                                    $('#loading-approve').hide();
                                });
                        }

                        window.addEventListener('load', () => {
                            loadReport(true);
                        });

                        function scrollHandlerNormal() {
                            if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 200) {
                                loadReport();
                            }
                        }
                        window.addEventListener('scroll', scrollHandlerNormal);
                    </script>
                </div>
                <div class="grid grid-rows-5 space-y-4">
                    <!-- Quick Information -->
                    <div
                        class="flex flex-row items-center justify-between rounded-2xl bg-white py-2 px-4 shadow-md border-2 border-gray-200">
                        <div class="basis-1/4 flex items-center justify-center">
                            <div class="flex items-center justify-center bg-red-600 rounded-full py-3 px-[22.265px]">
                                <i class="fa-solid fa-hourglass-half text-[50px] text-white"></i>
                            </div>
                        </div>
                        <div class="basis-3/4 text-center">
                            <div class="font-medium text-lg">SỐ BÀI CẦN DUYỆT</div>
                            <div class="text-3xl" id="count-approval">{{ $countReview }} </div>
                        </div>
                    </div>
                    <!-- Form -->
                    <div
                        class="row-span-4 flex flex-col items-center justify-between rounded-2xl bg-white px-4 shadow-md border-2 border-gray-200 space-y-2">
                        <div class="w-full text-left font-semibold text-2xl border-b-2 border-gray-200 py-3">THÔNG TIN BÁO
                            CÁO</div>
                        <div class="w-full flex flex-col items-center justify-start space-y-4 px-2">
                            <img id="image-approvalForm"
                                src="https://media0.giphy.com/media/gfO3FcnL8ZK9wVgr6t/200w.gif?cid=6c09b952vgmok2v2iivlcygbxsl4j7h142m3qwl8xrngyzes&ep=v1_gifs_search&rid=200w.gif&ct=g"
                                loading="lazy" alt="Image"
                                class="w-1/2 aspect-square rounded-2xl border-2 border-gray-200 cursor-pointer object-cover">
                            <div class="w-full space-y-1 text-black">
                                <label for="id-approvalForm" class="font-medium">ID</label>
                                <input type="number" name="id-approvalForm" id="id-approvalForm" disabled placeholder=""
                                    class="p-2 border-2 border-gray-500 focus:outline-none focus:border-indigo-700 rounded w-full"
                                    disabled>
                            </div>
                            <div class="w-full space-y-1 text-black">
                                <label for="quantity-approvalForm" class="font-medium">Số Lượng</label>
                                <input type="number" name="quantity-approvalForm" id="quantity-approvalForm" disabled
                                    placeholder=""
                                    class="p-2 border-2 border-gray-500 focus:outline-none focus:border-indigo-700 rounded w-full">
                            </div>
                            <div class="w-full space-y-1 text-black">
                                <label for="content-approvalForm" class="font-medium">Nội Dung</label>
                                <textarea name="content-approvalForm" id="content-approvalForm" disabled
                                    class="resize-none p-2 border-2 border-gray-500 focus:outline-none focus:border-indigo-700 rounded w-full"></textarea>
                            </div>
                        </div>
                        <div
                            class="w-full flex flex-row items-center justify-center border-t-2 border-gray-200 py-3 space-x-8">
                            <button type="submit" id="approve-button"
                                class="flex flex-row items-center space-x-2 bg-green-700 border-2 border-green-700 hover:bg-white hover:!text-green-700 rounded px-3 py-1 text-white text-lg font-medium">
                                <i class="fa-solid fa-circle-check text-current"></i>
                                <div>Đồng ý</div>
                            </button>
                            <button type="button" id="disapprove-button"
                                class="flex flex-row items-center space-x-2 bg-red-700 border-2 border-red-700 hover:bg-white hover:!text-red-700 rounded px-3 py-1 text-white text-lg font-medium">
                                <i class="fa-solid fa-xmark text-current"></i>
                                <div>Không đồng ý</div>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        //Remove Image
        function removeImage(id) {
            let image = $('.display-component[data-id="' + id + '"]');
            image.remove();
        }
        //Form
        $(document).ready(function() {
            $('#image-approvalForm').on('click', function(e) {
                e.preventDefault();

                const image = $(this).attr('src');

                $('#image-dialog').removeClass('hidden');
                $('#image-imageDialog').attr('src', image);
            });

            $('#approve-button').on('click', function(e) {
                e.preventDefault();
                let idForm = $('#id-approvalForm').prop('value');
                if (!idForm) {
                    swal.fire({
                        icon: 'error',
                        iconColor: 'white',
                        title: 'Thông báo',
                        text: 'Vui lòng chọn ý kiến trước khi đồng ý',
                        color: 'white',
                        position: 'bottom-left',
                        toast: true,
                        timer: 3000,
                        showConfirmButton: false,
                        background: '#F04770'
                    })
                } else {
                    swal.fire({
                        icon: 'question',
                        title: 'Thông báo',
                        text: 'Bạn có chắc chắn đồng ý với yêu cầu',
                        showCancelButton: true,
                        confirmButtonText: 'Xác Nhận',
                        cancelButtonText: 'Hủy Bỏ',
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: '/admin/approvedreport',
                                type: 'PUT',
                                data: {
                                    image_id: idForm,
                                    _token: "{{ csrf_token() }}"
                                },
                                success: function(response) {
                                    if (response.success) {
                                        swal.fire({
                                            icon: 'success',
                                            iconColor: 'white',
                                            title: 'Thông báo',
                                            text: 'Đã đồng ý với báo cáo',
                                            color: 'white',
                                            position: 'bottom-left',
                                            toast: true,
                                            timer: 3000,
                                            showConfirmButton: false,
                                            background: '#46DFB1'
                                        });

                                        removeImage(idForm);

                                        $('#image-approvalForm').attr('src',
                                            'https://media0.giphy.com/media/gfO3FcnL8ZK9wVgr6t/200w.gif?cid=6c09b952vgmok2v2iivlcygbxsl4j7h142m3qwl8xrngyzes&ep=v1_gifs_search&rid=200w.gif&ct=g'
                                            );
                                        $('#id-approvalForm').prop('value', '');
                                        $('#quantity-approvalForm').prop('value', '');
                                        $('#content-approvalForm').prop('value', '');

                                        let count_approval = $('#count-approval')
                                    .text();
                                        let count_approval_sidebar = $(
                                            '#count-approval-sidebar').text();
                                        count_approval = parseInt(count_approval) - 1;

                                        if (count_approval < 0) {
                                            count_approval = 0;
                                        }
                                        $('#count-approval').text(count_approval);
                                        $('#count-approval-sidebar').text(
                                            count_approval);
                                    } else {
                                        swal.fire({
                                            icon: 'error',
                                            iconColor: 'white',
                                            title: 'Thông báo',
                                            text: response.message,
                                            color: 'white',
                                            position: 'bottom-left',
                                            toast: true,
                                            timer: 3000,
                                            showConfirmButton: false,
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
                            });
                        }
                    });
                }
            });

            $('#disapprove-button').on('click', function(e) {
                e.preventDefault();
                let idForm = $('#id-approvalForm').prop('value');
                if (!idForm) {
                    swal.fire({
                        icon: 'error',
                        iconColor: 'white',
                        title: 'Thông báo',
                        text: 'Vui lòng chọn ý kiến trước khi không đồng ý',
                        color: 'white',
                        position: 'bottom-left',
                        toast: true,
                        timer: 3000,
                        showConfirmButton: false,
                        background: '#F04770'
                    })
                } else {
                    swal.fire({
                        icon: 'question',
                        title: 'Thông báo',
                        text: 'Bạn có chắc chắn không đồng ý với yêu cầu',
                        showCancelButton: true,
                        confirmButtonText: 'Xác Nhận',
                        cancelButtonText: 'Hủy Bỏ',
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: '/admin/rejectreport',
                                type: 'PUT',
                                data: {
                                    image_id: idForm,
                                    _token: "{{ csrf_token() }}"
                                },
                                success: function(response) {
                                    if (response.success) {
                                        swal.fire({
                                            icon: 'success',
                                            iconColor: 'white',
                                            title: 'Thông báo',
                                            text: 'Đã không đồng ý với báo cáo',
                                            color: 'white',
                                            position: 'bottom-left',
                                            toast: true,
                                            timer: 3000,
                                            showConfirmButton: false,
                                            background: '#46DFB1'
                                        });
                                        removeImage(idForm);

                                        $('#image-approvalForm').attr('src',
                                            'https://media0.giphy.com/media/gfO3FcnL8ZK9wVgr6t/200w.gif?cid=6c09b952vgmok2v2iivlcygbxsl4j7h142m3qwl8xrngyzes&ep=v1_gifs_search&rid=200w.gif&ct=g'
                                            );
                                        $('#id-approvalForm').prop('value', '');
                                        $('#quantity-approvalForm').prop('value', '');
                                        $('#content-approvalForm').prop('value', '');

                                        let count_approval = $('#count-approval')
                                    .text();
                                        let count_approval_sidebar = $(
                                            '#count-approval-sidebar').text();
                                        count_approval = parseInt(count_approval) - 1;

                                        if (count_approval < 0) {
                                            count_approval = 0;
                                        }
                                        $('#count-approval').text(count_approval);
                                        $('#count-approval-sidebar').text(
                                            count_approval);
                                    } else {
                                        swal.fire({
                                            icon: 'error',
                                            iconColor: 'white',
                                            title: 'Thông báo',
                                            text: response.message,
                                            color: 'white',
                                            position: 'bottom-left',
                                            toast: true,
                                            timer: 3000,
                                            showConfirmButton: false,
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
                            });
                        }
                    });
                }
            });
        });
    </script>
@endsection
