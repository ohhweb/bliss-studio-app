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

                    <!-- ALL YOUR ORIGINAL CONTENT GOES HERE -->
                    <!-- For example: The "Add New Video" link, the success message, and the table -->

                    <a href="{{ route('videos.create') }}">Add New Video</a>
                    <hr>
                    @if (session('success'))
                        <div>{{ session('success') }}</div>
                    @endif
                    <table>
                        <!-- ... your table code ... -->
                    </table>
                    {{ $videos->links() }}

                </div>
            </div>
        </div>
    </div>
</x-app-layout>