@extends('layouts.app')

@section('title', 'Profile')

@section('content')

<div class="mb-8">
    <h1 class="text-2xl font-bold text-slate-900">Profile</h1>
    <p class="text-slate-500 text-sm mt-1">Manage your account information</p>
</div>

<div class="max-w-3xl space-y-6">

    {{-- Profile info --}}
    <div class="card p-6">
        <h2 class="font-semibold text-slate-900 border-b border-slate-100 pb-3 mb-5">Account Information</h2>

        <div class="flex items-center gap-4 mb-6">
            <div class="w-16 h-16 rounded-2xl bg-brand-100 flex items-center justify-center text-brand-700 text-2xl font-bold">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div>
                <p class="font-bold text-slate-900 text-lg">{{ auth()->user()->name }}</p>
                <p class="text-slate-500 text-sm">{{ auth()->user()->email }}</p>
                <span class="mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ auth()->user()->isAdmin() ? 'bg-violet-100 text-violet-700' : 'bg-slate-100 text-slate-600' }}">
                    {{ ucfirst(auth()->user()->role) }}
                </span>
            </div>
        </div>

        <form method="POST" action="{{ route('profile.update') }}">
            @csrf @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="label">Name</label>
                    <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" class="input" required>
                </div>
                <div>
                    <label class="label">Email</label>
                    <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" class="input" required>
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn-primary">
                    <i class="fa-solid fa-check"></i> Save Changes
                </button>
            </div>
        </form>
    </div>

    {{-- Password --}}
    <div class="card p-6">
        <h2 class="font-semibold text-slate-900 border-b border-slate-100 pb-3 mb-5">Change Password</h2>
        <form method="POST" action="{{ route('profile.password') }}">
            @csrf @method('PUT')
            <div class="space-y-4 max-w-sm">
                <div>
                    <label class="label">Current Password</label>
                    <input type="password" name="current_password" class="input" required>
                    @error('current_password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="label">New Password</label>
                    <input type="password" name="password" class="input" required>
                </div>
                <div>
                    <label class="label">Confirm New Password</label>
                    <input type="password" name="password_confirmation" class="input" required>
                </div>
                <button type="submit" class="btn-primary">
                    <i class="fa-solid fa-lock"></i> Update Password
                </button>
            </div>
        </form>
    </div>

    {{-- My adoption requests --}}
    @if(!auth()->user()->isAdmin())
    <div class="card overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100">
            <h2 class="font-semibold text-slate-900">My Adoption Requests</h2>
        </div>
        <div class="divide-y divide-slate-50">
            @forelse($user->adoptionRequests as $req)
            <div class="px-6 py-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg overflow-hidden bg-slate-100">
                        @if($req->pet && $req->pet->image)
                            <img src="{{ asset('storage/' . $req->pet->image) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <i class="fa-solid fa-dog text-slate-300 text-xs"></i>
                            </div>
                        @endif
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-800">{{ $req->pet->name ?? 'Deleted Pet' }}</p>
                        <p class="text-xs text-slate-400">{{ $req->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <span class="badge-{{ $req->status }}">{{ ucfirst($req->status) }}</span>
                    <a href="{{ route('adoptions.show', $req) }}" class="text-xs text-brand-600 hover:text-brand-700 font-medium">View</a>
                </div>
            </div>
            @empty
            <div class="px-6 py-8 text-center text-slate-400">
                <i class="fa-solid fa-heart text-3xl mb-2 block"></i>
                <p class="text-sm">You haven't made any adoption requests yet.</p>
                <a href="{{ route('adoptions.create') }}" class="mt-3 inline-flex text-sm text-brand-600 font-medium hover:text-brand-700">
                    Browse available pets <i class="fa-solid fa-arrow-right ml-1"></i>
                </a>
            </div>
            @endforelse
        </div>
    </div>
    @endif

</div>

@endsection
