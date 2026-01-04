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
                    <a href="{{ route('obat.index') }}" class="text-decoration-none">Data Obat</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Tambah Obat</li>
            </ol>
        </nav>

        <h4 class="fw-bold mb-0">Tambah Data Obat</h4>
        <small class="text-muted">Semua input masuk ke draft dulu! Bisa tambah banyak tanpa hilang 😎</small>
    </div>

    <div class="row g-4">
        <!-- LEFT SECTION - FORM INPUT -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="fw-bold mb-4">
                        <i class="bi bi-capsule-pill me-2 text-primary"></i> Form Input Data
                    </h5>

                    <form id="formObat">
                        @csrf
                        <input type="hidden" name="edit_id" id="edit_id">

                        <div class="mb-3">
                            <label class="form-label">Nama Obat</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-capsule-pill"></i></span>
                                <input type="text" class="form-control" id="nama_obat" name="nama_obat"
                                    placeholder="Contoh: Paracetamol" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"
                                placeholder="Deskripsi obat, kegunaan, efek samping..."></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Stok</label>
                                    <input type="number" class="form-control" id="stok" name="stok"
                                        placeholder="100" min="0" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Satuan</label>
                                    <select class="form-select" id="satuan" name="satuan" required>
                                        <option value="" disabled selected>-- Pilih Satuan --</option>
                                        <option value="Tablet">Tablet</option>
                                        <option value="Kapsul">Kapsul</option>
                                        <option value="Botol">Botol</option>
                                        <option value="Strip">Strip</option>
                                        <option value="Box">Box</option>
                                        <option value="Pcs">Pcs</option>
                                        <option value="Ampul">Ampul</option>
                                        <option value="Tube">Tube</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Stok Minimum</label>
                                    <input type="number" class="form-control" id="stok_minimum" name="stok_minimum"
                                        placeholder="10" min="0">
                                    <small class="text-muted">Alert jika stok dibawah nilai ini</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Harga Satuan (Rp)</label>
                                    <input type="number" class="form-control" id="harga_satuan" name="harga_satuan"
                                        placeholder="5000" min="0" step="100">
                                </div>
                            </div>
                        </div>

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
                                <th>Nama Obat</th>
                                <th>Stok</th>
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
                    <form action="{{ route('obat.saveAll') }}" method="POST">
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
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="bi bi-capsule me-2"></i>Detail Draft Obat</h5>
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
        const form = document.getElementById('formObat');

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

        // ⬇️ Format Rupiah
        function formatRupiah(angka) {
            if (!angka) return 'Rp 0';
            return 'Rp ' + parseInt(angka).toLocaleString('id-ID');
        }

        // ⬇️ Add to Draft
        function addToTemporary() {
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            const fd = new FormData(form);
            const editId = document.getElementById('edit_id').value;

            const url = editId ?
                "{{ route('obat.updateTemporary') }}" :
                "{{ route('obat.storeTemporary') }}";

            const method = editId ? "PUT" : "POST";

            const data = {};
            fd.forEach((value, key) => data[key] = value);
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
            fetch("{{ route('obat.getTemporary') }}")
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
                        const stockBadge = (item.stok_minimum && item.stok <= item.stok_minimum) ?
                            '<span class="badge bg-danger ms-1">Stok Rendah</span>' :
                            '';

                        return `
                            <tr>
                                <td>
                                    <strong>${item.nama_obat}</strong><br>
                                    <small class="text-muted">${item.satuan}</small>
                                </td>
                                <td>
                                    ${item.stok} ${stockBadge}
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

            fetch(`{{ route('obat.getTemporary') }}?id=${id}`)
                .then(res => res.json())
                .then(d => {
                    const stockStatus = (d.stok_minimum && d.stok <= d.stok_minimum) ?
                        '<span class="badge bg-danger">Stok Menipis</span>' :
                        '<span class="badge bg-success">Stok Aman</span>';

                    document.getElementById("modalContent").innerHTML = `
                        <div class="row g-3">
                            <div class="col-md-6">
                                <h6 class="text-primary fw-bold border-bottom pb-2">
                                    <i class="bi bi-info-circle me-2"></i>Informasi Obat
                                </h6>
                                <table class="table table-sm table-borderless">
                                    <tr><td width="140"><b>Nama Obat</b></td><td>: ${d.nama_obat}</td></tr>
                                    <tr><td><b>Satuan</b></td><td>: ${d.satuan}</td></tr>
                                    <tr><td><b>Stok</b></td><td>: ${d.stok} ${d.satuan}</td></tr>
                                    <tr><td><b>Status Stok</b></td><td>: ${stockStatus}</td></tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-primary fw-bold border-bottom pb-2">
                                    <i class="bi bi-cash me-2"></i>Detail Lainnya
                                </h6>
                                <table class="table table-sm table-borderless">
                                    <tr><td width="140"><b>Stok Minimum</b></td><td>: ${d.stok_minimum || '-'}</td></tr>
                                    <tr><td><b>Harga Satuan</b></td><td>: ${d.harga_satuan ? formatRupiah(d.harga_satuan) : '-'}</td></tr>
                                    <tr><td><b>Total Nilai</b></td><td>: ${d.harga_satuan ? formatRupiah(d.stok * d.harga_satuan) : '-'}</td></tr>
                                </table>
                            </div>
                        </div>

                        ${d.deskripsi ? `
                            <div class="mt-3">
                                <h6 class="fw-bold text-primary border-bottom pb-2">Deskripsi</h6>
                                <p class="text-muted">${d.deskripsi}</p>
                            </div>` : ''}

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
            fetch(`{{ route('obat.getTemporary') }}?id=${id}`)
                .then(res => res.json())
                .then(d => {
                    document.getElementById('edit_id').value = d.id;
                    document.getElementById('nama_obat').value = d.nama_obat;
                    document.getElementById('deskripsi').value = d.deskripsi || '';
                    document.getElementById('stok').value = d.stok;
                    document.getElementById('satuan').value = d.satuan;
                    document.getElementById('stok_minimum').value = d.stok_minimum || '';
                    document.getElementById('harga_satuan').value = d.harga_satuan || '';

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
            document.getElementById('btnSubmit').innerHTML = '<i class="bi bi-plus-circle me-1"></i> TAMBAH KE DRAFT';
            document.getElementById('btnCancel').style.display = 'none';
            showAlert("Mode edit dibatalkan", "secondary");
        }

        // ⬇️ Delete Draft
        function deleteTemp(id) {
            if (!confirm('Yakin ingin menghapus draft ini?')) return;

            fetch("{{ route('obat.deleteTemporary') }}", {
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
