<x-member-layout>
    <div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        <!-- Warning Alert if user has no class -->
        @if (isset($warning))
            <div class="mb-6 p-4 bg-amber-500/10 backdrop-blur-md border border-amber-500/20 rounded-2xl text-amber-300 flex items-center gap-3 shadow-lg">
                <svg class="w-6 h-6 flex-shrink-0 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
                <span class="text-sm font-semibold tracking-wide">{{ $warning }}</span>
            </div>
        @endif

        <!-- Header -->
        <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-black text-white tracking-tight bg-gradient-to-r from-white via-slate-200 to-slate-400 bg-clip-text text-transparent">
                    Riwayat Kehadiran
                </h1>
                <p class="text-sm text-slate-400 mt-1.5 font-medium tracking-wide">Rekap kehadiran Anda di setiap pertemuan kelas</p>
            </div>
            <!-- Glassy pill to indicate total attendance rate -->
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/[0.04] border border-white/10 rounded-full text-slate-200 text-xs font-bold self-start md:self-auto backdrop-blur-md">
                <span>Kelas Aktif</span>
            </div>
        </div>

        <!-- Summary Cards Grid -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-5 mb-8">
            <!-- Percentage Card -->
            <div class="col-span-2 md:col-span-3 lg:col-span-1 bg-gradient-to-br from-violet-600 via-indigo-600 to-purple-600 text-white p-6 rounded-2xl shadow-xl flex flex-col justify-between items-center text-center transition-all duration-300 hover:shadow-violet-900/20 hover:-translate-y-1 group relative overflow-hidden">
                <div class="absolute -right-6 -bottom-6 w-20 h-20 bg-white/10 rounded-full blur-xl transition-all duration-500 group-hover:scale-150"></div>
                <div class="my-auto relative z-10">
                    <p class="text-5xl font-black tracking-tight group-hover:scale-105 transition-transform duration-300">{{ $stats['percentage'] }}%</p>
                    <p class="text-[10px] font-bold text-violet-100 uppercase tracking-widest mt-2">Rasio Kehadiran</p>
                </div>
            </div>

            <!-- Hadir Card -->
            <div class="bg-white/[0.03] backdrop-blur-md border border-white/10 p-6 rounded-2xl shadow-lg flex flex-col justify-between items-center text-center transition-all duration-300 hover:bg-white/[0.06] hover:border-emerald-500/30 hover:-translate-y-1 group">
                <div class="my-auto">
                    <p class="text-4xl font-black text-emerald-400 group-hover:scale-105 transition-transform duration-300">{{ $stats['hadir'] }}</p>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-2 group-hover:text-emerald-300 transition-colors">Hadir</p>
                </div>
            </div>

            <!-- Izin Card -->
            <div class="bg-white/[0.03] backdrop-blur-md border border-white/10 p-6 rounded-2xl shadow-lg flex flex-col justify-between items-center text-center transition-all duration-300 hover:bg-white/[0.06] hover:border-blue-500/30 hover:-translate-y-1 group">
                <div class="my-auto">
                    <p class="text-4xl font-black text-blue-400 group-hover:scale-105 transition-transform duration-300">{{ $stats['izin'] }}</p>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-2 group-hover:text-blue-300 transition-colors">Izin</p>
                </div>
            </div>

            <!-- Sakit Card -->
            <div class="bg-white/[0.03] backdrop-blur-md border border-white/10 p-6 rounded-2xl shadow-lg flex flex-col justify-between items-center text-center transition-all duration-300 hover:bg-white/[0.06] hover:border-amber-500/30 hover:-translate-y-1 group">
                <div class="my-auto">
                    <p class="text-4xl font-black text-amber-400 group-hover:scale-105 transition-transform duration-300">{{ $stats['sakit'] }}</p>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-2 group-hover:text-amber-300 transition-colors">Sakit</p>
                </div>
            </div>

            <!-- Alpha Card -->
            <div class="bg-white/[0.03] backdrop-blur-md border border-white/10 p-6 rounded-2xl shadow-lg flex flex-col justify-between items-center text-center transition-all duration-300 hover:bg-white/[0.06] hover:border-rose-500/30 hover:-translate-y-1 group">
                <div class="my-auto">
                    <p class="text-4xl font-black text-rose-400 group-hover:scale-105 transition-transform duration-300">{{ $stats['alpa'] }}</p>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-2 group-hover:text-rose-300 transition-colors">Alpha</p>
                </div>
            </div>
        </div>

        <!-- Detail per Pertemuan -->
        <div class="bg-white/[0.02] backdrop-blur-lg border border-white/10 rounded-2xl shadow-2xl overflow-hidden">
            <div class="px-6 py-5 border-b border-white/10 bg-white/[0.01] flex items-center justify-between">
                <h2 class="text-lg font-bold text-white tracking-wide">Detail per Pertemuan</h2>
                <span class="text-xs text-slate-400 font-semibold">{{ $meetings->count() }} Total Pertemuan</span>
            </div>
            
            <div class="overflow-x-auto">
                @if ($meetings->count() > 0)
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-white/[0.02] border-b border-white/10">
                                <th class="py-4 px-6 text-xs font-bold text-slate-300 uppercase tracking-wider">Pertemuan</th>
                                <th class="py-4 px-6 text-xs font-bold text-slate-300 uppercase tracking-wider">Topik</th>
                                <th class="py-4 px-6 text-xs font-bold text-slate-300 uppercase tracking-wider">Tanggal</th>
                                <th class="py-4 px-6 text-xs font-bold text-slate-300 uppercase tracking-wider">Tipe</th>
                                <th class="py-4 px-6 text-xs font-bold text-slate-300 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/[0.05]">
                            @foreach ($meetings as $index => $meeting)
                                <tr class="hover:bg-white/[0.02] transition-colors duration-150 group">
                                    <!-- Pertemuan -->
                                    <td class="py-4 px-6 whitespace-nowrap">
                                        <span class="inline-block bg-white/10 border border-white/10 text-slate-200 font-bold text-xs px-3 py-1 rounded-lg">
                                            Ke-{{ $index + 1 }}
                                        </span>
                                    </td>
                                    
                                    <!-- Topik -->
                                    <td class="py-4 px-6">
                                        <div class="text-sm font-semibold text-white leading-snug group-hover:text-violet-300 transition-colors">
                                            {{ $meeting->title }}
                                        </div>
                                        @if ($meeting->description)
                                            <div class="text-xs text-slate-400 mt-1 line-clamp-1">
                                                {{ $meeting->description }}
                                            </div>
                                        @endif
                                    </td>
                                    
                                    <!-- Tanggal -->
                                    <td class="py-4 px-6 whitespace-nowrap">
                                        <span class="text-sm font-medium text-slate-300">
                                            {{ \Carbon\Carbon::parse($meeting->meeting_date)->translatedFormat('d M Y') }}
                                        </span>
                                    </td>
                                    
                                    <!-- Tipe -->
                                    <td class="py-4 px-6 whitespace-nowrap">
                                        @if (strtolower($meeting->type) === 'online')
                                            <span class="inline-flex items-center bg-emerald-500/10 text-emerald-300 border border-emerald-500/20 text-xs font-bold px-3 py-1 rounded-lg">
                                                Online
                                            </span>
                                        @else
                                            <span class="inline-flex items-center bg-amber-500/10 text-amber-300 border border-amber-500/20 text-xs font-bold px-3 py-1 rounded-lg">
                                                Offline
                                            </span>
                                        @endif
                                    </td>
                                    
                                    <!-- Status -->
                                    <td class="py-4 px-6 whitespace-nowrap">
                                        @php
                                            $attendance = $meeting->attendances->first();
                                        @endphp
                                        @if ($attendance)
                                            @switch(strtolower($attendance->status))
                                                @case('hadir')
                                                    <span class="inline-flex items-center gap-1.5 bg-emerald-500/10 text-emerald-300 border border-emerald-500/20 text-xs font-extrabold px-3.5 py-1.5 rounded-full">
                                                        Hadir
                                                    </span>
                                                    @break
                                                @case('izin')
                                                    <span class="inline-flex items-center gap-1.5 bg-blue-500/10 text-blue-300 border border-blue-500/20 text-xs font-extrabold px-3.5 py-1.5 rounded-full">
                                                        Izin
                                                    </span>
                                                    @break
                                                @case('sakit')
                                                    <span class="inline-flex items-center gap-1.5 bg-amber-500/10 text-amber-300 border border-amber-500/20 text-xs font-extrabold px-3.5 py-1.5 rounded-full">
                                                        Sakit
                                                    </span>
                                                    @break
                                                @case('alpa')
                                                    <span class="inline-flex items-center gap-1.5 bg-rose-500/10 text-rose-300 border border-rose-500/20 text-xs font-extrabold px-3.5 py-1.5 rounded-full">
                                                        Alpha
                                                    </span>
                                                    @break
                                                @default
                                                    <span class="inline-flex items-center gap-1.5 bg-white/5 text-slate-300 border border-white/10 text-xs font-extrabold px-3.5 py-1.5 rounded-full">
                                                        {{ ucfirst($attendance->status) }}
                                                    </span>
                                            @endswitch
                                        @else
                                            <span class="inline-flex items-center gap-1.5 bg-white/5 text-slate-400 border border-white/10 text-xs font-extrabold px-3.5 py-1.5 rounded-full">
                                                Belum Diabsen
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="py-16 text-center">
                        <svg class="mx-auto h-12 w-12 text-slate-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <h3 class="text-sm font-bold text-slate-300 mb-1">Tidak ada pertemuan</h3>
                        <p class="text-xs text-slate-500">Belum ada daftar pertemuan yang dijadwalkan untuk kelas Anda.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-member-layout>
