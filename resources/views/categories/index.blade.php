<x-app-layout>
    <div class="bg-primary text-white min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-8">
            <h2 class="text-3xl font-bold text-white mb-6 border-l-4 border-accent pl-4">
                All Categories
            </h2>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach ($categories as $category)
                    <a href="{{ route('categories.show', $category) }}" class="block bg-secondary rounded-lg p-6 text-center transform hover:scale-105 transition-transform duration-200">
                        <h3 class="text-xl font-bold">{{ $category->name }}</h3>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>