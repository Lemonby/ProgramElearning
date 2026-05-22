<x-mentor-layout>
    <div class="max-w-3xl mx-auto space-y-8">
        
        <!-- Header -->
        <div class="flex items-center justify-between pb-4 border-b border-white/5">
            <div>
                <h1 class="text-3xl font-extrabold text-white tracking-tight">Edit Tugas</h1>
                <p class="text-slate-400 mt-1 text-sm">Perbarui detail tugas siswa di kelas Anda.</p>
            </div>
            <a href="{{ route('assignment.show', $assignment->id) }}" class="text-purple-300 hover:text-white flex items-center gap-1.5 text-xs font-bold transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali ke Detail
            </a>
        </div>

        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="bg-rose-500/10 border border-rose-500/30 text-rose-200 p-5 rounded-2xl text-sm shadow-xl">
                <h3 class="font-bold mb-2">Terjadi beberapa kesalahan input:</h3>
                <ul class="list-disc list-inside space-y-1 text-xs">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form Card -->
        <form action="{{ route('assignment.update', $assignment->id) }}" method="POST" enctype="multipart/form-data" 
              class="bg-[#1f193f]/40 border border-white/5 rounded-[28px] p-6 sm:p-8 shadow-xl space-y-6">
            @csrf
            @method('PUT')

            <!-- Class Info Banner -->
            <div class="bg-purple-950/40 border border-purple-500/20 text-purple-300 rounded-2xl p-4 flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-purple-500/20 text-purple-300 flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <p class="text-xs leading-relaxed">
                    Tugas ini terhubung ke kelas aktif: 
                    <span class="font-black text-white ml-0.5">{{ $class->name ?? $assignment->class->name ?? 'Kelas Belum Diset' }}</span>
                </p>
            </div>

            <!-- Title -->
            <div class="space-y-2">
                <label for="title" class="block text-xs font-black text-white uppercase tracking-wider">
                    Judul Tugas <span class="text-rose-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="title" 
                    name="title"
                    maxlength="255"
                    class="w-full bg-[#1A1435]/60 border border-white/10 rounded-xl px-4 py-2.5 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all text-sm {{ $errors->has('title') ? 'border-rose-500 focus:ring-rose-500' : '' }}"
                    placeholder="Contoh: Tugas Proyek Akhir - Pembuatan Portofolio"
                    value="{{ old('title', $assignment->title) }}"
                    required
                >
                @error('title')
                    <p class="text-rose-400 text-xs mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div class="space-y-2">
                <label for="description" class="block text-xs font-black text-white uppercase tracking-wider">
                    Deskripsi Detail Tugas <span class="text-rose-500">*</span>
                </label>
                <textarea 
                    id="description" 
                    name="description"
                    rows="6"
                    maxlength="5000"
                    class="w-full bg-[#1A1435]/60 border border-white/10 rounded-xl px-4 py-2.5 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all text-sm leading-relaxed {{ $errors->has('description') ? 'border-rose-500 focus:ring-rose-500' : '' }}"
                    placeholder="Jelaskan detail requirement tugas, kriteria penilaian, dan instruksi penyerahan secara lengkap..."
                    required
                >{{ old('description', $assignment->description) }}</textarea>
                <div class="flex justify-between items-center text-[10px] text-slate-500 font-semibold uppercase">
                    <span>Maksimal 5000 karakter</span>
                </div>
                @error('description')
                    <p class="text-rose-400 text-xs mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Deadline -->
            <div class="space-y-2">
                <label for="deadline" class="block text-xs font-black text-white uppercase tracking-wider">
                    Batas Waktu Pengumpulan (Deadline) <span class="text-rose-500">*</span>
                </label>
                <input 
                    type="datetime-local" 
                    id="deadline" 
                    name="deadline"
                    class="w-full bg-[#1A1435]/60 border border-white/10 rounded-xl px-4 py-2.5 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all text-sm {{ $errors->has('deadline') ? 'border-rose-500 focus:ring-rose-500' : '' }}"
                    value="{{ old('deadline', $assignment->deadline ? $assignment->deadline->format('Y-m-d\TH:i') : '') }}"
                    required
                >
                @error('deadline')
                    <p class="text-rose-400 text-xs mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Current File/Link Banner -->
            @if ($assignment->file_path)
                <div class="bg-indigo-950/40 border border-indigo-500/20 text-indigo-300 rounded-2xl p-4 space-y-2">
                    <p class="text-xs font-black text-white uppercase tracking-wider">Lampiran Saat Ini:</p>
                    @if (Str::startsWith($assignment->file_path, ['http://', 'https://']))
                        <div class="flex items-center gap-2 text-xs bg-indigo-500/10 p-2.5 rounded-xl border border-indigo-500/20">
                            <span class="text-indigo-400">🔗 Link:</span>
                            <a href="{{ $assignment->file_path }}" target="_blank" class="font-bold text-white hover:underline truncate max-w-full">
                                {{ Str::limit($assignment->file_path, 60) }}
                            </a>
                        </div>
                    @else
                        <div class="flex items-center gap-2 text-xs bg-indigo-500/10 p-2.5 rounded-xl border border-indigo-500/20">
                            <span class="text-indigo-400">📄 Berkas:</span>
                            <span class="font-bold text-white truncate max-w-full">
                                {{ basename($assignment->file_path) }}
                            </span>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Attachment Section (File or Link) -->
            <div class="border-t border-white/5 pt-6 space-y-4">
                <div>
                    <label class="block text-xs font-black text-white uppercase tracking-wider">
                        Update Lampiran Tugas (Berkas atau Tautan)
                    </label>
                    <p class="text-[11px] text-slate-400 mt-1">Biarkan bagian ini kosong jika Anda tidak ingin mengubah lampiran saat ini.</p>
                </div>

                <!-- File Upload input -->
                <div class="space-y-2 bg-white/[0.02] border border-white/5 p-4 rounded-2xl">
                    <label for="file_assignment" class="block text-xs font-bold text-slate-300 uppercase tracking-wide">
                        Pilihan 1: Unggah Berkas Baru
                    </label>
                    <input 
                        type="file" 
                        id="file_assignment" 
                        name="file_assignment"
                        class="w-full text-slate-300 text-xs file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-black file:bg-purple-600/20 file:text-purple-300 file:cursor-pointer hover:file:bg-purple-600/30 transition-all border border-white/10 rounded-xl p-2 bg-[#1A1435]/30 cursor-pointer"
                        accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.zip,.rar"
                    >
                    <p class="text-[10px] text-slate-500 font-semibold">Format: PDF, DOC, DOCX, PPT, ZIP, RAR (Maks: 10MB)</p>
                    @error('file_assignment')
                        <p class="text-rose-400 text-xs mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Divider -->
                <div class="flex items-center">
                    <div class="flex-grow border-t border-white/5"></div>
                    <span class="px-3 text-[10px] font-black text-slate-500 tracking-wider">ATAU</span>
                    <div class="flex-grow border-t border-white/5"></div>
                </div>

                <!-- Link Input -->
                <div class="space-y-2 bg-white/[0.02] border border-white/5 p-4 rounded-2xl">
                    <label for="link_assignment" class="block text-xs font-bold text-slate-300 uppercase tracking-wide">
                        Pilihan 2: Ganti Tautan Baru (Link)
                    </label>
                    <input 
                        type="url" 
                        id="link_assignment" 
                        name="link_assignment"
                        class="w-full bg-[#1A1435]/60 border border-white/10 rounded-xl px-4 py-2.5 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all text-sm"
                        placeholder="https://drive.google.com/... atau https://github.com/..."
                        value="{{ old('link_assignment') }}"
                    >
                    @error('link_assignment')
                        <p class="text-rose-400 text-xs mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Submit buttons -->
            <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-white/5">
                <button type="submit" 
                        class="flex-1 bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-6 rounded-xl transition-all shadow-lg shadow-purple-500/20 text-xs uppercase tracking-wider">
                    Simpan Perubahan
                </button>
                <a href="{{ route('assignment.show', $assignment->id) }}"
                   class="flex-1 text-center bg-white/5 hover:bg-white/10 border border-white/10 text-slate-300 hover:text-white font-bold py-3 px-6 rounded-xl transition-all text-xs uppercase tracking-wider">
                    Batal
                </a>
            </div>

        </form>

    </div>
</x-mentor-layout>
