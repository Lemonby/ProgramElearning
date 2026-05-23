<x-member-layout>
    <div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-black text-white tracking-tight">
                    Materi Pembelajaran
                </h1>
                <p class="text-sm text-slate-400 mt-1.5 font-medium tracking-wide">Akses modul, slide, dan bahan ajar yang dibagikan oleh mentor</p>
            </div>
            <!-- Total Materials Badge -->
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/[0.04] border border-white/10 rounded-full text-slate-200 text-xs font-bold self-start md:self-auto backdrop-blur-md">
                <span class="w-2.5 h-2.5 rounded-full bg-violet-500"></span>
                <span>{{ $materials->count() }} Modul Tersedia</span>
            </div>
        </div>

        <!-- Materials Grid -->
        @if ($materials->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($materials as $material)
                    <div class="bg-white/[0.03] backdrop-blur-md border border-white/10 rounded-3xl p-6 shadow-xl hover:bg-white/[0.06] hover:border-violet-500/30 hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-between group">
                        <div>
                            <!-- Material Premium Icon Banner -->
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-10 h-10 rounded-2xl bg-violet-600 flex items-center justify-center text-white shadow-lg shadow-violet-900/30 group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                </div>
                                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 bg-white/5 border border-white/10 px-2.5 py-1 rounded-full group-hover:bg-violet-500/10 group-hover:text-violet-300 transition-colors">
                                    Modul Ajar
                                </span>
                            </div>

                            <!-- Material Title -->
                            <h3 class="text-lg font-bold text-white leading-snug group-hover:text-violet-300 transition-colors line-clamp-2">
                                {{ $material->title }}
                            </h3>

                            <!-- Material Description -->
                            <p class="text-sm text-slate-400 line-clamp-3 mt-3.5 leading-relaxed font-light">
                                {{ $material->description }}
                            </p>
                        </div>

                        <div>
                            <!-- Material Date -->
                            <div class="text-xs text-slate-400 mt-5 pb-5 border-b border-white/[0.06] flex items-center gap-2">
                                <svg class="w-4 h-4 text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span>{{ $material->created_at->translatedFormat('d F Y H:i') }}</span>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex gap-3 mt-5">
                                <a href="{{ route('member-materials.show', $material->id) }}" 
                                   class="flex-1 inline-flex justify-center items-center px-4 py-2.5 bg-purple-600 hover:bg-purple-700 border border-transparent rounded-xl font-bold text-xs text-white uppercase tracking-wider transition duration-150 shadow-md shadow-purple-900/20 group-hover:shadow-purple-900/40 gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    <span>Detail</span>
                                </a>
                                <a href="{{ route('member-materials.download', $material->id) }}" 
                                   class="flex-1 inline-flex justify-center items-center px-4 py-2.5 bg-white/5 hover:bg-white/10 border border-white/10 rounded-xl font-bold text-xs text-white uppercase tracking-wider transition duration-150 gap-2">
                                    <svg class="w-4 h-4 text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                    </svg>
                                    <span>Download</span>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white/[0.02] backdrop-blur-md border border-white/10 rounded-3xl p-12 text-center shadow-xl max-w-xl mx-auto">
                <div class="w-16 h-16 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-slate-400 mx-auto mb-5">
                    <svg class="h-8 w-8 text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-white mb-2">
                    Belum Ada Materi
                </h3>
                <p class="text-sm text-slate-400 leading-relaxed max-w-sm mx-auto">
                    Materi pembelajaran akan ditampilkan di sini setelah mentor kelas mengunggahnya.
                </p>
            </div>
        @endif
    </div>
</x-member-layout>
