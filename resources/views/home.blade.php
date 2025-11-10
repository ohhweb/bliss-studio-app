<x-app-layout>
    {{-- We are overriding the default gray background with our new primary color --}}
    <div class="bg-primary text-white">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-8">

           <!-- Hero Slider Section -->
@if($featuredVideos->isNotEmpty())
<div class="mb-12 rounded-lg overflow-hidden relative">
    <!-- Swiper container -->
    <div class="swiper">   <!-- h-[50vh] -->
        <div class="swiper-wrapper">
            <!-- Loop through each featured video to create a slide -->
            @foreach($featuredVideos as $featuredVideo)
            <div class="swiper-slide relative">
                <img src="{{ $featuredVideo->thumbnail_url }}" alt="{{ $featuredVideo->title }}" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
                <div class="absolute bottom-0 left-0 p-4 md:p-8">
                    <h1 class="text-2xl md:text-4xl font-bold mb-2 leading-tight">{{ $featuredVideo->title }}</h1>
                    <div class="flex items-center space-x-4 mt-4">
                        <a href="{{ route('videos.show', $featuredVideo) }}" class="bg-accent hover:bg-orange-600 text-white font-bold py-2 px-6 rounded-full transition text-sm md:text-base">
                            Play
                        </a>
                        {{-- Watchlist button logic remains the same --}}
                        @auth
                        <form method="POST" action="{{ route('videos.watchlist.toggle', $featuredVideo) }}">
                            @csrf
                            <button type="submit" class="text-white font-semibold text-sm md:text-base bg-black/30 hover:bg-black/50 py-2 px-4 rounded-full transition">
                                @if(Auth::user()->watchlist()->where('video_id', $featuredVideo->id)->exists())
                                    ✓ Added to Watchlist
                                @else
                                    + Add to Watchlist
                                @endif
                            </button>
                        </form>
                        @endauth
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>
    </div>
</div>
@endif

<!-- Include Swiper initialization script -->
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const swiper = new Swiper('.swiper', {
            // Optional parameters
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            // If we need pagination
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
        });
    });
</script>
@endpush

<!-- Add custom styles for Swiper pagination -->
@push('styles')
<style>
    .swiper-pagination-bullet {
        background: rgba(255, 255, 255, 0.5);
        width: 10px;
        height: 10px;
    }
    .swiper-pagination-bullet-active {
        background: #FB8C00; /* Your accent color */
    }
</style>
@endpush


            <!-- Horizontal Scrolling Rows with Like Buttons -->
            @foreach ($categories as $category)
                <div class="mb-8">
                    <a href="{{ route('categories.show', $category) }}" class="inline-block">
                        <h2 class="text-2xl font-bold text-white mb-4 hover:text-accent transition-colors">{{ $category->name }}</h2>
                    </a>

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

                                               <div x-ref="container" class="flex space-x-4 overflow-x-auto pb-4 scrollbar-hide">
                            @foreach ($category->videos as $video)
                                <div class="flex-shrink-0 w-64">
                                    <a href="{{ route('videos.show', $video) }}" class="block bg-secondary rounded-lg overflow-hidden transform hover:scale-105 transition-transform duration-200">
                                        <img src="{{ $video->thumbnail_url }}" alt="{{ $video->title }}" class="w-full h-36 object-cover">
                                        
                                        <!-- UPDATED SECTION WITH LIKE BUTTON -->
                                        <div class="p-3 flex justify-between items-center">
                                            <h3 class="font-semibold truncate pr-2">{{ $video->title }}</h3>
                                            
                                            @auth
                                                <form method="POST" action="{{ route('videos.like', $video) }}">
                                                    @csrf
                                                    <button type="submit">
                                                        @if(Auth::user()->likes()->where('video_id', $video->id)->exists())
                                                            <!-- Filled Heart (Liked) -->
                                                            <svg class="w-6 h-6 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path></svg>
                                                        @else
                                                            <!-- Outline Heart (Not Liked) -->
                                                            <svg class="w-6 h-6 text-gray-400 hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.5l1.318-1.182a4.5 4.5 0 116.364 6.364L12 21.5l-7.682-7.682a4.5 4.5 0 010-6.364z"></path></svg>
                                                        @endif
                                                    </button>
                                                </form>
                                            @else
                                                <!-- Disabled Heart for Guests -->
                                                <span class="cursor-pointer" onclick="window.location.href='{{ route('login') }}'">
                                                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.5l1.318-1.182a4.5 4.5 0 116.364 6.364L12 21.5l-7.682-7.682a4.5 4.5 0 010-6.364z"></path></svg>
                                                </span>
                                            @endauth
                                        </div>
                                        <!-- END OF UPDATED SECTION -->

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