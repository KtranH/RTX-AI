@extends('Admin.Container')
@section('Content')

<title>RTX-ADMIN: Tổng Quan</title>

<div class="w-full h-full flex flex-col justify-between space-y-4 p-2 divide-y-4 divide-indigo-700 cursor-default">
    <!-- Header -->
    <div class="h-10 py-2 px-8 flex items-center text-2xl font-bold">TỔNG QUAN</div>
    <!-- Content -->
    <div class="h-full overflow-y-auto p-2 space-y-4 snap-y snap-mandatory scroll-smooth">
        <!-- Quick Number -->
        <div class="grid grid-cols-4 h-36 space-x-4 p-2 snap-start snap-always">
            <div class="flex flex-row items-center justify-between rounded-2xl bg-white py-2 px-4 shadow-md border-2 border-gray-200">
                <div class="basis-1/4 flex items-center justify-center">
                    <div class="flex items-center justify-center bg-green-600 rounded-full p-3">
                        <i class="fa-solid fa-images text-[50px] text-white"></i>
                    </div>
                </div>
                <div class="basis-3/4 text-center">
                    <div class="font-medium text-lg">SỐ ALBUM</div>
                    <div class="text-3xl">{{ $countAlbum }}</div>
                </div>
            </div>
            <div class="flex flex-row items-center justify-between rounded-2xl bg-white py-2 px-4 shadow-md border-2 border-gray-200">
                <div class="basis-1/4 flex items-center justify-center">
                    <div class="flex items-center justify-center bg-red-600 rounded-full p-3">
                        <i class="fa-solid fa-globe text-5xl text-white"></i>
                    </div>
                </div>
                <div class="basis-3/4 text-center">
                    <div class="font-medium text-lg">BÀI ĐĂNG</div>
                    <div class="text-3xl">{{ $countImage }}</div>
                </div>
            </div>
            <div class="flex flex-row items-center justify-between rounded-2xl bg-white py-2 px-4 shadow-md border-2 border-gray-200">
                <div class="basis-1/4 flex items-center justify-center">
                    <div class="flex items-center justify-center bg-blue-600 rounded-full p-3">
                        <i class="fa-solid fa-chart-line text-[50px] text-white"></i>
                    </div>
                </div>
                <div class="basis-3/4 text-center">
                    <div class="font-medium text-lg">WORKFLOW</div>
                    <div class="text-3xl">{{ $countWorkFlow }}</div>
                </div>
            </div>
            <div class="flex flex-row items-center justify-between rounded-2xl bg-white py-2 px-4 shadow-md border-2 border-gray-200">
                <div class="basis-1/4 flex items-center justify-center">
                    <div class="flex items-center justify-center bg-yellow-600 rounded-full p-3">
                        <i class="fa-solid fa-circle-check text-[50px] text-white"></i>
                    </div>
                </div>
                <div class="basis-3/4 text-center">
                    <div class="font-medium text-lg">SỐ NGƯỜI DÙNG</div>
                    <div class="text-3xl">{{ $countUser }}</div>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-2 h-full space-x-4 p-2 snap-start snap-always">
            <!-- Albums -->
            <div class="flex flex-col items-center rounded-2xl bg-white px-4 shadow-md border-2 border-gray-200 space-y-2">
                <div class="w-full text-left font-semibold text-2xl border-b-2 border-gray-200 py-3">SỐ LƯỢNG ALBUMS</div>
                <div id="albums-container" class="w-full h-full py-3"></div>
            </div>
            <!-- Uploads -->
            <div class="flex flex-col items-center rounded-2xl bg-white px-4 shadow-md border-2 border-gray-200 space-y-2">
                <div class="w-full text-left font-semibold text-2xl border-b-2 border-gray-200 py-3">SỐ LƯỢNG BÀI ĐĂNG</div>
                <div id="uploads-container" class="w-full h-full py-3"></div>
            </div>
        </div>
        <div class="w-full space-x-4 p-2 h-full snap-start snap-always">
            <!-- Users -->
            <div class="h-full flex flex-col items-center rounded-2xl bg-white px-4 shadow-md border-2 border-gray-200 space-y-2">
                <div class="w-full flex flex-row items-center justify-between border-b-2 border-gray-200 py-3">
                    <div class="text-left font-semibold text-2xl">SỐ LƯỢNG NGƯỜI DÙNG</div>
                </div>
                <div id="users-container" class="w-full h-full py-3"></div>
            </div>
        </div>
    </div>
</div>

<script>
    //Charts Container
    var albumsContainer = document.getElementById('albums-container');
    var uploadsContainer = document.getElementById('uploads-container');
    var usersContainer = document.getElementById('users-container');

    //Charts
    var albumsChart = echarts.init(albumsContainer);
    var uploadsChart = echarts.init(uploadsContainer);
    var usersChart = echarts.init(usersContainer);

    //Options
    var albumsOptions = {
        tooltip: {
            trigger: 'item'
        },
        legend: {
            top: '5%',
            left: 'center'
        },
        series: [
            {
            name: 'Access From',
            type: 'pie',
            radius: ['40%', '70%'],
            avoidLabelOverlap: false,
            label: {
                show: false,
                position: 'center'
            },
            emphasis: {
                label: {
                show: true,
                fontSize: 40,
                fontWeight: 'bold'
                }
            },
            labelLine: {
                show: false
            },
            data: [
                { value: {!! json_encode($countAlbumPrivate) !!}, name: 'Riêng tư' },
                { value: {!! json_encode($countAlbumPublic) !!}, name: 'Công khai' }
            ]
            }
        ]
    };
    var uploadsOptions = {
        xAxis: {
            type: 'category',
            data: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
        },
        yAxis: {
            type: 'value'
        },
        series: [
            {
                data: {!! json_encode($formattedPhotosPerMonth) !!},
                type: 'bar',
                itemStyle: {
                    color: '#4338ca'
                }
            }
        ]
    };
    var usersOptions= {
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
                data: {!! json_encode($formattedUserPerMonth) !!},
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
    albumsChart.setOption(albumsOptions);
    uploadsChart.setOption(uploadsOptions);
    usersChart.setOption(usersOptions);

</script>

@endsection