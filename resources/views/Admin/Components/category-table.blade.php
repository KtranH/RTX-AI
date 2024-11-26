<tbody class="align-top">
    @foreach ($allCategory as $item)
        <tr class="even:bg-gray-100 hover:bg-indigo-200 border-b-2">
            <td class="p-1 text-center align-middle">{{$item->id}}</td>
            <td class="p-1 text-center align-middle">{{ $item->name }}</td>
            <td class="p-1 align-middle truncate hover:overflow-visible hover:whitespace-normal hover:text-ellipsis text-justify">{{ $item->description }}</td>
            <td class="flex flex-row items-center justify-center space-x-2 p-1">
                <button data-id="{{$item->id}}" data-name="{{$item->name}}" data-description="{{$item->description}}" 
                    class="edit-button flex items-center bg-yellow-700 border-2 border-yellow-700 hover:bg-white hover:!text-yellow-700 rounded p-2 text-white text-lg font-medium">
                    <i class="fa-solid fa-pen text-current text-xs"></i>
                </button>
                <button data-id="{{$item->id}}" data-name="{{$item->name}}" data-description="{{$item->description}}" 
                    class="delete-button flex items-center bg-red-700 border-2 border-red-700 hover:bg-white hover:!text-red-700 rounded p-2 text-white text-lg font-medium">
                    <i class="fa-solid fa-trash text-current text-xs"></i>
                </button>
            </td>
        </tr>
    @endforeach
</tbody>