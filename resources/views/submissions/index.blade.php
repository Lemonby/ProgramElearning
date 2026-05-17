<x-member-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Kumpul Tugas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success/Error Messages -->
            @if (session('success'))
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6 text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6 text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Assignments Grid -->
            @if ($assignments->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($assignments as $assignment)
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-all duration-200">
                            <!-- Card Header -->
                            <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                                <h3 class="text-white font-bold text-lg truncate">{{ $assignment->title }}</h3>
                                <p class="text-blue-100 text-sm mt-1">
                                    Kelas: <strong>{{ $assignment->class->name ?? 'N/A' }}</strong>
                                </p>
                            </div>

                            <!-- Card Content -->
                            <div class="p-6">
                                <p class="text-gray-600 dark:text-gray-400 text-sm line-clamp-3 mb-4">
                                    {{ $assignment->description }}
                                </p>

                                <!-- Meta Info -->
                                <div class="space-y-2 text-sm mb-6">
                                    <div class="flex items-center justify-between">
                                        <span class="text-gray-600 dark:text-gray-400">📅 Deadline:</span>
                                        <span class="font-semibold text-gray-900 dark:text-gray-100">
                                            {{ $assignment->deadline->format('d M Y H:i') }}
                                        </span>
                                    </div>

                                    <!-- Time Left -->
                                    @php
                                        $now = \Carbon\Carbon::now();
                                        $deadline = $assignment->deadline;
                                        $isOverdue = $now > $deadline;
                                        $daysLeft = $now->diffInDays($deadline);
                                    @endphp
                                    <div class="flex items-center justify-between">
                                        <span class="text-gray-600 dark:text-gray-400">⏱️ Sisa Waktu:</span>
                                        <span class="font-semibold @if ($isOverdue) text-red-600 @else text-green-600 @endif">
                                            @if ($isOverdue)
                                                ⚠️ Terlambat {{ $daysLeft }} hari
                                            @else
                                                {{ $daysLeft }} hari
                                            @endif
                                        </span>
                                    </div>

                                    <!-- Submission Status -->
                                    @php
                                        $userSubmission = $assignment->submissions()
                                            ->where('member_id', auth()->id())
                                            ->first();
                                    @endphp
                                    <div class="flex items-center justify-between">
                                        <span class="text-gray-600 dark:text-gray-400">✓ Status:</span>
                                        @if ($userSubmission)
                                            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">
                                                Sudah Dikumpulkan
                                            </span>
                                        @else
                                            <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-semibold">
                                                Belum Dikumpulkan
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex gap-2 pt-4 border-t border-gray-200 dark:border-gray-700">
                                    <button type="button"
                                        onclick="openSubmissionModal({{ $assignment->id }}, '{{ addslashes($assignment->title) }}')"
                                        class="flex-1 @if ($userSubmission) bg-blue-100 hover:bg-blue-200 text-blue-700 @else bg-blue-600 hover:bg-blue-700 text-white @endif font-semibold py-2 rounded-lg transition-colors text-sm">
                                        @if ($userSubmission)
                                            ✏️ Ubah
                                        @else
                                            📤 Kumpulkan
                                        @endif
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-12 text-center">
                    <p class="text-gray-500 dark:text-gray-400 text-lg">📭 Tidak ada tugas yang tersedia saat ini</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Submission -->
    <div id="submissionModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full max-h-[90vh] overflow-y-auto">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-6 sticky top-0 flex justify-between items-center">
                <div>
                    <h2 class="text-xl font-bold text-white">Kumpulkan Tugas</h2>
                    <p id="modalAssignmentTitle" class="text-blue-100 text-sm mt-1"></p>
                </div>
                <button type="button" onclick="closeSubmissionModal()" class="text-white text-2xl hover:text-blue-100">
                    ✕
                </button>
            </div>

            <!-- Modal Body -->
            <form id="submissionForm" action="{{ route('submissions.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf

                <!-- Hidden Fields -->
                <input type="hidden" id="assignmentId" name="assignmentId">
                <input type="hidden" id="memberId" name="memberId" value="{{ auth()->id() }}">

                <!-- Nama Siswa (readonly) -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nama Anda</label>
                    <input type="text"
                        value="{{ auth()->user()->name }}"
                        readonly
                        class="w-full px-4 py-2 rounded-lg bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-400 cursor-not-allowed">
                    <input type="hidden" name="namaSiswa" value="{{ auth()->user()->name }}">
                </div>

                <!-- Judul Tugas (readonly) -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Judul Tugas</label>
                    <input type="text"
                        id="judulTugas"
                        name="judulTugas"
                        readonly
                        class="w-full px-4 py-2 rounded-lg bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-400 cursor-not-allowed">
                </div>

                <!-- File Upload atau Link (dengan tab selection) -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Cara Pengumpulan</label>
                    <div class="flex gap-2 mb-3">
                        <button type="button"
                            onclick="switchTab('file')"
                            class="flex-1 px-3 py-2 rounded-lg bg-blue-600 text-white text-sm font-semibold transition-all"
                            id="tabFile">
                            📁 Upload File
                        </button>
                        <button type="button"
                            onclick="switchTab('link')"
                            class="flex-1 px-3 py-2 rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm font-semibold transition-all hover:bg-gray-300 dark:hover:bg-gray-600"
                            id="tabLink">
                            🔗 Link
                        </button>
                    </div>

                    <!-- File Input -->
                    <div id="fileSection" class="mb-2">
                        <input type="file" name="fileTugas"
                            class="w-full px-4 py-2 rounded-lg bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all text-gray-900 dark:text-gray-100"
                            accept=".pdf,.doc,.docx,.zip,.rar,.txt,.xlsx">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">📦 Format: PDF, DOC, DOCX, ZIP, RAR (Max 5MB)</p>
                    </div>

                    <!-- Link Input -->
                    <div id="linkSection" class="mb-2 hidden">
                        <input type="url" name="linkTugas"
                            class="w-full px-4 py-2 rounded-lg bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all text-gray-900 dark:text-gray-100"
                            placeholder="https://github.com/... atau https://drive.google.com/...">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">🔗 Masukkan link repositori atau drive</p>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <button type="button"
                        onclick="closeSubmissionModal()"
                        class="flex-1 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-900 dark:text-gray-100 font-semibold py-2 rounded-lg transition-colors">
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg transition-colors">
                        ✓ Kumpulkan
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        function openSubmissionModal(assignmentId, title) {
            document.getElementById('assignmentId').value = assignmentId;
            document.getElementById('judulTugas').value = title;
            document.getElementById('modalAssignmentTitle').textContent = title;
            document.getElementById('submissionModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeSubmissionModal() {
            document.getElementById('submissionModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
            document.getElementById('submissionForm').reset();
        }

        function switchTab(tab) {
            if (tab === 'file') {
                document.getElementById('fileSection').classList.remove('hidden');
                document.getElementById('linkSection').classList.add('hidden');
                document.getElementById('tabFile').classList.add('bg-blue-600', 'text-white');
                document.getElementById('tabFile').classList.remove('bg-gray-200', 'dark:bg-gray-700', 'text-gray-700', 'dark:text-gray-300');
                document.getElementById('tabLink').classList.remove('bg-blue-600', 'text-white');
                document.getElementById('tabLink').classList.add('bg-gray-200', 'dark:bg-gray-700', 'text-gray-700', 'dark:text-gray-300');
                document.querySelector('input[name="fileTugas"]').required = true;
                document.querySelector('input[name="linkTugas"]').required = false;
            } else {
                document.getElementById('fileSection').classList.add('hidden');
                document.getElementById('linkSection').classList.remove('hidden');
                document.getElementById('tabLink').classList.add('bg-blue-600', 'text-white');
                document.getElementById('tabLink').classList.remove('bg-gray-200', 'dark:bg-gray-700', 'text-gray-700', 'dark:text-gray-300');
                document.getElementById('tabFile').classList.remove('bg-blue-600', 'text-white');
                document.getElementById('tabFile').classList.add('bg-gray-200', 'dark:bg-gray-700', 'text-gray-700', 'dark:text-gray-300');
                document.querySelector('input[name="fileTugas"]').required = false;
                document.querySelector('input[name="linkTugas"]').required = true;
            }
        }

        // Close modal when clicking outside
        document.getElementById('submissionModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeSubmissionModal();
            }
        });
    </script>
    @endpush
</x-member-layout>
