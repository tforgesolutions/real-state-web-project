@extends('admin.layouts.app')

@section('title', 'Properties')
@section('header', 'Manage Properties')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <h2 class="text-xl font-semibold text-gray-800">Properties List</h2>
    <a href="{{ route('admin.properties.create') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none">
        <i class="fas fa-plus mr-2"></i> Add Property
    </a>
</div>

<!-- Filters -->
<div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100 mb-6">
    <form action="{{ route('admin.properties.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-4">
        
        <div class="lg:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Title, ID, Location..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border p-2">
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Purpose</label>
            <select name="purpose" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border p-2">
                <option value="">All</option>
                <option value="buy" {{ request('purpose') == 'buy' ? 'selected' : '' }}>For Sale</option>
                <option value="rent" {{ request('purpose') == 'rent' ? 'selected' : '' }}>For Rent</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <select name="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border p-2">
                <option value="">All</option>
                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="pending_review" {{ request('status') == 'pending_review' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Published</option>
                <option value="sold" {{ request('status') == 'sold' ? 'selected' : '' }}>Sold</option>
                <option value="rented" {{ request('status') == 'rented' ? 'selected' : '' }}>Rented</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Featured</label>
            <select name="is_featured" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border p-2">
                <option value="">All</option>
                <option value="1" {{ request('is_featured') === '1' ? 'selected' : '' }}>Yes</option>
                <option value="0" {{ request('is_featured') === '0' ? 'selected' : '' }}>No</option>
            </select>
        </div>

        <div class="flex items-end space-x-2">
            <button type="submit" class="w-full bg-gray-800 text-white px-4 py-2 rounded-md hover:bg-gray-700 focus:outline-none text-sm font-medium">
                Filter
            </button>
            <a href="{{ route('admin.properties.index') }}" class="w-full text-center bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 focus:outline-none text-sm font-medium">
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
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Property</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type/Purpose</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price/Size</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Featured</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($properties as $property)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 bg-gray-200 rounded overflow-hidden">
                                @if(!empty($property->images) && count($property->images) > 0)
                                    <img src="{{ Storage::url($property->images[0]) }}" alt="" class="h-10 w-10 object-cover">
                                @else
                                    <i class="fas fa-image text-gray-400 h-10 w-10 flex items-center justify-center"></i>
                                @endif
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">{{ Str::limit($property->title, 30) }}</div>
                                <div class="text-xs text-gray-500">{{ $property->reference_id }} | {{ $property->city }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $property->property_type }}</div>
                        <div class="text-xs text-gray-500 capitalize">{{ $property->purpose === 'buy' ? 'For Sale' : 'For Rent' }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">${{ number_format($property->price) }}</div>
                        <div class="text-xs text-gray-500">{{ $property->area }} {{ $property->area_unit }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @php
                            $statusColors = [
                                'draft' => 'bg-gray-100 text-gray-800',
                                'pending_review' => 'bg-yellow-100 text-yellow-800',
                                'approved' => 'bg-green-100 text-green-800',
                                'sold' => 'bg-blue-100 text-blue-800',
                                'rented' => 'bg-purple-100 text-purple-800',
                                'inactive' => 'bg-red-100 text-red-800',
                            ];
                            $color = $statusColors[$property->status] ?? 'bg-gray-100 text-gray-800';
                            $label = str_replace('_', ' ', $property->status);
                        @endphp
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full capitalize {{ $color }}">
                            {{ $label }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <button type="button" onclick="toggleFeatured({{ $property->id }}, this)" class="focus:outline-none">
                            <i class="fas fa-star text-lg {{ $property->is_featured ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                        </button>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                        <a href="{{ route('admin.properties.show', $property->id) }}" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 p-2 rounded"><i class="fas fa-eye"></i></a>
                        <a href="{{ route('admin.properties.edit', $property->id) }}" class="text-blue-600 hover:text-blue-900 bg-blue-50 p-2 rounded"><i class="fas fa-edit"></i></a>
                        <button type="button" onclick="confirmDelete({{ $property->id }})" class="text-red-600 hover:text-red-900 bg-red-50 p-2 rounded"><i class="fas fa-trash"></i></button>
                        
                        <form id="delete-form-{{ $property->id }}" action="{{ route('admin.properties.destroy', $property->id) }}" method="POST" class="hidden">
                            @csrf
                            @method('DELETE')
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                        <i class="fas fa-building text-4xl mb-3 text-gray-300"></i>
                        <p>No properties found.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($properties->hasPages())
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $properties->links() }}
    </div>
    @endif
</div>

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
            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Delete Property</h3>
            <div class="mt-2">
              <p class="text-sm text-gray-500">Are you sure you want to delete this property? This action cannot be undone.</p>
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

    function toggleFeatured(id, btnElement) {
        fetch(`/admin/properties/${id}/featured`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                const icon = btnElement.querySelector('i');
                if(data.is_featured) {
                    icon.classList.remove('text-gray-300');
                    icon.classList.add('text-yellow-400');
                } else {
                    icon.classList.remove('text-yellow-400');
                    icon.classList.add('text-gray-300');
                }
            }
        });
    }
</script>
@endsection
