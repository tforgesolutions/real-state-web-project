@extends('admin.layouts.app')

@section('title', 'Manage Locations')
@section('header', 'Locations Hierarchy')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <h2 class="text-xl font-semibold text-gray-800">Locations List</h2>
    <a href="{{ route('admin.locations.create') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none">
        <i class="fas fa-plus mr-2"></i> Add Location
    </a>
</div>

@if(session('success'))
<div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6">
    <div class="flex">
        <div class="flex-shrink-0">
            <i class="fas fa-check-circle text-green-500"></i>
        </div>
        <div class="ml-3">
            <p class="text-sm text-green-700">{{ session('success') }}</p>
        </div>
    </div>
</div>
@endif

@if(session('error'))
<div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
    <div class="flex">
        <div class="flex-shrink-0">
            <i class="fas fa-exclamation-circle text-red-500"></i>
        </div>
        <div class="ml-3">
            <p class="text-sm text-red-700">{{ session('error') }}</p>
        </div>
    </div>
</div>
@endif

<!-- Filters -->
<div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100 mb-6">
    <form action="{{ route('admin.locations.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Location Name or ID..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border p-2">
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
            <select name="type" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border p-2">
                <option value="">All Types</option>
                @foreach(['Country', 'Province/State', 'City', 'Area/Locality'] as $type)
                <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex items-end space-x-2">
            <button type="submit" class="w-full bg-gray-800 text-white px-4 py-2 rounded-md hover:bg-gray-700 focus:outline-none text-sm font-medium">
                Filter
            </button>
            <a href="{{ route('admin.locations.index') }}" class="w-full text-center bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 focus:outline-none text-sm font-medium">
                Reset
            </a>
        </div>
    </form>
</div>

<!-- Table -->
<div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Location</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hierarchy Path</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usage</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($locations as $location)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            @php
                                $icon = 'fa-map-marker-alt';
                                if($location->type == 'Country') $icon = 'fa-globe-americas text-blue-600';
                                elseif($location->type == 'Province/State') $icon = 'fa-map text-indigo-600';
                                elseif($location->type == 'City') $icon = 'fa-city text-purple-600';
                                else $icon = 'fa-map-pin text-orange-600';
                            @endphp
                            <div class="flex-shrink-0 h-10 w-10 bg-gray-100 rounded-full flex items-center justify-center">
                                <i class="fas {{ $icon }}"></i>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-bold text-gray-900">{{ $location->name }}</div>
                                <div class="text-xs text-gray-500">{{ $location->type }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="text-xs text-gray-600 bg-gray-100 px-2 py-1 rounded">
                            {{ $location->path }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex space-x-4 text-sm">
                            <div class="text-gray-500" title="Properties">
                                <i class="fas fa-home mr-1"></i> {{ $location->properties_count }}
                            </div>
                            <div class="text-gray-500" title="Projects">
                                <i class="fas fa-building mr-1"></i> {{ $location->projects_count }}
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $location->status == 'Active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $location->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                        <a href="{{ route('admin.locations.show', $location->id) }}" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 p-2 rounded" title="View"><i class="fas fa-eye"></i></a>
                        <a href="{{ route('admin.locations.edit', $location->id) }}" class="text-blue-600 hover:text-blue-900 bg-blue-50 p-2 rounded" title="Edit"><i class="fas fa-edit"></i></a>
                        
                        <button type="button" onclick="confirmDelete({{ $location->id }})" class="text-red-600 hover:text-red-900 bg-red-50 p-2 rounded" title="Delete"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                        <i class="fas fa-map-marked-alt text-4xl mb-3 text-gray-300"></i>
                        <p>No locations found.</p>
                        <a href="{{ route('admin.locations.create') }}" class="text-blue-600 hover:underline mt-2 inline-block">Create your first location</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($locations->hasPages())
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $locations->links() }}
    </div>
    @endif
</div>

@foreach($locations as $location)
<form id="delete-form-{{ $location->id }}" action="{{ route('admin.locations.destroy', $location->id) }}" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>
@endforeach

<!-- Delete Modal -->
<div id="deleteModal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
  <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeDeleteModal()"></div>
    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
    <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
      <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
        <div class="sm:flex sm:items-start">
          <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
            <i class="fas fa-exclamation-triangle text-red-600"></i>
          </div>
          <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Delete Location</h3>
            <div class="mt-2">
              <p class="text-sm text-gray-500">Are you sure you want to delete this location? If it is attached to properties, projects, or child locations, the deletion will be blocked.</p>
            </div>
          </div>
        </div>
      </div>
      <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
        <button type="button" id="confirmDeleteBtn" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
          Delete
        </button>
        <button type="button" onclick="closeDeleteModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
          Cancel
        </button>
      </div>
    </div>
  </div>
</div>

<script>
    let deleteId = null;
    function confirmDelete(id) {
        deleteId = id;
        document.getElementById('deleteModal').classList.remove('hidden');
    }
    function closeDeleteModal() {
        deleteId = null;
        document.getElementById('deleteModal').classList.add('hidden');
    }
    document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
        if(deleteId) {
            document.getElementById('delete-form-' + deleteId).submit();
        }
    });
</script>
@endsection
