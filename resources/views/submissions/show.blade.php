<x-member-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Submission') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                <!-- Header -->
                <div class="bg-gradient-to-r from-green-500 to-green-600 px-6 py-4">
                    <h3 class="text-xl font-bold text-white">{{ $submission->assignment->title }}</h3>
                    <p class="text-green-100 text-sm mt-1">
                        Kelas: {{ $submission->assignment->class->name ?? 'N/A' }}
                    </p>
                </div>

                <!-- Content -->
                <div class="p-6">
                    <!-- Status Badge -->
                    <div class="mb-6 flex gap-2">
                        <span class="inline-block bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">
                            ✓ Sudah Dikumpulkan
                        </span>
                        @if($submission->graded_at)
                            <span class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold">
                                📝 Sudah Dinilai
                            </span>
                        @else
                            <span class="inline-block bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-semibold">
                                ⏳ Menunggu Penilaian
                            </span>
                        @endif
                    </div>

                    <!-- Assignment Info -->
                    <div class="mb-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600">
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-2">📋 Informasi Tugas</h4>
                        <p class="text-gray-700 dark:text-gray-300 text-sm mb-3">{{ $submission->assignment->description }}</p>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-gray-600 dark:text-gray-400">📅 Deadline:</span>
                                <p class="font-semibold text-gray-900 dark:text-white">
                                    {{ $submission->assignment->deadline->format('d M Y H:i') }}
                                </p>
                            </div>
                            <div>
                                <span class="text-gray-600 dark:text-gray-400">✓ Dikumpulkan:</span>
                                <p class="font-semibold text-gray-900 dark:text-white">
                                    {{ $submission->submitted_at->format('d M Y H:i') }}
                                </p>
                            </div>
                        </div>
                        @if($submission->graded_at)
                            <div class="grid grid-cols-2 gap-4 text-sm mt-3 pt-3 border-t border-gray-300 dark:border-gray-600">
                                <div>
                                    <span class="text-gray-600 dark:text-gray-400">📝 Dinilai:</span>
                                    <p class="font-semibold text-gray-900 dark:text-white">
                                        {{ $submission->graded_at->format('d M Y H:i') }}
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Submission Content -->
                    <div class="mb-6 p-4 bg-blue-50 dark:bg-gray-700 rounded-lg border border-blue-200 dark:border-gray-600">
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-4">📨 Submission Anda</h4>
                        
                        @if($submission->is_upload)
                            <!-- File Display -->
                            <div class="flex items-center gap-3 p-3 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600">
                                <span class="text-2xl">📄</span>
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-900 dark:text-white text-sm">
                                        {{ basename($submission->file_url) }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        File Upload
                                    </p>
                                </div>
                                <a href="{{ route('submissions.download', $submission->id) }}" 
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm font-semibold transition-colors">
                                    ⬇️ Download
                                </a>
                            </div>
                        @else
                            <!-- Link Display -->
                            <div class="flex items-center gap-3 p-3 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600">
                                <span class="text-2xl">🔗</span>
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-900 dark:text-white text-sm break-all">
                                        {{ $submission->file_url }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        Link External
                                    </p>
                                </div>
                                <a href="{{ $submission->file_url }}" 
                                    target="_blank"
                                    class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm font-semibold transition-colors">
                                    🔗 Kunjungi
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Member Info -->
                    <div class="mb-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600">
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-2">👤 Informasi Pengumpul</h4>
                        <p class="text-gray-700 dark:text-gray-300 text-sm">
                            <strong>Nama:</strong> {{ $submission->member->name }}<br>
                            <strong>Email:</strong> {{ $submission->member->email }}<br>
                            <strong>Role:</strong> {{ ucfirst($submission->member->role) }}
                        </p>
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('submissions.index') }}"
                            class="flex-1 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-900 dark:text-gray-100 font-semibold py-2 px-4 rounded-lg transition-colors text-center">
                            ← Kembali
                        </a>
                        
                        @if(now() <= $submission->assignment->deadline)
                            <a href="{{ route('submissions.edit', $submission->id) }}"
                                class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors text-center">
                                ✏️ Ubah
                            </a>
                            <form action="{{ route('submissions.destroy', $submission->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Yakin ingin menghapus submission ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                                    🗑️ Hapus
                                </button>
                            </form>
                        @else
                            <div class="flex-1 bg-gray-300 dark:bg-gray-600 text-gray-600 dark:text-gray-400 font-semibold py-2 px-4 rounded-lg text-center cursor-not-allowed">
                                ⚠️ Deadline Lewat
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-member-layout>
