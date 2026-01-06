@extends('layouts.master')

@section('content')
    <div class="space-y-6 max-w-2xl">
        <!-- PAGE HEADER -->
        <div>
            <h1 class="text-3xl font-bold text-text-main dark:text-white">Tambah Data Kelas</h1>
            <p class="text-text-muted dark:text-gray-400 mt-1">Tambahkan kelas baru untuk mengorganisir santri</p>
        </div>

        <!-- FORM CARD -->
        <div
            class="bg-surface-light dark:bg-surface-dark rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm p-6">
            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100 dark:border-gray-700">
                <div class="p-2 bg-primary/10 rounded-lg text-primary">
                    <span class="material-symbols-outlined">school</span>
                </div>
                <h2 class="text-lg font-bold text-text-main dark:text-white">Form Data Kelas</h2>
            </div>

            <form method="POST" action="{{ route('kelas.store') }}" class="space-y-5">
                @csrf

                <!-- NAMA KELAS -->
                <div>
                    <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">
                        Nama Kelas <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-text-muted">
                            <span class="material-symbols-outlined text-lg">home_group</span>
                        </span>
                        <input type="text"
                            class="w-full pl-12 pr-4 py-3 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white placeholder:text-text-muted focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-colors @error('nama_kelas') border-red-500 ring-2 ring-red-500 @enderror"
                            id="nama_kelas" placeholder="Contoh: Kelas 10-A" name="nama_kelas"
                            value="{{ old('nama_kelas') }}" required />
                    </div>
                    @error('nama_kelas')
                        <p class="text-red-500 text-sm mt-2 flex items-center gap-1">
                            <span class="material-symbols-outlined text-lg">error</span>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- BUTTON -->
                <div class="flex gap-3 pt-4">
                    <a href="{{ route('kelas.index') }}"
                        class="flex-1 px-4 py-3 border border-gray-200 dark:border-gray-700 text-text-main dark:text-gray-300 font-medium rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined">arrow_back</span>
                        Batal
                    </a>
                    <button type="submit"
                        class="flex-1 px-4 py-3 bg-primary hover:bg-green-600 text-text-main font-medium rounded-lg transition-colors flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined">check_circle</span>
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
