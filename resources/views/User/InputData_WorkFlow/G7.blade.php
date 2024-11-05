@extends('User.Container')
@section('Body')
<title>RTX-AI: Sáng tạo hình ảnh</title>

<form id="G7" method="POST" enctype="multipart/form-data" action="{{ route("createg7") }}">
    @csrf
    <div class="bg-white">
        <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-16">
            <div class="space-y-12">
                <div class="border-b border-gray-900/10 pb-12">
                    <div style="margin-top:-5%" class="mb-8">
                        <h2 class="text-4xl font-bold tracking-tight text-gray-900 mb-2">{{ $G->name }}</h2>
                        <p class="text-2xs font-gray-500 tracking-tight">{{ $G->description }}</p>
                   </div>
                    <div style="margin-bottom:2%;">
                        <h2 class="text-base font-semibold leading-7 text-gray-900">
                            Chi phí: {{$Price}} lượt
                        </h2>
                    </div>

                    <div class="col-span-full">
                        <label for="cover-photo" class="block text-sm font-medium leading-6 text-gray-900">Ảnh của bạn:</label>
                        <div class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10 drag-image">
                            <div class="text-center @error('categories') is-invalid @enderror">
                                <svg class="mx-auto h-12 w-12 text-gray-300" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" id="icon-image">
                                <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 6v12a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 18V6zM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0021 18v-1.94l-2.69-2.689a1.5 1.5 0 00-2.12 0l-.88.879.97.97a.75.75 0 11-1.06 1.06l-5.16-5.159a1.5 1.5 0 00-2.12 0L3 16.061zm10.125-7.81a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0z" clip-rule="evenodd" />
                                </svg>
                                <div class="mt-4 flex text-sm leading-6 text-gray-600">
                                    <div>
                                        <h6 class="h6_image">Kéo thả ảnh vào đây</h6>
                                        <span>Hoặc</span>
                                        <button style="font-weight:bold;color:#631CB3" class="button_image">Chọn ảnh</button>
                                        <input type="file" class="input_image" hidden>
                                    </div>
                                </div>
                                <p class="text-xs leading-5 text-gray-600">PNG, JPG, GIF</p>
                            </div>
                        </div>
                        @error('input')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <input type="file" name="input" id="input_image" required hidden>
                    </div>
                        
                    <script>
                        const dropArea = document.querySelector(".drag-image"),
                        dragText = document.querySelector(".h6_image"),
                        button = document.querySelector(".button_image"),
                        input = document.querySelector(".input_image");
                        let file; 

                        button.onclick = ()=>{
                            input.click(); 
                            }

                        input.addEventListener("change", function(){
                            
                            file = this.files[0];
                            dropArea.classList.add("active");

                            var fileInput = document.getElementById('input_image');
                            var fileList = new DataTransfer();
                            fileList.items.add(this.files[0]);
                            fileInput.files = fileList.files;

                            viewfile();
                            });

                        dropArea.addEventListener("dragover", (event)=>{
                            event.preventDefault();
                            dropArea.classList.add("active");
                            dragText.textContent = "Thả ảnh ra trong đây";
                            });


                         dropArea.addEventListener("dragleave", ()=>{
                            dropArea.classList.remove("active");
                            dragText.textContent = "Kéo thả ảnh vào đây";
                            }); 

                        dropArea.addEventListener("drop", (event)=>{                         
                            event.preventDefault(); 
                            file = event.dataTransfer.files[0];

                            PutIntoInput()
                            viewfile(); 
                            });

                        function PutIntoInput()
                        {
                            var fileInput = document.getElementById('input_image');
                            var fileList = new DataTransfer();
                            fileList.items.add(event.dataTransfer.files[0]);
                            fileInput.files = fileList.files;
                        }
                        function viewfile()
                        {
                            let fileType = file.type; 
                            let validExtensions = ["image/jpeg", "image/jpg", "image/png"];
                            if(validExtensions.includes(fileType)){ 
                                let fileReader = new FileReader(); 
                                fileReader.onload = ()=>{
                                let fileURL = fileReader.result; 
                                let imgTag = `<img src="${fileURL}" alt="image" style="width: 25%;margin:auto;margin-top:-2%;margin-bottom:2%;border-radius:10px">`;
                                dropArea.innerHTML = imgTag; 
                                }
                                fileReader.readAsDataURL(file);                            

                            }else{
                                alert("This is not an Image File!");
                                dropArea.classList.remove("active");
                                dragText.textContent = "Lỗi không phải là ảnh";
                            }
                        }
                    </script>

                <div class="border-b border-gray-900/10 pb-12">

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
                            {{ $ShowTimes }}
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

                    const fileInput = document.getElementById('input_image');
                    
                    if (!fileInput.files.length) {
                        alert('Vui lòng tải ảnh của bạn lên!');
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

                    const formData = new FormData(document.getElementById('G7'));
                    fetch("{{ route('createg7') }}", {
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
                            alert(data.message);
                            this.disabled = false;
                            document.getElementById('create').style.cursor = 'pointer';
                            document.getElementById('create').style.backgroundColor = '';
                            document.getElementById('loading-image').style.display = 'none';
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