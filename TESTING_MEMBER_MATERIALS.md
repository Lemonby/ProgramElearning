# Testing Guide - Member Materials Feature

## Quick Test Steps

### 1. Access Member Materials Page

```
URL: http://127.0.0.1:8000/materi
Expected: Empty state with message "Belum ada materi"
```

### 2. Test with Materials Data

1. Login as Mentor/Admin
2. Create/Upload material via `/materials` (MaterialController)
3. Go back to member account
4. Access `/materi`
5. Should see material card with:
    - Material title
    - Description preview
    - Class badge
    - Upload date/time
    - View & Download buttons

### 3. Test View Material Detail

1. Click "Lihat" (View) button on any material card
2. Verify detail page shows:
    - Full title
    - Full description
    - Class info
    - Upload timestamp
    - File download button
    - Breadcrumb back to list

### 4. Test Download Functionality

1. Click "Download" button (from list or detail page)
2. Verify file downloads correctly
3. Check file integrity

### 5. Test Authorization

1. Create material for Class A
2. Login as member from Class B
3. Access `/materi` - should NOT see Class A materials
4. Try direct access to material ID: `/materi/{id}` - should get 403 error

### 6. Test Responsive Design

1. Test on mobile (375px)
2. Test on tablet (768px)
3. Test on desktop (1920px)
4. Verify layout adjusts correctly:
    - Mobile: 1 column grid
    - Tablet: 2 columns
    - Desktop: 3 columns

## Test Scenarios

### Scenario A: First Time Visit

- [ ] Page loads without errors
- [ ] Empty state displays correctly
- [ ] Heading "Materi Pembelajaran" is visible
- [ ] Icon and message are centered

### Scenario B: With Materials

- [ ] Materials from user's class appear
- [ ] Materials from other classes don't appear
- [ ] Cards display complete information
- [ ] Buttons are clickable

### Scenario C: Detail View

- [ ] All material info is displayed
- [ ] Breadcrumb navigation works
- [ ] Download button works
- [ ] Dark mode styling works properly

### Scenario D: Error Handling

- [ ] 403 error for unauthorized access
- [ ] 404 error for non-existent material
- [ ] Graceful error pages display

## Browser Support

- Chrome/Edge (Latest)
- Firefox (Latest)
- Safari (Latest)
- Mobile browsers

## Performance Notes

- Page loads with list of materials from user's class only
- Uses eager loading (with 'class') for performance
- Latest materials first (sorted by created_at desc)

## Known Limitations

- Read-only access (no edit/delete for members)
- File download only (no inline view)
- Requires authentication
- Limited to member's assigned class
