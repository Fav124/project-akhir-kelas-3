<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use Illuminate\Http\Request;

class ObatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // ========================
    // 📍 INDEX
    // ========================
    public function index()
    {
        $obat = Obat::orderBy('nama_obat', 'asc')->get();
        return view('obat.index', compact('obat'));
    }

    // ========================
    // 📍 CREATE
    // ========================
    public function create()
    {
        return view('obat.create');
    }

    // ========================
    // 📍 STORE TEMPORARY (Draft)
    // ========================
    public function storeTemporary(Request $request)
    {
        $request->validate([
            'nama_obat' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'stok' => 'required|numeric|min:0',
            'satuan' => 'required|string|max:50',
            'stok_minimum' => 'nullable|numeric|min:0',
            'harga_satuan' => 'nullable|numeric|min:0'
        ]);

        $sessionKey = 'obat_draft_' . session()->getId();
        $drafts = session()->get($sessionKey, []);

        $newData = $request->all();
        $newData['id'] = uniqid('obat_');
        $newData['created_at'] = now()->toDateTimeString();

        $drafts[] = $newData;
        session()->put($sessionKey, $drafts);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil ditambahkan ke draft! 🎉'
        ]);
    }

    // ========================
    // 📍 GET TEMPORARY
    // ========================
    public function getTemporary(Request $request)
    {
        $sessionKey = 'obat_draft_' . session()->getId();
        $drafts = session()->get($sessionKey, []);

        if ($request->has('id')) {
            $id = $request->get('id');
            $item = collect($drafts)->firstWhere('id', $id);

            if (!$item) {
                return response()->json(['error' => 'Data tidak ditemukan'], 404);
            }

            return response()->json($item);
        }

        return response()->json($drafts);
    }

    // ========================
    // 📍 UPDATE TEMPORARY
    // ========================
    public function updateTemporary(Request $request)
    {
        $request->validate([
            'edit_id' => 'required|string',
            'nama_obat' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'stok' => 'required|numeric|min:0',
            'satuan' => 'required|string|max:50',
            'stok_minimum' => 'nullable|numeric|min:0',
            'harga_satuan' => 'nullable|numeric|min:0'
        ]);

        $sessionKey = 'obat_draft_' . session()->getId();
        $drafts = session()->get($sessionKey, []);

        $editId = $request->input('edit_id');

        $drafts = collect($drafts)->map(function ($item) use ($editId, $request) {
            if ($item['id'] === $editId) {
                return array_merge($item, $request->except(['_token', 'edit_id']), [
                    'updated_at' => now()->toDateTimeString()
                ]);
            }
            return $item;
        })->all();

        session()->put($sessionKey, $drafts);

        return response()->json([
            'success' => true,
            'message' => 'Draft berhasil diupdate! ✏️'
        ]);
    }

    // ========================
    // 📍 DELETE TEMPORARY
    // ========================
    public function deleteTemporary(Request $request)
    {
        $sessionKey = 'obat_draft_' . session()->getId();
        $drafts = session()->get($sessionKey, []);

        $id = $request->input('id');

        $drafts = collect($drafts)->reject(function ($item) use ($id) {
            return $item['id'] === $id;
        })->values()->all();

        session()->put($sessionKey, $drafts);

        return response()->json(['success' => true]);
    }

    // ========================
    // 📍 SAVE ALL FROM DRAFT
    // ========================
    public function saveAll()
    {
        try {
            $sessionKey = 'obat_draft_' . session()->getId();
            $drafts = session()->get($sessionKey, []);

            if (empty($drafts)) {
                return back()->with('error', 'Tidak ada draft untuk disimpan.');
            }

            $savedCount = 0;

            foreach ($drafts as $data) {
                $validated = validator($data, [
                    'nama_obat' => 'required|string|max:100',
                    'deskripsi' => 'nullable|string',
                    'stok' => 'required|numeric|min:0',
                    'satuan' => 'required|string|max:50',
                    'stok_minimum' => 'nullable|numeric|min:0',
                    'harga_satuan' => 'nullable|numeric|min:0'
                ])->validate();

                Obat::create($validated);
                $savedCount++;
            }

            session()->forget($sessionKey);

            return redirect()->route('obat.index')
                ->with('success', "Berhasil menyimpan {$savedCount} data obat ke database! 🎉");
        } catch (\Exception $e) {
            return back()->with('error', 'Kesalahan: ' . $e->getMessage());
        }
    }

    // ========================
    // 📍 STORE (Individual)
    // ========================
    public function store(Request $request)
    {
        $request->validate([
            'nama_obat' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'stok' => 'required|numeric|min:0',
            'satuan' => 'required|string|max:50',
            'stok_minimum' => 'nullable|numeric|min:0',
            'harga_satuan' => 'nullable|numeric|min:0'
        ]);

        Obat::create($request->all());

        return redirect()->route('obat.index')->with('success', 'Obat berhasil ditambahkan');
    }

    // ========================
    // 📍 EDIT
    // ========================
    public function edit(Obat $obat)
    {
        return view('obat.edit', compact('obat'));
    }

    // ========================
    // 📍 UPDATE
    // ========================
    public function update(Request $request, Obat $obat)
    {
        $request->validate([
            'nama_obat' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'stok' => 'required|numeric|min:0',
            'satuan' => 'required|string|max:50',
            'stok_minimum' => 'nullable|numeric|min:0',
            'harga_satuan' => 'nullable|numeric|min:0'
        ]);

        $obat->update($request->all());

        return redirect()->route('obat.index')->with('success', 'Obat berhasil diperbarui');
    }

    // ========================
    // 📍 DELETE
    // ========================
    public function destroy(Obat $obat)
    {
        // Check if obat is being used
        if ($obat->sakitSantris()->count() > 0) {
            return redirect()->route('obat.index')
                ->with('error', 'Obat tidak dapat dihapus karena masih digunakan dalam data sakit santri.');
        }

        $obat->delete();
        return redirect()->route('obat.index')->with('success', 'Obat berhasil dihapus');
    }

    // ========================
    // 📍 CHECK STOCK
    // ========================
    public function checkStock()
    {
        $lowStockObats = Obat::whereRaw('stok <= stok_minimum')->get();

        return response()->json([
            'success' => true,
            'low_stock_count' => $lowStockObats->count(),
            'obats' => $lowStockObats
        ]);
    }
}
