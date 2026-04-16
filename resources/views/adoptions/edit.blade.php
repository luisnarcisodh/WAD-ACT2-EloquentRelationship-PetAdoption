@extends('layouts.app')

@section('title', 'Review Adoption Request')

@section('content')

<div class="mb-8 flex items-center gap-4">
    <a href="{{ route('adoptions.index') }}" class="w-9 h-9 bg-white border border-slate-200 rounded-xl flex items-center justify-center hover:bg-slate-50 transition-colors">
        <i class="fa-solid fa-arrow-left text-slate-500 text-sm"></i>
    </a>
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Review Request #{{ $adoption->id }}</h1>
        <p class="text-slate-500 text-sm mt-0.5">{{ $adoption->user->name }} → {{ $adoption->pet->name }}</p>
    </div>
</div>

<div class="max-w-lg">
    <form method="POST" action="{{ route('adoptions.update', $adoption) }}">
        @csrf @method('PUT')

        <div class="card p-6 space-y-5 mb-4">
            <div>
                <label class="label">Decision <span class="text-red-400">*</span></label>
                <div class="grid grid-cols-3 gap-3 mt-2">
                    @foreach(['pending' => ['amber', 'clock'], 'approved' => ['emerald', 'check-circle'], 'rejected' => ['red', 'times-circle']] as $status => [$color, $icon])
                    <label class="cursor-pointer">
                        <input type="radio" name="status" value="{{ $status }}"
                               {{ old('status', $adoption->status) === $status ? 'checked' : '' }}
                               class="sr-only peer" required>
                        <div class="text-center p-4 rounded-xl border-2 border-slate-200 peer-checked:border-{{ $color }}-400 peer-checked:bg-{{ $color }}-50 hover:bg-slate-50 transition-all">
                            <i class="fa-solid fa-{{ $icon }} text-{{ $color }}-{{ old('status', $adoption->status) === $status ? '500' : '300' }} text-2xl mb-1 block"></i>
                            <p class="text-xs font-semibold capitalize text-slate-600">{{ $status }}</p>
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>

            <div>
                <label class="label">Review Notes</label>
                <textarea name="notes" rows="3" class="input"
                          placeholder="Add notes about your decision...">{{ old('notes', $adoption->notes) }}</textarea>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <button type="submit" class="btn-primary px-8 py-2.5">
                <i class="fa-solid fa-gavel"></i> Submit Decision
            </button>
            <a href="{{ route('adoptions.index') }}" class="btn-secondary px-6 py-2.5">Cancel</a>
        </div>
    </form>
</div>

@endsection
