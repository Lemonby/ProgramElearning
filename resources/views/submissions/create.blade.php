<x-member-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Kumpulkan Tugas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                <!-- Header -->
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                    <h3 class="text-xl font-bold text-white">{{ $assignment->title }}</h3>
                    <p class="text-blue-100 text-sm mt-1">{{ $assignment->class->name ?? 'N/A' }}</p>
                </div>

                <!-- Content -->
                <div class="p-6">
                    <!-- Assignment Info -->
                    <div class="mb-6 p-4 bg-blue-50 dark:bg-gray-700 rounded-lg border border-blue-200 dark:border-gray-600">
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-2">📋 Informasi Tugas</h4>
                        <p class="text-gray-700 dark:text-gray-300 text-sm mb-3">{{ $assignment->description }}</p>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-gray-600 dark:text-gray-400">📅 Deadline:</span>
                                <p class="font-semibold text-gray-900 dark:text-white">
                                    {{ $assignment->deadline->format('d M Y H:i') }}
                                </p>
                            </div>
                            <div>
                                <span class="text-gray-600 dark:text-gray-400">⏱️ Sisa Waktu:</span>
                                <p class="font-semibold @if(now() > $assignment->deadline) text-red-600 @else text-green-600 @endif">
                                    @if(now() > $assignment->deadline)
                                        ⚠️ Terlambat
                                    @else
                                        {{ now()->diffInDays($assignment->deadline) }} hari
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Submission Form -->
                    <form action="{{ route('submissions.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Hidden Field -->
                        <input type="hidden" name="assignment_id" value="{{ $assignment->id }}">

                        <!-- Submission Method Selection -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Cara Pengumpulan</label>
                            <div class="flex gap-4">
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="submission_method" value="file" checked class="w-4 h-4" onchange="showFileUpload()">
                                    <span class="ml-2 text-gray-700 dark:text-gray-300">📁 Upload File</span>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="submission_method" value="link" class="w-4 h-4" onchange="showLinkInput()">
                                    <span class="ml-2 text-gray-700 dark:text-gray-300">🔗 Link</span>
                                </label>
                            </div>
                        </div>

                        <!-- File Upload Section -->
                        <div id="fileSection" class="mb-6">
                            <label for="file_submission" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Pilih File
                            </label>
                            <div class="relative">
                                <input type="file" 
                                    id="file_submission"
                                    name="file_submission"
                                    class="w-full px-4 py-3 rounded-lg bg-gray-50 dark:bg-gray-700 border-2 border-dashed border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all text-gray-900 dark:text-gray-100 cursor-pointer hover:border-blue-500"
                                    accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.zip,.rar">
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                                📦 Format: PDF, DOC, DOCX, PPT, PPTX, XLS, XLSX, ZIP, RAR (Max 10 MB)
                            </p>
                            <div id="fileName" class="mt-2 text-sm text-blue-600 dark:text-blue-400"></div>
                            @error('file_submission')
                                <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Link Input Section (hidden by default) -->
                        <div id="linkSection" class="mb-6 hidden">
                            <label for="link_submission" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Masukkan Link
                            </label>
                            <input type="url" 
                                id="link_submission"
                                name="link_submission"
                                class="w-full px-4 py-2 rounded-lg bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all text-gray-900 dark:text-gray-100"
                                placeholder="https://github.com/... atau https://drive.google.com/...">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                                🔗 Masukkan link repositori (GitHub, GitLab) atau cloud storage (Google Drive, Dropbox, dll)
                            </p>
                            @error('link_submission')
                                <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="flex gap-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <a href="{{ route('submissions.index') }}"
                                class="flex-1 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-900 dark:text-gray-100 font-semibold py-2 px-4 rounded-lg transition-colors text-center">
                                ← Kembali
                            </a>
                            <button type="submit"
                                class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                                ✓ Kumpulkan Tugas
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        const fileInput = document.getElementById('file_submission');
        const fileNameDisplay = document.getElementById('fileName');

        fileInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                fileNameDisplay.textContent = '✓ File terpilih: ' + this.files[0].name;
            } else {
                fileNameDisplay.textContent = '';
            }
        });

        function showFileUpload() {
            document.getElementById('fileSection').classList.remove('hidden');
            document.getElementById('linkSection').classList.add('hidden');
            document.getElementById('file_submission').required = true;
            document.getElementById('link_submission').required = false;
        }

        function showLinkInput() {
            document.getElementById('fileSection').classList.add('hidden');
            document.getElementById('linkSection').classList.remove('hidden');
            document.getElementById('file_submission').required = false;
            document.getElementById('link_submission').required = true;
        }
    </script>
    @endpush
</x-member-layout>
