<x-mentor-layout>
    <div class="space-y-10">
        
        <!-- Welcome Header -->
        <div class="pb-4 border-b border-white/5">
            <h1 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">Hello, {{ Auth::user()->name }}!</h1>
            <p class="text-slate-400 mt-2 text-sm">Selamat datang kembali. Cek rangkuman aktivitas kelas dan tugas terbaru Anda di bawah ini.</p>
        </div>

        <!-- Premium Glassmorphic Stats Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <!-- Card 1: Kelas -->
            <div class="group bg-[#1f193f]/40 border border-white/5 hover:border-purple-500/30 rounded-2xl p-5 shadow-xl transition-all duration-300 hover:-translate-y-1 relative overflow-hidden flex items-center gap-4">
                <div class="absolute top-0 right-0 w-24 h-24 bg-purple-500/5 rounded-full blur-2xl group-hover:bg-purple-500/10 pointer-events-none transition-all"></div>
                <div class="w-12 h-12 rounded-xl bg-purple-600/10 border border-purple-500/20 text-purple-300 flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <div>
                    <span class="block text-2xl font-black text-white leading-none">{{ $totalClasses }}</span>
                    <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1.5">Total Kelas</span>
                </div>
            </div>

            <!-- Card 2: Member -->
            <div class="group bg-[#1f193f]/40 border border-white/5 hover:border-purple-500/30 rounded-2xl p-5 shadow-xl transition-all duration-300 hover:-translate-y-1 relative overflow-hidden flex items-center gap-4">
                <div class="absolute top-0 right-0 w-24 h-24 bg-purple-500/5 rounded-full blur-2xl group-hover:bg-purple-500/10 pointer-events-none transition-all"></div>
                <div class="w-12 h-12 rounded-xl bg-purple-600/10 border border-purple-500/20 text-purple-300 flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div>
                    <span class="block text-2xl font-black text-white leading-none">{{ $totalMembers }}</span>
                    <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1.5">Total Siswa</span>
                </div>
            </div>

            <!-- Card 3: Tugas Belum Dinilai -->
            <div class="group bg-[#1f193f]/40 border border-white/5 hover:border-purple-500/30 rounded-2xl p-5 shadow-xl transition-all duration-300 hover:-translate-y-1 relative overflow-hidden flex items-center gap-4">
                <div class="absolute top-0 right-0 w-24 h-24 bg-purple-500/5 rounded-full blur-2xl group-hover:bg-purple-500/10 pointer-events-none transition-all"></div>
                <div class="w-12 h-12 rounded-xl bg-purple-600/10 border border-purple-500/20 text-purple-300 flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <div>
                    <span class="block text-2xl font-black text-white leading-none">{{ $pendingGrading }}</span>
                    <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1.5">Belum Dinilai</span>
                </div>
            </div>

            <!-- Card 4: Tugas Sudah Dinilai -->
            <div class="group bg-[#1f193f]/40 border border-white/5 hover:border-purple-500/30 rounded-2xl p-5 shadow-xl transition-all duration-300 hover:-translate-y-1 relative overflow-hidden flex items-center gap-4">
                <div class="absolute top-0 right-0 w-24 h-24 bg-purple-500/5 rounded-full blur-2xl group-hover:bg-purple-500/10 pointer-events-none transition-all"></div>
                <div class="w-12 h-12 rounded-xl bg-purple-600/10 border border-purple-500/20 text-purple-300 flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <span class="block text-2xl font-black text-white leading-none">{{ $gradedCount }}</span>
                    <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1.5">Sudah Dinilai</span>
                </div>
            </div>

        </div>

        <!-- Aktivitas Section -->
        <div class="space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-white/5 pb-4">
                <h2 class="text-2xl font-bold text-white tracking-tight">Linimasa Aktivitas</h2>
                
                <!-- Sleek Filters -->
                <div class="flex items-center gap-3">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Urutkan:</span>
                    <select class="bg-[#1A1435]/60 hover:bg-[#1A1435] text-white border border-white/10 rounded-xl px-3 py-1.5 text-xs focus:outline-none cursor-pointer">
                        <option>Tipe</option>
                    </select>
                    <select class="bg-[#1A1435]/60 hover:bg-[#1A1435] text-white border border-white/10 rounded-xl px-3 py-1.5 text-xs focus:outline-none cursor-pointer">
                        <option>Tanggal</option>
                    </select>
                </div>
            </div>

            <!-- Activities Clean List -->
            <div class="space-y-4">
                @forelse ($activities as $activity)
                    <!-- Activity Row -->
                    <div class="group bg-[#1f193f]/40 border border-white/5 hover:border-purple-500/20 rounded-2xl p-4 sm:p-5 shadow-lg flex flex-col md:flex-row md:items-center justify-between gap-4 transition-all duration-300 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-purple-500/5 rounded-full blur-2xl group-hover:bg-purple-500/10 pointer-events-none transition-all"></div>
                        
                        <div class="flex items-center gap-4 relative z-10">
                            <!-- Premium Left Date Capsule -->
                            <div class="bg-purple-600/10 border border-purple-500/20 flex flex-col items-center justify-center py-2 px-3 rounded-xl min-w-[65px] flex-shrink-0">
                                <span class="text-xl font-black text-white leading-none">
                                    {{ \Carbon\Carbon::parse($activity['date'])->translatedFormat('d') }}
                                </span>
                                <span class="text-[9px] font-black text-purple-300 tracking-widest uppercase mt-0.5 leading-none">
                                    {{ strtoupper(\Carbon\Carbon::parse($activity['date'])->translatedFormat('M')) }}
                                </span>
                            </div>

                            <!-- Dynamic Icon based on type -->
                            <div class="w-10 h-10 rounded-full flex items-center justify-center bg-white/5 border border-white/10 text-purple-300 flex-shrink-0">
                                @if ($activity['type'] === 'submission')
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                @else
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                @endif
                            </div>

                            <!-- Details -->
                            <div>
                                <h4 class="text-xs font-black text-slate-400 tracking-wider uppercase leading-snug">
                                    {{ $activity['title'] }}
                                </h4>
                                <p class="text-sm font-bold text-white mt-1">
                                    {{ $activity['description'] }}
                                </p>
                            </div>
                        </div>

                        <!-- Right Detail Button -->
                        <div class="flex justify-end flex-shrink-0 relative z-10">
                            <a href="{{ $activity['detail_url'] }}" 
                               class="inline-flex items-center gap-1 bg-purple-600/15 hover:bg-purple-600 border border-purple-500/20 text-purple-300 hover:text-white font-bold py-2 px-4 rounded-xl transition-all text-xs">
                                Lihat Detail
                            </a>
                        </div>

                    </div>
                @empty
                    <div class="bg-[#1f193f]/40 border border-white/5 rounded-2xl p-12 text-center shadow-xl space-y-4">
                        <div class="w-12 h-12 rounded-full bg-purple-600/10 text-purple-400 flex items-center justify-center mx-auto border border-purple-500/20">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="max-w-md mx-auto space-y-1">
                            <p class="text-white font-bold text-sm">Belum Ada Aktivitas Terbaru</p>
                            <p class="text-slate-400 text-xs leading-relaxed">
                                Aktivitas dari siswa dan pembaruan kelas Anda akan terakumulasi otomatis di sini.
                            </p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</x-mentor-layout>
