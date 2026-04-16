@extends('layouts.app')

@section('title', 'Edit ' . $pet->name)

@section('content')

<div class="mb-8 flex items-center gap-4">
    <a href="{{ route('pets.index') }}" class="w-9 h-9 bg-white border border-slate-200 rounded-xl flex items-center justify-center hover:bg-slate-50 transition-colors">
        <i class="fa-solid fa-arrow-left text-slate-500 text-sm"></i>
    </a>
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Edit {{ $pet->name }}</h1>
        <p class="text-slate-500 text-sm mt-0.5">Update pet information</p>
    </div>
</div>

<div class="max-w-3xl">
    <form method="POST" action="{{ route('pets.update', $pet) }}" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="card p-6 space-y-5 mb-4">
            <h2 class="font-semibold text-slate-900 border-b border-slate-100 pb-3">Pet Information</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="label">Name <span class="text-red-400">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $pet->name) }}" class="input" required>
                </div>
                <div>
                    <label class="label">Type <span class="text-red-400">*</span></label>
                    <input type="text" name="type" value="{{ old('type', $pet->type) }}" class="input" required>
                </div>
                <div>
                    <label class="label">Breed</label>
                    <input type="text" name="breed" value="{{ old('breed', $pet->breed) }}" class="input">
                </div>
                <div>
                    <label class="label">Age (years)</label>
                    <input type="number" name="age" value="{{ old('age', $pet->age) }}" class="input" min="0" max="100">
                </div>
                <div>
                    <label class="label">Gender <span class="text-red-400">*</span></label>
                    <select name="gender" class="input" required>
                        @foreach(['unknown','male','female'] as $g)
                        <option value="{{ $g }}" {{ old('gender', $pet->gender) === $g ? 'selected' : '' }}>{{ ucfirst($g) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="label">Status <span class="text-red-400">*</span></label>
                    <select name="status" class="input" required>
                        @foreach(['available','pending','adopted'] as $s)
                        <option value="{{ $s }}" {{ old('status', $pet->status) === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="label">Description</label>
                <textarea name="description" rows="3" class="input">{{ old('description', $pet->description) }}</textarea>
            </div>

            <div>
                <label class="label">Photo</label>
                @if($pet->image)
                <div class="mb-3 flex items-center gap-3">
                    <img src="{{ asset('storage/' . $pet->image) }}" class="h-20 w-20 object-cover rounded-xl">
                    <p class="text-sm text-slate-500">Current photo. Upload a new one to replace it.</p>
                </div>
                @endif
                <div class="border-2 border-dashed border-slate-200 rounded-xl p-4 text-center hover:border-brand-300 transition-colors cursor-pointer"
                     onclick="document.getElementById('imageInput').click()">
                    <i class="fa-solid fa-cloud-arrow-up text-slate-300 text-2xl mb-1 block"></i>
                    <p class="text-sm text-slate-500">Click to upload new photo</p>
                    <input type="file" id="imageInput" name="image" accept="image/*" class="hidden"
                           onchange="previewImage(this)">
                </div>
                <div id="imagePreview" class="hidden mt-3">
                    <img id="previewImg" src="" class="h-24 rounded-xl object-cover">
                </div>
            </div>
        </div>

        @if($vets->count())
        <div class="card p-6 mb-4">
            <h2 class="font-semibold text-slate-900 border-b border-slate-100 pb-3 mb-4">Assigned Veterinarians</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                @foreach($vets as $vet)
                <label class="flex items-center gap-3 p-3 rounded-xl border border-slate-200 hover:bg-slate-50 cursor-pointer transition-colors">
                    <input type="checkbox" name="vet_ids[]" value="{{ $vet->id }}"
                           {{ in_array($vet->id, old('vet_ids', $pet->vets->pluck('id')->toArray())) ? 'checked' : '' }}
                           class="w-4 h-4 text-brand-600 rounded">
                    <div>
                        <p class="text-sm font-medium text-slate-800">{{ $vet->name }}</p>
                        <p class="text-xs text-slate-400">{{ $vet->clinic }}</p>
                    </div>
                </label>
                @endforeach
            </div>
        </div>
        @endif

        <div class="flex items-center gap-3">
            <button type="submit" class="btn-primary px-8 py-2.5">
                <i class="fa-solid fa-check"></i> Update Pet
            </button>
            <a href="{{ route('pets.index') }}" class="btn-secondary px-6 py-2.5">Cancel</a>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('imagePreview').classList.remove('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
