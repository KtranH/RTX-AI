@extends('User.Container')
@section('Body')
<title>RTX-AI: Sáng tạo hình ảnh</title>
<form>
    @csrf
    <div class="bg-white">
        <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-16">
            <div class="space-y-12" style="margin-top:-5%">
                <div class="border-b border-gray-900/10 pb-12">
                    <div class="mt-6 space-y-12 lg:grid lg:grid-cols-1 lg:gap-x-6 lg:space-y-0">
                        <div class="group relative">
                          <div class="relative h-100 w-full overflow-hidden rounded-lg bg-white sm:aspect-h-1 sm:aspect-w-2 lg:aspect-h-1 lg:aspect-w-1 group-hover:opacity-75 sm:h-64" style="display:flex;flex-wrap:wrap;">
                            @if ($url == null)
                                <img src="/images/loading.gif" alt="Desk with leather desk pad, walnut desk organizer, wireless keyboard and mouse, and porcelain mug." class="h-full w-full object-cover object-center">
                            @else
                                <img src="{{ $url }}" alt="Desk with leather desk pad, walnut desk organizer, wireless keyboard and mouse, and porcelain mug." style="width:400px;border-radius:10px" class="object-cover object-center">
                            @endif
                            <style>
                                .responsive-div 
                                {
                                    margin-left: 5%;
                                    width: 62%;
                                }
                                @media only screen and (max-width: 600px) 
                                {
                                    .responsive-div 
                                    {
                                        margin-top:2%;
                                        margin-left: 0;
                                        width: 100%;
                                    }
                                }
                            </style>
                            <div class="responsive-div">
                                <h2 class="text-4xl font-bold tracking-tight text-gray-900 mb-2">{{ $G->name }}</h2>
                                <p class="text-2xs text-gray-500 tracking-tight mb-2">{{ $G->description }}</p>
                                <p class="text-xl font-semibold text-gray-900" style="margin-top:5%">Mô tả:</p>
                                <textarea style="margin-top:1%" id="about" name="prompt" rows="3" class="p-1 block w-full rounded-md border py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" readonly>{{ $prompt }}</textarea>
                                <p class="text-xl font-semibold text-gray-900" style="margin-top:1%">Mô hình:</p>
                                <input style="margin-top:1%" type="text" name="seed" id="first-name" autocomplete="given-name" class="block w-full rounded-md border py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 p-1" value="{{ $model }}" readonly>
                                <p class="text-xl font-semibold text-gray-900" style="margin-top:1%">Thông số seed:</p>
                                <input style="margin-top:1%" type="text" name="seed" id="first-name" autocomplete="given-name" class="block w-full rounded-md border py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 p-1" value="{{ $seed }}" readonly>
                                <div style="margin-top:2%">
                                    <img src="https://t4.ftcdn.net/jpg/03/58/90/89/360_F_358908973_k9y31m50zOnbIMOZYEEyNLBPbRanQig1.jpg" alt="" style="width:30%;margin-left:-5%">
                                    <p class="mt-1 text-sm text-gray-500" style="width:100%">Hình ảnh được tạo bởi AI là một công cụ hỗ trợ sáng tạo. Người dùng có trách nhiệm chỉnh sửa và tùy biến các hình ảnh này để phù hợp với mục đích sử dụng của mình. Chúng tôi không đảm bảo bản quyền đối với các hình ảnh được tạo ra.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-6 flex items-center justify-end gap-x-6">
            <a type="button" href="{{ route("g" . $G->id) }}" style="margin-right:2%" class="text-sm font-semibold leading-6 text-gray-900">Tạo lại</a>
            <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Chia sẻ</button> 
        </div>
    </div>
</form>
@endsection