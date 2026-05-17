<x-mentor-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Buat Assignment Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                <h3 class="text-red-800 font-semibold mb-3">Terjadi kesalahan:</h3>
                <ul class="text-red-700 space-y-1 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Success Message -->
        @if (session('success'))
            <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <!-- Form -->
        <form action="{{ route('assignment.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow-md p-6">
            @csrf

            <!-- Class Selection -->
            <div class="mb-6">
                <label for="class_id" class="block text-sm font-medium text-gray-700 mb-2">
                    Kelas <span class="text-red-500">*</span>
                </label>
                <select 
                    id="class_id" 
                    name="class_id"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('class_id') border-red-500 @enderror"
                    required
                >
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                            {{ $class->name }}
                        </option>
                    @endforeach
                </select>
                @error('class_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Title -->
            <div class="mb-6">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                    Judul Assignment <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="title" 
                    name="title"
                    maxlength="255"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('title') border-red-500 @enderror"
                    placeholder="Contoh: Membuat Aplikasi To-Do List"
                    value="{{ old('title') }}"
                    required
                >
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Deskripsi Assignment <span class="text-red-500">*</span>
                </label>
                <textarea 
                    id="description" 
                    name="description"
                    rows="6"
                    maxlength="5000"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror"
                    placeholder="Jelaskan detail assignment, requirement, dan kriteria penilaian..."
                    required
                >{{ old('description') }}</textarea>
                <p class="text-sm text-gray-500 mt-1">Maksimal 5000 karakter</p>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Deadline -->
            <div class="mb-6">
                <label for="deadline" class="block text-sm font-medium text-gray-700 mb-2">
                    Batas Waktu <span class="text-red-500">*</span>
                </label>
                <input 
                    type="datetime-local" 
                    id="deadline" 
                    name="deadline"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('deadline') border-red-500 @enderror"
                    value="{{ old('deadline') }}"
                    required
                >
                @error('deadline')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- File atau Link -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Upload File atau Link Assignment <span class="text-red-500">*</span>
                </label>
                <p class="text-sm text-gray-600 mb-3">Pilih salah satu: Upload file atau masukkan link (contoh: Google Drive, GitHub, dll)</p>

                <!-- File Upload -->
                <div class="mb-4">
                    <label for="file_assignment" class="block text-sm font-medium text-gray-600 mb-2">
                        Upload File
                    </label>
                    <div class="relative">
                        <input 
                            type="file" 
                            id="file_assignment" 
                            name="file_assignment"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('file_assignment') border-red-500 @enderror"
                            accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.zip,.rar"
                        >
                        <p class="text-xs text-gray-500 mt-1">
                            Format: PDF, DOC, DOCX, PPT, PPTX, XLS, XLSX, ZIP, RAR (Max: 10MB)
                        </p>
                    </div>
                    @error('file_assignment')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Divider -->
                <div class="flex items-center my-4">
                    <div class="flex-grow border-t border-gray-300"></div>
                    <span class="px-3 text-gray-500 text-sm">ATAU</span>
                    <div class="flex-grow border-t border-gray-300"></div>
                </div>

                <!-- Link Assignment -->
                <div>
                    <label for="link_assignment" class="block text-sm font-medium text-gray-600 mb-2">
                        Link Assignment
                    </label>
                    <input 
                        type="url" 
                        id="link_assignment" 
                        name="link_assignment"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('link_assignment') border-red-500 @enderror"
                        placeholder="https://drive.google.com/... atau https://github.com/..."
                        value="{{ old('link_assignment') }}"
                    >
                    @error('link_assignment')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex gap-4">
                <button 
                    type="submit" 
                    class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-200"
                >
                    Buat Assignment
                </button>
                <a 
                    href="{{ route('assignment.index') }}"
                    class="flex-1 text-center bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded-lg transition duration-200"
                >
                    Batal
                </a>
            </div>
        </form>

        <!-- Info Box -->
        <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-4">
            <h3 class="font-semibold text-blue-900 mb-2">💡 Tips:</h3>
            <ul class="text-blue-800 text-sm space-y-1">
                <li>• Jelaskan requirement assignment dengan detail agar siswa memahami apa yang harus dikerjakan</li>
                <li>• Tentukan deadline yang cukup realistis untuk siswa menyelesaikan assignment</li>
                <li>• Berikan referensi/materi dalam file atau link untuk membantu siswa</li>
                <li>• Pastikan kelas yang dipilih sudah benar sebelum membuat assignment</li>
            </ul>
        </div>
        </div>
    </div>
</x-mentor-layout>
