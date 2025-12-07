<?php

namespace App\Http\Controllers;

use App\Models\Mst_anggota;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    /**
     * Tampilkan daftar anggota
     */
    public function index(Mst_anggota $anggota)
    {
        // paginate 5 records per page
        $rows = $anggota->paginate(5);
        return view('anggota.index', ['rows' => $rows]);
    }

    /**
     * Tampilkan form tambah anggota
     */
    public function add_new()
    {
        return view('anggota.add', ['is_update' => 0]);
    }

    /**
     * Simpan record anggota baru
     */
    public function save(Mst_anggota $anggota, Request $request)
    {
        $rules = [
            'nim' => 'required|unique:mst_anggota,nim',
            'nama' => 'required',
            'progdi' => 'required',
        ];

        $messages = [
            'nim.required' => 'NIM wajib diisi.',
            'nim.unique' => 'NIM sudah terdaftar.',
            'nama.required' => 'Nama lengkap wajib diisi.',
            'progdi.required' => 'Program studi wajib diisi.',
        ];

        $attributes = [
            'nim' => 'NIM',
            'nama' => 'Nama Lengkap',
            'progdi' => 'Program Studi',
        ];

        $request->validate($rules, $messages, $attributes);

        $data = [
            'nim' => $request->input('nim'),
            'nama' => $request->input('nama'),
            'progdi' => $request->input('progdi'),
        ];

        try {
            if ($anggota->insert_record($data)) {
                return redirect('anggota')->with('success', 'Data anggota berhasil disimpan.');
            }
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data.');
        } catch (\Exception $e) {
            \Log::error('AnggotaController::save error - ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Tampilkan form edit anggota
     */
    public function edit(Mst_anggota $anggota, $id)
    {
        $row = $anggota->where('ID_Anggota', $id)->first();
        if (!$row) {
            return redirect('anggota')->with('error', 'Data tidak ditemukan.');
        }
        return view('anggota.add', ['is_update' => 1, 'row' => $row]);
    }

    /**
     * Update record anggota
     */
    public function update(Mst_anggota $anggota, Request $request)
    {
        $id = $request->input('ID_Anggota');
        $rules = [
            'nim' => 'required|unique:mst_anggota,nim,' . $id . ',ID_Anggota',
            'nama' => 'required',
            'progdi' => 'required',
        ];

        $messages = [
            'nim.required' => 'NIM wajib diisi.',
            'nim.unique' => 'NIM sudah terdaftar.',
            'nama.required' => 'Nama lengkap wajib diisi.',
            'progdi.required' => 'Program studi wajib diisi.',
        ];

        $attributes = [
            'nim' => 'NIM',
            'nama' => 'Nama Lengkap',
            'progdi' => 'Program Studi',
        ];

        $request->validate($rules, $messages, $attributes);

        $data = [
            'nim' => $request->input('nim'),
            'nama' => $request->input('nama'),
            'progdi' => $request->input('progdi'),
        ];

        try {
            if ($anggota->update_by_id($data, $id)) {
                return redirect('anggota')->with('success', 'Data anggota berhasil diupdate.');
            }
            return redirect()->back()->withInput()->with('error', 'Gagal mengupdate data.');
        } catch (\Exception $e) {
            \Log::error('AnggotaController::update error - ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Hapus record anggota
     */
    public function delete(Mst_anggota $anggota, $id)
    {
        try {
            $anggota->delete_by_id($id);
            return redirect('anggota')->with('success', 'Data anggota berhasil dihapus.');
        } catch (\Exception $e) {
            \Log::error('AnggotaController::delete error - ' . $e->getMessage());
            return redirect('anggota')->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
