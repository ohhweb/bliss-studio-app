<x-app-layout>
    <div class="bg-primary text-white min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-8">
            <!-- Search Form -->
            <form method="GET" action="{{ route('search') }}">
                <div class="relative">
                    <input
                        type="text"
                        name="query"
                        placeholder="Search for movies, songs, serials..."
                        class="w-full bg-secondary text-white border-gray-600 rounded-full py-3 px-4 pl-10 text-lg focus:ring-accent focus:border-accent"
                        autofocus
                    >
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                </div>
            </form>

            <!-- Placeholder for Recent/Trending Searches -->
            <div class="mt-8">
                <h3 class="text-xl font-semibold text-gray-300">Trending Searches</h3>
                <div class="mt-4 flex flex-wrap gap-2">
                    {{-- This can be made dynamic later --}}
                    <a href="{{ route('search', ['query' => 'Comedy']) }}" class="bg-secondary px-3 py-1 rounded-full text-sm">Comedy</a>
                    <a href="{{ route('search', ['query' => 'Action']) }}" class="bg-secondary px-3 py-1 rounded-full text-sm">Action</a>
                    <a href="{{ route('search', ['query' => 'Drama']) }}" class="bg-secondary px-3 py-1 rounded-full text-sm">Drama</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>