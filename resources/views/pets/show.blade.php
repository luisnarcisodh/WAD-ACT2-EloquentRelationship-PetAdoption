@extends('layouts.app')

@section('title', $pet->name)

@section('content')

<div class="mb-6 flex items-center gap-4">
    <a href="{{ route('pets.index') }}" class="w-9 h-9 bg-white border border-slate-200 rounded-xl flex items-center justify-center hover:bg-slate-50 transition-colors">
        <i class="fa-solid fa-arrow-left text-slate-500 text-sm"></i>
    </a>
    <div class="flex-1">
        <h1 class="text-2xl font-bold text-slate-900">{{ $pet->name }}</h1>
        <p class="text-slate-500 text-sm mt-0.5">{{ ucfirst($pet->type) }}{{ $pet->breed ? ' · ' . $pet->breed : '' }}</p>
    </div>
    @if(auth()->user()->isAdmin())
    <div class="flex items-center gap-2">
        <a href="{{ route('pets.edit', $pet) }}" class="btn-secondary">
            <i class="fa-solid fa-pen"></i> Edit
        </a>
        <form method="POST" action="{{ route('pets.destroy', $pet) }}"
              onsubmit="return confirm('Delete this pet?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn-danger">
                <i class="fa-solid fa-trash"></i> Delete
            </button>
        </form>
    </div>
    @endif
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Left: Image + quick actions --}}
    <div class="space-y-4">
        <div class="card overflow-hidden">
            @if($pet->image)
                <img src="{{ asset('storage/' . $pet->image) }}" alt="{{ $pet->name }}"
                     class="w-full aspect-square object-cover">
            @else
                <div class="w-full aspect-square flex items-center justify-center bg-gradient-to-br from-slate-100 to-slate-200">
                    <i class="fa-solid fa-{{ $pet->type === 'cat' ? 'cat' : 'dog' }} text-slate-300 text-7xl"></i>
                </div>
            @endif
        </div>

        @if($pet->status === 'available')
        <a href="{{ route('adoptions.create', ['pet_id' => $pet->id]) }}"
           class="btn-primary w-full justify-center py-3 text-base">
            <i class="fa-solid fa-heart"></i> Adopt {{ $pet->name }}
        </a>
        @else
        <div class="card p-4 text-center">
            <span class="badge-{{ $pet->status }} text-sm px-3 py-1">{{ ucfirst($pet->status) }}</span>
            <p class="text-xs text-slate-400 mt-2">This pet is not available for adoption</p>
        </div>
        @endif
    </div>

    {{-- Right: Details --}}
    <div class="lg:col-span-2 space-y-4">

        {{-- Basic info --}}
        <div class="card p-6">
            <h2 class="font-semibold text-slate-900 mb-4">Details</h2>
            <dl class="grid grid-cols-2 gap-4">
                <div>
                    <dt class="text-xs text-slate-400 uppercase tracking-wider mb-1">Status</dt>
                    <dd><span class="badge-{{ $pet->status }}">{{ ucfirst($pet->status) }}</span></dd>
                </div>
                <div>
                    <dt class="text-xs text-slate-400 uppercase tracking-wider mb-1">Gender</dt>
                    <dd class="text-sm font-medium text-slate-800 capitalize">{{ $pet->gender }}</dd>
                </div>
                @if($pet->age)
                <div>
                    <dt class="text-xs text-slate-400 uppercase tracking-wider mb-1">Age</dt>
                    <dd class="text-sm font-medium text-slate-800">{{ $pet->age }} year{{ $pet->age > 1 ? 's' : '' }}</dd>
                </div>
                @endif
                @if($pet->breed)
                <div>
                    <dt class="text-xs text-slate-400 uppercase tracking-wider mb-1">Breed</dt>
                    <dd class="text-sm font-medium text-slate-800">{{ $pet->breed }}</dd>
                </div>
                @endif
            </dl>
            @if($pet->description)
            <div class="mt-4 pt-4 border-t border-slate-100">
                <dt class="text-xs text-slate-400 uppercase tracking-wider mb-2">About</dt>
                <p class="text-sm text-slate-700 leading-relaxed">{{ $pet->description }}</p>
            </div>
            @endif
        </div>

        {{-- Vaccination --}}
        <div class="card p-6">
            <h2 class="font-semibold text-slate-900 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-syringe text-emerald-500"></i> Vaccination
            </h2>
            @if($pet->vaccination)
            <div class="flex items-center gap-4 p-4 bg-emerald-50 rounded-xl border border-emerald-100">
                <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center">
                    <i class="fa-solid fa-shield-virus text-emerald-600"></i>
                </div>
                <div>
                    <p class="font-semibold text-slate-800">{{ $pet->vaccination->vaccine_name }}</p>
                    <p class="text-xs text-slate-500">
                        Administered: {{ $pet->vaccination->date->format('M d, Y') }}
                        @if($pet->vaccination->next_due)
                        · Next due: {{ $pet->vaccination->next_due->format('M d, Y') }}
                        @endif
                    </p>
                </div>
            </div>
            @else
            <p class="text-sm text-slate-400">No vaccination records on file.</p>
            @endif
        </div>

        {{-- Vets --}}
        @if($pet->vets->count())
        <div class="card p-6">
            <h2 class="font-semibold text-slate-900 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-stethoscope text-sky-500"></i> Assigned Vets
            </h2>
            <div class="space-y-2">
                @foreach($pet->vets as $vet)
                <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-xl">
                    <div class="w-8 h-8 bg-sky-100 rounded-lg flex items-center justify-center">
                        <i class="fa-solid fa-user-doctor text-sky-600 text-sm"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-800">{{ $vet->name }}</p>
                        <p class="text-xs text-slate-400">{{ $vet->clinic }}</p>
                    </div>
                    @if($vet->phone)
                    <a href="tel:{{ $vet->phone }}" class="ml-auto text-xs text-brand-600 hover:underline">{{ $vet->phone }}</a>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Adoption requests (admin only) --}}
        @if(auth()->user()->isAdmin() && $pet->adoptionRequests->count())
        <div class="card p-6">
            <h2 class="font-semibold text-slate-900 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-heart text-pink-500"></i> Adoption Requests
            </h2>
            <div class="space-y-2">
                @foreach($pet->adoptionRequests as $req)
                <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl">
                    <div class="flex items-center gap-3">
                        <div class="w-7 h-7 rounded-full bg-brand-100 flex items-center justify-center text-brand-700 text-xs font-bold">
                            {{ strtoupper(substr($req->user->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-sm font-medium text-slate-800">{{ $req->user->name }}</p>
                            <p class="text-xs text-slate-400">{{ $req->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                    <span class="badge-{{ $req->status }}">{{ ucfirst($req->status) }}</span>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

@endsection
