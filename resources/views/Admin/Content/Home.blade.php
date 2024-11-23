@extends('Admin.Container')
@section('Content')

<title>RTX-ADMIN: Tổng Quan</title>

<div class="w-full h-full flex flex-col justify-between space-y-4 p-2 divide-y-4 divide-indigo-700 cursor-default">
    <!-- Header -->
    <div class="h-10 py-2 px-8 flex items-center text-2xl font-bold">TỔNG QUAN</div>
    <!-- Content -->
    <div class="h-full overflow-y-auto p-2 scroll-smooth">
        <!-- Quick Number -->
        <div class="grid grid-cols-4 h-36 space-x-4 p-2 snap-start">
            <div class="flex flex-row items-center justify-between rounded-2xl bg-white py-2 px-4 shadow-md border-2 border-gray-200">
                <div class="basis-1/4 flex items-center justify-center">
                    <div class="flex items-center justify-center bg-green-600 rounded-full p-3">
                        <i class="fa-solid fa-clock text-[50px] text-white"></i>
                    </div>
                </div>
                <div class="basis-3/4 text-center">
                    <div class="font-medium text-lg">ĐANG ONLINE</div>
                    <div class="text-3xl">100,000</div>
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
                    <div class="text-3xl">1,000</div>
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
                    <div class="text-3xl">25%</div>
                </div>
            </div>
            <div class="flex flex-row items-center justify-between rounded-2xl bg-white py-2 px-4 shadow-md border-2 border-gray-200">
                <div class="basis-1/4 flex items-center justify-center">
                    <div class="flex items-center justify-center bg-yellow-600 rounded-full p-3">
                        <i class="fa-solid fa-circle-check text-[50px] text-white"></i>
                    </div>
                </div>
                <div class="basis-3/4 text-center">
                    <div class="font-medium text-lg">SỐ MEMBER</div>
                    <div class="text-3xl">1,000</div>
                </div>
            </div>
        </div>
        <!-- Charts -->
        <div class="grid grid-cols-2 h-[710px] space-x-4 p-2">
            <!-- Albums -->
            <div class="flex flex-col items-center rounded-2xl bg-white py-3 px-4 shadow-md border-2 border-gray-200 space-y-2">
                <div class="w-full text-left font-semibold text-2xl border-b-2 border-gray-200 pb-2">SỐ LƯỢNG ALBUMS</div>
                <form id="albums-form" class="w-full flex flex-row items-center justify-between space-x-10 p-2 border-b-2 border-gray-200 pb-4 text-white">
                    <div class="w-72 space-y-1 text-black">
                        <label for="albums-fromDate" class="font-medium">Từ Ngày</label>
                        <input type="date" name="albums-fromDate" id="albums-fromDate" placeholder="" class="p-2 border-2 border-gray-500 focus:outline-none focus:border-indigo-700 rounded w-full">
                    </div>
                    <button type="submit" id="albums-submit" class="rounded-full bg-indigo-700 border-2 border-indigo-700  hover:bg-white hover:text-indigo-700 w-10 h-10">
                        <i class="fa-solid fa-arrow-right text-lg text-inherit"></i>
                    </button>
                    <div class="w-72 space-y-1 text-black">
                        <label for="albums-toDate" class="font-medium">Đến Ngày</label>
                        <input type="date" name="albums-toDate" id="albums-toDate" placeholder="" class="p-2 border-2 border-gray-500 focus:outline-none focus:border-indigo-700 rounded w-full">
                    </div>
                </form>
                <div id="albums-Container" class="w-full h-full"></div>
            </div>
            <!-- Uploads -->
            <div class="flex flex-col items-center rounded-2xl bg-white py-3 px-4 shadow-md border-2 border-gray-200 space-y-2">
                <div class="w-full text-left font-semibold text-2xl border-b-2 border-gray-200 pb-2">SỐ LƯỢNG BÀI ĐĂNG</div>
                <form id="uploads-form" class="w-full flex flex-row items-center justify-between space-x-10 p-2 border-b-2 border-gray-200 pb-4 text-white">
                    <div class="w-72 space-y-1 text-black">
                        <label for="uploads-fromDate" class="font-medium">Từ Ngày</label>
                        <input type="date" name="uploads-fromDate" id="uploads-fromDate" placeholder="" class="p-2 border-2 border-gray-500 focus:outline-none focus:border-indigo-700 rounded w-full">
                    </div>
                    <button type="submit" id="uploads-submit" class="rounded-full bg-indigo-700 border-2 border-indigo-700  hover:bg-white hover:text-indigo-700 w-10 h-10">
                        <i class="fa-solid fa-arrow-right text-lg text-inherit"></i>
                    </button>
                    <div class="w-72 space-y-1 text-black">
                        <label for="uploads-toDate" class="font-medium">Đến Ngày</label>
                        <input type="date" name="uploads-toDate" id="uploads-toDate" placeholder="" class="p-2 border-2 border-gray-500 focus:outline-none focus:border-indigo-700 rounded w-full">
                    </div>
                </form>
                <div id="uploads-Container" class="w-full h-full"></div>
            </div>
        </div>
        <!-- Charts -->
        <div class="w-full space-x-4 p-2">
            <!-- Users -->
            <div class="flex flex-col items-center rounded-2xl bg-white py-3 px-4 shadow-md border-2 border-gray-200 space-y-2">
                <div class="w-full flex flex-row items-center justify-between border-b-2 border-gray-200 pb-2">
                    <div class="text-left font-semibold text-2xl">SỐ LƯỢNG NGƯỜI DÙNG</div>
                    <form id="users-form" class="flex flex-row items-center justify-between space-x-4 text-white">
                        <label for="users-fromDate" class="font-medium text-black">Từ Ngày</label>
                        <input type="date" name="users-fromDate" id="users-fromDate" placeholder="" class="p-2 border-2 border-gray-500 focus:outline-none focus:border-indigo-700 rounded w-72 text-black">
                        <label for="users-toDate" class="font-medium text-black">Đến Ngày</label>
                        <input type="date" name="users-toDate" id="users-toDate" placeholder="" class="p-2 border-2 border-gray-500 focus:outline-none focus:border-indigo-700 rounded w-72 text-black">
                        <button type="submit" id="users-submit" class="rounded-full bg-indigo-700 border-2 border-indigo-700 hover:bg-white hover:text-indigo-700 w-10 h-10">
                            <i class="fa-solid fa-arrow-right text-lg text-inherit"></i>
                        </button>
                    </form>
                </div>
                <div id="users-Container" class="w-full h-[500px]"></div>
            </div>
        </div>
        <!-- Charts -->
        <div class="grid grid-cols-2 h-[710px] space-x-4 p-2">
            <!-- Workflows -->
            <div class="flex flex-col items-center rounded-2xl bg-white py-3 px-4 shadow-md border-2 border-gray-200 space-y-2">
                <div class="w-full text-left font-semibold text-2xl border-b-2 border-gray-200 pb-2">SỐ LƯỢNG WORKFLOW</div>
                <form id="workflows-form" class="w-full flex flex-row items-center justify-between space-x-10 p-2 border-b-2 border-gray-200 pb-4 text-white">
                    <div class="w-72 space-y-1 text-black">
                        <label for="workflows-fromDate" class="font-medium">Từ Ngày</label>
                        <input type="date" name="workflows-fromDate" id="workflows-fromDate" placeholder="" class="p-2 border-2 border-gray-500 focus:outline-none focus:border-indigo-700 rounded w-full">
                    </div>
                    <button type="submit" id="workflows-submit" class="rounded-full bg-indigo-700 border-2 border-indigo-700  hover:bg-white hover:text-indigo-700 w-10 h-10">
                        <i class="fa-solid fa-arrow-right text-lg text-inherit"></i>
                    </button>
                    <div class="w-72 space-y-1 text-black">
                        <label for="workflows-toDate" class="font-medium">Đến Ngày</label>
                        <input type="date" name="workflows-toDate" id="workflows-toDate" placeholder="" class="p-2 border-2 border-gray-500 focus:outline-none focus:border-indigo-700 rounded w-full">
                    </div>
                </form>
                <div id="workflows-Container" class="w-full h-full"></div>
            </div>
            <!-- Members -->
            <div class="flex flex-col items-center rounded-2xl bg-white py-3 px-4 shadow-md border-2 border-gray-200 space-y-2">
                <div class="w-full text-left font-semibold text-2xl border-b-2 border-gray-200 pb-2">SỐ LƯỢNG THÀNH VIÊN</div>
                <form id="members-form" class="w-full flex flex-row items-center justify-between space-x-10 p-2 border-b-2 border-gray-200 pb-4 text-white">
                    <div class="w-72 space-y-1 text-black">
                        <label for="members-fromDate" class="font-medium">Từ Ngày</label>
                        <input type="date" name="members-fromDate" id="members-fromDate" placeholder="" class="p-2 border-2 border-gray-500 focus:outline-none focus:border-indigo-700 rounded w-full">
                    </div>
                    <button type="submit" id="members-submit" class="rounded-full bg-indigo-700 border-2 border-indigo-700  hover:bg-white hover:text-indigo-700 w-10 h-10">
                        <i class="fa-solid fa-arrow-right text-lg text-inherit"></i>
                    </button>
                    <div class="w-72 space-y-1 text-black">
                        <label for="members-toDate" class="font-medium">Đến Ngày</label>
                        <input type="date" name="members-toDate" id="members-toDate" placeholder="" class="p-2 border-2 border-gray-500 focus:outline-none focus:border-indigo-700 rounded w-full">
                    </div>
                </form>
                <div id="members-Container" class="w-full h-full"></div>
            </div>
        </div>
    </div>
</div>

<script>
    //Charts Container
    var albumsContainer = document.getElementById('albums-Container');
    var uploadsContainer = document.getElementById('uploads-Container');
    var workflowsContainer = document.getElementById('workflows-Container');
    var membersContainer = document.getElementById('members-Container');
    var usersContainer = document.getElementById('users-Container');

    //Charts
    var albumsChart = echarts.init(albumsContainer);
    var uploadsChart = echarts.init(uploadsContainer);
    var workflowsChart = echarts.init(workflowsContainer);
    var membersChart = echarts.init(membersContainer);
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
                { value: 1048, name: 'Search Engine' },
                { value: 735, name: 'Direct' },
                { value: 580, name: 'Email' },
                { value: 484, name: 'Union Ads' },
                { value: 300, name: 'Video Ads' }
            ]
            }
        ]
    };
    var uploadsOptions = {
        xAxis: {
            type: 'category',
            data: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']
        },
        yAxis: {
            type: 'value'
        },
        series: [
            {
            data: [120, 200, 150, 80, 70, 110, 130],
            type: 'bar',
            itemStyle: {
                color: '#4338ca'
            }
            }
        ]
    };
    var workflowsOptions = {
        xAxis: {
            type: 'category',
            data: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']
        },
        yAxis: {
            type: 'value'
        },
        series: [
            {
            data: [120, 200, 150, 80, 70, 110, 130],
            type: 'bar',
            itemStyle: {
                color: '#4338ca'
            }
            }
        ]
    };
    var membersOptions= {
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
    var usersOptions= {
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
    albumsChart.setOption(albumsOptions);
    uploadsChart.setOption(uploadsOptions);
    workflowsChart.setOption(workflowsOptions);
    membersChart.setOption(membersOptions);
    usersChart.setOption(usersOptions);

</script>



@endsection