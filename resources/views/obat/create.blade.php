@extends('layouts.master')
@section('content')
<div class="space-y-6">
    <!-- PAGE HEADER -->
    <div>
        <nav class="flex mb-2" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm font-medium text-text-muted hover:text-primary dark:text-gray-400 dark:hover:text-white">
                        Dashboard
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <span class="material-symbols-outlined text-text-muted text-lg mx-1">chevron_right</span>
                        <a href="{{ route('obat.index') }}" class="text-sm font-medium text-text-muted hover:text-primary dark:text-gray-400 dark:hover:text-white">Data Obat</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <span class="material-symbols-outlined text-text-muted text-lg mx-1">chevron_right</span>
                        <span class="text-sm font-medium text-text-main dark:text-gray-200">Tambah Obat</span>
                    </div>
                </li>
            </ol>
        </nav>
        <h1 class="text-3xl font-bold text-text-main dark:text-white">Tambah Data Obat</h1>
        <p class="text-text-muted dark:text-gray-400 mt-1">Semua input masuk ke draft dulu! Bisa tambah banyak tanpa hilang 😎</p>
    </div>

    <div class="grid lg:grid-cols-2 gap-6">
        <!-- LEFT SECTION - FORM INPUT -->
        <div class="bg-surface-light dark:bg-surface-dark rounded-lg shadow-sm p-6">
            <h2 class="text-lg font-bold text-text-main dark:text-white mb-6 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">medication</span>
                Form Input Data
            </h2>

            <form id="formObat">
                @csrf
                <input type="hidden" name="edit_id" id="edit_id">

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Nama Obat</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                <span class="material-symbols-outlined text-lg">medication</span>
                            </span>
                            <input type="text" class="w-full pl-10 pr-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary" placeholder="Contoh: Paracetamol" name="nama_obat" id="nama_obat" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Deskripsi</label>
                        <textarea class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary" rows="3" placeholder="Deskripsi obat, kegunaan, efek samping..." name="deskripsi" id="deskripsi"></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Stok</label>
                            <input type="number" class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary" placeholder="100" min="0" name="stok" id="stok" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Satuan</label>
                            <select class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary" name="satuan" id="satuan" required>
                                <option value="" disabled selected>-- Pilih --</option>
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

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Stok Minimum</label>
                            <input type="number" class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary" placeholder="10" min="0" name="stok_minimum" id="stok_minimum">
                            <p class="text-xs text-text-muted mt-1">Alert jika stok dibawah nilai ini</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Harga Satuan (Rp)</label>
                            <input type="number" class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary" placeholder="5000" min="0" step="100" name="harga_satuan" id="harga_satuan">
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-3 mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <button type="button" onclick="addToTemporary()" class="flex-1 flex items-center justify-center gap-2 px-4 py-2 bg-primary hover:bg-green-600 text-white font-medium rounded-lg transition-colors" id="btnSubmit">
                        <span class="material-symbols-outlined text-lg">add_circle</span>
                        <span>TAMBAH KE DRAFT</span>
                    </button>
                    <button type="button" onclick="cancelEdit()" class="flex-1 flex items-center justify-center gap-2 px-4 py-2 bg-gray-300 dark:bg-gray-700 text-text-main dark:text-white font-medium rounded-lg hover:bg-gray-400 dark:hover:bg-gray-600 transition-colors hidden" id="btnCancel">
                        <span class="material-symbols-outlined text-lg">cancel</span>
                        <span>Batal</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- RIGHT SECTION - DRAFT TABLE -->
        <div class="bg-surface-light dark:bg-surface-dark rounded-lg shadow-sm overflow-hidden flex flex-col">
            <!-- Header -->
            <div class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-gray-800">
                <h2 class="text-lg font-bold text-text-main dark:text-white flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">fact_check</span>
                    Draft Autosave
                </h2>
                <span class="px-3 py-1 bg-primary text-white text-sm font-bold rounded-full" id="draftCount">0</span>
            </div>

            <div class="flex-1 overflow-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-gray-900/50 border-b border-gray-200 dark:border-gray-800 sticky top-0">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-text-main dark:text-gray-300">Nama Obat</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-text-main dark:text-gray-300">Stok</th>
                            <th class="px-6 py-3 text-center text-sm font-semibold text-text-main dark:text-gray-300">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="draftTable" class="divide-y divide-gray-200 dark:divide-gray-800">
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-text-muted dark:text-gray-400">
                                <span class="material-symbols-outlined text-4xl text-gray-300 dark:text-gray-600 block mb-2">inbox</span>
                                Belum ada data tersimpan
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="p-6 border-t border-gray-200 dark:border-gray-800 bg-gray-50 dark:bg-gray-900/50">
                <form action="{{ route('obat.saveAll') }}" method="POST">
                    @csrf
                    <button class="w-full flex items-center justify-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 disabled:bg-gray-400 disabled:cursor-not-allowed text-white font-medium rounded-lg transition-colors" id="btnSaveAll" disabled>
                        <span class="material-symbols-outlined text-lg">check_circle</span>
                        <span>SIMPAN SEMUA KE DATABASE</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- DETAIL MODAL -->
    <div id="detailModal" class="fixed inset-0 bg-black/50 hidden flex items-center justify-center z-50 p-4">
        <div class="bg-surface-light dark:bg-surface-dark rounded-lg shadow-xl max-w-2xl w-full max-h-96 overflow-y-auto">
            <div class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-gray-800 sticky top-0 bg-surface-light dark:bg-surface-dark">
                <h3 class="text-lg font-bold text-text-main dark:text-white flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">info</span>
                    Detail Draft Obat
                </h3>
                <button type="button" onclick="closeDetailModal()" class="p-1 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors">
                    <span class="material-symbols-outlined text-lg">close</span>
                </button>
            </div>
            <div class="p-6" id="modalContent">
                <div class="flex justify-center py-8">
                    <div class="inline-flex items-center gap-2 text-primary">
                        <span class="material-symbols-outlined animate-spin">refresh</span>
                        <span>Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Box -->
    <div id="alertBox" class="fixed top-6 right-6 z-50 max-w-sm space-y-2"></div>

    <script>
        const form = document.getElementById('formObat');

        function showAlert(message, type = "success") {
            const box = document.getElementById("alertBox");
            const id = "alert-" + Date.now();
            const bgClass = {
                'success': 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 border-green-200 dark:border-green-700',
                'danger': 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 border-red-200 dark:border-red-700',
                'question': 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 border-blue-200 dark:border-blue-700', // Info
                'warning': 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300 border-amber-200 dark:border-amber-700',
                'secondary': 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 border-gray-200 dark:border-gray-700'
            }[type] || 'bg-blue-100';

            const icon = {
                'success': 'check_circle',
                'danger': 'error',
                'question': 'info',
                'warning': 'warning',
                'secondary': 'check'
            }[type] || 'info';

            const alert = `
                <div id="${id}" class="p-4 border rounded-lg shadow-sm ${bgClass} flex items-start gap-3 animate-in slide-in-from-top">
                    <span class="material-symbols-outlined flex-shrink-0 mt-0.5">${icon}</span>
                    <p class="flex-1 text-sm font-medium">${message}</p>
                    <button type="button" onclick="document.getElementById('${id}').remove()" class="flex-shrink-0 opacity-70 hover:opacity-100">
                        <span class="material-symbols-outlined text-lg">close</span>
                    </button>
                </div>
            `;
            box.insertAdjacentHTML("beforeend", alert);
            setTimeout(() => {
                const el = document.getElementById(id);
                if (el) el.remove();
            }, 3500);
        }

        function formatRupiah(angka) {
            if (!angka) return 'Rp 0';
            return 'Rp ' + parseInt(angka).toLocaleString('id-ID');
        }

        function addToTemporary() {
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            const fd = new FormData(form);
            const editId = document.getElementById('edit_id').value;
            const url = editId ? "{{ route('obat.updateTemporary') }}" : "{{ route('obat.storeTemporary') }}";
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
                        document.getElementById('btnSubmit').innerHTML = '<span class="material-symbols-outlined text-lg">add_circle</span><span>TAMBAH KE DRAFT</span>';
                        document.getElementById('btnCancel').classList.add('hidden');
                        renderDrafts();
                        showAlert(result.message || "Data berhasil disimpan! 🎉", "success");
                    }
                })
                .catch(() => showAlert("Gagal menyimpan data!", "danger"));
        }

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
                            <tr><td colspan="3" class="px-6 py-8 text-center text-text-muted dark:text-gray-400">
                                <span class="material-symbols-outlined text-4xl text-gray-300 dark:text-gray-600 block mb-2">inbox</span>
                                Belum ada data
                            </td></tr>`;
                        return;
                    }

                    table.innerHTML = data.map(item => {
                        const lowStock = (item.stok_minimum && item.stok <= item.stok_minimum);
                        const stockBadge = lowStock ?
                            '<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800 ml-2">Stok Rendah</span>' : '';

                        return `
                            <tr class="border-b border-gray-200 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-900/50">
                                <td class="px-6 py-4">
                                    <div class="font-medium text-text-main dark:text-white">${item.nama_obat}</div>
                                    <div class="text-xs text-text-muted">${item.satuan}</div>
                                </td>
                                <td class="px-6 py-4 text-text-main dark:text-gray-300">
                                    ${item.stok} ${stockBadge}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <button class="p-2 text-blue-600 dark:text-blue-400 hover:bg-blue-100 dark:hover:bg-blue-900/30 rounded-lg transition-colors" onclick='openDetail(${JSON.stringify(item.id)})'>
                                            <span class="material-symbols-outlined text-lg">visibility</span>
                                        </button>
                                        <button class="p-2 text-amber-600 dark:text-amber-400 hover:bg-amber-100 dark:hover:bg-amber-900/30 rounded-lg transition-colors" onclick='editDraft(${JSON.stringify(item.id)})'>
                                            <span class="material-symbols-outlined text-lg">edit</span>
                                        </button>
                                        <button class="p-2 text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-900/30 rounded-lg transition-colors" onclick='deleteTemp(${JSON.stringify(item.id)})'>
                                            <span class="material-symbols-outlined text-lg">delete</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        `;
                    }).join('');
                });
        }

        function openDetail(id) {
            document.getElementById('detailModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';

            fetch(`{{ route('obat.getTemporary') }}?id=${id}`)
                .then(res => res.json())
                .then(d => {
                    const lowStock = (d.stok_minimum && d.stok <= d.stok_minimum);
                    const stockStatus = lowStock ?
                        '<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">Stok Menipis</span>' :
                        '<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">Stok Aman</span>';

                    document.getElementById("modalContent").innerHTML = `
                         <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <h4 class="text-sm font-bold text-primary border-b border-gray-200 dark:border-gray-700 pb-2">Informasi Obat</h4>
                                <div>
                                    <p class="text-xs font-semibold text-text-muted uppercase tracking-wide">Nama Obat</p>
                                    <p class="text-sm font-medium text-text-main dark:text-white mt-1">${d.nama_obat}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-text-muted uppercase tracking-wide">Satuan</p>
                                    <p class="text-sm font-medium text-text-main dark:text-white mt-1">${d.satuan}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-text-muted uppercase tracking-wide">Stok</p>
                                    <p class="text-sm font-medium text-text-main dark:text-white mt-1">${d.stok} ${d.satuan}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-text-muted uppercase tracking-wide">Status</p>
                                    <div class="mt-1">${stockStatus}</div>
                                </div>
                            </div>
                             <div class="space-y-4">
                                <h4 class="text-sm font-bold text-primary border-b border-gray-200 dark:border-gray-700 pb-2">Detail Lainnya</h4>
                                <div>
                                    <p class="text-xs font-semibold text-text-muted uppercase tracking-wide">Stok Minimum</p>
                                    <p class="text-sm font-medium text-text-main dark:text-white mt-1">${d.stok_minimum || '-'}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-text-muted uppercase tracking-wide">Harga Satuan</p>
                                    <p class="text-sm font-medium text-text-main dark:text-white mt-1">${d.harga_satuan ? formatRupiah(d.harga_satuan) : '-'}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-text-muted uppercase tracking-wide">Total Nilai</p>
                                    <p class="text-sm font-medium text-text-main dark:text-white mt-1">${d.harga_satuan ? formatRupiah(d.stok * d.harga_satuan) : '-'}</p>
                                </div>
                            </div>
                        </div>
                        ${d.deskripsi ? `
                            <div class="mt-6 p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                <h4 class="text-xs font-bold text-primary mb-2">DESKRIPSI</h4>
                                <p class="text-sm text-text-muted dark:text-gray-300">${d.deskripsi}</p>
                            </div>` : ''}

                        <div class="flex gap-3 mt-6 pt-6 border-t border-gray-200 dark:border-gray-800">
                            <button class="flex-1 px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white font-medium rounded-lg flex items-center justify-center gap-2 transition-colors" onclick='editDraft("${d.id}")'>
                                <span class="material-symbols-outlined text-lg">edit</span>
                                <span>Edit</span>
                            </button>
                            <button class="flex-1 px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg flex items-center justify-center gap-2 transition-colors" onclick='deleteTemp("${d.id}")'>
                                <span class="material-symbols-outlined text-lg">delete</span>
                                <span>Hapus</span>
                            </button>
                        </div>
                    `;
                });
        }

        function closeDetailModal() {
            document.getElementById('detailModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

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

                    document.getElementById('btnSubmit').innerHTML = '<span class="material-symbols-outlined text-lg">check_circle</span><span>UPDATE DRAFT</span>';
                    document.getElementById('btnCancel').classList.remove('hidden');

                    closeDetailModal();
                    form.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    showAlert("Mode edit aktif! Ubah data lalu klik UPDATE DRAFT", "info");
                });
        }

        function cancelEdit() {
            form.reset();
            document.getElementById('edit_id').value = '';
            document.getElementById('btnSubmit').innerHTML = '<span class="material-symbols-outlined text-lg">add_circle</span><span>TAMBAH KE DRAFT</span>';
            document.getElementById('btnCancel').classList.add('hidden');
            showAlert("Mode edit dibatalkan", "secondary");
        }

        function deleteTemp(id) {
            if (!confirm('Yakin ingin menghapus draft ini?')) return;

            fetch("{{ route('obat.deleteTemporary') }}", {
                    method: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector("input[name=_token]").value,
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({ id })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        renderDrafts();
                        closeDetailModal();
                        showAlert("Data berhasil dihapus dari draft 🗑️", "warning");
                    }
                })
                .catch(() => showAlert("Gagal menghapus data!", "danger"));
        }

        document.addEventListener("DOMContentLoaded", renderDrafts);
    </script>
</div>
@endsection

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
