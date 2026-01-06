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
                        <a href="{{ route('sakit.index') }}" class="text-sm font-medium text-text-muted hover:text-primary dark:text-gray-400 dark:hover:text-white">Data Sakit</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                         <span class="material-symbols-outlined text-text-muted text-lg mx-1">chevron_right</span>
                        <span class="text-sm font-medium text-text-main dark:text-gray-200">Tambah Data Sakit</span>
                    </div>
                </li>
            </ol>
        </nav>
        <h1 class="text-3xl font-bold text-text-main dark:text-white">Tambah Data Santri Sakit</h1>
        <p class="text-text-muted dark:text-gray-400 mt-1">Semua input masuk ke draft dulu! Bisa tambah banyak tanpa hilang 😎</p>
    </div>

    <div class="grid lg:grid-cols-2 gap-6">
        <!-- LEFT SECTION - FORM INPUT -->
        <div class="bg-surface-light dark:bg-surface-dark rounded-lg shadow-sm p-6">
            <h2 class="text-lg font-bold text-text-main dark:text-white mb-6 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">clinical_notes</span>
                Form Input Data
            </h2>

            <form id="formSakit">
                @csrf
                <input type="hidden" name="edit_id" id="edit_id">

                <div class="space-y-6">
                    <!-- Data Santri Section -->
                    <div>
                        <h3 class="font-bold text-text-main dark:text-white mb-4 flex items-center gap-2">
                             <span class="material-symbols-outlined text-primary text-md">person</span>
                            Data Santri
                        </h3>
                         <div>
                            <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Pilih Santri</label>
                            <select class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary" name="santri_id" id="santri_id" required>
                                <option value="" disabled selected>-- Pilih Santri --</option>
                                @foreach ($santri as $s)
                                    <option value="{{ $s->id }}">{{ $s->nis }} - {{ $s->nama_lengkap }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <hr class="border-gray-200 dark:border-gray-700">

                    <!-- Data Penyakit Section -->
                     <div>
                        <h3 class="font-bold text-text-main dark:text-white mb-4 flex items-center gap-2">
                             <span class="material-symbols-outlined text-primary text-md">stethoscope</span>
                            Data Penyakit
                        </h3>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Tanggal Mulai Sakit</label>
                                <input type="date" class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary" name="tanggal_mulai_sakit" id="tanggal_mulai_sakit" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Diagnosis Penyakit</label>
                                <input type="text" class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary" placeholder="Contoh: Flu, Demam, Diare" name="diagnosis" id="diagnosis" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Gejala yang Dialami</label>
                                <textarea class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary" rows="3" placeholder="Deskripsikan gejala..." name="gejala" id="gejala" required></textarea>
                            </div>

                             <div>
                                <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Tindakan/Perawatan</label>
                                <textarea class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary" rows="3" placeholder="Tindakan medis yang diberikan..." name="tindakan" id="tindakan" required></textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Resep Obat (Deskripsi)</label>
                                <textarea class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary" rows="3" placeholder="Obat yang diberikan..." name="resep_obat" id="resep_obat" required></textarea>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Suhu Tubuh (°C)</label>
                                    <input type="number" class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary" placeholder="38.5" step="0.1" name="suhu_tubuh" id="suhu_tubuh">
                                </div>
                                <div>
                                     <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Status Kondisi</label>
                                    <select class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary" name="status" id="status" required>
                                        <option value="" disabled selected>-- Pilih Status --</option>
                                        <option value="sakit">Masih Sakit</option>
                                        <option value="sembuh">Sembuh</option>
                                        <option value="kontrol">Kontrol</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Tanggal Selesai Sakit (Opsional)</label>
                                <input type="date" class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary" name="tanggal_selesai_sakit" id="tanggal_selesai_sakit">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Catatan Tambahan</label>
                                <textarea class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary" rows="2" placeholder="Catatan lainnya..." name="catatan" id="catatan"></textarea>
                            </div>
                        </div>
                    </div>

                    <hr class="border-gray-200 dark:border-gray-700">

                    <!-- Obat Section -->
                    <div>
                        <h3 class="font-bold text-text-main dark:text-white mb-4 flex items-center gap-2">
                             <span class="material-symbols-outlined text-primary text-md">medication_liquid</span>
                            Obat yang Digunakan
                        </h3>

                        <div id="obatContainer" class="space-y-4 mb-4">
                            <!-- Obat items added here -->
                        </div>

                         <button type="button" class="flex items-center gap-2 px-3 py-1.5 border border-primary text-primary hover:bg-primary/5 rounded-lg text-sm font-medium transition-colors" onclick="addObatRow()">
                            <span class="material-symbols-outlined text-lg">add_circle</span>
                            Tambah Obat
                        </button>
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
                            <th class="px-6 py-3 text-left text-sm font-semibold text-text-main dark:text-gray-300">Santri</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-text-main dark:text-gray-300">Diagnosis</th>
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
                <form action="{{ route('sakit.saveAll') }}" method="POST">
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
        <div class="bg-surface-light dark:bg-surface-dark rounded-lg shadow-xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-gray-800 sticky top-0 bg-surface-light dark:bg-surface-dark z-10">
                <h3 class="text-lg font-bold text-text-main dark:text-white flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">info</span>
                    Detail Draft Sakit
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
        const santriList = @json($santri);
        const obatList = @json($obats);
        const form = document.getElementById('formSakit');
        let obatCounter = 0;

        function showAlert(message, type = "success") {
            const box = document.getElementById("alertBox");
            const id = "alert-" + Date.now();
            const bgClass = {
                'success': 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 border-green-200 dark:border-green-700',
                'danger': 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 border-red-200 dark:border-red-700',
                'question': 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 border-blue-200 dark:border-blue-700',
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

        function addObatRow(data = null) {
            obatCounter++;
            const container = document.getElementById('obatContainer');

            const row = document.createElement('div');
            row.className = 'p-4 border border-gray-200 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-gray-800/50 obat-item';
            row.dataset.id = obatCounter;

            row.innerHTML = `
                <div class="flex justify-between items-center mb-3">
                    <h6 class="text-sm font-bold text-primary">Obat #${obatCounter}</h6>
                    <button type="button" class="text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 p-1 rounded transition-colors" onclick="removeObatRow(${obatCounter})">
                        <span class="material-symbols-outlined text-lg">delete</span>
                    </button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="col-span-1 md:col-span-2">
                        <label class="block text-xs font-medium text-text-muted mb-1">Nama Obat</label>
                        <select class="w-full px-3 py-1.5 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white text-sm focus:outline-none focus:ring-2 focus:ring-primary obat-select" name="obat_data[${obatCounter}][obat_id]" required>
                            <option value="">-- Pilih Obat --</option>
                            ${obatList.map(obat => `
                                <option value="${obat.id}" ${data && data.obat_id == obat.id ? 'selected' : ''}>
                                    ${obat.nama_obat}
                                </option>
                            `).join('')}
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-text-muted mb-1">Jumlah</label>
                        <input type="number" class="w-full px-3 py-1.5 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white text-sm focus:outline-none focus:ring-2 focus:ring-primary"
                            name="obat_data[${obatCounter}][jumlah]"
                            value="${data ? data.jumlah : 1}" min="1" required>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-text-muted mb-1">Dosis</label>
                        <input type="text" class="w-full px-3 py-1.5 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white text-sm focus:outline-none focus:ring-2 focus:ring-primary"
                            name="obat_data[${obatCounter}][dosis]"
                            value="${data ? data.dosis : ''}"
                            placeholder="3x sehari">
                    </div>
                    <div class="col-span-1 md:col-span-2">
                        <label class="block text-xs font-medium text-text-muted mb-1">Keterangan</label>
                        <textarea class="w-full px-3 py-1.5 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white text-sm focus:outline-none focus:ring-2 focus:ring-primary" rows="2"
                            name="obat_data[${obatCounter}][keterangan]"
                            placeholder="Diminum setelah makan...">${data ? data.keterangan : ''}</textarea>
                    </div>
                </div>
            `;
            container.appendChild(row);
        }

        function removeObatRow(id) {
            const item = document.querySelector(`.obat-item[data-id="${id}"]`);
            if (item) item.remove();
        }

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

        function addToTemporary() {
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            const fd = new FormData(form);
            const editId = document.getElementById('edit_id').value;
            const obatData = collectObatData();
            const url = editId ? "{{ route('sakit.updateTemporary') }}" : "{{ route('sakit.storeTemporary') }}";
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
                        document.getElementById('btnSubmit').innerHTML = '<span class="material-symbols-outlined text-lg">add_circle</span><span>TAMBAH KE DRAFT</span>';
                        document.getElementById('btnCancel').classList.add('hidden');
                        renderDrafts();
                        showAlert(result.message || "Data berhasil disimpan! 🎉", "success");
                    }
                })
                .catch(() => showAlert("Gagal menyimpan data!", "danger"));
        }

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
                            <tr><td colspan="3" class="px-6 py-8 text-center text-text-muted dark:text-gray-400">
                                <span class="material-symbols-outlined text-4xl text-gray-300 dark:text-gray-600 block mb-2">inbox</span>
                                Belum ada data
                            </td></tr>`;
                        return;
                    }

                    table.innerHTML = data.map(item => {
                        const santri = santriList.find(s => s.id == item.santri_id);
                        const statusColor = item.status === 'sakit' ? 'red' : (item.status === 'sembuh' ? 'green' : 'amber');
                        const statusBadge = `<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-${statusColor}-100 text-${statusColor}-800 capitalize">${item.status}</span>`;

                        return `
                             <tr class="border-b border-gray-200 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-900/50">
                                <td class="px-6 py-4">
                                     <div class="font-medium text-text-main dark:text-white">${santri ? santri.nama_lengkap : 'N/A'}</div>
                                    <div class="text-xs text-text-muted">${santri ? santri.nis : ''}</div>
                                </td>
                                <td class="px-6 py-4 text-text-main dark:text-gray-300">
                                    <div class="mb-1">${item.diagnosis}</div>
                                    ${statusBadge}
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

            fetch(`{{ route('sakit.getTemporary') }}?id=${id}`)
                .then(res => res.json())
                 .then(d => {
                    const santri = santriList.find(s => s.id == d.santri_id);
                     const statusColor = d.status === 'sakit' ? 'red' : (d.status === 'sembuh' ? 'green' : 'amber');
                    const statusBadge = `<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-${statusColor}-100 text-${statusColor}-800 capitalize">${d.status}</span>`;

                    let obatHTML = '';
                    if (d.obat_data && d.obat_data.length > 0) {
                        obatHTML = '<h6 class="text-sm font-bold text-primary mt-6 mb-3 border-b border-gray-200 dark:border-gray-700 pb-2">Obat yang Digunakan</h6><div class="grid grid-cols-1 md:grid-cols-2 gap-4">';
                        d.obat_data.forEach(obat => {
                            const obatInfo = obatList.find(o => o.id == obat.obat_id);
                            obatHTML += `
                                <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-3">
                                    <h6 class="font-bold text-text-main dark:text-white mb-2">${obatInfo ? obatInfo.nama_obat : 'N/A'}</h6>
                                    <div class="space-y-1 text-sm text-text-muted dark:text-gray-400">
                                         <p><span class="font-medium">Jumlah:</span> ${obat.jumlah}</p>
                                         <p><span class="font-medium">Dosis:</span> ${obat.dosis || '-'}</p>
                                         ${obat.keterangan ? `<p class="italic text-xs mt-1">"${obat.keterangan}"</p>` : ''}
                                    </div>
                                </div>
                            `;
                        });
                        obatHTML += '</div>';
                    }

                     document.getElementById("modalContent").innerHTML = `
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <h4 class="text-sm font-bold text-primary border-b border-gray-200 dark:border-gray-700 pb-2">Data Santri</h4>
                                <div>
                                    <p class="text-xs font-semibold text-text-muted uppercase tracking-wide">NIS</p>
                                    <p class="text-sm font-medium text-text-main dark:text-white mt-1">${santri ? santri.nis : 'N/A'}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-text-muted uppercase tracking-wide">Nama</p>
                                    <p class="text-sm font-medium text-text-main dark:text-white mt-1">${santri ? santri.nama_lengkap : 'N/A'}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-text-muted uppercase tracking-wide">Kelas</p>
                                    <p class="text-sm font-medium text-text-main dark:text-white mt-1">${santri && santri.kelas ? santri.kelas.nama_kelas : 'N/A'}</p>
                                </div>
                            </div>
                             <div class="space-y-4">
                                <h4 class="text-sm font-bold text-primary border-b border-gray-200 dark:border-gray-700 pb-2">Data Penyakit</h4>
                                <div>
                                    <p class="text-xs font-semibold text-text-muted uppercase tracking-wide">Diagnosis</p>
                                    <p class="text-sm font-medium text-text-main dark:text-white mt-1">${d.diagnosis}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-text-muted uppercase tracking-wide">Status</p>
                                    <div class="mt-1">${statusBadge}</div>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-text-muted uppercase tracking-wide">Tanggal Mulai</p>
                                    <p class="text-sm font-medium text-text-main dark:text-white mt-1">${d.tanggal_mulai_sakit}</p>
                                </div>
                            </div>
                        </div>

                         <div class="mt-6 space-y-4">
                             <div>
                                <p class="text-xs font-semibold text-text-muted uppercase tracking-wide">Gejala</p>
                                <p class="text-sm text-text-main dark:text-white mt-1">${d.gejala}</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-text-muted uppercase tracking-wide">Tindakan</p>
                                <p class="text-sm text-text-main dark:text-white mt-1">${d.tindakan}</p>
                            </div>
                             <div>
                                <p class="text-xs font-semibold text-text-muted uppercase tracking-wide">Resep (Deskripsi)</p>
                                <p class="text-sm text-text-main dark:text-white mt-1">${d.resep_obat}</p>
                            </div>
                        </div>

                        ${obatHTML}

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

                    document.getElementById('obatContainer').innerHTML = '';
                    obatCounter = 0;
                    if (d.obat_data && d.obat_data.length > 0) {
                        d.obat_data.forEach(obat => addObatRow(obat));
                    }

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
            document.getElementById('obatContainer').innerHTML = '';
            obatCounter = 0;
             document.getElementById('btnSubmit').innerHTML = '<span class="material-symbols-outlined text-lg">add_circle</span><span>TAMBAH KE DRAFT</span>';
            document.getElementById('btnCancel').classList.add('hidden');
            showAlert("Mode edit dibatalkan", "secondary");
        }

        function deleteTemp(id) {
             if (!confirm('Yakin ingin menghapus draft ini?')) return;

             fetch("{{ route('sakit.deleteTemporary') }}", {
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
