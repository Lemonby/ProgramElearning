<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Mentor</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,900&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-slate-100 bg-[#0c0721]" x-data="{ sidebarOpen: false }">
        
        <!-- HIDDEN LOGOUT FORM -->
        <form method="POST" id="logout-form" action="{{ route('logout') }}" class="hidden">
            @csrf
        </form>

        <div class="min-h-screen flex bg-gradient-to-br from-[#0c0721] via-[#160f38] to-[#251052] overflow-hidden">
            
            <!-- MOBILE SIDEBAR DRAWER (Alpine.js) -->
            <div x-show="sidebarOpen" 
                 class="fixed inset-0 z-50 flex lg:hidden" 
                 x-description="Off-canvas menu for mobile, show/hide based on off-canvas menu state." 
                 style="display: none;">
                
                <!-- Backdrop -->
                <div x-show="sidebarOpen" 
                     x-transition:enter="transition-opacity ease-linear duration-300" 
                     x-transition:enter-start="opacity-0" 
                     x-transition:enter-end="opacity-100" 
                     x-transition:leave="transition-opacity ease-linear duration-300" 
                     x-transition:leave-start="opacity-100" 
                     x-transition:leave-end="opacity-0" 
                     class="fixed inset-0 bg-[#0B071E]/80 backdrop-blur-sm" 
                     @click="sidebarOpen = false"></div>

                <!-- Menu Drawer -->
                <div x-show="sidebarOpen" 
                     x-transition:enter="transition ease-in-out duration-300 transform" 
                     x-transition:enter-start="-translate-x-full" 
                     x-transition:enter-end="translate-x-0" 
                     x-transition:leave="transition ease-in-out duration-300 transform" 
                     x-transition:leave-start="translate-x-0" 
                     x-transition:leave-end="-translate-x-full" 
                     class="relative flex w-full max-w-xs flex-1 flex-col bg-[#0B071E] p-6">
                    
                    <!-- Close button -->
                    <div class="absolute top-0 right-0 -mr-12 pt-4">
                        <button type="button" 
                                class="ml-1 flex h-10 w-10 items-center justify-center rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" 
                                @click="sidebarOpen = false">
                            <span class="sr-only">Close sidebar</span>
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Sidebar content (Mobile) -->
                    <div class="flex flex-shrink-0 items-center mb-10 pl-2">
                        <span class="text-2xl font-black tracking-tight text-white uppercase flex flex-col leading-none">
                            Edu<span class="text-purple-500">Code</span>
                            <span class="text-[10px] font-bold text-slate-400 mt-1 uppercase tracking-widest">Mentor</span>
                        </span>
                    </div>

                    <nav class="flex flex-1 flex-col justify-between">
                        <div class="space-y-2">
                            <!-- Dashboard -->
                            <a href="{{ route('dashboard.mentor') }}" 
                               class="flex items-center gap-3 px-4 py-3.5 rounded-xl transition-all {{ request()->routeIs('dashboard.mentor') ? 'bg-white/10 text-white font-bold border-l-4 border-purple-500 shadow-lg shadow-purple-500/5' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                </svg>
                                <span>Dashboard</span>
                            </a>

                            <!-- Materi -->
                            <a href="{{ route('materials.index') }}" 
                               class="flex items-center gap-3 px-4 py-3.5 rounded-xl transition-all {{ request()->routeIs('materials.*') ? 'bg-white/10 text-white font-bold border-l-4 border-purple-500 shadow-lg shadow-purple-500/5' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                                <span>Materi</span>
                            </a>

                            <!-- Tugas -->
                            <a href="{{ route('assignment.index') }}" 
                               class="flex items-center gap-3 px-4 py-3.5 rounded-xl transition-all {{ request()->routeIs('assignment.*') ? 'bg-white/10 text-white font-bold border-l-4 border-purple-500 shadow-lg shadow-purple-500/5' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                </svg>
                                <span>Tugas</span>
                            </a>

                            <!-- Absensi -->
                            <a href="{{ route('attendances.index') }}" 
                               class="flex items-center gap-3 px-4 py-3.5 rounded-xl transition-all {{ request()->routeIs('attendances.*') ? 'bg-white/10 text-white font-bold border-l-4 border-purple-500 shadow-lg shadow-purple-500/5' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>Absensi</span>
                            </a>

                            <!-- Meetings -->
                            <a href="{{ route('meetings.index') }}" 
                               class="flex items-center gap-3 px-4 py-3.5 rounded-xl transition-all {{ request()->routeIs('meetings.*') ? 'bg-white/10 text-white font-bold border-l-4 border-purple-500 shadow-lg shadow-purple-500/5' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 00-2 2z" />
                                </svg>
                                <span>Meetings</span>
                            </a>
                        </div>

                        <div class="space-y-2 border-t border-white/5 pt-4">
                            <!-- Setting -->
                            <a href="{{ route('profile.edit') }}" 
                               class="flex items-center gap-3 px-4 py-3.5 rounded-xl transition-all {{ request()->routeIs('profile.edit') ? 'bg-white/10 text-white font-bold border-l-4 border-purple-500 shadow-lg shadow-purple-500/5' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span>Setting</span>
                            </a>

                            <!-- Logout -->
                            <a href="{{ route('logout') }}" 
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                               class="flex items-center gap-3 text-slate-400 hover:text-rose-400 hover:bg-rose-500/10 transition-all rounded-xl px-4 py-3.5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                <span>Logout</span>
                            </a>
                        </div>
                    </nav>
                </div>
            </div>

            <!-- DESKTOP SIDEBAR -->
            <aside class="hidden lg:flex lg:flex-shrink-0 flex-col w-64 bg-[#0B071E] border-r border-white/5 p-6 min-h-screen">
                <div class="flex items-center mb-10 pl-2">
                    <span class="text-2xl font-black tracking-tight text-white uppercase flex flex-col leading-none">
                        Edu<span class="text-purple-500">Code</span>
                        <span class="text-[10px] font-bold text-slate-400 mt-1 uppercase tracking-widest">Mentor</span>
                    </span>
                </div>

                <nav class="flex flex-1 flex-col justify-between">
                    <div class="space-y-1.5">
                        <!-- Dashboard -->
                        <a href="{{ route('dashboard.mentor') }}" 
                           class="flex items-center gap-3 px-4 py-3.5 rounded-xl transition-all {{ request()->routeIs('dashboard.mentor') ? 'bg-white/10 text-white font-bold border-l-4 border-purple-500 shadow-lg shadow-purple-500/5' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                            </svg>
                            <span>Dashboard</span>
                        </a>

                        <!-- Materi -->
                        <a href="{{ route('materials.index') }}" 
                           class="flex items-center gap-3 px-4 py-3.5 rounded-xl transition-all {{ request()->routeIs('materials.*') ? 'bg-white/10 text-white font-bold border-l-4 border-purple-500 shadow-lg shadow-purple-500/5' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            <span>Materi</span>
                        </a>

                        <!-- Tugas -->
                        <a href="{{ route('assignment.index') }}" 
                           class="flex items-center gap-3 px-4 py-3.5 rounded-xl transition-all {{ request()->routeIs('assignment.*') ? 'bg-white/10 text-white font-bold border-l-4 border-purple-500 shadow-lg shadow-purple-500/5' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                            <span>Tugas</span>
                        </a>

                        <!-- Absensi -->
                        <a href="{{ route('attendances.index') }}" 
                           class="flex items-center gap-3 px-4 py-3.5 rounded-xl transition-all {{ request()->routeIs('attendances.*') ? 'bg-white/10 text-white font-bold border-l-4 border-purple-500 shadow-lg shadow-purple-500/5' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Absensi</span>
                        </a>

                        <!-- Meetings -->
                        <a href="{{ route('meetings.index') }}" 
                           class="flex items-center gap-3 px-4 py-3.5 rounded-xl transition-all {{ request()->routeIs('meetings.*') ? 'bg-white/10 text-white font-bold border-l-4 border-purple-500 shadow-lg shadow-purple-500/5' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 00-2 2z" />
                            </svg>
                            <span>Meetings</span>
                        </a>
                    </div>

                    <div class="space-y-1.5 border-t border-white/5 pt-4">
                        <!-- Setting -->
                        <a href="{{ route('profile.edit') }}" 
                           class="flex items-center gap-3 px-4 py-3.5 rounded-xl transition-all {{ request()->routeIs('profile.edit') ? 'bg-white/10 text-white font-bold border-l-4 border-purple-500 shadow-lg shadow-purple-500/5' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span>Setting</span>
                        </a>

                        <!-- Logout -->
                        <a href="{{ route('logout') }}" 
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                           class="flex items-center gap-3 text-slate-400 hover:text-rose-400 hover:bg-rose-500/10 transition-all rounded-xl px-4 py-3.5 mt-1">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            <span>Logout</span>
                        </a>
                    </div>
                </nav>
            </aside>

            <!-- MAIN WORKSPACE -->
            <div class="flex-1 flex flex-col min-h-screen overflow-hidden">
                
                <!-- TOP HEADER -->
                <header class="flex items-center justify-between px-6 lg:px-10 py-5 bg-[#0B071E]/50 border-b border-white/5 backdrop-blur-md sticky top-0 z-40">
                    
                    <!-- Hamburger / Title -->
                    <div class="flex items-center gap-4">
                        <button type="button" 
                                class="inline-flex lg:hidden items-center justify-center p-2 rounded-xl text-slate-400 hover:text-white hover:bg-white/5 focus:outline-none" 
                                @click="sidebarOpen = true">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                        <span class="text-xl font-bold text-white tracking-wide">E-Learning</span>
                    </div>

                    <!-- Search Bar in Header -->
                    <div class="hidden md:flex flex-1 max-w-md mx-6">
                        <div class="relative w-full">
                            <input type="text" 
                                   placeholder="Search anything..." 
                                   class="w-full bg-[#1A1435]/50 hover:bg-[#1A1435] text-white border border-white/10 rounded-full px-5 py-2 pl-11 text-xs focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all placeholder-slate-400">
                            <div class="absolute left-4 top-2.5">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Icons & Profile Capsule -->
                    <div class="flex items-center gap-3">
                        <!-- Extra Action Icons -->
                        <button class="p-2 rounded-full text-slate-400 hover:text-white hover:bg-white/5 transition-all hidden sm:block">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>

                        <button class="p-2 rounded-full text-slate-400 hover:text-white hover:bg-white/5 transition-all relative">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            <span class="absolute top-1.5 right-1.5 w-2 h-2 rounded-full bg-rose-500"></span>
                        </button>

                        <!-- User Profile Pill -->
                        <div class="bg-[#1A1435]/60 border border-white/10 rounded-full py-1 pl-4 pr-1 sm:pr-1 flex items-center gap-3 ml-2 hover:bg-[#1A1435] transition-all">
                            <div class="hidden sm:block text-right">
                                <p class="text-[9px] font-semibold text-slate-400 uppercase tracking-wider">Divisi / Mentor</p>
                                <p class="text-xs font-bold text-white truncate max-w-[120px]">{{ Auth::user()->name }}</p>
                            </div>
                            <div class="w-8 h-8 rounded-full bg-purple-600 border border-white/20 flex items-center justify-center font-bold text-sm text-white">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                        </div>
                    </div>
                </header>

                <!-- SCROLLABLE WORKSPACE WRAPPER -->
                <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 bg-gradient-to-br from-[#120B30] via-[#160f38] to-[#251052]">
                    <!-- Main rounded card wrapping page slots -->
                    <div class="bg-[#191338]/60 backdrop-blur-xl border border-white/10 rounded-[35px] p-6 sm:p-8 shadow-2xl min-h-full">
                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>
    </body>
</html>
