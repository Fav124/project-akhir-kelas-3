<?php

namespace App\Http\Controllers;

use App\Models\SakitSantri;
use App\Models\Santri;
use App\Models\Obat;
use Illuminate\Http\Request;

class SakitController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // ========================
    // 📍 INDEX
    // ========================
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = SakitSantri::with(['santri', 'santri.kelas', 'obats'])->orderBy('tanggal_mulai_sakit', 'desc');

            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $query->whereHas('santri', function($q) use ($search) {
                    $q->where('nama_lengkap', 'LIKE', "%{$search}%")
                      ->orWhere('nis', 'LIKE', "%{$search}%");
                })->orWhere('diagnosis', 'LIKE', "%{$search}%")
                  ->orWhere('status', 'LIKE', "%{$search}%");
            }

            $sakit = $query->paginate(10);
            return view('sakit.table', compact('sakit'))->render();
        }

        $sakit = SakitSantri::with(['santri', 'santri.kelas', 'obats'])
            ->orderBy('tanggal_mulai_sakit', 'desc')
            ->paginate(10);

        return view('sakit.index', compact('sakit'));
    }

    // ========================
    // 📍 CREATE
    // ========================
    public function create()
    {
        $santri = Santri::all();
        $obats = Obat::all();
        return view('sakit.create', compact('santri', 'obats'));
    }

    // ========================
    // 📍 STORE TEMPORARY (Draft)
    // ========================
    public function storeTemporary(Request $request)
    {
        $request->validate([
            'santri_id' => 'required|exists:santris,id',
            'tanggal_mulai_sakit' => 'required|date',
            'diagnosis' => 'required|string',
            'gejala' => 'required|string',
            'tindakan' => 'required|string',
            'resep_obat' => 'required|string',
            'suhu_tubuh' => 'nullable|numeric',
            'status' => 'required|in:sakit,sembuh,kontrol',
            'tanggal_selesai_sakit' => 'nullable|date',
            'catatan' => 'nullable|string',
            'obat_data' => 'nullable|array'
        ]);

        $sessionKey = 'sakit_draft_' . session()->getId();
        $drafts = session()->get($sessionKey, []);

        $newData = $request->all();
        $newData['id'] = uniqid('sakit_');
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
        $sessionKey = 'sakit_draft_' . session()->getId();
        $drafts = session()->get($sessionKey, []);

        if ($request->has('id')) {
            $id = $request->get('id');
            $item = collect($drafts)->firstWhere('id', $id);

            if (!$item) {
                return response()->json(['error' => 'Data tidak ditemukan'], 404);
            }

            // Load santri data
            $item['santri'] = Santri::find($item['santri_id']);

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
            'santri_id' => 'required|exists:santris,id',
            'tanggal_mulai_sakit' => 'required|date',
            'diagnosis' => 'required|string',
            'gejala' => 'required|string',
            'tindakan' => 'required|string',
            'resep_obat' => 'required|string',
            'suhu_tubuh' => 'nullable|numeric',
            'status' => 'required|in:sakit,sembuh,kontrol',
            'tanggal_selesai_sakit' => 'nullable|date',
            'catatan' => 'nullable|string',
            'obat_data' => 'nullable|array'
        ]);

        $sessionKey = 'sakit_draft_' . session()->getId();
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
        $sessionKey = 'sakit_draft_' . session()->getId();
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
            $sessionKey = 'sakit_draft_' . session()->getId();
            $drafts = session()->get($sessionKey, []);

            if (empty($drafts)) {
                return back()->with('error', 'Tidak ada draft untuk disimpan.');
            }

            $savedCount = 0;

            foreach ($drafts as $data) {
                $validated = validator($data, [
                    'santri_id' => 'required|exists:santris,id',
                    'tanggal_mulai_sakit' => 'required|date',
                    'diagnosis' => 'required|string',
                    'gejala' => 'required|string',
                    'tindakan' => 'required|string',
                    'resep_obat' => 'required|string',
                    'suhu_tubuh' => 'nullable|numeric',
                    'status' => 'required|in:sakit,sembuh,kontrol',
                    'tanggal_selesai_sakit' => 'nullable|date',
                    'catatan' => 'nullable|string'
                ])->validate();

                $sakit = SakitSantri::create($validated);

                // Simpan obat jika ada
                if (isset($data['obat_data']) && is_array($data['obat_data'])) {
                    foreach ($data['obat_data'] as $obatData) {
                        $sakit->obats()->attach($obatData['obat_id'], [
                            'jumlah' => $obatData['jumlah'] ?? 1,
                            'dosis' => $obatData['dosis'] ?? null,
                            'keterangan' => $obatData['keterangan'] ?? null
                        ]);
                    }
                }

                $savedCount++;
            }

            session()->forget($sessionKey);

            return redirect()->route('sakit.index')
                ->with('success', "Berhasil menyimpan {$savedCount} data sakit santri ke database! 🎉");
        } catch (\Exception $e) {
            return back()->with('error', 'Kesalahan: ' . $e->getMessage());
        }
    }

    // ========================
    // 📍 STORE (Individual Save)
    // ========================
    public function store(Request $request)
    {
        $request->validate([
            'santri_id' => 'required|exists:santris,id',
            'tanggal_mulai_sakit' => 'required|date',
            'diagnosis' => 'required|string',
            'gejala' => 'required|string',
            'tindakan' => 'required|string',
            'resep_obat' => 'required|string',
            'suhu_tubuh' => 'nullable|numeric',
            'status' => 'required|in:sakit,sembuh,kontrol',
            'tanggal_selesai_sakit' => 'nullable|date',
            'catatan' => 'nullable|string'
        ]);

        $sakit = SakitSantri::create($request->all());

        // Update santri status to 'sakit'
        Santri::find($request->santri_id)->update(['status' => 'sakit']);

        return redirect()->route('sakit.index')->with('success', 'Data sakit santri berhasil disimpan');
    }

    // ========================
    // 📍 EDIT
    // ========================
    public function edit(SakitSantri $sakit)
    {
        $santri = Santri::all();
        $obats = Obat::all();
        $sakit->load(['santri', 'obats']);
        return view('sakit.edit', compact('sakit', 'santri', 'obats'));
    }

    // ========================
    // 📍 SHOW
    // ========================
    public function show(SakitSantri $sakit)
    {
        $sakit->load(['santri.kelas', 'obats', 'user']); // Assuming 'user' is the petugas
        return view('sakit.show', compact('sakit'));
    }

    // ========================
    // 📍 UPDATE
    // ========================
    public function update(Request $request, SakitSantri $sakit)
    {
        $request->validate([
            'santri_id' => 'required|exists:santris,id',
            'tanggal_mulai_sakit' => 'required|date',
            'diagnosis' => 'required|string',
            'gejala' => 'required|string',
            'tindakan' => 'required|string',
            'resep_obat' => 'required|string',
            'suhu_tubuh' => 'nullable|numeric',
            'status' => 'required|in:sakit,sembuh,kontrol',
            'tanggal_selesai_sakit' => 'nullable|date',
            'catatan' => 'nullable|string'
        ]);

        $sakit->update($request->all());

        return redirect()->route('sakit.index')->with('success', 'Data sakit santri berhasil diperbarui');
    }

    // ========================
    // 📍 MARK RECOVERED
    // ========================
    public function markRecovered(SakitSantri $sakit)
    {
        $sakit->update([
            'status' => 'sembuh',
            'tanggal_selesai_sakit' => now()->toDateString()
        ]);

        // Update santri status back to 'sehat'
        Santri::find($sakit->santri_id)->update(['status' => 'sehat']);

        return redirect()->route('sakit.index')->with('success', 'Status santri berhasil diperbarui menjadi sembuh');
    }

    // ========================
    // 📍 DELETE
    // ========================
    public function destroy(SakitSantri $sakit)
    {
        $sakit->delete();
        return redirect()->route('sakit.index')->with('success', 'Data sakit santri berhasil dihapus');
    }
}
