@extends('User.Container')
@section('Body')
<title>RTX-AI: Sáng tạo hình ảnh</title>
<main style="with:100%;height:100%">
    <div class="bg-white">
        <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-16">
           <div style="margin-top:-5%" class="text-center">
                <h2 class="text-4xl font-bold tracking-tight text-gray-900 mb-2" data-aos="fade-up">Khám phá cùng RTX-AI</h2>
                <p class="text-2xs text-gray-500 tracking-tight" data-aos="fade-up" data-aos-delay="300">Bắt đầu sáng tạo các hình ảnh bằng AI, và chia sẻ với những người khác.</p>
           </div>
          <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3 xl:gap-x-8" data-aos="fade-up" data-aos-delay="500">
            @foreach ( $workflow as $x )
              <div class="group relative">
                <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-2xl bg-gray-200 lg:aspect-none group-hover:opacity-75 lg:h-80" style="height: 400px">
                  <img src="{{ $x->image }}" loading="lazy" alt="Front of men&#039;s Basic Tee in black." class="h-full w-full object-cover object-center lg:h-full lg:w-full">
                </div>
                <div class="mt-4 flex justify-between">
                  <div>
                    <h3 class="text-sm text-gray-700">
                      <a href="{{ route('g'.$x->id) }}">
                        <span aria-hidden="true" class="absolute inset-0"></span>
                       <p class="font-bold">
                        {{ $x->name }}
                       </p>
                      </a>
                    </h3>
                    <p class="mt-1 text-sm text-gray-500">
                        {{ $x->description }}.
                    </p>
                  </div>
                </div>
              </div>
              @endforeach
            <!-- More products... -->
          </div>
          <div style="width:100%;margin-top:5%">
            {{ $workflow->links("vendor.pagination.tailwind") }}
          </div>
        </div>
    </div>
</main>
@endsection