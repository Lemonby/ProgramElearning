<x-member-layout>
    <div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-black text-white tracking-tight bg-gradient-to-r from-white via-slate-200 to-slate-400 bg-clip-text text-transparent">
                    Kumpul Tugas
                </h1>
                <p class="text-sm text-slate-400 mt-1.5 font-medium tracking-wide">Pantau tenggat waktu dan kumpulkan tugas Anda secara terjadwal</p>
            </div>
            <!-- Total Tasks Badge -->
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/[0.04] border border-white/10 rounded-full text-slate-200 text-xs font-bold self-start md:self-auto backdrop-blur-md">
                <span class="w-2.5 h-2.5 rounded-full bg-indigo-500"></span>
                <span>{{ $assignments->count() }} Tugas Ditemukan</span>
            </div>
        </div>

        <!-- Success/Error Messages -->
        @if (session('success'))
            <div class="mb-6 p-4 bg-emerald-500/10 backdrop-blur-md border border-emerald-500/20 rounded-2xl text-emerald-300 flex items-center gap-3 shadow-lg">
                <svg class="w-6 h-6 flex-shrink-0 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="text-sm font-semibold tracking-wide">{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 p-4 bg-rose-500/10 backdrop-blur-md border border-rose-500/20 rounded-2xl text-rose-300 flex items-center gap-3 shadow-lg">
                <svg class="w-6 h-6 flex-shrink-0 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
                <span class="text-sm font-semibold tracking-wide">{{ session('error') }}</span>
            </div>
        @endif

        @if (session('info'))
            <div class="mb-6 p-4 bg-blue-500/10 backdrop-blur-md border border-blue-500/20 rounded-2xl text-blue-300 flex items-center gap-3 shadow-lg">
                <svg class="w-6 h-6 flex-shrink-0 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="text-sm font-semibold tracking-wide">{{ session('info') }}</span>
            </div>
        @endif

        <!-- Assignments Grid -->
        @if ($assignments->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($assignments as $assignment)
                    <div class="bg-white/[0.03] backdrop-blur-md border border-white/10 rounded-3xl shadow-xl overflow-hidden hover:bg-white/[0.06] hover:border-violet-500/30 hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-between group">
                        <!-- Card Banner (Header) -->
                        <div class="bg-purple-600 px-6 py-5 relative overflow-hidden">
                            <div class="absolute -right-6 -bottom-6 w-20 h-20 bg-white/10 rounded-full blur-xl pointer-events-none"></div>
                            <h3 class="text-white font-bold text-lg truncate relative z-10 group-hover:text-purple-200 transition-colors">
                                {{ $assignment->title }}
                            </h3>
                            <p class="text-purple-200 text-xs font-semibold mt-1.5 relative z-10">
                                Kelas: <strong class="bg-white/10 px-2 py-0.5 rounded ml-1">{{ $assignment->class->name ?? 'N/A' }}</strong>
                            </p>
                        </div>

                        <!-- Card Content -->
                        <div class="p-6 flex flex-col justify-between flex-1">
                            <div>
                                <p class="text-slate-400 text-sm line-clamp-3 mb-6 leading-relaxed font-light">
                                    {{ $assignment->description }}
                                </p>

                                <!-- Meta Info List -->
                                <div class="space-y-3.5 text-sm mb-6 border-b border-white/[0.06] pb-6">
                                    <!-- Deadline -->
                                    <div class="flex items-center justify-between">
                                        <span class="text-slate-400 flex items-center gap-2">
                                            <svg class="w-4 h-4 text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <span>Deadline</span>
                                        </span>
                                        <span class="font-bold text-slate-200">
                                            {{ $assignment->deadline->translatedFormat('d M Y H:i') }}
                                        </span>
                                    </div>

                                    <!-- Time Left -->
                                    @php
                                        $now = \Carbon\Carbon::now();
                                        $deadline = $assignment->deadline;
                                        $isOverdue = $now > $deadline;
                                        $daysLeft = (int) round($now->diffInDays($deadline));
                                    @endphp
                                    <div class="flex items-center justify-between">
                                        <span class="text-slate-400 flex items-center gap-2">
                                            <svg class="w-4 h-4 text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span>Sisa Waktu</span>
                                        </span>
                                        <span class="font-bold">
                                            @if ($isOverdue)
                                                <span class="inline-flex items-center bg-rose-500/10 text-rose-300 border border-rose-500/20 text-xs px-2.5 py-1 rounded-lg">
                                                    Terlambat {{ $daysLeft }} hari
                                                </span>
                                            @else
                                                <span class="inline-flex items-center bg-emerald-500/10 text-emerald-300 border border-emerald-500/20 text-xs px-2.5 py-1 rounded-lg">
                                                    {{ $daysLeft }} hari lagi
                                                </span>
                                            @endif
                                        </span>
                                    </div>

                                    <!-- Submission Status -->
                                    @php
                                        $userSubmission = $assignment->submissions()
                                            ->where('member_id', auth()->id())
                                            ->first();
                                    @endphp
                                    <div class="flex items-center justify-between">
                                        <span class="text-slate-400 flex items-center gap-2">
                                            <svg class="w-4 h-4 text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span>Status</span>
                                        </span>
                                        @if ($userSubmission)
                                            <span class="inline-flex items-center gap-1 bg-emerald-500/10 text-emerald-300 border border-emerald-500/20 px-3 py-1 rounded-full text-xs font-bold">
                                                Sudah Dikumpulkan
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 bg-amber-500/10 text-amber-300 border border-amber-500/20 px-3 py-1 rounded-full text-xs font-bold">
                                                Belum Dikumpulkan
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex gap-3 mt-4">
                                @if ($userSubmission)
                                    <a href="{{ route('submissions.show', $userSubmission->id) }}"
                                       class="flex-1 bg-white/5 hover:bg-white/10 border border-white/10 text-white font-bold py-2.5 px-4 rounded-xl transition-all duration-150 text-xs text-center flex items-center justify-center gap-1.5">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        <span>Detail</span>
                                    </a>
                                    <a href="{{ route('submissions.edit', $userSubmission->id) }}"
                                       class="flex-1 bg-purple-600 hover:bg-purple-700 text-white font-bold py-2.5 px-4 rounded-xl transition-all duration-150 text-xs text-center flex items-center justify-center gap-1.5 shadow-md shadow-purple-900/20">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        <span>Ubah</span>
                                    </a>
                                @else
                                    <a href="{{ route('submissions.create', $assignment->id) }}"
                                       class="flex-1 bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-4 rounded-xl transition-all duration-150 text-xs text-center flex items-center justify-center gap-1.5 shadow-md shadow-purple-900/30">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                        </svg>
                                        <span>Kumpulkan Tugas</span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white/[0.02] backdrop-blur-md border border-white/10 rounded-3xl p-12 text-center shadow-xl max-w-xl mx-auto">
                <div class="w-16 h-16 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-slate-400 mx-auto mb-5">
                    <svg class="h-8 w-8 text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0V9a2 2 0 00-2-2H6a2 2 0 00-2 2v4"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-white mb-2">
                    Tidak Ada Tugas
                </h3>
                <p class="text-sm text-slate-400 leading-relaxed max-w-sm mx-auto">
                    Tidak ada tugas yang diberikan atau tersedia untuk kelas Anda saat ini.
                </p>
            </div>
        @endif
    </div>
</x-member-layout>
