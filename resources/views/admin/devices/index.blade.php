<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Device Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="min-w-full bg-white">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="py-3 px-4 text-left">User</th>
                                <th class="py-3 px-4 text-left">Online Status</th>
                                <th class="py-3 px-4 text-left">App Usage</th>
                                <th class="py-3 px-4 text-left">Last Seen</th>
                                <th class="py-3 px-4 text-left">Device Info</th>
                                <th class="py-3 px-4 text-left">IP / Location</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @forelse ($devices as $device)
                                <tr class="border-b">
                                    <td class="py-3 px-4">{{ $device->user->name }}</td>
                                    <td class="py-3 px-4">
                                        @if($device->last_seen_at->diffInMinutes(now()) < 5)
                                            <span class="bg-green-500 text-white py-1 px-2 rounded-full text-xs">Online</span>
                                        @else
                                            <span class="bg-gray-500 text-white py-1 px-2 rounded-full text-xs">Offline</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4">
                                        @if($device->user->app_status == 'webapp')
                                            <span class="bg-blue-500 text-white py-1 px-2 rounded-full text-xs">Web App</span>
                                        @else
                                            <span class="bg-gray-300 text-gray-800 py-1 px-2 rounded-full text-xs">Browser</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4">{{ $device->last_seen_at->diffForHumans() }}</td>
                                    <td class="py-3 px-4 text-sm">
                                        <strong>Battery:</strong> {{ $device->battery_level ?? 'N/A' }} <br>
                                        <strong>Network:</strong> {{ $device->network_type ?? 'N/A' }} <br>
                                        <em class="text-gray-500">{{ Str::limit($device->user_agent, 40) }}</em>
                                    </td>
                                    <td class="py-3 px-4">{{ $device->ip_address }} <br> <span class="text-gray-500">{{ $device->location }}</span></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-8 text-gray-500">No device data has been recorded yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $devices->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>