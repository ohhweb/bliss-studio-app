<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stevebauman\Location\Facades\Location;

class ActivityController extends Controller
{
    public function heartbeat(Request $request)
    {
        $user = $request->user();

        // Validate the incoming data from the browser
        $data = $request->validate([
            'device_identifier' => 'required|string|max:255',
            'battery_level' => 'nullable|string',
            'network_type' => 'nullable|string',
        ]);

        // Get server-side data
        $ip = $request->ip();
        $userAgent = $request->userAgent();
        $locationInfo = Location::get($ip); // Use the package to get location

        // Use updateOrCreate to either find the existing device or create a new one
        $user->devices()->updateOrCreate(
            ['device_identifier' => $data['device_identifier']],
            [
                'user_agent' => $userAgent,
                'ip_address' => $ip,
                'location' => $locationInfo ? "{$locationInfo->cityName}, {$locationInfo->countryName}" : 'Unknown',
                'battery_level' => $data['battery_level'],
                'network_type' => $data['network_type'],
                'last_seen_at' => now(),
            ]
        );

        return response()->json(['status' => 'success']);
    }
}