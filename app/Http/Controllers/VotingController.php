<?php

namespace App\Http\Controllers;

use App\Models\VotingEvent;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VotingController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $groupIds = $user->groups()->pluck('groups.id')->toArray();

        // Get currently active events that are public OR belong to one of user's groups
        $events = VotingEvent::active()
            ->where(function ($query) use ($groupIds) {
                $query->whereNull('group_id')
                      ->orWhereIn('group_id', $groupIds);
            })
            ->get();

        return view('voting.index', compact('events'));
    }

    public function show($id)
    {
        $event = VotingEvent::with('options')->findOrFail($id);
        $user = Auth::user();

        // Check if event is active & accessible
        if (!$event->is_active || $event->start_time > now() || $event->end_time < now()) {
            abort(403, 'This voting event is not currently active.');
        }

        if ($event->group_id && !$user->groups()->where('groups.id', $event->group_id)->exists()) {
            abort(403, 'You do not have access to this voting event.');
        }

        // Check if already voted
        $hasVoted = Vote::where('user_id', $user->id)
            ->where('voting_event_id', $event->id)
            ->exists();

        if ($hasVoted) {
            return redirect()->route('voting.results', $event->id)->with('message', 'You have already voted in this event.');
        }

        return view('voting.show', compact('event'));
    }

    public function vote(Request $request, $id)
    {
        $request->validate([
            'option_id' => 'required|exists:options,id',
        ]);

        $event = VotingEvent::findOrFail($id);
        $user = Auth::user();

        // Access checks
        if (!$event->is_active || $event->start_time > now() || $event->end_time < now()) {
            abort(403, 'This voting event is not currently active.');
        }

        if ($event->group_id && !$user->groups()->where('groups.id', $event->group_id)->exists()) {
            abort(403, 'You do not have access to this voting event.');
        }

        // One-time check
        $hasVoted = Vote::where('user_id', $user->id)
            ->where('voting_event_id', $event->id)
            ->exists();

        if ($hasVoted) {
            return redirect()->route('voting.results', $event->id)->with('error', 'You have already voted in this event.');
        }

        // Must belong to this event
        if (!$event->options()->where('id', $request->option_id)->exists()) {
            abort(400, 'Invalid option selected.');
        }

        Vote::create([
            'user_id' => $user->id,
            'voting_event_id' => $event->id,
            'option_id' => $request->option_id,
        ]);

        // If the event allows showing results, redirect there, else back to index
        if ($event->show_results) {
            return redirect()->route('voting.results', $event->id)->with('success', 'Your vote has been cast successfully!');
        }

        return redirect()->route('home')->with('success', 'Your vote has been cast successfully! Results are kept private for this event.');
    }

    public function results($id)
    {
        $event = VotingEvent::with('options')->findOrFail($id);
        
        $user = Auth::user();
        if ($event->group_id && !$user->groups()->where('groups.id', $event->group_id)->exists()) {
            abort(403, 'You do not have access to this voting event.');
        }

        if (!$event->show_results) {
            return view('voting.already-voted', compact('event'));
        }

        $results = $event->options()->withCount('votes')->get();

        return view('voting.results', compact('event', 'results'));
    }
}
