<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventAttendeesController extends Controller
{
    public function index(Event $event)
    {
        $attendees = $event->attendees()->paginate(20);
        return view('events.attendees', compact('event', 'attendees'));
    }
}
