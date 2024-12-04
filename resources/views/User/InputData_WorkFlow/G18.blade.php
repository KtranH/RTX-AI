@extends('User.Container')
@section('Body')
<title>RTX-AI: Sáng tạo hình ảnh</title>
<form id="G18" method="POST" action="{{ route("createg18") }}">
    @csrf
    <div class="bg-white">
        <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-16">
            <div class="space-y-12">
                <div class="border-b border-gray-900/10 pb-12">
                    <div style="margin-top:-5%" class="mb-8">
                        <h2 class="text-4xl font-bold tracking-tight text-gray-900 mb-2">{{ $G->name }}</h2>
                        <p class="text-2xs text-gray-500 tracking-tight">{{ $G->description }}</p>
                   </div>
                    <div style="margin-bottom:2%;">
                        <h2 class="text-base font-semibold leading-7 text-gray-900">
                            Chi phí: {{$Price}} lượt
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
                            <option>Tạo ảnh phòng ngủ</option>
                            <option>Tạo ảnh phòng khách</option>
                            <option>Tạo ảnh phòng tắm</option>
                            <option>Tạo ảnh phòng bếp</option>
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
                            const randomSeed = Math.floor(Math.random() * (9999999999 - 1111111111 + 1)) + 1111111111;
                            document.getElementById('first-name').value = randomSeed;
                        });
                    </script>

                    <div>
                        <h2 class="text-base font-semibold leading-7 text-gray-900">Số lượt tạo ảnh:
                            @if ($ShowTimes > 0)
                                <span>{{ $ShowTimes }}</span>
                            @else
                                <span class="text-red-600">{{ $ShowTimes }}</span>
                            @endif
                        </h2>
                        <p class="mt-1 text-sm leading-6 text-gray-600">Nếu như hết lượt tạo ảnh bạn không thể tạo được ảnh! Số lượng sẽ được khôi phục vào ngày mai.</p>    
                    </div> 
                </div>
                <img id="loading-image" style="width:30%; margin:auto; display:none" src="/images/loading.gif" alt="Loading...">
            </div>
            <div class="relative mt-4">
                <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                    <div id="progress-bar" class="h-full bg-indigo-600 rounded-full transition-all duration-300 ease-in-out" style="width: 0%;"></div>
                </div>
                <div class="flex justify-between text-xs font-medium text-gray-600 mt-1">
                    <div id="progress-text" class="mt-1 text-sm text-gray-600">0%</div>
                    <span class="font-bold text-indigo-600">100%</span>
                </div>
            </div>
            <div class="mt-6 flex items-center justify-end gap-x-6">
                <a type="button" id="cancel" href="{{ route("showcreativity") }}" class="text-sm font-semibold leading-6 text-gray-900">Quay lại</a>
                <button type="submit" id="create" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Tạo ảnh</button>
            </div>

            <script>
                document.getElementById('create').addEventListener('click', function(event) {
                    event.preventDefault();
                    
                    const promptValue = document.getElementById('about').value.trim();
                    const seedValue = document.getElementById('first-name').value.trim();
                    
                    if (!promptValue) {
                        alert('Vui lòng nhập mô tả của bạn!');
                        return;
                    }
                    
                    if (!seedValue) {
                        alert('Vui lòng nhập thông số Seed!');
                        return;
                    }

                    this.disabled = true;

                    document.getElementById('create').style.cursor = 'not-allowed';
                    document.getElementById('create').style.backgroundColor = '#6B6B6B';
                    document.getElementById('loading-image').style.display = 'block';

                    setTimeout(() => {
                        const progressBar = document.getElementById('progress-bar');
                        const progressText = document.getElementById('progress-text');
                        progressBar.style.width = '50%';
                        progressText.innerText = '50%';
                    }, 2000);

                    const formData = new FormData(document.getElementById('G18'));
                    fetch("{{ route('createg18') }}", {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const progressBar = document.getElementById('progress-bar');
                            const progressText = document.getElementById('progress-text');
                            progressBar.style.width = '80%';
                            progressText.innerText = '80%';
                            setTimeout(() => {
                                progressBar.style.width = '100%';
                                progressText.innerText = '100%'; 
                                window.location.href = data.redirect; 
                            }, 1000); 
                        } else {
                            if(data.message.includes('hết lượt'))
                            {
                                Swal.fire({
                                icon: 'error',
                                title: 'Thông báo',
                                text: data.message,
                                confirmButtonText: 'OK'
                            }).then((result) => { 
                                if (result.isConfirmed) {
                                    location.reload();  
                                }});
                            }
                            else
                            {
                                alert(data.message);
                                this.disabled = false;
                                document.getElementById('create').style.cursor = 'pointer';
                                document.getElementById('create').style.backgroundColor = '';
                                document.getElementById('loading-image').style.display = 'none';
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        this.disabled = false;
                        document.getElementById('create').style.cursor = 'pointer';
                        document.getElementById('create').style.backgroundColor = '';
                        document.getElementById('loading-image').style.display = 'none';
                    });
                });
            </script>
            <script>
                 window.addEventListener('beforeunload', function (event) {
                    if (!document.getElementById('create').disabled) {
                        event.preventDefault();
                        event.returnValue = 'Bạn có chắc chắn muốn rời khỏi trang này? Dữ liệu sẽ không được lưu!';
                    }
                });
            </script>
        </div>
    </div>
</form>
@endsection