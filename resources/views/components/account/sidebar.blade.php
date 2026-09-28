<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden sticky top-24">
    <!-- User Info Summary -->
    <div class="p-6 bg-[var(--color-primary)] text-white text-center">
        <div class="w-20 h-20 bg-gray-200 rounded-full mx-auto mb-4 overflow-hidden border-2 border-white shadow-md">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=random" class="w-full h-full object-cover">
        </div>
        <h3 class="font-bold text-lg truncate">{{ auth()->user()->name }}</h3>
        <p class="text-gray-300 text-sm truncate">{{ auth()->user()->email }}</p>
    </div>

    <!-- Navigation -->
    <nav class="flex flex-col py-2">
        <a href="{{ route('account.index') }}" class="px-6 py-3 flex items-center text-sm font-medium {{ request()->routeIs('account.index') ? 'text-[var(--color-primary)] bg-gray-50 border-l-4 border-[var(--color-accent)]' : 'text-gray-600 hover:text-[var(--color-primary)] hover:bg-gray-50 border-l-4 border-transparent' }} transition-colors">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
            Overview
        </a>
        <a href="{{ route('account.profile') }}" class="px-6 py-3 flex items-center text-sm font-medium {{ request()->routeIs('account.profile') ? 'text-[var(--color-primary)] bg-gray-50 border-l-4 border-[var(--color-accent)]' : 'text-gray-600 hover:text-[var(--color-primary)] hover:bg-gray-50 border-l-4 border-transparent' }} transition-colors">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            My Profile
        </a>
        <a href="{{ route('account.my-properties.index') }}" class="px-6 py-3 flex items-center text-sm font-medium {{ request()->routeIs('account.my-properties.*') ? 'text-[var(--color-primary)] bg-gray-50 border-l-4 border-[var(--color-accent)]' : 'text-gray-600 hover:text-[var(--color-primary)] hover:bg-gray-50 border-l-4 border-transparent' }} transition-colors">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            My Properties
        </a>
        <a href="{{ route('account.favorites') }}" class="px-6 py-3 flex items-center justify-between text-sm font-medium {{ request()->routeIs('account.favorites') ? 'text-[var(--color-primary)] bg-gray-50 border-l-4 border-[var(--color-accent)]' : 'text-gray-600 hover:text-[var(--color-primary)] hover:bg-gray-50 border-l-4 border-transparent' }} transition-colors group">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                Saved Properties
            </div>
            <span id="sidebarFavCount" class="bg-gray-100 text-gray-500 text-xs px-2 py-0.5 rounded-full group-hover:bg-[var(--color-accent)] group-hover:text-white transition-colors">0</span>
        </a>
        <a href="{{ route('account.compare') }}" class="px-6 py-3 flex items-center justify-between text-sm font-medium {{ request()->routeIs('account.compare') ? 'text-[var(--color-primary)] bg-gray-50 border-l-4 border-[var(--color-accent)]' : 'text-gray-600 hover:text-[var(--color-primary)] hover:bg-gray-50 border-l-4 border-transparent' }} transition-colors group">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                Compare
            </div>
            <span id="sidebarCompareCount" class="bg-gray-100 text-gray-500 text-xs px-2 py-0.5 rounded-full group-hover:bg-[var(--color-accent)] group-hover:text-white transition-colors">0</span>
        </a>
        <a href="{{ route('account.inquiries') }}" class="px-6 py-3 flex items-center text-sm font-medium {{ request()->routeIs('account.inquiries') ? 'text-[var(--color-primary)] bg-gray-50 border-l-4 border-[var(--color-accent)]' : 'text-gray-600 hover:text-[var(--color-primary)] hover:bg-gray-50 border-l-4 border-transparent' }} transition-colors">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
            My Inquiries
        </a>
        <a href="{{ route('account.alerts.index') }}" class="px-6 py-3 flex items-center text-sm font-medium {{ request()->routeIs('account.alerts.*') ? 'text-[var(--color-primary)] bg-gray-50 border-l-4 border-[var(--color-accent)]' : 'text-gray-600 hover:text-[var(--color-primary)] hover:bg-gray-50 border-l-4 border-transparent' }} transition-colors">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
            Property Alerts
        </a>
        <a href="{{ route('account.notifications.index') }}" class="px-6 py-3 flex items-center justify-between text-sm font-medium {{ request()->routeIs('account.notifications.*') ? 'text-[var(--color-primary)] bg-gray-50 border-l-4 border-[var(--color-accent)]' : 'text-gray-600 hover:text-[var(--color-primary)] hover:bg-gray-50 border-l-4 border-transparent' }} transition-colors group">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                Notifications
            </div>
            @if(auth()->check() && auth()->user()->unreadNotifications->count() > 0)
                <span class="bg-[var(--color-accent)] text-white text-xs px-2 py-0.5 rounded-full font-bold">{{ auth()->user()->unreadNotifications->count() }}</span>
            @endif
        </a>
        <a href="{{ route('account.recently-viewed') }}" class="px-6 py-3 flex items-center text-sm font-medium {{ request()->routeIs('account.recently-viewed') ? 'text-[var(--color-primary)] bg-gray-50 border-l-4 border-[var(--color-accent)]' : 'text-gray-600 hover:text-[var(--color-primary)] hover:bg-gray-50 border-l-4 border-transparent' }} transition-colors">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            Recently Viewed
        </a>
        
        <div class="border-t border-gray-100 my-2"></div>
        
        <a href="{{ route('account.settings') }}" class="px-6 py-3 flex items-center text-sm font-medium {{ request()->routeIs('account.settings') ? 'text-[var(--color-primary)] bg-gray-50 border-l-4 border-[var(--color-accent)]' : 'text-gray-600 hover:text-[var(--color-primary)] hover:bg-gray-50 border-l-4 border-transparent' }} transition-colors">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            Account Settings
        </a>
        <form action="{{ route('logout') }}" method="POST" class="block w-full">
            @csrf
            <button type="submit" class="w-full px-6 py-3 flex items-center text-sm font-medium text-red-500 hover:bg-red-50 hover:text-red-600 border-l-4 border-transparent transition-colors text-left">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                Logout
            </button>
        </form>
    </nav>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Hydrate counts from existing local storage
        setTimeout(() => {
            if(window.AuraFavorites) {
                const favCount = window.AuraFavorites.get().length;
                document.getElementById('sidebarFavCount').innerText = favCount;
            }
            if(window.AuraCompare) {
                const compCount = window.AuraCompare.get().length;
                document.getElementById('sidebarCompareCount').innerText = compCount;
            }
        }, 100);

        window.addEventListener('favorites-updated', (e) => {
            document.getElementById('sidebarFavCount').innerText = e.detail.favorites.length;
        });

        window.addEventListener('compare-updated', (e) => {
            document.getElementById('sidebarCompareCount').innerText = e.detail.compareList.length;
        });
    });
</script>
