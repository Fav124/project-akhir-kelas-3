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
                        <span class="text-sm font-medium text-text-main dark:text-gray-200">Edit Data</span>
                    </div>
                </li>
            </ol>
        </nav>
        <h1 class="text-3xl font-bold text-text-main dark:text-white">Edit Data Sakit</h1>
        <p class="text-text-muted dark:text-gray-400 mt-1">Perbarui data riwayat sakit santri.</p>
    </div>

    <div class="bg-surface-light dark:bg-surface-dark rounded-lg shadow-sm p-6">
        <form method="POST" action="{{ route('sakit.update', $sakit->id) }}">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <!-- Data Santri Readonly -->
                <div>
                     <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Santri</label>
                    <div class="p-3 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                        <p class="font-bold text-text-main dark:text-white">{{ $sakit->santri->nama_lengkap }}</p>
                        <p class="text-sm text-text-muted">NIS: {{ $sakit->santri->nis }}</p>
                        <input type="hidden" name="santri_id" value="{{ $sakit->santri_id }}">
                    </div>
                </div>

                <hr class="border-gray-200 dark:border-gray-700">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Tanggal Mulai Sakit</label>
                        <input type="date" class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary @error('tanggal_mulai_sakit') border-red-500 @enderror" 
                               name="tanggal_mulai_sakit" value="{{ old('tanggal_mulai_sakit', $sakit->tanggal_mulai_sakit) }}" required>
                        @error('tanggal_mulai_sakit')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Status Kondisi</label>
                        <div class="relative">
                            <select class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary appearance-none" 
                                    name="status" required>
                                <option value="sakit" {{ old('status', $sakit->status) == 'sakit' ? 'selected' : '' }}>Masih Sakit</option>
                                <option value="sembuh" {{ old('status', $sakit->status) == 'sembuh' ? 'selected' : '' }}>Sembuh</option>
                                <option value="kontrol" {{ old('status', $sakit->status) == 'kontrol' ? 'selected' : '' }}>Kontrol</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-text-muted">
                                <span class="material-symbols-outlined text-lg">expand_more</span>
                            </div>
                        </div>
                    </div>

                    <div class="md:col-span-2">
                         <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Diagnosis (Tags)</label>
                         <div id="diagnosisTagInput" class="w-full p-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus-within:ring-2 focus-within:ring-primary min-h-[42px] flex flex-wrap gap-2 items-center">
                            <!-- Tags will be rendered here -->
                            <input type="text" id="tagInput" class="flex-1 bg-transparent border-none outline-none text-sm min-w-[120px]" placeholder="Ketik & tekan Enter untuk tambah tag...">
                        </div>
                        <div id="tagSuggestions" class="absolute z-50 mt-1 w-full max-w-md bg-surface-light dark:bg-surface-dark border border-gray-200 dark:border-gray-800 rounded-lg shadow-xl hidden overflow-hidden">
                             <!-- Suggestions will be rendered here -->
                        </div>
                        <div id="tagsHiddenContainer">
                            @foreach($sakit->diagnoses as $diag)
                                <input type="hidden" name="diagnoses[]" value="{{ $diag->nama }}">
                            @endforeach
                        </div>
                        <p class="text-xs text-text-muted mt-1 italic">Ketik diagnosis lalu tekan Enter. Anda bisa menambah lebih dari satu tag.</p>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Gejala</label>
                        <textarea class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary" 
                                  rows="2" name="gejala" required>{{ old('gejala', $sakit->gejala) }}</textarea>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Tindakan</label>
                        <textarea class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary" 
                                  rows="2" name="tindakan" required>{{ old('tindakan', $sakit->tindakan) }}</textarea>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Resep Obat (Deskripsi)</label>
                        <textarea class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary" 
                                  rows="2" name="resep_obat" required>{{ old('resep_obat', $sakit->resep_obat) }}</textarea>
                        <p class="text-xs text-text-muted mt-1">Edit obat detail belum tersedia. Ubah deskripsi ini jika ada perubahan obat.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Suhu Tubuh (°C)</label>
                        <input type="number" step="0.1" class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary" 
                               name="suhu_tubuh" value="{{ old('suhu_tubuh', $sakit->suhu_tubuh) }}">
                    </div>

                     <div>
                        <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Tanggal Selesai Sakit</label>
                        <input type="date" class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary" 
                               name="tanggal_selesai_sakit" value="{{ old('tanggal_selesai_sakit', $sakit->tanggal_selesai_sakit) }}">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Catatan Tambahan</label>
                        <textarea class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary" 
                                  rows="2" name="catatan">{{ old('catatan', $sakit->catatan) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="flex gap-3 mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('sakit.index') }}" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-text-main dark:text-white font-medium rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-4 py-2 bg-primary hover:bg-primary-dark text-white font-medium rounded-lg transition-colors flex items-center gap-2">
                    <span class="material-symbols-outlined text-lg">save</span>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
    <script>
    class TagInput {
        constructor(containerId, inputId, suggestionsId, hiddenContainerId) {
            this.container = document.getElementById(containerId);
            this.input = document.getElementById(inputId);
            this.suggestions = document.getElementById(suggestionsId);
            this.hiddenContainer = document.getElementById(hiddenContainerId);
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
                <div class="px-3 py-2 hover:bg-primary/10 cursor-pointer text-sm font-medium border-b border-gray-100 last:border-0" data-nama="${item.nama}">
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
            // Render UI Chips
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

            // Update Hidden Inputs
            this.hiddenContainer.innerHTML = '';
            this.tags.forEach(tag => {
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'diagnoses[]';
                hiddenInput.value = tag;
                this.hiddenContainer.appendChild(hiddenInput);
            });
        }

        setTags(tags) {
            this.tags = tags || [];
            this.render();
        }
    }

    const diagnosisTags = new TagInput('diagnosisTagInput', 'tagInput', 'tagSuggestions', 'tagsHiddenContainer');
    
    // Set initial tags from existing data
    const initialTags = @json($sakit->diagnoses->pluck('nama'));
    diagnosisTags.setTags(initialTags);
    </script>
@endsection
