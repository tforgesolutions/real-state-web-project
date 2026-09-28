@extends('admin.layouts.app')

@section('title', 'Edit Project')
@section('header', 'Edit Project')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.projects.index') }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm flex items-center">
        <i class="fas fa-arrow-left mr-2"></i> Back to Projects
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

<form action="{{ route('admin.projects.update', $project->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
    @csrf
    @method('PUT')
    
    <!-- Basic Information -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-lg font-medium text-gray-800">Basic Information</h3>
            <span class="text-xs text-gray-500">ID: {{ $project->reference_id }}</span>
        </div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Project Name <span class="text-red-500">*</span></label>
                <input type="text" name="title" value="{{ old('title', $project->title) }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" rows="4" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">{{ old('description', $project->description) }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Developer / Builder <span class="text-red-500">*</span></label>
                <input type="text" name="developer" value="{{ old('developer', $project->developer) }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Project Type <span class="text-red-500">*</span></label>
                <select name="project_type" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                    <option value="Residential" {{ old('project_type', $project->project_type) == 'Residential' ? 'selected' : '' }}>Residential</option>
                    <option value="Commercial" {{ old('project_type', $project->project_type) == 'Commercial' ? 'selected' : '' }}>Commercial</option>
                    <option value="Mixed Use" {{ old('project_type', $project->project_type) == 'Mixed Use' ? 'selected' : '' }}>Mixed Use</option>
                    <option value="Villas" {{ old('project_type', $project->project_type) == 'Villas' ? 'selected' : '' }}>Villas</option>
                </select>
            </div>

            @include('admin.locations.partials.selector', ['entity' => $project])
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Location <span class="text-red-500">*</span></label>
                <input type="text" name="location" value="{{ old('location', $project->location) }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Full Address</label>
                <input type="text" name="address" value="{{ old('address', $project->address) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
            </div>

        </div>
    </div>

    <!-- Details -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-100">
            <h3 class="text-lg font-medium text-gray-800">Project Details</h3>
        </div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Total Units</label>
                <input type="number" name="total_units" value="{{ old('total_units', $project->total_units) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Available Units</label>
                <input type="number" name="available_units" value="{{ old('available_units', $project->available_units) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Sold Units</label>
                <input type="number" name="sold_units" value="{{ old('sold_units', $project->sold_units) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Starting Price</label>
                <input type="number" step="0.01" name="starting_price" value="{{ old('starting_price', $project->starting_price) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Maximum Price</label>
                <input type="number" step="0.01" name="maximum_price" value="{{ old('maximum_price', $project->maximum_price) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Completion Date</label>
                <input type="date" name="completion_date" value="{{ old('completion_date', $project->completion_date ? $project->completion_date->format('Y-m-d') : '') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
            </div>

            <div class="md:col-span-3">
                <label class="block text-sm font-medium text-gray-700 mb-2">Amenities</label>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                    @php
                        $availableAmenities = ['Swimming Pool', 'Gymnasium', 'Club House', 'Security', 'Parking', 'Play Area', 'Tennis Court', 'Spa'];
                        $currentAmenities = old('amenities', $project->amenities ?? []);
                    @endphp
                    @foreach($availableAmenities as $amenity)
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="amenities[]" value="{{ $amenity }}" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200" {{ in_array($amenity, $currentAmenities) ? 'checked' : '' }}>
                        <span class="ml-2 text-sm text-gray-600">{{ $amenity }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

        </div>
    </div>

    <!-- Contact & Status -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-100">
            <h3 class="text-lg font-medium text-gray-800">Contact, Status & Media</h3>
        </div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status <span class="text-red-500">*</span></label>
                <select name="status" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                    <option value="upcoming" {{ old('status', $project->status) == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                    <option value="ongoing" {{ old('status', $project->status) == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                    <option value="completed" {{ old('status', $project->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="on_hold" {{ old('status', $project->status) == 'on_hold' ? 'selected' : '' }}>On Hold</option>
                    <option value="cancelled" {{ old('status', $project->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Website URL</label>
                <input type="url" name="website_url" value="{{ old('website_url', $project->website_url) }}" placeholder="https://" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
            </div>

            <div class="flex space-x-4 md:col-span-2">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Contact Phone</label>
                    <input type="text" name="contact_phone" value="{{ old('contact_phone', $project->contact_phone) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                </div>
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Contact Email</label>
                    <input type="email" name="contact_email" value="{{ old('contact_email', $project->contact_email) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                </div>
            </div>

            <div class="md:col-span-2">
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_featured" value="1" class="sr-only peer" {{ old('is_featured', $project->is_featured) ? 'checked' : '' }}>
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    <span class="ml-3 text-sm font-medium text-gray-700">Mark as Featured Project</span>
                </label>
            </div>

            <!-- Existing Images -->
            @if(!empty($project->images) && count($project->images) > 0)
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Current Images</label>
                <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-5 gap-4">
                    @foreach($project->images as $imagePath)
                    <div class="relative group rounded-md overflow-hidden border border-gray-200" id="img-container-{{ md5($imagePath) }}">
                        <img src="{{ Storage::url($imagePath) }}" class="h-24 w-full object-cover">
                        <button type="button" onclick="deleteImage('{{ $imagePath }}', 'img-container-{{ md5($imagePath) }}')" class="absolute top-1 right-1 bg-red-600 text-white rounded-full h-6 w-6 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity focus:outline-none hover:bg-red-700">
                            <i class="fas fa-times text-xs"></i>
                        </button>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Upload New Images</label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md bg-gray-50 hover:bg-gray-100 transition-colors">
                    <div class="space-y-1 text-center">
                        <i class="fas fa-cloud-upload-alt text-gray-400 text-3xl mb-3"></i>
                        <div class="flex text-sm text-gray-600 justify-center">
                            <label for="images" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none p-1 px-2 border">
                                <span>Upload files</span>
                                <input id="images" name="images[]" type="file" class="sr-only" multiple accept="image/*" onchange="previewImages(event)">
                            </label>
                            <p class="pl-1 pt-1">or drag and drop</p>
                        </div>
                        <p class="text-xs text-gray-500">PNG, JPG, GIF up to 5MB (Select multiple)</p>
                    </div>
                </div>
                <div id="image-preview" class="mt-4 grid grid-cols-2 sm:grid-cols-4 gap-4"></div>
            </div>

        </div>
    </div>

    <div class="flex justify-end">
        <a href="{{ route('admin.projects.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none mr-3">
            Cancel
        </a>
        <button type="submit" class="bg-blue-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            Update Project
        </button>
    </div>
</form>

<script>
    function previewImages(event) {
        const container = document.getElementById('image-preview');
        container.innerHTML = '';
        const files = event.target.files;
        
        for(let i = 0; i < files.length; i++) {
            const file = files[i];
            if(!file.type.match('image.*')) continue;
            
            const reader = new FileReader();
            reader.onload = (function(theFile) {
                return function(e) {
                    const div = document.createElement('div');
                    div.className = 'relative group rounded-md overflow-hidden border border-gray-200';
                    div.innerHTML = `
                        <img class="h-24 w-full object-cover" src="${e.target.result}" />
                        <div class="absolute inset-0 bg-black bg-opacity-40 hidden group-hover:flex items-center justify-center">
                            <span class="text-white text-xs font-semibold px-2 py-1 bg-gray-900 bg-opacity-75 rounded">New</span>
                        </div>
                    `;
                    container.appendChild(div);
                };
            })(file);
            reader.readAsDataURL(file);
        }
    }

    function deleteImage(imagePath, containerId) {
        if(!confirm('Are you sure you want to remove this image? This action cannot be undone.')) return;
        
        fetch(`{{ route('admin.projects.delete-image', $project->id) }}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ image_path: imagePath })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                document.getElementById(containerId).remove();
            } else {
                alert('Failed to remove image.');
            }
        });
    }
</script>
@endsection
