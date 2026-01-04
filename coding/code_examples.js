// ============================================
// DEISA Data Management - Code Examples
// ============================================

// ============================================
// 1. WORKING WITH LOCALSTORAGE (Current)
// ============================================

// Get all data
const allData = JSON.parse(localStorage.getItem('dataSantri')) || [];

// Add data
function addNewStudent(studentData) {
    const dataList = JSON.parse(localStorage.getItem('dataSantri')) || [];
    dataList.push(studentData);
    localStorage.setItem('dataSantri', JSON.stringify(dataList));
}

// Get single data
function getStudent(index) {
    const dataList = JSON.parse(localStorage.getItem('dataSantri')) || [];
    return dataList[index];
}

// Update data
function updateStudent(index, updatedData) {
    const dataList = JSON.parse(localStorage.getItem('dataSantri')) || [];
    dataList[index] = updatedData;
    localStorage.setItem('dataSantri', JSON.stringify(dataList));
}

// Delete data
function deleteStudent(index) {
    const dataList = JSON.parse(localStorage.getItem('dataSantri')) || [];
    dataList.splice(index, 1);
    localStorage.setItem('dataSantri', JSON.stringify(dataList));
}

// Clear all data
function clearAllStudents() {
    localStorage.removeItem('dataSantri');
}

// ============================================
// 2. API INTEGRATION EXAMPLES (Future)
// ============================================

// ---- CREATE (POST) ----
async function addNewStudentToAPI(studentData) {
    try {
        const response = await fetch('/api/santri', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(studentData)
        });

        if (!response.ok) throw new Error('Failed to add student');
        return await response.json();
    } catch (error) {
        console.error('Error:', error);
        showAlert('Gagal menambah data', 'danger');
    }
}

// ---- READ ALL (GET) ----
async function getAllStudentsFromAPI() {
    try {
        const response = await fetch('/api/santri');
        if (!response.ok) throw new Error('Failed to fetch students');
        return await response.json();
    } catch (error) {
        console.error('Error:', error);
        showAlert('Gagal memuat data', 'danger');
        return [];
    }
}

// ---- READ ONE (GET) ----
async function getStudentFromAPI(id) {
    try {
        const response = await fetch(`/api/santri/${id}`);
        if (!response.ok) throw new Error('Student not found');
        return await response.json();
    } catch (error) {
        console.error('Error:', error);
        showAlert('Data tidak ditemukan', 'danger');
        return null;
    }
}

// ---- UPDATE (PUT) ----
async function updateStudentToAPI(id, updatedData) {
    try {
        const response = await fetch(`/api/santri/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(updatedData)
        });

        if (!response.ok) throw new Error('Failed to update student');
        return await response.json();
    } catch (error) {
        console.error('Error:', error);
        showAlert('Gagal memperbarui data', 'danger');
    }
}

// ---- DELETE (DELETE) ----
async function deleteStudentFromAPI(id) {
    try {
        const response = await fetch(`/api/santri/${id}`, {
            method: 'DELETE'
        });

        if (!response.ok) throw new Error('Failed to delete student');
        return await response.json();
    } catch (error) {
        console.error('Error:', error);
        showAlert('Gagal menghapus data', 'danger');
    }
}

// ============================================
// 3. QUICK MIGRATION WRAPPER
// ============================================

// This wrapper helps you switch between localStorage and API easily
const DataService = {
    // Flag to switch between localStorage and API
    useAPI: false,

    // Create
    async add(data) {
        if (this.useAPI) {
            return await addNewStudentToAPI(data);
        } else {
            addNewStudent(data);
            return data;
        }
    },

    // Read All
    async getAll() {
        if (this.useAPI) {
            return await getAllStudentsFromAPI();
        } else {
            return JSON.parse(localStorage.getItem('dataSantri')) || [];
        }
    },

    // Read One
    async getById(id) {
        if (this.useAPI) {
            return await getStudentFromAPI(id);
        } else {
            const dataList = JSON.parse(localStorage.getItem('dataSantri')) || [];
            return dataList[id];
        }
    },

    // Update
    async update(id, data) {
        if (this.useAPI) {
            return await updateStudentToAPI(id, data);
        } else {
            updateStudent(id, data);
            return data;
        }
    },

    // Delete
    async delete(id) {
        if (this.useAPI) {
            return await deleteStudentFromAPI(id);
        } else {
            deleteStudent(id);
            return true;
        }
    }
};

// Usage:
// DataService.add(studentData);
// const all = await DataService.getAll();
// const one = await DataService.getById(0);
// DataService.update(0, newData);
// DataService.delete(0);

// ============================================
// 4. SEARCH & FILTER FUNCTIONS
// ============================================

// Search by name
function searchByName(keyword) {
    const dataList = JSON.parse(localStorage.getItem('dataSantri')) || [];
    return dataList.filter(student =>
        student.namaSantri.toLowerCase().includes(keyword.toLowerCase())
    );
}

// Search by NIS
function searchByNIS(nis) {
    const dataList = JSON.parse(localStorage.getItem('dataSantri')) || [];
    return dataList.find(student => student.nis === nis);
}

// Search by class
function searchByClass(kelas) {
    const dataList = JSON.parse(localStorage.getItem('dataSantri')) || [];
    return dataList.filter(student => student.kelas === kelas);
}

// Filter by gender
function filterByGender(gender) {
    const dataList = JSON.parse(localStorage.getItem('dataSantri')) || [];
    return dataList.filter(student => student.jenisKelamin === gender);
}

// Sort by name (A-Z)
function sortByName() {
    const dataList = JSON.parse(localStorage.getItem('dataSantri')) || [];
    return dataList.sort((a, b) =>
        a.namaSantri.localeCompare(b.namaSantri)
    );
}

// ============================================
// 5. DATA EXPORT/IMPORT
// ============================================

// Export to JSON file
function exportDataAsJSON() {
    const dataList = JSON.parse(localStorage.getItem('dataSantri')) || [];
    const dataStr = JSON.stringify(dataList, null, 2);
    const dataBlob = new Blob([dataStr], { type: 'application/json' });
    const url = URL.createObjectURL(dataBlob);
    const link = document.createElement('a');
    link.href = url;
    link.download = `santri-backup-${new Date().toISOString().split('T')[0]}.json`;
    link.click();
}

// Export to CSV
function exportDataAsCSV() {
    const dataList = JSON.parse(localStorage.getItem('dataSantri')) || [];

    if (dataList.length === 0) {
        showAlert('Tidak ada data untuk diekspor', 'warning');
        return;
    }

    // CSV headers
    const headers = ['NIS', 'Nama', 'Gender', 'Kelas', 'Tempat Lahir', 'Tgl Lahir', 'Nama Wali', 'Hubungan', 'No HP', 'Alamat'];

    // CSV rows
    const rows = dataList.map(d => [
        d.nis,
        d.namaSantri,
        d.jenisKelamin,
        d.kelas,
        d.tempatLahir,
        d.tanggalLahir,
        d.namaWali,
        d.hubungan,
        d.nomorHp,
        d.alamat
    ]);

    // Create CSV content
    const csvContent = [
        headers.join(','),
        ...rows.map(row => row.map(cell => `"${cell}"`).join(','))
    ].join('\n');

    // Download
    const blob = new Blob([csvContent], { type: 'text/csv' });
    const url = URL.createObjectURL(blob);
    const link = document.createElement('a');
    link.href = url;
    link.download = `santri-export-${new Date().toISOString().split('T')[0]}.csv`;
    link.click();
}

// Import from JSON file
function importDataFromJSON(event) {
    const file = event.target.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = (e) => {
        try {
            const importedData = JSON.parse(e.target.result);

            if (!Array.isArray(importedData)) {
                throw new Error('Format harus array data');
            }

            localStorage.setItem('dataSantri', JSON.stringify(importedData));
            showAlert(`Berhasil import ${importedData.length} data!`, 'success');
            location.reload();
        } catch (error) {
            showAlert(`Gagal import: ${error.message}`, 'danger');
        }
    };
    reader.readAsText(file);
}

// ============================================
// 6. VALIDATION FUNCTIONS
// ============================================

// Validate student data
function validateStudentData(data) {
    const errors = [];

    if (!data.nis || data.nis.trim() === '') errors.push('NIS harus diisi');
    if (!data.namaSantri || data.namaSantri.trim() === '') errors.push('Nama santri harus diisi');
    if (!data.jenisKelamin) errors.push('Jenis kelamin harus dipilih');
    if (!data.kelas) errors.push('Kelas harus dipilih');
    if (!data.tempatLahir || data.tempatLahir.trim() === '') errors.push('Tempat lahir harus diisi');
    if (!data.tanggalLahir) errors.push('Tanggal lahir harus diisi');
    if (!data.namaWali || data.namaWali.trim() === '') errors.push('Nama wali harus diisi');
    if (!data.hubungan) errors.push('Hubungan harus dipilih');
    if (!data.nomorHp || data.nomorHp.trim() === '') errors.push('Nomor HP harus diisi');
    if (!data.alamat || data.alamat.trim() === '') errors.push('Alamat harus diisi');

    return errors;
}

// Check duplicate NIS
function checkDuplicateNIS(nis, excludeIndex = -1) {
    const dataList = JSON.parse(localStorage.getItem('dataSantri')) || [];
    return dataList.some((student, index) =>
        student.nis === nis && index !== excludeIndex
    );
}

// ============================================
// 7. STATISTICS & ANALYTICS
// ============================================

// Get total students
function getTotalStudents() {
    const dataList = JSON.parse(localStorage.getItem('dataSantri')) || [];
    return dataList.length;
}

// Get students by class
function getStudentsByClass() {
    const dataList = JSON.parse(localStorage.getItem('dataSantri')) || [];
    const result = {};

    dataList.forEach(student => {
        result[student.kelas] = (result[student.kelas] || 0) + 1;
    });

    return result;
}

// Get gender distribution
function getGenderDistribution() {
    const dataList = JSON.parse(localStorage.getItem('dataSantri')) || [];
    const result = { 'Laki-laki': 0, 'Perempuan': 0 };

    dataList.forEach(student => {
        result[student.jenisKelamin]++;
    });

    return result;
}

// Get average age
function getAverageAge() {
    const dataList = JSON.parse(localStorage.getItem('dataSantri')) || [];

    if (dataList.length === 0) return 0;

    const totalAge = dataList.reduce((sum, student) => {
        const birthDate = new Date(student.tanggalLahir);
        const age = new Date().getFullYear() - birthDate.getFullYear();
        return sum + age;
    }, 0);

    return (totalAge / dataList.length).toFixed(1);
}

// ============================================
// 8. BACKUP & RESTORE
// ============================================

// Auto-backup to localStorage
function autoBackup() {
    const dataList = JSON.parse(localStorage.getItem('dataSantri')) || [];
    localStorage.setItem('dataSantri_backup', JSON.stringify(dataList));
    localStorage.setItem('dataSantri_backup_time', new Date().toISOString());
}

// Restore from backup
function restoreFromBackup() {
    const backup = localStorage.getItem('dataSantri_backup');
    if (!backup) {
        showAlert('Tidak ada backup yang tersimpan', 'warning');
        return;
    }

    if (confirm('Yakin ingin mengembalikan dari backup?')) {
        localStorage.setItem('dataSantri', backup);
        showAlert('Data berhasil dikembalikan dari backup', 'success');
        location.reload();
    }
}

// Get backup info
function getBackupInfo() {
    const backupTime = localStorage.getItem('dataSantri_backup_time');
    const backupSize = localStorage.getItem('dataSantri_backup')?.length || 0;

    return {
        time: backupTime ? new Date(backupTime).toLocaleString('id-ID') : 'Belum ada backup',
        size: `${(backupSize / 1024).toFixed(2)} KB`
    };
}

// ============================================
// 9. HELPER FUNCTIONS
// ============================================

// Format date to Indonesian
function formatDateIndonesian(dateString) {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateString).toLocaleDateString('id-ID', options);
}

// Calculate age from birth date
function calculateAge(birthDate) {
    const today = new Date();
    let age = today.getFullYear() - new Date(birthDate).getFullYear();
    const monthDifference = today.getMonth() - new Date(birthDate).getMonth();

    if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < new Date(birthDate).getDate())) {
        age--;
    }

    return age;
}

// Generate NIS automatically
function generateNIS() {
    return 'NIS' + Date.now();
}

// Check browser storage size
function getStorageSize() {
    let total = 0;
    for (let key in localStorage) {
        if (localStorage.hasOwnProperty(key)) {
            total += localStorage[key].length + key.length;
        }
    }
    return `${(total / 1024).toFixed(2)} KB`;
}

// ============================================
// 10. USAGE EXAMPLES
// ============================================

/*
// Example: Create new student
const newStudent = {
  nis: '001',
  namaSantri: 'Ahmad Fadillah',
  jenisKelamin: 'Laki-laki',
  kelas: 'Kelas 1',
  tempatLahir: 'Jakarta',
  tanggalLahir: '2010-05-15',
  namaWali: 'Bapak Ahmad',
  hubungan: 'Ayah',
  nomorHp: '081234567890',
  alamat: 'Jl. Merdeka No. 123'
};

// Validate data
const errors = validateStudentData(newStudent);
if (errors.length > 0) {
  console.error('Validation errors:', errors);
} else {
  // Check duplicate
  if (checkDuplicateNIS(newStudent.nis)) {
    console.error('NIS sudah terdaftar');
  } else {
    // Save data
    addNewStudent(newStudent);
    autoBackup();
  }
}

// Get statistics
console.log('Total:', getTotalStudents());
console.log('By Class:', getStudentsByClass());
console.log('Gender:', getGenderDistribution());
console.log('Avg Age:', getAverageAge());

// Export
exportDataAsJSON();
exportDataAsCSV();

// Storage info
console.log('Storage Size:', getStorageSize());
console.log('Backup Info:', getBackupInfo());
*/
