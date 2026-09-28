@extends('admin.layouts.app')

@section('title', 'Menu Management')
@section('header', 'Menu Management')

@section('content')

@if(session('success'))
<div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded shadow-sm">
    <div class="flex items-center">
        <i class="fas fa-check-circle text-green-500 mr-3"></i>
        <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
    </div>
</div>
@endif

@if ($errors->any())
<div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded shadow-sm">
    <div class="flex">
        <i class="fas fa-exclamation-circle text-red-500 mr-3 mt-0.5"></i>
        <div>
            <h3 class="text-sm font-medium text-red-800">There were errors with your submission</h3>
            <ul class="mt-1 text-sm text-red-700 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endif

<!-- Location Selector -->
<div class="mb-6 bg-white p-4 rounded-lg shadow-sm border border-gray-100 flex flex-wrap gap-4 items-center justify-between">
    <div class="flex items-center space-x-4">
        <span class="text-sm font-medium text-gray-700">Select Menu Location:</span>
        <div class="inline-flex rounded-md shadow-sm">
            <a href="{{ route('admin.menus.index', ['location' => 'header']) }}" class="px-4 py-2 text-sm font-medium {{ $location == 'header' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50' }} border border-gray-200 rounded-l-lg focus:z-10 focus:ring-2 focus:ring-blue-500">
                Main Navbar
            </a>
            <a href="{{ route('admin.menus.index', ['location' => 'footer']) }}" class="px-4 py-2 text-sm font-medium {{ $location == 'footer' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50' }} border border-gray-200 border-l-0 rounded-r-lg focus:z-10 focus:ring-2 focus:ring-blue-500">
                Footer Menu
            </a>
        </div>
    </div>
    <button onclick="document.getElementById('addModal').classList.remove('hidden')" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm flex items-center">
        <i class="fas fa-plus mr-2"></i> Add Menu Item
    </button>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Menu Structure -->
    <div class="lg:col-span-3">
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                <h3 class="font-medium text-gray-800">Menu Structure ({{ ucfirst($location) }})</h3>
                <span class="text-xs text-gray-500">Drag to reorder (if supported) or edit order numbers.</span>
            </div>
            <div class="p-0">
                @if($menuItems->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Label</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Link</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200" id="menu-list">
                            @foreach($menuItems as $item)
                                @include('admin.menus._item', ['item' => $item, 'level' => 0])
                                
                                @foreach($item->children as $child)
                                    @include('admin.menus._item', ['item' => $child, 'level' => 1])
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="p-12 text-center text-gray-500">
                    <i class="fas fa-sitemap text-4xl mb-3 text-gray-300"></i>
                    <p>No menu items found in this location.</p>
                    <button onclick="document.getElementById('addModal').classList.remove('hidden')" class="mt-4 text-blue-600 font-medium hover:underline">Add the first item</button>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div id="addModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="document.getElementById('addModal').classList.add('hidden')"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form action="{{ route('admin.menus.store') }}" method="POST">
                @csrf
                <input type="hidden" name="location" value="{{ $location }}">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Add Menu Item</h3>
                            <div class="mt-4 space-y-4 text-left">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Label <span class="text-red-500">*</span></label>
                                    <input type="text" name="name" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">URL / Route</label>
                                    <input type="text" name="url" placeholder="/properties or https://..." class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    <p class="mt-1 text-xs text-gray-500">Leave blank for dropdown parent items.</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Parent Item</label>
                                    <select name="parent_id" class="mt-1 block w-full bg-white border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                        <option value="">-- Top Level --</option>
                                        @foreach($parentOptions as $opt)
                                            <option value="{{ $opt->id }}">{{ $opt->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Target</label>
                                    <select name="target" class="mt-1 block w-full bg-white border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                        <option value="_self">Same Tab</option>
                                        <option value="_blank">New Tab</option>
                                    </select>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" name="is_active" id="is_active_add" value="1" checked class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <label for="is_active_add" class="ml-2 block text-sm text-gray-900">Active (Visible)</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">Save Item</button>
                    <button type="button" onclick="document.getElementById('addModal').classList.add('hidden')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
