# DEISA - Quick Reference Guide

## 🎯 Fitur Aplikasi (5 Modul)

### 1. Dashboard 📊
- **URL:** `http://localhost:8000/dashboard`
- **Fitur:** Overview statistik, quick access buttons
- **Statistik:** Total Santri, Kelas, Obat, Laporan

### 2. Data Santri 👥
- **URL:** `http://localhost:8000/santri/index`
- **CRUD:**
  - **Create:** `/santri/create` → Form + Preview
  - **Read:** `/santri/index` → Table list
  - **Update:** `/santri/{id}/edit` → Edit form
  - **Delete:** Delete button dengan konfirmasi

### 3. Kelas 🏫
- **URL:** `http://localhost:8000/kelas`
- **CRUD:** Create, Read (list), Update, Delete
- **Validasi:** Nama kelas harus unik

### 4. Santri Sakit 🏥
- **URL:** `http://localhost:8000/sakit`
- **Data:** Tinggi badan, berat badan, golongan darah, catatan
- **CRUD:** Create, Read, Update, Delete

### 5. Obat 💊
- **URL:** `http://localhost:8000/obat`
- **Data:** Nama, deskripsi, stok, satuan
- **Fitur:** Stok indicator (🟢🟡🔴)
- **CRUD:** Create, Read, Update, Delete

### 6. Laporan 📄
- **URL:** `http://localhost:8000/laporan`
- **Data:** Keluhan, suhu tubuh, tindakan, status kondisi
- **Status:** Sehat, Sakit Ringan, Sakit Berat
- **CRUD:** Create, Read, Update, Delete

---

## 🗂️ Struktur File

### Controllers (`app/Http/Controllers/`)
```
DashboardController.php      ← Dashboard
SantriController.php         ← Santri CRUD
KelasController.php          ← Kelas CRUD
SakitController.php          ← Health Info CRUD
ObatController.php           ← Medicine CRUD
LaporanController.php        ← Report CRUD
```

### Models (`app/Models/`)
```
Santri.php                   ← Student model
Kelas.php                    ← Class model
WaliSantri.php               ← Guardian model
InfoKesehatanSantri.php      ← Health info model
RiwayatPemeriksaan.php       ← Check-up history model
Obat.php                     ← Medicine model
```

### Views (`resources/views/`)
```
layouts/master.blade.php     ← Master template
dashboard.blade.php          ← Dashboard

santri/
  index.blade.php           ← List students
  create.blade.php          ← Add student form
  edit.blade.php            ← Edit student form

kelas/
  index.blade.php           ← List classes
  create.blade.php          ← Add class form
  edit.blade.php            ← Edit class form

sakit/
  index.blade.php           ← List health info
  create.blade.php          ← Add health info form
  edit.blade.php            ← Edit health info form

obat/
  index.blade.php           ← List medicines
  create.blade.php          ← Add medicine form
  edit.blade.php            ← Edit medicine form

laporan/
  index.blade.php           ← List reports
  create.blade.php          ← Add report form
  edit.blade.php            ← Edit report form
```

---

## 🚀 Getting Started

### Step 1: Database Setup
```bash
# Create database
mysql -u root -p
> CREATE DATABASE deisa;

# Update .env
DB_DATABASE=deisa
DB_USERNAME=root
DB_PASSWORD=
```

### Step 2: Run Migrations
```bash
php artisan migrate
```

### Step 3: Start Server
```bash
php artisan serve
```

### Step 4: Add Initial Data
1. Go to `/kelas` → Add classes
2. Go to `/obat` → Add medicines
3. Go to `/santri` → Add students
4. Go to `/sakit` → Add health info
5. Go to `/laporan` → Add reports

---

## 📋 Form Fields Reference

### Santri Form
| Field | Type | Validation |
|-------|------|-----------|
| NIS | Text | Required, Unique |
| Nama Lengkap | Text | Required |
| Jenis Kelamin | Select | Required |
| Kelas | Select | Required, Exists |
| Tempat Lahir | Text | Required |
| Tanggal Lahir | Date | Required |
| Nama Wali | Text | Required |
| Hubungan | Select | Required (Ayah/Ibu/Wali) |
| No HP | Tel | Required |
| Tempat Lahir Wali | Text | Required |
| Tanggal Lahir Wali | Date | Required |
| Alamat | Textarea | Required |

### Kelas Form
| Field | Type | Validation |
|-------|------|-----------|
| Nama Kelas | Text | Required, Unique |

### Sakit Form
| Field | Type | Validation |
|-------|------|-----------|
| Santri | Select | Required, Exists |
| Tinggi Badan | Number | Required |
| Berat Badan | Number | Required |
| Golongan Darah | Select | Optional (A/B/AB/O) |
| Catatan | Textarea | Optional |

### Obat Form
| Field | Type | Validation |
|-------|------|-----------|
| Nama Obat | Text | Required |
| Deskripsi | Textarea | Optional |
| Stok | Number | Required, Min 0 |
| Satuan | Select | Required |

### Laporan Form
| Field | Type | Validation |
|-------|------|-----------|
| Santri | Select | Required, Exists |
| Tanggal Pemeriksaan | Date | Required |
| Keluhan | Textarea | Required |
| Suhu Tubuh | Number | Required |
| Tindakan | Textarea | Optional |
| Status Kondisi | Select | Required |

---

## 🎨 UI Features

### Navigation
- **Sidebar Menu:** Dashboard, Santri, Kelas, Sakit, Obat, Laporan
- **Active State:** Current page highlighted
- **Mobile:** Hamburger menu on small screens

### List Pages
- **Table:** Responsive table with data
- **Actions:** Edit, Delete buttons
- **Add Button:** Top right corner
- **Empty State:** Message if no data

### Form Pages
- **Breadcrumb:** Show current location
- **Two Column:** Form on left (on desktop)
- **Validation:** Show errors inline
- **Submit:** Save/Update button
- **Cancel:** Back button

### Alerts
- **Success:** Green alert after save/delete
- **Error:** Red alert if validation fails
- **Dismissible:** Can close alerts

---

## 🔍 Form Validation Messages

**Server-side validation:**
```
"nis" => "required|string|unique:santris",
"nama_lengkap" => "required|string",
"jenis_kelamin" => "required|string",
"kelas_id" => "required|exists:kelas,id",
"tempat_lahir" => "required|string",
"tanggal_lahir" => "required|date",
```

**Messages display:**
- Below each input field
- In red text
- Auto-disappears when corrected

---

## 🔐 Security

✅ **CSRF Protection:** All forms protected
✅ **Validation:** Server-side validation
✅ **Authorization:** Check user permissions
✅ **Delete Confirm:** Confirm before delete
✅ **Unique:** Database constraints

---

## 🐛 Troubleshooting

### Issue: Page not found (404)
**Solution:** Clear route cache
```bash
php artisan route:clear
```

### Issue: Database connection error
**Solution:** Check .env file
```
DB_HOST=127.0.0.1
DB_DATABASE=deisa
DB_USERNAME=root
DB_PASSWORD=
```

### Issue: Foreign key error
**Solution:** Make sure parent record exists first
- Add Kelas before Santri
- Add Santri before Health Info

### Issue: Cannot delete
**Solution:** Check related records
- Deleting Santri also deletes WaliSantri
- Check child records first

---

## 📱 Responsive Breakpoints

- **Mobile:** < 768px (Hamburger menu active)
- **Tablet:** 768px - 992px (Single column)
- **Desktop:** > 992px (Two column layout)

---

## 🎯 Common Tasks

### Add a New Student
1. Go to `/kelas` → Create classes first
2. Go to `/santri/create`
3. Fill all fields
4. Click "Simpan"
5. Check list at `/santri`

### Track Health
1. Go to `/sakit/create`
2. Select student
3. Enter height, weight, blood type
4. Click "Simpan"

### Create Report
1. Go to `/laporan/create`
2. Select student
3. Enter symptoms, temperature, action
4. Select condition status
5. Click "Simpan"

### Update Medication Stock
1. Go to `/obat`
2. Click edit on medicine
3. Update stock
4. Click "Perbarui"

---

## 🔄 Data Flow

```
Dashboard
    ↓
Select Menu Item
    ↓
List Page (Index)
    ↓
Create/Edit/Delete ← Actions
    ↓
Success Message
    ↓
Back to List
```

---

## 💡 Tips & Tricks

1. **Keyboard Navigation:** Tab through form fields
2. **Form Retention:** Data saved on validation error
3. **Quick Add:** Add button visible on all list pages
4. **Breadcrumb:** Click to navigate back
5. **Mobile:** Hamburger menu for narrow screens
6. **Status Badge:** Color indicates health status
7. **Stock Color:** Green/Yellow/Red stock levels

---

## 📞 Support

- **Docs:** Check APPLICATION_GUIDE.md
- **Technical:** See TECHNICAL_SUMMARY.md
- **Database:** See DATABASE_MIGRATION_GUIDE.md

---

**DEISA v1.0** | Last Updated: December 28, 2025
**Quick Ref Version:** 1.0
