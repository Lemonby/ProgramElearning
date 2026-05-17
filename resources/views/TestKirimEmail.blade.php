<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Email Elearning</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-slate-900 text-white flex items-center justify-center min-h-screen">

    <div class="max-w-md w-full bg-slate-800 p-8 rounded-xl shadow-lg border border-slate-700">
        <h2 class="text-2xl font-bold mb-2 text-blue-400">Elearning Test</h2>
        <p class="text-slate-400 mb-6 text-sm">Gunakan form ini untuk mengetes pengiriman email ke Mailtrap Sandbox.</p>

        {{-- @if (session('success'))
            <div class="bg-green-500/20 border border-green-500 text-green-400 p-3 rounded-lg mb-6 text-sm">
                {{ session('success') }}
            </div>
        @endif --}}

        <form action="{{ route('pengumpulan_tugas.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2">Assignment ID</label>
                <input type="number" name="assignmentId" 
                    class="w-full px-4 py-2 rounded-lg bg-slate-700 border border-slate-600 focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all"
                    placeholder="Contoh: 1" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-2">Member ID (Siswa)</label>
                <input type="number" name="memberId" 
                    class="w-full px-4 py-2 rounded-lg bg-slate-700 border border-slate-600 focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all"
                    placeholder="Contoh: 2" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-2">Nama Siswa</label>
                <input type="text" name="namaSiswa" 
                    class="w-full px-4 py-2 rounded-lg bg-slate-700 border border-slate-600 focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all"
                    placeholder="Contoh: John Doe" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-2">Judul Tugas (Opsional)</label>
                <input type="text" name="judulTugas" 
                    class="w-full px-4 py-2 rounded-lg bg-slate-700 border border-slate-600 focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all"
                    placeholder="Contoh: Pengembangan Fitur Tracking V2">
            </div>
            
            {{-- kirim file tugas atau link --}}
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2">File Tugas</label>
                <input type="file" name="fileTugas" 
                    class="w-full px-4 py-2 rounded-lg bg-slate-700 border border-slate-600 focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all"
                    placeholder="Pilih file tugas">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-2">Link Tugas (Opsional)</label>
                <input type="url" name="linkTugas" 
                    class="w-full px-4 py-2 rounded-lg bg-slate-700 border border-slate-600 focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all"
                    placeholder="Contoh: https://github.com/...">
            </div>

            <button type="submit" 
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg transition-colors shadow-md">
                Kirim Test Email
            </button>
        </form>
    </div>

</body>
</html>