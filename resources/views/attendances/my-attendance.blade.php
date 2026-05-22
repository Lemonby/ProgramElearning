<x-member-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-white">Detail Kehadiran</h2>
    </x-slot>

    <div class="min-h-screen bg-gradient-to-b from-[#020617] to-purple-900 p-4 md:p-8">
        <div class="max-w-7xl mx-auto space-y-6">
            <div class="bg-gradient-to-r from-purple-700 to-purple-800 text-white rounded-2xl p-6 md:p-8">
                <h1 class="text-2xl md:text-4xl font-bold">Riwayat Kehadiran Saya</h1>
                <p class="text-purple-100 mt-2">Ringkasan status hadir, sakit, dan alpha untuk kelas Anda.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach ($summaryCards as $card)
                    <div class="bg-white/10 backdrop-blur-xl rounded-2xl border border-white/20 p-5 text-center">
                        <p class="text-gray-300 text-sm">{{ $card['label'] }}</p>
                        <p class="text-3xl font-bold text-white mt-2">{{ $card['count'] }}</p>
                        <p class="text-xs text-gray-300 mt-1">catatan</p>
                    </div>
                @endforeach
            </div>

            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-200">
                    <h3 class="text-xl font-bold text-slate-800">Detail Kehadiran</h3>
                </div>

                @if($attendances->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead class="bg-slate-50 border-b border-slate-200">
                                <tr>
                                    <th class="px-4 py-3 text-left text-slate-700 font-semibold">No</th>
                                    <th class="px-4 py-3 text-left text-slate-700 font-semibold">Tanggal Meet</th>
                                    <th class="px-4 py-3 text-left text-slate-700 font-semibold">Topik / Judul Pertemuan</th>
                                    <th class="px-4 py-3 text-left text-slate-700 font-semibold">Kelas</th>
                                    <th class="px-4 py-3 text-left text-slate-700 font-semibold">Tipe Pertemuan</th>
                                    <th class="px-4 py-3 text-left text-slate-700 font-semibold">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach ($attendances as $index => $attendance)
                                    <tr class="hover:bg-slate-50">
                                        <td class="px-4 py-3 text-slate-700">{{ $index + 1 }}</td>
                                        <td class="px-4 py-3 text-slate-700">
                                            {{ \Carbon\Carbon::parse($attendance->meeting->meeting_date)->format('d M Y') }}
                                        </td>
                                        <td class="px-4 py-3 text-slate-800 font-medium">
                                            {{ $attendance->meeting->title }}
                                        </td>
                                        <td class="px-4 py-3 text-slate-700">
                                            {{ $attendance->meeting->class->name ?? 'N/A' }}
                                        </td>
                                        <td class="px-4 py-3 text-slate-700 capitalize">
                                            {{ $attendance->meeting->type ?? 'online' }}
                                        </td>
                                        <td class="px-4 py-3">
                                            @php
                                                $statusColors = [
                                                    'hadir' => 'bg-emerald-100 text-emerald-700',
                                                    'izin' => 'bg-amber-100 text-amber-700',
                                                    'sakit' => 'bg-rose-100 text-rose-700',
                                                    'alpa' => 'bg-slate-100 text-slate-700',
                                                ];
                                                $statusLabels = [
                                                    'hadir' => 'Hadir',
                                                    'izin' => 'Izin',
                                                    'sakit' => 'Sakit',
                                                    'alpa' => 'Alpha',
                                                ];
                                            @endphp
                                            <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold {{ $statusColors[$attendance->status] ?? 'bg-slate-100 text-slate-700' }}">
                                                {{ $statusLabels[$attendance->status] ?? $attendance->status }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-8 text-center text-slate-500">
                        Belum ada data kehadiran untuk Anda.
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-member-layout>