<html>
<div class="text-lg font-semibold mb-3">Thông Báo</div>
<div class="max-h-64 overflow-y-auto">
    <ul id="js-notification-main">
        @if (isset($user))
            @php
                $data = \App\Models\Notification::where('user_id', Auth::id())
                    ->orderBy('created_at', 'desc')
                    ->limit(3)
                    ->get();
            @endphp
            @foreach ($data as $item)
                <li class="py-2 flex">
                    <a href="{{ json_decode($item->data)->url }}" data-id="{{ $item->id }}"
                        onclick="readNotification(this, event)"
                        class="flex items-center w-full hover:bg-gray-100 p-2 rounded {{ $item->is_read == 0 ? 'bg-red-100' : '' }}">
                        <img class="h-6 w-6 rounded-full ring-2 ring-white mr-2"
                            src="{{ json_decode($item->data)->avatar_url ?? 'https://lh3.googleusercontent.com/a/ACg8ocLev1qQPI8GSu3HuQYV5frfYBAmMQX_Fej2vyRveWGMPofrZdar=s96-c' }}"
                            alt="">
                        <p class="font-semibold text-gray-700">{{ json_decode($item->data)->message ?? 'abc' }}</p>
                    </a>
                </li>
            @endforeach
            @if ($data->count() == 0)
                <li class="py-2 flex" id="no-notification">
                    <a href="#" class="flex items-center w-full hover:bg-gray-100 p-2 rounded">
                        <p class="font-semibold text-gray-300">Không có thông báo nào</p>
                    </a>
                </li>
            @endif

            <li class="py-2 flex justify-center items-center">
                <button type="button" onclick="getNotification()"
                    class="btn btn-dark font-bold rounded-full px-4 py-2 bg-gray-800 text-white hover:bg-gray-700">
                    <p class="font-semibold text-gray-300">Xem Thêm</p>
                </button>
            </li>

        @endif
    </ul>
</div>

</html>
