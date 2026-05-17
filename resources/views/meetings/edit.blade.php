<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>edit meeting</title>
</head>
<body>
    <h1>Edit Meeting</h1>
@if ($errors->any())

    @foreach ($errors->all() as $error)

        <p>{{ $error }}</p>

    @endforeach

@endif
<form action="{{ route('meetings.update', $meeting->id) }}"
      method="POST">

    @csrf
    @method('PUT')

    <input type="text"
           name="title"
           value="{{ $meeting->title }}">

    <br><br>

    <input type="date"
           name="meeting_date"
           value="{{ $meeting->meeting_date }}">

    <br><br>

    <input type="time"
           name="meeting_time"
           value="{{ $meeting->meeting_time }}">

    <br><br>

    <input type="text"
           name="meeting_link"
           value="{{ $meeting->meeting_link }}">

    <br><br>

    <textarea name="description">
        {{ $meeting->description }}
    </textarea>

    <br><br>

    <button type="submit">
        Update
    </button>
</form>
</body>
</html>