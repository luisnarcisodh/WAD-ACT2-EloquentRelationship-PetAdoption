@extends('layouts.app')

@section('header', 'My Profile')

@section('content')
<div class="max-w-xl bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden p-8">
    <form method="POST" action="{{ route('profile.update') }}" class="space-y-5">
        @csrf @method('PUT')
        
        <div>
            <label class="block text-sm font-medium mb-1 text-slate-700">Full Name</label>
            <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" class="w-full px-4 py-2 border @error('name') border-red-500 @else border-slate-200 @enderror rounded-lg focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600 outline-none transition-all" required>
            @error('name')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>
        
        <div>
            <label class="block text-sm font-medium mb-1 text-slate-700">Email Address</label>
            <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" class="w-full px-4 py-2 border @error('email') border-red-500 @else border-slate-200 @enderror rounded-lg focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600 outline-none transition-all" required>
            @error('email')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>
        
        <hr class="border-slate-100 my-6">
        
        <div>
            <label class="block text-sm font-medium mb-1 text-slate-700">New Password <span class="text-slate-400 font-normal">(Leave blank if you don't want to change it)</span></label>
            <input type="password" name="password" class="w-full px-4 py-2 border @error('password') border-red-500 @else border-slate-200 @enderror rounded-lg focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600 outline-none transition-all">
            @error('password')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>
        
        <div>
            <label class="block text-sm font-medium mb-1 text-slate-700">Confirm New Password</label>
            <input type="password" name="password_confirmation" class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600 outline-none transition-all">
        </div>
        
        <div class="pt-4 flex justify-end">
            <button type="submit" class="bg-indigo-600 text-white px-6 py-2.5 rounded-lg text-sm font-medium hover:bg-indigo-700 transition-colors shadow-sm">
                Save Changes
            </button>
        </div>
    </form>
</div>
@endsection