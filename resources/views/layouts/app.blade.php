<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'PawsHQ') }}</title>
    
    <!-- TAILWIND CSS FOR UI/UX -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- ALPINE.JS FOR MODALS & DROPDOWNS -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- LUCIDE ICONS FOR PREMIUM LOOK -->
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <!-- GOOGLE FONTS -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="h-full flex overflow-hidden text-slate-800">

    <!-- SIDEBAR NAVIGATION -->
    <aside class="w-64 bg-white border-r border-slate-200 flex flex-col hidden md:flex z-10 shadow-sm">
        <div class="h-16 flex items-center px-6 border-b border-slate-200">
            <i data-lucide="paw-print" class="w-6 h-6 text-indigo-600 mr-2"></i>
            <span class="text-xl font-bold text-slate-900 tracking-tight">PawsHQ</span>
        </div>
        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
            <a href="{{ route('dashboard') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                <i data-lucide="layout-dashboard" class="w-5 h-5 mr-3 {{ request()->routeIs('dashboard') ? 'text-indigo-600' : 'text-slate-400' }}"></i> Dashboard
            </a>
            <a href="{{ route('pets.index') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('pets.*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                <i data-lucide="cat" class="w-5 h-5 mr-3 {{ request()->routeIs('pets.*') ? 'text-indigo-600' : 'text-slate-400' }}"></i> Pets Catalog
            </a>
            <a href="{{ route('adoptions.index') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('adoptions.*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                <i data-lucide="heart-handshake" class="w-5 h-5 mr-3 {{ request()->routeIs('adoptions.*') ? 'text-indigo-600' : 'text-slate-400' }}"></i> Adoptions
            </a>
            @if(auth()->user() && auth()->user()->role === 'admin')
            <a href="{{ route('vets.index') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('vets.*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                <i data-lucide="stethoscope" class="w-5 h-5 mr-3 {{ request()->routeIs('vets.*') ? 'text-indigo-600' : 'text-slate-400' }}"></i> Veterinarians
            </a>
            @endif
            <a href="{{ route('profile.index') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('profile.*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                <i data-lucide="user" class="w-5 h-5 mr-3 {{ request()->routeIs('profile.*') ? 'text-indigo-600' : 'text-slate-400' }}"></i> My Profile
            </a>
        </nav>
        <div class="p-4 border-t border-slate-200">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center w-full px-3 py-2.5 text-sm font-medium text-red-600 rounded-lg hover:bg-red-50 transition-colors">
                    <i data-lucide="log-out" class="w-5 h-5 mr-3"></i> Sign Out
                </button>
            </form>
        </div>
    </aside>

    <!-- MAIN CONTENT AREA -->
    <main class="flex-1 flex flex-col h-full overflow-hidden bg-slate-50/50">
        <!-- TOP HEADER -->
        <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-8 z-0 shadow-sm">
            <h1 class="text-xl font-bold text-slate-800">@yield('header')</h1>
            <div class="flex items-center gap-4">
                @if(auth()->user())
                    <span class="px-3 py-1 rounded-full text-xs font-semibold tracking-wide uppercase {{ auth()->user()->role === 'admin' ? 'bg-indigo-100 text-indigo-700' : 'bg-slate-100 text-slate-700' }}">
                        {{ auth()->user()->role }}
                    </span>
                    <div class="h-9 w-9 rounded-full bg-gradient-to-tr from-indigo-600 to-purple-600 text-white flex items-center justify-center font-bold text-sm shadow-sm ring-2 ring-white">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                @endif
            </div>
        </header>

        <!-- PAGE CONTENT -->
        <div class="flex-1 overflow-y-auto p-8">
            <!-- ALERTS -->
            @if(session('success'))
                <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 flex items-center text-emerald-800 shadow-sm">
                    <i data-lucide="check-circle-2" class="w-5 h-5 mr-3 text-emerald-600"></i>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif
            @if($errors->any())
                <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-red-800 shadow-sm flex items-start">
                    <i data-lucide="alert-circle" class="w-5 h-5 mr-3 text-red-600 mt-0.5"></i>
                    <ul class="list-disc list-inside text-sm font-medium space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <!-- INITIALIZE ICONS -->
    <script>lucide.createIcons();</script>
</body>
</html>