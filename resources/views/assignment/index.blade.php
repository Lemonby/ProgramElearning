<x-mentor-layout>
    <div class="space-y-8">
        
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-white/5">
            <div>
                <h1 class="text-3xl font-extrabold text-white tracking-tight">Kelola Tugas</h1>
                <p class="text-slate-400 mt-1 text-sm">Buat, edit, dan awasi tugas yang diberikan untuk kelas Anda.</p>
            </div>
            
            <a href="{{ route('assignment.create') }}"
               class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2.5 px-6 rounded-xl transition-all shadow-lg shadow-purple-500/20 text-xs uppercase tracking-wider inline-flex items-center gap-2 self-start sm:self-center">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                </svg>
                + Buat Tugas Baru
            </a>
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

        <!-- Empty State -->
        @if ($assignments->isEmpty())
            <div class="bg-white/5 border border-white/10 rounded-[30px] p-12 text-center max-w-xl mx-auto">
                <div class="text-purple-400 mb-4 flex justify-center">
                    <div class="bg-purple-500/10 p-4 rounded-full">
                        <svg class="h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">Belum ada tugas terdaftar</h3>
                <p class="text-slate-400 text-sm mb-6 leading-relaxed">Mulai buat tugas pertama Anda untuk membagikan materi dan menguji kemampuan mahasiswa di kelas.</p>
                <a href="{{ route('assignment.create') }}"
                   class="inline-block bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-8 rounded-xl transition-all shadow-lg shadow-purple-500/20 text-xs uppercase tracking-wider">
                    Buat Tugas Pertama
                </a>
            </div>
        @else
            <!-- Assignments Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($assignments as $assignment)
                    <div class="bg-[#1f193f]/40 border border-white/5 rounded-[28px] overflow-hidden shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group min-h-[300px]">
                        
                        <!-- Top Header -->
                        <div class="bg-gradient-to-r from-[#44238c]/40 to-[#271552]/40 border-b border-white/5 px-6 py-5">
                            <span class="inline-block bg-purple-500/20 text-purple-300 border border-purple-500/30 text-[9px] font-extrabold px-2.5 py-0.5 rounded-full mb-2 uppercase tracking-wider">
                                Kelas: {{ $assignment->class->name ?? 'N/A' }}
                            </span>
                            <h3 class="text-lg font-black text-white leading-snug group-hover:text-purple-300 transition-colors line-clamp-1">
                                {{ $assignment->title }}
                            </h3>
                        </div>

                        <!-- Card Body -->
                        <div class="px-6 py-5 flex-1 flex flex-col justify-between gap-4">
                            <!-- Description -->
                            <p class="text-slate-400 text-xs leading-relaxed line-clamp-3">
                                {{ $assignment->description }}
                            </p>

                            <!-- Info Grid -->
                            <div class="space-y-3 pt-3 border-t border-white/5">
                                <div class="flex items-center justify-between text-xs">
                                    <span class="text-slate-400 font-bold uppercase tracking-wider text-[9px]">Deadline</span>
                                    <span class="text-white font-bold">{{ $assignment->deadline->format('d M Y, H:i') }}</span>
                                </div>
                                <div class="flex items-center justify-between text-xs">
                                    <span class="text-slate-400 font-bold uppercase tracking-wider text-[9px]">Attachment</span>
                                    @if ($assignment->file_path)
                                        @if (Str::startsWith($assignment->file_path, ['http://', 'https://']))
                                            <span class="text-amber-400 font-bold flex items-center gap-1">
                                                🔗 Tautan Luar
                                            </span>
                                        @else
                                            <span class="text-emerald-400 font-bold flex items-center gap-1">
                                                📄 Berkas File
                                            </span>
                                        @endif
                                    @else
                                        <span class="text-slate-500">-</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Card Footer actions -->
                        <div class="bg-white/5 px-6 py-4 flex gap-2 border-t border-white/5">
                            <a href="{{ route('assignment.show', $assignment->id) }}"
                               class="flex-1 text-center bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-3 rounded-xl text-xs uppercase tracking-wider transition-all duration-200">
                                Detail
                            </a>
                            <a href="{{ route('assignment.edit', $assignment->id) }}"
                               class="bg-amber-600/20 hover:bg-amber-600 border border-amber-500/30 text-amber-200 hover:text-white font-bold py-2 px-3 rounded-xl text-xs uppercase tracking-wider transition-all duration-200">
                                Edit
                            </a>
                            <form action="{{ route('assignment.destroy', $assignment->id) }}" 
                                  method="POST" 
                                  class="inline"
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus assignment ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="w-full bg-rose-600/20 hover:bg-rose-600 border border-rose-500/30 text-rose-200 hover:text-white font-bold py-2 px-3 rounded-xl text-xs uppercase tracking-wider transition-all duration-200">
                                    Hapus
                                </button>
                            </form>
                        </div>
                        
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-mentor-layout>
