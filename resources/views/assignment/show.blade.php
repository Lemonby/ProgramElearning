<x-mentor-layout>
    <!-- MAIN COLUMN CONTAINER -->
    <div class="max-w-6xl mx-auto space-y-8">
        
        <!-- Back Button & Quick Actions Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-white/5">
            <a href="{{ route('assignment.index') }}" class="text-purple-300 hover:text-white flex items-center gap-2 group text-sm font-bold transition-colors">
                <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali ke Daftar
            </a>
            <div class="flex gap-3">
                <a href="{{ route('assignment.edit', $assignment->id) }}"
                   class="bg-amber-600/20 hover:bg-amber-600 border border-amber-500/30 text-amber-200 hover:text-white font-bold py-2 px-5 rounded-xl transition-all duration-200 text-xs uppercase tracking-wider">
                    Edit
                </a>
                <form action="{{ route('assignment.destroy', $assignment->id) }}" 
                      method="POST"
                      class="inline"
                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus assignment ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="bg-rose-600/20 hover:bg-rose-600 border border-rose-500/30 text-rose-200 hover:text-white font-bold py-2 px-5 rounded-xl transition-all duration-200 text-xs uppercase tracking-wider">
                        Hapus
                    </button>
                </form>
            </div>
        </div>

        <!-- Success Alert -->
        @if (session('success'))
            <div class="bg-purple-600/20 border border-purple-500/30 text-purple-200 p-4 rounded-2xl text-sm shadow-xl flex items-center gap-3">
                <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Grid layout: Assignment details (Left) and Submission summary (Right) -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- LEFT COLUMN: Assignment details (2/3 width) -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Detail Header Card -->
                <div class="bg-gradient-to-tr from-[#3a2075]/40 to-[#1f123d]/60 border border-white/10 rounded-[28px] p-6 shadow-xl relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-purple-600/10 rounded-full blur-3xl"></div>
                    <span class="inline-block bg-purple-500/20 text-purple-300 border border-purple-500/30 text-[10px] font-extrabold px-3 py-1 rounded-full mb-4 uppercase tracking-widest">
                        Assignment #{{ $assignment->id }}
                    </span>
                    <h1 class="text-3xl font-black text-white leading-tight mb-4">{{ $assignment->title }}</h1>
                    
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 pt-4 border-t border-white/5 text-slate-300">
                        <div>
                            <p class="text-slate-400 text-[10px] font-bold uppercase tracking-wider">Kelas</p>
                            <p class="font-bold text-white text-sm mt-0.5">{{ $assignment->class->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-slate-400 text-[10px] font-bold uppercase tracking-wider">Batas Waktu</p>
                            <p class="font-bold text-white text-sm mt-0.5">{{ $assignment->deadline->format('d M Y, H:i') }}</p>
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <p class="text-slate-400 text-[10px] font-bold uppercase tracking-wider">Tanggal Dibuat</p>
                            <p class="font-bold text-white text-sm mt-0.5">{{ $assignment->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Description Card -->
                <div class="bg-[#1f193f]/40 border border-white/5 rounded-[28px] p-6 shadow-xl">
                    <h2 class="text-xl font-extrabold text-white tracking-tight mb-4">Deskripsi Tugas</h2>
                    <div class="text-slate-300 text-sm whitespace-pre-wrap leading-relaxed">
                        {{ $assignment->description }}
                    </div>
                </div>

                <!-- File/Link Card -->
                @if ($assignment->file_path)
                    <div class="bg-[#1f193f]/40 border border-white/5 rounded-[28px] p-6 shadow-xl">
                        <h2 class="text-xl font-extrabold text-white tracking-tight mb-4">Materi Pendukung / Link</h2>
                        
                        @if (Str::startsWith($assignment->file_path, ['http://', 'https://']))
                            <!-- External Link Layout -->
                            <div class="bg-white/5 border border-white/10 rounded-2xl p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-white/10 transition-all">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-purple-500/20 text-purple-300 flex items-center justify-center">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.658 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                        </svg>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-xs font-bold text-white uppercase tracking-wider">Tautan Pendukung</p>
                                        <p class="text-[11px] text-slate-400 truncate max-w-xs mt-0.5">{{ $assignment->file_path }}</p>
                                    </div>
                                </div>
                                <a href="{{ $assignment->file_path }}" target="_blank"
                                   class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded-xl text-xs uppercase tracking-wider transition-colors inline-flex items-center gap-1.5 self-start sm:self-center">
                                    Buka Link
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                    </svg>
                                </a>
                            </div>
                        @else
                            <!-- Local File Layout -->
                            <div class="bg-white/5 border border-white/10 rounded-2xl p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-white/10 transition-all">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-purple-500/20 text-purple-300 flex items-center justify-center">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-white uppercase tracking-wider">File Pendukung</p>
                                        <p class="text-[11px] text-slate-400 mt-0.5">Format file terlampir</p>
                                    </div>
                                </div>
                                <a href="{{ Storage::url($assignment->file_path) }}" download
                                   class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded-xl text-xs uppercase tracking-wider transition-colors inline-flex items-center gap-1.5 self-start sm:self-center">
                                    Download File
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                </a>
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            <!-- RIGHT COLUMN: Submissions Quick stats (1/3 width) -->
            <div class="space-y-6">
                <!-- Stats Summary Panel -->
                <div class="bg-[#1f193f]/40 border border-white/5 rounded-[28px] p-6 shadow-xl flex flex-col justify-between min-h-[220px]">
                    <h3 class="text-lg font-extrabold text-white tracking-tight mb-4">Rangkuman Pengumpulan</h3>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-white/5 border border-white/10 rounded-2xl p-4 text-center">
                            <span class="text-2xl font-black text-white block">
                                {{ $assignment->submissions->count() }}
                            </span>
                            <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-1 block">Dikumpulkan</span>
                        </div>
                        <div class="bg-white/5 border border-white/10 rounded-2xl p-4 text-center">
                            <span class="text-2xl font-black text-purple-400 block">
                                {{ max(0, ($assignment->class->members->where('role', '!=', 'mentor')->count() ?? 0) - $assignment->submissions->count()) }}
                            </span>
                            <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-1 block">Belum Kumpul</span>
                        </div>
                    </div>

                    <div class="border-t border-white/5 pt-4 mt-4 flex items-center justify-between text-xs text-slate-400">
                        <span>Total Anggota Kelas:</span>
                        <span class="font-extrabold text-white">
                            {{ $assignment->class->members->where('role', '!=', 'mentor')->count() ?? 0 }} Siswa
                        </span>
                    </div>
                </div>
            </div>

        </div>

        <!-- FULL-WIDTH SECTION: Student Submissions Dashboard -->
        <div class="bg-[#1f193f]/40 border border-white/5 rounded-[28px] p-6 shadow-xl">
            <h2 class="text-2xl font-extrabold text-white tracking-tight mb-6 flex items-center gap-2">
                Daftar Pengumpulan Mahasiswa
                <span class="text-xs bg-purple-500/20 text-purple-300 border border-purple-500/30 px-2 py-0.5 rounded-full font-bold">
                    {{ $assignment->submissions->count() }} / {{ $assignment->class->members->where('role', '!=', 'mentor')->count() ?? 0 }}
                </span>
            </h2>

            <div class="overflow-x-auto rounded-2xl border border-white/10">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-white/5 border-b border-white/10">
                            <th class="py-4 px-6 text-xs font-bold uppercase tracking-wider text-slate-300">Nama Siswa</th>
                            <th class="py-4 px-6 text-xs font-bold uppercase tracking-wider text-slate-300">Status</th>
                            <th class="py-4 px-6 text-xs font-bold uppercase tracking-wider text-slate-300">Waktu Pengumpulan</th>
                            <th class="py-4 px-6 text-xs font-bold uppercase tracking-wider text-slate-300">Lampiran Tugas</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5 text-slate-300">
                        @forelse ($assignment->class->members->where('role', '!=', 'mentor')->sortBy('name') as $member)
                            @php
                                $submission = $assignment->submissions->where('member_id', $member->id)->first();
                            @endphp
                            <tr class="hover:bg-white/[0.02] transition-colors">
                                <!-- Student profile avatar + name -->
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-purple-600 flex items-center justify-center font-bold text-xs text-white border border-white/10">
                                            {{ strtoupper(substr($member->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-white text-sm">{{ $member->name }}</p>
                                            <p class="text-[10px] text-slate-400 mt-0.5">{{ $member->email }}</p>
                                        </div>
                                    </div>
                                </td>

                                <!-- Status Badge -->
                                <td class="py-4 px-6">
                                    @if ($submission)
                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-[10px] font-extrabold bg-purple-500/20 text-purple-300 border border-purple-500/30 uppercase tracking-wider">
                                            Sudah Kumpul
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-[10px] font-extrabold bg-rose-500/10 text-rose-300 border border-rose-500/20 uppercase tracking-wider">
                                            Belum Kumpul
                                        </span>
                                    @endif
                                </td>

                                <!-- Submission Time -->
                                <td class="py-4 px-6 text-xs font-semibold">
                                    @if ($submission)
                                        {{ $submission->submitted_at->translatedFormat('d M Y, H:i') }}
                                        @if ($submission->submitted_at > $assignment->deadline)
                                            <span class="text-rose-400 font-extrabold ml-1 uppercase text-[9px] tracking-wide">(Terlambat)</span>
                                        @endif
                                    @else
                                        <span class="text-slate-500">-</span>
                                    @endif
                                </td>

                                <!-- File attachment download / external link -->
                                <td class="py-4 px-6">
                                    @if ($submission)
                                        @if ($submission->is_upload)
                                            <!-- Downloadable Local File -->
                                            <a href="{{ route('submissions.download', $submission->id) }}"
                                               class="inline-flex items-center gap-1.5 text-xs text-purple-300 hover:text-white font-bold transition-all border-b border-purple-500/30 hover:border-white pb-0.5">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                </svg>
                                                Download Tugas
                                            </a>
                                        @else
                                            <!-- External URL Link -->
                                            <a href="{{ $submission->file_url }}" target="_blank"
                                               class="inline-flex items-center gap-1.5 text-xs text-purple-300 hover:text-white font-bold transition-all border-b border-purple-500/30 hover:border-white pb-0.5">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                                </svg>
                                                Buka Tautan Tugas
                                            </a>
                                        @endif
                                    @else
                                        <span class="text-slate-500">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-slate-500 text-sm font-semibold">
                                    Tidak ada anggota terdaftar di kelas ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-mentor-layout>
