<x-app-layout>
    {{-- This sets the browser tab title dynamically --}}
    <x-slot name="title">{{ $video->title }} - Bliss Films</x-slot>

    <div class="py-12 bg-gray-900" x-data="{ playing: false }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <!-- UPGRADED Universal Video Player with Click-to-Play -->
                    <div class="relative aspect-w-16 aspect-h-9">
                        <div x-show="!playing" class="absolute inset-0 flex items-center justify-center cursor-pointer">
                            <img src="{{ $video->thumbnail_url }}" alt="{{ $video->title }}" class="w-full h-full object-cover rounded-lg">
                            <button @click="playing = true" class="absolute z-10 p-4 bg-red-600 rounded-full hover:bg-red-700 transition">
                                <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"></path></svg>
                            </button>
                        </div>
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
                            Category: <a href="{{ route('categories.show', $video->category) }}" class="hover:underline">{{ $video->category->name }}</a>
                        </p>
                    </div>
                    
                    <!-- Like/Unlike and Watchlist Buttons -->
                    <div class="mt-4 flex items-center space-x-4">
                        @auth
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
                                <a href="{{ route('login') }}" class="font-bold underline">Log in</a> to interact.
                                ({{ $video->likes()->count() }} likes)
                            </p>
                        @endauth
                    </div>
                    
                    <!-- Description -->
                    <p class="text-gray-300 mt-6">{{ $video->description }}</p>
                </div>

                <!-- Social Share and Comments Section -->
                <div class="border-t border-gray-700 p-6">
                    <!-- Social Share Buttons -->
                    <div class="flex items-center space-x-4 mb-8">
                        <span class="text-gray-400 font-semibold">Share:</span>
                        <a href="https://twitter.com/intent/tweet?url={{ url()->current() }}&text=Check out {{ $video->title }}" target="_blank" class="text-gray-400 hover:text-white">Twitter</a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}" target="_blank" class="text-gray-400 hover:text-white">Facebook</a>
                        <a href="whatsapp://send?text=Check out {{ $video->title }}: {{ url()->current() }}" data-action="share/whatsapp/share" class="text-gray-400 hover:text-white">WhatsApp</a>
                    </div>
                    
                    <!-- Comments Section -->
                    <h3 class="text-2xl font-bold text-white mb-4">Comments ({{ $comments->count() }})</h3>

                    <!-- Add a Comment Form -->
                    @auth
                        <form method="POST" action="{{ route('comments.store', $video) }}" class="mb-8">
                            @csrf
                            <textarea name="body" rows="3" class="w-full bg-gray-700 text-white rounded-md border-gray-600 focus:ring-accent focus:border-accent" placeholder="Add a public comment..." required></textarea>
                            <div class="text-right mt-2">
                                <button type="submit" class="bg-accent hover:bg-orange-600 text-white font-bold py-2 px-4 rounded-lg">Comment</button>
                            </div>
                        </form>
                    @else
                        <div class="mb-8 text-center bg-gray-700 p-4 rounded-lg">
                            <a href="{{ route('login') }}" class="font-semibold text-accent hover:underline">Log in</a>
                            <span class="text-gray-400"> to post a comment.</span>
                        </div>
                    @endauth

                    <!-- Existing Comments -->
                    <div class="space-y-6">
                        @forelse ($comments as $comment)
                            <div class="flex space-x-4">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 rounded-full bg-secondary flex items-center justify-center font-bold">{{ strtoupper(substr($comment->user->name, 0, 1)) }}</div>
                                </div>
                                <div>
                                    <div class="flex items-center space-x-2">
                                        <span class="font-bold text-white">{{ $comment->user->name }}</span>
                                        <span class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-gray-300 mt-1">{{ $comment->body }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500">No comments yet. Be the first to comment!</p>
                        @endforelse
                    </div>
                </div>

                <!-- Related Videos Section -->
                @if(!$relatedVideos->isEmpty())
                <div class="border-t border-gray-700 p-6">
                    <h3 class="text-2xl font-bold text-white mb-4">More In This Category</h3>
                    <div class="flex space-x-4 overflow-x-auto pb-4 scrollbar-hide">
                        @foreach ($relatedVideos as $relatedVideo)
                            <div class="flex-shrink-0 w-64">
                                <a href="{{ route('videos.show', $relatedVideo) }}" class="block bg-secondary rounded-lg overflow-hidden transform hover:scale-105 transition-transform duration-200">
                                    <img src="{{ $relatedVideo->thumbnail_url }}" alt="{{ $relatedVideo->title }}" class="w-full h-36 object-cover">
                                    <div class="p-3">
                                        <h3 class="font-semibold truncate">{{ $relatedVideo->title }}</h3>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
            
            <div class="mt-4">
                <a href="{{ route('home') }}" class="text-blue-400 hover:text-blue-600">&larr; Back to Home</a>
            </div>
        </div>
    </div>
</x-app-layout>

{{-- Script to send heartbeat every minute while on this page --}}
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof window.sendHeartbeat === 'function') {
            const heartbeatInterval = setInterval(() => {
                if (!document.hidden) {
                    window.sendHeartbeat(false);
                }
            }, 60000);
        }
    });
</script>
@endpush
<style>
    .w-10.h-10.rounded-full.bg-secondary.flex.items-center.justify-center.font-bold {
    background-color: white;
}</style>