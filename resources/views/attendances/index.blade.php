<x-mentor-layout>
    <div class="space-y-8">
        
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-white/5">
            <div>
                <h1 class="text-3xl font-extrabold text-white tracking-tight">Presensi & Kehadiran</h1>
                <p class="text-slate-400 mt-1 text-sm">Kelola lembar absensi siswa untuk setiap sesi pertemuan kelas.</p>
            </div>
            <div>
                <a href="{{ route('attendances.create') }}" 
                   class="inline-flex items-center gap-2 bg-purple-600 hover:bg-purple-700 text-white font-bold py-2.5 px-5 rounded-xl transition-all shadow-lg shadow-purple-500/20 text-xs uppercase tracking-wider">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Buat Lembar Presensi
                </a>
            </div>
        </div>

        <!-- Session Status Notifications -->
        @if (session('success'))
            <div class="bg-emerald-500/10 border border-emerald-500/30 text-emerald-200 p-4 rounded-2xl text-xs font-semibold shadow-xl flex items-center gap-2.5">
                <div class="w-6 h-6 rounded-full bg-emerald-500/20 text-emerald-300 flex items-center justify-center flex-shrink-0">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-rose-500/10 border border-rose-500/30 text-rose-200 p-4 rounded-2xl text-xs font-semibold shadow-xl flex items-center gap-2.5">
                <div class="w-6 h-6 rounded-full bg-rose-500/20 text-rose-300 flex items-center justify-center flex-shrink-0">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Attendance List -->
        @if ($meetings->count() > 0)
            <div class="space-y-6">
                @foreach ($meetings as $meeting)
                    <div class="group bg-[#1f193f]/40 border border-white/5 hover:border-purple-500/30 rounded-[28px] p-6 shadow-xl hover:shadow-2xl hover:shadow-purple-950/10 transition-all duration-300 relative overflow-hidden">
                        
                        <!-- Glow effect -->
                        <div class="absolute top-0 right-0 w-32 h-32 bg-purple-500/5 rounded-full blur-3xl group-hover:bg-purple-500/10 transition-all duration-300 pointer-events-none"></div>

                        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                            
                            <!-- Left: Session Title & Info -->
                            <div class="space-y-3 flex-1">
                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="px-2.5 py-1 rounded-full text-[9px] font-black tracking-wider uppercase bg-purple-500/10 text-purple-300 border border-purple-500/20">
                                        {{ $meeting->class->description ?? 'N/A' }}
                                    </span>
                                    <span class="px-2.5 py-1 rounded-full text-[9px] font-black tracking-wider uppercase bg-white/5 text-slate-300 border border-white/10 flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                        {{ $meeting->attendances->count() }} / {{ $meeting->class->members->count() }} Terisi
                                    </span>
                                </div>
                                <h3 class="text-xl font-bold text-white group-hover:text-purple-300 transition-colors">
                                    {{ $meeting->title }}
                                </h3>
                                <p class="text-slate-400 text-xs leading-relaxed max-w-2xl line-clamp-2">
                                    {{ $meeting->description ?? 'Tidak ada keterangan tambahan.' }}
                                </p>
                            </div>

                            <!-- Middle: Quick Breakdown Stats -->
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 lg:w-96 flex-shrink-0">
                                <div class="bg-emerald-500/10 border border-emerald-500/20 p-2.5 rounded-2xl text-center">
                                    <span class="block text-lg font-black text-emerald-400">{{ $meeting->getPresentCount() }}</span>
                                    <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Hadir</span>
                                </div>
                                <div class="bg-amber-500/10 border border-amber-500/20 p-2.5 rounded-2xl text-center">
                                    <span class="block text-lg font-black text-amber-400">{{ $meeting->getExcusedCount() }}</span>
                                    <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Izin</span>
                                </div>
                                <div class="bg-cyan-500/10 border border-cyan-500/20 p-2.5 rounded-2xl text-center">
                                    <span class="block text-lg font-black text-cyan-400">{{ $meeting->getSickCount() }}</span>
                                    <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Sakit</span>
                                </div>
                                <div class="bg-rose-500/10 border border-rose-500/20 p-2.5 rounded-2xl text-center">
                                    <span class="block text-lg font-black text-rose-400">{{ $meeting->getAbsentCount() }}</span>
                                    <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Alpa</span>
                                </div>
                            </div>

                            <!-- Right: Actions -->
                            <div class="flex items-center gap-2 border-t lg:border-t-0 border-white/5 pt-4 lg:pt-0 justify-end flex-shrink-0 relative z-10">
                                <a href="{{ route('attendances.show', $meeting->id) }}" 
                                   class="inline-flex items-center gap-1 bg-purple-600/15 hover:bg-purple-600 text-purple-300 hover:text-white font-bold py-2 px-3.5 rounded-xl transition-all text-xs border border-purple-500/20"
                                   title="Lihat Detail Absensi">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    Detail
                                </a>
                                <a href="{{ route('attendances.edit', $meeting->id) }}" 
                                   class="p-2 bg-white/5 hover:bg-white/10 border border-white/10 text-slate-300 hover:text-white rounded-xl transition-all"
                                   title="Edit Absensi">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                    </svg>
                                </a>
                                <form action="{{ route('attendances.destroy', $meeting->id) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus seluruh data lembar absensi untuk pertemuan ini?');"
                                      class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="p-2 bg-rose-500/10 hover:bg-rose-500 border border-rose-500/20 text-rose-300 hover:text-white rounded-xl transition-all"
                                            title="Hapus Lembar Absensi">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>

                        </div>

                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty State Card -->
            <div class="bg-[#1f193f]/40 border border-white/5 rounded-[28px] p-12 text-center shadow-xl space-y-6">
                <div class="w-16 h-16 rounded-full bg-purple-600/10 text-purple-400 flex items-center justify-center mx-auto border border-purple-500/20">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                    </svg>
                </div>
                <div class="max-w-md mx-auto space-y-2">
                    <h3 class="text-xl font-extrabold text-white">Belum Ada Rekap Absensi</h3>
                    <p class="text-slate-400 text-xs leading-relaxed">
                        Anda belum membuat rekap presensi kelas atau mengabsen siswa. Mulai dengan membuat lembar absensi baru berdasarkan sesi pertemuan aktif.
                    </p>
                </div>
                <a href="{{ route('attendances.create') }}" 
                   class="inline-flex items-center gap-2 bg-purple-600 hover:bg-purple-700 text-white font-bold py-2.5 px-6 rounded-xl transition-all shadow-lg shadow-purple-500/20 text-xs uppercase tracking-wider">
                    Buat Absensi Pertama
                </a>
            </div>
        @endif

    </div>
</x-mentor-layout>