@extends('layouts.app')

@section('title', 'Add Pet')

@section('content')

<div class="mb-8 flex items-center gap-4">
    <a href="{{ route('pets.index') }}" class="w-9 h-9 bg-white border border-slate-200 rounded-xl flex items-center justify-center hover:bg-slate-50 transition-colors">
        <i class="fa-solid fa-arrow-left text-slate-500 text-sm"></i>
    </a>
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Add New Pet</h1>
        <p class="text-slate-500 text-sm mt-0.5">Register a new pet into the system</p>
    </div>
</div>

<div class="max-w-3xl">
    <form method="POST" action="{{ route('pets.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="card p-6 space-y-5 mb-4">
            <h2 class="font-semibold text-slate-900 border-b border-slate-100 pb-3">Pet Information</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="label">Name <span class="text-red-400">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" class="input" placeholder="e.g. Buddy" required>
                </div>
                <div>
                    <label class="label">Type <span class="text-red-400">*</span></label>
                    <input type="text" name="type" value="{{ old('type') }}" class="input" placeholder="e.g. Dog, Cat, Bird" required>
                </div>
                <div>
                    <label class="label">Breed</label>
                    <input type="text" name="breed" value="{{ old('breed') }}" class="input" placeholder="e.g. Labrador">
                </div>
                <div>
                    <label class="label">Age (years)</label>
                    <input type="number" name="age" value="{{ old('age') }}" class="input" min="0" max="100" placeholder="e.g. 3">
                </div>
                <div>
                    <label class="label">Gender <span class="text-red-400">*</span></label>
                    <select name="gender" class="input" required>
                        <option value="unknown" {{ old('gender') === 'unknown' ? 'selected' : '' }}>Unknown</option>
                        <option value="male" {{ old('gender') === 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender') === 'female' ? 'selected' : '' }}>Female</option>
                    </select>
                </div>
                <div>
                    <label class="label">Status <span class="text-red-400">*</span></label>
                    <select name="status" class="input" required>
                        <option value="available" {{ old('status', 'available') === 'available' ? 'selected' : '' }}>Available</option>
                        <option value="pending" {{ old('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="adopted" {{ old('status') === 'adopted' ? 'selected' : '' }}>Adopted</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="label">Description</label>
                <textarea name="description" rows="3" class="input" placeholder="Tell us about this pet...">{{ old('description') }}</textarea>
            </div>

            <div>
                <label class="label">Photo</label>
                <div class="border-2 border-dashed border-slate-200 rounded-xl p-6 text-center hover:border-brand-300 transition-colors cursor-pointer"
                     onclick="document.getElementById('imageInput').click()">
                    <i class="fa-solid fa-cloud-arrow-up text-slate-300 text-3xl mb-2 block"></i>
                    <p class="text-sm text-slate-500">Click to upload or drag and drop</p>
                    <p class="text-xs text-slate-400 mt-1">JPG, PNG, WEBP up to 2MB</p>
                    <input type="file" id="imageInput" name="image" accept="image/*" class="hidden"
                           onchange="previewImage(this)">
                </div>
                <div id="imagePreview" class="hidden mt-3">
                    <img id="previewImg" src="" class="h-32 rounded-xl object-cover">
                </div>
            </div>
        </div>

        @if($vets->count())
        <div class="card p-6 mb-4">
            <h2 class="font-semibold text-slate-900 border-b border-slate-100 pb-3 mb-4">Assign Veterinarians</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                @foreach($vets as $vet)
                <label class="flex items-center gap-3 p-3 rounded-xl border border-slate-200 hover:bg-slate-50 cursor-pointer transition-colors">
                    <input type="checkbox" name="vet_ids[]" value="{{ $vet->id }}"
                           {{ in_array($vet->id, old('vet_ids', [])) ? 'checked' : '' }}
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
                <i class="fa-solid fa-check"></i> Create Pet
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
