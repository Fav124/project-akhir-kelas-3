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
                         <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Diagnosis</label>
                         <input type="text" class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary" 
                                name="diagnosis" value="{{ old('diagnosis', $sakit->diagnosis) }}" required>
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
@endsection
