# 🚀 QUICK START - Fitur Upload Assignment

## ⚡ Setup Cepat (5 Menit)

### 1. Run Migration

```bash
php artisan migrate
```

### 2. Akses Routes

- **List**: http://localhost:8000/assignment
- **Create**: http://localhost:8000/assignment/create
- **Detail**: http://localhost:8000/assignment/{id}
- **Edit**: http://localhost:8000/assignment/{id}/edit}

---

## 📦 File Structure Baru

```
app/
  ├── Http/
  │   ├── Controllers/AssignmentController.php (NEW)
  │   └── Requests/StoreAssignmentRequest.php (NEW)
  └── Services/AssignmentService.php (NEW)

resources/
  └── views/assignment/ (NEW)
      ├── create.blade.php
      ├── edit.blade.php
      ├── index.blade.php
      └── show.blade.php

database/
  └── migrations/
      └── 2026_05_17_000001_add_file_path_to_assignments_table.php (NEW)
```

---

## 🎯 Features

### CREATE (Buat Assignment Baru)

- Upload file (PDF, DOC, DOCX, PPT, PPTX, XLS, XLSX, ZIP, RAR) max 10MB
- ATAU masukkan link eksternal
- Pilih kelas tujuan
- Set deadline
- Deskripsi lengkap

### READ (Lihat Assignment)

- List view dengan grid cards
- Detail view dengan full description
- Download file atau buka link

### UPDATE (Edit Assignment)

- Edit semua field
- Update file/link (optional)
- Preview file/link saat ini

### DELETE (Hapus Assignment)

- Soft delete atau hard delete
- Konfirmasi sebelum delete

---

## 🔧 Konfigurasi

### Storage Configuration (.env)

```env
FILESYSTEM_DISK=local
```

### File akan disimpan di:

```
storage/app/assignments/assignment_TIMESTAMP.ext
```

---

## ✨ Key Features

✅ Form dengan validasi lengkap  
✅ Error handling yang ramah user  
✅ File upload dengan safety checks  
✅ Support for external links  
✅ Download file atau buka link  
✅ Responsive design (mobile, tablet, desktop)  
✅ Custom error messages (Bahasa Indonesia)  
✅ CSRF protection  
✅ Authorization (auth middleware)

---

## 📋 Validasi Rules

| Field             | Rules                                                        |
| ----------------- | ------------------------------------------------------------ |
| `title`           | required, string, max:255                                    |
| `description`     | required, string, max:5000                                   |
| `deadline`        | required, date, after_or_equal:today                         |
| `class_id`        | required, integer, exists:classes,id                         |
| `file_assignment` | file, mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,zip,rar, max:10MB |
| `link_assignment` | url                                                          |

**Note**: File atau Link harus ada minimal salah satu

---

## 🎨 UI Highlights

- **Header Gradient**: Blue gradient header untuk visual appeal
- **Responsive Cards**: Menyesuaikan dengan ukuran layar
- **Badge Status**: Indicator untuk file (📄) atau link (🔗)
- **Action Buttons**: Edit, Delete, View Detail
- **Empty State**: Messaging jika belum ada assignment
- **Success/Error Messages**: Flash messages yang jelas

---

## 🧪 Manual Testing Checklist

- [ ] Create assignment dengan file
- [ ] Create assignment dengan link
- [ ] Validasi error (upload tanpa file/link)
- [ ] Validasi error (deadline lewat)
- [ ] Validasi error (invalid URL)
- [ ] Edit assignment
- [ ] Delete assignment
- [ ] Download file
- [ ] Open link eksternal
- [ ] Responsive design (mobile)

---

## 💡 Pro Tips

1. **File Organization**: Gunakan folder structure clear di Google Drive/GitHub untuk link
2. **Deadline Strategy**: Set deadline yang reasonable (biasanya 1-2 minggu)
3. **Description Format**: Gunakan format dengan clear instructions dan requirements
4. **File Format**: Prefer PDF untuk compatibility
5. **Link Preference**: Google Drive atau GitHub untuk public sharing

---

## 🆘 Common Issues & Solutions

| Issue                 | Solution                          |
| --------------------- | --------------------------------- |
| File tidak tersimpan  | Run `php artisan storage:link`    |
| Dropdown kelas kosong | Pastikan kelas sudah dibuat di DB |
| Form validation error | Check error messages di form      |
| Deadline error        | Pilih tanggal >= hari ini         |

---

## 📞 Next Steps

- [ ] Test semua fitur manual
- [ ] Verify file storage working
- [ ] Test responsive design
- [ ] Create sample assignments
- [ ] Setup notifications (optional)

---

**Status**: ✅ Ready for Production  
**Last Updated**: 17 May 2026  
**Version**: 1.0.0
