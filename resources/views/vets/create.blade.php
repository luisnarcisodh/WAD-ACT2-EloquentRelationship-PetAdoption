@extends('layouts.app')

@section('title', 'Add Veterinarian')

@section('content')

<div class="mb-8 flex items-center gap-4">
    <a href="{{ route('vets.index') }}" class="w-9 h-9 bg-white border border-slate-200 rounded-xl flex items-center justify-center hover:bg-slate-50 transition-colors">
        <i class="fa-solid fa-arrow-left text-slate-500 text-sm"></i>
    </a>
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Add Veterinarian</h1>
        <p class="text-slate-500 text-sm mt-0.5">Register a new vet to the system</p>
    </div>
</div>

<div class="max-w-2xl">
    <form method="POST" action="{{ route('vets.store') }}">
        @csrf

        <div class="card p-6 space-y-5 mb-4">
            <h2 class="font-semibold text-slate-900 border-b border-slate-100 pb-3">Veterinarian Details</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="label">Full Name <span class="text-red-400">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" class="input" placeholder="Dr. Sarah Johnson" required>
                </div>
                <div>
                    <label class="label">Clinic <span class="text-red-400">*</span></label>
                    <input type="text" name="clinic" value="{{ old('clinic') }}" class="input" placeholder="Happy Paws Clinic" required>
                </div>
                <div>
                    <label class="label">Specialization</label>
                    <input type="text" name="specialization" value="{{ old('specialization') }}" class="input" placeholder="Small Animals">
                </div>
                <div>
                    <label class="label">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" class="input" placeholder="+1 (555) 000-0000">
                </div>
                <div class="md:col-span-2">
                    <label class="label">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="input" placeholder="vet@clinic.com">
                </div>
            </div>
        </div>

        @if($pets->count())
        <div class="card p-6 mb-4">
            <h2 class="font-semibold text-slate-900 border-b border-slate-100 pb-3 mb-4">Assign to Pets</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 max-h-60 overflow-y-auto">
                @foreach($pets as $pet)
                <label class="flex items-center gap-3 p-3 rounded-xl border border-slate-200 hover:bg-slate-50 cursor-pointer transition-colors">
                    <input type="checkbox" name="pet_ids[]" value="{{ $pet->id }}"
                           {{ in_array($pet->id, old('pet_ids', [])) ? 'checked' : '' }}
                           class="w-4 h-4 text-brand-600 rounded">
                    <div>
                        <p class="text-sm font-medium text-slate-800">{{ $pet->name }}</p>
                        <p class="text-xs text-slate-400">{{ ucfirst($pet->type) }}</p>
                    </div>
                </label>
                @endforeach
            </div>
        </div>
        @endif

        <div class="flex items-center gap-3">
            <button type="submit" class="btn-primary px-8 py-2.5">
                <i class="fa-solid fa-check"></i> Add Veterinarian
            </button>
            <a href="{{ route('vets.index') }}" class="btn-secondary px-6 py-2.5">Cancel</a>
        </div>
    </form>
</div>

@endsection
