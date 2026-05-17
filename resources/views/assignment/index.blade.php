<x-mentor-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Daftar Assignment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Button Create Assignment -->
            <div class="mb-8 flex justify-end">
                <a 
                    href="{{ route('assignment.create') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition duration-200 inline-flex items-center gap-2"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    + Buat Assignment Baru
                </a>
            </div>

            <!-- Success Message -->
            @if (session('success'))
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6 text-green-700">
                    {{ session('success') }}
                </div>
            @endif

    <!-- Empty State -->
    @if ($assignments->isEmpty())
        <div class="bg-gray-50 rounded-lg border border-gray-200 p-12 text-center">
            <div class="text-gray-400 mb-4">
                <svg class="mx-auto h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum ada assignment</h3>
            <p class="text-gray-600 mb-6">Mulai dengan membuat assignment pertama Anda untuk kelas</p>
            <a 
                href="{{ route('assignment.create') }}"
                class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition duration-200"
            >
                Buat Assignment Pertama
            </a>
        </div>
    @else
        <!-- Assignments Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($assignments as $assignment)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-200">
                    <!-- Card Header -->
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                        <h3 class="text-white font-bold text-lg truncate">{{ $assignment->title }}</h3>
                        <p class="text-blue-100 text-sm mt-1">
                            Kelas: <strong>{{ $assignment->class->name ?? 'N/A' }}</strong>
                        </p>
                    </div>

                    <!-- Card Body -->
                    <div class="px-6 py-4">
                        <!-- Description Preview -->
                        <p class="text-gray-600 text-sm line-clamp-2 mb-3">
                            {{ Str::limit($assignment->description, 100) }}
                        </p>

                        <!-- Deadline -->
                        <div class="mb-3">
                            <p class="text-xs text-gray-500 font-semibold uppercase tracking-wide">Deadline</p>
                            <p class="text-sm font-medium text-gray-900">
                                {{ $assignment->deadline->format('d M Y, H:i') }}
                            </p>
                        </div>

                        <!-- File/Link Status -->
                        @if ($assignment->file_path)
                            <div class="mb-4">
                                @if (Str::startsWith($assignment->file_path, ['http://', 'https://']))
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                        🔗 Link Assignment
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-800">
                                        📄 File Tersedia
                                    </span>
                                @endif
                            </div>
                        @endif

                        <!-- Timestamps -->
                        <div class="text-xs text-gray-400">
                            <p>Dibuat: {{ $assignment->created_at->format('d M Y') }}</p>
                        </div>
                    </div>

                    <!-- Card Footer -->
                    <div class="bg-gray-50 px-6 py-4 flex gap-2">
                        <a 
                            href="{{ route('assignment.show', $assignment->id) }}"
                            class="flex-1 text-center bg-blue-100 hover:bg-blue-200 text-blue-700 font-semibold py-2 px-3 rounded text-sm transition duration-200"
                        >
                            Lihat Detail
                        </a>
                        <a 
                            href="{{ route('assignment.edit', $assignment->id) }}"
                            class="flex-1 text-center bg-yellow-100 hover:bg-yellow-200 text-yellow-700 font-semibold py-2 px-3 rounded text-sm transition duration-200"
                        >
                            Edit
                        </a>
                        <form 
                            action="{{ route('assignment.destroy', $assignment->id) }}" 
                            method="POST" 
                            class="flex-1"
                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus assignment ini?');"
                        >
                            @csrf
                            @method('DELETE')
                            <button 
                                type="submit"
                                class="w-full bg-red-100 hover:bg-red-200 text-red-700 font-semibold py-2 px-3 rounded text-sm transition duration-200"
                            >
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
        </div>
    </div>
</x-mentor-layout>
