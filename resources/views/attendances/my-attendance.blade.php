<!DOCTYPE html>
<html>
<head>
    <title>Riwayat Kehadiran</title>
</head>
<body>

<h1>Riwayat Kehadiran</h1>

<table border="1" cellpadding="10">
    <tr>
        <th>Meeting</th>
        <th>Status</th>
    </tr>

    @foreach($attendances as $attendance)

    <tr>
        <td>{{ $attendance->meeting->title }}</td>
        <td>{{ $attendance->status }}</td>
    </tr>

    @endforeach

</table>

</body>
</html>