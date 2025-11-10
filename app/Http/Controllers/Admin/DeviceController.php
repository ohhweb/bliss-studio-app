<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Device;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function index()
    {
        // Get all devices, with their user relationship, ordered by last seen
        $devices = Device::with('user')->latest('last_seen_at')->paginate(20);

        return view('admin.devices.index', compact('devices'));
    }
}