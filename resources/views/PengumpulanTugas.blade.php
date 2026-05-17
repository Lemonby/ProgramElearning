<!DOCTYPE html>
<html>
<head>
    <title>Pengumpulan Tugas Berhasil</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header {
            background-color: #007bff;
            color: white;
            padding: 20px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            line-height: 1.6;
            color: #333;
        }
        .section {
            margin-bottom: 20px;
        }
        .label {
            font-weight: bold;
            color: #007bff;
        }
        .divider {
            border-top: 1px solid #ddd;
            margin: 20px 0;
        }
        .footer {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 4px;
            text-align: center;
            font-size: 14px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>✓ Pengumpulan Tugas Berhasil Diterima</h2>
        </div>

        <div class="content">
            <p>Halo <strong>{{ $namaSiswa }}</strong>,</p>
            
            <p>Pengumpulan tugas Anda telah berhasil disimpan dalam sistem. Berikut adalah rincian pengumpulan Anda:</p>

            <div class="section">
                <p><span class="label">Judul Tugas:</span><br>{{ $judulTugas }}</p>
            </div>

            <div class="section">
                <p><span class="label">Tanggal Pengumpulan:</span><br>{{ $tanggalSubmit }}</p>
            </div>

            <div class="section">
                <p><span class="label">Batas Akhir Pengumpulan:</span><br>{{ $batasTugas }}</p>
            </div>

            <div class="divider"></div>

            <p><strong>Informasi Penting:</strong></p>
            <ul>
                <li>Silakan pantau nilai dan feedback dari guru Anda di halaman penilaian.</li>
                <li>Anda dapat melihat riwayat pengumpulan tugas Anda kapan saja.</li>
                <li>Jika ada pertanyaan atau masalah, hubungi guru Anda.</li>
            </ul>

            <div class="divider"></div>

            <p>Terima kasih telah menggunakan sistem e-learning kami!</p>
            <p><strong>Tim CSC - Divisi Teknologi</strong></p>
        </div>

        <div class="footer">
            <p>Email ini adalah notifikasi otomatis. Silakan jangan balas email ini.</p>
            <p>&copy; 2026 Platform E-Learning. Semua hak cipta dilindungi.</p>
        </div>
    </div>
</body>
</html>