<?php

namespace App\Http\Controllers\Api\Organizers;

use App\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Organizer;

class EventsController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show($organizerSlug, $eventSlug)
    {
        $organizer = Organizer::where('slug', $organizerSlug)->first();
        if (!$organizer) {
            return response()->json(['message' => 'Organizer not found'], 404);
        }

        $event = Event::where('slug', $eventSlug)->with(['channels', 'channels.rooms', 'channels.rooms.sessions', 'tickets'])->first();
        if (!$event || $event->organizer_id !== $organizer->id) {
            return response()->json(['message' => 'Event not found'], 404);
        }

        return $event;
    }
}
