<?php

namespace App\Http\Controllers\Events;

use App\Room;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Event;

class CapacityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Event $event)
    {
        return view('capacity.index', ['event' => $event, 'showEventSidebar' => true]);
    }
}
