# 📁 Storage Configuration untuk Assignment Upload

## ✅ Folder Structure

```
storage/
├── app/
│   ├── assignments/                    # Local storage (backup/private)
│   ├── public/
│   │   ├── assignments/               # PUBLIC - File bisa di-download
│   │   └── .gitignore
│   ├── private/
│   └── .gitignore

public/
└── storage -> ../../storage/app/public  # Symlink untuk public access
```

## 🔧 Setup yang Sudah Dilakukan

✅ **Folder Creation**

```bash
mkdir -p storage/app/assignments
mkdir -p storage/app/public/assignments
```

✅ **Permissions**

```bash
chmod -R 775 storage/app/
```

✅ **Symlink Setup**

```bash
php artisan storage:link
# Membuat symlink: public/storage -> storage/app/public
```

## 📤 File Upload Flow

```
User Upload File
    ↓
Form Validation (StoreAssignmentRequest)
    ↓
AssignmentController->store()
    ↓
AssignmentService->simpanAssignment()
    ↓
uploadFile() [disk: 'public']
    ↓
storage/app/public/assignments/assignment_TIMESTAMP.ext
    ↓
DB: file_path = 'assignments/assignment_TIMESTAMP.ext'
    ↓
Download URL: /storage/assignments/assignment_TIMESTAMP.ext
```

## 💾 File Storage Locations

### Local Storage (Backup)

```
storage/app/assignments/
```

- Used untuk backup internal
- Not directly accessible via web

### Public Storage (Download)

```
storage/app/public/assignments/
```

- File yang bisa di-download siswa
- Accessible via `/storage/assignments/`
- Via symlink: `public/storage -> storage/app/public`

## 🌐 Access URLs

### Download File

```
GET /storage/assignments/assignment_1715938274.pdf
```

Full URL:

```
http://localhost:8000/storage/assignments/assignment_1715938274.pdf
```

### In Blade Template

```php
// Generate download link
Storage::url('assignments/assignment_1715938274.pdf')
// Output: /storage/assignments/assignment_1715938274.pdf
```

## 🔍 Verify Setup

```bash
# Check folder exists
ls -la storage/app/public/assignments/

# Check symlink
ls -la public/storage

# Test in browser
curl http://localhost:8000/storage/assignments/
```

## 📝 Troubleshooting

### ❌ "File not found" error

```bash
# Recreate symlink
php artisan storage:link

# Check permissions
chmod -R 775 storage/app/
```

### ❌ "Permission denied" saat upload

```bash
# Fix permissions
chmod -R 775 storage/
chown -R www-data:www-data storage/  # atau user yang sesuai
```

### ❌ File tidak terlihat di public

```bash
# Ensure public disk configured in config/filesystems.php
php artisan config:cache

# Verify symlink exists
ls -la public/storage
```

## 🔒 Security Notes

1. **File Validation** - Hanya file format tertentu yang diizinkan
2. **Size Limit** - Max 10MB per file
3. **Disk Config** - Menggunakan 'public' disk untuk controlled access
4. **Permissions** - 775 untuk writable folder
5. **Path Safety** - File name di-generate dengan timestamp, tidak dari user input

## 📂 File Naming Convention

```
assignment_TIMESTAMP.EXTENSION
Contoh: assignment_1715938274.pdf
```

- `TIMESTAMP` - Unix timestamp (unique per file)
- `EXTENSION` - Original file extension (.pdf, .doc, dll)
- **Tidak ada** user-provided name (untuk security)

## 🗑️ Cleanup (Optional)

### Delete Old Files

```bash
# Manual delete
rm -rf storage/app/public/assignments/*

# Via Laravel command (custom - perlu dibuat)
php artisan assignments:cleanup-old-files
```

### Database Cleanup

```bash
# Delete orphaned assignment records
php artisan tinker
>>> \App\Models\Assignments::whereNull('file_path')->delete();
```

## 📊 Storage Statistics

```bash
# Check folder size
du -sh storage/app/public/assignments/

# Count files
ls storage/app/public/assignments/ | wc -l

# List files with size
ls -lh storage/app/public/assignments/
```

## 🔄 Migration to Another Server

### Backup Files

```bash
# Backup storage folder
tar -czf assignments_backup.tar.gz storage/app/public/assignments/
```

### Restore Files

```bash
# Extract to new server
tar -xzf assignments_backup.tar.gz -C /new/server/path/
chmod -R 775 /new/server/path/storage/
php artisan storage:link
```

## 📋 Checklist

- [x] Folder `storage/app/assignments` created
- [x] Folder `storage/app/public/assignments` created
- [x] Permissions set to 775
- [x] Symlink created (`public/storage`)
- [x] Service updated to use 'public' disk
- [x] File upload ready

---

**Status**: ✅ Storage Setup Complete
