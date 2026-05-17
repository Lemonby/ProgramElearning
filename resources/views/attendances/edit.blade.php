<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Absensi</title>
</head>
<body>

<h1>Edit Absensi</h1>

<form action="{{ route('attendances.update', $attendance->id) }}"
      method="POST">

    @csrf
    @method('PUT')

    <label>Meeting</label>

    <select name="meeting_id">

        @foreach($meetings as $meeting)

        <option value="{{ $meeting->id }}"
            {{ $attendance->meeting_id == $meeting->id ? 'selected' : '' }}>

            {{ $meeting->title }}

        </option>

        @endforeach

    </select>

    <br><br>

    <label>Member</label>

    <select name="member_id">

        @foreach($users as $user)

        <option value="{{ $user->id }}"
            {{ $attendance->member_id == $user->id ? 'selected' : '' }}>

            {{ $user->name }}

        </option>

        @endforeach

    </select>

    <br><br>

    <label>Status</label>

    <select name="status">

        <option value="hadir"
            {{ $attendance->status == 'hadir' ? 'selected' : '' }}>
            Hadir
        </option>

        <option value="izin"
            {{ $attendance->status == 'izin' ? 'selected' : '' }}>
            Izin
        </option>

        <option value="sakit"
            {{ $attendance->status == 'sakit' ? 'selected' : '' }}>
            Sakit
        </option>

        <option value="alpa"
            {{ $attendance->status == 'alpa' ? 'selected' : '' }}>
            Alpa
        </option>

    </select>

    <br><br>

    <button type="submit">
        Update
    </button>

</form>

</body>
</html>