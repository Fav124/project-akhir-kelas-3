@extends('layouts.master')
@section('content')
<div class="space-y-6">
    <!-- PAGE HEADER -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-text-main dark:text-white">Data Santri Sakit</h1>
            <p class="text-text-muted dark:text-gray-400 mt-1">Kelola catatan santri yang sakit</p>
        </div>
        <a href="{{ route('sakit.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-primary hover:bg-green-600 text-white font-medium rounded-lg transition-colors w-fit">
            <span class="material-symbols-outlined text-xl">add_circle</span>
            <span>Tambah Data</span>
        </a>
    </div>

    <!-- DATA TABLE -->
    <div class="bg-surface-light dark:bg-surface-dark rounded-lg shadow-sm overflow-hidden">
        @if ($sakit->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-gray-900/50 border-b border-gray-200 dark:border-gray-800">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-text-main dark:text-gray-300">Tanggal</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-text-main dark:text-gray-300">Santri</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-text-main dark:text-gray-300">Diagnosis</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-text-main dark:text-gray-300">Status</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-text-main dark:text-gray-300">Suhu</th>
                            <th class="px-6 py-3 text-center text-sm font-semibold text-text-main dark:text-gray-300">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                        @foreach ($sakit as $item)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/50 transition-colors">
                                <td class="px-6 py-4 text-sm text-text-muted dark:text-gray-400">{{ $item->tanggal_mulai_sakit->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <p class="font-semibold text-text-main dark:text-gray-300">{{ $item->santri->nama_lengkap ?? 'N/A' }}</p>
                                    <p class="text-xs text-text-muted dark:text-gray-400">{{ $item->santri->nis ?? '-' }}</p>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <p class="font-semibold text-text-main dark:text-gray-300">{{ $item->diagnosis }}</p>
                                    <p class="text-xs text-text-muted dark:text-gray-400">{{ substr($item->gejala, 0, 30) }}...</p>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    @if($item->status === 'sehat')
                                        <span class="inline-block px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 rounded-full text-xs font-medium">Sehat</span>
                                    @elseif($item->status === 'sembuh')
                                        <span class="inline-block px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-full text-xs font-medium">Sembuh</span>
                                    @else
                                        <span class="inline-block px-3 py-1 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 rounded-full text-xs font-medium">Sakit</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm font-semibold text-text-main dark:text-gray-300">
                                    @if ($item->suhu_tubuh)
                                        {{ $item->suhu_tubuh }}°C
                                    @else
                                        <span class="text-text-muted dark:text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <div class="flex items-center justify-center gap-2">
                                        <button type="button" 
                                                onclick="openDetailModal({{ $item->id }})"
                                                class="p-2 text-primary hover:bg-primary/10 rounded-lg transition-colors"
                                                title="Lihat detail">
                                            <span class="material-symbols-outlined text-lg">visibility</span>
                                        </button>
                                        <a href="{{ route('sakit.edit', $item->id) }}" 
                                           class="p-2 text-amber-600 dark:text-amber-400 hover:bg-amber-100 dark:hover:bg-amber-900/30 rounded-lg transition-colors"
                                           title="Edit">
                                            <span class="material-symbols-outlined text-lg">edit</span>
                                        </a>
                                        @if($item->status !== 'sembuh')
                                            <form action="{{ route('sakit.sembuh', $item->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" 
                                                        class="p-2 text-green-600 dark:text-green-400 hover:bg-green-100 dark:hover:bg-green-900/30 rounded-lg transition-colors"
                                                        onclick="return confirm('Tandai santri sebagai sembuh?')"
                                                        title="Tandai Sembuh">
                                                    <span class="material-symbols-outlined text-lg">check_circle</span>
                                                </button>
                                            </form>
                                        @else
                                            <span class="p-2 text-gray-400 dark:text-gray-600 cursor-not-allowed" title="Sudah sembuh">
                                                <span class="material-symbols-outlined text-lg">check_circle</span>
                                            </span>
                                        @endif
                                        <form action="{{ route('sakit.destroy', $item->id) }}" method="POST" style="display:inline;">
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
                                            <span class="material-symbols-outlined text-primary text-2xl">health_and_safety</span>
                                            <h3 class="text-lg font-bold text-text-main dark:text-white">Detail Data Sakit</h3>
                                        </div>
                                        <button type="button" onclick="closeDetailModal({{ $item->id }})" class="p-1 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors">
                                            <span class="material-symbols-outlined">close</span>
                                        </button>
                                    </div>
                                    <!-- Modal Body -->
                                    <div class="p-6">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <!-- Data Santri -->
                                            <div class="space-y-4">
                                                <h4 class="font-bold text-text-main dark:text-white">Data Santri</h4>
                                                <div>
                                                    <p class="text-xs font-semibold text-text-muted dark:text-gray-400 uppercase tracking-wide">NIS</p>
                                                    <p class="text-sm font-medium text-text-main dark:text-gray-300 mt-1">{{ $item->santri->nis }}</p>
                                                </div>
                                                <div>
                                                    <p class="text-xs font-semibold text-text-muted dark:text-gray-400 uppercase tracking-wide">Nama</p>
                                                    <p class="text-sm font-medium text-text-main dark:text-gray-300 mt-1">{{ $item->santri->nama_lengkap }}</p>
                                                </div>
                                                <div>
                                                    <p class="text-xs font-semibold text-text-muted dark:text-gray-400 uppercase tracking-wide">Kelas</p>
                                                    <p class="text-sm font-medium text-text-main dark:text-gray-300 mt-1">{{ $item->santri->kelas->nama_kelas ?? 'N/A' }}</p>
                                                </div>
                                            </div>
                                            <!-- Status -->
                                            <div class="space-y-4">
                                                <h4 class="font-bold text-text-main dark:text-white">Status</h4>
                                                <div>
                                                    <p class="text-xs font-semibold text-text-muted dark:text-gray-400 uppercase tracking-wide">Status Kondisi</p>
                                                    <div class="mt-1">
                                                        @if($item->status === 'sehat')
                                                            <span class="inline-block px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 rounded-full text-xs font-medium">Sehat</span>
                                                        @elseif($item->status === 'sembuh')
                                                            <span class="inline-block px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-full text-xs font-medium">Sembuh</span>
                                                        @else
                                                            <span class="inline-block px-3 py-1 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 rounded-full text-xs font-medium">Sakit</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div>
                                                    <p class="text-xs font-semibold text-text-muted dark:text-gray-400 uppercase tracking-wide">Tanggal Mulai</p>
                                                    <p class="text-sm font-medium text-text-main dark:text-gray-300 mt-1">{{ $item->tanggal_mulai_sakit->format('d M Y') }}</p>
                                                </div>
                                                @if ($item->tanggal_selesai_sakit)
                                                    <div>
                                                        <p class="text-xs font-semibold text-text-muted dark:text-gray-400 uppercase tracking-wide">Tanggal Selesai</p>
                                                        <p class="text-sm font-medium text-text-main dark:text-gray-300 mt-1">{{ $item->tanggal_selesai_sakit->format('d M Y') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <hr class="my-6 border-gray-200 dark:border-gray-700">

                                        <!-- Detail Penyakit -->
                                        <div class="space-y-4">
                                            <h4 class="font-bold text-text-main dark:text-white">Detail Penyakit</h4>
                                            <div>
                                                <p class="text-xs font-semibold text-text-muted dark:text-gray-400 uppercase tracking-wide">Diagnosis</p>
                                                <p class="text-sm font-medium text-text-main dark:text-gray-300 mt-1">{{ $item->diagnosis }}</p>
                                            </div>
                                            <div>
                                                <p class="text-xs font-semibold text-text-muted dark:text-gray-400 uppercase tracking-wide">Gejala</p>
                                                <p class="text-sm font-medium text-text-main dark:text-gray-300 mt-1">{{ $item->gejala }}</p>
                                            </div>
                                            <div>
                                                <p class="text-xs font-semibold text-text-muted dark:text-gray-400 uppercase tracking-wide">Tindakan/Perawatan</p>
                                                <p class="text-sm font-medium text-text-main dark:text-gray-300 mt-1">{{ $item->tindakan }}</p>
                                            </div>
                                            <div>
                                                <p class="text-xs font-semibold text-text-muted dark:text-gray-400 uppercase tracking-wide">Resep Obat</p>
                                                <p class="text-sm font-medium text-text-main dark:text-gray-300 mt-1">{{ $item->resep_obat }}</p>
                                            </div>
                                            @if ($item->suhu_tubuh)
                                                <div>
                                                    <p class="text-xs font-semibold text-text-muted dark:text-gray-400 uppercase tracking-wide">Suhu Tubuh</p>
                                                    <p class="text-sm font-bold text-text-main dark:text-gray-300 mt-1">{{ $item->suhu_tubuh }}°C</p>
                                                </div>
                                            @endif
                                            @if ($item->catatan)
                                                <div>
                                                    <p class="text-xs font-semibold text-text-muted dark:text-gray-400 uppercase tracking-wide">Catatan</p>
                                                    <p class="text-sm font-medium text-text-main dark:text-gray-300 mt-1">{{ $item->catatan }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <!-- Modal Footer -->
                                    <div class="flex gap-3 p-6 border-t border-gray-200 dark:border-gray-800 bg-gray-50 dark:bg-gray-900/50 sticky bottom-0">
                                        <button type="button" 
                                                onclick="closeDetailModal({{ $item->id }})"
                                                class="flex-1 px-4 py-2 bg-gray-200 dark:bg-gray-700 text-text-main dark:text-white font-medium rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
                                            Tutup
                                        </button>
                                        <a href="{{ route('sakit.edit', $item->id) }}" 
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
                <p class="text-text-muted dark:text-gray-400 mb-4">Belum ada data santri sakit</p>
                <a href="{{ route('sakit.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-primary hover:bg-green-600 text-white font-medium rounded-lg transition-colors">
                    <span class="material-symbols-outlined text-lg">add_circle</span>
                    <span>Tambah Data Pertama</span>
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
