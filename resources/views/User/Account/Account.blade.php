@extends('User.Container')
@section('Body')

    <?php
        
        $cookie = request()->cookie("token_account");
        $account = DB::select("SELECT * FROM users WHERE email = ?", [$cookie])[0];

        $path = request()->path();
        $segments = explode('/', $path);
        $tab = end($segments);    
        
        // echo $tab;
        
    ?>

    <title>RTX-AI: Tài Khoản</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <main class="w-full h-full">
        <!-- Title -->
        <div class="flex items-center justify-center">
            <div class="w-full max-w-2xl px-4 py-4 sm:px-6 sm:py-6 lg:max-w-7xl lg:px-16 text-center">
                <div class="font-bold text-3xl">Tài Khoản</div>
                <div class="text-gray-500">Mỗi Khoảnh Khắc Nên Được Trân Trọng</div>
            </div>
        </div>
        <!-- Form -->
        <div class="flex items-center justify-center">
            <div class="w-full max-w-2xl px-4 py-4 sm:px-6 sm:py-6 lg:max-w-9xl lg:px-16">
                <form class="bg-gray-100 rounded-lg shadow-md p-4">
                    <label for="avatar-cover" class="block text-xl font-medium mb-1 text-center">Ảnh Đại Diện</label>
                    <div class="flex justify-center mb-4">
                        <div class="aspect-square relative group w-40 h-40">
                            <img id="avatar-cover" src="{{ $account->avatar_url }}" alt="Avatar Cover" class="w-full h-full object-cover rounded-lg">
                            <label for="cover" class="absolute inset-0 flex items-center justify-center bg-white bg-opacity-50 opacity-0 group-hover:opacity-100 group-hover:!opacity-100 transition-opacity duration-300 cursor-pointer">
                                <i class="fas fa-upload text-gray-700 text-3xl"></i>
                            </label>
                            <input type="file" id="cover" class="absolute inset-0 opacity-0 cursor-pointer">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="username" class="block text-xl font-medium mb-1">Tên Người Dùng</label>
                        <input type="text" id="username" name="username" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-[#a000ff] focus:!border-[#a000ff] sm:text-sm" value="{{ $account->username }}">
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-xl font-medium mb-1">Email</label>
                        <input type="email" id="email" name="email" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-[#a000ff] focus:!border-[#a000ff] sm:text-sm" value="{{ $account->email }}">
                    </div>
                    <div class="mb-4">
                        <label for="password" class="block text-xl font-medium mb-1">Mật Khẩu</label>
                        <input type="password" id="password" name="password" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-[#a000ff] focus:!border-[#a000ff] sm:text-sm" value="Hahahaha">
                    </div>
                    <div class="flex justify-center mt-4">
                        <button type="submit" class="bg-[#a000ff] text-white font-bold px-5 py-2 rounded-md border border-[#a000ff] hover:bg-white hover:text-[#a000ff] hover:!text-[#a000ff] hover:border-[#a000ff] hover:border-![#a000ff]">
                            Lưu
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <script>
            document.getElementById('cover').addEventListener('change', function(event) 
            {
                const file = event.target.files[0];
                if (file) 
                {
                    const reader = new FileReader();
                    reader.onload = function(e) 
                    {
                        document.getElementById('avatar-cover').src = e.target.result;
                    }
                    reader.readAsDataURL(file);
                }
            });
        </script>
    </main>

@endsection