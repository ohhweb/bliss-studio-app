<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stevebauman\Location\Facades\Location;
use Illuminate\Support\Facades\Log; // Optional: for debugging

class ActivityController extends Controller
{
    /**
     * Receives a heartbeat from a user's device, updates their status,
     * and increments their time spent on the platform.
     */
    public function heartbeat(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Unauthenticated'], 401);
        }

        $data = $request->validate([
            'device_identifier' => 'required|string|max:255',
            'app_status' => 'required|in:webapp,browser',
            'time_spent' => 'required|integer|min:0',
            'battery_level' => 'nullable|string|max:255',
            'network_type' => 'nullable|string|max:255',
        ]);

        $ip = $request->ip();
        $ipForLocation = in_array($ip, ['127.0.0.1', '::1']) ? '8.8.8.8' : $ip;
        $userAgent = $request->userAgent();
        $locationInfo = Location::get($ipForLocation);

        // Update the device record
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

        // Update the user's main status record
        $user->app_status = $data['app_status'];
        
        // Use a safe increment operation to add the time spent
        if ($data['time_spent'] > 0) {
            $user->increment('time_spent', $data['time_spent']);
        }
        
        // We only need to save if we changed the app_status,
        // as increment() saves automatically.
        if ($user->isDirty('app_status')) {
            $user->save();
        }

        return response()->json(['status' => 'success']);
    }
}