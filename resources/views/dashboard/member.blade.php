<x-member-layout>
    <!-- MAIN CONTENT GRID -->
    <div class="grid grid-cols-1 xl:grid-cols-12 gap-8 items-start">
        
        <!-- LEFT COLUMN: Welcome, Stats & Events (9 Columns on Large, 12 on Mobile) -->
        <div class="xl:col-span-9 space-y-10">
            
            <!-- Welcome Header -->
            <div>
                <h1 class="text-4xl font-extrabold text-white tracking-tight">Hello {{ Auth::user()->name }}!</h1>
                <p class="text-slate-400 mt-2 text-sm">Selamat datang kembali. Cek rangkuman kehadiran dan tugas terbaru Anda di bawah ini.</p>
            </div>

            <!-- Stats Circles Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-6">
                @foreach ($attendanceCards as $card)
                    <div class="flex flex-col items-center text-center p-4">
                        <!-- Circular Progress Ring (SVG) -->
                        <div class="relative w-32 h-32 flex items-center justify-center">
                            <svg class="w-32 h-32 transform -rotate-90">
                                <!-- Outer Background Path -->
                                <circle cx="64" cy="64" r="50" 
                                        class="text-purple-950/40 stroke-current" 
                                        stroke-width="10" 
                                        fill="transparent" />
                                <!-- Glowing Purple Progress Path -->
                                <circle cx="64" cy="64" r="50" 
                                        class="text-purple-500 stroke-current drop-shadow-[0_0_8px_rgba(168,85,247,0.5)]" 
                                        stroke-width="10" 
                                        fill="transparent" 
                                        stroke-dasharray="314" 
                                        stroke-dashoffset="{{ 314 - (314 * $card['percentage']) / 100 }}" 
                                        stroke-linecap="round" 
                                        class="transition-all duration-500 ease-out" />
                            </svg>
                            <!-- Inner Content -->
                            <div class="absolute flex flex-col items-center justify-center">
                                <span class="text-xl font-black text-white leading-none">{{ $card['percentage'] }}%</span>
                                <span class="text-[10px] font-bold text-slate-400 mt-1 uppercase tracking-wider">
                                    {{ $card['count'] }}/{{ $totalMeetWithAttendance }}
                                </span>
                            </div>
                        </div>
                        <!-- Label -->
                        <span class="text-base font-bold text-white mt-4">{{ $card['label'] }}</span>
                    </div>
                @endforeach
            </div>

            <!-- Events Section -->
            <div class="pt-4">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                    <h2 class="text-2xl font-bold text-white tracking-tight">Events</h2>
                    
                    <!-- Filters matching the mockup -->
                    <div class="flex items-center gap-3">
                        <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Filter by:</span>
                        <select class="bg-[#1A1435]/60 hover:bg-[#1A1435] text-white border border-white/10 rounded-full px-4 py-1 text-xs focus:outline-none focus:ring-1 focus:ring-purple-500 cursor-pointer">
                            <option>Type</option>
                            <option>Online</option>
                            <option>Offline</option>
                        </select>
                        <select class="bg-[#1A1435]/60 hover:bg-[#1A1435] text-white border border-white/10 rounded-full px-4 py-1 text-xs focus:outline-none focus:ring-1 focus:ring-purple-500 cursor-pointer">
                            <option>Date</option>
                            <option>Latest</option>
                            <option>Oldest</option>
                        </select>
                    </div>
                </div>

                <!-- Events Cards Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @forelse ($upcomingMeetings as $index => $meeting)
                        <div class="bg-white text-slate-800 p-6 rounded-[24px] shadow-lg flex flex-col justify-between min-h-[220px] transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl">
                            <div>
                                <!-- Meeting Badge -->
                                <span class="inline-block bg-purple-100 text-purple-700 text-[10px] font-extrabold px-3 py-1 rounded-full mb-3 uppercase tracking-wider">
                                    Kelas ke-{{ $index + 1 }}
                                </span>
                                <!-- Title -->
                                <h3 class="text-lg font-black text-slate-900 leading-tight line-clamp-2">
                                    {{ $meeting->title }}
                                </h3>
                                <!-- Description -->
                                <p class="text-xs text-slate-500 mt-2 line-clamp-3 leading-relaxed">
                                    {{ $meeting->description ?? 'Tidak ada deskripsi pertemuan.' }}
                                </p>
                            </div>
                            
                            <!-- Bottom Info -->
                            <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between">
                                <span class="text-[10px] font-extrabold text-slate-400 uppercase">
                                    {{ \Carbon\Carbon::parse($meeting->meeting_date)->translatedFormat('d M Y') }}
                                </span>
                                <span class="text-xs font-bold text-purple-700">
                                    {{ $meeting->mentor->name ?? 'Ms. Icha' }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-3 bg-white/5 border border-white/10 rounded-[24px] p-10 text-center text-slate-400">
                            <svg class="mx-auto h-12 w-12 text-slate-500 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <p class="text-sm font-semibold text-white">Tidak ada pertemuan mendatang</p>
                            <p class="text-xs text-slate-500 mt-1">Daftar kelas baru akan dirilis oleh mentor.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Chevron Down Indicator -->
                <div class="flex justify-center mt-6">
                    <svg class="w-6 h-6 text-slate-400 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN: To-Do List (3 Columns on Large, 12 on Mobile) -->
        <div class="xl:col-span-3 space-y-6 lg:h-full">
            <div class="bg-[#1f193f]/80 border border-white/5 shadow-2xl rounded-[30px] overflow-hidden flex flex-col justify-between min-h-[500px]">
                
                <!-- Todo Header -->
                <div class="p-6 pb-2">
                    <h2 class="text-2xl font-black text-white tracking-tight">To do:</h2>
                </div>

                <!-- Todo Checklist Items -->
                <div class="flex-1 px-6 py-2 overflow-y-auto max-h-[360px] space-y-3.5">
                    @forelse ($assignmentList->take(7) as $assignment)
                        <div class="flex items-center gap-3.5 group">
                            <!-- Rounded custom checkbox -->
                            <div class="w-6 h-6 rounded-full flex items-center justify-center border-2 transition-all flex-shrink-0 cursor-pointer 
                                 {{ $assignment['is_submitted'] 
                                     ? 'bg-purple-600 border-purple-500 text-white shadow-lg shadow-purple-500/20' 
                                     : 'border-slate-500 hover:border-purple-400 bg-white/5' }}">
                                @if ($assignment['is_submitted'])
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                    </svg>
                                @endif
                            </div>
                            <!-- Title & Status -->
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-bold text-white truncate group-hover:text-purple-300 transition-colors leading-tight">
                                    {{ $assignment['title'] }}
                                </p>
                                <p class="text-[10px] font-semibold tracking-wide uppercase mt-0.5
                                     {{ $assignment['is_submitted'] 
                                         ? 'text-purple-400' 
                                         : ($assignment['is_overdue'] 
                                             ? 'text-rose-400' 
                                             : ($assignment['is_due_soon'] 
                                                 ? 'text-amber-400' 
                                                 : 'text-slate-400')) }}">
                                    @if ($assignment['is_submitted'])
                                        Selesai
                                    @elseif ($assignment['is_overdue'])
                                        Terlambat
                                    @else
                                        Deadline: {{ $assignment['deadline']->format('d M') }}
                                    @endif
                                </p>
                            </div>
                        </div>
                    @empty
                        <div class="py-12 text-center text-slate-500">
                            <p class="text-xs">Tidak ada tugas terdaftar.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Large Plus Action Box at Bottom -->
                <a href="{{ route('submissions.index') }}" 
                   class="bg-[#2D245E] hover:bg-[#392e76] transition-all py-5 flex items-center justify-center border-t border-white/5 group">
                    <svg class="w-8 h-8 text-purple-300 group-hover:scale-110 group-hover:text-white transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                    </svg>
                </a>

            </div>
        </div>
        
    </div>
</x-member-layout>
