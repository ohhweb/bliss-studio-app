<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="py-3 px-4 text-left">User</th>
                            <th class="py-3 px-4 text-left">Plan</th>
                            <th class="py-3 px-4 text-left">Time Spent</th>
                            <th class="py-3 px-4 text-left">Status</th>
                            <th class="py-3 px-4 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr class="border-b">
                            <td class="py-3 px-4">{{ $user->name }}<br><span class="text-sm text-gray-500">{{ $user->email }}</span></td>
                            <td class="py-3 px-4">{{ ucfirst($user->plan ?? 'N/A') }}</td>
                            <td class="py-3 px-4">{{ number_format($user->time_spent / 60) }} mins</td>
                            <td class="py-3 px-4">
                                @if($user->status == 'active') <span class="bg-green-500 text-white text-xs py-1 px-2 rounded-full">Active</span>
                                @elseif($user->status == 'blocked') <span class="bg-red-500 text-white text-xs py-1 px-2 rounded-full">Blocked</span>
                                @elseif($user->status == 'unblock_request') <span class="bg-yellow-500 text-white text-xs py-1 px-2 rounded-full">Unblock Request</span>
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                @if($user->status == 'blocked' || $user->status == 'unblock_request')
                                <form action="{{ route('admin.users.unblock', $user) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="text-green-600 hover:underline">Unblock</button>
                                    @if($user->block_note)<p class="text-xs text-gray-500 mt-1">Note: {{ $user->block_note }}</p>@endif
                                </form>
                                @else
                                <form action="{{ route('admin.users.block', $user) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <input type="text" name="block_note" placeholder="Reason for blocking..." required class="text-xs border-gray-300 rounded-md">
                                    <button type="submit" class="text-red-600 hover:underline ml-2">Block</button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                 <div class="mt-4">{{ $users->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout> 