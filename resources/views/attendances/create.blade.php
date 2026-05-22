<x-mentor-layout>
    <div class="max-w-4xl mx-auto space-y-8">
        
        <!-- Header -->
        <div class="flex items-center justify-between pb-4 border-b border-white/5">
            <div>
                <h1 class="text-3xl font-extrabold text-white tracking-tight">Buat Lembar Presensi</h1>
                <p class="text-slate-400 mt-1 text-sm">Catat atau perbarui kehadiran siswa untuk pertemuan tertentu.</p>
            </div>
            <a href="{{ route('attendances.index') }}" class="text-purple-300 hover:text-white flex items-center gap-1.5 text-xs font-bold transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali ke Daftar
            </a>
        </div>

        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="bg-rose-500/10 border border-rose-500/30 text-rose-200 p-5 rounded-2xl text-sm shadow-xl">
                <div class="flex items-center gap-2.5 mb-2 font-bold">
                    <svg class="w-5 h-5 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    <span>Terjadi kesalahan input:</span>
                </div>
                <ul class="list-disc list-inside space-y-1 text-xs text-rose-300/90 pl-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form Card Container -->
        <div class="bg-[#1f193f]/40 border border-white/5 rounded-[28px] p-6 sm:p-8 shadow-xl relative overflow-hidden">
            <!-- Glow effect -->
            <div class="absolute top-0 right-0 w-48 h-48 bg-purple-500/5 rounded-full blur-3xl"></div>
            
            <form action="{{ route('attendances.store') }}" method="POST" id="attendanceForm" class="space-y-8 relative z-10">
                @csrf

                <!-- Pilih Meeting Section -->
                <div class="space-y-2">
                    <label for="meeting_id" class="block text-xs font-black text-white uppercase tracking-wider">
                        Pilih Pertemuan Kelas <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <select id="meeting_id" 
                                name="meeting_id" 
                                class="w-full bg-[#1A1435]/60 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all text-sm appearance-none cursor-pointer"
                                required
                                onchange="loadMembers(this.value)">
                            <option value="" class="bg-[#1A1435] text-slate-400">-- Pilih Pertemuan untuk Memulai Absensi --</option>
                            @foreach($meetings as $meeting)
                                <option value="{{ $meeting->id }}" class="bg-[#1A1435] text-white">
                                    {{ $meeting->title }} ({{ $meeting->class->description ?? 'N/A' }})
                                </option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-purple-300">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Loading Indicator -->
                <div id="loadingIndicator" class="hidden text-center py-12 space-y-4">
                    <div class="inline-block animate-spin rounded-full h-10 w-10 border-t-2 border-b-2 border-purple-500"></div>
                    <p class="text-purple-300 font-medium text-xs tracking-wide">{{ __('Menghubungkan & Memuat data member kelas...') }}</p>
                </div>

                <!-- Members Attendance Form Container (Initially Hidden) -->
                <div id="membersContainer" class="hidden space-y-6">
                    <div class="pb-4 border-b border-white/5">
                        <h3 class="text-lg font-bold text-white">
                            {{ __('Daftar Member & Status Kehadiran') }}
                        </h3>
                        <p class="text-xs text-slate-400 mt-1">
                            {{ __('Silakan tandai status absensi untuk masing-masing siswa di bawah ini.') }}
                        </p>
                    </div>

                    <!-- Attendance Items dynamic list -->
                    <div id="attendanceItems" class="space-y-4 max-h-[500px] overflow-y-auto pr-2 custom-scrollbar">
                        <!-- Akan diisi secara dinamis oleh AJAX -->
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-white/5">
                        <button type="submit" 
                                class="flex-1 bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-6 rounded-xl transition-all shadow-lg shadow-purple-500/20 text-xs uppercase tracking-wider flex items-center justify-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Simpan Absensi Kelas
                        </button>
                        <a href="{{ route('attendances.index') }}"
                           class="flex-1 text-center bg-white/5 hover:bg-white/10 border border-white/10 text-slate-300 hover:text-white font-bold py-3 px-6 rounded-xl transition-all text-xs uppercase tracking-wider flex items-center justify-center">
                            Batal & Kembali
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Custom Scrollbar styling for list -->
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.02);
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(147, 51, 234, 0.3);
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(147, 51, 234, 0.5);
        }
    </style>

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
                            throw new Error('Anda tidak memiliki akses ke pertemuan ini');
                        }
                        throw new Error('Gagal memuat data member kelas');
                    }
                    return response.json();
                })
                .then(data => {
                    itemsContainer.innerHTML = '';
                    const members = data.members;
                    const existing = data.existingAttendances;

                    if (members.length === 0) {
                        itemsContainer.innerHTML = `
                            <div class="text-center py-8 bg-white/5 border border-white/5 rounded-2xl p-6">
                                <p class="text-slate-400 text-sm">Tidak ada member/siswa terdaftar di kelas untuk pertemuan ini.</p>
                            </div>
                        `;
                    } else {
                        members.forEach((member, index) => {
                            const currentStatus = existing[member.id] || 'hadir';
                            const memberHtml = `
                                <div class="bg-[#1f193f]/30 border border-white/5 hover:border-purple-500/20 rounded-2xl p-4 sm:p-5 transition-all duration-300 flex flex-col md:flex-row md:items-center justify-between gap-4">
                                    
                                    <!-- Left Info -->
                                    <div class="flex items-center gap-3">
                                        <span class="w-8 h-8 rounded-full bg-purple-600/10 border border-purple-500/20 text-purple-300 flex items-center justify-center text-xs font-black flex-shrink-0">
                                            ${index + 1}
                                        </span>
                                        <div>
                                            <h4 class="font-bold text-white text-sm tracking-wide">${member.name}</h4>
                                            <p class="text-slate-400 text-[10px] tracking-wider uppercase font-bold mt-0.5">Siswa</p>
                                        </div>
                                    </div>

                                    <!-- Right Options (Custom radio cards) -->
                                    <div class="flex flex-wrap gap-2">
                                        <!-- Hadir Option -->
                                        <label class="relative flex items-center justify-center cursor-pointer select-none">
                                            <input type="radio" 
                                                   name="attendances[${index}][status]" 
                                                   value="hadir" 
                                                   ${currentStatus === 'hadir' ? 'checked' : ''} 
                                                   class="sr-only peer" 
                                                   required>
                                            <span class="px-4 py-2 rounded-xl text-xs font-black uppercase tracking-wider border border-white/10 bg-[#1A1435]/60 text-slate-400 transition-all peer-checked:bg-emerald-500/20 peer-checked:text-emerald-300 peer-checked:border-emerald-500/30 hover:bg-white/5 hover:text-white">
                                                Hadir
                                            </span>
                                        </label>

                                        <!-- Izin Option -->
                                        <label class="relative flex items-center justify-center cursor-pointer select-none">
                                            <input type="radio" 
                                                   name="attendances[${index}][status]" 
                                                   value="izin" 
                                                   ${currentStatus === 'izin' ? 'checked' : ''} 
                                                   class="sr-only peer" 
                                                   required>
                                            <span class="px-4 py-2 rounded-xl text-xs font-black uppercase tracking-wider border border-white/10 bg-[#1A1435]/60 text-slate-400 transition-all peer-checked:bg-amber-500/20 peer-checked:text-amber-300 peer-checked:border-amber-500/30 hover:bg-white/5 hover:text-white">
                                                Izin
                                            </span>
                                        </label>

                                        <!-- Sakit Option -->
                                        <label class="relative flex items-center justify-center cursor-pointer select-none">
                                            <input type="radio" 
                                                   name="attendances[${index}][status]" 
                                                   value="sakit" 
                                                   ${currentStatus === 'sakit' ? 'checked' : ''} 
                                                   class="sr-only peer" 
                                                   required>
                                            <span class="px-4 py-2 rounded-xl text-xs font-black uppercase tracking-wider border border-white/10 bg-[#1A1435]/60 text-slate-400 transition-all peer-checked:bg-cyan-500/20 peer-checked:text-cyan-300 peer-checked:border-cyan-500/30 hover:bg-white/5 hover:text-white">
                                                Sakit
                                            </span>
                                        </label>

                                        <!-- Alpa Option -->
                                        <label class="relative flex items-center justify-center cursor-pointer select-none">
                                            <input type="radio" 
                                                   name="attendances[${index}][status]" 
                                                   value="alpa" 
                                                   ${currentStatus === 'alpa' ? 'checked' : ''} 
                                                   class="sr-only peer" 
                                                   required>
                                            <span class="px-4 py-2 rounded-xl text-xs font-black uppercase tracking-wider border border-white/10 bg-[#1A1435]/60 text-slate-400 transition-all peer-checked:bg-rose-500/20 peer-checked:text-rose-300 peer-checked:border-rose-500/30 hover:bg-white/5 hover:text-white">
                                                Alpa
                                            </span>
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
                    itemsContainer.innerHTML = `
                        <div class="bg-rose-500/10 border border-rose-500/30 text-rose-200 p-4 rounded-2xl text-xs font-semibold shadow-xl flex items-center gap-2.5 justify-center">
                            <svg class="w-4 h-4 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            <span>${error.message}</span>
                        </div>
                    `;
                    container.classList.remove('hidden');
                    console.error('Error loading members:', error);
                });
        }

        // Form submit validation
        document.getElementById('attendanceForm').addEventListener('submit', function(e) {
            const meetingId = document.getElementById('meeting_id').value;
            const itemsContainer = document.getElementById('attendanceItems');
            const allInputs = itemsContainer.querySelectorAll('input[name^="attendances"]');
            
            if (!meetingId) {
                e.preventDefault();
                alert('Silakan pilih pertemuan terlebih dahulu');
                return false;
            }

            if (allInputs.length === 0) {
                e.preventDefault();
                alert('Silakan pilih pertemuan yang memiliki siswa terlebih dahulu');
                return false;
            }

            // Check if all members have status selected
            const attendanceIndices = new Set();
            document.querySelectorAll('input[name^="attendances"][name$="[status]"]').forEach(input => {
                const name = input.name;
                const match = name.match(/\[(\d+)\]/);
                if (match) {
                    attendanceIndices.add(match[1]);
                }
            });

            let allStatusSelected = true;
            attendanceIndices.forEach(index => {
                const statusInputs = document.querySelectorAll(`input[name="attendances[${index}][status]"]:checked`);
                if (statusInputs.length === 0) {
                    allStatusSelected = false;
                }
            });

            if (!allStatusSelected) {
                e.preventDefault();
                alert('Silakan pilih status kehadiran untuk semua siswa');
                return false;
            }
        });
    </script>
</x-mentor-layout>