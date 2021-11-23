<?php

namespace App\Http\Controllers\Events;

use App\EventTicket;
use App\Event;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TicketsController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function create(Event $event)
    {
        return view('tickets.create', ['event' => $event, 'showEventSidebar' => true]);
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
        $request->validate(array_merge([
            'name' => 'required',
            'cost' => 'required|numeric',
        ], $request->get('special_validity') === 'amount' ? ['amount' => 'required|integer'] : [],
            $request->get('special_validity') === 'valid_until' ? ['valid_until' => 'required|date'] : []
        ));

        $ticket = new EventTicket($request->all());

        if ($request->get('special_validity') === 'amount') {
            $ticket->special_validity = json_encode(['type' => 'amount', 'amount' => $request->get('amount')]);
        } else if ($request->get('special_validity') === 'date') {
            $ticket->special_validity = json_encode(['type' => 'date', 'date' => $request->get('valid_until')]);
        }

        $ticket->event_id = $event->id;
        $ticket->save();

        return redirect(url('/events/'.$event->slug))->with('success', 'Ticket successfully created');
    }
}
