<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Absensi</title>
</head>
<body>

<h1>Tambah Absensi</h1>
@if ($errors->any())

    <ul>

        @foreach ($errors->all() as $error)

            <li>{{ $error }}</li>

        @endforeach

    </ul>

@endif
<form action="{{ route('attendances.store') }}"
      method="POST">

    @csrf

    <label>Meeting</label>

    <select name="meeting_id" required>

        @foreach($meetings as $meeting)

            <option value="{{ $meeting->id }}">
                {{ $meeting->title }}
            </option>

        @endforeach

    </select>

    <br><br>

    <label>Member</label>

    <select name="member_id" required>

        @foreach($users as $user)

            <option value="{{ $user->id }}">
                {{ $user->name }}
            </option>

        @endforeach

    </select>

    <br><br>

    <label>Status</label>

    <select name="status">

        <option value="hadir">Hadir</option>
        <option value="izin">Izin</option>
        <option value="sakit">Sakit</option>
        <option value="alpa">Alpa</option>

    </select>

    <br><br>

    <button type="submit">
        Simpan
    </button>

</form>

</body>
</html>