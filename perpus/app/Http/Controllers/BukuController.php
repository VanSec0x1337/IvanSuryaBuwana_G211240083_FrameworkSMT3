<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku_m;

class BukuController extends Controller
{
    var $data;

    public function __construct()
    {
        $this->data['opt_kategori'] = [
            '' => '- Pilih salah satu -',
            'novel' => 'Novel',
            'komik' => 'Komik',
            'kamus' => 'Kamus',
            'program' => 'Pemrograman'
        ];
    }

    public function index(Buku_m $buku)
    {
        // paginate 5 records per page and provide category options
        $data = [
            'query' => $buku->paginate(5),
            'optkategori' => $this->data['opt_kategori'],
            // also pass with underscore for views that expect $opt_kategori
            'opt_kategori' => $this->data['opt_kategori']
        ];
        return view('buku.list', $data);
    }

    public function add_new()
    {
        $data = [
            'is_update' => 0,
            'optkategori' => $this->data['opt_kategori']
        ];
        return view('buku.add', $data);
    }

    public function save(Buku_m $buku, Request $request)
    {
        $rules = [
            'Judul' => 'required',
            'Pengarang' => 'required',
            'Kategori' => 'required',
        ];

        $messages = [
            'Judul.required' => 'Judul buku wajib diisi.',
            'Pengarang.required' => 'Pengarang wajib diisi.',
            'Kategori.required' => 'Kategori wajib dipilih.',
        ];

        $attributes = [
            'Judul' => 'Judul',
            'Pengarang' => 'Pengarang',
            'Kategori' => 'Kategori',
        ];

        $request->validate($rules, $messages, $attributes);

        $data['Judul'] = $request->input('Judul');
        $data['Pengarang'] = $request->input('Pengarang');
        $data['Kategori'] = $request->input('Kategori');
        $is_update = $request->input('is_update');

        try {
            if ($is_update == 0) {
                if ($buku->insert_record($data))
                    return redirect('buku')->with('success', 'Data buku berhasil disimpan.');
            } else {
                $id = $request->input('id');
                if ($buku->update_by_id($data, $id))
                    return redirect('buku')->with('success', 'Data buku berhasil diupdate.');
            }
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data.');
        } catch (\Exception $e) {
            \Log::error('BukuController::save error - ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit($id, Buku_m $buku)
    {
        $data = [
            'query' => $buku->get_records($id)->first(),
            'is_update' => 1,
            'optkategori' => $this->data['opt_kategori']
        ];
        return view('buku.add', $data);
    }

    public function delete($id, Buku_m $buku)
    {
        if ($buku->delete_by_id($id))
            return redirect('buku');
    }
}
