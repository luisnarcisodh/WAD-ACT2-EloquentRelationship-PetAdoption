@extends('layouts.app')

@section('header', 'Pets Catalog')

@section('content')
<div x-data="{ showModal: false, editMode: false, currentPet: {id: '', name: '', type: '', gender: '', status: ''} }">

    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Pets</h1>
            <p class="text-slate-500 text-sm mt-1">{{ method_exists($pets, 'total') ? $pets->total() : $pets->count() }} pets registered</p>
        </div>
        @if(auth()->user()->isAdmin())
        <!-- Notice we use @click to trigger the modal instead of an <a> tag -->
        <button @click="showModal = true; editMode = false; currentPet = {id: '', name: '', type: '', gender: '', status: 'available'}" class="bg-indigo-600 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-indigo-700 flex items-center shadow-sm transition-all active:scale-95">
            <i data-lucide="plus" class="w-4 h-4 mr-2"></i> Add Pet
        </button>
        @endif
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($pets as $pet)
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 p-6 flex flex-col group relative">

                <div class="absolute top-4 right-4 flex flex-col gap-2 items-end">
                    <span class="bg-indigo-50 text-indigo-700 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-widest">
                        {{ $pet->type }}
                    </span>
                    @if(isset($pet->status))
                    <span class="{{ strtolower($pet->status) == 'available' ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }} text-xs font-bold px-3 py-1 rounded-full uppercase tracking-widest">
                        {{ $pet->status }}
                    </span>
                    @endif
                </div>

                <div class="h-40 bg-slate-50/50 rounded-xl mb-5 flex items-center justify-center ring-1 ring-slate-100 group-hover:bg-indigo-50/30 transition-colors">
                    <i data-lucide="{{ strtolower($pet->type) == 'dog' ? 'dog' : 'cat' }}" class="w-16 h-16 text-slate-300 group-hover:text-indigo-300 transition-colors"></i>
                </div>

                <h3 class="text-xl font-bold text-slate-900 mb-1">
                    {{ $pet->name }}
                    @if(isset($pet->gender))
                        <i data-lucide="{{ strtolower($pet->gender) == 'male' ? 'gender-male' : 'gender-female' }}" class="w-4 h-4 inline-block ml-1 {{ strtolower($pet->gender) == 'male' ? 'text-blue-500' : 'text-pink-500' }}"></i>
                    @endif
                </h3>
                <p class="text-sm font-medium text-slate-500 mb-6 flex items-center">
                    <i data-lucide="calendar" class="w-4 h-4 mr-1.5 text-slate-400"></i> Added {{ $pet->created_at->diffForHumans() }}
                </p>

                <div class="mt-auto pt-5 border-t border-slate-100 flex gap-2">
                    <form method="POST" action="{{ route('adoptions.store') }}" class="w-full">
                        @csrf
                        <input type="hidden" name="pet_id" value="{{ $pet->id }}">
                        <button class="w-full bg-slate-900 text-white py-2.5 rounded-xl text-sm font-semibold hover:bg-indigo-600 shadow-sm transition-all flex justify-center items-center {{ (isset($pet->status) && strtolower($pet->status) != 'available') ? 'opacity-50 cursor-not-allowed' : '' }}" {{ (isset($pet->status) && strtolower($pet->status) != 'available') ? 'disabled' : '' }}>
                            <i data-lucide="heart" class="w-4 h-4 mr-2"></i> Adopt
                        </button>
                    </form>

                    @if(auth()->user()->isAdmin())
                    <button @click="currentPet = {{ json_encode($pet) }}; editMode = true; showModal = true" class="px-3.5 py-2.5 bg-slate-100 text-slate-600 rounded-xl hover:bg-indigo-50 hover:text-indigo-600 transition-colors" title="Edit Pet">
                        <i data-lucide="edit-2" class="w-4 h-4"></i>
                    </button>
                    <form method="POST" action="{{ route('pets.destroy', $pet) }}" onsubmit="return confirm('Are you sure you want to delete this pet?');">
                        @csrf @method('DELETE')
                        <button class="px-3.5 py-2.5 bg-red-50 text-red-600 rounded-xl hover:bg-red-100 hover:text-red-700 transition-colors" title="Delete Pet">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-20 bg-white rounded-3xl border-2 border-slate-200 border-dashed">
                <div class="mx-auto w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                    <i data-lucide="search-x" class="w-10 h-10 text-slate-400"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-1">No Pets Found</h3>
                <p class="text-slate-500">There are currently no pets available.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination Links -->
    @if(method_exists($pets, 'hasPages') && $pets->hasPages())
    <div class="mt-6 px-6 py-4 bg-white rounded-xl border border-slate-200 shadow-sm">
        {{ $pets->links() }}
    </div>
    @endif

    <!-- CREATE/EDIT MODAL -->
    <div x-show="showModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div x-show="showModal" x-transition.opacity class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="showModal = false"></div>

        <div x-show="showModal"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             class="bg-white rounded-2xl shadow-2xl w-full max-w-md relative z-10 overflow-hidden transform">

            <div class="h-2 bg-gradient-to-r from-indigo-500 to-purple-500 w-full absolute top-0 left-0"></div>

            <form :action="editMode ? '/pets/' + currentPet.id : '{{ route('pets.store') }}'" method="POST">
                @csrf
                <template x-if="editMode"><input type="hidden" name="_method" value="PUT"></template>

                <div class="p-8 pb-6">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center">
                            <i data-lucide="paw-print" class="w-5 h-5"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900" x-text="editMode ? 'Update Pet Info' : 'Register New Pet'"></h3>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Pet Name</label>
                            <input type="text" name="name" x-model="currentPet.name" placeholder="e.g. Max, Bella" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-indigo-600/20 focus:border-indigo-600 outline-none transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Species / Type</label>
                            <input type="text" name="type" x-model="currentPet.type" placeholder="e.g. Dog, Cat, Rabbit" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-indigo-600/20 focus:border-indigo-600 outline-none transition-all">
                        </div>
                        
                        <!-- Updated Lowercase Value Fields -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Gender</label>
                                <select name="gender" x-model="currentPet.gender" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-indigo-600/20 focus:border-indigo-600 outline-none transition-all">
                                    <option value="" disabled>Select Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Status</label>
                                <select name="status" x-model="currentPet.status" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-indigo-600/20 focus:border-indigo-600 outline-none transition-all">
                                    <option value="" disabled>Select Status</option>
                                    <option value="available">Available</option>
                                    <option value="adopted">Adopted</option>
                                    <option value="pending">Pending</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="px-8 py-5 bg-slate-50 border-t border-slate-100 flex justify-end gap-3">
                    <button type="button" @click="showModal = false" class="px-5 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-200 rounded-xl transition-colors">Cancel</button>
                    <button type="submit" class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl text-sm font-semibold hover:bg-indigo-700 shadow-sm transition-all flex items-center">
                        <i data-lucide="save" class="w-4 h-4 mr-2"></i> Save Details
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection