<?php

namespace App\Http\Controllers\Events;

use App\Session;
use App\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SessionsController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function create(Event $event)
    {
        return view('sessions.create', ['event' => $event, 'showEventSidebar' => true]);
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
            'title' => 'required',
            'description' => 'required',
            'speaker' => 'required',
            'start' => 'required|date',
            'end' => 'required|date',
            'type' => 'required|in:talk,workshop',
            'cost' => 'nullable|numeric',
            'room' => 'required|exists:rooms,id',
        ]);

        $booked = Session::where('room_id', $request->get('room'))->where(function ($query) use ($request) {
            return $query->where(function ($query) use ($request) {
                return $query->where('start', '>', $request->get('start'))->where('start', '<', $request->get('end'))
                    ->orWhere(function ($query) use ($request) {
                        return $query->where('end', '>', $request->get('start'))->where('end', '<', $request->get('end'));
                    })->orWhere(function ($query) use ($request) {
                        return $query->where('start', '<=', $request->get('start'))->where('end', '>=', $request->get('end'));
                    });
            });
        })->first();

        if ($booked) {
            return redirect()->back()->withInput()->withErrors(['room' => ['Room already booked during this time']]);
        }

        $session = new Session($request->all());
        $session->room_id = $request->get('room');
        $session->save();

        return redirect(url('/events/'.$event->slug))->with('success', 'Session successfully created');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Event  $event
     * @param  \App\Session  $session
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event, Session $session)
    {
        return view('sessions.edit', ['event' => $event, 'session' => $session, 'showEventSidebar' => true]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Event  $event
     * @param  \App\Session  $session
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event, Session $session)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'speaker' => 'required',
            'start' => 'required|date',
            'end' => 'required|date',
            'type' => 'required|in:talk,workshop',
            'cost' => 'nullable|numeric',
            'room' => 'required|exists:rooms,id',
        ]);

        $booked = Session::where('room_id', $request->get('room'))->where(function ($query) use ($request) {
            return $query->where(function ($query) use ($request) {
                return $query->where('start', '>', $request->get('start'))->where('start', '<', $request->get('end'))
                    ->orWhere(function ($query) use ($request) {
                        return $query->where('end', '>', $request->get('start'))->where('end', '<', $request->get('end'));
                    })->orWhere(function ($query) use ($request) {
                        return $query->where('start', '<=', $request->get('start'))->where('end', '>=', $request->get('end'));
                    });
            });
        })->first();

        if ($booked && $booked->id !== $session->id) {
            return redirect()->back()->withInput()->withErrors(['room' => ['Room already booked during this time']]);
        }

        $session->fill($request->all());
        $session->room_id = $request->get('room');
        $session->save();

        return redirect(url('/events/'.$event->slug))->with('success', 'Session successfully updated');
    }
}
