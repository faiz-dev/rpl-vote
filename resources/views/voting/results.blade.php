@extends('layouts.app')

@section('content')
<div class="mb-6 flex justify-between items-end">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">{{ $event->title }} - Results</h1>
        <p class="mt-2 text-sm text-gray-600">Current voting results for this event.</p>
    </div>
    <a href="{{ route('home') }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">&larr; Back to List</a>
</div>

<div class="bg-white shadow overflow-hidden sm:rounded-lg p-6">
    @php
        $totalVotes = $results->sum('votes_count');
        $winner = $results->sortByDesc('votes_count')->first();
    @endphp

    <div class="mb-6">
        <p class="text-lg text-gray-700">Total Votes Cast: <strong>{{ $totalVotes }}</strong></p>
    </div>

    <div class="space-y-6">
        @foreach($results->sortByDesc('votes_count') as $option)
            @php
                $percentage = $totalVotes > 0 ? round(($option->votes_count / $totalVotes) * 100, 1) : 0;
                $isWinner = $winner && $option->id === $winner->id && $option->votes_count > 0;
            @endphp
            <div>
                <div class="flex justify-between items-end mb-1">
                    <span class="text-base font-medium text-gray-700 flex items-center">
                        @if($option->photo)
                            <img class="h-8 w-8 rounded-full object-cover mr-2" src="{{ Str::startsWith($option->photo, ['http://', 'https://']) ? $option->photo : Storage::url($option->photo) }}" alt="" />
                        @endif
                        {{ $option->candidate_name }}
                        @if($isWinner)
                            <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                Leading
                            </span>
                        @endif
                    </span>
                    <span class="text-sm font-medium text-gray-500">{{ $option->votes_count }} votes ({{ $percentage }}%)</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-4">
                    <div class="bg-indigo-600 h-4 rounded-full" style="width: {{ $percentage }}%"></div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
