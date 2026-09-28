@extends('admin.layouts.app')

@section('title', 'Add Property')
@section('header', 'Add New Property')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.properties.index') }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm flex items-center">
        <i class="fas fa-arrow-left mr-2"></i> Back to Properties
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

<form action="{{ route('admin.properties.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
    @csrf
    
    <!-- Basic Information -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-100">
            <h3 class="text-lg font-medium text-gray-800">Basic Information</h3>
        </div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Property Title <span class="text-red-500">*</span></label>
                <input type="text" name="title" value="{{ old('title') }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" rows="4" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">{{ old('description') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Purpose <span class="text-red-500">*</span></label>
                <select name="purpose" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                    <option value="">Select Purpose</option>
                    <option value="buy" {{ old('purpose') == 'buy' ? 'selected' : '' }}>For Sale</option>
                    <option value="rent" {{ old('purpose') == 'rent' ? 'selected' : '' }}>For Rent</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Property Category <span class="text-red-500">*</span></label>
                <select name="property_category" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                    <option value="">Select Category</option>
                    <option value="Residential" {{ old('property_category') == 'Residential' ? 'selected' : '' }}>Residential</option>
                    <option value="Commercial" {{ old('property_category') == 'Commercial' ? 'selected' : '' }}>Commercial</option>
                    <option value="Plot" {{ old('property_category') == 'Plot' ? 'selected' : '' }}>Plot/Land</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Property Type <span class="text-red-500">*</span></label>
                <select id="prop_type_dropdown" name="property_type_id" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                    <option value="">Select Type</option>
                    @foreach($propertyTypes as $pt)
                    <option value="{{ $pt->id }}" {{ old('property_type_id') == $pt->id ? 'selected' : '' }}>{{ $pt->name }}</option>
                    @endforeach
                </select>
                <!-- Legacy field maintained for compatibility -->
                <input type="hidden" id="legacy_prop_type" name="property_type" value="{{ old('property_type', 'House') }}">
            </div>
            <script>
                document.getElementById('prop_type_dropdown').addEventListener('change', function() {
                    let text = this.options[this.selectedIndex].text;
                    document.getElementById('legacy_prop_type').value = text;
                });
            </script>

            <div class="flex space-x-2">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Price <span class="text-red-500">*</span></label>
                    <input type="number" step="0.01" name="price" value="{{ old('price') }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                </div>
                <div class="w-1/3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Unit</label>
                    <input type="text" name="price_unit" value="{{ old('price_unit', 'USD') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                </div>
            </div>

        </div>
    </div>

    <!-- Location & Details -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-100">
            <h3 class="text-lg font-medium text-gray-800">Location & Details</h3>
        </div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            
            @include('admin.locations.partials.selector', ['entity' => null])
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">City <span class="text-red-500">*</span></label>
                <input type="text" name="city" value="{{ old('city') }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Area / Locality <span class="text-red-500">*</span></label>
                <input type="text" name="area_locality" value="{{ old('area_locality') }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Full Address</label>
                <input type="text" name="address" value="{{ old('address') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
            </div>

            <div class="flex space-x-2">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Area Size <span class="text-red-500">*</span></label>
                    <input type="number" step="0.01" name="area" value="{{ old('area') }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                </div>
                <div class="w-1/3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Unit</label>
                    <select name="area_unit" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                        <option value="Sq.Ft" {{ old('area_unit') == 'Sq.Ft' ? 'selected' : '' }}>Sq.Ft</option>
                        <option value="Sq.M" {{ old('area_unit') == 'Sq.M' ? 'selected' : '' }}>Sq.M</option>
                        <option value="Sq.Yd" {{ old('area_unit') == 'Sq.Yd' ? 'selected' : '' }}>Sq.Yd</option>
                        <option value="Acre" {{ old('area_unit') == 'Acre' ? 'selected' : '' }}>Acre</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Bedrooms</label>
                <input type="number" name="bedrooms" value="{{ old('bedrooms') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Bathrooms</label>
                <input type="number" step="0.5" name="bathrooms" value="{{ old('bathrooms') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Amenities</label>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 bg-gray-50 p-4 rounded border border-gray-100">
                    @if(isset($amenitiesList) && $amenitiesList->count() > 0)
                        @foreach($amenitiesList as $amenity)
                        <label class="inline-flex items-center p-2 border border-gray-200 rounded bg-white hover:bg-gray-50 cursor-pointer">
                            <input type="checkbox" name="amenities_ids[]" value="{{ $amenity->id }}" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" {{ is_array(old('amenities_ids')) && in_array($amenity->id, old('amenities_ids')) ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700"><i class="{{ $amenity->icon ?? 'fas fa-check' }} text-gray-400 w-5"></i> {{ $amenity->name }}</span>
                        </label>
                        @endforeach
                    @else
                        <p class="text-sm text-gray-500 col-span-2 sm:col-span-3">No amenities available.</p>
                    @endif
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
                <label class="block text-sm font-medium text-gray-700 mb-1">Agent / Owner <span class="text-red-500">*</span></label>
                <select name="user_id" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                    <option value="">Select Agent</option>
                    @foreach($agents as $agent)
                        <option value="{{ $agent->id }}" {{ old('user_id') == $agent->id ? 'selected' : '' }}>{{ $agent->name }} ({{ $agent->role }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status <span class="text-red-500">*</span></label>
                <select name="status" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="pending_review" {{ old('status') == 'pending_review' ? 'selected' : '' }}>Pending Review</option>
                    <option value="approved" {{ old('status', 'approved') == 'approved' ? 'selected' : '' }}>Approved / Published</option>
                    <option value="sold" {{ old('status') == 'sold' ? 'selected' : '' }}>Sold</option>
                    <option value="rented" {{ old('status') == 'rented' ? 'selected' : '' }}>Rented</option>
                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Contact Name <span class="text-red-500">*</span></label>
                <input type="text" name="contact_name" value="{{ old('contact_name', Auth::user()->name) }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
            </div>

            <div class="flex space-x-4">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Contact Phone <span class="text-red-500">*</span></label>
                    <input type="text" name="contact_phone" value="{{ old('contact_phone') }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                </div>
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Contact Email <span class="text-red-500">*</span></label>
                    <input type="email" name="contact_email" value="{{ old('contact_email', Auth::user()->email) }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                </div>
            </div>

            <div class="md:col-span-2">
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_featured" value="1" class="sr-only peer" {{ old('is_featured') ? 'checked' : '' }}>
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    <span class="ml-3 text-sm font-medium text-gray-700">Mark as Featured Property</span>
                </label>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Property Images</label>
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
        <a href="{{ route('admin.properties.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none mr-3">
            Cancel
        </a>
        <button type="submit" class="bg-blue-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            Save Property
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
                            <span class="text-white text-xs font-semibold px-2 py-1 bg-gray-900 bg-opacity-75 rounded">Preview</span>
                        </div>
                    `;
                    container.appendChild(div);
                };
            })(file);
            reader.readAsDataURL(file);
        }
    }
</script>
@endsection
