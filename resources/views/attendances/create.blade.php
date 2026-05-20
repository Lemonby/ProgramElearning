<x-mentor-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Buat Absensi') }}
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

                <form action="{{ route('attendances.store') }}" method="POST" id="attendanceForm" class="space-y-6">
                    @csrf

                    <!-- Pilih Meeting -->
                    <div>
                        <label for="meeting_id" class="block font-medium text-sm text-gray-700 dark:text-gray-300">
                            {{ __('Pilih Pertemuan') }} <span class="text-red-600">*</span>
                        </label>
                        <select id="meeting_id" 
                                name="meeting_id" 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                required
                                onchange="loadMembers(this.value)">
                            <option value="">-- {{ __('Pilih Pertemuan') }} --</option>
                            @foreach($meetings as $meeting)
                                <option value="{{ $meeting->id }}">
                                    {{ $meeting->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Loading Indicator -->
                    <div id="loadingIndicator" class="hidden text-center py-4">
                        <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                        <p class="text-gray-600 dark:text-gray-400 mt-2">{{ __('Memuat data member...') }}</p>
                    </div>

                    <!-- Members Attendance Form -->
                    <div id="membersContainer" class="hidden">
                        <div class="mb-4 pb-4 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                {{ __('Daftar Member') }}
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                {{ __('Pilih status kehadiran untuk setiap member') }}
                            </p>
                        </div>

                        <div id="attendanceItems" class="space-y-4">
                            <!-- Akan diisi oleh AJAX -->
                        </div>

                        <!-- Buttons -->
                        <div class="flex gap-3 justify-end mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <a href="{{ route('attendances.index') }}">
                                <x-secondary-button>
                                    {{ __('Batal') }}
                                </x-secondary-button>
                            </a>
                            <x-primary-button>
                                {{ __('Simpan Absensi') }}
                            </x-primary-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function loadMembers(meetingId) {
            const container = document.getElementById('membersContainer');
            const loading = document.getElementById('loadingIndicator');
            const itemsContainer = document.getElementById('attendanceItems');

            if (!meetingId) {
                container.classList.add('hidden');
                return;
            }

            loading.classList.remove('hidden');
            container.classList.add('hidden');

            fetch(`/attendances/${meetingId}/members`)
                .then(response => {
                    if (!response.ok) {
                        if (response.status === 403) {
                            throw new Error('Anda tidak memiliki akses ke meeting ini');
                        }
                        throw new Error('Gagal memuat data');
                    }
                    return response.json();
                })
                .then(data => {
                    itemsContainer.innerHTML = '';
                    const members = data.members;
                    const existing = data.existingAttendances;

                    if (members.length === 0) {
                        itemsContainer.innerHTML = '<p class="text-center text-gray-500 dark:text-gray-400 py-4">Tidak ada member di kelas ini</p>';
                    } else {
                        members.forEach((member, index) => {
                            const currentStatus = existing[member.id] || 'hadir';
                            const memberHtml = `
                                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                    <div class="flex items-center justify-between mb-3">
                                        <label class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                            ${index + 1}. ${member.name}
                                        </label>
                                    </div>
                                    <div class="flex gap-4">
                                        <label class="flex items-center">
                                            <input type="radio" name="attendances[${index}][member_id]" value="${member.id}" class="hidden" required>
                                            <input type="radio" name="attendances[${index}][status]" value="hadir" ${currentStatus === 'hadir' ? 'checked' : ''} class="w-4 h-4 text-green-600" required>
                                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Hadir</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="radio" name="attendances[${index}][status]" value="izin" ${currentStatus === 'izin' ? 'checked' : ''} class="w-4 h-4 text-yellow-600" required>
                                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Izin</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="radio" name="attendances[${index}][status]" value="sakit" ${currentStatus === 'sakit' ? 'checked' : ''} class="w-4 h-4 text-orange-600" required>
                                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Sakit</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="radio" name="attendances[${index}][status]" value="alpa" ${currentStatus === 'alpa' ? 'checked' : ''} class="w-4 h-4 text-red-600" required>
                                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Alpa</span>
                                        </label>
                                    </div>
                                    <input type="hidden" name="attendances[${index}][member_id]" value="${member.id}">
                                </div>
                            `;
                            itemsContainer.innerHTML += memberHtml;
                        });
                    }

                    loading.classList.add('hidden');
                    container.classList.remove('hidden');
                })
                .catch(error => {
                    loading.classList.add('hidden');
                    itemsContainer.innerHTML = `<p class="text-red-600 dark:text-red-400 text-center py-4">Error: ${error.message}</p>`;
                    container.classList.remove('hidden');
                });
        }
    </script>
</x-mentor-layout>