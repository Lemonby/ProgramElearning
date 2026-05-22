<x-member-layout>
    <div class="py-8 px-4 sm:px-6 lg:px-8 max-w-3xl mx-auto">
        <!-- Back Navigation & Quick Info -->
        <div class="flex justify-between items-center mb-8">
            <a href="{{ route('submissions.index') }}" 
               class="inline-flex items-center gap-2 px-4 py-2 bg-white/5 hover:bg-white/10 border border-white/10 rounded-xl font-bold text-xs text-white uppercase tracking-wider transition-all duration-150">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
                </svg>
                <span>Kembali</span>
            </a>
            <span class="text-xs text-slate-400 font-semibold tracking-wider uppercase bg-white/5 border border-white/10 px-3.5 py-1.5 rounded-full">
                Detail Submission
            </span>
        </div>

        <div class="bg-white/[0.03] backdrop-blur-md border border-white/10 rounded-3xl shadow-2xl overflow-hidden relative">
            <!-- Background Accent glow -->
            <div class="absolute -top-40 -right-40 w-96 h-96 bg-violet-600/10 rounded-full blur-3xl pointer-events-none"></div>

            <!-- Card Banner Header -->
            <div class="bg-gradient-to-r from-violet-600 via-indigo-600 to-purple-600 px-6 sm:px-8 py-6 relative overflow-hidden shadow-lg">
                <div class="absolute -right-6 -bottom-6 w-20 h-20 bg-white/10 rounded-full blur-xl pointer-events-none"></div>
                <h3 class="text-xl sm:text-2xl font-black text-white relative z-10 leading-tight">
                    {{ $submission->assignment->title }}
                </h3>
                <p class="text-violet-100 text-xs font-semibold mt-2 relative z-10">
                    Kelas: <strong class="bg-white/10 px-2 py-0.5 rounded ml-1">{{ $submission->assignment->class->name ?? 'N/A' }}</strong>
                </p>
            </div>

            <!-- Content -->
            <div class="p-6 sm:p-8 relative z-10">
                <!-- Status Badges -->
                <div class="mb-6 flex flex-wrap gap-2.5">
                    <span class="inline-flex items-center gap-1.5 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 px-3 py-1.5 rounded-full text-xs font-semibold tracking-wide">
                        ✓ Sudah Dikumpulkan
                    </span>
                    @if($submission->graded_at)
                        <span class="inline-flex items-center gap-1.5 bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 px-3 py-1.5 rounded-full text-xs font-semibold tracking-wide">
                            📝 Sudah Dinilai
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 bg-amber-500/10 border border-amber-500/20 text-amber-400 px-3 py-1.5 rounded-full text-xs font-semibold tracking-wide">
                            ⏳ Menunggu Penilaian
                        </span>
                    @endif
                </div>

                <!-- Assignment Info Box -->
                <div class="mb-6 p-5 bg-violet-950/20 backdrop-blur-sm border border-violet-500/20 rounded-2xl">
                    <h4 class="font-bold text-white mb-2.5 flex items-center gap-2 text-sm uppercase tracking-wider">
                        <svg class="w-4 h-4 text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span>Informasi Tugas</span>
                    </h4>
                    <p class="text-slate-300 text-sm leading-relaxed mb-4 font-light">{{ $submission->assignment->description }}</p>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs sm:text-sm pt-4 border-t border-white/[0.06]">
                        <div>
                            <span class="text-slate-400 block mb-1">📅 Deadline</span>
                            <p class="font-bold text-slate-200">
                                {{ $submission->assignment->deadline->translatedFormat('d M Y H:i') }}
                            </p>
                        </div>
                        <div>
                            <span class="text-slate-400 block mb-1">✓ Dikumpulkan</span>
                            <p class="font-bold text-slate-200">
                                {{ $submission->submitted_at->translatedFormat('d M Y H:i') }}
                            </p>
                        </div>
                    </div>
                    @if($submission->graded_at)
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs sm:text-sm mt-3 pt-3 border-t border-white/[0.06]">
                            <div>
                                <span class="text-slate-400 block mb-1">📝 Dinilai</span>
                                <p class="font-bold text-slate-200">
                                    {{ $submission->graded_at->translatedFormat('d M Y H:i') }}
                                </p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Submission Content -->
                <div class="mb-6 p-5 bg-indigo-950/20 backdrop-blur-sm border border-indigo-500/20 rounded-2xl">
                    <h4 class="font-bold text-white mb-4 flex items-center gap-2 text-sm uppercase tracking-wider">
                        <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <span>Submission Anda</span>
                    </h4>
                    
                    @if($submission->is_upload)
                        <!-- File Display -->
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 p-4 bg-white/[0.02] hover:bg-white/[0.04] border border-white/10 hover:border-violet-500/30 rounded-2xl transition-all duration-300">
                            <div class="flex items-center gap-3.5 min-w-0">
                                <div class="w-12 h-12 rounded-xl bg-violet-500/10 flex items-center justify-center text-violet-400 flex-shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <p class="font-bold text-slate-200 text-sm break-all">
                                        {{ basename($submission->file_url) }}
                                    </p>
                                    <p class="text-xs text-slate-400 font-medium mt-0.5">
                                        File Upload
                                    </p>
                                </div>
                            </div>
                            <a href="{{ route('submissions.download', $submission->id) }}" 
                                class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-gradient-to-r from-violet-600 to-indigo-600 hover:from-violet-500 hover:to-indigo-500 text-white font-bold text-xs uppercase tracking-wider rounded-xl transition-all duration-150 shadow-lg shadow-indigo-600/10 whitespace-nowrap">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                                <span>Download File</span>
                            </a>
                        </div>
                    @else
                        <!-- Link Display -->
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 p-4 bg-white/[0.02] hover:bg-white/[0.04] border border-white/10 hover:border-violet-500/30 rounded-2xl transition-all duration-300">
                            <div class="flex items-center gap-3.5 min-w-0">
                                <div class="w-12 h-12 rounded-xl bg-violet-500/10 flex items-center justify-center text-violet-400 flex-shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <p class="font-bold text-slate-200 text-sm break-all">
                                        {{ $submission->file_url }}
                                    </p>
                                    <p class="text-xs text-slate-400 font-medium mt-0.5">
                                        Link External
                                    </p>
                                </div>
                            </div>
                            <a href="{{ $submission->file_url }}" 
                                target="_blank"
                                class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white font-bold text-xs uppercase tracking-wider rounded-xl transition-all duration-150 shadow-lg shadow-emerald-600/10 whitespace-nowrap">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                </svg>
                                <span>Kunjungi Link</span>
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Member Info -->
                <div class="mb-8 p-5 bg-white/[0.02] border border-white/10 rounded-2xl">
                    <h4 class="font-bold text-white mb-3.5 flex items-center gap-2 text-sm uppercase tracking-wider">
                        <svg class="w-4 h-4 text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span>Informasi Pengumpul</span>
                    </h4>
                    <div class="space-y-2.5 text-sm">
                        <div class="flex justify-between border-b border-white/[0.04] pb-2">
                            <span class="text-slate-400">Nama</span>
                            <span class="font-semibold text-slate-200">{{ $submission->member->name }}</span>
                        </div>
                        <div class="flex justify-between border-b border-white/[0.04] pb-2">
                            <span class="text-slate-400">Email</span>
                            <span class="font-semibold text-slate-200">{{ $submission->member->email }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400">Role</span>
                            <span class="font-semibold text-slate-200">{{ ucfirst($submission->member->role) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-white/[0.06]">
                    <a href="{{ route('submissions.index') }}"
                        class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-3 bg-white/5 hover:bg-white/10 border border-white/10 rounded-xl font-bold text-xs text-white uppercase tracking-wider transition-all duration-150 text-center">
                        ← Kembali
                    </a>
                    
                    @if(now() <= $submission->assignment->deadline)
                        <a href="{{ route('submissions.edit', $submission->id) }}"
                            class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-3 bg-gradient-to-r from-violet-600 to-indigo-600 hover:from-violet-500 hover:to-indigo-500 text-white font-bold text-xs uppercase tracking-wider rounded-xl transition-all duration-150 shadow-lg shadow-indigo-600/10 text-center">
                            ✏️ Ubah
                        </a>
                        <form action="{{ route('submissions.destroy', $submission->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Yakin ingin menghapus submission ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-rose-500/10 hover:bg-rose-500/20 border border-rose-500/20 rounded-xl font-bold text-xs text-rose-400 uppercase tracking-wider transition-all duration-150 cursor-pointer">
                                🗑️ Hapus
                            </button>
                        </form>
                    @else
                        <div class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-3 bg-white/[0.02] border border-white/5 text-slate-500 font-bold text-xs uppercase tracking-wider rounded-xl text-center cursor-not-allowed">
                            ⚠️ Deadline Lewat
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-member-layout>
