<x-mentor-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Daftar Meetings') }}
            </h2>
            <a href="{{ route('meetings.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 dark:bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 dark:hover:bg-blue-600 focus:outline-none transition ease-in-out duration-150">
                + Tambah Meeting
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($meetings->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($meetings as $meeting)
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow duration-300">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                                    {{ $meeting->title }}
                                </h3>
                                
                                <div class="space-y-2 mb-4 text-sm">
                                    <div class="flex items-center text-gray-600 dark:text-gray-400">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <span class="capitalize">{{ $meeting->type ?? 'online' }}</span>
                                    </div>
                                    <div class="flex items-center text-gray-600 dark:text-gray-400">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        {{ $meeting->meeting_date }}
                                    </div>
                                    <div class="flex items-center text-gray-600 dark:text-gray-400">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $meeting->meeting_time }}
                                    </div>
                                </div>

                                <p class="text-gray-700 dark:text-gray-300 text-sm mb-4 line-clamp-3">
                                    {{ $meeting->description }}
                                </p>

                                <div class="flex gap-2">
                                    <a href="{{ $meeting->meeting_link }}" target="_blank" class="flex-1 inline-flex justify-center items-center px-3 py-2 bg-green-600 dark:bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 dark:hover:bg-green-600 focus:outline-none transition ease-in-out duration-150">
                                        Join Meeting
                                    </a>
                                    <a href="{{ route('meetings.edit', $meeting->id) }}" class="inline-flex justify-center items-center px-3 py-2 bg-yellow-600 dark:bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700 dark:hover:bg-yellow-600 focus:outline-none transition ease-in-out duration-150">
                                        Edit
                                    </a>
                                    <form action="{{ route('meetings.destroy', $meeting->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus meeting ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-2 bg-red-600 dark:bg-red-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 dark:hover:bg-red-600 focus:outline-none transition ease-in-out duration-150">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <p class="text-gray-600 dark:text-gray-400">Belum ada meetings. Mulai buat meeting baru!</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-mentor-layout>