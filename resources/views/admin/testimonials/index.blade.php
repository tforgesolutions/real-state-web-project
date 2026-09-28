@extends('admin.layouts.app')

@section('title', 'Testimonials & Reviews')
@section('header', 'Testimonials & Reviews')

@section('content')

@if(session('success'))
<div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded shadow-sm">
    <div class="flex items-center">
        <i class="fas fa-check-circle text-green-500 mr-3"></i>
        <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
    </div>
</div>
@endif

<div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100 mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
    <form action="{{ route('admin.testimonials.index') }}" method="GET" class="flex flex-wrap items-center gap-2 w-full md:w-auto">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search client or text..." class="border border-gray-300 rounded-md shadow-sm py-2 px-3 text-sm focus:ring-blue-500 focus:border-blue-500">
        
        <select name="status" class="border border-gray-300 rounded-md shadow-sm py-2 px-3 text-sm focus:ring-blue-500 focus:border-blue-500">
            <option value="">All Status</option>
            <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Active</option>
            <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Inactive</option>
        </select>

        <select name="featured" class="border border-gray-300 rounded-md shadow-sm py-2 px-3 text-sm focus:ring-blue-500 focus:border-blue-500">
            <option value="">Featured Any</option>
            <option value="1" {{ request('featured') == '1' ? 'selected' : '' }}>Featured Only</option>
            <option value="0" {{ request('featured') == '0' ? 'selected' : '' }}>Not Featured</option>
        </select>

        <select name="rating" class="border border-gray-300 rounded-md shadow-sm py-2 px-3 text-sm focus:ring-blue-500 focus:border-blue-500">
            <option value="">All Ratings</option>
            @for($i=5; $i>=1; $i--)
                <option value="{{ $i }}" {{ request('rating') == (string)$i ? 'selected' : '' }}>{{ $i }} Stars</option>
            @endfor
        </select>

        <button type="submit" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-md text-sm font-medium transition-colors">
            Filter
        </button>
        @if(request()->hasAny(['search', 'status', 'featured', 'rating']))
            <a href="{{ route('admin.testimonials.index') }}" class="text-sm text-gray-500 hover:text-blue-600">Clear</a>
        @endif
    </form>

    <a href="{{ route('admin.testimonials.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm flex items-center">
        <i class="fas fa-plus mr-2"></i> Add Testimonial
    </a>
</div>

<div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Feedback</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rating</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Featured</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($testimonials as $testimonial)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <img class="h-10 w-10 rounded-full object-cover" src="{{ $testimonial->image_url }}" alt="">
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">{{ $testimonial->client_name }}</div>
                                <div class="text-xs text-gray-500">
                                    {{ $testimonial->designation }} 
                                    @if($testimonial->designation && $testimonial->company) - @endif
                                    {{ $testimonial->company }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900 line-clamp-2 max-w-xs" title="{{ $testimonial->testimonial }}">
                            {{ Str::limit($testimonial->testimonial, 80) }}
                        </div>
                        <div class="text-xs text-gray-400 mt-1">Order: {{ $testimonial->display_order }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex text-yellow-400 text-xs">
                            @for($i=0; $i<$testimonial->rating; $i++) <i class="fas fa-star"></i> @endfor
                            @for($i=$testimonial->rating; $i<5; $i++) <i class="far fa-star text-gray-300"></i> @endfor
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <form action="{{ route('admin.testimonials.toggle', $testimonial->id) }}" method="POST">
                            @csrf @method('PATCH')
                            <button type="submit" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $testimonial->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $testimonial->status ? 'Active' : 'Inactive' }}
                            </button>
                        </form>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <form action="{{ route('admin.testimonials.feature', $testimonial->id) }}" method="POST">
                            @csrf @method('PATCH')
                            <button type="submit" class="text-xl {{ $testimonial->featured ? 'text-yellow-400 hover:text-yellow-500' : 'text-gray-300 hover:text-gray-400' }}">
                                <i class="fas fa-star"></i>
                            </button>
                        </form>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('admin.testimonials.edit', $testimonial->id) }}" class="text-blue-600 hover:text-blue-900 mr-3"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.testimonials.destroy', $testimonial->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this testimonial?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900"><i class="fas fa-trash-alt"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                        <i class="fas fa-comment-dots text-4xl mb-3 text-gray-300"></i>
                        <p>No testimonials found.</p>
                        <a href="{{ route('admin.testimonials.create') }}" class="text-blue-600 font-medium hover:underline mt-2 inline-block">Add your first testimonial</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($testimonials->hasPages())
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $testimonials->links() }}
    </div>
    @endif
</div>

@endsection
