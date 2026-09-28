@extends('admin.layouts.app')

@section('title', 'View Amenity')
@section('header', 'Amenity Details')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <a href="{{ route('admin.amenities.index') }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm flex items-center">
        <i class="fas fa-arrow-left mr-2"></i> Back to Amenities
    </a>
    <div class="space-x-2 flex">
        <a href="{{ route('admin.amenities.edit', $amenity->id) }}" class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none">
            <i class="fas fa-edit mr-2"></i> Edit
        </a>
        <button type="button" onclick="confirmDelete({{ $amenity->id }})" class="inline-flex items-center justify-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none">
            <i class="fas fa-trash mr-2"></i> Delete
        </button>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Content -->
    <div class="lg:col-span-1 space-y-6">
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 text-center border-b border-gray-100">
                <div class="mx-auto h-16 w-16 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center text-3xl mb-4">
                    <i class="{{ $amenity->icon ?? 'fas fa-check' }}"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-900">{{ $amenity->name }}</h2>
                <p class="text-sm text-gray-500 mt-1">/{{ $amenity->slug }}</p>
                <div class="mt-4">
                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full {{ $amenity->status == 'Active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $amenity->status }}
                    </span>
                </div>
            </div>
            <div class="p-6">
                <h4 class="text-sm font-medium text-gray-700 mb-2">Description</h4>
                <p class="text-gray-600 text-sm whitespace-pre-line">{{ $amenity->description ?: 'No description provided.' }}</p>
                
                <div class="mt-6 pt-6 border-t border-gray-100 space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Created:</span>
                        <span class="text-gray-900">{{ $amenity->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Updated:</span>
                        <span class="text-gray-900">{{ $amenity->updated_at->format('M d, Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Properties List -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-800">Recent Properties Using Amenity</h3>
                <span class="bg-blue-100 text-blue-800 text-xs font-bold px-3 py-1 rounded-full">{{ $amenity->properties_count }} Total</span>
            </div>
            
            @if($properties->count() > 0)
            <ul class="divide-y divide-gray-100">
                @foreach($properties as $property)
                <li class="px-6 py-4 flex justify-between items-center hover:bg-gray-50">
                    <div>
                        <a href="{{ route('admin.properties.show', $property->id) }}" class="text-sm font-medium text-blue-600 hover:underline">{{ $property->title }}</a>
                        <p class="text-xs text-gray-500 mt-1">{{ $property->city }} • ${{ number_format($property->price) }}</p>
                    </div>
                </li>
                @endforeach
            </ul>
            @else
            <div class="p-12 text-center text-gray-500">
                <i class="fas fa-building text-4xl mb-3 text-gray-300"></i>
                <p>No properties are currently using this amenity.</p>
            </div>
            @endif
        </div>
    </div>
</div>

<form id="delete-form-{{ $amenity->id }}" action="{{ route('admin.amenities.destroy', $amenity->id) }}" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>

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
            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Delete Amenity</h3>
            <div class="mt-2">
              <p class="text-sm text-gray-500">Are you sure you want to delete this amenity? If it is used by properties, the deletion will be blocked.</p>
            </div>
          </div>
        </div>
      </div>
      <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
        <button type="button" id="confirmDeleteBtn" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 sm:ml-3 sm:w-auto sm:text-sm">Delete</button>
        <button type="button" onclick="closeDeleteModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Cancel</button>
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
        if(deleteId) document.getElementById('delete-form-' + deleteId).submit();
    });
</script>
@endsection
