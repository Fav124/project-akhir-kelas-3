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
                                <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Diagnosis Penyakit (Tags)</label>
                                <div id="diagnosisTagInput" class="w-full p-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus-within:ring-2 focus-within:ring-primary min-h-[42px] flex flex-wrap gap-2 items-center">
                                    <!-- Tags will be rendered here -->
                                    <input type="text" id="tagInput" class="flex-1 bg-transparent border-none outline-none text-sm min-w-[120px]" placeholder="Ketik & tekan Enter untuk tambah tag...">
                                </div>
                                <div id="tagSuggestions" class="absolute z-50 mt-1 w-full max-w-md bg-surface-light dark:bg-surface-dark border border-gray-200 dark:border-gray-800 rounded-lg shadow-xl hidden overflow-hidden">
                                     <!-- Suggestions will be rendered here -->
                                </div>
                                <p class="text-xs text-text-muted mt-1 italic">Ketik diagnosis (misal: Demam) lalu tekan Enter. Anda bisa menambah lebih dari satu tag.</p>
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
    /* =========================
       TAG INPUT FOR DIAGNOSIS
    ========================= */
    class TagInput {
        constructor(containerId, inputId, suggestionsId) {
            this.container = document.getElementById(containerId);
            this.input = document.getElementById(inputId);
            this.suggestions = document.getElementById(suggestionsId);
            this.tags = [];
            this.init();
        }

        init() {
            this.input.addEventListener('keydown', (e) => {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    const val = this.input.value.trim();
                    if (val) this.addTag(val);
                } else if (e.key === 'Backspace' && !this.input.value && this.tags.length > 0) {
                    this.removeTag(this.tags.length - 1);
                }
            });

            this.input.addEventListener('input', () => {
                const val = this.input.value.trim();
                if (val.length >= 2) {
                    this.fetchSuggestions(val);
                } else {
                    this.hideSuggestions();
                }
            });

            // Prevent closing when clicking inside
            this.container.addEventListener('click', () => this.input.focus());
            document.addEventListener('click', (e) => {
                if (!this.container.contains(e.target) && !this.suggestions.contains(e.target)) {
                    this.hideSuggestions();
                }
            });
        }

        async fetchSuggestions(q) {
            try {
                const res = await fetch(`{{ route('diagnosis.search') }}?q=${q}`);
                const data = await res.json();
                this.renderSuggestions(data);
            } catch (e) {
                console.error("Failed to fetch suggestions", e);
            }
        }

        renderSuggestions(items) {
            if (!items.length) {
                this.hideSuggestions();
                return;
            }

            this.suggestions.innerHTML = items.map(item => `
                <div class="px-4 py-2 hover:bg-primary/10 cursor-pointer text-sm font-medium border-b border-gray-100 dark:border-gray-800 last:border-0" data-nama="${item.nama}">
                    ${item.nama}
                </div>
            `).join('');

            this.suggestions.querySelectorAll('div').forEach(div => {
                div.addEventListener('click', () => {
                    this.addTag(div.dataset.nama);
                    this.hideSuggestions();
                });
            });

            this.suggestions.classList.remove('hidden');
        }

        hideSuggestions() {
            this.suggestions.classList.add('hidden');
        }

        addTag(val) {
            if (this.tags.includes(val)) {
                this.input.value = '';
                return;
            }
            this.tags.push(val);
            this.render();
            this.input.value = '';
        }

        removeTag(index) {
            this.tags.splice(index, 1);
            this.render();
        }

        render() {
            // Keep input at the end
            const input = this.input;
            this.container.innerHTML = '';
            this.tags.forEach((tag, index) => {
                const badge = document.createElement('span');
                badge.className = 'inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-primary/10 text-primary text-xs font-bold border border-primary/20';
                badge.innerHTML = `
                    ${tag}
                    <button type="button" class="hover:text-red-500 flex items-center" onclick="diagnosisTags.removeTag(${index})">
                        <span class="material-symbols-outlined text-[14px]">close</span>
                    </button>
                `;
                this.container.appendChild(badge);
            });
            this.container.appendChild(input);
            input.focus();
        }

        setTags(tags) {
            this.tags = tags || [];
            this.render();
        }

        getTags() {
            return this.tags;
        }

        clear() {
            this.tags = [];
            this.render();
        }
    }

    let diagnosisTags = null;
    const santriList = @json($santri);
    const obatList = @json($obats);
    const form = document.getElementById('formSakit');
    let obatCounter = 0;
    let santriSelect = null;

    /* =========================
       CUSTOM SEARCHABLE SELECT
    ========================= */
    class SearchableSelect {
        constructor(selectElement, options = {}) {
            this.select = selectElement;
            this.options = options;
            this.placeholder = options.placeholder || 'Cari...';
            this.container = null;
            this.searchInput = null;
            this.dropdown = null;
            this.itemsContainer = null;
            this.isOpen = false;
            this.selectedValue = this.select.value;
            this.selectedLabel = '';

            const activeOption = this.select.options[this.select.selectedIndex];
            if (activeOption && activeOption.value !== "") {
                this.selectedLabel = activeOption.text;
            }

            this.init();
        }

        init() {
            this.select.classList.add('hidden');

            this.container = document.createElement('div');
            this.container.className = 'relative custom-searchable-select';
            this.select.parentNode.insertBefore(this.container, this.select.nextSibling);

            this.display = document.createElement('div');
            this.display.className = 'w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary cursor-pointer flex justify-between items-center';
            this.updateDisplayText();
            this.container.appendChild(this.display);

            this.dropdown = document.createElement('div');
            this.dropdown.className = 'absolute z-[60] mt-1 w-full bg-surface-light dark:bg-surface-dark border border-gray-200 dark:border-gray-800 rounded-lg shadow-xl hidden overflow-hidden flex flex-col max-h-72';

            const searchWrapper = document.createElement('div');
            searchWrapper.className = 'p-2 border-b border-gray-100 dark:border-gray-700 sticky top-0 bg-surface-light dark:bg-surface-dark';
            this.searchInput = document.createElement('input');
            this.searchInput.type = 'text';
            this.searchInput.placeholder = this.placeholder;
            this.searchInput.className = 'w-full px-3 py-1.5 text-sm border border-gray-100 dark:border-gray-700 rounded-md bg-gray-50 dark:bg-gray-800 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary';
            searchWrapper.appendChild(this.searchInput);
            this.dropdown.appendChild(searchWrapper);

            this.itemsContainer = document.createElement('div');
            this.itemsContainer.className = 'overflow-y-auto flex-1';
            this.dropdown.appendChild(this.itemsContainer);

            this.container.appendChild(this.dropdown);

            this.display.addEventListener('click', (e) => {
                e.stopPropagation();
                this.toggle();
            });

            this.searchInput.addEventListener('input', (e) => {
                this.filter(e.target.value);
            });

            this.searchInput.addEventListener('click', (e) => e.stopPropagation());
            document.addEventListener('click', () => this.close());

            this.renderItems();
        }

        updateDisplayText() {
            this.display.innerHTML = `
                <span class="${this.selectedValue ? '' : 'text-text-muted'} truncate">
                    ${this.selectedLabel || (this.options.emptyText || '-- Pilih --')}
                </span>
                <span class="material-symbols-outlined text-gray-400">expand_more</span>
            `;
        }

        renderItems(filterText = '') {
            this.itemsContainer.innerHTML = '';
            const options = Array.from(this.select.options).filter(opt => opt.value !== "");

            let found = false;
            options.forEach(opt => {
                if (opt.text.toLowerCase().includes(filterText.toLowerCase())) {
                    const item = document.createElement('div');
                    item.className = `px-4 py-2.5 text-sm cursor-pointer hover:bg-primary/10 transition-colors 
                        ${this.selectedValue == opt.value ? 'bg-primary/5 font-bold text-primary' : 'text-text-main dark:text-gray-300'}`;
                    item.textContent = opt.text;
                    item.addEventListener('click', (e) => {
                        e.stopPropagation();
                        this.selectItem(opt.value, opt.text);
                    });
                    this.itemsContainer.appendChild(item);
                    found = true;
                }
            });

            if (!found) {
                const empty = document.createElement('div');
                empty.className = 'px-4 py-8 text-center text-xs text-text-muted italic';
                empty.textContent = 'Data tidak ditemukan';
                this.itemsContainer.appendChild(empty);
            }
        }

        selectItem(value, label) {
            this.selectedValue = value;
            this.selectedLabel = label;
            this.select.value = value;
            this.select.dispatchEvent(new Event('change', { bubbles: true }));
            this.updateDisplayText();
            this.close();
        }

        filter(text) {
            this.renderItems(text);
        }

        toggle() {
            if (this.isOpen) this.close();
            else this.open();
        }

        open() {
            document.querySelectorAll('.custom-searchable-select .absolute').forEach(d => d.classList.add('hidden'));
            this.dropdown.classList.remove('hidden');
            this.isOpen = true;
            this.searchInput.value = '';
            this.renderItems();
            setTimeout(() => this.searchInput.focus(), 50);
        }

        close() {
            this.dropdown.classList.add('hidden');
            this.isOpen = false;
        }

        setValue(value) {
            this.select.value = value;
            const opt = Array.from(this.select.options).find(o => o.value == value);
            if (opt) {
                this.selectedValue = value;
                this.selectedLabel = opt.text;
            } else {
                this.selectedValue = '';
                this.selectedLabel = '';
            }
            this.updateDisplayText();
        }
    }

    /* =========================
       ALERT
    ========================= */
    function showAlert(message, type = "success") {
        const box = document.getElementById("alertBox");
        const id = "alert-" + Date.now();
        const bgClass = {
            'success': 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 border-green-200 dark:border-green-700',
            'danger': 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 border-red-200 dark:border-red-700',
            'question': 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 border-blue-200 dark:border-blue-700',
            'warning': 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300 border-amber-200 dark:border-amber-700',
            'secondary': 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 border-gray-200 dark:border-gray-700',
            'info': 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 border-blue-200 dark:border-blue-700'
        }[type] || 'bg-blue-100';

        const icon = {
            'success': 'check_circle',
            'danger': 'error',
            'question': 'info',
            'warning': 'warning',
            'secondary': 'check',
            'info': 'info'
        }[type] || 'info';

        const alert = `
            <div id="${id}" class="p-4 border rounded-lg shadow-sm ${bgClass} flex items-start gap-3">
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

    /* =========================
       OBAT HANDLER
    ========================= */
    function addObatRow(data = null) {
        obatCounter++;
        const container = document.getElementById('obatContainer');

        const row = document.createElement('div');
        row.className = 'p-4 border border-gray-200 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-gray-800/50 obat-item';
        row.dataset.id = obatCounter;

        row.innerHTML = `
            <div class="flex justify-between items-center mb-3">
                <h6 class="text-sm font-bold text-primary">Obat #${obatCounter}</h6>
                <button type="button" class="text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 p-1 rounded" onclick="removeObatRow(${obatCounter})">
                    <span class="material-symbols-outlined text-lg">delete</span>
                </button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-xs font-medium text-text-muted mb-1">Nama Obat</label>
                    <select class="w-full px-3 py-1.5 border rounded-lg obat-select" name="obat_data[${obatCounter}][obat_id]" required>
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
                    <input type="number" class="w-full px-3 py-1.5 border rounded-lg" name="obat_data[${obatCounter}][jumlah]" value="${data ? data.jumlah : 1}" min="1" required>
                </div>
                <div>
                    <label class="block text-xs font-medium text-text-muted mb-1">Dosis</label>
                    <input type="text" class="w-full px-3 py-1.5 border rounded-lg" name="obat_data[${obatCounter}][dosis]" value="${data ? data.dosis : ''}">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-medium text-text-muted mb-1">Keterangan</label>
                    <textarea class="w-full px-3 py-1.5 border rounded-lg" rows="2" name="obat_data[${obatCounter}][keterangan]">${data ? data.keterangan : ''}</textarea>
                </div>
            </div>
        `;
        container.appendChild(row);

        const select = row.querySelector('.obat-select');
        new SearchableSelect(select, {
            placeholder: 'Cari obat...',
            emptyText: '-- Pilih Obat --'
        });
    }

    function removeObatRow(id) {
        const item = document.querySelector(`.obat-item[data-id="${id}"]`);
        if (item) item.remove();
    }

    function collectObatData() {
        const obatData = [];
        document.querySelectorAll('.obat-item').forEach(item => {
            const obatId = item.querySelector('.obat-select').value;
            if (obatId) {
                obatData.push({
                    obat_id: obatId,
                    jumlah: item.querySelector('input[name*="[jumlah]"]').value,
                    dosis: item.querySelector('input[name*="[dosis]"]').value,
                    keterangan: item.querySelector('textarea[name*="[keterangan]"]').value
                });
            }
        });
        return obatData;
    }

    /* =========================
       SUBMIT TEMPORARY
    ========================= */
    function addToTemporary() {
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        const fd = new FormData(form);
        const editId = document.getElementById('edit_id').value;
        const obatData = collectObatData();
        const diagnoses = diagnosisTags.getTags();

        if (diagnoses.length === 0) {
            showAlert("Minimal harus ada satu diagnosis penyakit!", "warning");
            return;
        }

        const url = editId ? "{{ route('sakit.updateTemporary') }}" : "{{ route('sakit.storeTemporary') }}";

        const data = {
            santri_id: fd.get('santri_id'),
            tanggal_mulai_sakit: fd.get('tanggal_mulai_sakit'),
            gejala: fd.get('gejala'),
            tindakan: fd.get('tindakan'),
            resep_obat: fd.get('resep_obat'),
            suhu_tubuh: fd.get('suhu_tubuh'),
            status: fd.get('status'),
            tanggal_selesai_sakit: fd.get('tanggal_selesai_sakit'),
            catatan: fd.get('catatan'),
            obat_data: obatData,
            diagnoses: diagnoses
        };

        if (editId) {
            data.edit_id = editId;
            data._method = "PUT";
        }

        fetch(url, {
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(res => res.json())
        .then(result => {
            if (result.success) {
                resetForm();
                renderDrafts();
                showAlert(result.message || "Data berhasil disimpan! 🎉", "success");
            }
        })
        .catch(() => showAlert("Gagal menyimpan data!", "danger"));
    }

    function resetForm() {
        form.reset();
        document.getElementById('edit_id').value = '';
        document.getElementById('obatContainer').innerHTML = '';
        obatCounter = 0;
        if (santriSelect) santriSelect.setValue('');
        if (diagnosisTags) diagnosisTags.clear();
        
        document.getElementById('btnSubmit').innerHTML = '<span class="material-symbols-outlined text-lg">add_circle</span><span>TAMBAH KE DRAFT</span>';
        document.getElementById('btnCancel').classList.add('hidden');
    }

    /* =========================
       DRAFT LIST
    ========================= */
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
                        <tr><td colspan="3" class="px-6 py-8 text-center text-text-muted">
                            Belum ada data
                        </td></tr>`;
                    return;
                }

                table.innerHTML = data.map(item => {
                    const santri = santriList.find(s => s.id == item.santri_id);
                    const diagText = (item.diagnoses || []).join(', ') || 'N/A';

                    let statusClass = 'bg-amber-100 text-amber-800';
                    if (item.status === 'sakit') statusClass = 'bg-red-100 text-red-800';
                    else if (item.status === 'sembuh') statusClass = 'bg-green-100 text-green-800';

                    const statusBadge = `<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium ${statusClass} capitalize">${item.status}</span>`;

                    return `
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="font-medium">${santri ? santri.nama_lengkap : 'N/A'}</div>
                                <div class="text-xs text-gray-500">${santri ? santri.nis : ''}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="mb-1 truncate max-w-[200px]" title="${diagText}">${diagText}</div>
                                ${statusBadge}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center gap-2">
                                    <button onclick="openDetail('${item.id}')" class="text-blue-600">👁</button>
                                    <button onclick="editDraft('${item.id}')" class="text-amber-600">✏️</button>
                                    <button onclick="deleteTemp('${item.id}')" class="text-red-600">🗑</button>
                                </div>
                            </td>
                        </tr>
                    `;
                }).join('');
            });
    }

    function editDraft(id) {
        fetch(`{{ route('sakit.getTemporary') }}?id=${id}`)
            .then(res => res.json())
            .then(d => {
                document.getElementById('edit_id').value = d.id;
                
                if (santriSelect) santriSelect.setValue(d.santri_id);
                if (diagnosisTags) diagnosisTags.setTags(d.diagnoses);
                
                document.getElementById('tanggal_mulai_sakit').value = d.tanggal_mulai_sakit;
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

                if (typeof closeDetailModal === 'function') closeDetailModal();
                form.scrollIntoView({ behavior: 'smooth', block: 'start' });
                showAlert("Mode edit aktif!", "info");
            });
    }

    function cancelEdit() {
        resetForm();
        showAlert("Mode edit dibatalkan", "secondary");
    }

    function deleteTemp(id) {
        if (!confirm('Yakin ingin menghapus draft ini?')) return;

        fetch("{{ route('sakit.deleteTemporary') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector("input[name=_token]").value,
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ id, _method: "DELETE" })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                renderDrafts();
                showAlert("Data berhasil dihapus 🗑️", "warning");
            }
        })
        .catch(() => showAlert("Gagal menghapus data!", "danger"));
    }

    document.addEventListener("DOMContentLoaded", () => {
        renderDrafts();
        
        // Initialize Santri Search
        const sSelect = document.getElementById('santri_id');
        if (sSelect) {
            santriSelect = new SearchableSelect(sSelect, {
                placeholder: 'Cari santri...',
                emptyText: '-- Pilih Santri --'
            });
        }

        // Initialize Diagnosis Tags
        diagnosisTags = new TagInput('diagnosisTagInput', 'tagInput', 'tagSuggestions');
    });
</script>

</div>
@endsection
