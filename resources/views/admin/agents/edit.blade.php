@extends('admin.layouts.app')

@section('title', 'Edit Agent')
@section('header', 'Edit Agent')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.agents.index') }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm flex items-center">
        <i class="fas fa-arrow-left mr-2"></i> Back to Agents
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

<form action="{{ route('admin.agents.update', $agent->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
    @csrf
    @method('PUT')
    
    <!-- Personal Information -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-lg font-medium text-gray-800">Personal Information</h3>
            <span class="text-xs text-gray-500">ID: {{ $agent->id }}</span>
        </div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Profile Photo</label>
                <div class="flex items-center space-x-6">
                    <div class="h-24 w-24 bg-gray-100 rounded-full border border-gray-200 flex items-center justify-center overflow-hidden relative group" id="photo-preview-container">
                        @if($agent->profile_photo)
                            <img src="{{ Storage::url($agent->profile_photo) }}" class="h-full w-full object-cover">
                            <button type="button" onclick="removePhoto()" class="absolute inset-0 bg-black bg-opacity-50 text-white flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity rounded-full text-xs">
                                <i class="fas fa-trash-alt mr-1"></i> Remove
                            </button>
                        @else
                            <i class="fas fa-user text-gray-400 text-3xl"></i>
                        @endif
                    </div>
                    <div>
                        <label for="profile_photo" class="cursor-pointer bg-white py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                            <span>Change Photo</span>
                            <input id="profile_photo" name="profile_photo" type="file" class="sr-only" accept="image/*" onchange="previewPhoto(event)">
                        </label>
                        <p class="mt-2 text-xs text-gray-500">JPG, PNG, GIF up to 2MB</p>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Full Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $agent->name) }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                <input type="email" name="email" value="{{ old('email', $agent->email) }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                <input type="text" name="phone" value="{{ old('phone', $agent->phone) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">WhatsApp</label>
                <input type="text" name="whatsapp" value="{{ old('whatsapp', $agent->whatsapp) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
            </div>

        </div>
    </div>

    <!-- Professional Information -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-100">
            <h3 class="text-lg font-medium text-gray-800">Professional Information</h3>
        </div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Agency / Company</label>
                <input type="text" name="agency" value="{{ old('agency', $agent->agency) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Designation</label>
                <input type="text" name="designation" value="{{ old('designation', $agent->designation) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Years of Experience</label>
                <input type="number" name="experience_years" value="{{ old('experience_years', $agent->experience_years) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
            </div>
            
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Bio / About Agent</label>
                <textarea name="bio" rows="4" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">{{ old('bio', $agent->bio) }}</textarea>
            </div>

        </div>
    </div>
    
    <!-- Additional Information -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-100">
            <h3 class="text-lg font-medium text-gray-800">Additional Information</h3>
        </div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                <input type="text" name="address" value="{{ old('address', $agent->address) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
            </div>

            <div class="flex space-x-2">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">City</label>
                    <input type="text" name="city" value="{{ old('city', $agent->city) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                </div>
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Country</label>
                    <input type="text" name="country" value="{{ old('country', $agent->country) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Facebook URL</label>
                <input type="url" name="facebook_url" value="{{ old('facebook_url', $agent->facebook_url) }}" placeholder="https://" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Instagram URL</label>
                <input type="url" name="instagram_url" value="{{ old('instagram_url', $agent->instagram_url) }}" placeholder="https://" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">LinkedIn URL</label>
                <input type="url" name="linkedin_url" value="{{ old('linkedin_url', $agent->linkedin_url) }}" placeholder="https://" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Website URL</label>
                <input type="url" name="website_url" value="{{ old('website_url', $agent->website_url) }}" placeholder="https://" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
            </div>

        </div>
    </div>

    <!-- Status -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-100">
            <h3 class="text-lg font-medium text-gray-800">Account Status</h3>
        </div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status <span class="text-red-500">*</span></label>
                <select name="status" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                    <option value="active" {{ old('status', $agent->status) == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status', $agent->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    <option value="suspended" {{ old('status', $agent->status) == 'suspended' ? 'selected' : '' }}>Suspended</option>
                </select>
            </div>
            
            <div class="flex items-center mt-6">
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_featured" value="1" class="sr-only peer" {{ old('is_featured', $agent->is_featured) ? 'checked' : '' }}>
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    <span class="ml-3 text-sm font-medium text-gray-700">Mark as Featured Agent</span>
                </label>
            </div>

        </div>
    </div>

    <div class="flex justify-end">
        <a href="{{ route('admin.agents.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none mr-3">
            Cancel
        </a>
        <button type="submit" class="bg-blue-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            Update Agent
        </button>
    </div>
</form>

<script>
    function previewPhoto(event) {
        const file = event.target.files[0];
        if(!file || !file.type.match('image.*')) return;
        
        const reader = new FileReader();
        reader.onload = function(e) {
            const container = document.getElementById('photo-preview-container');
            container.innerHTML = `<img src="${e.target.result}" class="h-full w-full object-cover">`;
        };
        reader.readAsDataURL(file);
    }
    
    function removePhoto() {
        if(!confirm('Are you sure you want to remove the profile photo?')) return;
        
        fetch(`{{ route('admin.agents.remove-photo', $agent->id) }}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                const container = document.getElementById('photo-preview-container');
                container.innerHTML = `<i class="fas fa-user text-gray-400 text-3xl"></i>`;
                container.classList.remove('group');
            } else {
                alert('Failed to remove photo.');
            }
        });
    }
</script>
@endsection
