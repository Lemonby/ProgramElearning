<x-mentor-layout>
    <div class="space-y-8">
        
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-white/5">
            <div>
                <h1 class="text-3xl font-extrabold text-white tracking-tight">Jadwal Pertemuan (Meetings)</h1>
                <p class="text-slate-400 mt-1 text-sm">Kelola kelas virtual, bimbingan, dan sesi interaktif Anda.</p>
            </div>
            <div>
                <a href="{{ route('meetings.create') }}" 
                   class="inline-flex items-center gap-2 bg-purple-600 hover:bg-purple-700 text-white font-bold py-2.5 px-5 rounded-xl transition-all shadow-lg shadow-purple-500/20 text-xs uppercase tracking-wider">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Meeting
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

        <!-- Meetings Grid -->
        @if ($meetings->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($meetings as $meeting)
                    <div class="group bg-[#1f193f]/40 border border-white/5 hover:border-purple-500/30 rounded-[28px] p-6 shadow-xl hover:shadow-2xl hover:shadow-purple-950/10 transition-all duration-300 flex flex-col justify-between relative overflow-hidden">
                        
                        <!-- Glow effect -->
                        <div class="absolute top-0 right-0 w-32 h-32 bg-purple-500/5 rounded-full blur-3xl group-hover:bg-purple-500/10 transition-all duration-300"></div>

                        <div>
                            <!-- Header / Date capsule -->
                            <div class="flex flex-wrap gap-2 mb-4">
                                <span class="px-2.5 py-1 rounded-full text-[9px] font-black tracking-wider uppercase bg-purple-500/10 text-purple-300 border border-purple-500/20 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    {{ $meeting->meeting_date }}
                                </span>
                                <span class="px-2.5 py-1 rounded-full text-[9px] font-black tracking-wider uppercase bg-indigo-500/10 text-indigo-300 border border-indigo-500/20 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $meeting->meeting_time }}
                                </span>
                            </div>

                            <!-- Content -->
                            <div class="space-y-2 mb-6">
                                <h3 class="text-lg font-bold text-white group-hover:text-purple-300 transition-colors line-clamp-2">
                                    {{ $meeting->title }}
                                </h3>
                                <p class="text-slate-400 text-xs leading-relaxed line-clamp-3">
                                    {{ $meeting->description ?? 'Tidak ada deskripsi pertemuan.' }}
                                </p>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="border-t border-white/5 pt-4 flex items-center justify-between gap-2">
                            <!-- Join link -->
                            <a href="{{ $meeting->meeting_link }}" 
                               class="inline-flex items-center gap-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded-xl transition-all text-xs tracking-wide shadow-lg shadow-emerald-500/10"
                               target="_blank">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                </svg>
                                Gabung Sesi
                            </a>

                            <!-- Edit and Delete buttons -->
                            <div class="flex items-center gap-1.5">
                                <a href="{{ route('meetings.edit', $meeting->id) }}" 
                                   class="p-2 bg-white/5 hover:bg-white/10 border border-white/10 text-slate-300 hover:text-white rounded-xl transition-all"
                                   title="Edit Sesi">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                    </svg>
                                </a>
                                
                                <form action="{{ route('meetings.destroy', $meeting->id) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal pertemuan ini?');"
                                      class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="p-2 bg-rose-500/10 hover:bg-rose-500 border border-rose-500/20 text-rose-300 hover:text-white rounded-xl transition-all"
                                            title="Hapus Sesi">
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div class="max-w-md mx-auto space-y-2">
                    <h3 class="text-xl font-extrabold text-white">Belum Ada Sesi Pertemuan</h3>
                    <p class="text-slate-400 text-xs leading-relaxed">
                        Anda belum menjadwalkan pertemuan virtual atau sesi kelas apa pun. Klik tombol di bawah untuk mulai membuat pertemuan virtual pertama.
                    </p>
                </div>
                <a href="{{ route('meetings.create') }}" 
                   class="inline-flex items-center gap-2 bg-purple-600 hover:bg-purple-700 text-white font-bold py-2.5 px-6 rounded-xl transition-all shadow-lg shadow-purple-500/20 text-xs uppercase tracking-wider">
                    Jadwalkan Sesi Pertama
                </a>
            </div>
        @endif

    </div>
</x-mentor-layout>