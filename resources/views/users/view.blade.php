@extends('layouts.app')

@section('content')

<h2>Users</h2>

<table class="table">
<tr>
    <th>Name</th>
    <th>Email</th>
</tr>

@foreach($users as $user)
<tr>
    <td>{{ $user->name }}</td>
    <td>{{ $user->email }}</td>
</tr>
@endforeach

</table>

@endsection