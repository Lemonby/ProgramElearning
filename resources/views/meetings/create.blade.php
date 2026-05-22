<x-mentor-layout>
    <div class="max-w-3xl mx-auto space-y-8">
        
        <!-- Header -->
        <div class="flex items-center justify-between pb-4 border-b border-white/5">
            <div>
                <h1 class="text-3xl font-extrabold text-white tracking-tight">Buat Sesi Pertemuan</h1>
                <p class="text-slate-400 mt-1 text-sm">Jadwalkan pertemuan virtual baru untuk kelas Anda.</p>
            </div>
            <a href="{{ route('meetings.index') }}" class="text-purple-300 hover:text-white flex items-center gap-1.5 text-xs font-bold transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
                </svg>
                Batal & Kembali
            </a>
        </div>

        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="bg-rose-500/10 border border-rose-500/30 text-rose-200 p-5 rounded-2xl text-sm shadow-xl">
                <h3 class="font-bold mb-2">Terjadi beberapa kesalahan input:</h3>
                <ul class="list-disc list-inside space-y-1 text-xs">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form Card -->
        <form action="{{ route('meetings.store') }}" method="POST" 
              class="bg-[#1f193f]/40 border border-white/5 rounded-[28px] p-6 sm:p-8 shadow-xl space-y-6">
            @csrf

            <!-- Title -->
            <div class="space-y-2">
                <label for="title" class="block text-xs font-black text-white uppercase tracking-wider">
                    Judul Pertemuan <span class="text-rose-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="title" 
                    name="title"
                    maxlength="255"
                    class="w-full bg-[#1A1435]/60 border border-white/10 rounded-xl px-4 py-2.5 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all text-sm {{ $errors->has('title') ? 'border-rose-500 focus:ring-rose-500' : '' }}"
                    placeholder="Contoh: Sesi Bimbingan Tugas Akhir & Evaluasi"
                    value="{{ old('title') }}"
                    required
                >
                @error('title')
                    <p class="text-rose-400 text-xs mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Date and Time Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Date -->
                <div class="space-y-2">
                    <label for="meeting_date" class="block text-xs font-black text-white uppercase tracking-wider">
                        Tanggal Pertemuan <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="date" 
                        id="meeting_date" 
                        name="meeting_date"
                        class="w-full bg-[#1A1435]/60 border border-white/10 rounded-xl px-4 py-2.5 text-white focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all text-sm"
                        value="{{ old('meeting_date') }}"
                        required
                    >
                    @error('meeting_date')
                        <p class="text-rose-400 text-xs mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Time -->
                <div class="space-y-2">
                    <label for="meeting_time" class="block text-xs font-black text-white uppercase tracking-wider">
                        Waktu Pertemuan <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="time" 
                        id="meeting_time" 
                        name="meeting_time"
                        class="w-full bg-[#1A1435]/60 border border-white/10 rounded-xl px-4 py-2.5 text-white focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all text-sm"
                        value="{{ old('meeting_time') }}"
                        required
                    >
                    @error('meeting_time')
                        <p class="text-rose-400 text-xs mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Meeting Type selection -->
            <div class="space-y-2">
                <label for="type" class="block text-xs font-black text-white uppercase tracking-wider">
                    Tipe Pertemuan <span class="text-rose-500">*</span>
                </label>
                <div class="relative">
                    <select 
                        id="type" 
                        name="type" 
                        class="w-full bg-[#1A1435]/60 border border-white/10 rounded-xl px-4 py-2.5 text-white focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all text-sm appearance-none cursor-pointer"
                        required
                    >
                        <option value="" class="bg-[#1A1435] text-slate-400">Pilih tipe pertemuan</option>
                        <option value="online" class="bg-[#1A1435] text-white" {{ old('type') === 'online' ? 'selected' : '' }}>Online (Google Meet / Zoom)</option>
                        <option value="offline" class="bg-[#1A1435] text-white" {{ old('type') === 'offline' ? 'selected' : '' }}>Offline (Tatap Muka)</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-purple-300">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>
                @error('type')
                    <p class="text-rose-400 text-xs mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Link Meeting -->
            <div class="space-y-2">
                <label for="meeting_link" class="block text-xs font-black text-white uppercase tracking-wider">
                    Tautan Pertemuan (Link) <span id="meeting-link-note" class="text-[10px] text-slate-400 font-semibold lowercase">(wajib jika online, opsional untuk offline)</span>
                </label>
                <input 
                    type="url" 
                    id="meeting_link" 
                    name="meeting_link"
                    class="w-full bg-[#1A1435]/60 border border-white/10 rounded-xl px-4 py-2.5 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all text-sm"
                    placeholder="https://meet.google.com/... atau https://zoom.us/j/..."
                    value="{{ old('meeting_link') }}"
                >
                @error('meeting_link')
                    <p class="text-rose-400 text-xs mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div class="space-y-2">
                <label for="description" class="block text-xs font-black text-white uppercase tracking-wider">
                    Deskripsi / Topik Pembahasan
                </label>
                <textarea 
                    id="description" 
                    name="description"
                    rows="4"
                    maxlength="1000"
                    class="w-full bg-[#1A1435]/60 border border-white/10 rounded-xl px-4 py-2.5 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all text-sm leading-relaxed {{ $errors->has('description') ? 'border-rose-500 focus:ring-rose-500' : '' }}"
                    placeholder="Deskripsikan agenda meeting, link file presentasi, atau instruksi tatap muka..."
                >{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-rose-400 text-xs mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit buttons -->
            <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-white/5">
                <button type="submit" 
                        class="flex-1 bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-6 rounded-xl transition-all shadow-lg shadow-purple-500/20 text-xs uppercase tracking-wider flex items-center justify-center gap-1.5">
                    Jadwalkan Sesi
                </button>
                <a href="{{ route('meetings.index') }}"
                   class="flex-1 text-center bg-white/5 hover:bg-white/10 border border-white/10 text-slate-300 hover:text-white font-bold py-3 px-6 rounded-xl transition-all text-xs uppercase tracking-wider flex items-center justify-center">
                    Batal
                </a>
            </div>

        </form>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const typeSelect = document.getElementById('type');
            const meetingLinkInput = document.getElementById('meeting_link');
            const meetingLinkNote = document.getElementById('meeting-link-note');

            const updateMeetingLinkRequirement = () => {
                const isOnline = typeSelect.value === 'online';

                meetingLinkInput.required = isOnline;
                meetingLinkNote.textContent = isOnline
                    ? '(wajib untuk online, opsional untuk offline)'
                    : '(opsional untuk offline)';

                if (!isOnline) {
                    meetingLinkInput.setCustomValidity('');
                }
            };

            typeSelect.addEventListener('change', updateMeetingLinkRequirement);
            updateMeetingLinkRequirement();
        });
    </script>
</x-mentor-layout>