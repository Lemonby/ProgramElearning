<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Materi</title>
</head>
<body>

<h1>Tambah Materi</h1>

<form action="{{ route('materials.store') }}"
      method="POST"
      enctype="multipart/form-data">

    @csrf

    <input type="text"
           name="title"
           placeholder="Judul Materi">

    <br><br>

    <textarea name="description"
              placeholder="Deskripsi"></textarea>

    <br><br>

   <select name="class_id" required>

    @foreach($classes as $class)

    <option value="{{ $class->id }}">
        {{ $class->description }}
    </option>

    @endforeach

</select>

    <br><br>

    <input type="file" name="file">

    <br><br>

    <button type="submit">
        Upload
    </button>

</form>

</body>
</html>