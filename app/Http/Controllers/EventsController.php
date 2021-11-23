<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Auth::user()->events;
        return view('events.index', ['events' => $events]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('events.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'slug' => ['required', Rule::unique('events')->where(function ($query) {
                return $query->where('organizer_id', Auth::user()->id);
            }), 'regex:/^[a-z0-9-]*$/'],
            'date' => 'required|date',
        ], [
            'regex' => 'Slug must not be empty and only contain a-z, 0-9 and \'-\'',
        ]);

        $event = new Event($request->all());
        $event->organizer_id = Auth::user()->id;
        $event->save();

        return redirect(url('/events/'.$event->slug))->with('success', 'Event successfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        return view('events.detail', ['event' => $event, 'showEventSidebar' => true]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        return view('events.edit', ['event' => $event, 'showEventSidebar' => true]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        $request->validate([
            'name' => 'required',
            'slug' => ['required', Rule::unique('events')->where(function ($query) use ($event) {
                return $query->where('organizer_id', Auth::user()->id)->where('id', '!=', $event->id);
            })],
            'date' => 'required|date',
        ]);

        $event->fill($request->all());
        $event->save();

        return redirect(url('/events/'.$event->slug))->with('success', 'Event successfully updated');
    }
}
