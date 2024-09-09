@if ($photos == 0)
    <div class="mt-2 grid gap-2">
    <div style="display:flex;margin-top:2%">
        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="width:80px; margin-right:1%">
            <path d="M22.71,6.29a1,1,0,0,0-1.42,0L20,7.59V2a1,1,0,0,0-2,0V7.59l-1.29-1.3a1,1,0,0,0-1.42,1.42l3,3a1,1,0,0,0,.33.21.94.94,0,0,0,.76,0,1,1,0,0,0,.33-.21l3-3A1,1,0,0,0,22.71,6.29ZM19,13a1,1,0,0,0-1,1v.38L16.52,12.9a2.79,2.79,0,0,0-3.93,0l-.7.7L9.41,11.12a2.85,2.85,0,0,0-3.93,0L4,12.6V7A1,1,0,0,1,5,6h8a1,1,0,0,0,0-2H5A3,3,0,0,0,2,7V19a3,3,0,0,0,3,3H17a3,3,0,0,0,3-3V14A1,1,0,0,0,19,13ZM5,20a1,1,0,0,1-1-1V15.43l2.9-2.9a.79.79,0,0,1,1.09,0l3.17,3.17,0,0L15.46,20Zm13-1a.89.89,0,0,1-.18.53L13.31,15l.7-.7a.77.77,0,0,1,1.1,0L18,17.21Z" fill="#6563ff"/>
        </svg>
        <h3 style="margin-top:30px;font-size:20px;" class="text-gray-500"> Bạn chưa có bất kì ảnh nào. Hãy tạo album và đăng ảnh ngay!</h3>
    </div>
@else

<style>
  .bd-placeholder-img {
    font-size: 1.125rem;
    text-anchor: middle;
    -webkit-user-select: none;
    -moz-user-select: none;
    user-select: none;
  }

  @media (min-width: 768px) {
    .bd-placeholder-img-lg {
      font-size: 3.5rem;
    }
  }

  .btn_logout
  {
      border-radius: 30px;
      font-weight: bold;
  }
  .nav_name2
  {
      display: none;
  }

  @media only screen and (max-width: 600px) 
  {
      .nav_name
      {
          display:none;
      }
      .nav_name2
      {
          display:block;
          color:white;
      }
  }
</style>

<style>
    .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
    }

    @media (min-width: 768px) {
        .bd-placeholder-img-lg {
            font-size: 3.5rem;
        }
    }
</style>

<div class="relative isolate px-6 pt-14 lg:px-8">
    <div class="absolute inset-x-0 -top-5 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-5" aria-hidden="true">
        <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
    </div>
</div>

<a href="{{ route("showboard") }}" class="text-center w-48 h-14 relative font-sans text-black text-xl font-semibold group">
    <div class="bg-black h-12 w-1/4 flex items-center justify-center absolute left-1 top-[4px] group-hover:!bg-[#a000ff] group-hover:w-[184px] z-10 duration-500 rounded-2xl">
        <svg width="25px" height="25px" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg">
            <path fill="#ffffff" d="M224 480h640a32 32 0 1 1 0 64H224a32 32 0 0 1 0-64z"></path>
            <path fill="#ffffff" d="m237.248 512 265.408 265.344a32 32 0 0 1-45.312 45.312l-288-288a32 32 0 0 1 0-45.312l288-288a32 32 0 1 1 45.312 45.312L237.248 512z"></path>
        </svg>
    </div>
    <p class="translate-x-2" style="margin-top:12px">Quay lại</p>
</a>

<div class="flex items-center justify-center">
                <div class="w-full max-w-2xl px-4 py-4 sm:px-6 sm:py-6 lg:max-w-7xl lg:px-16">
                    <div class="font-bold text-3xl">Ảnh nổi bật</div>
                    @if (count($feature) == 0)
                        <div class="mt-2 grid gap-2">
                            <div style="display:flex;margin-top:2%">
                                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="width:80px; margin-right:1%">
                                    <path d="M22.71,6.29a1,1,0,0,0-1.42,0L20,7.59V2a1,1,0,0,0-2,0V7.59l-1.29-1.3a1,1,0,0,0-1.42,1.42l3,3a1,1,0,0,0,.33.21.94.94,0,0,0,.76,0,1,1,0,0,0,.33-.21l3-3A1,1,0,0,0,22.71,6.29ZM19,13a1,1,0,0,0-1,1v.38L16.52,12.9a2.79,2.79,0,0,0-3.93,0l-.7.7L9.41,11.12a2.85,2.85,0,0,0-3.93,0L4,12.6V7A1,1,0,0,1,5,6h8a1,1,0,0,0,0-2H5A3,3,0,0,0,2,7V19a3,3,0,0,0,3,3H17a3,3,0,0,0,3-3V14A1,1,0,0,0,19,13ZM5,20a1,1,0,0,1-1-1V15.43l2.9-2.9a.79.79,0,0,1,1.09,0l3.17,3.17,0,0L15.46,20Zm13-1a.89.89,0,0,1-.18.53L13.31,15l.7-.7a.77.77,0,0,1,1.1,0L18,17.21Z" fill="#6563ff"/>
                                </svg>
                                <h3 style="margin-top:30px;font-size:20px;" class="text-gray-500">Bạn chưa có ảnh nào được đặt làm ảnh nổi bật!</h3>
                            </div>
                        </div>
                    @else
                        <div class="mt-2 gap-2 featured-photos">
                            @foreach ($feature as $x)
                                <div class="col-span-3 row-span-1 relative group">
                                    <a href="{{ route('showimage', ['id' => $x->id]) }}">
                                        <div class="aspect-square">
                                            <img src="{{ $x->url }}" alt="Image 1" class="w-full h-full object-cover transition-opacity duration-300 group-hover:opacity-15">
                                        </div>
                                        <div class="absolute inset-0 flex flex-col justify-between opacity-0 group-hover:opacity-100 group-hover:!opacity-100 transition-opacity duration-300">
                                            <div class="mt-2 text-left px-2 py-1">
                                                <div class="font-semibold text-lg truncate group-hover:text-[#000000]">{{ $x->title }}</div>
                                                <div class="text-sm text-gray-500 h-20 overflow-hidden">{{ $x->description }}</div>
                                            </div>
                                        </div>
                                    </a>    
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>