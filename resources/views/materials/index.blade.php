<x-mentor-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Daftar Materi') }}
            </h2>
            <a href="{{ route('materials.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                {{ __('+ Tambah Materi') }}
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

            @if ($materials->count() > 0)
                <div class="space-y-4">
                    @foreach ($materials as $material)
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                            <div class="mb-4">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                    {{ $material->title }}
                                </h3>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    {{ $material->description }}
                                </p>
                            </div>

                            <div class="mb-4 text-xs text-gray-500 dark:text-gray-400">
                                <span><strong>Kelas:</strong> {{ $material->class->description ?? 'N/A' }}</span> | 
                                <span><strong>Upload:</strong> {{ $material->created_at->format('d/m/Y H:i') }}</span>
                            </div>

                            <div class="flex gap-2 flex-wrap">
                                <a href="{{ asset('storage/' . $material->file_url) }}" 
                                   class="inline-flex items-center px-3 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150"
                                   target="_blank" 
                                   download>
                                    📥 {{ __('Download') }}
                                </a>
                                <a href="{{ route('materials.edit', $material->id) }}" 
                                   class="inline-flex items-center px-3 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700 focus:bg-yellow-700 active:bg-yellow-900 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                    ✏️ {{ __('Edit') }}
                                </a>
                                <form action="{{ route('materials.destroy', $material->id) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Yakin ingin menghapus materi ini?');"
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
                        {{ __('Belum ada materi.') }}
                    </p>
                    <a href="{{ route('materials.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                        {{ __('Tambah Materi Baru') }}
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-mentor-layout>