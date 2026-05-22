<x-member-layout>
    <div class="py-8 px-4 sm:px-6 lg:px-8 max-w-5xl mx-auto space-y-8">
        
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-white/5">
            <div>
                <h1 class="text-3xl font-extrabold text-white tracking-tight">Riwayat Kehadiran Saya</h1>
                <p class="text-slate-400 mt-1 text-sm">Pantau status kehadiran dan persentase absensi Anda sepanjang program pembelajaran.</p>
            </div>
            <span class="text-xs text-slate-400 font-semibold tracking-wider uppercase bg-white/5 border border-white/10 px-3.5 py-1.5 rounded-full self-start sm:self-auto">
                Absensi Siswa
            </span>
        </div>

        @if($attendances->count() > 0)
            <!-- Main Grid Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                
                <!-- Left: Stats Ringkasan Widget (Span 1) -->
                <div class="lg:col-span-1 space-y-4">
                    <div class="bg-white/[0.03] backdrop-blur-md border border-white/10 rounded-3xl p-6 shadow-2xl relative overflow-hidden">
                        <div class="absolute -top-16 -right-16 w-32 h-32 bg-violet-600/10 rounded-full blur-2xl pointer-events-none"></div>
                        
                        <h3 class="text-sm font-bold text-white uppercase tracking-wider mb-4 border-b border-white/5 pb-2">
                            Ringkasan Kehadiran
                        </h3>
                        
                        <div class="grid grid-cols-2 gap-3">
                            <div class="bg-emerald-500/10 border border-emerald-500/20 p-3 rounded-2xl text-center">
                                <span class="block text-xl font-black text-emerald-400 leading-none mb-1">
                                    {{ $attendances->where('status', 'hadir')->count() }}
                                </span>
                                <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Hadir</span>
                            </div>
                            <div class="bg-amber-500/10 border border-amber-500/20 p-3 rounded-2xl text-center">
                                <span class="block text-xl font-black text-amber-400 leading-none mb-1">
                                    {{ $attendances->where('status', 'izin')->count() }}
                                </span>
                                <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Izin</span>
                            </div>
                            <div class="bg-cyan-500/10 border border-cyan-500/20 p-3 rounded-2xl text-center">
                                <span class="block text-xl font-black text-cyan-400 leading-none mb-1">
                                    {{ $attendances->where('status', 'sakit')->count() }}
                                </span>
                                <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Sakit</span>
                            </div>
                            <div class="bg-rose-500/10 border border-rose-500/20 p-3 rounded-2xl text-center">
                                <span class="block text-xl font-black text-rose-400 leading-none mb-1">
                                    {{ $attendances->where('status', 'alpa')->count() }}
                                </span>
                                <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Alpa</span>
                            </div>
                        </div>

                        <!-- Optional Attendance Percentage calculation -->
                        @php
                            $totalSessions = $attendances->count();
                            $presentSessions = $attendances->where('status', 'hadir')->count();
                            $attendanceRate = $totalSessions > 0 ? round(($presentSessions / $totalSessions) * 100) : 0;
                        @endphp
                        <div class="mt-6 pt-4 border-t border-white/5 space-y-2">
                            <div class="flex justify-between text-xs font-semibold">
                                <span class="text-slate-400">Rasio Kehadiran</span>
                                <span class="text-purple-300 font-black">{{ $attendanceRate }}%</span>
                            </div>
                            <div class="w-full bg-white/5 border border-white/10 h-2 rounded-full overflow-hidden">
                                <div class="bg-gradient-to-r from-violet-500 to-fuchsia-500 h-full rounded-full" style="width: {{ $attendanceRate }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Detailed Logs Table (Span 3) -->
                <div class="lg:col-span-3">
                    <div class="bg-white/[0.03] backdrop-blur-md border border-white/10 rounded-3xl p-6 sm:p-8 shadow-2xl relative overflow-hidden h-full flex flex-col justify-between">
                        <div class="absolute -top-32 -right-32 w-64 h-64 bg-violet-600/10 rounded-full blur-3xl pointer-events-none"></div>
                        
                        <div class="space-y-6 relative z-10">
                            <h3 class="text-base font-bold text-white uppercase tracking-wider border-b border-white/5 pb-3">
                                Rincian Log Pertemuan
                            </h3>

                            <div class="overflow-x-auto">
                                <table class="w-full text-sm text-left">
                                    <thead>
                                        <tr class="border-b border-white/5 text-slate-400 text-xs font-black uppercase tracking-wider">
                                            <th class="pb-3 pl-2">No</th>
                                            <th class="pb-3">Judul Pertemuan</th>
                                            <th class="pb-3">Kelas</th>
                                            <th class="pb-3">Status</th>
                                            <th class="pb-3 hidden md:table-cell">Dicatat Oleh</th>
                                            <th class="pb-3 text-right pr-2">Tanggal</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-white/5">
                                        @foreach ($attendances as $index => $attendance)
                                            <tr class="hover:bg-white/5 transition-colors">
                                                <td class="py-4 pl-2 font-bold text-slate-500">{{ $index + 1 }}</td>
                                                <td class="py-4 font-bold text-white leading-snug">
                                                    {{ $attendance->meeting->title }}
                                                </td>
                                                <td class="py-4 text-purple-300 text-xs font-semibold">
                                                    {{ $attendance->meeting->class->description ?? 'N/A' }}
                                                </td>
                                                <td class="py-4">
                                                    @php
                                                        $statusColors = [
                                                            'hadir' => 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30',
                                                            'izin' => 'bg-amber-500/20 text-amber-300 border border-amber-500/30',
                                                            'sakit' => 'bg-cyan-500/20 text-cyan-300 border border-cyan-500/30',
                                                            'alpa' => 'bg-rose-500/20 text-rose-300 border border-rose-500/30',
                                                        ];
                                                        $statusLabels = [
                                                            'hadir' => 'Hadir',
                                                            'izin' => 'Izin',
                                                            'sakit' => 'Sakit',
                                                            'alpa' => 'Alpa',
                                                        ];
                                                    @endphp
                                                    <span class="inline-flex px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-wider {{ $statusColors[$attendance->status] ?? 'bg-white/5 text-slate-300' }}">
                                                        {{ $statusLabels[$attendance->status] ?? $attendance->status }}
                                                    </span>
                                                </td>
                                                <td class="py-4 text-slate-400 text-xs hidden md:table-cell">
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
                        </div>
                    </div>
                </div>

            </div>
        @else
            <!-- Empty State Card -->
            <div class="bg-white/[0.03] backdrop-blur-md border border-white/10 rounded-3xl p-16 text-center shadow-2xl space-y-6">
                <div class="w-16 h-16 rounded-full bg-violet-600/10 text-violet-400 flex items-center justify-center mx-auto border border-violet-500/20">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                    </svg>
                </div>
                <div class="max-w-md mx-auto space-y-2">
                    <h3 class="text-xl font-extrabold text-white">Belum Ada Riwayat Presensi</h3>
                    <p class="text-slate-400 text-xs leading-relaxed">
                        Data riwayat kehadiran Anda di kelas belum tercatat. Hubungi mentor atau admin untuk info pencatatan kehadiran.
                    </p>
                </div>
            </div>
        @endif

    </div>
</x-member-layout>