<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - Real Estate</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Add some premium styling */
        body { font-family: 'Inter', sans-serif; }
        .sidebar-item { transition: all 0.3s; }
        .sidebar-item:hover { background-color: #1e3a8a; color: white; }
        .sidebar-item.active { background-color: #1e3a8a; color: white; border-left: 4px solid #60a5fa; }
    </style>
</head>
<body class="bg-gray-50 h-screen flex overflow-hidden">

    <!-- Sidebar -->
    <aside class="bg-blue-900 text-gray-300 w-64 flex-shrink-0 hidden md:flex flex-col">
        <div class="h-16 flex items-center justify-center bg-blue-950 text-white text-2xl font-bold tracking-wider">
            REAL<span class="text-blue-400">ESTATE</span>
        </div>
        
        <div class="flex-1 overflow-y-auto py-4">
            <nav class="space-y-1 px-2">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-item flex items-center px-4 py-3 text-sm font-medium rounded-md {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt w-6"></i> Dashboard
                </a>
                <a href="{{ route('admin.properties.index') }}" class="sidebar-item flex items-center px-4 py-3 text-sm font-medium rounded-md {{ request()->routeIs('admin.properties.*') ? 'active' : '' }}">
                    <i class="fas fa-building w-6"></i> Properties
                </a>
                <a href="{{ route('admin.projects.index') }}" class="sidebar-item flex items-center px-4 py-3 text-sm font-medium rounded-md {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}">
                    <i class="fas fa-city w-6"></i> Projects
                </a>
                <a href="{{ route('admin.agents.index') }}" class="sidebar-item flex items-center px-4 py-3 text-sm font-medium rounded-md {{ request()->routeIs('admin.agents.*') ? 'active' : '' }}">
                    <i class="fas fa-user-tie w-6"></i> Agents
                </a>
                <a href="{{ route('admin.users.index') }}" class="sidebar-item flex items-center px-4 py-3 text-sm font-medium rounded-md {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="fas fa-users w-6"></i> Users
                </a>
                <a href="{{ route('admin.inquiries.index') }}" class="sidebar-item flex items-center px-4 py-3 text-sm font-medium rounded-md {{ request()->routeIs('admin.inquiries.*') ? 'active' : '' }}">
                    <i class="fas fa-envelope w-6"></i> Inquiries / Leads
                </a>
                <a href="{{ route('admin.locations.index') }}" class="sidebar-item flex items-center px-4 py-3 text-sm font-medium rounded-md {{ request()->routeIs('admin.locations.*') ? 'active' : '' }}">
                    <i class="fas fa-map-marker-alt w-6"></i> Locations
                </a>
                <a href="{{ route('admin.property-types.index') }}" class="sidebar-item flex items-center px-4 py-3 text-sm font-medium rounded-md {{ request()->routeIs('admin.property-types.*') ? 'active' : '' }}">
                    <i class="fas fa-tags w-6"></i> Property Types
                </a>
                <a href="{{ route('admin.amenities.index') }}" class="sidebar-item flex items-center px-4 py-3 text-sm font-medium rounded-md {{ request()->routeIs('admin.amenities.*') ? 'active' : '' }}">
                    <i class="fas fa-swimming-pool w-6"></i> Amenities
                </a>
                <a href="{{ route('admin.reports.index') }}" class="sidebar-item flex items-center px-4 py-3 text-sm font-medium rounded-md {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                    <i class="fas fa-chart-bar w-6"></i> Reports
                </a>
                <a href="{{ route('admin.settings.index') }}" class="sidebar-item flex items-center px-4 py-3 text-sm font-medium rounded-md {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                    <i class="fas fa-cog w-6"></i> Settings
                </a>
                
                <a href="{{ route('admin.homepage.index') }}" class="sidebar-item flex items-center px-4 py-3 text-sm font-medium rounded-md {{ request()->routeIs('admin.homepage.*') ? 'active' : '' }}">
                    <i class="fas fa-desktop w-6"></i> Homepage CMS
                </a>
                
                <a href="{{ route('admin.menus.index') }}" class="sidebar-item flex items-center px-4 py-3 text-sm font-medium rounded-md {{ request()->routeIs('admin.menus.*') ? 'active' : '' }}">
                    <i class="fas fa-bars w-6"></i> Menu Management
                </a>

                <a href="{{ route('admin.media.index') }}" class="sidebar-item flex items-center px-4 py-3 text-sm font-medium rounded-md {{ request()->routeIs('admin.media.*') ? 'active' : '' }}">
                    <i class="fas fa-images w-6"></i> Media Library
                </a>

                <a href="{{ route('admin.testimonials.index') }}" class="sidebar-item flex items-center px-4 py-3 text-sm font-medium rounded-md {{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}">
                    <i class="fas fa-quote-left w-6"></i> Testimonials
                </a>
            </nav>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
        <!-- Header -->
        <header class="bg-white shadow-sm h-16 flex-shrink-0 flex items-center justify-between px-6 z-10">
            <div class="flex items-center">
                <button class="text-gray-500 focus:outline-none md:hidden">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <h1 class="text-xl font-semibold text-gray-800 ml-4 md:ml-0">@yield('header', 'Dashboard')</h1>
            </div>
            <div class="flex items-center space-x-4">
                <!-- Notifications Dropdown -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="text-gray-400 hover:text-gray-600 focus:outline-none relative mt-1 mx-2">
                        <i class="fas fa-bell text-xl"></i>
                        @if(auth()->check() && auth()->user()->unreadNotifications->count() > 0)
                        <span class="absolute -top-1 -right-2 bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full">
                            {{ auth()->user()->unreadNotifications->count() }}
                        </span>
                        @endif
                    </button>
                    
                    <div x-show="open" @click.away="open = false" x-cloak class="absolute right-0 mt-2 w-80 bg-white rounded-md shadow-lg overflow-hidden z-50 border border-gray-100" style="display: none;">
                        <div class="py-2 px-4 bg-gray-50 border-b border-gray-100 flex justify-between items-center">
                            <span class="font-bold text-sm text-gray-700">Notifications</span>
                            @if(auth()->check() && auth()->user()->unreadNotifications->count() > 0)
                            <form action="{{ route('admin.notifications.markAllAsRead') }}" method="POST">
                                @csrf
                                <button type="submit" class="text-xs text-blue-600 hover:underline">Mark all read</button>
                            </form>
                            @endif
                        </div>
                        <div class="max-h-64 overflow-y-auto">
                            @if(auth()->check())
                                @forelse(auth()->user()->unreadNotifications->take(5) as $notification)
                                <a href="{{ route('admin.notifications.read', $notification->id) }}" class="block px-4 py-3 border-b border-gray-50 hover:bg-gray-50 {{ $notification->read_at ? 'opacity-75' : 'bg-blue-50/30' }}">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 mt-0.5">
                                            <i class="fas fa-envelope-open-text text-blue-500"></i>
                                        </div>
                                        <div class="ml-3 w-0 flex-1">
                                            <p class="text-sm font-medium text-gray-900 truncate">
                                                {{ $notification->data['name'] ?? 'System' }}
                                            </p>
                                            <p class="text-xs text-gray-500">
                                                {{ $notification->data['type'] ?? 'New Inquiry' }}
                                            </p>
                                            <p class="text-xs text-gray-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                </a>
                                @empty
                                <div class="px-4 py-6 text-center text-gray-500 text-sm">
                                    No new notifications.
                                </div>
                                @endforelse
                            @endif
                        </div>
                        <a href="{{ route('admin.notifications.index') }}" class="block text-center px-4 py-2 text-sm text-blue-600 font-medium bg-gray-50 hover:bg-gray-100">
                            View all notifications
                        </a>
                    </div>
                </div>
                <div class="relative group ml-4">
                    <button class="flex items-center space-x-2 focus:outline-none">
                        @if(Auth::check() && Auth::user()->profile_photo)
                            <img src="{{ Storage::url(Auth::user()->profile_photo) }}" alt="Admin" class="h-8 w-8 rounded-full border border-gray-200 object-cover">
                        @else
                            <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-bold text-sm">
                                {{ Auth::check() ? substr(Auth::user()->name, 0, 1) : 'A' }}
                            </div>
                        @endif
                        <span class="text-sm font-medium text-gray-700 hidden sm:block">{{ Auth::user()->name ?? 'Admin' }}</span>
                        <i class="fas fa-chevron-down text-xs text-gray-400"></i>
                    </button>
                    <!-- Dropdown -->
                    <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 hidden group-hover:block border border-gray-100 z-50">
                        <a href="{{ route('admin.profile.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                        <a href="{{ route('admin.settings.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                        <div class="border-t border-gray-100 mt-1"></div>
                        <form method="POST" action="{{ route('admin.logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Body -->
        <main class="flex-1 overflow-y-auto bg-gray-50 p-6">
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 shadow-sm" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

</body>
</html>
