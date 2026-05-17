<x-member-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard Member') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Selamat datang, Member! 👋</h3>
                    <p class="text-gray-600 dark:text-gray-400">{{ __("Lihat materi, kerjakan tugas, dan pantau progress Anda di sini.") }}</p>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="mt-8">
                <a href="{{ route('submissions.index') }}" class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold py-3 px-6 rounded-lg shadow-md transition-all duration-200 inline-flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Kumpulkan Tugas
                </a>
            </div>
        </div>
    </div>
</x-member-layout>
