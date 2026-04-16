@extends('layouts.app')

@section('title', 'Adoption Request')

@section('content')

<div class="mb-6 flex items-center gap-4">
    <a href="{{ route('adoptions.index') }}" class="w-9 h-9 bg-white border border-slate-200 rounded-xl flex items-center justify-center hover:bg-slate-50 transition-colors">
        <i class="fa-solid fa-arrow-left text-slate-500 text-sm"></i>
    </a>
    <div class="flex-1">
        <h1 class="text-2xl font-bold text-slate-900">Adoption Request #{{ $adoption->id }}</h1>
        <p class="text-slate-500 text-sm mt-0.5">Submitted {{ $adoption->created_at->format('M d, Y \a\t g:i A') }}</p>
    </div>
    @if(auth()->user()->isAdmin())
    <a href="{{ route('adoptions.edit', $adoption) }}" class="btn-primary">
        <i class="fa-solid fa-pen"></i> Review
    </a>
    @endif
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-4">
        {{-- Status card --}}
        <div class="card p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-semibold text-slate-900">Request Status</h2>
                <span class="badge-{{ $adoption->status }} text-sm px-3 py-1">{{ ucfirst($adoption->status) }}</span>
            </div>
            <div class="grid grid-cols-3 gap-4">
                @foreach(['pending' => 'Submitted', 'approved' => 'Approved', 'rejected' => 'Rejected'] as $s => $label)
                <div class="text-center p-3 rounded-xl {{ $adoption->status === $s ? 'bg-brand-50 border border-brand-200' : 'bg-slate-50' }}">
                    <i class="fa-solid fa-{{ $s === 'pending' ? 'clock' : ($s === 'approved' ? 'check-circle' : 'times-circle') }}
                               {{ $adoption->status === $s ? 'text-brand-500' : 'text-slate-300' }} text-xl mb-1 block"></i>
                    <p class="text-xs font-medium {{ $adoption->status === $s ? 'text-brand-700' : 'text-slate-400' }}">{{ $label }}</p>
                </div>
                @endforeach
            </div>
            @if($adoption->notes)
            <div class="mt-4 pt-4 border-t border-slate-100">
                <p class="text-xs text-slate-400 uppercase tracking-wider mb-1">Notes</p>
                <p class="text-sm text-slate-700">{{ $adoption->notes }}</p>
            </div>
            @endif
            @if($adoption->reviewed_at)
            <p class="mt-3 text-xs text-slate-400">Reviewed {{ $adoption->reviewed_at->format('M d, Y') }}</p>
            @endif
        </div>

        {{-- Pet details --}}
        <div class="card p-6">
            <h2 class="font-semibold text-slate-900 mb-4">Pet Details</h2>
            <div class="flex items-start gap-4">
                <div class="w-20 h-20 rounded-xl overflow-hidden bg-slate-100 flex-shrink-0">
                    @if($adoption->pet->image)
                        <img src="{{ asset('storage/' . $adoption->pet->image) }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <i class="fa-solid fa-dog text-slate-300 text-3xl"></i>
                        </div>
                    @endif
                </div>
                <div>
                    <h3 class="font-bold text-slate-900 text-lg">{{ $adoption->pet->name }}</h3>
                    <p class="text-slate-500 text-sm">{{ ucfirst($adoption->pet->type) }}{{ $adoption->pet->breed ? ' · ' . $adoption->pet->breed : '' }}</p>
                    <div class="mt-2 flex items-center gap-3">
                        @if($adoption->pet->age)
                        <span class="text-xs text-slate-400">{{ $adoption->pet->age }} yr{{ $adoption->pet->age > 1 ? 's' : '' }}</span>
                        @endif
                        <span class="text-xs text-slate-400 capitalize">{{ $adoption->pet->gender }}</span>
                    </div>
                    <a href="{{ route('pets.show', $adoption->pet) }}" class="mt-2 inline-flex text-xs text-brand-600 hover:text-brand-700 font-medium">
                        View pet profile <i class="fa-solid fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Applicant --}}
    <div>
        <div class="card p-6">
            <h2 class="font-semibold text-slate-900 mb-4">Applicant</h2>
            <div class="flex items-center gap-3 mb-4">
                <div class="w-12 h-12 rounded-full bg-brand-100 flex items-center justify-center text-brand-700 text-lg font-bold">
                    {{ strtoupper(substr($adoption->user->name, 0, 1)) }}
                </div>
                <div>
                    <p class="font-semibold text-slate-800">{{ $adoption->user->name }}</p>
                    <p class="text-sm text-slate-400">{{ $adoption->user->email }}</p>
                </div>
            </div>
            <div class="pt-4 border-t border-slate-100">
                <p class="text-xs text-slate-400 mb-1">Member since</p>
                <p class="text-sm text-slate-700">{{ $adoption->user->created_at->format('M Y') }}</p>
            </div>
        </div>
    </div>
</div>

@endsection
