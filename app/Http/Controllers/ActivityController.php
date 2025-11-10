<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stevebauman\Location\Facades\Location;

class ActivityController extends Controller
{
    public function heartbeat(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Unauthenticated'], 401);
        }

        $data = $request->validate([
            'device_identifier' => 'required|string|max:255',
            'battery_level' => 'nullable|string|max:255',
            'network_type' => 'nullable|string|max:255',
        ]);

        $ip = $request->ip();
        // For local testing, spoof a public IP address
        // On a real server, you can remove this line.
        $ipForLocation = ($ip === '127.0.0.1' || $ip === '::1') ? '8.8.8.8' : $ip;
        
        $userAgent = $request->userAgent();
        $locationInfo = Location::get($ipForLocation);

        $user->devices()->updateOrCreate(
            ['device_identifier' => $data['device_identifier']],
            [
                'user_agent' => $userAgent,
                'ip_address' => $ip,
                'location' => $locationInfo ? "{$locationInfo->cityName}, {$locationInfo->countryName}" : 'Local Network',
                'battery_level' => $data['battery_level'],
                'network_type' => $data['network_type'],
                'last_seen_at' => now(),
            ]
        );

        return response()->json(['status' => 'success']);
    }
}