<?php

namespace App\Http\Controllers\Events;

use App\Room;
use App\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoomsController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function create(Event $event)
    {
        return view('rooms.create', ['event' => $event, 'showEventSidebar' => true]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Event $event)
    {
        $request->validate([
            'name' => 'required',
            'capacity' => 'required|integer',
            'channel_id' => 'required|exists:channels,id',
        ]);

        $room = new Room($request->all());
        $room->save();

        return redirect(url('/events/'.$event->slug))->with('success', 'Room successfully created');
    }
}
