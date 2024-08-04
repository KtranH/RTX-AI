@extends('User.Container')
@section('Body')
    <title>RTX-AI: Trang chủ</title>
    <h2 class="text-2xl font-bold tracking-tight text-gray-900 text-center">Khám phá cùng RTX-AI</h2>
    <h5 class="text-2xl tracking-tight text-gray-900 text-center" style="margin-bottom:-60px">Chia sẻ và tìm kiếm những bức ảnh nổi bật</h5>
    <main style="with:100%;height:100%">
        <div class="bg-white">
            <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-16">
              <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3 xl:gap-x-8">
                  <div class="group relative">
                    <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md bg-gray-200 lg:aspect-none group-hover:opacity-75 lg:h-80" style="height: 400px">
                      <img src="/images/landscape.png" alt="Front of men&#039;s Basic Tee in black." class="h-full w-full object-cover object-center lg:h-full lg:w-full">
                    </div>
                    <div class="mt-4 flex justify-between">
                      <div>
                        <h3 class="text-sm text-gray-700">
                          <a href="#">
                            <span aria-hidden="true" class="absolute inset-0"></span>
                           <p class="font-bold">
                             @foreach ($landscape as $x)
                                 <?php echo $x->name; ?>
                             @endforeach
                           </p>
                          </a>
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">
                        @foreach ($landscape as $x)
                            <?php echo $x->description; ?>
                        @endforeach
                        </p>
                      </div>
                    </div>
                  </div>
                  <div class="group relative">
                    <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md bg-gray-200 lg:aspect-none group-hover:opacity-75 lg:h-80" style="height: 400px">
                      <img src="/images/animal.png" alt="Front of men&#039;s Basic Tee in black." class="h-full w-full object-cover object-center lg:h-full lg:w-full">
                    </div>
                    <div class="mt-4 flex justify-between">
                      <div>
                        <h3 class="text-sm text-gray-700">
                          <a href="#">
                            <span aria-hidden="true" class="absolute inset-0"></span>
                            <p class="font-bold">
                              @foreach ($animal as $x)
                                  <?php echo $x->name; ?>
                              @endforeach
                            </p>
                          </a>
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">
                        @foreach ($animal as $x)
                            <?php echo $x->description; ?>
                        @endforeach
                        </p>
                      </div>
                    </div>
                  </div>
                  <div class="group relative">
                    <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md bg-gray-200 lg:aspect-none group-hover:opacity-75 lg:h-80" style="height: 400px">
                      <img src="/images/travel.png" alt="Front of men&#039;s Basic Tee in black." class="h-full w-full object-cover object-center lg:h-full lg:w-full">
                    </div>
                    <div class="mt-4 flex justify-between">
                      <div>
                        <h3 class="text-sm text-gray-700">
                          <a href="#">
                            <span aria-hidden="true" class="absolute inset-0"></span>
                            <p class="font-bold">
                              @foreach ($travel as $x)
                                  <?php echo $x->name; ?>
                              @endforeach
                            </p>
                          </a>
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">
                          @foreach ($travel as $x)
                              <?php echo $x->description; ?>
                          @endforeach
                        </p>
                      </div>
                    </div>
                  </div>
                  <div class="group relative">
                    <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md bg-gray-200 lg:aspect-none group-hover:opacity-75 lg:h-80" style="height: 400px">
                      <img src="/images/tech.png" alt="Front of men&#039;s Basic Tee in black." class="h-full w-full object-cover object-center lg:h-full lg:w-full">
                    </div>
                    <div class="mt-4 flex justify-between">
                      <div>
                        <h3 class="text-sm text-gray-700">
                          <a href="#">
                            <span aria-hidden="true" class="absolute inset-0"></span>
                            <p class="font-bold"> 
                              @foreach ($tech as $x)
                                  <?php echo $x->name; ?>
                              @endforeach
                            </p>
                          </a>
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">
                          @foreach ($tech as $x)
                            <?php echo $x->description; ?>
                          @endforeach
                        </p>
                      </div>
                    </div>
                  </div>
                  <div class="group relative">
                    <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md bg-gray-200 lg:aspect-none group-hover:opacity-75 lg:h-80" style="height: 400px">
                      <img src="/images/fashion.png" alt="Front of men&#039;s Basic Tee in black." class="h-full w-full object-cover object-center lg:h-full lg:w-full">
                    </div>
                    <div class="mt-4 flex justify-between">
                      <div>
                        <h3 class="text-sm text-gray-700">
                          <a href="#">
                            <span aria-hidden="true" class="absolute inset-0"></span>
                            <p class="font-bold">
                              @foreach ($fashion as $x)
                                  <?php echo $x->name; ?>
                              @endforeach
                            </p>
                          </a>
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">
                          @foreach ($fashion as $x)
                                <?php echo $x->description; ?>
                          @endforeach
                        </p>
                      </div>
                    </div>
                  </div>
                  <div class="group relative">
                    <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md bg-gray-200 lg:aspect-none group-hover:opacity-75 lg:h-80" style="height: 400px">
                      <img src="/images/city.png" alt="Front of men&#039;s Basic Tee in black." class="h-full w-full object-cover object-center lg:h-full lg:w-full">
                    </div>
                    <div class="mt-4 flex justify-between">
                      <div>
                        <h3 class="text-sm text-gray-700">
                          <a href="#">
                            <span aria-hidden="true" class="absolute inset-0"></span>
                            <p class="font-bold">
                              @foreach ($city as $x)
                                  <?php echo $x->name; ?>
                              @endforeach
                            </p>
                          </a>
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">
                          @foreach ($city as $x)
                                <?php echo $x->description; ?>
                          @endforeach
                        </p>
                      </div>
                    </div>
                  </div>
                <!-- More products... -->
              </div>
            </div>
        </div>
    </main>
@endsection