@extends('Admin.Container')
@section('Content')

<title>RTX-ADMIN: Thông Tin</title>

<div class="w-full h-full flex flex-col justify-between space-y-4 p-2 divide-y-4 divide-indigo-700 cursor-default">
    <!-- Header -->
    <div class="h-10 py-2 px-8 flex items-center text-2xl font-bold">THÔNG TIN</div>
    <!-- Content -->
    <div class="h-full overflow-hidden p-2">
        <div class="grid grid-cols-2 h-full space-x-4 p-2">
            <!-- Form -->
            <div class="flex flex-col items-center justify-start rounded-2xl bg-white px-4 shadow-md border-2 border-gray-200 space-y-2 h-full">
                <div class="w-full text-left font-semibold text-2xl border-b-2 border-gray-200 py-3">THÔNG TIN TÀI KHOẢN</div>
                <form action="" id="account-form" class="w-full h-full flex flex-col items-center justify-between space-y-4 px-2">
                    <div class="w-full h-3/4 flex flex-col items-center space-y-4">
                        <div class="w-full space-y-1 text-black">
                            <label for="username-input" class="font-medium">Tên tài khoản</label>
                            <input type="text" name="username-input" id="username-input" value="{{ Auth::guard('admin')->user()->username }}" placeholder="" class="p-2 border-2 border-gray-500 focus:outline-none focus:border-indigo-700 rounded w-full" required>
                        </div>
                        <div class="w-full space-y-1 text-black">
                            <label for="email-input" class="font-medium">Email</label>
                            <input type="email" name="email-input" id="email-input" value="{{ Auth::guard('admin')->user()->email }}" placeholder="" class="p-2 border-2 border-gray-500 focus:outline-none focus:border-indigo-700 rounded w-full" required>
                        </div>
                        <div class="w-full space-y-1 text-black">
                            <label for="password-input" class="font-medium">Mật khẩu</label>
                            <div class="w-full flex flex-row items-center justify-between space-x-4">
                                <input type="password" name="password-input" id="password-input" placeholder="" class="p-2 border-2 border-gray-500 focus:outline-none focus:border-indigo-700 rounded w-full">
                                <i id="toggle-icon" class="fa-solid fa-eye flex items-center cursor-pointer text-gray-500 hover:text-indigo-700 border-2 border-gray-500 hover:border-indigo-700 py-[12px] px-[12px] rounded w-12"></i>
                            </div>
                        </div>
                        <div class="w-full space-y-1 text-black">
                            <label for="role-select" class="font-medium">Chức vụ</label>
                            <select name="role-select" id="role-select" class="disabled:bg-gray-300 p-2 outline outline-2 outline-gray-500 focus:outline-indigo-700 rounded-[3px] w-full border-r-[12px] border-transparent">
                                <option selected value="ABC">{{ Auth::guard('admin')->user()->adminRole->role_name }}</option>
                                @foreach ($role as $item)
                                    @if(Auth::guard('admin')->user()->adminRole->role_name != $item->role_name && Auth::guard('admin')->user()->adminRole->role_name != 'superadmin')
                                        <option value="{{ $item->role_name }}">{{ $item->role_name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="w-full space-y-1 text-black">
                            <label for="create-input" class="font-medium">Ngày Vào</label>
                            <input type="text" name="create-input" id="create-input" value="{{ date('d-m-Y', strtotime(Auth::guard('admin')->user()->created_at)) }}" placeholder="" class="disabled:bg-gray-300 p-2 border-2 border-gray-500 focus:outline-none focus:border-indigo-700 rounded w-full" required>
                        </div>
                        <div class="w-full space-y-1 text-black">
                            <label for="update-input" class="font-medium">Ngày Cập Nhật</label>
                            <input type="text" name="update-input" id="update-input" value="{{ date('d-m-Y', strtotime(Auth::guard('admin')->user()->updated_at)) }}" placeholder="" class="disabled:bg-gray-300 p-2 border-2 border-gray-500 focus:outline-none focus:border-indigo-700 rounded w-full" required>
                        </div>
                    </div>
                    <div class="w-full flex flex-row items-center justify-center border-t-2 border-gray-200 py-3 space-x-8">
                        @if (Auth::guard('admin')->user()->adminRole->role_name == 'superadmin')
                            <button type="submit" id="update-button" class="flex flex-row items-center space-x-2 bg-yellow-700 border-2 border-yellow-700 hover:bg-white hover:!text-yellow-700 rounded px-3 py-1 text-white text-lg font-medium">
                                <i class="fa-solid fa-pen text-current"></i>
                                <div>Sửa Lại</div>
                            </button>
                        @else
                            <button type="submit" id="update-password-button" class="flex flex-row items-center space-x-2 bg-green-700 border-2 border-green-700 hover:bg-white hover:!text-green-700 rounded px-3 py-1 text-white text-lg font-medium">
                                <i class="fa-solid fa-pen text-current"></i>
                                <div>Làm mới mật khẩu</div>
                            </button>
                        @endif
                    </div>
                </form>
            </div>
            <div class="grid grid-rows-4 space-y-4">
                <!-- Information -->
                <div class="row-span-3 flex flex-col items-center justify-center rounded-2xl bg-white px-4 shadow-md border-2 border-gray-200 h-full">
                    <button type="submit" id="update-avatar-button" class="hidden mb-4 flex flex-row items-center space-x-2 bg-green-700 border-2 border-green-700 hover:bg-white hover:!text-green-700 rounded px-3 py-1 text-white text-lg font-medium">
                        <i class="fa-solid fa-camera"></i>
                        <div>Cập nhật avatar</div>
                    </button>
                    <div class="aspect-square relative group w-[350px] h-[350px] flex items-center justify-center px-2">
                        <div class="relative group w-80 h-80">
                            <img id="avatar-image" 
                                 src="{{ Auth::guard('admin')->user()->avatar_url }}" 
                                 loading="lazy" 
                                 alt="Avatar" 
                                 class="w-full h-full object-cover rounded-full border-4 border-gray-200">
                            
                            <label for="avatar-input" 
                                   class="absolute inset-0 flex items-center justify-center bg-white bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300 cursor-pointer">
                                <i class="fas fa-upload text-indigo-700 text-4xl"></i>
                            </label>
                            
                            <input type="file" 
                                   name="avatar-input" 
                                   id="avatar-input" 
                                   accept="image/*" 
                                   class="absolute inset-0 opacity-0 cursor-pointer">
                        </div>
                    </div>
                    <div class="w-full text-center font-semibold text-2xl pt-3 pb-2" id="username">{{ Auth::guard('admin')->user()->username }}</div>
                    <div class="w-full text-center font-medium text-gray-500 text-xl pb-3" id="email">{{ Auth::guard('admin')->user()->email }}</div>
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
                            <div class="font-medium text-lg">Số bài đăng đã không duyệt</div>
                            <div class="text-3xl">{{ Auth::guard('admin')->user()->reviews->where('status', 'rejected')->count() }}</div>
                        </div>
                    </div>
                    <div class="flex flex-row items-center justify-between rounded-2xl bg-white py-2 px-4 shadow-md border-2 border-gray-200">
                        <div class="basis-1/4 flex items-center justify-center">
                            <div class="flex items-center justify-center bg-green-600 rounded-full p-3">
                                <i class="fa-solid fa-feather text-[50px] text-white"></i>
                            </div>
                        </div>
                        <div class="basis-3/4 text-center">
                            <div class="font-medium text-lg">Số bài đăng đã duyệt</div>
                            <div class="text-3xl">{{ Auth::guard('admin')->user()->reviews->where('status', 'approved')->count() }}</div>
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

        //Add Avatar 
        $('#avatar-input').on('change', function (e) 
        {
            const file = this.files[0];
            if (file) 
            {
                if ((file.type === 'image/jpeg' || file.type === 'image/png') && file.size <= 4048000) {
                    const reader = new FileReader();
                    reader.onload = function(e) 
                    {
                        $('#avatar-image').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(file);
                    $('#update-avatar-button').removeClass('hidden');
                }
                else
                {
                    Swal.fire({
                        icon: 'error',
                        iconColor: 'white',
                        title: 'Thông báo',
                        text: 'Vui lòng tải ảnh hợp lệ nhỏ hơn 4MB!',
                        color: 'white',
                        position: 'bottom-left',
                        toast: true,
                        timer: 3000,
                        showConfirmButton: false,
                        background: '#F04770'
                    })

                    $('avatar-input').val('');
                }
            }
        });

        //Update Avatar Button
        $('#update-avatar-button').on('click', function (e) {
        e.preventDefault();

        let avatar = $('#avatar-input')[0].files[0];
        if (!avatar) {
            Swal.fire({
                icon: 'error',
                iconColor: 'white',
                title: 'Lỗi',
                text: 'Vui lòng chọn một ảnh để tải lên!',
                color: 'white',
                timer: 3000,
                showConfirmButton: false,
                position: 'bottom-left',
                toast: true,
                background: '#F04770'
            });
            return;
        }

        Swal.fire({
            title: 'Đang tải ảnh...',
            html: '<div class="relative flex justify-center items-center"> <div class="absolute animate-ping w-8 h-8 rounded-full bg-blue-500 opacity-75"></div> <div class="relative w-8 h-8 rounded-full bg-blue-600 animate-pulse flex items-center justify-center"> <svg class="w-5 h-5 text-white animate-spin" fill="none" viewBox="0 0 24 24"> <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle> <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path> </svg> </div> </div>',
            showConfirmButton: false,
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        let formData = new FormData();
        formData.append('avatar', avatar);
        formData.append('_token', '{{ csrf_token() }}'); 

            $.ajax({
                url: '/admin/updateavatar',
                type: 'POST',
                data: formData,
                contentType: false, 
                processData: false,  

                success: function (response) {
                    Swal.fire({
                        icon: 'success',
                        iconColor: 'white',
                        title: 'Thành công',
                        text: 'Ảnh đại diện đã được cập nhật!',
                        color: 'white',
                        timer: 3000,
                        showConfirmButton: false,
                        position: 'bottom-left',
                        toast: true,
                        background: '#46DFB1'
                    });

                    if (response.avatar) {
                        $('#avatar-image').attr('src', response.avatar);
                        $('#avatar-sidebar').attr('src', response.avatar);
                    }
                },
                error: function (xhr) {
                    Swal.fire({
                        icon: 'error',
                        iconColor: 'white',
                        title: 'Lỗi',
                        text: 'Cập nhật ảnh thất bại. Vui lòng thử lại!',
                        color: 'white',
                        timer: 3000,
                        showConfirmButton: false,
                        position: 'bottom-left',
                        toast: true,
                        background: '#F04770'
                    });
                    console.error('Error:', xhr.responseText);
                }
            });
        });


        //Update Passowrd Button
        $('#update-password-button').on('click', function (e) 
        {
            e.preventDefault();
            let password = $('#password-input').val();

            if(password == '')
            {
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
            }
            else
            {
                $.ajax({
                    url: '{{ route('admin.updatepassword') }}',
                    method: 'PUT',
                    data: {
                        password: password,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) 
                    {
                        if(response.status == 'success')
                        {
                            Swal.fire({
                                icon: 'success',
                                iconColor: 'white',
                                title: 'Thông báo',
                                text: 'Câp nhật thành công!',
                                color: 'white',
                                position: 'bottom-left',
                                toast: true,
                                timer: 3000,
                                showConfirmButton: false,
                                background: '#46DFB1'   
                            });
                        }
                        else
                        {
                            Swal.fire({
                                icon: 'error',
                                iconColor: 'white',
                                title: 'Thông báo',
                                text: 'Câp nhật thất bại! ' + response.message,
                                color: 'white',
                                position: 'bottom-left',
                                toast: true,
                                timer: 3000,
                                showConfirmButton: false,
                                background: '#F04770'
                            });
                        }
                    },
                    error: function (xhr, status, error) 
                    {
                        console.error('Error:', error);
                        alert('Có lỗi xảy ra khi câp nhật.');
                    }
                });
            }
        });
        //Update Button
        $('#update-button').on('click', function (e) 
        {
            e.preventDefault();
            let username = $('#username-input').val();
            let email = $('#email-input').val();
            let password = $('#password-input').val();
            let createDay = $('#create-input').val();
            let updateDay = $('#update-input').val();
            let usernameR = $('#username').val();
            let emailR = $('#email').val();

            if(username == '' || email == '')
            {
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
            }
            else
            {
                $.ajax({
                    url: '{{ route('admin.updateinformation') }}',
                    method: 'PUT',
                    data: {
                        username: username,
                        email: email,
                        password: password,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) 
                    {
                        if(response.success)
                        {
                            Swal.fire({
                                icon: 'success',
                                iconColor: 'white',
                                title: 'Thông báo',
                                text: "Cập nhật thành công",
                                color: 'white',
                                position: 'bottom-left',
                                toast: true,
                                timer: 3000,
                                showConfirmButton: false,
                                background: '#46DFB1'
                            });

                            $('#username').text(username);
                            $('#email').text(email);
                            $('#usernameR').text(username);
                        }
                        else
                        {
                            Swal.fire({
                                icon: 'error',
                                iconColor: 'white',
                                title: 'Thông báo',
                                text: "Cập nhật thất bại " + response.message,
                                color: 'white',
                                position: 'bottom-left',
                                toast: true,
                                timer: 3000,
                                showConfirmButton: false,
                                background: '#F04770'
                            });
                        }
                    },
                    error: function (xhr, status, error) 
                    {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            iconColor: 'white',
                            title: 'Thông báo',
                            text: 'Vui lòng thử lại sau',
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
    });
</script>

@endsection