<x-mentor-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Absensi - ') }} {{ $meeting->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                @if ($errors->any())
                    <div class="mb-4 px-4 py-3 bg-red-100 border border-red-400 text-red-700 rounded dark:bg-red-900 dark:border-red-700 dark:text-red-100">
                        <strong>{{ __('Error:') }}</strong>
                        <ul class="list-disc list-inside mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

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

                <form action="{{ route('attendances.update', $meeting->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Members Attendance Form -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                            {{ __('Update Kehadiran Member') }}
                        </h3>

                        <div class="space-y-4">
                            @foreach($members as $index => $member)
                                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                    <div class="flex items-center justify-between mb-3">
                                        <label class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                            {{ $index + 1 }}. {{ $member->name }}
                                        </label>
                                    </div>
                                    <div class="flex gap-4 flex-wrap">
                                        @php
                                            $currentStatus = $existingAttendances->get($member->id, 'hadir');
                                        @endphp
                                        <label class="flex items-center">
                                            <input type="radio" 
                                                   name="attendances[{{ $index }}][status]" 
                                                   value="hadir" 
                                                   {{ $currentStatus === 'hadir' ? 'checked' : '' }} 
                                                   class="w-4 h-4 text-green-600" 
                                                   required>
                                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Hadir</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="radio" 
                                                   name="attendances[{{ $index }}][status]" 
                                                   value="izin" 
                                                   {{ $currentStatus === 'izin' ? 'checked' : '' }} 
                                                   class="w-4 h-4 text-yellow-600" 
                                                   required>
                                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Izin</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="radio" 
                                                   name="attendances[{{ $index }}][status]" 
                                                   value="sakit" 
                                                   {{ $currentStatus === 'sakit' ? 'checked' : '' }} 
                                                   class="w-4 h-4 text-orange-600" 
                                                   required>
                                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Sakit</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="radio" 
                                                   name="attendances[{{ $index }}][status]" 
                                                   value="alpa" 
                                                   {{ $currentStatus === 'alpa' ? 'checked' : '' }} 
                                                   class="w-4 h-4 text-red-600" 
                                                   required>
                                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Alpa</span>
                                        </label>
                                    </div>
                                    <input type="hidden" name="attendances[{{ $index }}][member_id]" value="{{ $member->id }}">
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-3 justify-end pt-6 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('attendances.index') }}">
                            <x-secondary-button>
                                {{ __('Batal') }}
                            </x-secondary-button>
                        </a>
                        <x-primary-button>
                            {{ __('Simpan Perubahan') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-mentor-layout>