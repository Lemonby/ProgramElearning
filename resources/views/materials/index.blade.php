<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Daftar Materi</title>
</head>
<body>
    <h1>Daftar Materi</h1>

    <a href="{{ route('materials.create') }}">
    Tambah Materi
    </a>
    
    <hr>

    @foreach ($materials as $material )
        <h3>{{ $material->title }}</h3>
        <p>{{ $material->deskription }}</p>
        <a href="{{ asset('storage/' . $material->file) }}">
            Download File</a>

            <hr>

            <form action="{{ route('materials.destroy', $material->id) }}" method="POST">
        @csrf
        @method('DELETE')

        <button type="submit">
            Hapus
        </button>
    </form>
        
    @endforeach


</body>
</html>