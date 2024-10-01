<html>
    <div class="text-lg font-semibold mb-3">Thông Báo</div>
    <div class="max-h-64 overflow-y-auto">
        <ul>
            @for ($i = 0; $i <= 5; $i++)
                <li class="py-2 flex">
                    <a href="#" class="flex items-center w-full hover:bg-gray-100 p-2 rounded">
                        <img class="h-6 w-6 rounded-full ring-2 ring-white mr-2" src="{{ $user->avatar_url }}" alt="">
                        <p class="font-semibold text-gray-700">{{ $user->username }}</p>
                    </a>
                </li>
            @endfor
        </ul>
    </div>
</html>



