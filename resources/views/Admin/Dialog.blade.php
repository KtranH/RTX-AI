<!-- Notification Dialog -->
<div id="notification-dialog" class="hidden fixed top-0 left-0 w-full h-full bg-gray-800 bg-opacity-50 flex flex-col items-center justify-center">
    <div class="bg-white rounded-lg w-[500px]">
        <div id="title-notificationDialog" class="bg-green-700 rounded-t-lg text-white font-bold text-center text-xl p-2"></div>
        <div id="content-notificationDialog" class="flex flex-col items-center justify-center h-24 py-2 px-4 text-lg text-center"></div>
        <div class="flex flex-row items-center justify-center p-2 space-x-4">
            <button id="confirm-notificationDialog" class="flex flex-row items-center space-x-2 bg-green-700 border-2 border-green-700 hover:bg-white hover:!text-green-700 rounded px-3 py-1 text-white text-lg font-medium"> 
                <i class="fa-solid fa-circle-check text-xl text-current"></i>
                <div>Xác Nhận</div>
            </button>
        </div>
    </div>
</div>  
<script>
    function SetNotificationDialog(state, message) 
    {
        const dialog = $('#notification-dialog');
        const title = $('#title-notificationDialog');
        const content = $('#content-notificationDialog');
        const confirmButton = $('#confirm-notificationDialog');

        title.removeClass('bg-green-700 bg-red-700 bg-yellow-700');
        confirmButton.removeClass('bg-green-700 border-green-700 hover:!text-green-700');
        confirmButton.removeClass('bg-red-700 border-red-700 hover:!text-red-700');
        confirmButton.removeClass('bg-yellow-700 border-yellow-700 hover:!text-yellow-700');
        confirmButton.removeClass('bg-indigo-700 border-indigo-700 hover:!text-indigo-700');

        if (state === 'success') 
        {
            title.addClass('bg-green-700').text('THÀNH CÔNG');
            confirmButton.addClass('bg-green-700 border-green-700 hover:!text-green-700');
        } 
        else if (state === 'failure') 
        {
            title.addClass('bg-red-700').text('THẤT BẠI');
            confirmButton.addClass('bg-red-700 border-red-700 hover:!text-red-700');
        } 
        else if (state === 'warning') 
        {
            title.addClass('bg-yellow-700').text('CẢNH BÁO');
            confirmButton.addClass('bg-yellow-700 border-yellow-700 hover:!text-yellow-700');
        }
        else if (state === 'special') 
        {
            title.addClass('bg-indigo-700').text('ĐẶC BIỆT');
            confirmButton.addClass('bg-indigo-700 border-indigo-700 hover:!text-indigo-700');
        }

        content.text(message);

        dialog.removeClass('hidden');
    }

    $(document).ready(function () 
    {
        $('#confirm-notificationDialog').on('click', function (e) 
        {
            e.preventDefault();

            $('#notification-dialog').addClass('hidden');
        });
    });
</script>

<!-- Image Dialog -->
<div id="image-dialog" class="hidden fixed top-0 left-0 w-full h-full bg-gray-800 bg-opacity-50 flex flex-col items-center justify-center">
    <div class="bg-white rounded-2xl w-[500px] h-[600px] flex flex-col items-center justify-between space-y-4 border-[7px] border-indigo-700">
        <div class="w-[500px] h-[500px] p-4">   
            <img id="image-imageDialog" src="https://picsum.photos/id/237/200" alt="Image" class="aspect-square w-full h-full rounded-2xl border-2 border-gray-200">
        </div>
        <div class="flex flex-row items-center justify-center px-4 pb-10">
            <button id="confirm-imageDialog" class="flex flex-row items-center space-x-2 bg-indigo-700 border-2 border-indigo-700 hover:bg-white hover:!text-indigo-700 rounded px-3 py-1 text-white text-lg font-medium"> 
                <i class="fa-solid fa-circle-check text-xl text-current"></i>
                <div>Xác Nhận</div>
            </button>
        </div>
    </div>
</div>  
<script>
    $(document).ready(function () 
    {
        $('#confirm-imageDialog').on('click', function (e) 
        {
            e.preventDefault();

            $('#image-dialog').addClass('hidden');
        });
    });
</script>