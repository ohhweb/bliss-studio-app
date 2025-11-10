<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stevebauman\Location\Facades\Location;

class ActivityController extends Controller
{
    /**
     * Receives a heartbeat from a user's device and updates their status.
     */
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
        // For local testing, spoof a public IP. On a real server, this is not strictly necessary
        // but it's good practice to handle private IP ranges.
        $ipForLocation = in_array($ip, ['127.0.0.1', '::1']) ? '8.8.8.8' : $ip;
        
        $userAgent = $request->userAgent();
        // The 'false' parameter tells the Location package not to throw an exception on failure
        $locationInfo = Location::get($ipForLocation);

        $user->devices()->updateOrCreate(
            // Find a device with this unique identifier
            ['device_identifier' => $data['device_identifier']],
            // Update or create it with this data
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