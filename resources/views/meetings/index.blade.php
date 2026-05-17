<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>meeting</title>
</head>
<body>
    <h1>Daftar Meeting</h1>

<a href="{{ route('meetings.create') }}">
    Tambah Meeting
</a>

<hr>

@foreach($meetings as $meeting)

<h3>{{ $meeting->title }}</h3>

<p>Tanggal:
{{ $meeting->meeting_date }}</p>

<p>Jam:
{{ $meeting->meeting_time }}</p>

<p>
<a href="{{ $meeting->meeting_link }}"
   target="_blank">

   Join Meeting
</a>
</p>

<p>{{ $meeting->description }}</p>

<a href="{{ route('meetings.edit', $meeting->id) }}">
    Edit
</a>

<form action="{{ route('meetings.destroy', $meeting->id) }}"
      method="POST">

    @csrf
    @method('DELETE')

    <button type="submit">
        Hapus
    </button>

</form>

<hr>

@endforeach
</body>
</html>