@extends('layouts.app')

@section('content')
<div class="bg-white shadow overflow-hidden sm:rounded-lg">
    <div class="px-4 py-10 sm:px-6 text-center">
        <svg class="mx-auto h-12 w-12 text-green-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <h3 class="text-2xl leading-6 font-medium text-gray-900 mb-2">Vote Recorded</h3>
        <p class="mt-1 max-w-2xl mx-auto text-base text-gray-500">
            Thank you for participating! Your vote for <strong>{{ $event->title }}</strong> has been successfully recorded.
        </p>
        <p class="mt-2 text-sm text-gray-400">
            Note: Results for this particular event are kept private by the administrator.
        </p>
        <div class="mt-8">
            <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Back to Dashboard
            </a>
        </div>
    </div>
</div>
@endsection
