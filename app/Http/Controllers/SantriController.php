<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\WaliSantri;
use App\Models\Kelas;
use App\Helpers\PhotoHelper;
use Illuminate\Http\Request;

class SantriController extends Controller
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
        $santri = Santri::with('kelas')->get();
        return view('santri.index', compact('santri'));
    }

    // ========================
    // 📍 CREATE
    // ========================
    public function create()
    {
        $kelas = Kelas::all();
        // preload a small list of santri for client-side typeahead
        $allSantri = Santri::select('id', 'nama_lengkap', 'nis', 'kelas_id')
            ->with('kelas:id,nama_kelas')
            ->limit(1000)
            ->get()
            ->map(function ($s) {
                return [
                    'id' => $s->id,
                    'nama_lengkap' => $s->nama_lengkap,
                    'nis' => $s->nis,
                    'kelas' => $s->kelas->nama_kelas ?? null
                ];
            });

        return view('santri.create', compact('kelas', 'allSantri'));
    }

    // ========================
    // 📍 SEARCH (typeahead)
    // ========================
    public function search(Request $request)
    {
        $q = $request->get('q', '');

        if (!trim($q)) {
            return response()->json([]);
        }

        $results = Santri::select('id', 'nama_lengkap', 'nis', 'kelas_id')
            ->with('kelas:id,nama_kelas')
            ->where('nama_lengkap', 'like', "%{$q}%")
            ->orWhere('nis', 'like', "%{$q}%")
            ->limit(20)
            ->get()
            ->map(function ($s) {
                return [
                    'id' => $s->id,
                    'nama_lengkap' => $s->nama_lengkap,
                    'nis' => $s->nis,
                    'kelas' => $s->kelas->nama_kelas ?? null
                ];
            });

        return response()->json($results);
    }

    // ========================
    // 📍 AUTOSAVE (store temporary)
    // ========================
    public function storeTemporary(Request $request)
    {
        $request->validate([
            'nis' => 'required|string',
            'nama_lengkap' => 'required|string',
            'jenis_kelamin' => 'required|string',
            'kelas_id' => 'required|exists:kelas,id',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'nama_wali' => 'required|string',
            'hubungan' => 'required|string',
            'no_hp' => 'required|string',
            'wali_tempat_lahir' => 'required|string',
            'wali_tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'foto' => 'nullable|image|max:5120'
        ]);

        // Ambil data yang sudah ada
        $sessionKey = 'santri_draft_' . session()->getId();
        $drafts = session()->get($sessionKey, []);

        // Handle photo upload
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = PhotoHelper::store($request->file('foto'), 'santris');
        }

        // Tambahkan data baru dengan ID unik
        $newData = $request->except('foto');
        $newData['foto'] = $fotoPath;
        $newData['id'] = uniqid('santri_'); // Generate unique ID
        $newData['created_at'] = now()->toDateTimeString();

        $drafts[] = $newData;

        // Simpan kembali ke session
        session()->put($sessionKey, $drafts);

        return response()->json([
            'success' => true,
            'message' => 'Draft tersimpan otomatis.'
        ]);
    }

    // ========================
    // 📍 GET TEMPORARY (list semua atau detail)
    // ========================
    public function getTemporary(Request $request)
    {
        $sessionKey = 'santri_draft_' . session()->getId();
        $drafts = session()->get($sessionKey, []);

        // Jika ada parameter ID, return detail satu item
        if ($request->has('id')) {
            $id = $request->get('id');
            $item = collect($drafts)->firstWhere('id', $id);

            if (!$item) {
                return response()->json(['error' => 'Data tidak ditemukan'], 404);
            }

            return response()->json($item);
        }

        // Return semua draft
        return response()->json($drafts);
    }

    // ========================
    // 📍 DELETE TEMPORARY (hapus satu item)
    // ========================
    public function deleteTemporary(Request $request)
    {
        $sessionKey = 'santri_draft_' . session()->getId();
        $drafts = session()->get($sessionKey, []);

        $id = $request->input('id');

        // Filter out item yang mau dihapus
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
            $sessionKey = 'santri_draft_' . session()->getId();
            $drafts = session()->get($sessionKey, []);

            if (empty($drafts)) {
                return back()->with('error', 'Tidak ada draft untuk disimpan.');
            }

            $savedCount = 0;

            foreach ($drafts as $data) {
                // Validasi setiap data
                $validated = validator($data, [
                    'nis' => 'required|string|unique:santris',
                    'nama_lengkap' => 'required|string',
                    'jenis_kelamin' => 'required|string',
                    'kelas_id' => 'required|exists:kelas,id',
                    'tempat_lahir' => 'required|string',
                    'tanggal_lahir' => 'required|date',
                    'nama_wali' => 'required|string',
                    'hubungan' => 'required|string',
                    'no_hp' => 'required|string',
                    'wali_tempat_lahir' => 'required|string',
                    'wali_tanggal_lahir' => 'required|date',
                    'alamat' => 'required|string',
                    'foto' => 'nullable|string'
                ])->validate();

                // Simpan Santri
                $santri = Santri::create([
                    'nis' => $validated['nis'],
                    'nama_lengkap' => $validated['nama_lengkap'],
                    'jenis_kelamin' => $validated['jenis_kelamin'],
                    'kelas_id' => $validated['kelas_id'],
                    'tempat_lahir' => $validated['tempat_lahir'],
                    'tanggal_lahir' => $validated['tanggal_lahir'],
                    'foto' => $validated['foto'] ?? null,
                    'status' => 'sehat'
                ]);

                // Simpan Wali
                WaliSantri::create([
                    'santri_id' => $santri->id,
                    'nama_wali' => $validated['nama_wali'],
                    'tempat_lahir' => $validated['wali_tempat_lahir'],
                    'tanggal_lahir' => $validated['wali_tanggal_lahir'],
                    'hubungan' => $validated['hubungan'],
                    'no_hp' => $validated['no_hp'],
                    'alamat' => $validated['alamat']
                ]);

                $savedCount++;
            }

            // Hapus semua draft setelah berhasil
            session()->forget($sessionKey);

            return redirect()->route('santri.index')
                ->with('success', "Berhasil menyimpan {$savedCount} data santri ke database! 🎉");
        } catch (\Exception $e) {
            return back()->with('error', 'Kesalahan: ' . $e->getMessage());
        }
    }

    // ========================
    // 📍 FINAL SAVE SANTRI (Manual Save) - TIDAK DIGUNAKAN LAGI
    // ========================
    public function save(Request $request)
    {
        $request->validate([
            'nis' => 'required|string|unique:santris',
            'nama_lengkap' => 'required|string',
            'jenis_kelamin' => 'required|string',
            'kelas_id' => 'required|exists:kelas,id',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'nama_wali' => 'required|string',
            'hubungan' => 'required|string',
            'no_hp' => 'required|string',
            'wali_tempat_lahir' => 'required|string',
            'wali_tanggal_lahir' => 'required|date',
            'alamat' => 'required|string'
        ]);

        $santri = Santri::create($request->only(
            'nis',
            'nama_lengkap',
            'jenis_kelamin',
            'kelas_id',
            'tempat_lahir',
            'tanggal_lahir'
        ) + ['status' => 'sehat']);

        WaliSantri::create([
            'santri_id' => $santri->id,
            'nama_wali' => $request->nama_wali,
            'tempat_lahir' => $request->wali_tempat_lahir,
            'tanggal_lahir' => $request->wali_tanggal_lahir,
            'hubungan' => $request->hubungan,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat
        ]);

        return redirect()->route('santri.index')->with('success', 'Data santri berhasil disimpan.');
    }

    // ========================
    // 📍 EDIT
    // ========================
    public function edit(Santri $santri)
    {
        $kelas = Kelas::all();
        $wali  = WaliSantri::where('santri_id', $santri->id)->first();
        return view('santri.edit', compact('santri', 'kelas', 'wali'));
    }

    // ========================
    // 📍 UPDATE
    // ========================
    public function update(Request $request, Santri $santri)
    {
        $request->validate([
            'nis' => 'required|string|unique:santris,nis,' . $santri->id,
            'nama_lengkap' => 'required|string',
            'jenis_kelamin' => 'required|string',
            'kelas_id' => 'required|exists:kelas,id',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'nama_wali' => 'required|string',
            'hubungan' => 'required|string',
            'no_hp' => 'required|string',
            'wali_tempat_lahir' => 'required|string',
            'wali_tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'foto' => 'nullable|image|max:5120'
        ]);

        // Handle photo upload/update
        $updateData = $request->only(
            'nis',
            'nama_lengkap',
            'jenis_kelamin',
            'kelas_id',
            'tempat_lahir',
            'tanggal_lahir'
        );

        if ($request->hasFile('foto')) {
            // Delete old photo
            PhotoHelper::delete($santri->foto);
            // Store new photo
            $updateData['foto'] = PhotoHelper::store($request->file('foto'), 'santris');
        }

        $santri->update($updateData);

        WaliSantri::updateOrCreate(
            ['santri_id' => $santri->id],
            [
                'nama_wali' => $request->nama_wali,
                'tempat_lahir' => $request->wali_tempat_lahir,
                'tanggal_lahir' => $request->wali_tanggal_lahir,
                'hubungan' => $request->hubungan,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat
            ]
        );

        return redirect()->route('santri.index')->with('success', 'Data berhasil diperbarui.');
    }

    // ========================
    // 📍 DELETE
    // ========================
    public function destroy(Santri $santri)
    {
        // Delete photo file
        PhotoHelper::delete($santri->foto);
        
        // Delete related records
        WaliSantri::where('santri_id', $santri->id)->delete();
        $santri->delete();

        return redirect()->route('santri.index')->with('success', 'Data santri berhasil dihapus.');
    }

    // ========================
    // 📍 UPDATE DRAFT (edit item di session)
    // ========================
    public function updateTemporary(Request $request)
    {
        $request->validate([
            'edit_id' => 'required|string',
            'nis' => 'required|string',
            'nama_lengkap' => 'required|string',
            'jenis_kelamin' => 'required|string',
            'kelas_id' => 'required|exists:kelas,id',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'nama_wali' => 'required|string',
            'hubungan' => 'required|string',
            'no_hp' => 'required|string',
            'wali_tempat_lahir' => 'required|string',
            'wali_tanggal_lahir' => 'required|date',
            'alamat' => 'required|string'
        ]);

        $sessionKey = 'santri_draft_' . session()->getId();
        $drafts = session()->get($sessionKey, []);

        $editId = $request->input('edit_id');

        // Cari dan update item
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
}
