<x-app-layout>
    <div class="py-12 bg-gray-900" x-data="{ playing: false }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <!-- UPGRADED Universal Video Player with Click-to-Play -->
                    <div class="relative aspect-w-16 aspect-h-9">
                        <!-- 1. The Thumbnail Image (Visible by default) -->
                        <div x-show="!playing" class="absolute inset-0 flex items-center justify-center cursor-pointer">
                            <img src="{{ $video->thumbnail_url }}" alt="{{ $video->title }}" class="w-full h-full object-cover rounded-lg">
                            <button @click="playing = true" class="absolute z-10 p-4 bg-red-600 rounded-full hover:bg-red-700 transition">
                                <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"></path>
                                </svg>
                            </button>
                        </div>

                        <!-- 2. The Video Iframe (Hidden until 'playing' is true) -->
                        <div x-show="playing" x-cloak class="absolute inset-0">
                            @if($video->video_type == 'youtube')
                                <iframe class="w-full h-full rounded-lg" src="https://www.youtube.com/embed/{{ $video->video_url }}?autoplay=1" title="{{ $video->title }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                            @elseif($video->video_type == 'vimeo')
                                <iframe class="w-full h-full rounded-lg" src="https://player.vimeo.com/video/{{ $video->video_url }}?autoplay=1" title="{{ $video->title }}" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                            @elseif($video->video_type == 'direct')
                                <video src="{{ $video->video_url }}" controls class="w-full h-full rounded-lg" autoplay></video>
                            @endif
                        </div>
                    </div>

                    <!-- Video Details -->
                    <div class="mt-6">
                        <h1 class="text-3xl font-bold text-white">{{ $video->title }}</h1>
                        <p class="text-sm text-gray-400 mt-2">
                            Category: {{ $video->category->name }}
                        </p>
                        <p class="text-gray-300 mt-4">
                            {{ $video->description }}
                        </p>
                    </div>

                    <!-- Like/Unlike Button -->
                    <div class="mt-6 flex items-center space-x-4">
                        @auth
                            <!-- Like/Unlike Button Form -->
                            <form method="POST" action="{{ route('videos.like', $video) }}">
                                @csrf
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    @if(Auth::user()->likes()->where('video_id', $video->id)->exists())
                                        Unlike ({{ $video->likes()->count() }})
                                    @else
                                        Like ({{ $video->likes()->count() }})
                                    @endif
                                </button>
                            </form>

                            <!-- Watchlist Button Form -->
                            <form method="POST" action="{{ route('videos.watchlist.toggle', $video) }}">
                                @csrf
                                <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                    @if(Auth::user()->watchlist()->where('video_id', $video->id)->exists())
                                        - Remove from Watchlist
                                    @else
                                        + Add to Watchlist
                                    @endif
                                </button>
                            </form>

                        @else
                            <p class="text-white">
                                <a href="{{ route('login') }}" class="font-bold underline">Log in</a> to like or add to watchlist.
                                ({{ $video->likes()->count() }} likes)
                            </p>
                        @endauth
                    </div>

                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('home') }}" class="text-blue-400 hover:text-blue-600">&larr; Back to Home</a>
            </div>
        </div>
    </div>
</x-app-layout>
{{-- At the very bottom of videos/show.blade.php --}}
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Send a heartbeat every 60 seconds (60000 milliseconds) while on this page
        const heartbeatInterval = setInterval(window.sendHeartbeat, 60000);

        // Optional: If you use Turbolinks/Livewire, you'd clear this interval
        // when the user navigates away to prevent it from running in the background.
    });
</script>
@endpush