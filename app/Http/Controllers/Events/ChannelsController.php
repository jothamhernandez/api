<?php

namespace App\Http\Controllers\Events;

use App\Channel;
use App\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChannelsController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function create(Event $event)
    {
        return view('channels.create', ['event' => $event, 'showEventSidebar' => true]);
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
        ]);

        $channel = new Channel($request->all());
        $channel->event_id = $event->id;
        $channel->save();

        return redirect(url('/events/'.$event->slug))->with('success', 'Channel successfully created');
    }
}
