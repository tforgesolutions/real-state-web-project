@extends('layouts.app')

@section('title', 'Real Estate Agencies | Aura Real Estate')

@section('content')
<div class="pt-24 pb-16 bg-[var(--color-surface)] min-h-screen">
    
    <!-- PAGE HEADER -->
    <div class="bg-[var(--color-primary)] text-white py-12 relative overflow-hidden">
        <div class="absolute top-0 right-0 -mt-20 -mr-20 w-96 h-96 bg-[var(--color-accent)]/10 rounded-full blur-3xl"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 animate-fade-up-scroll">
            <div class="flex items-center text-sm text-gray-400 mb-4 space-x-2">
                <a href="{{ route('home') }}" class="hover:text-[var(--color-accent)] transition-colors">Home</a>
                <span>/</span>
                <span class="text-white">Agencies</span>
            </div>
            <h1 class="font-heading text-4xl md:text-5xl font-bold mb-4">Discover Top Agencies</h1>
            <p class="text-gray-300 max-w-2xl text-lg">Find reputable real estate agencies and brokerages to help you with your property journey.</p>
        </div>
    </div>

    <!-- MAIN LAYOUT -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-10">
        <div class="flex flex-col lg:flex-row gap-8">
            
            <!-- FILTER SIDEBAR -->
            <aside class="w-full lg:w-1/4">
                <div class="glass-panel rounded-2xl p-6 lg:p-8 space-y-6 lg:sticky lg:top-28">
                    <h2 class="font-heading text-xl font-bold text-[var(--color-primary)] mb-2">Search Agencies</h2>
                    
                    <form onsubmit="event.preventDefault();" class="space-y-5">
                        <!-- Name Search -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Agency Name</label>
                            <div class="relative">
                                <input type="text" placeholder="Search by name..." class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] transition-all">
                                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                        </div>

                        <!-- Location -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Location</label>
                            <input type="text" placeholder="City or Area" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] transition-all">
                        </div>

                        <!-- Specialization -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Specialization</label>
                            <select class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] transition-all appearance-none">
                                <option>Any Type</option>
                                <option>Residential Sales</option>
                                <option>Commercial Real Estate</option>
                                <option>Property Management</option>
                                <option>Luxury Brokerage</option>
                            </select>
                        </div>

                        <!-- Buttons -->
                        <div class="pt-4 border-t border-gray-100">
                            <button type="submit" class="w-full btn-primary py-3 rounded-lg shadow-md mb-3">
                                Find Agency
                            </button>
                            <button type="reset" class="w-full py-2 text-[var(--color-primary)] font-medium hover:text-[var(--color-accent)] transition-colors text-sm">
                                Clear Filters
                            </button>
                        </div>
                    </form>
                </div>
            </aside>

            <!-- RESULTS AREA -->
            <main class="w-full lg:w-3/4">
                
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
                    <div>
                        <h2 class="font-heading text-2xl font-bold text-[var(--color-primary)] mb-1">Top Brokerages</h2>
                        <p class="text-sm text-gray-500">Showing 1 - 4 of 18 agencies</p>
                    </div>

                    <!-- Sort -->
                    <div class="relative w-full sm:w-auto">
                        <select class="w-full sm:w-48 appearance-none bg-white border border-gray-200 text-gray-700 py-2.5 px-4 pr-8 rounded-lg leading-tight focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)]">
                            <option>Most Agents</option>
                            <option>Most Properties</option>
                            <option>Name (A-Z)</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>
                </div>

                <!-- Agencies Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-agency-card 
                        logo="https://images.unsplash.com/photo-1560179707-f14e90ef3623?q=80&w=1500&auto=format&fit=crop"
                        name="Aura Premier Group"
                        description="Specializing in luxury real estate, high-end residential sales, and exclusive estates."
                        location="Beverly Hills, CA"
                        specialization="Luxury Estates"
                        agentCount="14"
                        propertiesCount="128"
                    />
                    <x-agency-card 
                        logo="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=1740&auto=format&fit=crop"
                        name="Urban Living Realty"
                        description="Your experts in downtown high-rises, commercial spaces, and metropolitan living."
                        location="New York, NY"
                        specialization="Commercial"
                        agentCount="22"
                        propertiesCount="205"
                    />
                    <x-agency-card 
                        logo="https://images.unsplash.com/photo-1582407947304-fd86f028f716?q=80&w=1596&auto=format&fit=crop"
                        name="Coastal Properties"
                        description="Premier beachfront real estate brokerage providing exceptional coastal living opportunities."
                        location="Miami, FL"
                        specialization="Residential"
                        agentCount="8"
                        propertiesCount="45"
                    />
                    <x-agency-card 
                        logo="https://images.unsplash.com/photo-1497366216548-37526070297c?q=80&w=1738&auto=format&fit=crop"
                        name="Peak Real Estate"
                        description="Connecting developers, investors, and land buyers with prime plots and acreages."
                        location="Austin, TX"
                        specialization="Plot/Land"
                        agentCount="11"
                        propertiesCount="86"
                    />
                </div>
            </main>
        </div>
    </div>
</div>
@endsection
