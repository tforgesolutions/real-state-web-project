@extends('admin.layouts.app')

@section('title', 'Admin Profile')
@section('header', 'My Profile')

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

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Profile Card & Security Info -->
    <div class="space-y-6">
        <!-- Profile Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-blue-600 h-24"></div>
            <div class="px-6 pb-6 relative">
                <div class="flex justify-center -mt-12 mb-4">
                    @if($user->profile_photo)
                        <img src="{{ Storage::url($user->profile_photo) }}" alt="{{ $user->name }}" class="h-24 w-24 rounded-full border-4 border-white shadow-md object-cover">
                    @else
                        <div class="h-24 w-24 rounded-full border-4 border-white shadow-md bg-blue-100 flex items-center justify-center text-blue-600 text-3xl font-bold">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                    @endif
                </div>
                <div class="text-center">
                    <h2 class="text-xl font-bold text-gray-900">{{ $user->name }}</h2>
                    <p class="text-sm text-gray-500">{{ $user->email }}</p>
                    <span class="inline-block mt-3 px-3 py-1 bg-blue-50 text-blue-700 text-xs font-bold uppercase rounded-full tracking-wider border border-blue-200">
                        {{ $user->role }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Security Information -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                <h3 class="text-base font-semibold text-gray-800 flex items-center">
                    <i class="fas fa-shield-alt text-gray-400 mr-2"></i> Security Information
                </h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex justify-between items-center py-2 border-b border-gray-50">
                    <span class="text-sm text-gray-500">Account Status</span>
                    <span class="text-sm font-medium text-green-600 flex items-center">
                        <i class="fas fa-check-circle mr-1 text-xs"></i> Active
                    </span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-50">
                    <span class="text-sm text-gray-500">Member Since</span>
                    <span class="text-sm font-medium text-gray-900">{{ $user->created_at->format('M d, Y') }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-50">
                    <span class="text-sm text-gray-500">Email Verification</span>
                    @if($user->email_verified_at)
                        <span class="text-sm font-medium text-green-600">Verified</span>
                    @else
                        <span class="text-sm font-medium text-yellow-600">Unverified</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Forms Area -->
    <div class="lg:col-span-2 space-y-6">
        
        <!-- Edit Profile Form -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                <h3 class="text-lg font-medium text-gray-800">Profile Information</h3>
                <p class="text-sm text-gray-500">Update your account's profile information and email address.</p>
            </div>
            <div class="p-6">
                <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-6">
                        <!-- Profile Photo -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Profile Photo</label>
                            <input type="file" name="profile_photo" accept="image/jpeg,image/png,image/webp" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 border border-gray-200 rounded-md">
                            <p class="mt-1 text-xs text-gray-500">JPG, PNG or WEBP. Max 2MB.</p>
                        </div>
                        
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name <span class="text-red-500">*</span></label>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address <span class="text-red-500">*</span></label>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                            <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                        </div>
                        
                        <div class="flex justify-end pt-4 border-t border-gray-100">
                            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md text-sm font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-sm flex items-center">
                                <i class="fas fa-save mr-2"></i> Save Profile
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Change Password Form -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                <h3 class="text-lg font-medium text-gray-800">Update Password</h3>
                <p class="text-sm text-gray-500">Ensure your account is using a long, random password to stay secure.</p>
            </div>
            <div class="p-6">
                <form action="{{ route('admin.profile.password') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-6">
                        <!-- Current Password -->
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Current Password <span class="text-red-500">*</span></label>
                            <input type="password" name="current_password" id="current_password" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                        </div>

                        <!-- New Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">New Password <span class="text-red-500">*</span></label>
                            <input type="password" name="password" id="password" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                            <p class="text-xs text-gray-500 mt-1">Must be at least 8 characters long.</p>
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password <span class="text-red-500">*</span></label>
                            <input type="password" name="password_confirmation" id="password_confirmation" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                        </div>
                        
                        <div class="flex justify-end pt-4 border-t border-gray-100">
                            <button type="submit" class="bg-gray-800 text-white px-6 py-2 rounded-md text-sm font-medium hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 shadow-sm flex items-center">
                                <i class="fas fa-key mr-2"></i> Change Password
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
