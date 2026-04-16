@extends('layouts.app')

@section('title', $vet->name)

@section('content')

<div class="mb-6 flex items-center gap-4">
    <a href="{{ route('vets.index') }}" class="w-9 h-9 bg-white border border-slate-200 rounded-xl flex items-center justify-center hover:bg-slate-50 transition-colors">
        <i class="fa-solid fa-arrow-left text-slate-500 text-sm"></i>
    </a>
    <div class="flex-1">
        <h1 class="text-2xl font-bold text-slate-900">{{ $vet->name }}</h1>
        <p class="text-slate-500 text-sm mt-0.5">{{ $vet->clinic }}</p>
    </div>
    <a href="{{ route('vets.edit', $vet) }}" class="btn-secondary">
        <i class="fa-solid fa-pen"></i> Edit
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="space-y-4">
        <div class="card p-6">
            <div class="w-16 h-16 bg-sky-100 rounded-2xl flex items-center justify-center mb-4">
                <i class="fa-solid fa-user-doctor text-sky-600 text-3xl"></i>
            </div>
            <h2 class="font-bold text-slate-900 text-lg">{{ $vet->name }}</h2>
            <p class="text-slate-500 text-sm mt-0.5">{{ $vet->specialization ?: 'General Practice' }}</p>

            <div class="mt-4 space-y-2.5">
                <div class="flex items-center gap-2 text-sm text-slate-600">
                    <i class="fa-solid fa-hospital text-slate-400 w-4"></i>
                    {{ $vet->clinic }}
                </div>
                @if($vet->phone)
                <div class="flex items-center gap-2 text-sm text-slate-600">
                    <i class="fa-solid fa-phone text-slate-400 w-4"></i>
                    {{ $vet->phone }}
                </div>
                @endif
                @if($vet->email)
                <div class="flex items-center gap-2 text-sm text-slate-600">
                    <i class="fa-solid fa-envelope text-slate-400 w-4"></i>
                    {{ $vet->email }}
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="lg:col-span-2">
        <div class="card p-6">
            <h2 class="font-semibold text-slate-900 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-dog text-brand-500"></i>
                Assigned Pets <span class="text-slate-400 font-normal">({{ $vet->pets->count() }})</span>
            </h2>

            @if($vet->pets->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                @foreach($vet->pets as $pet)
                <a href="{{ route('pets.show', $pet) }}" class="flex items-center gap-3 p-3 rounded-xl border border-slate-100 hover:bg-slate-50 hover:border-brand-100 transition-all">
                    <div class="w-10 h-10 rounded-xl overflow-hidden bg-slate-100 flex-shrink-0">
                        @if($pet->image)
                            <img src="{{ asset('storage/' . $pet->image) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <i class="fa-solid fa-{{ $pet->type === 'cat' ? 'cat' : 'dog' }} text-slate-300"></i>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-slate-800 truncate">{{ $pet->name }}</p>
                        <p class="text-xs text-slate-400">{{ ucfirst($pet->type) }}</p>
                    </div>
                    @if($pet->vaccination)
                    <i class="fa-solid fa-syringe text-emerald-400 text-xs flex-shrink-0" title="Vaccinated"></i>
                    @endif
                </a>
                @endforeach
            </div>
            @else
            <p class="text-sm text-slate-400">No pets assigned to this vet yet.</p>
            @endif
        </div>
    </div>
</div>

@endsection
