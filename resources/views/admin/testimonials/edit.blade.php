@extends('admin.layouts.app')

@section('title', 'Edit Testimonial')
@section('header', 'Edit Testimonial')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <a href="{{ route('admin.testimonials.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center">
        <i class="fas fa-arrow-left mr-2"></i> Back to Testimonials
    </a>
</div>

<div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden max-w-4xl">
    <form action="{{ route('admin.testimonials.update', $testimonial->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="p-6 md:p-8">
            <h3 class="text-lg font-medium text-gray-900 mb-6 border-b pb-3">Testimonial Details</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Client Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Client Name <span class="text-red-500">*</span></label>
                    <input type="text" name="client_name" value="{{ old('client_name', $testimonial->client_name) }}" required class="w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    @error('client_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                
                <!-- Client Image -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Client Image (Optional)</label>
                    <div class="flex items-center space-x-4 mb-2">
                        <img src="{{ $testimonial->image_url }}" alt="Preview" class="h-12 w-12 rounded-full object-cover border border-gray-200">
                        <input type="file" name="image" accept="image/jpeg,image/png,image/webp" class="w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm file:mr-4 file:py-1 file:px-3 file:rounded file:border-0 file:text-xs file:bg-gray-100 file:text-gray-700">
                    </div>
                    <p class="text-xs text-gray-500">Leave blank to keep existing image. Max 4MB.</p>
                    @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Designation -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Designation (e.g. CEO, Homeowner)</label>
                    <input type="text" name="designation" value="{{ old('designation', $testimonial->designation) }}" class="w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    @error('designation') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Company -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Company (Optional)</label>
                    <input type="text" name="company" value="{{ old('company', $testimonial->company) }}" class="w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    @error('company') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                
                <!-- Rating -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Rating <span class="text-red-500">*</span></label>
                    <select name="rating" required class="w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        @for($i=5; $i>=1; $i--)
                            <option value="{{ $i }}" {{ old('rating', $testimonial->rating) == $i ? 'selected' : '' }}>{{ $i }} Star{{ $i > 1 ? 's' : '' }}</option>
                        @endfor
                    </select>
                    @error('rating') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Display Order -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Display Order <span class="text-red-500">*</span></label>
                    <input type="number" name="display_order" value="{{ old('display_order', $testimonial->display_order) }}" min="0" required class="w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    @error('display_order') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Testimonial Text -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Testimonial Text <span class="text-red-500">*</span></label>
                <textarea name="testimonial" rows="4" required class="w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ old('testimonial', $testimonial->testimonial) }}</textarea>
                @error('testimonial') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            
            <div class="flex items-center space-x-6 border-t pt-6">
                <div class="flex items-center">
                    <input type="checkbox" name="status" id="status" value="1" {{ old('status', $testimonial->status) ? 'checked' : '' }} class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="status" class="ml-2 block text-sm text-gray-900 font-medium">Active (Visible)</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" name="featured" id="featured" value="1" {{ old('featured', $testimonial->featured) ? 'checked' : '' }} class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="featured" class="ml-2 block text-sm text-gray-900 font-medium">Featured (Show on Homepage)</label>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-6 py-4 flex justify-end rounded-b-lg border-t border-gray-100">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm">
                Update Testimonial
            </button>
        </div>
    </form>
</div>
@endsection
