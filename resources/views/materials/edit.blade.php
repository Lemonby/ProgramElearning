<x-mentor-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Materi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('materials.update', $material->id) }}"
                      method="POST"
                      enctype="multipart/form-data"
                      class="space-y-6">

                    @csrf
                    @method('PUT')

                    <!-- Judul Materi -->
                    <div>
                        <label for="title" class="block font-medium text-sm text-gray-700 dark:text-gray-300">
                            {{ __('Judul Materi') }} <span class="text-red-600">*</span>
                        </label>
                        <input type="text"
                               id="title"
                               name="title"
                               placeholder="{{ __('Judul Materi') }}"
                               value="{{ $material->title }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                               required>
                        @error('title')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label for="description" class="block font-medium text-sm text-gray-700 dark:text-gray-300">
                            {{ __('Deskripsi') }}
                        </label>
                        <textarea id="description"
                                  name="description"
                                  placeholder="{{ __('Deskripsi') }}"
                                  rows="4"
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ $material->description }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kelas -->
                    <div>
                        <label for="class_id" class="block font-medium text-sm text-gray-700 dark:text-gray-300">
                            {{ __('Kelas') }} <span class="text-red-600">*</span>
                        </label>
                        <select id="class_id" 
                                name="class_id"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                required>
                            <option value="">-- {{ __('Pilih Kelas') }} --</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" 
                                        @if($class->id === $material->class_id) selected @endif>
                                    {{ $class->description }}
                                </option>
                            @endforeach
                        </select>
                        @error('class_id')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- File Materi Saat Ini -->
                    <div>
                        <label class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('File Materi Saat Ini') }}
                        </label>
                        <a href="{{ asset('storage/' . $material->file_url) }}" 
                           target="_blank"
                           class="inline-flex items-center px-3 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            {{ __('📥 Download File') }}
                        </a>
                    </div>

                    <!-- File Materi Baru -->
                    <div>
                        <label for="file" class="block font-medium text-sm text-gray-700 dark:text-gray-300">
                            {{ __('Upload File Baru (Opsional)') }}
                        </label>
                        <input type="file" 
                               id="file"
                               name="file"
                               class="mt-1 block w-full text-sm text-gray-700 dark:text-gray-300">
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            {{ __('Format: PDF, PPT, PPTX, DOC, DOCX (Max 20 MB) - Biarkan kosong jika tidak ingin mengganti file') }}
                        </p>
                        @error('file')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-3 justify-end">
                        <a href="{{ route('materials.index') }}">
                            <x-secondary-button>
                                {{ __('Batal') }}
                            </x-secondary-button>
                        </a>
                        <x-primary-button>
                            {{ __('Perbarui') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-mentor-layout>
