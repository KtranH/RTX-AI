@extends('Admin.Container')
@section('Content')

<title>RTX-ADMIN: Hình Ảnh</title>

<div class="w-full h-full flex flex-col justify-between space-y-4 p-2 divide-y-4 divide-indigo-700 cursor-default">
    <!-- Header -->
    <div class="h-10 py-2 px-8 flex items-center text-2xl font-bold">ẢNH AI</div>
    <!-- Content -->
    <div class="w-full h-full overflow-y-auto overflow-x-hidden p-2 space-y-4 snap-y snap-mandatory scroll-smooth">
        <!-- Weekly -->
        <div class="w-full h-full p-2 snap-start snap-always">
            <div class="flex flex-col items-center justify-start rounded-2xl bg-white px-4 shadow-md border-2 border-gray-200 space-y-2 h-full">
                <div class="w-full text-left font-semibold text-2xl border-b-2 border-gray-200 py-3">ẢNH AI THEO TUẦN</div>
                <!-- Display -->
                <div class="w-full h-[730px] overflow-auto pr-4">
                    <div class="grid grid-cols-4 gap-3 py-2">
                        @for($i = 0; $i < 150; $i++)
                            <div class="w-full h-full cursor-pointer">
                                <img src="https://picsum.photos/id/{{$i + 10}}/200" alt="Image" class="image-display w-full h-full rounded-2xl border-2 border-gray-200 hover:!opacity-50">
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
        <!-- Weekly -->
        <div class="w-full h-full p-2 snap-start snap-always">
            <div class="flex flex-col items-center justify-start rounded-2xl bg-white px-4 shadow-md border-2 border-gray-200 space-y-2 h-full">
                <div class="w-full text-left font-semibold text-2xl border-b-2 border-gray-200 py-3">TẤT CẢ ẢNH AI</div>
                <!-- Display -->
                <div class="w-full h-[730px] overflow-auto pr-4">
                    <div class="grid grid-cols-4 gap-3 py-2">
                        @for($i = 0; $i < 150; $i++)
                            <div class="w-full h-full cursor-pointer">
                                <img src="https://picsum.photos/id/{{$i + 20}}/200" alt="Image" class="image-display w-full h-full rounded-2xl border-2 border-gray-200 hover:!opacity-50">
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
        <!-- Chart -->
        <div class="w-full space-x-4 p-2 h-full snap-start snap-always">
            <div class="h-full flex flex-col items-center rounded-2xl bg-white px-4 shadow-md border-2 border-gray-200 space-y-2">
                <div class="w-full flex flex-row items-center justify-between border-b-2 border-gray-200 py-3">
                    <div class="text-left font-semibold text-2xl">SỐ LƯỢNG TẠO AI</div>
                    <form action="" id="chart-form" class="flex flex-row items-center justify-between space-x-4 text-white">
                        <label for="chart-fromDate" class="font-medium text-black">Từ Ngày</label>
                        <input type="date" name="chart-fromDate" id="chart-fromDate" placeholder="" class="p-2 border-2 border-gray-500 focus:outline-none focus:border-indigo-700 rounded w-72 text-black">
                        <label for="chart-toDate" class="font-medium text-black">Đến Ngày</label>
                        <input type="date" name="chart-toDate" id="chart-toDate" placeholder="" class="p-2 border-2 border-gray-500 focus:outline-none focus:border-indigo-700 rounded w-72 text-black">
                        <button type="submit" id="chart-submit" class="rounded-full bg-indigo-700 border-2 border-indigo-700 hover:bg-white hover:text-indigo-700 w-10 h-10">
                            <i class="fa-solid fa-arrow-right text-lg text-inherit"></i>
                        </button>
                    </form>
                </div>
                <div id="chart-container" class="w-full h-full py-3"></div>
            </div>
        </div>
    </div>
</div>
<script>
    //Search
    $(document).ready(function () 
    {
        $('#search-input').on('input', function () 
        {
            if ($(this).val().length > 0) 
            {
                $('#clear-icon').removeClass('hidden');
                console.log("a");
            } 
            else 
            {
                $('#clear-icon').addClass('hidden');
            }
        });

        $('#clear-icon').on('click', function () 
        {
            $('#search-input').val('');
            $('#clear-icon').addClass('hidden');
        });
    }); 

    //Display
    $(document).ready(function () 
    {
        $('.image-display').on('click', function (e) 
        {
            e.preventDefault();
            
            const image = $(this).attr('src');

            $('#image-dialog').removeClass('hidden');
            $('#image-imageDialog').attr('src', image);
        });
    });

    //Chart Container
    var chartContainer = document.getElementById('chart-container');

    //Chart
    var chartChart = echarts.init(chartContainer);

    //Chart Option
    var chartOptions= {
        xAxis: {
            type: 'category',
            boundaryGap: false,
            data: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']
        },
        yAxis: {
            type: 'value'
        },
        series: [
            {
                data: [820, 932, 901, 934, 1290, 1330, 1320],
                type: 'line',
                areaStyle: {
                    color: 'rgba(67, 56, 202, 0.5)'
                },
                lineStyle: {
                    color: '#4338ca'
                },
                itemStyle: {
                    color: '#4338ca'
                }
            }
        ]
    };

    //Add Options
    chartChart.setOption(chartOptions);
</script>

@endsection