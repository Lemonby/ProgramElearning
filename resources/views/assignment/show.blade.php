@extends('layouts.master')

@section('title', 'Detail Assignment: ' . $assignment->title)

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Back Button & Actions -->
        <div class="flex items-center justify-between mb-6">
            <a href="{{ route('assignment.index') }}" class="text-blue-600 hover:text-blue-800 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali ke Daftar
            </a>
            <div class="flex gap-2">
                <a 
                    href="{{ route('assignment.edit', $assignment->id) }}"
                    class="bg-yellow-600 hover:bg-yellow-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-200"
                >
                    Edit
                </a>
                <form 
                    action="{{ route('assignment.destroy', $assignment->id) }}" 
                    method="POST"
                    style="display: inline;"
                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus assignment ini?');"
                >
                    @csrf
                    @method('DELETE')
                    <button 
                        type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-200"
                    >
                        Hapus
                    </button>
                </form>
            </div>
        </div>

        <!-- Header Card -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg shadow-lg p-8 mb-6">
            <h1 class="text-3xl font-bold text-white mb-4">{{ $assignment->title }}</h1>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-white">
                <div>
                    <p class="text-blue-100 text-sm">Kelas</p>
                    <p class="font-semibold text-lg">{{ $assignment->class->name }}</p>
                </div>
                <div>
                    <p class="text-blue-100 text-sm">Batas Waktu</p>
                    <p class="font-semibold text-lg">{{ $assignment->deadline->format('d M Y, H:i') }}</p>
                </div>
                <div>
                    <p class="text-blue-100 text-sm">Dibuat</p>
                    <p class="font-semibold text-lg">{{ $assignment->created_at->format('d M Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Content Cards -->
        <div class="space-y-6">
            <!-- Description -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Deskripsi Assignment</h2>
                <div class="text-gray-700 whitespace-pre-wrap leading-relaxed">
                    {{ $assignment->description }}
                </div>
            </div>

            <!-- File/Link Section -->
            @if ($assignment->file_path)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">File atau Link Assignment</h2>
                    
                    @if (Str::startsWith($assignment->file_path, ['http://', 'https://']))
                        <!-- External Link -->
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <div class="flex items-center gap-3 mb-3">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.658 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                </svg>
                                <span class="font-semibold text-blue-900">Link Assignment</span>
                            </div>
                            <a 
                                href="{{ $assignment->file_path }}" 
                                target="_blank"
                                class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-800 font-semibold break-all"
                            >
                                {{ Str::limit($assignment->file_path, 80) }}
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                </svg>
                            </a>
                        </div>
                    @else
                        <!-- Local File -->
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                            <div class="flex items-center gap-3 mb-3">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 21l-8.97-8.97a6 6 0 018.485-8.485 6 6 0 018.485 8.485L12 21z"></path>
                                </svg>
                                <span class="font-semibold text-green-900">File Assignment</span>
                            </div>
                            <p class="text-gray-700 mb-3">Lokasi: <code class="bg-gray-100 px-2 py-1 rounded text-sm">{{ $assignment->file_path }}</code></p>
                            <a 
                                href="{{ Storage::url($assignment->file_path) }}"
                                download
                                class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded transition duration-200"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                                Download File
                            </a>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Additional Info -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Informasi Tambahan</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-gray-50 rounded p-4">
                        <p class="text-sm text-gray-600">ID Assignment</p>
                        <p class="font-semibold text-gray-900">#{{ $assignment->id }}</p>
                    </div>
                    <div class="bg-gray-50 rounded p-4">
                        <p class="text-sm text-gray-600">Waktu Pembaruan</p>
                        <p class="font-semibold text-gray-900">{{ $assignment->updated_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
