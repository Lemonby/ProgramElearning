<x-member-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-white">
            Dashboard Member
        </h2>
    </x-slot>

    <div class="min-h-screen bg-gradient-to-b from-[#020617] to-purple-900 p-4 md:p-8">

        <!-- TOP SECTION -->
        <div class="bg-white/10 backdrop-blur-xl rounded-[30px] p-6 md:p-10 shadow-2xl">

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                <!-- Main column -->
                <div class="lg:col-span-9 space-y-6">
                    <div class="bg-gradient-to-r from-purple-700 to-purple-800 text-white rounded-2xl p-6 md:p-8">
                        <h1 class="text-2xl md:text-4xl font-bold">Halo, {{ $user->name ?? auth()->user()->name }}!</h1>
                        <p class="text-purple-100 mt-2">Selamat datang di E-Learning Platform. Jangan lupa cek tugas dan absensimu ya!</p>
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <h2 class="text-lg font-semibold text-white">Pertemuan Mendatang</h2>
                            <a href="#" class="text-sm text-purple-200">Lihat Semua →</a>
                        </div>

                            <div class="bg-white/5 backdrop-blur rounded-2xl p-4 text-gray-400 border border-white/10">
                            @if(isset($upcomingMeetings) && $upcomingMeetings->isNotEmpty())
                                <ul class="space-y-3">
                                    @foreach($upcomingMeetings as $m)
                                        <li class="flex items-center justify-between">
                                            <div>
                                                <div class="font-semibold text-white">{{ $m->title }}</div>
                                                <div class="text-sm text-gray-300">{{ \Carbon\Carbon::parse($m->meeting_date)->format('d M Y') }} • {{ $m->meeting_time }}</div>
                                            </div>
                                            <div class="text-sm text-gray-300">{{ optional($m->mentor)->name ?? '-' }}</div>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <div class="text-center py-8 text-gray-400">Tidak ada pertemuan mendatang</div>
                            @endif
                        </div>
                    </div>

                    <div>
                        <h2 class="text-lg font-semibold text-white mb-3">Kehadiran</h2>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            @php
                                $hadirCount = $hadir ?? ($attendanceCards[0]['count'] ?? 0);
                                $izinCount = $izin ?? ($attendanceCards[1]['count'] ?? 0);
                                $sakitCount = $sakit ?? ($attendanceCards[2]['count'] ?? 0);
                                $alpaCount = $alpa ?? ($attendanceCards[3]['count'] ?? 0);
                                $totalMeet = $totalMeetings ?? 0;
                            @endphp

                            <div class="bg-white/10 rounded-2xl p-4 border border-white/10">
                                <p class="text-gray-300 text-sm">Hadir</p>
                                <p class="text-white text-2xl font-bold mt-2">{{ $hadirCount }}</p>
                                <p class="text-gray-400 text-sm">{{ $hadirCount }}/{{ $totalMeet }}</p>
                            </div>

                            <div class="bg-white/10 rounded-2xl p-4 border border-white/10">
                                <p class="text-gray-300 text-sm">Sakit</p>
                                <p class="text-white text-2xl font-bold mt-2">{{ $sakitCount }}</p>
                                <p class="text-gray-400 text-sm">{{ $sakitCount }}/{{ $totalMeet }}</p>
                            </div>

                            <div class="bg-white/10 rounded-2xl p-4 border border-white/10">
                                <p class="text-gray-300 text-sm">Izin</p>
                                <p class="text-white text-2xl font-bold mt-2">{{ $izinCount }}</p>
                                <p class="text-gray-400 text-sm">{{ $izinCount }}/{{ $totalMeet }}</p>
                            </div>

                            <div class="bg-white/10 rounded-2xl p-4 border border-white/10">
                                <p class="text-gray-300 text-sm">Alpa</p>
                                <p class="text-white text-2xl font-bold mt-2">{{ $alpaCount }}</p>
                                <p class="text-gray-400 text-sm">{{ $alpaCount }}/{{ $totalMeet }}</p>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-3 space-y-6">
                    <div class="bg-white rounded-2xl p-6 shadow-lg">
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 rounded-full bg-gray-200 flex items-center justify-center text-xl font-bold text-gray-700">{{ strtoupper(substr($user->name ?? auth()->user()->name,0,1)) }}</div>
                            <div>
                                <div class="font-bold">{{ $user->name ?? auth()->user()->name }}</div>
                                <div class="text-sm text-gray-500">{{ $user->email ?? auth()->user()->email }}</div>
                            </div>
                        </div>

                        <div class="mt-6 bg-gradient-to-r from-purple-600 to-purple-700 text-white rounded-xl p-3 grid grid-cols-2 gap-2">
                            <div class="text-center">
                                <div class="text-xs text-purple-200">Tugas Selesai</div>
                                <div class="font-bold text-xl">{{ $completedAssignments ?? ($progressSummary['completed_assignments'] ?? 0) }}</div>
                            </div>
                            <div class="text-center">
                                <div class="text-xs text-purple-200">Progress</div>
                                <div class="font-bold text-xl">{{ $assignmentProgress ?? ($progressSummary['progress_percentage'] ?? 0) }}%</div>
                            </div>
                        </div>
                    </div>

                    {{-- <div class="bg-white rounded-2xl p-4 shadow-lg">
                        <h3 class="font-semibold mb-3">Tugas Belum Dikerjakan</h3>
                        @php
                            $pendingList = $pending ?? ($assignmentList ?? collect());
                        @endphp
                        @if($pendingList->isNotEmpty())
                            <ul class="space-y-3">
                                @foreach($pendingList->take(5) as $p)
                                    <li class="flex items-start justify-between">
                                        <div class="text-sm">{{ $p->title ?? $p['title'] ?? 'Untitled' }}</div>
                                        <div class="text-xs text-gray-400">{{ isset($p->deadline) ? \Carbon\Carbon::parse($p->deadline)->format('d M Y') : (isset($p['deadline']) ? \Carbon\Carbon::parse($p['deadline'])->format('d M Y') : '') }}</div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="text-sm text-gray-500">Tidak ada tugas tertunda.</div>
                        @endif
                    </div> --}}
                </div>
            </div>

            <!-- ASSIGNMENTS -->
            <div>
                <h2 class="text-3xl font-bold text-white mb-6">
                    Daftar Tugas
                </h2>

                <div class="bg-white rounded-[30px] p-6 shadow-lg">
                    <div class="space-y-4">
                        @forelse ($assignmentList as $assignment)
                            <div class="rounded-xl px-4 py-4 font-semibold {{ $assignment['is_submitted'] ? 'bg-green-100 text-green-700' : ($assignment['is_overdue'] ? 'bg-red-100 text-red-700' : ($assignment['is_due_soon'] ? 'bg-amber-100 text-amber-700' : 'bg-gray-100 text-gray-800')) }}">
                                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2">
                                    <p>{{ $assignment['title'] }}</p>
                                    <span class="text-xs font-bold uppercase tracking-wide">
                                        {{ $assignment['is_submitted'] ? 'Sudah dikumpulkan' : 'Belum dikumpulkan' }}
                                    </span>
                                </div>

                                <p class="text-sm font-medium mt-1">
                                    Deadline: {{ $assignment['deadline']->format('d M Y H:i') }}
                                    @if (!$assignment['is_submitted'] && $assignment['is_overdue'])
                                        (Melewati deadline)
                                    @elseif (!$assignment['is_submitted'] && $assignment['is_due_soon'])
                                        (Mendekati deadline)
                                    @endif
                                </p>
                            </div>
                        @empty
                            <div class="bg-gray-100 text-gray-700 rounded-xl px-4 py-4 font-semibold">
                                Belum ada assignment untuk kelas Anda.
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-8">
                        <a href="{{ route('submissions.index') }}"
                          class="w-full inline-flex justify-center items-center bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white font-bold py-4 rounded-2xl transition-all duration-300 shadow-lg">
                            Kumpulkan Tugas
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-member-layout>
