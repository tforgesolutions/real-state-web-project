@extends('layouts.app')

@section('title', 'New Projects & Developments | Aura Real Estate')

@section('content')
<div class="pt-24 pb-16 bg-[var(--color-surface)] min-h-screen">
    
    <!-- PAGE HEADER -->
    <div class="bg-[var(--color-primary)] text-white py-16 relative overflow-hidden">
        <div class="absolute inset-0 z-0 opacity-20">
            <img src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=1740&auto=format&fit=crop" class="w-full h-full object-cover">
        </div>
        <div class="absolute inset-0 bg-gradient-to-r from-[var(--color-primary)] to-transparent z-0"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 animate-fade-up-scroll">
            <div class="flex items-center text-sm text-gray-300 mb-4 space-x-2">
                <a href="{{ route('home') }}" class="hover:text-[var(--color-accent)] transition-colors">Home</a>
                <span>/</span>
                <span class="text-white">Projects</span>
            </div>
            <h1 class="font-heading text-4xl md:text-5xl font-bold mb-4">New Developments</h1>
            <p class="text-gray-200 max-w-2xl text-lg">Explore premium new construction, master-planned communities, and commercial developments.</p>
        </div>
    </div>

    <!-- MAIN LAYOUT -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-10">
        <div class="flex flex-col lg:flex-row gap-8">
            
            <!-- FILTER SIDEBAR -->
            <aside class="w-full lg:w-1/4">
                <div class="glass-panel rounded-2xl p-6 lg:p-8 space-y-6 lg:sticky lg:top-28">
                    <h2 class="font-heading text-xl font-bold text-[var(--color-primary)] mb-2">Filter Projects</h2>
                    
                    <form action="{{ route('projects.index') }}" method="GET" class="space-y-5">
                        <!-- Search -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Search</label>
                            <div class="relative">
                                <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Project name..." class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] transition-all">
                                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                        </div>

                        <!-- Location -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">City / Location</label>
                            <input type="text" name="location" value="{{ request('location') }}" placeholder="e.g. Dubai, London" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] transition-all">
                        </div>

                        <!-- Project Type -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Project Type</label>
                            <select name="type" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] transition-all appearance-none">
                                <option value="Any Type" {{ request('type') == 'Any Type' ? 'selected' : '' }}>Any Type</option>
                                <option value="Residential" {{ request('type') == 'Residential' ? 'selected' : '' }}>Residential</option>
                                <option value="Commercial" {{ request('type') == 'Commercial' ? 'selected' : '' }}>Commercial</option>
                                <option value="Mixed-use" {{ request('type') == 'Mixed-use' ? 'selected' : '' }}>Mixed-use</option>
                                <option value="Housing Society" {{ request('type') == 'Housing Society' ? 'selected' : '' }}>Housing Society</option>
                            </select>
                        </div>
                        
                        <!-- Property Type -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Property Types</label>
                            <select name="property_type" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] transition-all appearance-none">
                                <option value="All" {{ request('property_type') == 'All' ? 'selected' : '' }}>All</option>
                                <option value="Apartments" {{ request('property_type') == 'Apartments' ? 'selected' : '' }}>Apartments</option>
                                <option value="Villas" {{ request('property_type') == 'Villas' ? 'selected' : '' }}>Villas</option>
                                <option value="Plots" {{ request('property_type') == 'Plots' ? 'selected' : '' }}>Plots</option>
                            </select>
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Status</label>
                            <div class="flex gap-2">
                                <label class="flex-1 text-center cursor-pointer">
                                    <input type="radio" name="status" value="All" class="peer sr-only" {{ request('status', 'All') == 'All' ? 'checked' : '' }}>
                                    <div class="py-2 px-1 text-xs border border-gray-200 rounded-lg peer-checked:bg-[var(--color-surface-alt)] peer-checked:border-[var(--color-accent)] peer-checked:text-[var(--color-primary)] font-semibold transition-colors">All</div>
                                </label>
                                <label class="flex-1 text-center cursor-pointer">
                                    <input type="radio" name="status" value="Upcoming" class="peer sr-only" {{ request('status') == 'Upcoming' ? 'checked' : '' }}>
                                    <div class="py-2 px-1 text-xs border border-gray-200 rounded-lg peer-checked:bg-[var(--color-surface-alt)] peer-checked:border-[var(--color-accent)] peer-checked:text-[var(--color-primary)] font-semibold transition-colors">Upcoming</div>
                                </label>
                                <label class="flex-1 text-center cursor-pointer">
                                    <input type="radio" name="status" value="Ongoing" class="peer sr-only" {{ request('status') == 'Ongoing' ? 'checked' : '' }}>
                                    <div class="py-2 px-1 text-xs border border-gray-200 rounded-lg peer-checked:bg-[var(--color-surface-alt)] peer-checked:border-[var(--color-accent)] peer-checked:text-[var(--color-primary)] font-semibold transition-colors">Ongoing</div>
                                </label>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="pt-4 border-t border-gray-100">
                            <button type="submit" class="w-full btn-primary py-3 rounded-lg shadow-md mb-3">
                                Search Projects
                            </button>
                            <a href="{{ route('projects.index') }}" class="block w-full py-2 text-center text-[var(--color-primary)] font-medium hover:text-[var(--color-accent)] transition-colors text-sm">
                                Clear Filters
                            </a>
                        </div>
                    </form>
                </div>
            </aside>

            <!-- RESULTS AREA -->
            <main class="w-full lg:w-3/4">
                
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
                    <div>
                        <h2 class="font-heading text-2xl font-bold text-[var(--color-primary)] mb-1">Featured Developments</h2>
                        <p class="text-sm text-gray-500">Showing 1 - 4 of 24 projects</p>
                    </div>

                    <!-- Sort -->
                    <div class="relative w-full sm:w-auto">
                        <select class="w-full sm:w-48 appearance-none bg-white border border-gray-200 text-gray-700 py-2.5 px-4 pr-8 rounded-lg leading-tight focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)]">
                            <option>Recommended</option>
                            <option>Newest First</option>
                            <option>Price (Low to High)</option>
                            <option>Price (High to Low)</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>
                </div>

                <!-- Projects Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    @forelse($projects as $project)
                        @php
                            $img = !empty($project->images) ? Storage::url($project->images[0]) : 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=1740&auto=format&fit=crop';
                            $propT = is_array($project->property_types) ? $project->property_types : ['Apartments'];
                        @endphp
                        <x-project-card 
                            :image="$img"
                            logo=""
                            :name="$project->title"
                            :location="$project->location"
                            :type="$project->project_type"
                            :status="$project->status"
                            :startingPrice="'$'.number_format($project->starting_price)"
                            :propertyTypes="$propT"
                            :description="$project->description"
                            :featured="(bool)$project->is_featured"
                            :link="route('projects.show', $project->slug)"
                        />
                    @empty
                        <div class="col-span-1 md:col-span-2 text-center py-12">
                            <p class="text-gray-500 text-lg">No projects match your current filters.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="mt-12 flex justify-center">
                    {{ $projects->links() }}
                </div>

            </main>
        </div>
    </div>
</div>
@endsection
