@extends('layouts.master')
@section('content')
    <!-- PAGE HEADER -->
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('sakit.index') }}" class="text-decoration-none">Data Sakit Santri</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Tambah Data Sakit</li>
            </ol>
        </nav>

        <h4 class="fw-bold mb-0">Tambah Data Santri Sakit</h4>
        <small class="text-muted">Semua input masuk ke draft dulu! Bisa tambah banyak tanpa hilang 😎</small>
    </div>

    <div class="row g-4">
        <!-- LEFT SECTION - FORM INPUT -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="fw-bold mb-4">
                        <i class="bi bi-pencil-square me-2 text-primary"></i> Form Input Data
                    </h5>

                    <form id="formSakit">
                        @csrf
                        <input type="hidden" name="edit_id" id="edit_id">

                        <h6 class="fw-bold text-primary mb-3">Data Santri</h6>

                        <div class="mb-4">
                            <label class="form-label">Pilih Santri</label>
                            <select class="form-select" id="santri_id" name="santri_id" required>
                                <option value="" disabled selected>-- Pilih Santri --</option>
                                @foreach ($santri as $s)
                                    <option value="{{ $s->id }}">{{ $s->nis }} - {{ $s->nama_lengkap }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <hr>

                        <h6 class="fw-bold text-primary mb-3">Data Penyakit</h6>

                        <div class="mb-3">
                            <label class="form-label">Tanggal Mulai Sakit</label>
                            <input type="date" class="form-control" id="tanggal_mulai_sakit" name="tanggal_mulai_sakit"
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Diagnosis Penyakit</label>
                            <input type="text" class="form-control" id="diagnosis" name="diagnosis"
                                placeholder="Contoh: Flu, Demam, Diare" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Gejala yang Dialami</label>
                            <textarea class="form-control" id="gejala" name="gejala" rows="3" placeholder="Deskripsikan gejala..."
                                required></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tindakan/Perawatan</label>
                            <textarea class="form-control" id="tindakan" name="tindakan" rows="3"
                                placeholder="Tindakan medis yang diberikan..." required></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Resep Obat</label>
                            <textarea class="form-control" id="resep_obat" name="resep_obat" rows="3" placeholder="Obat yang diberikan..."
                                required></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Suhu Tubuh (°C)</label>
                            <input type="number" class="form-control" id="suhu_tubuh" name="suhu_tubuh" placeholder="38.5"
                                step="0.1">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status Kondisi</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="" disabled selected>-- Pilih Status --</option>
                                <option value="sakit">Masih Sakit</option>
                                <option value="sembuh">Sembuh</option>
                                <option value="kontrol">Kontrol</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tanggal Selesai Sakit (Opsional)</label>
                            <input type="date" class="form-control" id="tanggal_selesai_sakit"
                                name="tanggal_selesai_sakit">
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Catatan Tambahan</label>
                            <textarea class="form-control" id="catatan" name="catatan" rows="2" placeholder="Catatan lainnya..."></textarea>
                        </div>

                        <hr>

                        <!-- OBAT SECTION -->
                        <h6 class="fw-bold text-primary mb-3">
                            <i class="bi bi-capsule me-2"></i> Obat yang Digunakan
                        </h6>

                        <div id="obatContainer" class="mb-3">
                            <!-- Obat items akan ditambahkan di sini -->
                        </div>

                        <button type="button" class="btn btn-sm btn-outline-primary mb-4" onclick="addObatRow()">
                            <i class="bi bi-plus-circle me-1"></i> Tambah Obat
                        </button>

                        <div class="d-flex gap-2">
                            <button type="button" onclick="addToTemporary()" class="btn btn-primary flex-fill"
                                id="btnSubmit">
                                <i class="bi bi-plus-circle me-1"></i> TAMBAH KE DRAFT
                            </button>
                            <button type="button" onclick="cancelEdit()" class="btn btn-secondary" id="btnCancel"
                                style="display:none;">
                                <i class="bi bi-x-circle me-1"></i> Batal
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

        <!-- RIGHT SECTION - DRAFT TABLE -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0"><i class="bi bi-list-check me-2 text-primary"></i> Draft Autosave</h5>
                    <span class="badge bg-primary" id="draftCount">0</span>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Santri</th>
                                <th>Diagnosis</th>
                                <th style="width:180px" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="draftTable">
                            <tr>
                                <td colspan="3" class="text-center text-muted py-4">
                                    <i class="bi bi-inbox"></i> Belum ada data tersimpan
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="p-3 border-top text-end">
                    <form action="{{ route('sakit.saveAll') }}" method="POST">
                        @csrf
                        <button class="btn btn-success" id="btnSaveAll" disabled>
                            <i class="bi bi-check2-all me-1"></i> SIMPAN SEMUA KE DATABASE
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL DETAIL -->
    <div class="modal fade" id="detailModal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="bi bi-file-medical me-2"></i>Detail Draft Sakit Santri</h5>
                    <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="modalContent">
                    <div class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ALERT -->
    <div id="alertBox" style="position: fixed; top: 20px; right: 20px; z-index: 2000; width: 300px;"></div>

    <script>
        const santriList = @json($santri);
        const obatList = @json($obats);
        const form = document.getElementById('formSakit');
        let obatCounter = 0;

        // ⬇️ Alert Function
        function showAlert(message, type = "success") {
            const box = document.getElementById("alertBox");
            const id = "alert-" + Date.now();
            const alert = `
                <div class="alert alert-${type} alert-dismissible fade show shadow-sm" id="${id}">
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;
            box.insertAdjacentHTML("beforeend", alert);
            setTimeout(() => {
                const el = document.getElementById(id);
                if (el) el.remove();
            }, 3500);
        }

        // ⬇️ Add Obat Row
        function addObatRow(data = null) {
            obatCounter++;
            const container = document.getElementById('obatContainer');

            const row = document.createElement('div');
            row.className = 'card mb-2 obat-item';
            row.dataset.id = obatCounter;

            row.innerHTML = `
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="mb-0 fw-bold text-primary">Obat #${obatCounter}</h6>
                        <button type="button" class="btn btn-sm btn-danger" onclick="removeObatRow(${obatCounter})">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                    <div class="row g-2">
                        <div class="col-md-6">
                            <label class="form-label small">Nama Obat</label>
                            <select class="form-select form-select-sm obat-select" name="obat_data[${obatCounter}][obat_id]" required>
                                <option value="">-- Pilih Obat --</option>
                                ${obatList.map(obat => `
                                        <option value="${obat.id}" ${data && data.obat_id == obat.id ? 'selected' : ''}>
                                            ${obat.nama_obat}
                                        </option>
                                    `).join('')}
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small">Jumlah</label>
                            <input type="number" class="form-control form-control-sm"
                                name="obat_data[${obatCounter}][jumlah]"
                                value="${data ? data.jumlah : 1}" min="1" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small">Dosis</label>
                            <input type="text" class="form-control form-control-sm"
                                name="obat_data[${obatCounter}][dosis]"
                                value="${data ? data.dosis : ''}"
                                placeholder="3x sehari">
                        </div>
                        <div class="col-12">
                            <label class="form-label small">Keterangan</label>
                            <textarea class="form-control form-control-sm" rows="2"
                                name="obat_data[${obatCounter}][keterangan]"
                                placeholder="Diminum setelah makan...">${data ? data.keterangan : ''}</textarea>
                        </div>
                    </div>
                </div>
            `;

            container.appendChild(row);
        }

        // ⬇️ Remove Obat Row
        function removeObatRow(id) {
            const item = document.querySelector(`.obat-item[data-id="${id}"]`);
            if (item) item.remove();
        }

        // ⬇️ Collect Obat Data
        function collectObatData() {
            const obatData = [];
            const items = document.querySelectorAll('.obat-item');

            items.forEach(item => {
                const obatId = item.querySelector('.obat-select').value;
                const jumlah = item.querySelector('input[name*="[jumlah]"]').value;
                const dosis = item.querySelector('input[name*="[dosis]"]').value;
                const keterangan = item.querySelector('textarea[name*="[keterangan]"]').value;

                if (obatId) {
                    obatData.push({
                        obat_id: obatId,
                        jumlah: jumlah,
                        dosis: dosis,
                        keterangan: keterangan
                    });
                }
            });

            return obatData;
        }

        // ⬇️ Add to Draft
        function addToTemporary() {
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            const fd = new FormData(form);
            const editId = document.getElementById('edit_id').value;

            // Collect obat data
            const obatData = collectObatData();

            const url = editId ?
                "{{ route('sakit.updateTemporary') }}" :
                "{{ route('sakit.storeTemporary') }}";

            const method = editId ? "PUT" : "POST";

            const data = {
                santri_id: fd.get('santri_id'),
                tanggal_mulai_sakit: fd.get('tanggal_mulai_sakit'),
                diagnosis: fd.get('diagnosis'),
                gejala: fd.get('gejala'),
                tindakan: fd.get('tindakan'),
                resep_obat: fd.get('resep_obat'),
                suhu_tubuh: fd.get('suhu_tubuh'),
                status: fd.get('status'),
                tanggal_selesai_sakit: fd.get('tanggal_selesai_sakit'),
                catatan: fd.get('catatan'),
                obat_data: obatData
            };

            if (editId) data.edit_id = editId;

            fetch(url, {
                    method: method,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value,
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                })
                .then(res => res.json())
                .then(result => {
                    if (result.success) {
                        form.reset();
                        document.getElementById('edit_id').value = '';
                        document.getElementById('obatContainer').innerHTML = '';
                        obatCounter = 0;
                        document.getElementById('btnSubmit').innerHTML =
                            '<i class="bi bi-plus-circle me-1"></i> TAMBAH KE DRAFT';
                        document.getElementById('btnCancel').style.display = 'none';
                        renderDrafts();
                        showAlert(result.message || "Data berhasil disimpan! 🎉", "success");
                    }
                })
                .catch(() => showAlert("Gagal menyimpan data!", "danger"));
        }

        // ⬇️ Render Drafts
        function renderDrafts() {
            fetch("{{ route('sakit.getTemporary') }}")
                .then(res => res.json())
                .then(data => {
                    const table = document.getElementById("draftTable");
                    const countBadge = document.getElementById("draftCount");
                    const btnSaveAll = document.getElementById("btnSaveAll");

                    countBadge.textContent = data.length;
                    btnSaveAll.disabled = data.length === 0;

                    if (!data.length) {
                        table.innerHTML = `
                            <tr><td colspan="3" class="text-center text-muted py-4">
                                <i class='bi bi-inbox'></i> Belum ada data
                            </td></tr>`;
                        return;
                    }

                    table.innerHTML = data.map(item => {
                        const santri = santriList.find(s => s.id == item.santri_id);
                        const statusBadge = item.status === 'sakit' ? 'danger' : (item.status === 'sembuh' ?
                            'success' : 'warning');

                        return `
                            <tr>
                                <td>
                                    <strong>${santri ? santri.nama_lengkap : 'N/A'}</strong><br>
                                    <small class="text-muted">${santri ? santri.nis : ''}</small>
                                </td>
                                <td>
                                    ${item.diagnosis}<br>
                                    <span class="badge bg-${statusBadge}">${item.status}</span>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-info btn-sm" onclick='openDetail(${JSON.stringify(item.id)})' title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button class="btn btn-warning btn-sm" onclick='editDraft(${JSON.stringify(item.id)})' title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn btn-danger btn-sm" onclick='deleteTemp(${JSON.stringify(item.id)})' title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        `;
                    }).join('');
                });
        }

        // ⬇️ Open Detail Modal
        function openDetail(id) {
            const modal = new bootstrap.Modal('#detailModal');
            modal.show();

            fetch(`{{ route('sakit.getTemporary') }}?id=${id}`)
                .then(res => res.json())
                .then(d => {
                    const santri = santriList.find(s => s.id == d.santri_id);
                    const statusBadge = d.status === 'sakit' ? 'danger' : (d.status === 'sembuh' ? 'success' :
                        'warning');

                    let obatHTML = '';
                    if (d.obat_data && d.obat_data.length > 0) {
                        obatHTML =
                            '<h6 class="fw-bold text-primary border-bottom pb-2 mt-4"><i class="bi bi-capsule me-2"></i>Obat yang Digunakan</h6><div class="row g-2">';
                        d.obat_data.forEach((obat, index) => {
                            const obatInfo = obatList.find(o => o.id == obat.obat_id);
                            obatHTML += `
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body p-3">
                                            <h6 class="fw-bold text-primary mb-2">${obatInfo ? obatInfo.nama_obat : 'N/A'}</h6>
                                            <p class="mb-1 small"><strong>Jumlah:</strong> ${obat.jumlah}</p>
                                            <p class="mb-1 small"><strong>Dosis:</strong> ${obat.dosis || '-'}</p>
                                            ${obat.keterangan ? `<p class="mb-0 small text-muted">${obat.keterangan}</p>` : ''}
                                        </div>
                                    </div>
                                </div>
                            `;
                        });
                        obatHTML += '</div>';
                    }

                    document.getElementById("modalContent").innerHTML = `
                        <div class="row g-3">
                            <div class="col-md-6">
                                <h6 class="text-primary fw-bold border-bottom pb-2">
                                    <i class="bi bi-person-badge me-2"></i>Data Santri
                                </h6>
                                <table class="table table-sm table-borderless">
                                    <tr><td width="140"><b>NIS</b></td><td>: ${santri ? santri.nis : 'N/A'}</td></tr>
                                    <tr><td><b>Nama</b></td><td>: ${santri ? santri.nama_lengkap : 'N/A'}</td></tr>
                                    <tr><td><b>Kelas</b></td><td>: ${santri && santri.kelas ? santri.kelas.nama_kelas : 'N/A'}</td></tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-primary fw-bold border-bottom pb-2">
                                    <i class="bi bi-clipboard-pulse me-2"></i>Data Penyakit
                                </h6>
                                <table class="table table-sm table-borderless">
                                    <tr><td width="140"><b>Diagnosis</b></td><td>: ${d.diagnosis}</td></tr>
                                    <tr><td><b>Status</b></td><td>: <span class="badge bg-${statusBadge}">${d.status}</span></td></tr>
                                    <tr><td><b>Tanggal Mulai</b></td><td>: ${d.tanggal_mulai_sakit}</td></tr>
                                    ${d.tanggal_selesai_sakit ? `<tr><td><b>Tanggal Selesai</b></td><td>: ${d.tanggal_selesai_sakit}</td></tr>` : ''}
                                    ${d.suhu_tubuh ? `<tr><td><b>Suhu Tubuh</b></td><td>: ${d.suhu_tubuh}°C</td></tr>` : ''}
                                </table>
                            </div>
                        </div>

                        <h6 class="fw-bold text-primary border-bottom pb-2 mt-3">Detail Lengkap</h6>
                        <div class="mb-3">
                            <strong class="small">Gejala:</strong>
                            <p class="text-muted mb-0">${d.gejala}</p>
                        </div>
                        <div class="mb-3">
                            <strong class="small">Tindakan/Perawatan:</strong>
                            <p class="text-muted mb-0">${d.tindakan}</p>
                        </div>
                        <div class="mb-3">
                            <strong class="small">Resep Obat:</strong>
                            <p class="text-muted mb-0">${d.resep_obat}</p>
                        </div>
                        ${d.catatan ? `
                            <div class="mb-3">
                                <strong class="small">Catatan:</strong>
                                <p class="text-muted mb-0">${d.catatan}</p>
                            </div>` : ''}

                        ${obatHTML}

                        <hr>
                        <div class="d-flex gap-2">
                            <button class="btn btn-warning flex-fill" onclick='editDraft("${d.id}")' data-bs-dismiss="modal">
                                <i class="bi bi-pencil me-1"></i> Edit
                            </button>
                            <button class="btn btn-danger flex-fill" onclick='deleteTemp("${d.id}")'>
                                <i class="bi bi-trash me-1"></i> Hapus
                            </button>
                        </div>
                    `;
                });
        }

        // ⬇️ Edit Draft
        function editDraft(id) {
            fetch(`{{ route('sakit.getTemporary') }}?id=${id}`)
                .then(res => res.json())
                .then(d => {
                    document.getElementById('edit_id').value = d.id;
                    document.getElementById('santri_id').value = d.santri_id;
                    document.getElementById('tanggal_mulai_sakit').value = d.tanggal_mulai_sakit;
                    document.getElementById('diagnosis').value = d.diagnosis;
                    document.getElementById('gejala').value = d.gejala;
                    document.getElementById('tindakan').value = d.tindakan;
                    document.getElementById('resep_obat').value = d.resep_obat;
                    document.getElementById('suhu_tubuh').value = d.suhu_tubuh || '';
                    document.getElementById('status').value = d.status;
                    document.getElementById('tanggal_selesai_sakit').value = d.tanggal_selesai_sakit || '';
                    document.getElementById('catatan').value = d.catatan || '';

                    // Clear and reload obat
                    document.getElementById('obatContainer').innerHTML = '';
                    obatCounter = 0;

                    if (d.obat_data && d.obat_data.length > 0) {
                        d.obat_data.forEach(obat => addObatRow(obat));
                    }

                    document.getElementById('btnSubmit').innerHTML =
                        '<i class="bi bi-check-circle me-1"></i> UPDATE DRAFT';
                    document.getElementById('btnCancel').style.display = 'block';

                    form.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                    showAlert("Mode edit aktif! Ubah data lalu klik UPDATE DRAFT", "info");
                });
        }

        // ⬇️ Cancel Edit
        function cancelEdit() {
            form.reset();
            document.getElementById('edit_id').value = '';
            document.getElementById('obatContainer').innerHTML = '';
            obatCounter = 0;
            document.getElementById('btnSubmit').innerHTML = '<i class="bi bi-plus-circle me-1"></i> TAMBAH KE DRAFT';
            document.getElementById('btnCancel').style.display = 'none';
            showAlert("Mode edit dibatalkan", "secondary");
        }

        // ⬇️ Delete Draft
        function deleteTemp(id) {
            if (!confirm('Yakin ingin menghapus draft ini?')) return;

            fetch("{{ route('sakit.deleteTemporary') }}", {
                    method: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector("input[name=_token]").value,
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        id
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        renderDrafts();
                        const modalEl = document.getElementById('detailModal');
                        const modalInstance = bootstrap.Modal.getInstance(modalEl);
                        if (modalInstance) modalInstance.hide();
                        showAlert("Data berhasil dihapus dari draft 🗑️", "warning");
                    }
                })
                .catch(() => showAlert("Gagal menghapus data!", "danger"));
        }

        document.addEventListener("DOMContentLoaded", renderDrafts);
    </script>
@endsection
