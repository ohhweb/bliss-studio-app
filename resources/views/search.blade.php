<x-app-layout>
    <div class="py-12 bg-gray-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Search Results Title -->
            <h2 class="text-3xl font-bold text-white mb-6 border-l-4 border-amber-500 pl-4">
                Search Results for: <span class="text-amber-500">"{{ $query }}"</span>
            </h2>

            <!-- Grid for the videos -->
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">

                @forelse ($videos as $video)
                    <div class="bg-gray-800 rounded-lg overflow-hidden transform hover:scale-105 transition-transform duration-200">
                        <a href="{{ route('videos.show', $video) }}">
                            <img src="{{ $video->thumbnail_url }}" alt="{{ $video->title }}" class="w-full h-48 object-cover">
                            <div class="p-3">
                                <h3 class="text-white text-md font-semibold truncate">{{ $video->title }}</h3>
                            </div>
                        </a>
                    </div>
                @empty
                    <p class="text-gray-400 col-span-full">No videos found matching your search.</p>
                @endforelse

            </div>

            <!-- Pagination Links -->
            <div class="mt-8">
                {{ $videos->links() }}
            </div>

        </div>
    </div>
</x-app-layout>