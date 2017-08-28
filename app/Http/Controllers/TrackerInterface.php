<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\TrackerActivity;
use App\TrackerUsers;
use App\TrackerIp;
use App\TrackerEventType;
use Input;

class TrackerInterface extends Controller
{

    public function event()
    {
        $this->logEvent(Input::All());

        // We always simply respond true just for the sake of security.
        return response()->json([
            'success' => 'true'
        ]);
    }

    protected function logEvent($event)
    {
        $guid = crc32($event['guid']);
        $eventName = $event['action'];
        $path = $event['path'];
        $timestamp = intval($event['timestamp']);
        $ipAddress = request()->ip();

        // First get the event id.
        $event = TrackerEventType::where('name', $eventName)
        ->limit(1)
        ->first();

        if(!$event)
            return false;

        // Insert GUI if it doesn't already exsist.
        $trackerUsers = TrackerUsers::firstOrNew(['id' => $guid]);
        $trackerUsers->id = $guid;
        $trackerUsers->save();

        // Drop ip address into our ip table.
        $trackerIp = TrackerIp::firstOrNew(['ip' => $ipAddress]);
        $trackerIp->ip = $ipAddress;
        $trackerIp->save();
        $ip_id = $trackerIp->id;

        // Now log activity
        $activity = new TrackerActivity();
        $activity->user_id = $guid;
        $activity->posted = $timestamp;
        $activity->path = $path;
        $activity->ip_id = $ip_id;
        $activity->event_id = $event->id;
        $activity->save();

        return true;
    }
}
