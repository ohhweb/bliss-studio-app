<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Video Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- THE FIX IS IN THIS LINE -->
                    <div class="mb-4">
                        <a href="{{ route('admin.videos.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Add New Video
                        </a>
                    </div>
                    <!-- END OF FIX -->

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <table class="min-w-full bg-white">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="w-1/4 text-left py-3 px-4 uppercase font-semibold text-sm">Thumbnail</th>
                                <th class="w-1/2 text-left py-3 px-4 uppercase font-semibold text-sm">Title</th>
                                <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @forelse ($videos as $video)
                                <tr class="border-b">
                                    <td class="py-3 px-4">
                                        <img src="{{ $video->thumbnail_url }}" alt="{{ $video->title }}" class="h-16 w-32 object-cover rounded">
                                    </td>
                                    <td class="py-3 px-4">{{ $video->title }}</td>
                                    <td class="py-3 px-4">
                                        <!-- THESE LINKS ALSO NEED TO BE FIXED -->
                                        <a href="{{ route('admin.videos.edit', $video) }}" class="text-blue-500 hover:text-blue-800">Edit</a>
                                        <form method="POST" action="{{ route('admin.videos.destroy', $video) }}" class="inline-block ml-4" onsubmit="return confirm('Are you sure?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-800">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="py-3 px-4 text-center">No videos found. Add one!</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $videos->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>