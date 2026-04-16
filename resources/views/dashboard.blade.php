@extends('layouts.app')

@section('header', 'Overview')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow flex items-center justify-between">
        <div>
            <p class="text-sm font-semibold text-slate-500 mb-1 uppercase tracking-wider">Total Pets</p>
            <h3 class="text-3xl font-bold text-slate-900">{{ \App\Models\Pet::count() }}</h3>
        </div>
        <div class="w-14 h-14 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center shadow-inner">
            <i data-lucide="cat" class="w-7 h-7"></i>
        </div>
    </div>
    
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow flex items-center justify-between">
        <div>
            <p class="text-sm font-semibold text-slate-500 mb-1 uppercase tracking-wider">Adoption Requests</p>
            <h3 class="text-3xl font-bold text-slate-900">{{ \App\Models\AdoptionRequest::count() }}</h3>
        </div>
        <div class="w-14 h-14 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center shadow-inner">
            <i data-lucide="heart" class="w-7 h-7"></i>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow flex items-center justify-between">
        <div>
            <p class="text-sm font-semibold text-slate-500 mb-1 uppercase tracking-wider">Veterinarians</p>
            <h3 class="text-3xl font-bold text-slate-900">{{ \App\Models\Vet::count() }}</h3>
        </div>
        <div class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center shadow-inner">
            <i data-lucide="stethoscope" class="w-7 h-7"></i>
        </div>
    </div>
</div>

<div class="bg-gradient-to-br from-indigo-900 to-slate-900 rounded-3xl border border-slate-800 shadow-xl p-10 text-center relative overflow-hidden">
    <!-- Decorative background elements -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden opacity-10 pointer-events-none">
        <svg class="absolute -top-24 -right-24 w-96 h-96 text-white" fill="currentColor" viewBox="0 0 100 100"><circle cx="50" cy="50" r="50"/></svg>
        <svg class="absolute -bottom-24 -left-24 w-72 h-72 text-indigo-400" fill="currentColor" viewBox="0 0 100 100"><circle cx="50" cy="50" r="50"/></svg>
    </div>

    <div class="relative z-10">
        <div class="inline-flex items-center justify-center w-20 h-20 bg-white/10 backdrop-blur-md text-white rounded-3xl mb-6 shadow-2xl ring-1 ring-white/20">
            <i data-lucide="sparkles" class="w-10 h-10"></i>
        </div>
        <h2 class="text-3xl font-bold text-white mb-3">Welcome to PawsHQ, {{ auth()->user()->name }}!</h2>
        <p class="text-indigo-100 max-w-2xl mx-auto text-lg mb-8 leading-relaxed">
            Manage your pet database, review adoption requests, and handle veterinary assignments securely and seamlessly in our brand new portal.
        </p>
        <div class="flex justify-center gap-4">
            <a href="{{ route('pets.index') }}" class="px-6 py-3 bg-white text-indigo-900 font-bold rounded-xl hover:bg-indigo-50 transition-colors shadow-lg">Browse Pets</a>
            <a href="{{ route('profile.index') }}" class="px-6 py-3 bg-white/10 text-white font-bold rounded-xl hover:bg-white/20 transition-colors backdrop-blur-md ring-1 ring-white/20">View Profile</a>
        </div>
    </div>
</div>
@endsection