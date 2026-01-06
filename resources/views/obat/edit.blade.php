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
                        <span class="text-sm font-medium text-text-main dark:text-gray-200">Edit Obat</span>
                    </div>
                </li>
            </ol>
        </nav>
        <h1 class="text-3xl font-bold text-text-main dark:text-white">Edit Data Obat</h1>
        <p class="text-text-muted dark:text-gray-400 mt-1">Perbarui informasi obat dan stok.</p>
    </div>

    <div class="bg-surface-light dark:bg-surface-dark rounded-lg shadow-sm p-6 max-w-3xl">
        <form method="POST" action="{{ route('obat.update', $obat->id) }}">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Nama Obat</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <span class="material-symbols-outlined text-lg">medication</span>
                        </span>
                        <input type="text" class="w-full pl-10 pr-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary @error('nama_obat') border-red-500 @enderror" 
                               placeholder="Contoh: Paracetamol" name="nama_obat"
                               value="{{ old('nama_obat', $obat->nama_obat) }}" required>
                    </div>
                    @error('nama_obat')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Deskripsi</label>
                    <textarea class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary @error('deskripsi') border-red-500 @enderror" 
                              rows="3" placeholder="Deskripsi obat" name="deskripsi">{{ old('deskripsi', $obat->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Stok</label>
                    <input type="number" class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary @error('stok') border-red-500 @enderror" 
                           placeholder="Contoh: 50" name="stok" min="0" value="{{ old('stok', $obat->stok) }}" required>
                    @error('stok')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Satuan</label>
                    <div class="relative">
                        <select class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary appearance-none @error('satuan') border-red-500 @enderror" 
                                name="satuan" required>
                            <option selected disabled>-- Pilih Satuan --</option>
                            <option value="Tablet" {{ old('satuan', $obat->satuan) == 'Tablet' ? 'selected' : '' }}>Tablet</option>
                            <option value="Kapsul" {{ old('satuan', $obat->satuan) == 'Kapsul' ? 'selected' : '' }}>Kapsul</option>
                            <option value="Botol" {{ old('satuan', $obat->satuan) == 'Botol' ? 'selected' : '' }}>Botol</option>
                            <option value="Strip" {{ old('satuan', $obat->satuan) == 'Strip' ? 'selected' : '' }}>Strip</option>
                            <option value="Box" {{ old('satuan', $obat->satuan) == 'Box' ? 'selected' : '' }}>Box</option>
                            <option value="Pcs" {{ old('satuan', $obat->satuan) == 'Pcs' ? 'selected' : '' }}>Pcs</option>
                            <option value="Ampul" {{ old('satuan', $obat->satuan) == 'Ampul' ? 'selected' : '' }}>Ampul</option>
                            <option value="Tube" {{ old('satuan', $obat->satuan) == 'Tube' ? 'selected' : '' }}>Tube</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-text-muted">
                            <span class="material-symbols-outlined text-lg">expand_more</span>
                        </div>
                    </div>
                    @error('satuan')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex gap-3 mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('obat.index') }}" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-text-main dark:text-white font-medium rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
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
