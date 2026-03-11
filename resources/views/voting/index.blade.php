@extends('layouts.app')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900">Active Voting Events</h1>
    <p class="mt-2 text-sm text-gray-600">Events you are eligible to participate in.</p>
</div>

@if($events->isEmpty())
    <div class="bg-white rounded-lg shadow p-6 text-center text-gray-500">
        There are no active voting events available for you right now. 
    </div>
@else
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @foreach($events as $event)
            <div class="bg-white overflow-hidden shadow rounded-lg">
                @if($event->thumbnail)
                    <img class="w-full h-48 object-cover" src="{{ Storage::url($event->thumbnail) }}" alt="{{ $event->title }}">
                @else
                    <div class="w-full h-48 bg-indigo-100 flex items-center justify-center">
                        <span class="text-indigo-400 font-semibold text-lg">No Image</span>
                    </div>
                @endif
                <div class="p-5">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">{{ $event->title }}</h3>
                    <p class="mt-2 max-w-2xl text-sm text-gray-500 line-clamp-2">
                        {{ $event->description }}
                    </p>
                    <div class="mt-4">
                        @php
                            $hasVoted = \App\Models\Vote::where('user_id', auth()->id())->where('voting_event_id', $event->id)->exists();
                        @endphp
                        
                        @if($hasVoted)
                            <a href="{{ route('voting.results', $event->id) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 w-full justify-center">
                                View Results / Already Voted
                            </a>
                        @else
                            <a href="{{ route('voting.show', $event->id) }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 w-full justify-center">
                                Vote Now
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection
