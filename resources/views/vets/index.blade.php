@extends('layouts.app')

@section('header', 'Veterinary Network')

@section('content')
<div x-data="{ showModal: false, editMode: false, currentVet: {id: '', name: '', clinic: ''} }">
    
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Veterinarians</h1>
            <!-- Added a check for total() in case you are paginating the vets in your controller -->
            <p class="text-slate-500 text-sm mt-1">{{ method_exists($vets, 'total') ? $vets->total() : $vets->count() }} vets on record</p>
        </div>
        @if(auth()->user()->isAdmin())
        <!-- Notice we use @click to trigger the modal instead of an <a> tag -->
        <button @click="showModal = true; editMode = false; currentVet = {id: '', name: '', clinic: ''}" class="bg-indigo-600 text-white px-4 py-2.5 rounded-lg text-sm font-medium flex items-center shadow-sm hover:bg-indigo-700 transition-colors">
            <i data-lucide="plus" class="w-4 h-4 mr-2"></i> Add Vet
        </button>
        @endif
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 border-b border-slate-200 text-slate-600 font-medium uppercase tracking-wider text-xs">
                <tr>
                    <th class="px-6 py-4">Name</th>
                    <th class="px-6 py-4">Clinic</th>
                    @if(auth()->user()->isAdmin())
                    <th class="px-6 py-4 text-right">Actions</th>
                    @endif
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($vets as $vet)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-4 font-medium text-slate-900 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold">
                            {{ substr($vet->name, 0, 1) }}
                        </div>
                        {{ $vet->name }}
                    </td>
                    <td class="px-6 py-4 text-slate-600">{{ $vet->clinic }}</td>
                    @if(auth()->user()->isAdmin())
                    <td class="px-6 py-4 text-right flex justify-end gap-2">
                        <button @click="currentVet = {{ json_encode($vet) }}; editMode = true; showModal = true" class="text-indigo-600 bg-indigo-50 p-2 rounded-lg hover:bg-indigo-100 transition-colors" title="Edit Vet">
                            <i data-lucide="edit" class="w-4 h-4"></i>
                        </button>
                        <form method="POST" action="{{ route('vets.destroy', $vet) }}" onsubmit="return confirm('Are you sure you want to remove this vet?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 bg-red-50 p-2 rounded-lg hover:bg-red-100 transition-colors" title="Delete Vet">
                                <i data-lucide="trash" class="w-4 h-4"></i>
                            </button>
                        </form>
                    </td>
                    @endif
                </tr>
                @empty
                <tr><td colspan="3" class="px-6 py-12 text-center text-slate-500">No veterinarians registered yet.</td></tr>
                @endforelse
            </tbody>
        </table>
        
        <!-- Pagination Links (if you are using ->paginate() in VetController) -->
        @if(method_exists($vets, 'hasPages') && $vets->hasPages())
        <div class="px-6 py-4 border-t border-slate-100">
            {{ $vets->links() }}
        </div>
        @endif
    </div>

    <!-- Create/Edit Modal -->
    <div x-show="showModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div x-show="showModal" x-transition.opacity class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm" @click="showModal = false"></div>
        <div x-show="showModal" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             class="bg-white rounded-2xl shadow-xl w-full max-w-md relative z-10 overflow-hidden">
            <form :action="editMode ? '/vets/' + currentVet.id : '{{ route('vets.store') }}'" method="POST">
                @csrf 
                <template x-if="editMode"><input type="hidden" name="_method" value="PUT"></template>
                
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-5 text-slate-900" x-text="editMode ? 'Edit Veterinarian' : 'Add New Veterinarian'"></h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold mb-1.5 text-slate-700">Vet Name</label>
                            <input type="text" name="name" x-model="currentVet.name" required placeholder="Dr. John Doe" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600 outline-none transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold mb-1.5 text-slate-700">Clinic Name</label>
                            <input type="text" name="clinic" x-model="currentVet.clinic" required placeholder="Paws & Claws Clinic" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600 outline-none transition-all">
                        </div>
                    </div>
                </div>
                <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end gap-3">
                    <button type="button" @click="showModal = false" class="px-5 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-200 rounded-xl transition-colors">Cancel</button>
                    <button type="submit" class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl text-sm font-semibold hover:bg-indigo-700 shadow-sm flex items-center transition-all">
                        <i data-lucide="save" class="w-4 h-4 mr-2"></i> Save Vet
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection