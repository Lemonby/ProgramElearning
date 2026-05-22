<!DOCTYPE html>
<html>
<head>
    <title>Riwayat Kehadiran</title>
</head>
<body>

<h1>Riwayat Kehadiran Saya</h1>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Meeting ID</th>
        <th>Status</th>
    </tr>

    @foreach($attendances as $attendance)
    <tr>
        <td>{{ $attendance->id }}</td>
        <td>{{ $attendance->meeting_id }}</td>
        <td>{{ $attendance->status }}</td>
    </tr>
    @endforeach

</table>

</body>
</html>