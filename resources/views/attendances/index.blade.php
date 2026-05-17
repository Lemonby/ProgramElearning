<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Absensi</title>
</head>
<body>

<h1>Data Absensi</h1>

<a href="{{ route('attendances.create') }}">
    Tambah Absensi
</a>

<br><br>

<table border="1" cellpadding="10">

    <tr>
        <th>ID</th>
        <th>Meeting ID</th>
        <th>Member ID</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>

    @foreach($attendances as $attendance)

    <tr>
        <td>{{ $attendance->id }}</td>
        <td>{{ $attendance->meeting->title }}</td>
        <td>{{ $attendance->member->name }}</td>
        <td>{{ $attendance->status }}</td>

        <td>

            <a href="{{ route('attendances.edit', $attendance->id) }}">
                Edit
            </a>

            <form action="{{ route('attendances.destroy', $attendance->id) }}"
                  method="POST">

                @csrf
                @method('DELETE')

                <button type="submit">
                    Hapus
                </button>

            </form>

        </td>
    </tr>

    @endforeach

</table>

</body>
</html>