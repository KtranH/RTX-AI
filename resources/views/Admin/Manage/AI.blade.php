@extends('Admin.Container')
@section('Content')

<title>RTX-ADMIN: Hình Ảnh</title>

<div class="w-full h-full flex flex-col justify-between space-y-4 p-2 divide-y-4 divide-indigo-700 cursor-default">
    <!-- Header -->
    <div class="h-10 py-2 px-8 flex items-center text-2xl font-bold">ẢNH AI</div>
    <!-- Content -->
    <div class="w-full h-full overflow-y-auto overflow-x-hidden p-2 space-y-4 snap-y snap-mandatory scroll-smooth">
        <div class="w-full h-full p-2 snap-start snap-always">
            <div class="flex flex-col items-center justify-start rounded-2xl bg-white px-4 shadow-md border-2 border-gray-200 space-y-2 h-full">
                <div class="w-full text-left font-semibold text-2xl border-b-2 border-gray-200 py-3">TẤT CẢ ẢNH AI</div>
                <!-- Display -->
                <div class="w-full h-[730px] overflow-auto pr-4">
                    <div class="grid grid-cols-4 gap-3 py-2" id="display-container">
                    </div>
                    <button id="load-more" class="w-full mt-4 px-6 py-2 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50">
                        Xem thêm
                    </button>
                    <div id="loading-imageAI" class="text-center my-4" style="display: none;">Đang tải thêm ảnh...</div>
                </div>
            </div>
        </div>
        <script>
       $(document).ready(function () {
            var page = 1;
            var isLoading = false;

            // Hàm tải báo cáo
            function loadAI() {
                if (isLoading) return;
                isLoading = true;

                $('#loading-imageAI').show();

                var url = `/api/admin/imageai?page=${page}`;  

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        const photoContainer = $('#display-container');
                        
                        if (data.photos.length === 0) {
                            $('#loading-imageAI').text('Không có ảnh nào để hiển thị.');
                        }

                        data.photos.forEach(photo => {
                            const photoHTML = `
                                <div class="w-full h-full cursor-pointer">
                                    <img src="${photo.url}" loading="lazy" alt="Image" class="image-display w-full h-full rounded-2xl border-2 border-gray-200 hover:!opacity-50">
                                </div>`;
                            photoContainer.append(photoHTML);
                        });

                        isLoading = false;
                        $('#loading-imageAI').hide();  

                        if (data.hasMorePages) {
                            page++; 
                        } else {
                            $('#load-more').hide();  
                        }
                    })
                    .catch(error => {
                        console.error('Lỗi khi tải ảnh:', error);
                        isLoading = false;
                        $('#loading-imageAI').hide(); 
                    });
            }

            window.addEventListener('load', () => {
                loadAI();  
            });

            $('#load-more').on('click', function() {
                loadAI();  
            });
        });
        </script>
        <!-- Chart -->
        <div class="w-full space-x-4 p-2 h-full snap-start snap-always">
            <div class="h-full flex flex-col items-center rounded-2xl bg-white px-4 shadow-md border-2 border-gray-200 space-y-2">
                <div class="w-full flex flex-row items-center justify-between border-b-2 border-gray-200 py-3">
                    <div class="text-left font-semibold text-2xl">SỐ LƯỢNG TẠO AI</div>
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
            data: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
        },
        yAxis: {
            type: 'value'
        },
        series: [
            {
                data: {!! json_encode($formattedPhotosPerMonth) !!},
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