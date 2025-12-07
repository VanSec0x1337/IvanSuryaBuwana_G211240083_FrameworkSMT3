<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku_m;
use App\Models\Mst_anggota;
use App\Models\Pinjam_m;

class PinjamController extends Controller
{
    /**
     * Tampilkan daftar peminjaman (index)
     */
    public function index()
    {
        $rows = \DB::table('pinjam')
            ->leftJoin('mst_anggota', 'pinjam.ID_Anggota', '=', 'mst_anggota.ID_Anggota')
            ->leftJoin('mst_buku', 'pinjam.ID_Buku', '=', 'mst_buku.ID_Buku')
            ->select(
                'pinjam.ID_Pinjam',
                'pinjam.ID_Anggota',
                'pinjam.ID_Buku',
                'pinjam.tgl_pinjam',
                'pinjam.tgl_kembali',
                'mst_anggota.nim as anggota_nim',
                'mst_anggota.nama as anggota_nama',
                'mst_anggota.progdi as anggota_progdi',
                'mst_buku.Judul as buku_judul'
            )
            ->orderBy('pinjam.ID_Pinjam', 'asc')
            ->paginate(5);

        return view('pinjam.index', ['rows' => $rows]);
    }

    /**
     * Tampilkan formulir tambah peminjaman
     */
    public function add_new(Buku_m $buku, Mst_anggota $anggota)
    {
        $data = [
            'optanggota' => $anggota->opt_anggota(),
            'optbuku' => $buku->opt_buku(),
        ];
        return view('pinjam.add', $data);
    }

    public function save(Pinjam_m $pinjam, Request $request)
    {
        $rules = [
            'ID_Anggota' => 'required',
            'ID_Buku' => 'required',
            'tgl_pinjam' => 'required|date',
            'tgl_kembali' => 'nullable|date|after_or_equal:tgl_pinjam',
        ];

        $messages = [
            'ID_Anggota.required' => 'Silakan pilih anggota.',
            'ID_Buku.required' => 'Silakan pilih buku.',
            'tgl_pinjam.required' => 'Tanggal pinjam wajib diisi.',
            'tgl_pinjam.date' => 'Format tanggal pinjam tidak valid.',
            'tgl_kembali.date' => 'Format tanggal kembali tidak valid.',
            'tgl_kembali.after_or_equal' => 'Tanggal kembali harus sama atau setelah tanggal pinjam.',
        ];

        $attributes = [
            'ID_Anggota' => 'Anggota',
            'ID_Buku' => 'Buku',
            'tgl_pinjam' => 'Tgl. Pinjam',
            'tgl_kembali' => 'Tgl. Kembali',
        ];

        $request->validate($rules, $messages, $attributes);

        $data['ID_Anggota']  = $request->input('ID_Anggota');
        $data['ID_Buku']     = $request->input('ID_Buku');
        $data['tgl_pinjam']  = $request->input('tgl_pinjam');
        $data['tgl_kembali'] = $request->input('tgl_kembali') ?: null;

        try {
            if ($pinjam->insert_record($data)) {
                return redirect('pinjam')->with('success', 'Data berhasil disimpan.');
            }
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data.');
        } catch (\Exception $e) {
            // Log exception and return back with message
            \Log::error('PinjamController::save error - ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Hapus record pinjam
     */
    public function delete(Pinjam_m $pinjam, $id)
    {
        try {
            $pinjam->delete_by_id($id);
            return redirect('pinjam')->with('success', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            \Log::error('PinjamController::delete error - ' . $e->getMessage());
            return redirect('pinjam')->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    /**
     * Tandai kembali (set tgl_kembali ke hari ini)
     */
    public function kembali(Pinjam_m $pinjam, $id)
    {
        try {
            $data = ['tgl_kembali' => date('Y-m-d')];
            $pinjam->update_by_id($data, $id);
            return redirect('pinjam')->with('success', 'Data berhasil diperbarui (kembali).');
        } catch (\Exception $e) {
            \Log::error('PinjamController::kembali error - ' . $e->getMessage());
            return redirect('pinjam')->with('error', 'Gagal mengembalikan: ' . $e->getMessage());
        }
    }

    /**
     * Tampilkan form edit
     */
    public function edit(Pinjam_m $pinjam, Buku_m $buku, Mst_anggota $anggota, $id)
    {
        $row = $pinjam->where('ID_Pinjam', $id)->first();
        if (! $row) {
            return redirect('pinjam')->with('error', 'Data tidak ditemukan.');
        }
        $data = [
            'is_update' => 1,
            'row' => $row,
            'optanggota' => $anggota->opt_anggota(),
            'optbuku' => $buku->opt_buku(),
        ];
        return view('pinjam.add', $data);
    }

    /**
     * Update record pinjam
     */
    public function update(Pinjam_m $pinjam, Request $request)
    {
        $rules = [
            'ID_Pinjam' => 'required',
            'ID_Anggota' => 'required',
            'ID_Buku' => 'required',
            'tgl_pinjam' => 'required|date',
            'tgl_kembali' => 'nullable|date|after_or_equal:tgl_pinjam',
        ];

        $messages = [
            'ID_Pinjam.required' => 'ID pinjam tidak ditemukan.',
            'ID_Anggota.required' => 'Silakan pilih anggota.',
            'ID_Buku.required' => 'Silakan pilih buku.',
            'tgl_pinjam.required' => 'Tanggal pinjam wajib diisi.',
            'tgl_kembali.after_or_equal' => 'Tanggal kembali harus sama atau setelah tanggal pinjam.',
        ];

        $attributes = [
            'ID_Pinjam' => 'ID Pinjam',
            'ID_Anggota' => 'Anggota',
            'ID_Buku' => 'Buku',
            'tgl_pinjam' => 'Tgl. Pinjam',
            'tgl_kembali' => 'Tgl. Kembali',
        ];

        $request->validate($rules, $messages, $attributes);

        $id = $request->input('ID_Pinjam');
        $data['ID_Anggota']  = $request->input('ID_Anggota');
        $data['ID_Buku']     = $request->input('ID_Buku');
        $data['tgl_pinjam']  = $request->input('tgl_pinjam');
        $data['tgl_kembali'] = $request->input('tgl_kembali') ?: null;

        try {
            if ($pinjam->update_by_id($data, $id)) {
                return redirect('pinjam')->with('success', 'Data berhasil diupdate.');
            }
            return redirect()->back()->withInput()->with('error', 'Gagal mengupdate data.');
        } catch (\Exception $e) {
            \Log::error('PinjamController::update error - ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
