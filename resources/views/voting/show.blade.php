@extends('layouts.app')

@section('content')
<div class="mb-6 flex justify-between items-end">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">{{ $event->title }}</h1>
        <p class="mt-2 text-sm text-gray-600">{{ $event->description }}</p>
    </div>
    <a href="{{ route('home') }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">&larr; Back to List</a>
</div>

<div class="bg-white shadow overflow-hidden sm:rounded-lg mb-8">
    <div class="px-4 py-5 sm:px-6 bg-gray-50">
        <h3 class="text-lg leading-6 font-medium text-gray-900">Select a Candidate</h3>
        <p class="mt-1 max-w-2xl text-sm text-gray-500">You can only vote once. Your choice is final.</p>
    </div>
    <div class="border-t border-gray-200 p-6">
        <form action="{{ route('voting.vote', $event->id) }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 mb-8">
                @foreach($event->options as $option)
                    <label for="option-{{ $option->id }}" class="relative rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-indigo-400 hover:bg-gray-50 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500 cursor-pointer transition-colors duration-150">
                        <div class="flex-shrink-0 w-16 h-16">
                            @if($option->photo)
                                <img class="h-16 w-16 rounded-full object-cover" src="{{ Str::startsWith($option->photo, ['http://', 'https://']) ? $option->photo : Storage::url($option->photo) }}" alt="" />
                            @else
                                <div class="h-16 w-16 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">No Pic</div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center">
                                <input id="option-{{ $option->id }}" name="option_id" value="{{ $option->id }}" type="radio" required class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500 mr-3 z-10">
                                <span class="text-sm font-medium text-gray-900">
                                    {{ $option->candidate_name }}
                                </span>
                            </div>
                            @if($option->description)
                                <p class="text-sm text-gray-500 truncate mt-1">{{ $option->description }}</p>
                            @endif
                        </div>
                    </label>
                @endforeach
            </div>

            <div class="flex justify-end border-t pt-5">
                <button type="submit" onclick="return confirm('Are you sure you want to cast this vote? This action cannot be undone.')" class="inline-flex justify-center py-2 px-10 border border-transparent shadow-sm text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Cast Vote
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
