<x-mentor-layout>
    <div class="space-y-8">
        
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-white/5">
            <div>
                <h1 class="text-3xl font-extrabold text-white tracking-tight">Detail Presensi Kelas</h1>
                <p class="text-slate-400 mt-1 text-sm">Lihat ringkasan dan status kehadiran siswa untuk pertemuan ini.</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('attendances.edit', $meeting->id) }}" 
                   class="inline-flex items-center gap-2 bg-purple-600 hover:bg-purple-700 text-white font-bold py-2.5 px-5 rounded-xl transition-all shadow-lg shadow-purple-500/20 text-xs uppercase tracking-wider">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                    </svg>
                    Edit Absensi
                </a>
                <a href="{{ route('attendances.index') }}" 
                   class="inline-flex items-center gap-2 bg-white/5 hover:bg-white/10 border border-white/10 text-slate-300 hover:text-white font-bold py-2.5 px-5 rounded-xl transition-all text-xs uppercase tracking-wider">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Left: Meeting Info (Span 1) -->
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-[#1f193f]/40 border border-white/5 rounded-[28px] p-6 shadow-xl relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-purple-500/5 rounded-full blur-3xl"></div>
                    
                    <h3 class="text-lg font-bold text-white mb-4 flex items-center gap-2 border-b border-white/5 pb-3">
                        <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Informasi Pertemuan
                    </h3>
                    
                    <div class="space-y-4">
                        <div>
                            <span class="text-slate-400 text-[10px] font-black uppercase tracking-wider">Judul Pertemuan</span>
                            <p class="font-extrabold text-white text-base mt-0.5 leading-snug">{{ $meeting->title }}</p>
                        </div>
                        <div>
                            <span class="text-slate-400 text-[10px] font-black uppercase tracking-wider">Kelas</span>
                            <p class="font-bold text-purple-300 text-sm mt-0.5">{{ $meeting->class->description ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <span class="text-slate-400 text-[10px] font-black uppercase tracking-wider">Jadwal Sesi</span>
                            <p class="text-slate-300 text-xs mt-0.5 flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                {{ $meeting->meeting_date }} &bull; {{ $meeting->meeting_time }} WIB
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Summary Breakdown Stats Widget -->
                <div class="bg-[#1f193f]/40 border border-white/5 rounded-[28px] p-6 shadow-xl relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-purple-500/5 rounded-full blur-3xl"></div>
                    
                    <h3 class="text-lg font-bold text-white mb-4 flex items-center gap-2 border-b border-white/5 pb-3">
                        <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        Ringkasan Kehadiran
                    </h3>

                    <div class="grid grid-cols-2 gap-3">
                        <div class="bg-emerald-500/10 border border-emerald-500/20 p-4 rounded-2xl text-center">
                            <span class="block text-2xl font-black text-emerald-400 leading-none mb-1">{{ $meeting->getPresentCount() }}</span>
                            <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Hadir</span>
                        </div>
                        <div class="bg-amber-500/10 border border-amber-500/20 p-4 rounded-2xl text-center">
                            <span class="block text-2xl font-black text-amber-400 leading-none mb-1">{{ $meeting->getExcusedCount() }}</span>
                            <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Izin</span>
                        </div>
                        <div class="bg-cyan-500/10 border border-cyan-500/20 p-4 rounded-2xl text-center">
                            <span class="block text-2xl font-black text-cyan-400 leading-none mb-1">{{ $meeting->getSickCount() }}</span>
                            <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Sakit</span>
                        </div>
                        <div class="bg-rose-500/10 border border-rose-500/20 p-4 rounded-2xl text-center">
                            <span class="block text-2xl font-black text-rose-400 leading-none mb-1">{{ $meeting->getAbsentCount() }}</span>
                            <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Alpa</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Attendance Roster (Span 2) -->
            <div class="lg:col-span-2">
                <div class="bg-[#1f193f]/40 border border-white/5 rounded-[28px] p-6 sm:p-8 shadow-xl relative overflow-hidden h-full flex flex-col">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-purple-500/5 rounded-full blur-3xl"></div>
                    
                    <h3 class="text-xl font-bold text-white mb-6 border-b border-white/5 pb-4 relative z-10">
                        Daftar Kehadiran Siswa
                    </h3>

                    @if ($meeting->attendances->count() > 0)
                        <div class="overflow-x-auto relative z-10 flex-1">
                            <table class="w-full text-sm text-left">
                                <thead>
                                    <tr class="border-b border-white/5 text-slate-400 text-xs font-black uppercase tracking-wider">
                                        <th class="pb-3 pl-2">No</th>
                                        <th class="pb-3">Nama Siswa</th>
                                        <th class="pb-3">Status</th>
                                        <th class="pb-3 hidden sm:table-cell">Dicatat Oleh</th>
                                        <th class="pb-3 text-right pr-2">Waktu Input</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-white/5">
                                    @foreach ($meeting->attendances as $index => $attendance)
                                        <tr class="hover:bg-white/5 transition-colors">
                                            <td class="py-4 pl-2 font-bold text-slate-500">{{ $index + 1 }}</td>
                                            <td class="py-4 font-bold text-white">
                                                <div class="flex items-center gap-3">
                                                    <span class="w-7 h-7 rounded-full bg-purple-600/10 border border-purple-500/20 text-purple-300 flex items-center justify-center text-[10px] font-black">
                                                        {{ substr($attendance->member->name, 0, 1) }}
                                                    </span>
                                                    <span>{{ $attendance->member->name }}</span>
                                                </div>
                                            </td>
                                            <td class="py-4">
                                                @php
                                                    $statusStyles = [
                                                        'hadir' => 'bg-emerald-500/20 text-emerald-300 border-emerald-500/30',
                                                        'izin' => 'bg-amber-500/20 text-amber-300 border-amber-500/30',
                                                        'sakit' => 'bg-cyan-500/20 text-cyan-300 border-cyan-500/30',
                                                        'alpa' => 'bg-rose-500/20 text-rose-300 border-rose-500/30',
                                                    ];
                                                    $statusLabels = [
                                                        'hadir' => 'Hadir',
                                                        'izin' => 'Izin',
                                                        'sakit' => 'Sakit',
                                                        'alpa' => 'Alpa',
                                                    ];
                                                @endphp
                                                <span class="px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-wider border {{ $statusStyles[$attendance->status] ?? 'bg-white/5 text-slate-300 border-white/10' }}">
                                                    {{ $statusLabels[$attendance->status] ?? $attendance->status }}
                                                </span>
                                            </td>
                                            <td class="py-4 text-slate-400 text-xs hidden sm:table-cell">
                                                {{ $attendance->inputBy->name ?? 'System' }}
                                            </td>
                                            <td class="py-4 text-slate-400 text-[11px] text-right pr-2">
                                                {{ $attendance->created_at->format('d/m/Y H:i') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-16 bg-[#1f193f]/20 border border-white/5 rounded-2xl relative z-10 flex-1 flex flex-col items-center justify-center space-y-4">
                            <div class="w-12 h-12 rounded-full bg-purple-600/10 text-purple-400 flex items-center justify-center border border-purple-500/20">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="space-y-1">
                                <p class="text-white font-bold text-sm">Belum Ada Kehadiran</p>
                                <p class="text-slate-400 text-xs max-w-xs leading-relaxed">
                                    Belum ada data kehadiran siswa yang tercatat untuk pertemuan sesi ini.
                                </p>
                            </div>
                            <a href="{{ route('attendances.edit', $meeting->id) }}" 
                               class="inline-flex items-center gap-1.5 bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded-xl transition-all text-xs uppercase tracking-wider">
                                Catat Sekarang
                            </a>
                        </div>
                    @endif

                </div>
            </div>

        </div>

    </div>
</x-mentor-layout>