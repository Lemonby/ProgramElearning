<x-mentor-layout>
    <div class="max-w-3xl mx-auto space-y-8">
        
        <!-- Header -->
        <div class="flex items-center justify-between pb-4 border-b border-white/5">
            <div>
                <h1 class="text-3xl font-extrabold text-white tracking-tight">Upload Materi Baru</h1>
                <p class="text-slate-400 mt-1 text-sm">Tambahkan materi pembelajaran baru untuk siswa Anda.</p>
            </div>
            <a href="{{ route('materials.index') }}" class="text-purple-300 hover:text-white flex items-center gap-1.5 text-xs font-bold transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
                </svg>
                Batal & Kembali
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
        <form action="{{ route('materials.store') }}" method="POST" enctype="multipart/form-data" 
              class="bg-[#1f193f]/40 border border-white/5 rounded-[28px] p-6 sm:p-8 shadow-xl space-y-6">
            @csrf

            <!-- Title -->
            <div class="space-y-2">
                <label for="title" class="block text-xs font-black text-white uppercase tracking-wider">
                    Judul Materi <span class="text-rose-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="title" 
                    name="title"
                    maxlength="255"
                    class="w-full bg-[#1A1435]/60 border border-white/10 rounded-xl px-4 py-2.5 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all text-sm {{ $errors->has('title') ? 'border-rose-500 focus:ring-rose-500' : '' }}"
                    placeholder="Contoh: Pengenalan HTML & CSS Dasar"
                    value="{{ old('title') }}"
                    required
                >
                @error('title')
                    <p class="text-rose-400 text-xs mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div class="space-y-2">
                <label for="description" class="block text-xs font-black text-white uppercase tracking-wider">
                    Deskripsi Materi
                </label>
                <textarea 
                    id="description" 
                    name="description"
                    rows="4"
                    maxlength="1000"
                    class="w-full bg-[#1A1435]/60 border border-white/10 rounded-xl px-4 py-2.5 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all text-sm leading-relaxed {{ $errors->has('description') ? 'border-rose-500 focus:ring-rose-500' : '' }}"
                    placeholder="Jelaskan secara singkat apa yang dipelajari pada materi ini..."
                >{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-rose-400 text-xs mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Class Selection -->
            <div class="space-y-2">
                <label for="class_id" class="block text-xs font-black text-white uppercase tracking-wider">
                    Pilih Kelas <span class="text-rose-500">*</span>
                </label>
                <div class="relative">
                    <select 
                        id="class_id" 
                        name="class_id" 
                        class="w-full bg-[#1A1435]/60 border border-white/10 rounded-xl px-4 py-2.5 text-white focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all text-sm appearance-none cursor-pointer"
                        required
                    >
                        <option value="" class="bg-[#1A1435] text-slate-400">-- Pilih Kelas --</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" class="bg-[#1A1435] text-white"
                                    @if(old('class_id') === (string)$class->id) selected @endif>
                                {{ $class->description }}
                            </option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-purple-300">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>
                @error('class_id')
                    <p class="text-rose-400 text-xs mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- File Upload input -->
            <div class="space-y-2">
                <label for="file" class="block text-xs font-black text-white uppercase tracking-wider">
                    Berkas Materi (File) <span class="text-rose-500">*</span>
                </label>
                <div class="bg-white/[0.02] border border-white/5 p-4 rounded-2xl space-y-2">
                    <input 
                        type="file" 
                        id="file" 
                        name="file"
                        class="w-full text-slate-300 text-xs file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-black file:bg-purple-600/20 file:text-purple-300 file:cursor-pointer hover:file:bg-purple-600/30 transition-all border border-white/10 rounded-xl p-2 bg-[#1A1435]/30 cursor-pointer"
                        accept=".pdf,.ppt,.pptx,.doc,.docx"
                        required
                    >
                    <p class="text-[10px] text-slate-500 font-semibold">Format didukung: PDF, PPT, PPTX, DOC, DOCX (Maks: 20MB)</p>
                </div>
                @error('file')
                    <p class="text-rose-400 text-xs mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit buttons -->
            <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-white/5">
                <button type="submit" 
                        class="flex-1 bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-6 rounded-xl transition-all shadow-lg shadow-purple-500/20 text-xs uppercase tracking-wider flex items-center justify-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                    </svg>
                    Unggah Materi
                </button>
                <a href="{{ route('materials.index') }}"
                   class="flex-1 text-center bg-white/5 hover:bg-white/10 border border-white/10 text-slate-300 hover:text-white font-bold py-3 px-6 rounded-xl transition-all text-xs uppercase tracking-wider flex items-center justify-center">
                    Batal
                </a>
            </div>

        </form>

    </div>
</x-mentor-layout>