<x-member-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-white">
            Dashboard Member
        </h2>
    </x-slot>

    <div class="min-h-screen bg-gradient-to-b from-[#020617] to-purple-900 p-4 md:p-8">

        <!-- TOP SECTION -->
        <div class="bg-white/10 backdrop-blur-xl rounded-[30px] p-6 md:p-10 shadow-2xl">

            <!-- WELCOME -->
            <div class="mb-10">
                <h1 class="text-3xl md:text-5xl font-bold text-white mb-3">
                    Selamat Datang👋
                </h1>

                <p class="text-gray-300 text-sm md:text-base">
                    Lihat materi, kerjakan tugas, dan pantau progress Anda di sini.
                </p>
            </div>

            <!-- STATISTICS -->
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-8 mb-14">

                <!-- CARD -->
                <div class="text-center">
                    <div class="w-36 h-36 mx-auto rounded-full border-[16px] border-purple-600 flex items-center justify-center shadow-lg">
                        <div>
                            <h2 class="text-3xl font-bold text-white">20%</h2>
                            <p class="text-gray-300">2/10</p>
                        </div>
                    </div>

                    <h3 class="text-2xl font-semibold text-white mt-4">
                        Hadir
                    </h3>
                </div>

                <!-- CARD -->
                <div class="text-center">
                    <div class="w-36 h-36 mx-auto rounded-full border-[16px] border-purple-600 flex items-center justify-center shadow-lg">
                        <div>
                            <h2 class="text-3xl font-bold text-white">20%</h2>
                            <p class="text-gray-300">2/10</p>
                        </div>
                    </div>

                    <h3 class="text-2xl font-semibold text-white mt-4">
                        Izin
                    </h3>
                </div>

                <!-- CARD -->
                <div class="text-center">
                    <div class="w-36 h-36 mx-auto rounded-full border-[16px] border-purple-600 flex items-center justify-center shadow-lg">
                        <div>
                            <h2 class="text-3xl font-bold text-white">20%</h2>
                            <p class="text-gray-300">2/10</p>
                        </div>
                    </div>

                    <h3 class="text-2xl font-semibold text-white mt-4">
                        Sakit
                    </h3>
                </div>

                <!-- CARD -->
                <div class="text-center">
                    <div class="w-36 h-36 mx-auto rounded-full border-[16px] border-purple-600 flex items-center justify-center shadow-lg">
                        <div>
                            <h2 class="text-3xl font-bold text-white">20%</h2>
                            <p class="text-gray-300">2/10</p>
                        </div>
                    </div>

                    <h3 class="text-2xl font-semibold text-white mt-4">
                        Alpa
                    </h3>
                </div>
            </div>

            <!-- CONTENT GRID -->
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">

                <!-- EVENTS -->
                <div class="xl:col-span-2">

                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
                        <h2 class="text-3xl font-bold text-white">
                            Events
                        </h2>

                        <div class="flex gap-3">
                            <select class="rounded-xl border-none bg-white/90 px-4 py-2">
                                <option>Type</option>
                            </select>

                            <select class="rounded-xl border-none bg-white/90 px-4 py-2">
                                <option>Date</option>
                            </select>
                        </div>
                    </div>

                    <!-- EVENT CARDS -->
                    <div class="grid grid-cols-1 md:grid-cols-2 2xl:grid-cols-3 gap-6">

                        <!-- CARD -->
                        <div class="bg-white rounded-3xl p-5 shadow-lg">
                            <span class="bg-purple-200 text-purple-700 text-xs px-3 py-1 rounded-full">
                                Kelas ke-1
                            </span>

                            <h3 class="text-xl font-bold mt-4 mb-2">
                                Pengenalan DKV
                            </h3>

                            <p class="text-gray-500 text-sm mb-4">
                                Mempelajari unsur desain dan penggunaan aplikasi desain grafis.
                            </p>

                            <small class="text-gray-700 font-medium">
                                Ms. Icha
                            </small>
                        </div>

                        <!-- CARD -->
                        <div class="bg-white rounded-3xl p-5 shadow-lg">
                            <span class="bg-purple-200 text-purple-700 text-xs px-3 py-1 rounded-full">
                                Kelas ke-1
                            </span>

                            <h3 class="text-xl font-bold mt-4 mb-2">
                                Pengenalan DKV
                            </h3>

                            <p class="text-gray-500 text-sm mb-4">
                                Mempelajari unsur desain dan penggunaan aplikasi desain grafis.
                            </p>

                            <small class="text-gray-700 font-medium">
                                Ms. Icha
                            </small>
                        </div>

                    </div>
                </div>

                <!-- TODO -->
                <div>
                    <h2 class="text-3xl font-bold text-white mb-6">
                        To do:
                    </h2>

                    <div class="bg-white rounded-[30px] p-6 shadow-lg">

                        <div class="space-y-4">

                            <div class="bg-gray-100 rounded-xl px-4 py-4 font-semibold">
                                Tugas 1
                            </div>

                            <div class="bg-gray-100 rounded-xl px-4 py-4 font-semibold">
                                Tugas 2
                            </div>

                            <div class="bg-gray-100 rounded-xl px-4 py-4 font-semibold">
                                Tugas 3
                            </div>

                        </div>

                        <!-- BUTTON -->
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
    </div>
</x-member-layout>
