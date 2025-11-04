<nav class="sm:hidden fixed bottom-0 left-0 w-full bg-secondary border-t border-gray-700 px-4 py-2 flex justify-around items-center z-50">
    <!-- Home Link -->
    <a href="{{ route('home') }}" class="flex flex-col items-center text-center {{ request()->routeIs('home') ? 'text-accent' : 'text-gray-400' }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
        <span class="text-xs">Home</span>
    </a>

    <!-- Search Link -->
    <a href="{{ route('search.form') }}" class="flex flex-col items-center text-center {{ request()->routeIs('search') ? 'text-accent' : 'text-gray-400' }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        <span class="text-xs">Search</span>
    </a>

    <!-- Categories Link (we'll create this page later) -->
    <a href="{{ route('categories.index') }}" class="flex flex-col items-center text-center {{ request()->routeIs('categories.index') ? 'text-accent' : 'text-gray-400' }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/></svg>
        <span class="text-xs">Categories</span>
    </a>

    <!-- Profile Link -->
    <a href="{{ route('profile.edit') }}" class="flex flex-col items-center text-center {{ request()->routeIs('profile.edit') ? 'text-accent' : 'text-gray-400' }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
        <span class="text-xs">Profile</span>
    </a>
</nav>