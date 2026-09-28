<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
        <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('meta_description', \App\Models\Setting::get('seo_meta_description', 'Aura is a premium real estate platform to find, buy, rent or sell your dream property.'))">
    <meta name="keywords" content="@yield('meta_keywords', \App\Models\Setting::get('seo_meta_keywords', ''))">
    <meta name="author" content="{{ \App\Models\Setting::get('seo_author', '') }}">
    <meta property="og:title" content="@yield('title', \App\Models\Setting::get('seo_meta_title', \App\Models\Setting::get('site_name', 'Aura Real Estate')))">
    <meta property="og:description" content="@yield('meta_description', \App\Models\Setting::get('seo_meta_description', 'Aura is a premium real estate platform to find, buy, rent or sell your dream property.'))">
    <meta property="og:type" content="website">
    <title>@yield('title', \App\Models\Setting::get('seo_meta_title', \App\Models\Setting::get('site_name', 'Aura Real Estate')))</title>

    @if(\App\Models\Setting::get('favicon'))
        <link rel="icon" href="{{ Storage::url(\App\Models\Setting::get('favicon')) }}">
    @endif

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex flex-col min-h-screen">
    
    <!-- Navbar -->
    <header class="fixed w-full z-50 transition-all duration-300 bg-white shadow-sm" id="navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex-shrink-0 flex items-center">
                    <a href="/" class="font-heading text-2xl font-bold text-[var(--color-primary)] flex items-center">
                        @if(\App\Models\Setting::get('logo'))
                            <img src="{{ Storage::url(\App\Models\Setting::get('logo')) }}" alt="{{ \App\Models\Setting::get('site_name', 'Aura') }}" class="h-10">
                        @else
                            {{ \App\Models\Setting::get('site_name', 'Aura') }}<span class="text-[var(--color-accent)]">.</span>
                        @endif
                    </a>
                </div>
                
                <nav class="hidden md:flex space-x-8">
                    @php
                        $headerMenus = Illuminate\Support\Facades\Cache::remember('menu_header', 86400, function() {
                            return \App\Models\MenuItem::where('location', 'header')
                                ->whereNull('parent_id')
                                ->where('is_active', true)
                                ->with(['children' => function($q) {
                                    $q->where('is_active', true)->orderBy('order');
                                }])
                                ->orderBy('order')
                                ->get();
                        });
                    @endphp

                    @if($headerMenus->isEmpty())
                        <!-- Fallback Navigation -->
                        <a href="{{ route('properties.index') }}" class="nav-link">Buy</a>
                        <a href="{{ route('properties.index', ['layout' => 'list']) }}" class="nav-link">Rent</a>
                        <a href="{{ route('projects.index') }}" class="nav-link">Projects</a>
                        <a href="{{ route('locations.index') }}" class="nav-link">Locations</a>
                        <a href="{{ route('agents.index') }}" class="nav-link">Agents</a>
                        <a href="{{ route('blog.index') }}" class="nav-link">Blog</a>
                        <a href="{{ route('about.index') }}" class="nav-link">About</a>
                    @else
                        @foreach($headerMenus as $menu)
                            @if($menu->children->isEmpty())
                                <a href="{{ url($menu->url) }}" target="{{ $menu->target }}" class="nav-link">{{ $menu->name }}</a>
                            @else
                                <div class="relative group">
                                    <button class="nav-link flex items-center bg-transparent border-none focus:outline-none">
                                        {{ $menu->name }}
                                        <svg class="ml-1 w-4 h-4 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </button>
                                    <div class="absolute left-0 mt-2 w-48 bg-white border border-gray-100 rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                                        <div class="py-1">
                                            @foreach($menu->children as $child)
                                                <a href="{{ url($child->url) }}" target="{{ $child->target }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-[var(--color-primary)]">{{ $child->name }}</a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endif
                </nav>

                <div class="hidden md:flex items-center space-x-4">
                    <a href="{{ route('compare.index') }}" class="text-[var(--color-primary)] opacity-80 hover:opacity-100 hover:text-[var(--color-accent)] transition-colors relative flex items-center justify-center w-10 h-10 rounded-full hover:bg-gray-100" aria-label="Compare Properties">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        <span id="navCompareCount" class="absolute top-1 right-1 bg-[var(--color-accent)] text-white text-[10px] font-bold w-4 h-4 rounded-full flex items-center justify-center hidden">0</span>
                    </a>
                    <a href="{{ route('favorites.index') }}" class="text-[var(--color-primary)] opacity-80 hover:opacity-100 hover:text-[var(--color-accent)] transition-colors relative flex items-center justify-center w-10 h-10 rounded-full hover:bg-gray-100" aria-label="Saved Properties">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                        <span id="navFavCount" class="absolute top-1 right-1 bg-[var(--color-accent)] text-white text-[10px] font-bold w-4 h-4 rounded-full flex items-center justify-center hidden">0</span>
                    </a>
                    
                    @guest
                        <a href="{{ route('login') }}" class="text-sm font-medium text-[var(--color-primary)] opacity-80 hover:opacity-100">Sign In</a>
                        <a href="{{ route('register') }}" class="text-sm font-medium text-[var(--color-primary)] opacity-80 hover:opacity-100">Register</a>
                        <a href="{{ route('properties.create') }}" class="btn-primary text-sm px-4 py-2">List Property</a>
                    @else
                        <!-- Notifications -->
                        <div class="relative group hidden md:block">
                            <button class="text-[var(--color-primary)] opacity-80 hover:opacity-100 hover:text-[var(--color-accent)] transition-colors relative flex items-center justify-center w-10 h-10 rounded-full hover:bg-gray-100 focus:outline-none" aria-label="Notifications">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                                @if(auth()->user()->unreadNotifications->count() > 0)
                                    <span class="absolute top-1 right-1 bg-red-500 text-white text-[10px] font-bold w-4 h-4 rounded-full flex items-center justify-center">{{ auth()->user()->unreadNotifications->count() }}</span>
                                @endif
                            </button>
                            
                            <!-- Notifications Dropdown -->
                            <div class="absolute right-0 mt-1 w-80 bg-white rounded-xl shadow-xl border border-gray-100 py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all transform origin-top-right z-50">
                                <div class="px-4 py-3 border-b border-gray-50 flex justify-between items-center">
                                    <h4 class="font-bold text-gray-900">Notifications</h4>
                                    @if(auth()->user()->unreadNotifications->count() > 0)
                                    <form method="POST" action="{{ route('account.notifications.read-all') }}">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="text-xs text-[var(--color-accent)] hover:underline font-medium">Mark all as read</button>
                                    </form>
                                    @endif
                                </div>
                                <div class="max-h-64 overflow-y-auto">
                                    @forelse(auth()->user()->unreadNotifications->take(5) as $notification)
                                        <a href="{{ route('account.notifications.index') }}" class="block px-4 py-3 hover:bg-gray-50 border-b border-gray-50 last:border-0">
                                            <p class="text-sm text-gray-800 font-medium">{{ $notification->data['title'] ?? 'New Notification' }}</p>
                                            <p class="text-xs text-gray-500 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                        </a>
                                    @empty
                                        <div class="px-4 py-6 text-center text-gray-500 text-sm">
                                            No new notifications
                                        </div>
                                    @endforelse
                                </div>
                                <a href="{{ route('account.notifications.index') }}" class="block px-4 py-2 text-center text-sm text-[var(--color-primary)] font-bold border-t border-gray-50 hover:bg-gray-50">View All</a>
                            </div>
                        </div>

                        <!-- User Menu -->
                        <div class="relative group">
                            <button class="flex items-center space-x-2 text-sm font-medium text-[var(--color-primary)] opacity-80 hover:opacity-100 focus:outline-none py-2">
                                @if(auth()->user()->profile_photo)
                                    <img src="{{ Storage::url(auth()->user()->profile_photo) }}" class="w-8 h-8 rounded-full border border-gray-200 object-cover">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=random&size=32" class="w-8 h-8 rounded-full border border-gray-200">
                                @endif
                                <span>{{ explode(' ', auth()->user()->name)[0] }}</span>
                                <svg class="w-4 h-4 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            
                            <!-- Dropdown -->
                            <div class="absolute right-0 mt-1 w-56 bg-white rounded-xl shadow-xl border border-gray-100 py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all transform origin-top-right z-50">
                                <div class="px-4 py-2 border-b border-gray-50 mb-2">
                                    <p class="text-sm font-bold text-gray-900 truncate">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                                </div>
                                <a href="{{ route('account.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-[var(--color-primary)]">My Account</a>
                                <a href="{{ route('account.my-properties.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-[var(--color-primary)]">My Properties</a>
                                <a href="{{ route('account.favorites') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-[var(--color-primary)]">Saved Properties</a>
                                <a href="{{ route('account.alerts.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-[var(--color-primary)]">Property Alerts</a>
                                <a href="{{ route('account.settings') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-[var(--color-primary)]">Settings</a>
                                <div class="border-t border-gray-50 my-2"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-500 hover:bg-red-50">Logout</button>
                                </form>
                            </div>
                        </div>
                    @endguest
                </div>

                <div class="md:hidden flex items-center space-x-2">
                    <a href="{{ route('compare.index') }}" class="text-[var(--color-primary)] opacity-80 hover:opacity-100 transition-colors relative flex items-center justify-center p-2" aria-label="Compare Properties">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        <span id="mobileNavCompareCount" class="absolute top-1 right-1 bg-[var(--color-accent)] text-white text-[10px] font-bold w-4 h-4 rounded-full flex items-center justify-center hidden">0</span>
                    </a>
                    <a href="{{ route('favorites.index') }}" class="text-[var(--color-primary)] opacity-80 hover:opacity-100 transition-colors relative flex items-center justify-center p-2" aria-label="Saved Properties">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                        <span id="mobileNavFavCount" class="absolute top-1 right-1 bg-[var(--color-accent)] text-white text-[10px] font-bold w-4 h-4 rounded-full flex items-center justify-center hidden">0</span>
                    </a>
                    @auth
                        <a href="{{ route('account.notifications.index') }}" class="text-[var(--color-primary)] opacity-80 hover:opacity-100 transition-colors relative flex items-center justify-center p-2" aria-label="Notifications">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                            @if(auth()->user()->unreadNotifications->count() > 0)
                                <span class="absolute top-1 right-1 bg-red-500 text-white text-[10px] font-bold w-4 h-4 rounded-full flex items-center justify-center">{{ auth()->user()->unreadNotifications->count() }}</span>
                            @endif
                        </a>
                        <a href="{{ route('account.index') }}" class="text-[var(--color-primary)] opacity-80 hover:opacity-100 transition-colors p-2">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=random&size=32" class="w-7 h-7 rounded-full border border-gray-200">
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-[var(--color-primary)] opacity-80 hover:opacity-100 transition-colors p-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </a>
                    @endauth
                    <button class="text-[var(--color-primary)] hover:text-[var(--color-accent)] focus:outline-none ml-1">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Toast Notification Container -->
    <div id="toast-container" class="fixed bottom-5 right-5 z-[100] flex flex-col gap-3 pointer-events-none"></div>

    <!-- Footer -->
    <footer class="bg-[var(--color-primary)] text-white pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <div class="col-span-1 md:col-span-1">
                    <a href="/" class="font-heading text-2xl font-bold text-white mb-6 inline-block flex items-center">
                        @if(\App\Models\Setting::get('logo'))
                            <img src="{{ Storage::url(\App\Models\Setting::get('logo')) }}" alt="{{ \App\Models\Setting::get('site_name', 'Aura') }}" class="h-10 brightness-0 invert">
                        @else
                            {{ \App\Models\Setting::get('site_name', 'Aura') }}<span class="text-[var(--color-accent)]">.</span>
                        @endif
                    </a>
                    <p class="text-gray-400 text-sm mb-6 leading-relaxed">
                        {{ \App\Models\Setting::get('site_description', 'Curating the finest properties for discerning individuals. Experience real estate with unmatched elegance and exclusivity.') }}
                    </p>
                    <div class="flex space-x-4">
                        @if(\App\Models\Setting::get('social_facebook'))
                            <a href="{{ \App\Models\Setting::get('social_facebook') }}" target="_blank" class="text-gray-400 hover:text-white transition-colors"><svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.77 7.46H14.5v-1.9c0-.9.6-1.1 1-1.1h3V.5h-4.33C10.24.5 9.5 3.44 9.5 5.32v2.15h-3v4h3v12h5v-12h3.85l.42-4z"/></svg></a>
                        @endif
                        @if(\App\Models\Setting::get('social_instagram'))
                            <a href="{{ \App\Models\Setting::get('social_instagram') }}" target="_blank" class="text-gray-400 hover:text-white transition-colors"><svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.16c3.2 0 3.58.01 4.85.07 3.25.15 4.77 1.69 4.92 4.92.06 1.27.07 1.65.07 4.85s-.01 3.58-.07 4.85c-.15 3.23-1.66 4.77-4.92 4.92-1.27.06-1.64.07-4.85.07s-3.58-.01-4.85-.07c-3.26-.15-4.77-1.69-4.92-4.92-.06-1.27-.07-1.64-.07-4.85s.01-3.58.07-4.85c.15-3.23 1.66-4.77 4.92-4.92 1.27-.06 1.65-.07 4.85-.07M12 0C8.74 0 8.33.01 7.05.07c-4.27.2-6.78 2.71-6.98 6.98C0 8.33 0 8.74 0 12s.01 3.67.07 4.95c.2 4.27 2.71 6.78 6.98 6.98 1.28.06 1.69.07 4.95.07s3.67-.01 4.95-.07c4.27-.2 6.78-2.71 6.98-6.98.06-1.28.07-1.69.07-4.95s-.01-3.67-.07-4.95c-.2-4.27-2.71-6.78-6.98-6.98C15.67.01 15.26 0 12 0zm0 5.84A6.16 6.16 0 1 0 18.16 12 6.16 6.16 0 0 0 12 5.84zm0 10.16A4 4 0 1 1 16 12a4 4 0 0 1-4 4zm7.85-11.4a1.44 1.44 0 1 1-2.88 0 1.44 1.44 0 0 1 2.88 0z"/></svg></a>
                        @endif
                        @if(\App\Models\Setting::get('social_twitter'))
                            <a href="{{ \App\Models\Setting::get('social_twitter') }}" target="_blank" class="text-gray-400 hover:text-white transition-colors"><svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.95 4.57a10 10 0 01-2.82.77 4.96 4.96 0 002.16-2.72 9.9 9.9 0 01-3.13 1.2 4.93 4.93 0 00-8.38 4.48A14 14 0 011.67 3.15a4.93 4.93 0 001.52 6.57 4.9 4.9 0 01-2.23-.62v.06a4.93 4.93 0 003.95 4.83 4.92 4.92 0 01-2.22.08 4.93 4.93 0 004.6 3.42A9.87 9.87 0 010 19.54 13.94 13.94 0 007.55 21.7c9.06 0 14-7.5 14-14v-.64a10.03 10.03 0 002.46-2.55z"/></svg></a>
                        @endif
                        @if(\App\Models\Setting::get('social_linkedin'))
                            <a href="{{ \App\Models\Setting::get('social_linkedin') }}" target="_blank" class="text-gray-400 hover:text-white transition-colors"><svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.45 20.45h-3.56v-5.56c0-1.33-.03-3.04-1.85-3.04-1.85 0-2.14 1.45-2.14 2.94v5.66H9.34V9h3.42v1.56h.05c.48-.9 1.63-1.85 3.37-1.85 3.6 0 4.27 2.37 4.27 5.45v6.3zM5.34 7.43a2.06 2.06 0 110-4.13 2.06 2.06 0 010 4.13zM7.12 20.45H3.56V9h3.56v11.45zM22.22 0H1.77C.8 0 0 .78 0 1.73v20.54C0 23.22.8 24 1.77 24h20.45c.98 0 1.78-.78 1.78-1.73V1.73C24 .78 23.2 0 22.22 0z"/></svg></a>
                        @endif
                        @if(\App\Models\Setting::get('social_youtube'))
                            <a href="{{ \App\Models\Setting::get('social_youtube') }}" target="_blank" class="text-gray-400 hover:text-white transition-colors"><svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.5 6.18a3 3 0 00-2.12-2.13C19.5 3.5 12 3.5 12 3.5s-7.5 0-9.38.55A3 3 0 00.5 6.18 31.42 31.42 0 000 12a31.42 31.42 0 00.5 5.82 3 3 0 002.12 2.13c1.88.55 9.38.55 9.38.55s7.5 0 9.38-.55a3 3 0 002.12-2.13A31.42 31.42 0 0024 12a31.42 31.42 0 00-.5-5.82zM9.54 15.56V8.44L15.82 12l-6.28 3.56z"/></svg></a>
                        @endif
                    </div>
                </div>
                <div>
                    <h4 class="font-heading text-lg mb-6">Properties</h4>
                    <ul class="space-y-3 text-sm text-gray-400">
                        <li><a href="{{ route('properties.index') }}" class="hover:text-white transition-colors">Buy a Home</a></li>
                        <li><a href="{{ route('properties.index', ['layout' => 'list']) }}" class="hover:text-white transition-colors">Rent a Home</a></li>
                        <li><a href="{{ route('projects.index') }}" class="hover:text-white transition-colors">New Developments</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Commercial</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-heading text-lg mb-6">Quick Links</h4>
                    <ul class="space-y-3 text-sm text-gray-400">
                        @php
                            $footerMenus = Illuminate\Support\Facades\Cache::remember('menu_footer', 86400, function() {
                                return \App\Models\MenuItem::where('location', 'footer')
                                    ->whereNull('parent_id')
                                    ->where('is_active', true)
                                    ->orderBy('order')
                                    ->get();
                            });
                        @endphp
                        
                        @if($footerMenus->isEmpty())
                            <li><a href="{{ route('about.index') }}" class="hover:text-white transition-colors">About Us</a></li>
                            <li><a href="{{ route('blog.index') }}" class="hover:text-white transition-colors">News & Insights</a></li>
                            <li><a href="{{ route('agents.index') }}" class="hover:text-white transition-colors">Our Agents</a></li>
                            <li><a href="{{ route('faq.index') }}" class="hover:text-white transition-colors">FAQ</a></li>
                            <li><a href="{{ route('contact.index') }}" class="hover:text-white transition-colors">Contact</a></li>
                        @else
                            @foreach($footerMenus as $menu)
                                <li><a href="{{ url($menu->url) }}" target="{{ $menu->target }}" class="hover:text-white transition-colors">{{ $menu->name }}</a></li>
                            @endforeach
                        @endif
                    </ul>
                </div>
                <div>
                    <h4 class="font-heading text-lg mb-6">Contact Us</h4>
                    <ul class="space-y-3 text-sm text-gray-400">
                        @if(\App\Models\Setting::get('contact_phone'))
                            <li class="flex items-center"><svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg> {{ \App\Models\Setting::get('contact_phone') }}</li>
                        @endif
                        @if(\App\Models\Setting::get('contact_email'))
                            <li class="flex items-center"><svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg> {{ \App\Models\Setting::get('contact_email') }}</li>
                        @endif
                        @if(\App\Models\Setting::get('contact_address') || \App\Models\Setting::get('contact_city'))
                            <li class="flex items-start"><svg class="w-4 h-4 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg> <span>{{ \App\Models\Setting::get('contact_address') }}<br>{{ \App\Models\Setting::get('contact_city') }}, {{ \App\Models\Setting::get('contact_country') }}</span></li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-500 text-sm">&copy; {{ date('Y') }} {{ \App\Models\Setting::get('site_name', 'Aura Real Estate') }}. All rights reserved.</p>
                <div class="flex space-x-4 mt-4 md:mt-0 text-gray-500">
                    <a href="#" class="hover:text-white transition-colors text-sm">Privacy Policy</a>
                    <a href="#" class="hover:text-white transition-colors text-sm">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Global Toast Logic
        window.AuraToast = {
            show: function(message, type = 'info') {
                const container = document.getElementById('toast-container');
                if(!container) return;
                
                let iconHtml = '';
                if(type === 'success') {
                    iconHtml = '<svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>';
                } else if(type === 'error') {
                    iconHtml = '<svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
                } else {
                    iconHtml = '<svg class="w-5 h-5 text-red-500 fill-current" viewBox="0 0 24 24"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>';
                }

                const toast = document.createElement('div');
                toast.className = 'bg-gray-900 text-white px-6 py-3 rounded-xl shadow-xl flex items-center gap-3 transform translate-y-10 opacity-0 transition-all duration-300';
                toast.innerHTML = `
                    ${iconHtml}
                    <span class="text-sm font-medium">${message}</span>
                `;
                
                container.appendChild(toast);
                
                setTimeout(() => { toast.classList.remove('translate-y-10', 'opacity-0'); }, 10);
                setTimeout(() => {
                    toast.classList.add('translate-y-10', 'opacity-0');
                    setTimeout(() => toast.remove(), 300);
                }, 3000);
            }
        };

        // Favorites Global Logic
        window.AuraFavorites = {
            get: function() {
                return JSON.parse(localStorage.getItem('aura_favorites') || '[]');
            },
            toggle: function(propertyObj) {
                let favorites = this.get();
                const index = favorites.findIndex(f => f.title === propertyObj.title);
                let added = false;
                
                if (index === -1) {
                    favorites.push(propertyObj);
                    added = true;
                    window.AuraToast.show('Property saved to favorites');
                } else {
                    favorites.splice(index, 1);
                    window.AuraToast.show('Property removed from favorites');
                }
                
                localStorage.setItem('aura_favorites', JSON.stringify(favorites));
                this.updateUI();
                window.dispatchEvent(new CustomEvent('favorites-updated'));
                return added;
            },
            isSaved: function(title) {
                return this.get().some(f => f.title === title);
            },
            updateUI: function() {
                const count = this.get().length;
                ['navFavCount', 'mobileNavFavCount'].forEach(id => {
                    const badge = document.getElementById(id);
                    if (badge) {
                        badge.innerText = count;
                        if (count > 0) badge.classList.remove('hidden');
                        else badge.classList.add('hidden');
                    }
                });

                document.querySelectorAll('.favorite-btn').forEach(btn => {
                    const title = btn.dataset.title;
                    const svg = btn.querySelector('svg');
                    if(this.isSaved(title)) {
                        svg.classList.add('fill-red-500', 'text-red-500');
                        svg.classList.remove('fill-none', 'text-gray-400');
                    } else {
                        svg.classList.remove('fill-red-500', 'text-red-500');
                        svg.classList.add('fill-none', 'text-gray-400');
                    }
                });
            }
        };

        // Compare Global Logic
        window.AuraCompare = {
            limit: 4,
            get: function() {
                return JSON.parse(localStorage.getItem('aura_compare') || '[]');
            },
            toggle: function(propertyObj) {
                let compareList = this.get();
                const index = compareList.findIndex(p => p.title === propertyObj.title);
                
                if (index === -1) {
                    if(compareList.length >= this.limit) {
                        window.AuraToast.show(`You can compare up to ${this.limit} properties at a time.`, 'error');
                        return false;
                    }
                    compareList.push(propertyObj);
                    window.AuraToast.show('Added to comparison', 'success');
                } else {
                    compareList.splice(index, 1);
                    window.AuraToast.show('Removed from comparison', 'success');
                }
                
                localStorage.setItem('aura_compare', JSON.stringify(compareList));
                this.updateUI();
                window.dispatchEvent(new CustomEvent('compare-updated'));
                return true;
            },
            clear: function() {
                localStorage.removeItem('aura_compare');
                this.updateUI();
                window.dispatchEvent(new CustomEvent('compare-updated'));
                window.AuraToast.show('Comparison list cleared', 'success');
            },
            isAdded: function(title) {
                return this.get().some(p => p.title === title);
            },
            updateUI: function() {
                const count = this.get().length;
                ['navCompareCount', 'mobileNavCompareCount'].forEach(id => {
                    const badge = document.getElementById(id);
                    if (badge) {
                        badge.innerText = count;
                        if (count > 0) badge.classList.remove('hidden');
                        else badge.classList.add('hidden');
                    }
                });

                document.querySelectorAll('.compare-btn').forEach(btn => {
                    const title = btn.dataset.title;
                    const svg = btn.querySelector('svg');
                    if(this.isAdded(title)) {
                        btn.classList.add('bg-[var(--color-primary)]', 'text-white');
                        btn.classList.remove('bg-white/80', 'text-gray-400', 'hover:bg-white', 'hover:text-[var(--color-primary)]');
                    } else {
                        btn.classList.remove('bg-[var(--color-primary)]', 'text-white');
                        btn.classList.add('bg-white/80', 'text-gray-400', 'hover:bg-white', 'hover:text-[var(--color-primary)]');
                    }
                });
            }
        };

        // Initialize on load
        document.addEventListener('DOMContentLoaded', () => {
            window.AuraFavorites.updateUI();
            window.AuraCompare.updateUI();
        });
    </script>
</body>
</html>


