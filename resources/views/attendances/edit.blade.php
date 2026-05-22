<x-mentor-layout>
    <div class="max-w-4xl mx-auto space-y-8">
        
        <!-- Header -->
        <div class="flex items-center justify-between pb-4 border-b border-white/5">
            <div>
                <h1 class="text-3xl font-extrabold text-white tracking-tight">Edit Lembar Presensi</h1>
                <p class="text-slate-400 mt-1 text-sm">Perbarui status kehadiran siswa untuk pertemuan terpilih.</p>
            </div>
            <a href="{{ route('attendances.index') }}" class="text-purple-300 hover:text-white flex items-center gap-1.5 text-xs font-bold transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
                </svg>
                Batal & Kembali
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

        <!-- Meeting Info Display Box -->
        <div class="bg-[#1f193f]/40 border border-white/5 rounded-[28px] p-6 shadow-xl relative overflow-hidden">
            <!-- Glow effect -->
            <div class="absolute top-0 right-0 w-32 h-32 bg-purple-500/5 rounded-full blur-3xl"></div>
            
            <div class="relative z-10 space-y-4">
                <div class="flex items-center gap-2">
                    <span class="px-2.5 py-1 rounded-full text-[9px] font-black tracking-wider uppercase bg-purple-500/10 text-purple-300 border border-purple-500/20">
                        {{ __('Informasi Pertemuan') }}
                    </span>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                    <div>
                        <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Judul Sesi</p>
                        <p class="font-extrabold text-white text-base mt-1">{{ $meeting->title }}</p>
                    </div>
                    <div>
                        <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Kelas</p>
                        <p class="font-extrabold text-purple-300 text-base mt-1">{{ $meeting->class->description ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Card Container -->
        <div class="bg-[#1f193f]/40 border border-white/5 rounded-[28px] p-6 sm:p-8 shadow-xl relative overflow-hidden">
            <!-- Glow effect -->
            <div class="absolute top-0 right-0 w-48 h-48 bg-purple-500/5 rounded-full blur-3xl"></div>
            
            <form action="{{ route('attendances.update', $meeting->id) }}" method="POST" class="space-y-8 relative z-10">
                @csrf
                @method('PUT')

                <!-- Members Attendance Form List -->
                <div class="space-y-6">
                    <div class="pb-4 border-b border-white/5">
                        <h3 class="text-lg font-bold text-white">
                            {{ __('Update Kehadiran Member') }}
                        </h3>
                        <p class="text-xs text-slate-400 mt-1">
                            {{ __('Silakan sesuaikan status kehadiran untuk masing-masing siswa di bawah ini.') }}
                        </p>
                    </div>

                    <!-- Attendance Items list -->
                    <div class="space-y-4 max-h-[500px] overflow-y-auto pr-2 custom-scrollbar">
                        @foreach($members as $index => $member)
                            @php
                                $currentStatus = $existingAttendances->get($member->id, 'hadir');
                            @endphp
                            <div class="bg-[#1f193f]/30 border border-white/5 hover:border-purple-500/20 rounded-2xl p-4 sm:p-5 transition-all duration-300 flex flex-col md:flex-row md:items-center justify-between gap-4">
                                
                                <!-- Left Info -->
                                <div class="flex items-center gap-3">
                                    <span class="w-8 h-8 rounded-full bg-purple-600/10 border border-purple-500/20 text-purple-300 flex items-center justify-center text-xs font-black flex-shrink-0">
                                        {{ $index + 1 }}
                                    </span>
                                    <div>
                                        <h4 class="font-bold text-white text-sm tracking-wide">{{ $member->name }}</h4>
                                        <p class="text-slate-400 text-[10px] tracking-wider uppercase font-bold mt-0.5">Siswa</p>
                                    </div>
                                </div>

                                <!-- Right Options (Custom radio cards) -->
                                <div class="flex flex-wrap gap-2">
                                    <!-- Hadir Option -->
                                    <label class="relative flex items-center justify-center cursor-pointer select-none">
                                        <input type="radio" 
                                               name="attendances[{{ $index }}][status]" 
                                               value="hadir" 
                                               {{ $currentStatus === 'hadir' ? 'checked' : '' }} 
                                               class="sr-only peer" 
                                               required>
                                        <span class="px-4 py-2 rounded-xl text-xs font-black uppercase tracking-wider border border-white/10 bg-[#1A1435]/60 text-slate-400 transition-all peer-checked:bg-emerald-500/20 peer-checked:text-emerald-300 peer-checked:border-emerald-500/30 hover:bg-white/5 hover:text-white">
                                            Hadir
                                        </span>
                                    </label>

                                    <!-- Izin Option -->
                                    <label class="relative flex items-center justify-center cursor-pointer select-none">
                                        <input type="radio" 
                                               name="attendances[{{ $index }}][status]" 
                                               value="izin" 
                                               {{ $currentStatus === 'izin' ? 'checked' : '' }} 
                                               class="sr-only peer" 
                                               required>
                                        <span class="px-4 py-2 rounded-xl text-xs font-black uppercase tracking-wider border border-white/10 bg-[#1A1435]/60 text-slate-400 transition-all peer-checked:bg-amber-500/20 peer-checked:text-amber-300 peer-checked:border-amber-500/30 hover:bg-white/5 hover:text-white">
                                            Izin
                                        </span>
                                    </label>

                                    <!-- Sakit Option -->
                                    <label class="relative flex items-center justify-center cursor-pointer select-none">
                                        <input type="radio" 
                                               name="attendances[{{ $index }}][status]" 
                                               value="sakit" 
                                               {{ $currentStatus === 'sakit' ? 'checked' : '' }} 
                                               class="sr-only peer" 
                                               required>
                                        <span class="px-4 py-2 rounded-xl text-xs font-black uppercase tracking-wider border border-white/10 bg-[#1A1435]/60 text-slate-400 transition-all peer-checked:bg-cyan-500/20 peer-checked:text-cyan-300 peer-checked:border-cyan-500/30 hover:bg-white/5 hover:text-white">
                                            Sakit
                                        </span>
                                    </label>

                                    <!-- Alpa Option -->
                                    <label class="relative flex items-center justify-center cursor-pointer select-none">
                                        <input type="radio" 
                                               name="attendances[{{ $index }}][status]" 
                                               value="alpa" 
                                               {{ $currentStatus === 'alpa' ? 'checked' : '' }} 
                                               class="sr-only peer" 
                                               required>
                                        <span class="px-4 py-2 rounded-xl text-xs font-black uppercase tracking-wider border border-white/10 bg-[#1A1435]/60 text-slate-400 transition-all peer-checked:bg-rose-500/20 peer-checked:text-rose-300 peer-checked:border-rose-500/30 hover:bg-white/5 hover:text-white">
                                            Alpa
                                        </span>
                                    </label>
                                </div>
                                <input type="hidden" name="attendances[{{ $index }}][member_id]" value="{{ $member->id }}">
                            </div>
                        @endforeach
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-white/5">
                        <button type="submit" 
                                class="flex-1 bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-6 rounded-xl transition-all shadow-lg shadow-purple-500/20 text-xs uppercase tracking-wider flex items-center justify-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Simpan Perubahan
                        </button>
                        <a href="{{ route('attendances.index') }}"
                           class="flex-1 text-center bg-white/5 hover:bg-white/10 border border-white/10 text-slate-300 hover:text-white font-bold py-3 px-6 rounded-xl transition-all text-xs uppercase tracking-wider flex items-center justify-center">
                            Batal
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
</x-mentor-layout>