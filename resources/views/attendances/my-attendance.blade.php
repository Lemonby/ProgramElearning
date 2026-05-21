<!DOCTYPE html>
<html>
<head>
    <title>Riwayat Kehadiran Saya</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 dark:bg-gray-900">

<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
            
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2">Riwayat Kehadiran Saya</h1>
                <p class="text-gray-600 dark:text-gray-400">Lihat status kehadiran Anda di semua pertemuan</p>
            </div>

            @if($attendances->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-100 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                            <tr>
                                <th class="px-4 py-3 text-left text-gray-700 dark:text-gray-300 font-semibold">No</th>
                                <th class="px-4 py-3 text-left text-gray-700 dark:text-gray-300 font-semibold">Judul Pertemuan</th>
                                <th class="px-4 py-3 text-left text-gray-700 dark:text-gray-300 font-semibold">Kelas</th>
                                <th class="px-4 py-3 text-left text-gray-700 dark:text-gray-300 font-semibold">Status</th>
                                <th class="px-4 py-3 text-left text-gray-700 dark:text-gray-300 font-semibold">Dicatat Oleh</th>
                                <th class="px-4 py-3 text-left text-gray-700 dark:text-gray-300 font-semibold">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($attendances as $index => $attendance)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                    <td class="px-4 py-3 text-gray-900 dark:text-gray-100">{{ $index + 1 }}</td>
                                    <td class="px-4 py-3 text-gray-900 dark:text-gray-100 font-medium">
                                        {{ $attendance->meeting->title }}
                                    </td>
                                    <td class="px-4 py-3 text-gray-700 dark:text-gray-300">
                                        {{ $attendance->meeting->class->description ?? 'N/A' }}
                                    </td>
                                    <td class="px-4 py-3">
                                        @php
                                            $statusColors = [
                                                'hadir' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                                'izin' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                                                'sakit' => 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200',
                                                'alpa' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                                            ];
                                            $statusLabels = [
                                                'hadir' => 'Hadir',
                                                'izin' => 'Izin',
                                                'sakit' => 'Sakit',
                                                'alpa' => 'Alpa',
                                            ];
                                        @endphp
                                        <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold {{ $statusColors[$attendance->status] ?? 'bg-gray-100 text-gray-800' }}">
                                            {{ $statusLabels[$attendance->status] ?? $attendance->status }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-gray-700 dark:text-gray-300">
                                        {{ $attendance->inputBy->name ?? 'System' }}
                                    </td>
                                    <td class="px-4 py-3 text-gray-600 dark:text-gray-400 text-xs">
                                        {{ $attendance->created_at->format('d/m/Y H:i') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Ringkasan Kehadiran -->
                <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Ringkasan Kehadiran</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="bg-green-50 dark:bg-green-900/20 p-4 rounded-lg text-center">
                            <p class="text-2xl font-bold text-green-700 dark:text-green-300">
                                {{ $attendances->where('status', 'hadir')->count() }}
                            </p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Hadir</p>
                        </div>
                        <div class="bg-yellow-50 dark:bg-yellow-900/20 p-4 rounded-lg text-center">
                            <p class="text-2xl font-bold text-yellow-700 dark:text-yellow-300">
                                {{ $attendances->where('status', 'izin')->count() }}
                            </p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Izin</p>
                        </div>
                        <div class="bg-orange-50 dark:bg-orange-900/20 p-4 rounded-lg text-center">
                            <p class="text-2xl font-bold text-orange-700 dark:text-orange-300">
                                {{ $attendances->where('status', 'sakit')->count() }}
                            </p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Sakit</p>
                        </div>
                        <div class="bg-red-50 dark:bg-red-900/20 p-4 rounded-lg text-center">
                            <p class="text-2xl font-bold text-red-700 dark:text-red-300">
                                {{ $attendances->where('status', 'alpa')->count() }}
                            </p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Alpa</p>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-12">
                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                        Belum ada data kehadiran untuk Anda
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>

</body>
</html>