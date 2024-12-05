<tbody class="align-top">
    @foreach ($listEmployee as $item)
        <tr class="even:bg-gray-100 hover:bg-indigo-200 border-b-2">
            <td class="px-1 pt-2 flex items-center justify-center h-[85.14px]"><img src="{{ $item->avatar_url }}" alt="" class="image-table cursor-pointer w-3/4 aspect-square rounded-full border-2 border-gray"></td>
            <td class="p-1 text-center align-middle">{{ $item->username }}</td>
            <td class="p-1 text-center align-middle">{{ $item->email }}</td>
            <td class="p-1 text-center align-middle">
                @if ($item->is_deleted == 1)
                    <span class="text-red-700 truncate hover:overflow-visible hover:whitespace-normal hover:text-ellipsis">Đã khóa</span>
                @else
                    <span class="text-green-700 text-bold truncate hover:overflow-visible hover:whitespace-normal hover:text-ellipsis">Hoạt động</span>
                @endif</td>
            <td class="p-1 text-center align-middle">{{ Date('d/m/Y', strtotime($item->created_at)) }}</td>
            <td class="p-1 text-center align-middle">{{ $item->adminRole->role_name }}</td>
            <td class="p-1">
                <div class="flex flex-row items-center justify-center space-x-2 w-full h-[85.14px]">
                    <button data-id="{{ $item->id }}" data-name="{{ $item->username }}" data-email="{{ $item->email }}" class="edit-button flex items-center bg-yellow-700 border-2 border-yellow-700 hover:bg-white hover:!text-yellow-700 rounded p-2 text-white text-lg font-medium">
                        <i class="fa-solid fa-pen text-current text-xs"></i>
                    </button>
                    <button data-id="{{ $item->id }}" data-name="{{ $item->username }}" data-lock="{{false}}" class="lock-button flex items-center bg-orange-700 border-2 border-orange-700 hover:bg-white hover:!text-orange-700 rounded p-2 text-white text-lg font-medium">
                        <i class="lock-icon fa-solid fa-lock text-current text-xs"></i>
                    </button>
                </div>
            </td>
        </tr>
     @endforeach
</tbody>