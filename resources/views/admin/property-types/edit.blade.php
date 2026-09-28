@extends('admin.layouts.app')

@section('title', 'Edit Property Type')
@section('header', 'Edit Property Type')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.property-types.index') }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm flex items-center">
        <i class="fas fa-arrow-left mr-2"></i> Back to Property Types
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

<form action="{{ route('admin.property-types.update', $propertyType->id) }}" method="POST" class="space-y-6 max-w-2xl">
    @csrf
    @method('PUT')
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-lg font-medium text-gray-800">Type Details</h3>
            <span class="text-xs text-gray-500 bg-gray-200 px-2 py-1 rounded">ID: {{ $propertyType->id }}</span>
        </div>
        <div class="p-6 space-y-6">

            <div class="bg-blue-50 p-4 rounded border border-blue-100 text-sm text-blue-800 mb-4">
                <i class="fas fa-info-circle mr-2"></i> Changing the name or slug will immediately update it across all attached properties without breaking their relationships.
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Type Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $propertyType->name) }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
                <input type="text" name="slug" value="{{ old('slug', $propertyType->slug) }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                <p class="mt-1 text-xs text-gray-500">Used in URLs. Must be unique.</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Icon Class (FontAwesome)</label>
                <div class="flex items-center space-x-3">
                    <div class="h-10 w-10 flex-shrink-0 bg-gray-100 flex items-center justify-center rounded text-gray-600 text-lg">
                        <i class="{{ $propertyType->icon ?? 'fas fa-home' }}"></i>
                    </div>
                    <input type="text" name="icon" value="{{ old('icon', $propertyType->icon) }}" placeholder="e.g. fas fa-building" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status <span class="text-red-500">*</span></label>
                <select name="status" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                    <option value="Active" {{ old('status', $propertyType->status) == 'Active' ? 'selected' : '' }}>Active</option>
                    <option value="Inactive" {{ old('status', $propertyType->status) == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Description (Optional)</label>
                <textarea name="description" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">{{ old('description', $propertyType->description) }}</textarea>
            </div>
            
        </div>
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex justify-end">
            <a href="{{ route('admin.property-types.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none mr-3">
                Cancel
            </a>
            <button type="submit" class="bg-blue-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Update Property Type
            </button>
        </div>
    </div>
</form>
@endsection
