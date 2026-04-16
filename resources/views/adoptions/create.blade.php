@extends('layouts.app')

@section('title', 'Request Adoption')

@section('content')

<div class="mb-8 flex items-center gap-4">
    <a href="{{ route('adoptions.index') }}" class="w-9 h-9 bg-white border border-slate-200 rounded-xl flex items-center justify-center hover:bg-slate-50 transition-colors">
        <i class="fa-solid fa-arrow-left text-slate-500 text-sm"></i>
    </a>
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Request Adoption</h1>
        <p class="text-slate-500 text-sm mt-0.5">Choose a pet and submit your request</p>
    </div>
</div>

<div class="max-w-2xl">
    <form method="POST" action="{{ route('adoptions.store') }}">
        @csrf

        <div class="card p-6 space-y-5 mb-4">
            <h2 class="font-semibold text-slate-900 border-b border-slate-100 pb-3">Select a Pet</h2>

            @if($pets->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 max-h-80 overflow-y-auto">
                @foreach($pets as $pet)
                <label class="group cursor-pointer">
                    <input type="radio" name="pet_id" value="{{ $pet->id }}"
                           {{ old('pet_id') == $pet->id || request('pet_id') == $pet->id ? 'checked' : '' }}
                           class="sr-only peer" required>
                    <div class="flex items-center gap-3 p-3 rounded-xl border border-slate-200 peer-checked:border-brand-500 peer-checked:bg-brand-50 hover:bg-slate-50 transition-all">
                        <div class="w-12 h-12 rounded-xl overflow-hidden bg-slate-100 flex-shrink-0">
                            @if($pet->image)
                                <img src="{{ asset('storage/' . $pet->image) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <i class="fa-solid fa-{{ $pet->type === 'cat' ? 'cat' : 'dog' }} text-slate-300"></i>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-slate-800 group-[.peer-checked]:text-brand-700">{{ $pet->name }}</p>
                            <p class="text-xs text-slate-400">{{ ucfirst($pet->type) }}{{ $pet->breed ? ' · ' . $pet->breed : '' }}</p>
                        </div>
                        <div class="w-4 h-4 rounded-full border-2 border-slate-300 peer-checked:border-brand-500 peer-checked:bg-brand-500 flex-shrink-0 transition-all"></div>
                    </div>
                </label>
                @endforeach
            </div>
            @else
            <div class="py-8 text-center text-slate-400">
                <i class="fa-solid fa-dog text-4xl mb-2 block"></i>
                <p class="text-sm">No pets are currently available for adoption.</p>
            </div>
            @endif

            @error('pet_id')
            <p class="text-red-500 text-xs">{{ $message }}</p>
            @enderror

            <div>
                <label class="label">Notes (optional)</label>
                <textarea name="notes" rows="3" class="input"
                          placeholder="Tell us why you'd be a great owner for this pet...">{{ old('notes') }}</textarea>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <button type="submit" class="btn-primary px-8 py-2.5" {{ $pets->count() ? '' : 'disabled' }}>
                <i class="fa-solid fa-heart"></i> Submit Request
            </button>
            <a href="{{ route('adoptions.index') }}" class="btn-secondary px-6 py-2.5">Cancel</a>
        </div>
    </form>
</div>

@endsection
