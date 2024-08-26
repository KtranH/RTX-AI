@extends('User.Container')
@section('Body')
<title>RTX-AI: Sáng tạo hình ảnh</title>
<form id="G1" method="POST" action="{{ route("createg1") }}">
    @csrf
    <div class="bg-white">
        <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-16">
            <div class="space-y-12">
                <div class="border-b border-gray-900/10 pb-12">
                    <div style="margin-top:-5%; margin-bottom:2%">
                        <h2 class="text-2xl font-bold tracking-tight text-gray-900">{{ $G->name }}</h2>
                        <p class="text-xs font-bold tracking-tight">{{ $G->description }}</p>
                   </div>
                    <div style="margin-bottom:2%;">
                        <h2 class="text-base font-semibold leading-7 text-gray-900">
                            Chi phí: 1 lượt
                        </h2>
                    </div>
                    <div class="col-span-full" style="margin-bottom:2%">
                        <label for="about" class="block text-sm font-medium leading-6 text-gray-900">Mô tả của bạn:</label>
                        <div class="mt-2">
                        <textarea id="about" name="prompt" rows="3" class="p-1 block w-full rounded-md border py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" required></textarea>
                        </div>
                        <p class="mt-3 text-sm leading-6 text-gray-600">Vui lòng không nhập từ khóa nhạy cảm!</p>
                        <p class="mt-3 text-sm leading-6 text-gray-400">Chú ý việc mô tả của bạn rất quan trọng. Nếu bạn muốn tạo ra hình ảnh hoạt hình hay 3D hãy đảm bảo trong mô tả của bạn có từ: Anime, 3D...!</p>
                        @if (Session::has("SensitiveWord"))
                            <p class="mt-3 text-sm leading-6 text-red-600">Mô tả của bạn chứa từ khóa nhạy cảm! Không thể tạo ảnh</p>
                        @endif
                    </div>
                <div class="border-b border-gray-900/10 pb-12">
                    <div class="sm:col-span-3" style="margin-bottom:2%">
                        <label for="country" class="block text-sm font-medium leading-6 text-gray-900">Thể loại ảnh: </label>
                        <div class="mt-2">
                        <select id="country" name="model" autocomplete="country-name" class="block w-full rounded-md border py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6">
                            <option>Ảnh hoạt hình</option>
                            <option>Ảnh hình 3D</option>
                        </select>
                        </div>
                    </div>    

                    <div class="sm:col-span-3" style="margin-bottom:2%">
                        <label for="first-name" class="block text-sm font-medium leading-6 text-gray-900">Thông số Seed:</label>
                        <div class="mt-2">
                          <input type="number" name="seed" id="first-name" autocomplete="given-name" class="block w-full rounded-md border py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 p-1" required>
                          <button id="generate-seed" class="mt-2 px-4 py-2 bg-indigo-600 text-white rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Tạo Seed</button>
                          <p class="mt-3 text-sm leading-6 text-gray-600">Thông số Seed phải thay đổi sau mỗi lượt tạo ảnh nếu không ảnh sẽ không thay đổi</p>
                        </div>
                    </div>

                    <script>
                        document.getElementById('generate-seed').addEventListener('click', function() 
                        {
                            event.preventDefault();
                            const randomSeed = Math.floor(Math.random() * (99999999 - 11111111 + 1)) + 11111111;
                            document.getElementById('first-name').value = randomSeed;
                        });
                    </script>

                    <div>
                        <h2 class="text-base font-semibold leading-7 text-gray-900">Số lượng tạo ảnh:
                            {{ $ShowTimes }}
                        </h2>
                        <p class="mt-1 text-sm leading-6 text-gray-600">Nếu như hết lượt tạo ảnh bạn không thể tạo được ảnh! Số lượng sẽ được khôi phục vào ngày mai.</p>    
                    </div> 
                </div>
                <img id="loading-image" style="width:30%; margin:auto; display:none" src="/images/loading.gif" alt="Loading...">
            </div>
        
            <div class="mt-6 flex items-center justify-end gap-x-6">
                <a type="button" id="cancel" href="{{ route("showworkflow") }}" class="text-sm font-semibold leading-6 text-gray-900">Quay lại</a>
                <button type="submit" id="create" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Tạo ảnh</button>
            </div>
            <script>
                document.getElementById('create').addEventListener('click', function(event) {

                    event.preventDefault();
                    this.disabled = true;

                    document.getElementById('create').style.cursor = 'not-allowed';
                    document.getElementById('create').style.backgroundColor = '#6B6B6B';
                    document.getElementById('loading-image').style.display = 'block';
                    document.getElementById('G1').submit();

                    const cancelLink = document.getElementById('cancel');
                    cancelLink.style.pointerEvents = 'none';
                    cancelLink.style.opacity = '0.5';
                
                });
            </script>
        </div>
    </div>
</form>
@endsection