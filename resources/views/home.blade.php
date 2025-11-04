<x-app-layout>
    {{-- We are overriding the default gray background with our new primary color --}}
    <div class="bg-primary text-white">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-8">

            <!-- Hero Section for Featured Video -->
            @if($featuredVideo)
            <div class="mb-12 rounded-lg overflow-hidden relative aspect-w-16 aspect-h-9">
                <img src="{{ $featuredVideo->thumbnail_url }}" alt="{{ $featuredVideo->title }}" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
                
                <!-- RESPONSIVE FIX APPLIED TO THIS BLOCK -->
                <div class="absolute bottom-0 left-0 p-4 md:p-8">
                    <h1 class="text-2xl md:text-4xl font-bold mb-2 leading-tight">{{ $featuredVideo->title }}</h1>
                    <p class="hidden md:block text-gray-300 max-w-2xl mb-4 truncate">{{ $featuredVideo->description }}</p>
                    <div class="flex items-center space-x-4 mt-4">
                        <a href="{{ route('videos.show', $featuredVideo) }}" class="bg-accent hover:bg-orange-600 text-white font-bold py-2 px-6 rounded-full transition text-sm md:text-base">
                            Play
                        </a>
                        
                        <!-- WATCHLIST BUTTON IMPLEMENTATION -->
                        @auth
                        <form method="POST" action="{{ route('videos.watchlist.toggle', $featuredVideo) }}">
                            @csrf
                            <button type-="submit" class="text-white font-semibold text-sm md:text-base bg-black/30 hover:bg-black/50 py-2 px-4 rounded-full transition">
                                @if(Auth::user()->watchlist()->where('video_id', $featuredVideo->id)->exists())
                                    ✓ Added to Watchlist
                                @else
                                    + Add to Watchlist
                                @endif
                            </button>
                        </form>
                        @else
                            {{-- Optional: Show a disabled button or nothing for guests --}}
                            <a href="{{ route('login') }}" class="text-white font-semibold text-sm md:text-base bg-black/30 hover:bg-black/50 py-2 px-4 rounded-full transition">
                                + Add to Watchlist
                            </a>
                        @endauth
                        <!-- END WATCHLIST BUTTON -->
                    </div>
                </div>
                <!-- END OF RESPONSIVE FIX -->
            </div>
            @endif

            <!-- Horizontal Scrolling Rows for Categories with Navigation Arrows -->
            @foreach ($categories as $category)
                <div class="mb-8">
                    <a href="{{ route('categories.show', $category) }}" class="inline-block">
                        <h2 class="text-2xl font-bold text-white mb-4 hover:text-accent transition-colors">{{ $category->name }}</h2>
                    </a>

                    <!-- Alpine.js Component for the Scroller -->
                    <div x-data="{
                            scrollContainer: null,
                            init() {
                                this.scrollContainer = this.$refs.container;
                            },
                            scrollLeft() {
                                this.scrollContainer.scrollBy({ left: -this.scrollContainer.offsetWidth, behavior: 'smooth' });
                            },
                            scrollRight() {
                                this.scrollContainer.scrollBy({ left: this.scrollContainer.offsetWidth, behavior: 'smooth' });
                            }
                        }"
                         class="relative group"
                    >
                        <!-- Previous Button -->
                        <button @click="scrollLeft()"
                                class="absolute left-0 top-1/2 -translate-y-1/2 z-10 bg-black bg-opacity-50 hover:bg-opacity-75 p-2 rounded-full cursor-pointer opacity-0 group-hover:opacity-100 transition-opacity hidden sm:block">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                        </button>

                        <!-- The Scrollable Container -->
                        <div x-ref="container" class="flex space-x-4 overflow-x-auto pb-4 scrollbar-hide">
                            @foreach ($category->videos as $video)
                                <div class="flex-shrink-0 w-64">
                                    <a href="{{ route('videos.show', $video) }}" class="block bg-secondary rounded-lg overflow-hidden transform hover:scale-105 transition-transform duration-200">
                                        <img src="{{ $video->thumbnail_url }}" alt="{{ $video->title }}" class="w-full h-36 object-cover">
                                        <div class="p-3">
                                            <h3 class="font-semibold truncate">{{ $video->title }}</h3>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>

                        <!-- Next Button -->
                        <button @click="scrollRight()"
                                class="absolute right-0 top-1/2 -translate-y-1/2 z-10 bg-black bg-opacity-50 hover:bg-opacity-75 p-2 rounded-full cursor-pointer opacity-0 group-hover:opacity-100 transition-opacity hidden sm:block"
                        >
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </button>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</x-app-layout>