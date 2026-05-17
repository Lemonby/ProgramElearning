<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Tugas - E-Learning</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-slate-900 text-white min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-blue-400 mb-2">Daftar Tugas</h1>
            <p class="text-slate-400">Pilih tugas untuk dikumpulkan</p>
        </div>

        <!-- Success/Error Messages -->
        @if (session('success'))
            <div class="bg-green-500/20 border border-green-500 text-green-400 p-4 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-500/20 border border-red-500 text-red-400 p-4 rounded-lg mb-6">
                {{ session('error') }}
            </div>
        @endif

        <!-- Assignments Grid -->
        @if ($assignments->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($assignments as $assignment)
                    <div class="bg-slate-800 border border-slate-700 rounded-xl overflow-hidden hover:border-blue-500 transition-all">
                        <!-- Card Header -->
                        <div class="bg-gradient-to-r from-blue-600 to-blue-500 p-4">
                            <h3 class="text-xl font-bold text-white">{{ $assignment->title }}</h3>
                        </div>

                        <!-- Card Content -->
                        <div class="p-6">
                            <p class="text-slate-300 text-sm mb-4 line-clamp-3">{{ $assignment->description }}</p>

                            <!-- Meta Info -->
                            <div class="space-y-3 mb-6 text-sm">
                                <div class="flex items-center justify-between">
                                    <span class="text-slate-400">📅 Deadline:</span>
                                    <span class="text-slate-200 font-semibold">
                                        {{ $assignment->deadline->format('d M Y H:i') }}
                                    </span>
                                </div>
                                
                                <div class="flex items-center justify-between">
                                    <span class="text-slate-400">⏱️ Sisa Waktu:</span>
                                    @php
                                        $now = \Carbon\Carbon::now();
                                        $deadline = $assignment->deadline;
                                        $isOverdue = $now > $deadline;
                                        $daysLeft = $now->diffInDays($deadline);
                                    @endphp
                                    <span class="@if ($isOverdue) text-red-400 @else text-green-400 @endif font-semibold">
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
                                    <span class="text-slate-400">✓ Status:</span>
                                    @if ($userSubmission)
                                        <span class="bg-green-500/20 text-green-400 px-3 py-1 rounded-full text-xs font-semibold">
                                            Sudah Dikumpulkan
                                        </span>
                                    @else
                                        <span class="bg-yellow-500/20 text-yellow-400 px-3 py-1 rounded-full text-xs font-semibold">
                                            Belum Dikumpulkan
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex gap-2">
                                @if (!$userSubmission)
                                    <button type="button" 
                                        onclick="openSubmissionModal({{ $assignment->id }}, '{{ $assignment->title }}')"
                                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg transition-colors">
                                        📤 Kumpulkan
                                    </button>
                                @else
                                    <button type="button" 
                                        onclick="openSubmissionModal({{ $assignment->id }}, '{{ $assignment->title }}')"
                                        class="flex-1 bg-slate-600 hover:bg-slate-700 text-white font-semibold py-2 rounded-lg transition-colors">
                                        ✏️ Ubah Submission
                                    </button>
                                @endif
                                
                                <button type="button" 
                                    class="flex-1 bg-slate-700 hover:bg-slate-600 text-white font-semibold py-2 rounded-lg transition-colors">
                                    👁️ Detail
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-slate-800 border border-slate-700 rounded-xl p-12 text-center">
                <p class="text-slate-400 text-lg">📭 Tidak ada tugas yang tersedia saat ini</p>
            </div>
        @endif
    </div>

    <!-- Modal Submission -->
    <div id="submissionModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
        <div class="bg-slate-800 rounded-xl shadow-2xl border border-slate-700 max-w-md w-full max-h-[90vh] overflow-y-auto">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-500 p-6 sticky top-0 flex justify-between items-center">
                <div>
                    <h2 class="text-xl font-bold text-white">Kumpulkan Tugas</h2>
                    <p id="modalAssignmentTitle" class="text-blue-100 text-sm mt-1"></p>
                </div>
                <button type="button" onclick="closeSubmissionModal()" class="text-white text-2xl hover:text-blue-100">
                    ✕
                </button>
            </div>

            <!-- Modal Body -->
            <form id="submissionForm" action="{{ route('pengumpulan_tugas.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                
                <!-- Hidden Fields -->
                <input type="hidden" id="assignmentId" name="assignmentId">
                <input type="hidden" id="memberId" name="memberId" value="{{ auth()->id() }}">

                <!-- Nama Siswa (readonly from session) -->
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">Nama Anda</label>
                    <input type="text" 
                        value="{{ auth()->user()->name }}" 
                        readonly
                        class="w-full px-4 py-2 rounded-lg bg-slate-700 border border-slate-600 text-slate-300 cursor-not-allowed">
                    <input type="hidden" name="namaSiswa" value="{{ auth()->user()->name }}">
                </div>

                <!-- Judul Tugas (readonly) -->
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">Judul Tugas</label>
                    <input type="text" 
                        id="judulTugas"
                        name="judulTugas"
                        readonly
                        class="w-full px-4 py-2 rounded-lg bg-slate-700 border border-slate-600 text-slate-300 cursor-not-allowed">
                </div>

                <!-- File Upload atau Link (dengan tab selection) -->
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">Cara Pengumpulan</label>
                    <div class="flex gap-2 mb-3">
                        <button type="button" 
                            onclick="switchTab('file')"
                            class="flex-1 px-3 py-2 rounded-lg bg-blue-600 text-white text-sm font-semibold transition-all" 
                            id="tabFile">
                            📁 Upload File
                        </button>
                        <button type="button" 
                            onclick="switchTab('link')"
                            class="flex-1 px-3 py-2 rounded-lg bg-slate-700 text-slate-300 text-sm font-semibold transition-all hover:bg-slate-600"
                            id="tabLink">
                            🔗 Link
                        </button>
                    </div>

                    <!-- File Input -->
                    <div id="fileSection" class="mb-2">
                        <input type="file" name="fileTugas" 
                            class="w-full px-4 py-2 rounded-lg bg-slate-700 border border-slate-600 focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all text-slate-300"
                            accept=".pdf,.doc,.docx,.zip,.rar,.txt,.xlsx">
                        <p class="text-xs text-slate-400 mt-2">📦 Format: PDF, DOC, DOCX, ZIP, RAR (Max 5MB)</p>
                    </div>

                    <!-- Link Input -->
                    <div id="linkSection" class="mb-2 hidden">
                        <input type="url" name="linkTugas" 
                            class="w-full px-4 py-2 rounded-lg bg-slate-700 border border-slate-600 focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all"
                            placeholder="https://github.com/... atau https://drive.google.com/...">
                        <p class="text-xs text-slate-400 mt-2">🔗 Masukkan link repositori atau drive</p>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex gap-3 pt-4 border-t border-slate-700">
                    <button type="button" 
                        onclick="closeSubmissionModal()"
                        class="flex-1 bg-slate-700 hover:bg-slate-600 text-white font-semibold py-2 rounded-lg transition-colors">
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
                document.getElementById('tabFile').classList.remove('bg-slate-700', 'text-slate-300');
                document.getElementById('tabLink').classList.remove('bg-blue-600', 'text-white');
                document.getElementById('tabLink').classList.add('bg-slate-700', 'text-slate-300');
                document.querySelector('input[name="fileTugas"]').required = true;
                document.querySelector('input[name="linkTugas"]').required = false;
            } else {
                document.getElementById('fileSection').classList.add('hidden');
                document.getElementById('linkSection').classList.remove('hidden');
                document.getElementById('tabLink').classList.add('bg-blue-600', 'text-white');
                document.getElementById('tabLink').classList.remove('bg-slate-700', 'text-slate-300');
                document.getElementById('tabFile').classList.remove('bg-blue-600', 'text-white');
                document.getElementById('tabFile').classList.add('bg-slate-700', 'text-slate-300');
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
</body>
</html>
