<div class="overflow-x-auto">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-800 dark:text-gray-300">
            <tr>
                <th class="px-6 py-4 font-bold rounded-tl-xl" scope="col">No</th>
                <th class="px-6 py-4 font-bold" scope="col">Nama Obat</th>
                <th class="px-6 py-4 font-bold" scope="col">Stok</th>
                <th class="px-6 py-4 font-bold" scope="col">Satuan</th>
                <th class="px-6 py-4 font-bold" scope="col">Stok Min</th>
                <th class="px-6 py-4 font-bold" scope="col">Harga</th>
                <th class="px-6 py-4 font-bold rounded-tr-xl text-center" scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
            @forelse($obat as $index => $item)
            <tr class="bg-white dark:bg-surface-dark hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                    {{ $obat->firstItem() + $index }}
                </td>
                <td class="px-6 py-4 font-medium text-text-main dark:text-white">
                    {{ $item->nama_obat }}
                    @if($item->stok <= $item->stok_minimum)
                        <span class="inline-flex items-center justify-center p-1 ml-2 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full" title="Stok Menipis!">!</span>
                    @endif
                </td>
                <td class="px-6 py-4">
                    <span class="{{ $item->stok <= $item->stok_minimum ? 'text-red-600 font-bold' : 'text-gray-600 dark:text-gray-300' }}">
                        {{ $item->stok }}
                    </span>
                </td>
                <td class="px-6 py-4">{{ $item->satuan }}</td>
                <td class="px-6 py-4">{{ $item->stok_minimum }}</td>
                <td class="px-6 py-4">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                <td class="px-6 py-4">
                    <div class="flex items-center justify-center gap-2">
                        <a href="{{ route('obat.show', $item->id) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg dark:text-blue-400 dark:hover:bg-blue-900/20 transition-colors" title="Detail">
                            <span class="material-symbols-outlined text-[20px]">visibility</span>
                        </a>
                        <a href="{{ route('obat.edit', $item->id) }}" class="p-2 text-amber-600 hover:bg-amber-50 rounded-lg dark:text-amber-400 dark:hover:bg-amber-900/20 transition-colors" title="Edit">
                            <span class="material-symbols-outlined text-[20px]">edit</span>
                        </a>
                        <form action="{{ route('obat.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus obat ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg dark:text-red-400 dark:hover:bg-red-900/20 transition-colors" title="Delete">
                                <span class="material-symbols-outlined text-[20px]">delete</span>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                    Tidak ada data obat ditemukan.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="p-4 border-t border-gray-200 dark:border-gray-800">
    {{ $obat->links('pagination::tailwind') }}
</div>
