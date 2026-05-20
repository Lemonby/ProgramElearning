<x-member-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $material->title }}
            </h2>
            <a href="{{ route('member-materials.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                {{ __('Kembali') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Material Header Card -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <!-- Badge Class -->
                    <div class="mb-4">
                        <span class="inline-block px-3 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-100 text-xs font-semibold rounded-full">
                            {{ $material->class->description ?? 'Kelas' }}
                        </span>
                    </div>

                    <!-- Title -->
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-4">
                        {{ $material->title }}
                    </h1>

                    <!-- Meta Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6 pb-6 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center text-gray-600 dark:text-gray-400">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span>{{ $material->created_at->translatedFormat('d F Y') }}</span>
                        </div>
                        <div class="flex items-center text-gray-600 dark:text-gray-400">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>{{ $material->created_at->format('H:i') }} WIB</span>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-3">
                            {{ __('Deskripsi') }}
                        </h3>
                        <div class="prose prose-sm dark:prose-invert max-w-none">
                            <p class="text-gray-700 dark:text-gray-300 whitespace-pre-wrap">
                                {{ $material->description }}
                            </p>
                        </div>
                    </div>

                    <!-- Download Section -->
                    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-6">
                        <div class="flex items-center mb-4">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                            <h3 class="text-lg font-semibold text-blue-900 dark:text-blue-100">
                                {{ __('File Materi') }}
                            </h3>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                            {{ __('Klik tombol di bawah untuk mengunduh file materi pembelajaran.') }}
                        </p>
                        <a href="{{ route('member-materials.download', $material->id) }}" 
                           class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                            {{ __('Unduh File') }}
                        </a>
                    </div>
                </div>
            </div>

            <!-- Additional Info Card -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                        {{ __('Informasi Materi') }}
                    </h3>
                    <dl class="space-y-4">
                        <div class="flex justify-between">
                            <dt class="text-gray-600 dark:text-gray-400">{{ __('Kelas') }}</dt>
                            <dd class="text-gray-900 dark:text-gray-100 font-medium">{{ $material->class->description ?? 'N/A' }}</dd>
                        </div>
                        <div class="flex justify-between border-t border-gray-200 dark:border-gray-700 pt-4">
                            <dt class="text-gray-600 dark:text-gray-400">{{ __('Tanggal Unggah') }}</dt>
                            <dd class="text-gray-900 dark:text-gray-100 font-medium">{{ $material->created_at->translatedFormat('d F Y H:i') }}</dd>
                        </div>
                        <div class="flex justify-between border-t border-gray-200 dark:border-gray-700 pt-4">
                            <dt class="text-gray-600 dark:text-gray-400">{{ __('Status') }}</dt>
                            <dd class="text-gray-900 dark:text-gray-100 font-medium">
                                <span class="inline-block px-3 py-1 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-100 text-xs font-semibold rounded-full">
                                    {{ __('Tersedia') }}
                                </span>
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</x-member-layout>
