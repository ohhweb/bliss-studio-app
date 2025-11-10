<x-app-layout>
    <div class="py-12 bg-primary text-white">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold text-red-500 mb-4">Access Denied</h2>
            <div class="bg-secondary rounded-lg p-8">
                <p class="text-lg">Your account has been blocked by an administrator.</p>
                @if(Auth::user()->block_note)
                <p class="text-gray-400 mt-2">Reason: {{ Auth::user()->block_note }}</p>
                @endif

                @if(Auth::user()->status != 'unblock_request')
                <form action="{{ route('unblock.request') }}" method="POST" class="mt-6">
                    @csrf
                    <button type="submit" class="bg-accent hover:bg-orange-600 text-white font-bold py-3 px-4 rounded-lg">
                        Request to Unblock
                    </button>
                </form>
                @else
                <p class="mt-6 text-green-400">Your unblock request has been sent and is pending review.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>