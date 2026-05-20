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
                    <span class="font-semibold">✓ Sukses!</span> {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6 text-red-700">
                    <span class="font-semibold">⚠ Gagal!</span> {{ session('error') }}
                </div>
            @endif

            @if (session('info'))
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6 text-blue-700">
                    <span class="font-semibold">ℹ Info:</span> {{ session('info') }}
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
                                    @if ($userSubmission)
                                        <a href="{{ route('submissions.show', $userSubmission->id) }}"
                                            class="flex-1 bg-green-100 hover:bg-green-200 text-green-700 font-semibold py-2 px-4 rounded-lg transition-colors text-sm text-center">
                                            👁️ Lihat Detail
                                        </a>
                                        <a href="{{ route('submissions.edit', $userSubmission->id) }}"
                                            class="flex-1 bg-blue-100 hover:bg-blue-200 text-blue-700 font-semibold py-2 px-4 rounded-lg transition-colors text-sm text-center">
                                            ✏️ Ubah
                                        </a>
                                    @else
                                        <a href="{{ route('submissions.create', $assignment->id) }}"
                                            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors text-sm text-center">
                                            📤 Kumpulkan
                                        </a>
                                    @endif
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
</x-member-layout>
