<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tambah Materi</title>
</head>
<body>
    <h1>Tambah Materi</h1>

    <form action="{{ route('materials.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div>
            <label > Judul </label>
            <input type="text" name="title">
        </div>

        <br>

        <div>
            <label >Deskripsi</label>
            <textarea name="deskription" id="" cols="30" rows="10"></textarea>
        </div>

        <br>

        <div>
            <label >File Materi</label>
            <input type="file" name="file">
        </div>

        <br>

        <button type="submit">
            Upload
        </button>
    </form>
</body>
</html>