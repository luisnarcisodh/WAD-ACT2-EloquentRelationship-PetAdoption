@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-6">User Management (Admins Only)</h1>

<div class="bg-white rounded shadow overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead class="bg-gray-200">
            <tr>
                <th class="p-4 border-b">ID</th>
                <th class="p-4 border-b">Name</th>
                <th class="p-4 border-b">Email</th>
                <th class="p-4 border-b">Role</th>
                <th class="p-4 border-b">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td class="p-4 border-b">{{ $user->id }}</td>
                <td class="p-4 border-b">{{ $user->name }}</td>
                <td class="p-4 border-b">{{ $user->email }}</td>
                <td class="p-4 border-b">{{ ucfirst($user->role) }}</td>
                <td class="p-4 border-b flex space-x-2">
                    <a href="{{ route('users.show', $user) }}" class="text-blue-500 underline">View</a>
                    <a href="{{ route('users.edit', $user) }}" class="text-green-500 underline">Edit</a>
                    @if($user->id !== auth()->id())
                    <form action="{{ route('users.destroy', $user) }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-500 underline">Delete</button>
                    </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection