# Fitur Upload Assignment oleh Mentor

## 📋 Daftar File yang Dibuat

### Controllers

- `app/Http/Controllers/AssignmentController.php` - Controller utama untuk CRUD assignment

### Requests (Validasi)

- `app/Http/Requests/StoreAssignmentRequest.php` - Validasi untuk create/store assignment

### Services

- `app/Services/AssignmentService.php` - Business logic untuk handle file upload dan database

### Models

- `app/Models/Assignments.php` - Model Assignment (sudah diupdate dengan relationship)

### Views

- `resources/views/assignment/create.blade.php` - Form untuk buat assignment baru
- `resources/views/assignment/index.blade.php` - Daftar semua assignment (list view)
- `resources/views/assignment/show.blade.php` - Detail assignment
- `resources/views/assignment/edit.blade.php` - Form untuk edit assignment

### Migrations

- `database/migrations/2026_05_09_003726_create_assignments_table.php` - Updated dengan file_path
- `database/migrations/2026_05_17_000001_add_file_path_to_assignments_table.php` - Add file_path column

### Routes

- `routes/web.php` - Updated dengan resource routes untuk assignment

---

## 🚀 Cara Menggunakan

### 1. Migration

Jalankan migration untuk menambahkan kolom `file_path` ke tabel assignments:

```bash
php artisan migrate
```

### 2. Akses Fitur

#### A. Daftar Assignment

```
GET /assignment
```

Menampilkan daftar semua assignment yang telah dibuat mentor dengan kartu yang menampilkan:

- Judul assignment
- Kelas yang dituju
- Deadline
- Status file/link (📄 File atau 🔗 Link)

#### B. Buat Assignment Baru

```
GET /assignment/create
```

Form untuk membuat assignment baru dengan input:

- **Kelas** (dropdown) - Pilih kelas tujuan assignment
- **Judul Assignment** - Judul yang deskriptif (max 255 karakter)
- **Deskripsi** - Detail lengkap assignment (max 5000 karakter)
- **Batas Waktu** - Tanggal dan jam deadline
- **File atau Link** - Upload file (pdf, doc, docx, ppt, pptx, xls, xlsx, zip, rar, max 10MB) ATAU masukkan URL link

```
POST /assignment
```

Simpan assignment ke database dengan validasi lengkap

#### C. Lihat Detail Assignment

```
GET /assignment/{id}
```

Menampilkan detail lengkap assignment:

- Header dengan info kelas, deadline, tanggal dibuat
- Deskripsi lengkap
- File/Link dengan opsi download (jika file) atau buka link eksternal
- Informasi tambahan (ID, waktu pembaruan)
- Tombol Edit & Hapus

#### D. Edit Assignment

```
GET /assignment/{id}/edit
```

Form untuk mengedit assignment (sama seperti create, tapi dengan data existing)

```
PUT /assignment/{id}
```

Update assignment dengan file/link yang baru (opsional)

#### E. Hapus Assignment

```
DELETE /assignment/{id}
```

Menghapus assignment dari database

---

## ✅ Validasi yang Diterapkan

### Validasi Input

```php
'title' => 'required|string|max:255',
'description' => 'required|string|max:5000',
'deadline' => 'required|date|after_or_equal:today',
'class_id' => 'required|integer|exists:classes,id',
'file_assignment' => 'nullable|required_without:link_assignment|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,zip,rar|max:10240',
'link_assignment' => 'nullable|required_without:file_assignment|url',
```

### Error Messages

Semua error message sudah di-customize dalam bahasa Indonesia:

- Error untuk field yang kosong
- Error untuk format yang tidak valid
- Error untuk ukuran file terlalu besar
- Error untuk deadline yang sudah lewat

---

## 📁 File Storage Configuration

Files akan disimpan di:

```
storage/app/assignments/
```

Struktur file:

```
assignment_{timestamp}.{extension}
Contoh: assignment_1715938274.pdf
```

---

## 🗄️ Database Schema

### Tabel: assignments

```sql
CREATE TABLE assignments (
    id BIGINT PRIMARY KEY,
    class_id BIGINT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    deadline DATETIME NOT NULL,
    file_path VARCHAR(255) NULLABLE,  -- Path file atau link
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (class_id) REFERENCES classes(id)
);
```

---

## 🔗 Model Relationships

### Assignments Model

```php
class Assignments extends Model
{
    protected $fillable = [
        'class_id',
        'title',
        'description',
        'deadline',
        'file_path'
    ];

    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }
}
```

---

## 🛠️ AssignmentService - Business Logic

Service ini menangani:

1. **Simpan Assignment**

```php
$assignmentService->simpanAssignment(
    title: 'Judul Assignment',
    description: 'Deskripsi',
    deadline: '2026-05-25 23:59:00',
    classId: 1,
    fileAssignment: $uploadedFile,  // UploadedFile atau null
    linkAssignment: 'https://...'   // URL atau null
);
```

2. **Update Assignment**

```php
$assignmentService->updateAssignment(
    assignment: $assignment,
    title: 'Judul Baru',
    description: 'Deskripsi Baru',
    deadline: '2026-05-25 23:59:00',
    classId: 1,
    fileAssignment: $newFile,   // Optional
    linkAssignment: $newLink    // Optional
);
```

3. **Delete Assignment**

```php
$assignmentService->deleteAssignment($assignment);
```

---

## 🎨 UI/UX Features

### Halaman Index (Daftar)

- Grid responsive (1 kolom mobile, 2 kolom tablet, 3 kolom desktop)
- Kartu dengan gradient header
- Preview deskripsi (max 100 karakter)
- Status file/link dengan badge warna
- Aksi: Lihat Detail, Edit, Hapus

### Halaman Create/Edit

- Form lengkap dengan instruksi
- Validasi real-time
- Error messages yang jelas
- Tips/best practices di bawah form
- File format reference

### Halaman Show (Detail)

- Header gradient dengan info penting
- Deskripsi lengkap (text formatting preserved)
- Download file atau buka link eksternal
- Info tambahan (ID, waktu update)
- Aksi: Edit, Hapus

---

## 🔐 Security Features

1. **Authorization** - Routes dilindungi dengan middleware `auth`
2. **CSRF Protection** - Form dilindungi dengan CSRF token
3. **File Validation** - Hanya file dengan tipe yang diizinkan
4. **File Size Limit** - Max 10MB per file
5. **Path Traversal Prevention** - File disimpan dengan nama random
6. **Database Constraints** - Foreign key ke classes, cascade on delete

---

## 📝 Testing

### Test Create Assignment

```bash
GET /assignment/create
POST /assignment (dengan form data)
```

### Test Edit Assignment

```bash
GET /assignment/1/edit
PUT /assignment/1 (dengan form data)
```

### Test Delete Assignment

```bash
DELETE /assignment/1
```

### Test View Assignment

```bash
GET /assignment
GET /assignment/1
```

---

## 🐛 Troubleshooting

### File tidak tersimpan

- Pastikan folder `storage/app/assignments/` ada dan writable
- Jalankan `php artisan storage:link`

### Error "Class tidak ditemukan"

- Pastikan kelas sudah dibuat di database
- Gunakan dropdown untuk memilih kelas

### Error "File terlalu besar"

- Max file size adalah 10MB
- Kompres file terlebih dahulu jika diperlukan

### Deadline error

- Deadline tidak boleh lebih awal dari hari ini
- Gunakan format datetime-local di form

---

## 🚀 Next Steps (Optional)

Fitur yang bisa ditambahkan di masa depan:

1. Edit file tanpa menghapus yang lama (versioning)
2. Attachment multiple files
3. Notification ke siswa saat ada assignment baru
4. Download semua submissions siswa
5. Assignment template/reusable
6. Duplicate assignment ke kelas lain
7. Scoring/rubric attachment
8. Extension deadline per siswa

---

## 📞 Support

Untuk pertanyaan atau masalah:

1. Cek error messages di form
2. Lihat Laravel logs: `storage/logs/`
3. Verifikasi database migration sudah jalan
4. Pastikan user role = mentor
