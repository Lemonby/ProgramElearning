<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>create meeting</title>
</head>
<body>
    <h1>Tambah Meeting</h1>

<form action="{{ route('meetings.store') }}"
      method="POST">

    @csrf

    <input type="text"
           name="title"
           placeholder="Judul Meeting">

    <br><br>

    <input type="date"
           name="meeting_date">

    <br><br>

    <input type="time"
           name="meeting_time">

    <br><br>

    <input type="text"
           name="meeting_link"
           placeholder="Link Zoom/Gmeet">

    <br><br>

    <textarea name="description"
              placeholder="Deskripsi"></textarea>

    <br><br>

    <button type="submit">
        Simpan
    </button>
</form>
</body>
</html>