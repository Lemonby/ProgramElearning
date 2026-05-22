<x-mentor-layout>
    <div class="space-y-8">
        
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-white/5">
            <div>
                <h1 class="text-3xl font-extrabold text-white tracking-tight">Materi Pembelajaran</h1>
                <p class="text-slate-400 mt-1 text-sm">Kelola dan unggah materi ajar untuk kelas Anda.</p>
            </div>
            <div>
                <a href="{{ route('materials.create') }}" 
                   class="inline-flex items-center gap-2 bg-purple-600 hover:bg-purple-700 text-white font-bold py-2.5 px-5 rounded-xl transition-all shadow-lg shadow-purple-500/20 text-xs uppercase tracking-wider">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Materi
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

        <!-- Materials Grid -->
        @if ($materials->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach ($materials as $material)
                    <div class="group bg-[#1f193f]/40 border border-white/5 hover:border-purple-500/30 rounded-[28px] p-6 shadow-xl hover:shadow-2xl hover:shadow-purple-950/10 transition-all duration-300 flex flex-col justify-between relative overflow-hidden">
                        
                        <!-- Glow effect -->
                        <div class="absolute top-0 right-0 w-32 h-32 bg-purple-500/5 rounded-full blur-3xl group-hover:bg-purple-500/10 transition-all duration-300"></div>

                        <div>
                            <!-- Header / Metadata -->
                            <div class="flex items-center gap-2 mb-4">
                                <!-- <span class="px-2.5 py-1 rounded-full text-[9px] font-black tracking-wider uppercase bg-purple-500/10 text-purple-300 border border-purple-500/20">
                                    {{ $material->class->description ?? 'Semua Kelas' }}
                                </span> -->
                                <span class="text-[10px] text-slate-500 font-semibold flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    {{ $material->created_at->format('d M Y H:i') }}
                                </span>
                            </div>

                            <!-- Content -->
                            <div class="space-y-2 mb-6">
                                <h3 class="text-lg font-bold text-white group-hover:text-purple-300 transition-colors line-clamp-1">
                                    {{ $material->title }}
                                </h3>
                                <p class="text-slate-400 text-xs leading-relaxed line-clamp-3">
                                    {{ $material->description ?? 'Tidak ada deskripsi materi.' }}
                                </p>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="border-t border-white/5 pt-4 flex items-center justify-between gap-2">
                            <!-- Download link -->
                            <a href="{{ asset('storage/' . $material->file_url) }}" 
                               class="inline-flex items-center gap-1.5 bg-purple-600/15 hover:bg-purple-600 text-purple-300 hover:text-white font-bold py-2 px-4 rounded-xl transition-all text-xs tracking-wide border border-purple-500/20"
                               target="_blank" 
                               download>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                                Unduh Materi
                            </a>

                            <!-- Edit and Delete buttons -->
                            <div class="flex items-center gap-1.5">
                                <a href="{{ route('materials.edit', $material->id) }}" 
                                   class="p-2 bg-white/5 hover:bg-white/10 border border-white/10 text-slate-300 hover:text-white rounded-xl transition-all"
                                   title="Edit Materi">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                    </svg>
                                </a>
                                
                                <form action="{{ route('materials.destroy', $material->id) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus materi ini?');"
                                      class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="p-2 bg-rose-500/10 hover:bg-rose-500 border border-rose-500/20 text-rose-300 hover:text-white rounded-xl transition-all"
                                            title="Hapus Materi">
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <div class="max-w-md mx-auto space-y-2">
                    <h3 class="text-xl font-extrabold text-white">Belum Ada Materi</h3>
                    <p class="text-slate-400 text-xs leading-relaxed">
                        Anda belum mengunggah materi pembelajaran apa pun untuk kelas Anda. Mulai dengan menambahkan materi baru untuk siswa Anda.
                    </p>
                </div>
                <a href="{{ route('materials.create') }}" 
                   class="inline-flex items-center gap-2 bg-purple-600 hover:bg-purple-700 text-white font-bold py-2.5 px-6 rounded-xl transition-all shadow-lg shadow-purple-500/20 text-xs uppercase tracking-wider">
                    Upload Materi Pertama
                </a>
            </div>
        @endif

    </div>
</x-mentor-layout>