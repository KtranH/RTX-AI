<html>
<div class="text-lg font-semibold mb-3">Thông Báo</div>
<div class="max-h-64 overflow-y-auto">
    <ul id="js-notification-main">
        @if (isset($user))
            @php
                $data = \App\Models\Notification::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
            @endphp
            @foreach ($data as $item)
                <li class="py-2 flex">
                    <a href="#" class="flex items-center w-full hover:bg-gray-100 p-2 rounded">
                        <img class="h-6 w-6 rounded-full ring-2 ring-white mr-2"
                            src="https://pub-d9195d29f33243c7a4d4c49fe887131e.r2.dev/default_avatar.jpg" alt="">
                        <p class="font-semibold text-gray-700">{{ json_decode($item->data)->message ?? 'abc' }}</p>
                    </a>
                </li>
            @endforeach
        @endif
    </ul>
</div>

</html>
