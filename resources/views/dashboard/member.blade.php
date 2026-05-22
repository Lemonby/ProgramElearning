<x-member-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-white">
            Dashboard Member
        </h2>
    </x-slot>

    <div class="min-h-screen bg-gradient-to-b from-[#020617] to-purple-900 p-4 md:p-8">
        @php
            $member = auth()->user();
            $pendingAssignments = $assignmentList->where('is_submitted', false)->take(5);
        @endphp

        <div class="max-w-7xl mx-auto grid grid-cols-1 xl:grid-cols-4 gap-6">

            <div class="xl:col-span-3 space-y-6">
                <div class="bg-gradient-to-r from-purple-700 to-purple-800 text-white rounded-2xl p-6 md:p-8 relative overflow-hidden">
                    <div class="relative z-10">
                        <h1 class="text-2xl md:text-4xl font-bold">
                            Halo, {{ $member->name }}!
                        </h1>
                        <p class="text-purple-100 mt-2 text-sm md:text-base">
                            Selamat datang di E-Learning Platform. Cek tugas dan absensimu hari ini.
                        </p>
                    </div>

                    <div class="absolute -right-8 -top-8 w-40 h-40 rounded-full bg-purple-500/50"></div>
                    <div class="absolute right-20 bottom-[-40px] w-32 h-32 rounded-full bg-purple-400/40"></div>
                </div>

                <div>
                    <h2 class="text-2xl font-bold text-white mb-3">Kehadiran</h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach ($attendanceCards as $card)
                            <div class="bg-white/10 backdrop-blur-xl rounded-2xl border border-white/20 p-4 text-center">
                                <p class="text-gray-300 text-sm">{{ $card['label'] }}</p>
                                <p class="text-3xl font-bold text-white mt-2">{{ $card['count'] }}</p>
                                <p class="text-xs text-gray-300">catatan</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-3">
                        <h2 class="text-2xl font-bold text-white">Pertemuan Mendatang</h2>
                    </div>

                    <div class="bg-white/10 backdrop-blur-xl rounded-2xl border border-white/20 p-4 min-h-[120px]">
                        @forelse ($upcomingMeetings as $meeting)
                            <div class="py-3 {{ !$loop->last ? 'border-b border-white/10' : '' }}">
                                <p class="font-semibold text-white">{{ $meeting->title }}</p>
                                <p class="text-sm text-gray-300 mt-1">
                                    {{ \Carbon\Carbon::parse($meeting->meeting_date)->translatedFormat('d M Y') }}
                                    • {{ \Carbon\Carbon::parse($meeting->meeting_time)->format('H:i') }}
                                </p>
                            </div>
                        @empty
                            <p class="text-gray-300 text-center pt-8">Tidak ada pertemuan mendatang</p>
                        @endforelse
                    </div>
                </div>

                <div>
                    <h2 class="text-2xl font-bold text-white mb-3">Daftar Assignment</h2>
                    <div class="bg-white rounded-2xl p-4 space-y-3 shadow-lg">
                        @forelse ($assignmentList as $assignment)
                            <div class="rounded-xl px-4 py-3 {{ $assignment['is_submitted'] ? 'bg-green-50 border border-green-100' : ($assignment['is_overdue'] ? 'bg-red-50 border border-red-100' : ($assignment['is_due_soon'] ? 'bg-amber-50 border border-amber-100' : 'bg-slate-50 border border-slate-100')) }}">
                                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-1">
                                    <p class="font-semibold text-slate-800">{{ $assignment['title'] }}</p>
                                    <span class="text-xs font-bold uppercase tracking-wide {{ $assignment['is_submitted'] ? 'text-green-700' : 'text-slate-500' }}">
                                        {{ $assignment['is_submitted'] ? 'Sudah dikumpulkan' : 'Belum dikumpulkan' }}
                                    </span>
                                </div>
                                <p class="text-sm text-slate-500 mt-1">
                                    Deadline: {{ $assignment['deadline']->format('d M Y H:i') }}
                                    @if (!$assignment['is_submitted'] && $assignment['is_overdue'])
                                        (Melewati deadline)
                                    @elseif (!$assignment['is_submitted'] && $assignment['is_due_soon'])
                                        (Mendekati deadline)
                                    @endif
                                </p>
                            </div>
                        @empty
                            <p class="text-slate-500">Belum ada assignment untuk kelas Anda.</p>
                        @endforelse

                        <div class="pt-2">
                            <a href="{{ route('submissions.index') }}"
                                class="inline-flex items-center justify-center w-full bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white font-semibold py-3 rounded-xl transition-all duration-300">
                                Kumpulkan Tugas
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-white/10 backdrop-blur-xl rounded-2xl border border-white/20 p-6 text-center">
                    <div class="w-20 h-20 rounded-full bg-white/20 mx-auto mb-4 overflow-hidden flex items-center justify-center border border-white/30">
                        <span class="text-white text-xl font-bold">{{ strtoupper(substr($member->name, 0, 1)) }}</span>
                    </div>
                    <p class="text-lg font-bold text-white">{{ $member->name }}</p>
                    <p class="text-sm text-gray-300">{{ $member->email }}</p>

                    <div class="mt-5 grid grid-cols-2 gap-3 bg-purple-700 rounded-xl p-3 text-white">
                        <div>
                            <p class="text-xs text-purple-200">Tugas Selesai</p>
                            <p class="text-2xl font-bold">{{ $progressSummary['completed_assignments'] }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-purple-200">Belum Dikerjakan</p>
                            <p class="text-2xl font-bold">{{ $progressSummary['pending_assignments'] }}</p>
                        </div>
                    </div>
                </div>

                {{-- <div class="bg-white rounded-2xl p-5 shadow-lg">
                    <h3 class="text-xl font-bold text-slate-800 mb-4">Tugas Belum Dikerjakan</h3>
                    <div class="space-y-3">
                        @forelse ($pendingAssignments as $assignment)
                            <div class="flex items-start gap-3 p-3 rounded-lg bg-slate-50 border border-slate-100">
                                <div class="w-8 h-8 rounded-lg bg-orange-100 text-orange-500 flex items-center justify-center text-sm font-bold">!</div>
                                <div>
                                    <p class="font-medium text-slate-700 leading-snug">{{ $assignment['title'] }}</p>
                                    <p class="text-xs text-slate-500 mt-1">{{ $assignment['deadline']->format('d M Y') }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-slate-500 text-sm">Tidak ada tugas tertunda.</p>
                        @endforelse
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
</x-member-layout>
