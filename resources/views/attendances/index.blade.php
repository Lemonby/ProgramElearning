<x-mentor-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Daftar Absensi') }}
            </h2>
            <a href="{{ route('attendances.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                {{ __('+ Buat Absensi') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 px-4 py-3 bg-green-100 border border-green-400 text-green-700 rounded dark:bg-green-900 dark:border-green-700 dark:text-green-100">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 px-4 py-3 bg-red-100 border border-red-400 text-red-700 rounded dark:bg-red-900 dark:border-red-700 dark:text-red-100">
                    {{ session('error') }}
                </div>
            @endif

            @if ($meetings->count() > 0)
                <div class="space-y-4">
                    @foreach ($meetings as $meeting)
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                            <div class="mb-4">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                            {{ $meeting->title }}
                                        </h3>
                                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                            Kelas: <strong>{{ $meeting->class->description ?? 'N/A' }}</strong>
                                        </p>
                                    </div>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-100">
                                        {{ $meeting->attendances->count() }} / {{ $meeting->class->members->count() }}
                                    </span>
                                </div>
                            </div>

                            <div class="mb-4 text-xs text-gray-500 dark:text-gray-400 space-y-1">
                                <p>
                                    <strong>Keterangan:</strong> {{ substr($meeting->description ?? 'Tidak ada keterangan', 0, 100) }}
                                </p>
                            </div>

                            <!-- Attendance Summary -->
                            <div class="mb-4 grid grid-cols-4 gap-2 text-sm">
                                <div class="bg-green-50 dark:bg-green-900/20 p-2 rounded">
                                    <p class="text-green-700 dark:text-green-300 font-semibold">
                                        {{ $meeting->attendances->where('status', 'hadir')->count() }}
                                    </p>
                                    <p class="text-xs text-gray-600 dark:text-gray-400">Hadir</p>
                                </div>
                                <div class="bg-yellow-50 dark:bg-yellow-900/20 p-2 rounded">
                                    <p class="text-yellow-700 dark:text-yellow-300 font-semibold">
                                        {{ $meeting->attendances->where('status', 'izin')->count() }}
                                    </p>
                                    <p class="text-xs text-gray-600 dark:text-gray-400">Izin</p>
                                </div>
                                <div class="bg-orange-50 dark:bg-orange-900/20 p-2 rounded">
                                    <p class="text-orange-700 dark:text-orange-300 font-semibold">
                                        {{ $meeting->attendances->where('status', 'sakit')->count() }}
                                    </p>
                                    <p class="text-xs text-gray-600 dark:text-gray-400">Sakit</p>
                                </div>
                                <div class="bg-red-50 dark:bg-red-900/20 p-2 rounded">
                                    <p class="text-red-700 dark:text-red-300 font-semibold">
                                        {{ $meeting->attendances->where('status', 'alpa')->count() }}
                                    </p>
                                    <p class="text-xs text-gray-600 dark:text-gray-400">Alpa</p>
                                </div>
                            </div>

                            <div class="flex gap-2 flex-wrap">
                                <a href="{{ route('attendances.show', $meeting->id) }}" 
                                   class="inline-flex items-center px-3 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                    👁️ {{ __('Lihat Detail') }}
                                </a>
                                <a href="{{ route('attendances.edit', $meeting->id) }}" 
                                   class="inline-flex items-center px-3 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700 focus:bg-yellow-700 active:bg-yellow-900 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                    ✏️ {{ __('Edit') }}
                                </a>
                                <form action="{{ route('attendances.destroy', $meeting->id) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Yakin ingin menghapus semua absensi untuk pertemuan ini?');"
                                      class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-3 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                        🗑️ {{ __('Hapus') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-12 text-center">
                    <p class="text-gray-500 dark:text-gray-400 mb-4">
                        {{ __('Belum ada data absensi.') }}
                    </p>
                    <a href="{{ route('attendances.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                        {{ __('Buat Absensi Baru') }}
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-mentor-layout>