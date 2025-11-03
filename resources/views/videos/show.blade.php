<x-app-layout>
    <div class="py-12 bg-gray-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <!-- Universal Video Player -->
                    <div class="aspect-w-16 aspect-h-9">
                        @if($video->video_type == 'youtube')
                            <iframe class="w-full h-full rounded-lg" src="https://www.youtube.com/embed/{{ $video->video_url }}" title="{{ $video->title }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                        @elseif($video->video_type == 'vimeo')
                            <iframe class="w-full h-full rounded-lg" src="https://player.vimeo.com/video/{{ $video->video_url }}" title="{{ $video->title }}" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                        @elseif($video->video_type == 'direct')
                            <video src="{{ $video->video_url }}" controls class="w-full h-full rounded-lg"></video>
                        @endif
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

                    <!-- Like/Unlike Button will be fixed in the next section -->
                    <div class="mt-6" id="like-section">
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
                        @else
                            <p class="text-white">
                                <a href="{{ route('login') }}" class="font-bold underline">Log in</a> to like this video.
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