<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <!-- Display Success/Error Messages -->
                @if (session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                        <p>{{ session('success') }}</p>
                    </div>
                @endif
                @if (session('error'))
                     <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                        <p>{{ session('error') }}</p>
                    </div>
                @endif

                <!-- Wrapper for Desktop View: Hidden on mobile, block on sm screens and up -->
                <div class="hidden sm:block">
                    <table class="min-w-full bg-white">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Plan</th>
                                <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time Spent</th>
                                <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($users as $user)
                                <tr class="border-b">
                                    <td class="py-4 px-4 whitespace-nowrap">
                                        <div class="font-medium text-gray-900">{{ $user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                    </td>
                                    <td class="py-4 px-4 whitespace-nowrap text-sm text-gray-500">{{ ucfirst($user->plan ?? 'N/A') }}</td>
                                    <td class="py-4 px-4 whitespace-nowrap text-sm text-gray-500">{{ number_format($user->time_spent / 60) }} mins</td>
                                    <td class="py-4 px-4 whitespace-nowrap">
                                        @if($user->status == 'active') <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Active</span>
                                        @elseif($user->status == 'blocked') <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Blocked</span>
                                        @elseif($user->status == 'unblock_request') <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Unblock Request</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-4 whitespace-nowrap text-sm">
                                        @if($user->is_admin)
                                            <span class="text-gray-500 italic">Admin</span>
                                        @elseif($user->status == 'blocked' || $user->status == 'unblock_request')
                                            <form action="{{ route('admin.users.unblock', $user) }}" method="POST">
                                                @csrf @method('PATCH')
                                                <button type="submit" class="text-green-600 hover:underline">Unblock</button>
                                                @if($user->block_note)<p class="text-xs text-gray-400 mt-1">Note: {{ $user->block_note }}</p>@endif
                                            </form>
                                        @else
                                            <form action="{{ route('admin.users.block', $user) }}" method="POST" class="flex items-center space-x-2">
                                                @csrf @method('PATCH')
                                                <input type="text" name="block_note" placeholder="Reason..." required class="text-xs border-gray-300 rounded-md w-32 focus:ring-indigo-500 focus:border-indigo-500">
                                                <button type="submit" class="text-red-600 hover:underline">Block</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center py-8 text-gray-500">No users found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Wrapper for Mobile View: Block by default, hidden on sm screens and up -->
                <div class="block sm:hidden">
                    <div class="space-y-4">
                        @forelse ($users as $user)
                            <div class="bg-white p-4 rounded-lg shadow border">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <div class="font-bold text-lg text-gray-900">{{ $user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                    </div>
                                    <div>
                                        @if($user->status == 'active') <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Active</span>
                                        @elseif($user->status == 'blocked') <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Blocked</span>
                                        @elseif($user->status == 'unblock_request') <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Unblock Request</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="text-sm text-gray-600 mb-4 border-t pt-2 mt-2">
                                    <strong>Plan:</strong> {{ ucfirst($user->plan ?? 'N/A') }} &bull; 
                                    <strong>Time:</strong> {{ number_format($user->time_spent / 60) }} mins
                                </div>
                                <div>
                                    @if($user->is_admin)
                                        <span class="text-gray-500 italic">Admin user - cannot be blocked.</span>
                                    @elseif($user->status == 'blocked' || $user->status == 'unblock_request')
                                        <form action="{{ route('admin.users.unblock', $user) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="text-green-600 hover:underline font-bold">Unblock User</button>
                                            @if($user->block_note)<p class="text-xs text-gray-500 mt-1">Note: {{ $user->block_note }}</p>@endif
                                        </form>
                                    @else
                                        <form action="{{ route('admin.users.block', $user) }}" method="POST" class="flex items-center space-x-2">
                                            @csrf @method('PATCH')
                                            <input type="text" name="block_note" placeholder="Reason for blocking..." required class="text-xs border-gray-300 rounded-md flex-grow focus:ring-indigo-500 focus:border-indigo-500">
                                            <button type="submit" class="bg-red-500 text-white text-xs font-bold py-1 px-3 rounded">Block</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="text-center py-8 text-gray-500">No users found.</p>
                        @endforelse
                    </div>
                </div>

                <div class="mt-4">{{ $users->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>