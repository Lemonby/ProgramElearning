<x-mentor-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Absensi - ') }} {{ $meeting->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <!-- Meeting Info -->
                <div class="mb-6 pb-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                        Informasi Pertemuan
                    </h3>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-gray-600 dark:text-gray-400">Judul</p>
                            <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $meeting->title }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 dark:text-gray-400">Kelas</p>
                            <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $meeting->class->description ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Attendance Summary -->
                <div class="mb-6 pb-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                        Ringkasan Kehadiran
                    </h3>
                    <div class="grid grid-cols-4 gap-3">
                        <div class="bg-green-50 dark:bg-green-900/20 p-4 rounded-lg text-center">
                            <p class="text-2xl font-bold text-green-700 dark:text-green-300">
                                {{ $meeting->attendances->where('status', 'hadir')->count() }}
                            </p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Hadir</p>
                        </div>
                        <div class="bg-yellow-50 dark:bg-yellow-900/20 p-4 rounded-lg text-center">
                            <p class="text-2xl font-bold text-yellow-700 dark:text-yellow-300">
                                {{ $meeting->attendances->where('status', 'izin')->count() }}
                            </p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Izin</p>
                        </div>
                        <div class="bg-orange-50 dark:bg-orange-900/20 p-4 rounded-lg text-center">
                            <p class="text-2xl font-bold text-orange-700 dark:text-orange-300">
                                {{ $meeting->attendances->where('status', 'sakit')->count() }}
                            </p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Sakit</p>
                        </div>
                        <div class="bg-red-50 dark:bg-red-900/20 p-4 rounded-lg text-center">
                            <p class="text-2xl font-bold text-red-700 dark:text-red-300">
                                {{ $meeting->attendances->where('status', 'alpa')->count() }}
                            </p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Alpa</p>
                        </div>
                    </div>
                </div>

                <!-- Attendance List -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                        Daftar Kehadiran Member
                    </h3>
                    @if ($meeting->attendances->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead class="bg-gray-100 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-gray-700 dark:text-gray-300 font-semibold">No</th>
                                        <th class="px-4 py-3 text-left text-gray-700 dark:text-gray-300 font-semibold">Nama Member</th>
                                        <th class="px-4 py-3 text-left text-gray-700 dark:text-gray-300 font-semibold">Status</th>
                                        <th class="px-4 py-3 text-left text-gray-700 dark:text-gray-300 font-semibold">Input Oleh</th>
                                        <th class="px-4 py-3 text-left text-gray-700 dark:text-gray-300 font-semibold">Waktu</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach ($meeting->attendances as $index => $attendance)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <td class="px-4 py-3 text-gray-900 dark:text-gray-100">{{ $index + 1 }}</td>
                                            <td class="px-4 py-3 text-gray-900 dark:text-gray-100">{{ $attendance->member->name }}</td>
                                            <td class="px-4 py-3">
                                                @php
                                                    $statusClass = [
                                                        'hadir' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                                        'izin' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                                                        'sakit' => 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200',
                                                        'alpa' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                                                    ];
                                                    $statusLabel = [
                                                        'hadir' => 'Hadir',
                                                        'izin' => 'Izin',
                                                        'sakit' => 'Sakit',
                                                        'alpa' => 'Alpa',
                                                    ];
                                                @endphp
                                                <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold {{ $statusClass[$attendance->status] ?? '' }}">
                                                    {{ $statusLabel[$attendance->status] ?? $attendance->status }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 text-gray-600 dark:text-gray-400">{{ $attendance->inputBy->name ?? 'System' }}</td>
                                            <td class="px-4 py-3 text-gray-600 dark:text-gray-400 text-xs">{{ $attendance->created_at->format('d/m/Y H:i') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500 dark:text-gray-400 text-center py-4">
                            Belum ada data kehadiran untuk pertemuan ini
                        </p>
                    @endif
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-3">
                    <a href="{{ route('attendances.edit', $meeting->id) }}" 
                       class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700 focus:bg-yellow-700 active:bg-yellow-900 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                        ✏️ {{ __('Edit Absensi') }}
                    </a>
                    <a href="{{ route('attendances.index') }}" 
                       class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                        {{ __('← Kembali') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-mentor-layout>