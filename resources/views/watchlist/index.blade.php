<x-app-layout>
    <div class="bg-primary text-white min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-8">
            <h2 class="text-3xl font-bold text-white mb-6 border-l-4 border-accent pl-4">
                My Watchlist
            </h2>

            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
                @forelse ($videos as $video)
                    <div class="bg-secondary rounded-lg overflow-hidden transform hover:scale-105 transition-transform duration-200">
                        <a href="{{ route('videos.show', $video) }}">
                            <img src="{{ $video->thumbnail_url }}" alt="{{ $video->title }}" class="w-full h-48 object-cover">
                            <div class="p-3">
                                <h3 class="text-white text-md font-semibold truncate">{{ $video->title }}</h3>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-gray-400 text-lg">Your watchlist is empty.</p>
                        <p class="text-gray-500 mt-2">Click the "+ Add to Watchlist" button on any video to save it here.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $videos->links() }}
            </div>
        </div>
    </div>
</x-app-layout>