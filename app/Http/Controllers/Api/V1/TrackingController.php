<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\TrackingPoint;
use App\Models\TrackingSession;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TrackingController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();

        Log::info("user " . json_encode($user));
        Log::info("Location " . json_encode($request->locations));
        Log::info("Time " . Carbon::parse($request->timestamp)->format('Y-m-d H:i:s'));
        Log::info("request " . json_encode($request->input()));

        $tracking_session = TrackingSession::where('user_id', Auth::user()->id)->first();
        if ($tracking_session) {
            return response()->json(['message' => 'Data sudah ada']);
        } else {
            return response()->json(['message' => 'Data tidak ada']);
        }

        // foreach ($locations as $loc) {
        //     // Simpan ke DB atau log
        //     Log::info("[$deviceId] Lat: {$loc['latitude']}, Lng: {$loc['longitude']}, Time: {$loc['timestamp']}");

        //     // Contoh simpan ke DB jika ada model LocationTracking
        //     TrackingPoint::create([
        //       'device_id' => $deviceId,
        //       'latitude' => $loc['latitude'],
        //       'longitude' => $loc['longitude'],
        //       'timestamp' => $loc['timestamp'],
        //     ]);
        // }

    }
}
