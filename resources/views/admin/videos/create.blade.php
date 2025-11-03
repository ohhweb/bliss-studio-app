<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Video') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <!-- Display validation errors -->
                    @if ($errors->any())
                        <div class="mb-4">
                            <div class="font-medium text-red-600">{{ __('Whoops! Something went wrong.') }}</div>
                            <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('videos.store') }}">
                        @csrf

                        <!-- Title -->
                        <div class="mb-4">
                            <label for="title" class="block font-medium text-sm text-gray-700">Title</label>
                            <input type="text" name="title" id="title" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('title') }}" required autofocus>
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label for="description" class="block font-medium text-sm text-gray-700">Description</label>
                            <textarea name="description" id="description" rows="4" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('description') }}</textarea>
                        </div>

                        <!-- Thumbnail URL -->
                        <div class="mb-4">
                            <label for="thumbnail_url" class="block font-medium text-sm text-gray-700">Thumbnail URL</label>
                            <input type="url" name="thumbnail_url" id="thumbnail_url" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('thumbnail_url') }}" required>
                        </div>

                        <!-- Category Dropdown -->
                        <div class="mb-4">
                            <label for="category_id" class="block font-medium text-sm text-gray-700">Category</label>
                            <select name="category_id" id="category_id" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                <option value="">-- Select a Category --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Video Platform -->
                        <div class="mb-4">
                            <label for="video_type" class="block font-medium text-sm text-gray-700">Video Platform</label>
                            <select name="video_type" id="video_type" class="block mt-1 w-full rounded-md shadow-sm border-gray-300">
                                <option value="youtube" {{ old('video_type') == 'youtube' ? 'selected' : '' }}>YouTube</option>
                                <option value="vimeo" {{ old('video_type') == 'vimeo' ? 'selected' : '' }}>Vimeo</option>
                                <option value="direct" {{ old('video_type') == 'direct' ? 'selected' : '' }}>Direct URL (.mp4, etc)</option>
                            </select>
                        </div>

                        <!-- Video URL / ID -->
                        <div class="mb-4">
                            <label for="video_url" class="block font-medium text-sm text-gray-700">Video URL or ID</label>
                            <input type="text" name="video_url" id="video_url" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" value="{{ old('video_url') }}" required>
                            <p class="text-sm text-gray-500 mt-1">For YouTube/Vimeo, paste just the video ID. For Direct URL, paste the full URL.</p>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-end mt-4">
                             <a href="{{ route('videos.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Cancel</a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Save Video
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>