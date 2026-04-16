@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-3xl font-bold mb-4">{{ $user->name }}'s Profile</h1>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Role:</strong> {{ ucfirst($user->role) }}</p>

    <div class="mt-6">
        <h3 class="font-bold text-xl mb-2">Adoption Requests</h3>
        <ul class="list-disc ml-5">
            @forelse($user->adoptionRequests as $request)
                <li>Requested <strong>{{ $request->pet->name }}</strong> - Status: <span class="text-blue-600">{{ ucfirst($request->status) }}</span></li>
            @empty
                <li>No adoption requests made.</li>
            @endforelse
        </ul>
    </div>

    <div class="mt-6">
        <a href="{{ route('users.edit', $user) }}" class="bg-gray-500 text-white px-4 py-2 rounded">Edit Profile</a>
    </div>
</div>
@endsection