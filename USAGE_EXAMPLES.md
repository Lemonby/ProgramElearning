# 📚 CONTOH PENGGUNAAN - Fitur Assignment Upload

## 1. Mengakses Halaman List Assignment

```bash
# Buka di browser
http://localhost:8000/assignment
```

---

## 2. Mengakses Form Create Assignment

```bash
# Buka di browser
http://localhost:8000/assignment/create
```

**Form Fields:**

- Kelas (dropdown)
- Judul Assignment
- Deskripsi
- Batas Waktu
- File ATAU Link

---

## 3. Submit Assignment dengan FILE

```html
<!-- Form Example -->
<form action="/assignment" method="POST" enctype="multipart/form-data">
    @csrf

    <!-- Class Selection -->
    <select name="class_id" required>
        <option value="">Pilih Kelas</option>
        <option value="1">Class 1</option>
        <option value="2">Class 2</option>
    </select>

    <!-- Title -->
    <input type="text" name="title" value="Laravel Assignment" required />

    <!-- Description -->
    <textarea name="description" required>
        Buat aplikasi Laravel dengan fitur...
    </textarea>

    <!-- Deadline -->
    <input
        type="datetime-local"
        name="deadline"
        value="2026-05-25T23:59"
        required
    />

    <!-- File Upload -->
    <input type="file" name="file_assignment" accept=".pdf,.doc,.docx" />

    <button type="submit">Buat Assignment</button>
</form>
```

**Expected Response:**

```
Redirect ke: /assignment
Message: Assignment berhasil dibuat! ID: 1
```

---

## 4. Submit Assignment dengan LINK

```html
<!-- Form dengan Link -->
<form action="/assignment" method="POST">
    @csrf

    <select name="class_id" required>
        <option value="1">Class 1</option>
    </select>

    <input type="text" name="title" value="GitHub Project" required />

    <textarea name="description">
        Fork repo ini dan lakukan...
    </textarea>

    <input type="datetime-local" name="deadline" required />

    <!-- Link instead of file -->
    <input
        type="url"
        name="link_assignment"
        value="https://github.com/example/assignment"
        required
    />

    <button type="submit">Buat Assignment</button>
</form>
```

---

## 5. Lihat Detail Assignment

```bash
# Buka di browser
http://localhost:8000/assignment/1
```

**Page menampilkan:**

- Title dalam header gradient
- Kelas & deadline info
- Full description
- Download button (jika file) atau open link
- Edit & Delete buttons

---

## 6. Edit Assignment

```bash
# Buka di browser
http://localhost:8000/assignment/1/edit
```

**Form sama seperti create, tapi dengan:**

- Data existing sudah terisi
- Preview file/link saat ini
- File/link baru bersifat optional

```html
<form action="/assignment/1" method="POST" enctype="multipart/form-data">
    @csrf @method('PUT')

    <!-- Form fields -->
    <input type="text" name="title" value="Laravel Assignment (Updated)" />

    <!-- Upload file baru (optional) -->
    <input type="file" name="file_assignment" />

    <button type="submit">Simpan Perubahan</button>
</form>
```

---

## 7. Delete Assignment

```bash
# Method 1: Via UI (klik tombol Hapus)
# Method 2: Via curl
curl -X DELETE http://localhost:8000/assignment/1 \
  -H "X-CSRF-TOKEN: token_value"
```

**Response:**

```
Redirect ke: /assignment
Message: Assignment berhasil dihapus!
```

---

## 8. Menggunakan Service Langsung

```php
<?php

namespace App\Http\Controllers;

use App\Services\AssignmentService;
use Illuminate\Http\Request;

class MyController extends Controller
{
    public function customUpload(Request $request, AssignmentService $service)
    {
        // Create assignment
        $assignment = $service->simpanAssignment(
            title: $request->input('title'),
            description: $request->input('description'),
            deadline: $request->input('deadline'),
            classId: $request->input('class_id'),
            fileAssignment: $request->file('file'),
            linkAssignment: $request->input('link')
        );

        return response()->json([
            'success' => true,
            'assignment_id' => $assignment->id,
            'message' => 'Assignment berhasil dibuat'
        ]);
    }

    public function customEdit(AssignmentService $service)
    {
        $assignment = Assignment::find(1);

        // Update assignment
        $updated = $service->updateAssignment(
            assignment: $assignment,
            title: 'New Title',
            description: 'New Description',
            deadline: now()->addWeek(),
            classId: 1
        );

        return $updated;
    }
}
```

---

## 9. Query Assignment di Database

```php
<?php

// Get all assignments
$assignments = \App\Models\Assignments::all();

// Get with class info
$assignments = \App\Models\Assignments::with('class')->get();

// Get for specific class
$assignments = \App\Models\Assignments::where('class_id', 1)->get();

// Get upcoming assignments
$upcoming = \App\Models\Assignments::where('deadline', '>', now())->get();

// Get past assignments
$past = \App\Models\Assignments::where('deadline', '<', now())->get();

// Find specific assignment
$assignment = \App\Models\Assignments::find(1);
$assignment = \App\Models\Assignments::findOrFail(1);

// Check file exists
if ($assignment->file_path) {
    if (Str::startsWith($assignment->file_path, 'http')) {
        // It's an external link
    } else {
        // It's a file path
    }
}
```

---

## 10. File Download Implementation

```php
<?php

// Di controller
public function downloadFile($assignmentId)
{
    $assignment = Assignment::findOrFail($assignmentId);

    // Check if file path valid
    if (!$assignment->file_path) {
        abort(404, 'File tidak ditemukan');
    }

    $filePath = storage_path('app/' . $assignment->file_path);

    if (!file_exists($filePath)) {
        abort(404, 'File tidak ditemukan');
    }

    return response()->download($filePath);
}
```

```html
<!-- Di view -->
@if ($assignment->file_path && !Str::startsWith($assignment->file_path, 'http'))
<a
    href="{{ route('assignment.download', $assignment->id) }}"
    class="btn btn-primary"
>
    Download File
</a>
@endif
```

---

## 11. Validation Error Handling

```php
<?php

// Controller dengan try-catch
try {
    $assignment = $service->simpanAssignment(/* params */);
    return redirect()->route('assignment.show', $assignment->id);

} catch (\Throwable $e) {
    return back()
        ->withInput()
        ->withErrors(['error' => $e->getMessage()]);
}
```

```html
<!-- Di blade view -->
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
```

---

## 12. Testing dengan Artisan Tinker

```bash
# Open tinker
php artisan tinker

# Create class first
>>> $class = App\Models\Classes::first();

# Create assignment
>>> App\Models\Assignments::create([
    'class_id' => $class->id,
    'title' => 'Test Assignment',
    'description' => 'This is a test',
    'deadline' => now()->addDays(7),
    'file_path' => 'assignments/test.pdf'
]);

# Get all assignments
>>> App\Models\Assignments::all();

# Get with relationship
>>> App\Models\Assignments::with('class')->get();

# Delete
>>> App\Models\Assignments::find(1)->delete();
```

---

## 13. API Response Example

```json
{
    "success": true,
    "data": {
        "id": 1,
        "class_id": 1,
        "title": "Laravel Assignment",
        "description": "Build a CRUD app...",
        "deadline": "2026-05-25T23:59:00",
        "file_path": "assignments/assignment_1715938274.pdf",
        "created_at": "2026-05-17T10:00:00",
        "updated_at": "2026-05-17T10:00:00",
        "class": {
            "id": 1,
            "name": "Class A"
        }
    }
}
```

---

## 14. Troubleshooting Guide

### Problem: File tidak muncul di list

```php
// Check database
php artisan tinker
>>> App\Models\Assignments::all();

// Check storage
ls storage/app/assignments/
```

### Problem: Link tidak bisa dibuka

```php
// Verify URL format
>>> $assignment->file_path;
// Output: "https://drive.google.com/..."
```

### Problem: Validation error persisten

```php
// Check StoreAssignmentRequest rules
// Check form field names match request properties
```

---

## 15. Performance Tips

```php
<?php

// ✅ Good - dengan eager loading
$assignments = Assignment::with('class')->get();

// ❌ Bad - N+1 query problem
$assignments = Assignment::all();
foreach ($assignments as $assignment) {
    echo $assignment->class->name;
}

// ✅ Good - pagination
$assignments = Assignment::with('class')->paginate(15);

// ✅ Good - caching
$assignments = Cache::remember('assignments', 3600, function () {
    return Assignment::with('class')->get();
});
```

---

## 📚 Reference

- Controllers: `app/Http/Controllers/AssignmentController.php`
- Models: `app/Models/Assignments.php`
- Views: `resources/views/assignment/`
- Service: `app/Services/AssignmentService.php`
- Routes: `routes/web.php`

---

**Last Updated**: 17 May 2026  
**Version**: 1.0.0
