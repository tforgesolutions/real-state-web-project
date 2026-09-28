@extends('layouts.app')

@section('title', 'Find Real Estate Agents | Aura Real Estate')

@section('content')
<div class="pt-24 pb-16 bg-[var(--color-surface)] min-h-screen">
    
    <!-- PAGE HEADER -->
    <div class="bg-[var(--color-primary)] text-white py-12 relative overflow-hidden">
        <div class="absolute top-0 right-0 -mt-20 -mr-20 w-96 h-96 bg-[var(--color-accent)]/10 rounded-full blur-3xl"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 animate-fade-up-scroll">
            <div class="flex items-center text-sm text-gray-400 mb-4 space-x-2">
                <a href="{{ route('home') }}" class="hover:text-[var(--color-accent)] transition-colors">Home</a>
                <span>/</span>
                <span class="text-white">Agents</span>
            </div>
            <h1 class="font-heading text-4xl md:text-5xl font-bold mb-4">Find an Agent</h1>
            <p class="text-gray-300 max-w-2xl text-lg">Connect with top-tier real estate professionals who know your local market inside and out.</p>
        </div>
    </div>

    <!-- MAIN LAYOUT -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-10">
        <div class="flex flex-col lg:flex-row gap-8">
            
            <!-- FILTER SIDEBAR -->
            <aside class="w-full lg:w-1/4">
                <div class="glass-panel rounded-2xl p-6 lg:p-8 space-y-6 lg:sticky lg:top-28">
                    <h2 class="font-heading text-xl font-bold text-[var(--color-primary)] mb-2">Search Agents</h2>
                    
                    <form action="{{ route('agents.index') }}" method="GET" class="space-y-5">
                        <!-- Name Search -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Agent Name</label>
                            <div class="relative">
                                <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Search by name..." class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] transition-all">
                                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="pt-4 border-t border-gray-100">
                            <button type="submit" class="w-full btn-primary py-3 rounded-lg shadow-md mb-3">
                                Find Agent
                            </button>
                            <a href="{{ route('agents.index') }}" class="w-full block text-center py-2 text-[var(--color-primary)] font-medium hover:text-[var(--color-accent)] transition-colors text-sm">
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
                        <h2 class="font-heading text-2xl font-bold text-[var(--color-primary)] mb-1">Our Top Agents</h2>
                        <p class="text-sm text-gray-500">Showing {{ $agents->firstItem() ?? 0 }} - {{ $agents->lastItem() ?? 0 }} of {{ $agents->total() }} agents</p>
                    </div>

                    <!-- Sort -->
                    <form action="{{ route('agents.index') }}" method="GET" class="relative w-full sm:w-auto">
                        @if(request('keyword')) <input type="hidden" name="keyword" value="{{ request('keyword') }}"> @endif
                        <select name="sort" onchange="this.form.submit()" class="w-full sm:w-48 appearance-none bg-white border border-gray-200 text-gray-700 py-2.5 px-4 pr-8 rounded-lg leading-tight focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)]">
                            <option value="Highest Rated" {{ request('sort') == 'Highest Rated' ? 'selected' : '' }}>Highest Rated</option>
                            <option value="Name (A-Z)" {{ request('sort') == 'Name (A-Z)' ? 'selected' : '' }}>Name (A-Z)</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </form>
                </div>

                <!-- Agents Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                    @forelse($agents as $agent)
                        <x-agent-card 
                            id="{{ $agent->id }}"
                            image="{{ $agent->profile_photo ? Storage::url($agent->profile_photo) : 'https://images.unsplash.com/photo-1560250097-0b93528c311a?q=80&w=1587&auto=format&fit=crop' }}"
                            name="{{ $agent->name }}"
                            title="{{ $agent->designation ?? 'Real Estate Agent' }}"
                            agency="{{ $agent->agency ?? 'Independent' }}"
                            location="{{ collect([$agent->city, $agent->country])->filter()->join(', ') ?: 'Location unavailable' }}"
                            specialization="Residential"
                            propertiesCount="{{ $agent->properties_count ?? 0 }}"
                            rating="5.0"
                            reviews="0"
                        />
                    @empty
                        <div class="col-span-full py-12 text-center text-gray-500">
                            <i class="fas fa-users text-4xl mb-3 text-gray-300"></i>
                            <p>No agents found matching your criteria.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="mt-12 flex justify-center">
                    {{ $agents->withQueryString()->links() }}
                </div>

            </main>
        </div>
    </div>
</div>
@endsection
