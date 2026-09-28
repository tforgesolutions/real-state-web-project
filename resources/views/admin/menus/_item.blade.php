<tr class="hover:bg-gray-50 border-b border-gray-100 {{ $level > 0 ? 'bg-gray-50/50' : '' }}">
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
        <form action="{{ route('admin.menus.update', $item->id) }}" method="POST" class="inline-block w-16" id="order-form-{{ $item->id }}">
            @csrf
            @method('PUT')
            <input type="hidden" name="name" value="{{ $item->name }}">
            <input type="hidden" name="url" value="{{ $item->url }}">
            <input type="hidden" name="parent_id" value="{{ $item->parent_id }}">
            <input type="hidden" name="target" value="{{ $item->target }}">
            @if($item->is_active)
            <input type="hidden" name="is_active" value="1">
            @endif
            <input type="number" name="order" value="{{ $item->order }}" class="w-full text-center border border-gray-200 rounded p-1 text-xs" onchange="document.getElementById('order-form-{{ $item->id }}').submit()">
        </form>
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
        <div class="flex items-center">
            @if($level > 0)
                <span class="text-gray-300 mr-2">└─</span>
            @endif
            <span class="text-sm font-medium text-gray-900">{{ $item->name }}</span>
        </div>
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
        {{ $item->url ?: '-' }}
        @if($item->target === '_blank') <i class="fas fa-external-link-alt text-xs ml-1"></i> @endif
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
        <form action="{{ route('admin.menus.toggle', $item->id) }}" method="POST" class="inline">
            @csrf
            @method('PATCH')
            <button type="submit" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $item->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                {{ $item->is_active ? 'Active' : 'Inactive' }}
            </button>
        </form>
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
        <button onclick="document.getElementById('editModal-{{ $item->id }}').classList.remove('hidden')" class="text-blue-600 hover:text-blue-900 mr-3">
            <i class="fas fa-edit"></i>
        </button>
        <form action="{{ route('admin.menus.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this menu item?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-red-600 hover:text-red-900">
                <i class="fas fa-trash-alt"></i>
            </button>
        </form>
    </td>
</tr>

<!-- Edit Modal -->
<div id="editModal-{{ $item->id }}" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="document.getElementById('editModal-{{ $item->id }}').classList.add('hidden')"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form action="{{ route('admin.menus.update', $item->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Edit Menu Item</h3>
                            <div class="mt-4 space-y-4 text-left">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Label <span class="text-red-500">*</span></label>
                                    <input type="text" name="name" value="{{ $item->name }}" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">URL / Route</label>
                                    <input type="text" name="url" value="{{ $item->url }}" placeholder="/properties" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Parent Item</label>
                                    <select name="parent_id" class="mt-1 block w-full bg-white border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                        <option value="">-- Top Level --</option>
                                        @foreach($parentOptions as $opt)
                                            @if($opt->id !== $item->id)
                                                <option value="{{ $opt->id }}" {{ $item->parent_id == $opt->id ? 'selected' : '' }}>{{ $opt->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Target</label>
                                    <select name="target" class="mt-1 block w-full bg-white border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                        <option value="_self" {{ $item->target == '_self' ? 'selected' : '' }}>Same Tab</option>
                                        <option value="_blank" {{ $item->target == '_blank' ? 'selected' : '' }}>New Tab</option>
                                    </select>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" name="is_active" id="is_active_edit_{{ $item->id }}" value="1" {{ $item->is_active ? 'checked' : '' }} class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <label for="is_active_edit_{{ $item->id }}" class="ml-2 block text-sm text-gray-900">Active (Visible)</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">Update Item</button>
                    <button type="button" onclick="document.getElementById('editModal-{{ $item->id }}').classList.add('hidden')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
