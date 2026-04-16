@extends('layouts.app')

@section('header', 'Adoption Requests')

@section('content')
<div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
    <table class="w-full text-left text-sm">
        <thead class="bg-slate-50 border-b border-slate-200 text-slate-600 font-medium uppercase tracking-wider text-xs">
            <tr>
                <th class="px-6 py-4">Reference ID</th>
                @if(auth()->user()->isAdmin())
                <th class="px-6 py-4">Adopter</th>
                @endif
                <th class="px-6 py-4">Pet</th>
                <th class="px-6 py-4 hidden md:table-cell">Date</th>
                <th class="px-6 py-4">Status</th>
                <th class="px-6 py-4 text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 text-slate-800">
            @forelse($adoptions as $adoption)
            <tr class="hover:bg-slate-50/50 transition-colors">
                <td class="px-6 py-4 font-mono text-xs text-slate-500">
                    #REQ-{{ str_pad($adoption->id, 5, '0', STR_PAD_LEFT) }}
                </td>
                
                @if(auth()->user()->isAdmin())
                <td class="px-6 py-4 font-medium text-slate-900">
                    {{ $adoption->user->name }}
                </td>
                @endif
                
                <td class="px-6 py-4 font-medium text-slate-900 flex items-center gap-2">
                    <i data-lucide="{{ strtolower($adoption->pet->type) == 'dog' ? 'dog' : 'cat' }}" class="w-4 h-4 text-slate-400"></i>
                    {{ $adoption->pet->name }}
                </td>
                
                <td class="px-6 py-4 text-slate-500 hidden md:table-cell">
                    {{ $adoption->created_at->format('M d, Y') }}
                </td>
                
                <td class="px-6 py-4">
                    @php
                        $badgeClass = match(strtolower($adoption->status)) {
                            'pending' => 'bg-amber-50 text-amber-700 border-amber-200',
                            'approved' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                            'rejected' => 'bg-red-50 text-red-700 border-red-200',
                            default => 'bg-slate-50 text-slate-700 border-slate-200'
                        };
                    @endphp
                    <span class="px-2.5 py-1 text-xs font-bold rounded-full border {{ $badgeClass }} uppercase tracking-widest">
                        {{ $adoption->status }}
                    </span>
                </td>
                
                <td class="px-6 py-4 text-right flex justify-end gap-2">
                    <!-- APPROVE/REJECT BUTTONS (ADMIN ONLY) -->
                    @if(auth()->user()->isAdmin() && strtolower($adoption->status) === 'pending')
                        <form method="POST" action="{{ route('adoptions.update', $adoption) }}">
                            @csrf @method('PUT')
                            <input type="hidden" name="status" value="approved">
                            <button type="submit" class="p-2 text-emerald-600 bg-emerald-50 rounded-lg hover:bg-emerald-100 transition-colors" title="Approve Request">
                                <i data-lucide="check" class="w-4 h-4"></i>
                            </button>
                        </form>

                        <form method="POST" action="{{ route('adoptions.update', $adoption) }}">
                            @csrf @method('PUT')
                            <input type="hidden" name="status" value="rejected">
                            <button type="submit" class="p-2 text-red-600 bg-red-50 rounded-lg hover:bg-red-100 transition-colors" title="Reject Request">
                                <i data-lucide="x" class="w-4 h-4"></i>
                            </button>
                        </form>
                    @endif

                    <!-- DELETE/CANCEL BUTTON (USER & ADMIN) -->
                    @if(auth()->user()->isAdmin() || auth()->id() === $adoption->user_id)
                        <form method="POST" action="{{ route('adoptions.destroy', $adoption) }}" onsubmit="return confirm('Are you sure you want to delete this request?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-2 text-slate-400 bg-slate-50 rounded-lg hover:bg-red-50 hover:text-red-600 transition-colors" title="{{ strtolower($adoption->status) === 'pending' ? 'Cancel Request' : 'Delete Record' }}">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="{{ auth()->user()->isAdmin() ? '6' : '5' }}" class="px-6 py-12 text-center text-slate-500">
                    <div class="flex flex-col items-center justify-center">
                        <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                            <i data-lucide="inbox" class="w-8 h-8 text-slate-400"></i>
                        </div>
                        <p>No adoption requests found.</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    <!-- Pagination Links -->
    @if(method_exists($adoptions, 'hasPages') && $adoptions->hasPages())
    <div class="px-6 py-4 border-t border-slate-100 bg-white">
        {{ $adoptions->links() }}
    </div>
    @endif
</div>
@endsection