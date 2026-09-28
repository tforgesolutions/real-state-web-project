@extends('admin.layouts.app')

@section('title', 'Edit Location')
@section('header', 'Edit Location')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <a href="{{ route('admin.locations.index') }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm flex items-center">
        <i class="fas fa-arrow-left mr-2"></i> Back to Locations
    </a>
</div>

@if ($errors->any())
<div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
    <div class="flex">
        <div class="flex-shrink-0">
            <i class="fas fa-exclamation-circle text-red-500"></i>
        </div>
        <div class="ml-3">
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

<form action="{{ route('admin.locations.update', $location->id) }}" method="POST" class="space-y-6 max-w-3xl">
    @csrf
    @method('PUT')
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-lg font-medium text-gray-800">Location Details</h3>
            <span class="text-xs text-gray-500 bg-gray-200 px-2 py-1 rounded">ID: {{ $location->id }}</span>
        </div>
        <div class="p-6 space-y-6">
            
            <div class="bg-yellow-50 p-4 rounded border border-yellow-100 text-sm text-yellow-800 mb-4">
                <i class="fas fa-exclamation-triangle mr-2"></i> Changing a location's type or hierarchy will update the structure for all properties and projects attached to it.
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Location Type <span class="text-red-500">*</span></label>
                <select name="type" id="location-type" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2 bg-gray-50">
                    <option value="Country" {{ old('type', $location->type) == 'Country' ? 'selected' : '' }}>Country</option>
                    <option value="Province/State" {{ old('type', $location->type) == 'Province/State' ? 'selected' : '' }}>Province/State</option>
                    <option value="City" {{ old('type', $location->type) == 'City' ? 'selected' : '' }}>City</option>
                    <option value="Area/Locality" {{ old('type', $location->type) == 'Area/Locality' ? 'selected' : '' }}>Area/Locality</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Location Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $location->name) }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
            </div>

            <!-- Dynamic Parent Fields -->
            <div id="parent-container" class="hidden">
                <label class="block text-sm font-medium text-gray-700 mb-1">Parent Location <span class="text-red-500">*</span></label>
                
                <!-- Country Dropdown (for State) -->
                <select name="parent_id_country" id="parent-country" class="parent-select hidden w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                    <option value="">Select Country</option>
                    @foreach($countries as $country)
                        <option value="{{ $country->id }}" {{ $location->parent_id == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                    @endforeach
                </select>

                <!-- State Dropdown (for City) -->
                <select name="parent_id_state" id="parent-state" class="parent-select hidden w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                    <option value="">Select Province/State</option>
                    @foreach($states as $state)
                        <option value="{{ $state->id }}" {{ $location->parent_id == $state->id ? 'selected' : '' }}>{{ $state->path }}</option>
                    @endforeach
                </select>

                <!-- City Dropdown (for Area) -->
                <select name="parent_id_city" id="parent-city" class="parent-select hidden w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                    <option value="">Select City</option>
                    @foreach($cities as $city)
                        <option value="{{ $city->id }}" {{ $location->parent_id == $city->id ? 'selected' : '' }}>{{ $city->path }}</option>
                    @endforeach
                </select>
                
                <!-- The actual field submitted -->
                <input type="hidden" name="parent_id" id="parent_id_real" value="{{ old('parent_id', $location->parent_id) }}">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status <span class="text-red-500">*</span></label>
                <select name="status" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                    <option value="Active" {{ old('status', $location->status) == 'Active' ? 'selected' : '' }}>Active</option>
                    <option value="Inactive" {{ old('status', $location->status) == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Description (Optional)</label>
                <textarea name="description" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">{{ old('description', $location->description) }}</textarea>
            </div>
            
        </div>
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex justify-end">
            <a href="{{ route('admin.locations.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none mr-3">
                Cancel
            </a>
            <button type="submit" class="bg-blue-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Update Location
            </button>
        </div>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const typeSelect = document.getElementById('location-type');
        const parentContainer = document.getElementById('parent-container');
        const realParentInput = document.getElementById('parent_id_real');
        
        const parentSelectors = {
            'Province/State': document.getElementById('parent-country'),
            'City': document.getElementById('parent-state'),
            'Area/Locality': document.getElementById('parent-city')
        };
        
        function updateParentFields() {
            const type = typeSelect.value;
            
            // Hide all
            Object.values(parentSelectors).forEach(select => {
                select.classList.add('hidden');
                select.required = false;
            });
            
            if (!type || type === 'Country') {
                parentContainer.classList.add('hidden');
                realParentInput.value = '';
            } else {
                parentContainer.classList.remove('hidden');
                const activeSelect = parentSelectors[type];
                if(activeSelect) {
                    activeSelect.classList.remove('hidden');
                    activeSelect.required = true;
                    // Keep original value if the dropdown has it, otherwise use select's current value
                    if (activeSelect.querySelector(`option[value="${realParentInput.value}"]`)) {
                        activeSelect.value = realParentInput.value;
                    } else {
                        realParentInput.value = activeSelect.value;
                    }
                }
            }
        }
        
        // Sync visible selects to hidden input
        Object.values(parentSelectors).forEach(select => {
            select.addEventListener('change', function() {
                realParentInput.value = this.value;
            });
        });
        
        typeSelect.addEventListener('change', function() {
            // When type changes, clear parent to prevent invalid hierarchies
            realParentInput.value = '';
            updateParentFields();
        });
        
        updateParentFields(); // Initial run
    });
</script>
@endsection
