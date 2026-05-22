<x-member-layout>
    <div class="py-8 px-4 sm:px-6 lg:px-8 max-w-3xl mx-auto">
        <!-- Back Navigation & Quick Info -->
        <div class="flex justify-between items-center mb-8">
            <a href="{{ route('submissions.show', $submission->id) }}" 
               class="inline-flex items-center gap-2 px-4 py-2 bg-white/5 hover:bg-white/10 border border-white/10 rounded-xl font-bold text-xs text-white uppercase tracking-wider transition-all duration-150">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
                </svg>
                <span>Kembali</span>
            </a>
            <span class="text-xs text-slate-400 font-semibold tracking-wider uppercase bg-white/5 border border-white/10 px-3.5 py-1.5 rounded-full">
                Edit Submission
            </span>
        </div>

        <div class="bg-white/[0.03] backdrop-blur-md border border-white/10 rounded-3xl shadow-2xl overflow-hidden relative">
            <!-- Background Accent glow -->
            <div class="absolute -top-40 -right-40 w-96 h-96 bg-violet-600/10 rounded-full blur-3xl pointer-events-none"></div>

            <!-- Card Banner Header -->
            <div class="bg-gradient-to-r from-violet-600 via-indigo-600 to-purple-600 px-6 sm:px-8 py-6 relative overflow-hidden shadow-lg">
                <div class="absolute -right-6 -bottom-6 w-20 h-20 bg-white/10 rounded-full blur-xl pointer-events-none"></div>
                <h3 class="text-xl sm:text-2xl font-black text-white relative z-10 leading-tight">
                    Edit Submission: {{ $assignment->title }}
                </h3>
                <p class="text-violet-100 text-xs font-semibold mt-2 relative z-10">
                    Kelas: <strong class="bg-white/10 px-2 py-0.5 rounded ml-1">{{ $assignment->class->name ?? 'N/A' }}</strong>
                </p>
            </div>

            <!-- Content -->
            <div class="p-6 sm:p-8 relative z-10">
                <!-- Warning Alert -->
                <div class="mb-6 p-4 bg-amber-500/10 backdrop-blur-md border border-amber-500/20 rounded-2xl text-amber-300 flex items-center gap-3 shadow-lg">
                    <svg class="w-6 h-6 flex-shrink-0 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    <span class="text-sm font-semibold tracking-wide">
                        Anda dapat mengubah submission ini sampai deadline. File sebelumnya akan digantikan secara permanen.
                    </span>
                </div>

                <!-- Assignment Info Box -->
                <div class="mb-6 p-5 bg-violet-950/20 backdrop-blur-sm border border-violet-500/20 rounded-2xl">
                    <h4 class="font-bold text-white mb-2.5 flex items-center gap-2 text-sm uppercase tracking-wider">
                        <svg class="w-4 h-4 text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span>Informasi Tugas</span>
                    </h4>
                    <p class="text-slate-300 text-sm leading-relaxed mb-4 font-light">{{ $assignment->description }}</p>
                    
                    <div class="grid grid-cols-2 gap-4 text-xs sm:text-sm pt-4 border-t border-white/[0.06]">
                        <div>
                            <span class="text-slate-400 block mb-1">📅 Deadline</span>
                            <p class="font-bold text-slate-200">
                                {{ $assignment->deadline->translatedFormat('d M Y H:i') }}
                            </p>
                        </div>
                        <div>
                            <span class="text-slate-400 block mb-1">✓ Waktu Pengumpulan</span>
                            <p class="font-bold text-slate-200">
                                {{ $submission->submitted_at->translatedFormat('d M Y H:i') }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Current Submission Box -->
                <div class="mb-8 p-5 bg-white/[0.02] border border-white/10 rounded-2xl">
                    <h4 class="font-bold text-slate-300 mb-3 text-xs uppercase tracking-wider">Tugas Dikumpulkan Saat Ini</h4>
                    @if($submission->is_upload)
                        <div class="flex items-center gap-3 p-4 bg-white/[0.03] border border-white/5 rounded-xl">
                            <div class="w-10 h-10 rounded-xl bg-violet-600/20 border border-violet-500/20 flex items-center justify-center text-violet-300 text-lg flex-shrink-0">
                                📄
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-bold text-white text-sm truncate">
                                    {{ basename($submission->file_url) }}
                                </p>
                                <p class="text-[10px] text-slate-500 font-semibold uppercase tracking-wider mt-0.5">Berkas Terunggah</p>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center gap-3 p-4 bg-white/[0.03] border border-white/5 rounded-xl">
                            <div class="w-10 h-10 rounded-xl bg-violet-600/20 border border-violet-500/20 flex items-center justify-center text-violet-300 text-lg flex-shrink-0">
                                🔗
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-bold text-white text-sm break-all">
                                    {{ $submission->file_url }}
                                </p>
                                <p class="text-[10px] text-slate-500 font-semibold uppercase tracking-wider mt-0.5">Tautan Eksternal</p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Edit Form -->
                <form action="{{ route('submissions.update', $submission->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Submission Method Selection -->
                    <div class="mb-6">
                        <label class="block text-sm font-bold text-white uppercase tracking-wider mb-3">Cara Pengumpulan Baru</label>
                        <div class="flex gap-4">
                            <label class="flex-1 flex items-center justify-center gap-2.5 p-4 bg-white/[0.02] border border-white/10 hover:border-violet-500/30 rounded-2xl cursor-pointer hover:bg-white/5 transition-all select-none">
                                <input type="radio" name="submission_method" value="file" class="w-4 h-4 text-violet-600 focus:ring-violet-500/50 bg-white/10 border-white/20" onchange="showFileUpload()">
                                <span class="text-sm font-semibold text-slate-200">📁 Upload Berkas</span>
                            </label>
                            <label class="flex-1 flex items-center justify-center gap-2.5 p-4 bg-white/[0.02] border border-white/10 hover:border-violet-500/30 rounded-2xl cursor-pointer hover:bg-white/5 transition-all select-none">
                                <input type="radio" name="submission_method" value="link" class="w-4 h-4 text-violet-600 focus:ring-violet-500/50 bg-white/10 border-white/20" onchange="showLinkInput()">
                                <span class="text-sm font-semibold text-slate-200">🔗 Link URL Baru</span>
                            </label>
                        </div>
                    </div>

                    <!-- File Upload Section -->
                    <div id="fileSection" class="mb-6">
                        <label for="file_submission" class="block text-sm font-bold text-white uppercase tracking-wider mb-3">
                            Pilih File Baru
                        </label>
                        <div class="relative bg-white/[0.02] border-2 border-dashed border-white/15 hover:border-violet-500/50 rounded-2xl p-8 transition duration-150 text-slate-300 text-center flex flex-col items-center justify-center cursor-pointer hover:bg-white/[0.04] group">
                            <!-- Input overlaying the full container -->
                            <input type="file" 
                                id="file_submission"
                                name="file_submission"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.zip,.rar">
                            
                            <div class="w-12 h-12 rounded-xl bg-violet-500/10 flex items-center justify-center text-violet-400 group-hover:scale-110 transition-transform duration-300 mb-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                            </div>
                            <span class="text-sm font-semibold text-white group-hover:text-violet-300 transition-colors">Seret berkas baru di sini atau klik untuk memilih</span>
                            <span class="text-xs text-slate-500 mt-2 font-light">Format yang diterima: PDF, DOC, DOCX, PPT, PPTX, XLS, XLSX, ZIP, RAR (Max 10 MB)</span>
                        </div>
                        <div id="fileName" class="mt-3 text-sm text-emerald-400 font-bold flex items-center gap-1.5"></div>
                        @error('file_submission')
                            <p class="text-rose-400 text-xs mt-2 font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Link Input Section (hidden by default) -->
                    <div id="linkSection" class="mb-6 hidden">
                        <label for="link_submission" class="block text-sm font-bold text-white uppercase tracking-wider mb-3">
                            Masukkan Link Baru
                        </label>
                        <input type="url" 
                            id="link_submission"
                            name="link_submission"
                            class="w-full px-4 py-3 rounded-2xl bg-white/[0.03] border border-white/15 focus:border-violet-500/50 focus:ring-violet-500/50 text-white placeholder-slate-500 focus:outline-none transition-all text-sm font-semibold"
                            placeholder="https://github.com/username/project atau https://drive.google.com/..."
                            @if(!$submission->is_upload) value="{{ $submission->file_url }}" @endif>
                        <p class="text-xs text-slate-500 mt-2 font-light">
                            Tautan valid dari cloud storage (Google Drive, Dropbox) or repositori kode (GitHub, GitLab, dll)
                        </p>
                        @error('link_submission')
                            <p class="text-rose-400 text-xs mt-2 font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-white/[0.06]">
                        <a href="{{ route('submissions.show', $submission->id) }}"
                           class="flex-1 bg-white/5 hover:bg-white/10 border border-white/10 text-white font-bold py-3 px-6 rounded-xl transition-colors text-center text-sm">
                            Batalkan
                        </a>
                        <button type="submit"
                                class="flex-1 bg-gradient-to-r from-violet-600 via-indigo-600 to-purple-600 hover:from-violet-700 hover:to-indigo-700 text-white font-bold py-3 px-6 rounded-xl transition-all duration-150 shadow-md shadow-violet-900/30 text-center text-sm">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        const fileInput = document.getElementById('file_submission');
        const fileNameDisplay = document.getElementById('fileName');
        const linkInput = document.getElementById('link_submission');

        fileInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                fileNameDisplay.innerHTML = `
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>Berkas Terpilih: ${this.files[0].name} (${(this.files[0].size / 1024 / 1024).toFixed(2)} MB)</span>
                `;
            } else {
                fileNameDisplay.innerHTML = '';
            }
        });

        function showFileUpload() {
            document.getElementById('fileSection').classList.remove('hidden');
            document.getElementById('linkSection').classList.add('hidden');
            document.getElementById('file_submission').required = true;
            linkInput.required = false;
        }

        function showLinkInput() {
            document.getElementById('fileSection').classList.add('hidden');
            document.getElementById('linkSection').classList.remove('hidden');
            document.getElementById('file_submission').required = false;
            linkInput.required = true;
        }

        // Set initial state based on current submission type
        if ({{ $submission->is_upload ? 'true' : 'false' }}) {
            document.querySelector('input[name="submission_method"][value="file"]').checked = true;
            showFileUpload();
        } else {
            document.querySelector('input[name="submission_method"][value="link"]').checked = true;
            showLinkInput();
        }
    </script>
    @endpush
</x-member-layout>
