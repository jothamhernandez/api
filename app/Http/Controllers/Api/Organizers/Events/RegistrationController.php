<?php

namespace App\Http\Controllers\Api\Organizers\Events;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Attendee;
use App\Registration;
use App\Event;
use App\EventTicket;
use App\SessionRegistration;
use Carbon\Carbon;

class RegistrationController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($organizerSlug, $eventSlug, Request $request)
    {
        $event = Event::where('slug', $eventSlug)->firstOrFail();
        $ticket = EventTicket::where('id', $request->get('ticket_id'))->firstOrFail();
        $sessionIds = $request->get('session_ids') ?? [];
        $token = $request->get('token');
        $attendee = Attendee::where('login_token', $token)->first();

        if (!$token || !$attendee) {
            return response()->json(['message' => 'User not logged in'], 401);
        }

        if (Registration::where('attendee_id', $attendee->id)->whereIn('ticket_id', EventTicket::where('event_id', $event->id)->get()->pluck('id'))->first()) {
            return response()->json(['message' => 'User already registered'], 401);
        } else if (!$ticket->available) {
            return response()->json(['message' => 'Ticket is no longer available'], 401);
        }

        $registration = new Registration(['attendee_id' => $attendee->id, 'ticket_id' => $ticket->id, 'registration_time' => Carbon::now()]);
        $registration->save();

        foreach ($sessionIds as $sessionId) {
            $sessionRegistration = new SessionRegistration(['registration_id' => $registration->id, 'session_id' => $sessionId]);
            $sessionRegistration->save();
        }

        return ['message' => 'Registration successful'];
    }
}
