<x-member-layout>
    <div class="py-8 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto">
        <!-- Back Navigation & Quick Info -->
        <div class="flex justify-between items-center mb-8">
            <a href="{{ route('member-materials.index') }}" 
               class="inline-flex items-center gap-2 px-4 py-2 bg-white/5 hover:bg-white/10 border border-white/10 rounded-xl font-bold text-xs text-white uppercase tracking-wider transition-all duration-150">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
                </svg>
                <span>Kembali</span>
            </a>
            <span class="text-xs text-slate-400 font-semibold tracking-wider uppercase bg-white/5 border border-white/10 px-3.5 py-1.5 rounded-full">
                Detail Modul
            </span>
        </div>

        <!-- Material Main Card -->
        <div class="bg-white/[0.03] backdrop-blur-md border border-white/10 rounded-3xl p-6 sm:p-8 shadow-2xl mb-6 relative overflow-hidden">
            <!-- Background Accent glow -->
            <div class="absolute -top-40 -right-40 w-96 h-96 bg-violet-600/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10">
                <!-- Title -->
                <h1 class="text-2xl sm:text-3xl font-black text-white leading-tight mb-6 bg-gradient-to-r from-white via-slate-200 to-slate-400 bg-clip-text text-transparent">
                    {{ $material->title }}
                </h1>

                <!-- Meta Information Capsule Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8 p-4 bg-white/[0.02] border border-white/5 rounded-2xl">
                    <div class="flex items-center text-slate-300 text-sm gap-3">
                        <div class="w-8 h-8 rounded-xl bg-violet-500/10 flex items-center justify-center text-violet-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-[10px] text-slate-500 font-bold uppercase tracking-wider">Tanggal Rilis</p>
                            <p class="font-medium text-slate-300">{{ $material->created_at->translatedFormat('d F Y') }}</p>
                        </div>
                    </div>
                    <div class="flex items-center text-slate-300 text-sm gap-3">
                        <div class="w-8 h-8 rounded-xl bg-violet-500/10 flex items-center justify-center text-violet-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-[10px] text-slate-500 font-bold uppercase tracking-wider">Waktu Unggah</p>
                            <p class="font-medium text-slate-300">{{ $material->created_at->format('H:i') }} WIB</p>
                        </div>
                    </div>
                </div>

                <!-- Description Section -->
                <div class="mb-8">
                    <h3 class="text-sm font-bold text-white uppercase tracking-wider mb-3">
                        Deskripsi Materi
                    </h3>
                    <div class="bg-white/[0.01] border border-white/5 rounded-2xl p-5 leading-relaxed text-slate-300 font-light whitespace-pre-wrap text-sm sm:text-base">
                        {{ $material->description }}
                    </div>
                </div>

                <!-- Download Card Section -->
                <div class="bg-gradient-to-tr from-violet-950/20 via-indigo-950/20 to-purple-950/20 backdrop-blur-sm border border-violet-500/20 rounded-2xl p-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl bg-violet-600/20 border border-violet-500/30 flex items-center justify-center text-violet-400 flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-white">
                                Berkas Materi Pembelajaran
                            </h3>
                            <p class="text-xs text-slate-400 mt-1">
                                Unduh untuk membaca secara offline kapan saja
                            </p>
                        </div>
                    </div>
                    
                    <a href="{{ route('member-materials.download', $material->id) }}" 
                       class="inline-flex justify-center items-center px-6 py-3 bg-purple-600 hover:bg-purple-700 border border-transparent rounded-xl font-bold text-xs text-white uppercase tracking-wider transition duration-150 shadow-md shadow-purple-900/30 gap-2 whitespace-nowrap self-stretch sm:self-auto text-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        <span>Unduh Berkas</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Additional Info Card -->
        <div class="bg-white/[0.03] backdrop-blur-md border border-white/10 rounded-3xl p-6 sm:p-8 shadow-2xl relative overflow-hidden">
            <h3 class="text-sm font-bold text-white uppercase tracking-wider mb-6">
                Metadata Modul
            </h3>
            
            <dl class="space-y-4">
                <div class="flex justify-between items-center py-1">
                    <dt class="text-sm text-slate-400">Nama Kelas</dt>
                    <dd class="text-sm text-white font-semibold">{{ $material->class->description ?? 'N/A' }}</dd>
                </div>
                <div class="flex justify-between items-center border-t border-white/[0.06] pt-4">
                    <dt class="text-sm text-slate-400 font-light">Waktu Rilis Lengkap</dt>
                    <dd class="text-sm text-white font-semibold">{{ $material->created_at->translatedFormat('d F Y H:i') }} WIB</dd>
                </div>
                <div class="flex justify-between items-center border-t border-white/[0.06] pt-4">
                    <dt class="text-sm text-slate-400 font-light">Status Ketersediaan</dt>
                    <dd>
                        <span class="inline-flex items-center gap-1.5 bg-emerald-500/10 text-emerald-300 border border-emerald-500/20 text-xs font-bold px-3 py-1 rounded-full">
                            Tersedia
                        </span>
                    </dd>
                </div>
            </dl>
        </div>
    </div>
</x-member-layout>
