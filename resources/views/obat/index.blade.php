@extends('layouts.master')
@section('content')
<div class="space-y-6">
    <!-- PAGE HEADER -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-text-main dark:text-white">Data Obat</h1>
            <p class="text-text-muted dark:text-gray-400 mt-1">Kelola data obat dengan baik</p>
        </div>
        <a href="{{ route('obat.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-primary hover:bg-green-600 text-white font-medium rounded-lg transition-colors w-fit">
            <span class="material-symbols-outlined text-xl">add_circle</span>
            <span>Tambah Obat</span>
        </a>
    </div>

    <!-- DATA TABLE -->
    <div class="bg-surface-light dark:bg-surface-dark rounded-lg shadow-sm overflow-hidden">
        @if ($obat->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-gray-900/50 border-b border-gray-200 dark:border-gray-800">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-text-main dark:text-gray-300">No</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-text-main dark:text-gray-300">Foto</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-text-main dark:text-gray-300">Nama Obat</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-text-main dark:text-gray-300">Deskripsi</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-text-main dark:text-gray-300">Stok</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-text-main dark:text-gray-300">Satuan</th>
                            <th class="px-6 py-3 text-center text-sm font-semibold text-text-main dark:text-gray-300">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                        @foreach ($obat as $item)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/50 transition-colors">
                                <td class="px-6 py-4 text-sm font-semibold text-text-main dark:text-gray-300">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4">
                                    <img src="{{ $item->foto ? asset('storage/photos/obats/' . basename($item->foto)) : asset('dummy.png') }}" 
                                         alt="{{ $item->nama_obat }}" 
                                         class="w-10 h-10 rounded-lg object-cover">
                                </td>
                                <td class="px-6 py-4 text-sm text-text-main dark:text-gray-300 font-medium">{{ $item->nama_obat }}</td>
                                <td class="px-6 py-4 text-sm text-text-muted dark:text-gray-400">{{ substr($item->deskripsi, 0, 40) }}{{ strlen($item->deskripsi) > 40 ? '...' : '' }}</td>
                                <td class="px-6 py-4 text-sm">
                                    @if ($item->stok > 10)
                                        <span class="inline-block px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 rounded-full text-xs font-medium">{{ $item->stok }}</span>
                                    @elseif ($item->stok > 5)
                                        <span class="inline-block px-3 py-1 bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300 rounded-full text-xs font-medium">{{ $item->stok }}</span>
                                    @else
                                        <span class="inline-block px-3 py-1 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 rounded-full text-xs font-medium">{{ $item->stok }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-text-main dark:text-gray-300">{{ $item->satuan }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <div class="flex items-center justify-center gap-2">
                                        <button type="button" 
                                                onclick="openDetailModal({{ $item->id }})"
                                                class="p-2 text-primary hover:bg-primary/10 rounded-lg transition-colors"
                                                title="Lihat detail">
                                            <span class="material-symbols-outlined text-lg">visibility</span>
                                        </button>
                                        <a href="{{ route('obat.edit', $item->id) }}" 
                                           class="p-2 text-amber-600 dark:text-amber-400 hover:bg-amber-100 dark:hover:bg-amber-900/30 rounded-lg transition-colors"
                                           title="Edit">
                                            <span class="material-symbols-outlined text-lg">edit</span>
                                        </a>
                                        <form action="{{ route('obat.destroy', $item->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="p-2 text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-900/30 rounded-lg transition-colors"
                                                    onclick="return confirm('Yakin ingin menghapus?')"
                                                    title="Hapus">
                                                <span class="material-symbols-outlined text-lg">delete</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <!-- DETAIL MODAL -->
                            <div id="detailModal{{ $item->id }}" class="fixed inset-0 bg-black/50 hidden flex items-center justify-center z-50 p-4">
                                <div class="bg-surface-light dark:bg-surface-dark rounded-lg shadow-xl max-w-2xl w-full max-h-96 overflow-y-auto">
                                    <!-- Modal Header -->
                                    <div class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-gray-800 sticky top-0 bg-surface-light dark:bg-surface-dark">
                                        <div class="flex items-center gap-3">
                                            <span class="material-symbols-outlined text-primary text-2xl">medicine</span>
                                            <h3 class="text-lg font-bold text-text-main dark:text-white">Detail Obat</h3>
                                        </div>
                                        <button type="button" onclick="closeDetailModal({{ $item->id }})" class="p-1 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors">
                                            <span class="material-symbols-outlined">close</span>
                                        </button>
                                    </div>
                                    <!-- Modal Body -->
                                    <div class="p-6">
                                        <div class="space-y-4">
                                            <div>
                                                <p class="text-xs font-semibold text-text-muted dark:text-gray-400 uppercase tracking-wide">Nama Obat</p>
                                                <p class="text-sm font-medium text-text-main dark:text-gray-300 mt-1">{{ $item->nama_obat }}</p>
                                            </div>
                                            <div>
                                                <p class="text-xs font-semibold text-text-muted dark:text-gray-400 uppercase tracking-wide">Deskripsi</p>
                                                <p class="text-sm font-medium text-text-main dark:text-gray-300 mt-1">{{ $item->deskripsi ?: '-' }}</p>
                                            </div>
                                            <div class="grid grid-cols-2 gap-4 pt-4">
                                                <div>
                                                    <p class="text-xs font-semibold text-text-muted dark:text-gray-400 uppercase tracking-wide">Stok</p>
                                                    <p class="text-sm font-medium text-text-main dark:text-gray-300 mt-1">{{ $item->stok }}</p>
                                                </div>
                                                <div>
                                                    <p class="text-xs font-semibold text-text-muted dark:text-gray-400 uppercase tracking-wide">Satuan</p>
                                                    <p class="text-sm font-medium text-text-main dark:text-gray-300 mt-1">{{ $item->satuan }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Modal Footer -->
                                    <div class="flex gap-3 p-6 border-t border-gray-200 dark:border-gray-800 bg-gray-50 dark:bg-gray-900/50 sticky bottom-0">
                                        <button type="button" 
                                                onclick="closeDetailModal({{ $item->id }})"
                                                class="flex-1 px-4 py-2 bg-gray-200 dark:bg-gray-700 text-text-main dark:text-white font-medium rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
                                            Tutup
                                        </button>
                                        <a href="{{ route('obat.edit', $item->id) }}" 
                                           class="flex-1 px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white font-medium rounded-lg flex items-center justify-center gap-2 transition-colors">
                                            <span class="material-symbols-outlined text-lg">edit</span>
                                            <span>Edit</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-12">
                <span class="material-symbols-outlined text-6xl text-gray-400 dark:text-gray-600 block mb-4">inbox</span>
                <p class="text-text-muted dark:text-gray-400 mb-4">Belum ada data obat</p>
                <a href="{{ route('obat.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-primary hover:bg-green-600 text-white font-medium rounded-lg transition-colors">
                    <span class="material-symbols-outlined text-lg">add_circle</span>
                    <span>Tambah Obat Pertama</span>
                </a>
            </div>
        @endif
    </div>
</div>

<script>
function openDetailModal(id) {
    document.getElementById('detailModal' + id).classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeDetailModal(id) {
    document.getElementById('detailModal' + id).classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Close modal when clicking outside
document.addEventListener('click', function(event) {
    if (event.target.id && event.target.id.startsWith('detailModal')) {
        event.target.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
});
</script>
@endsection
