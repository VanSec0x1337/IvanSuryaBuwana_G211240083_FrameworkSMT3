<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mst_anggota extends Model
{
    use HasFactory;

    protected $table = 'mst_anggota';
    protected $primaryKey = 'ID_Anggota';
    public $timestamps = false;

    function get_records($criteria = '')
    {
        $result = self::select('*')
            ->when($criteria, function ($query, $criteria) {
                return $query->where('ID_Anggota', $criteria);
            })
            ->get();
        return $result;
    }

    /**
     * Return an array suitable for a select input: [id => label]
     * Tries common name columns and falls back when necessary.
     */
    function opt_anggota()
    {
        $rows = $this->get_records();
        $opt = ['' => '-Pilih anggota-'];
        foreach ($rows as $r) {
            $id = $r->ID_Anggota ?? $r->id ?? null;
            $nim = $r->NIM ?? $r->nim ?? '';
            $name = $r->Nama ?? $r->Nama_Anggota ?? $r->nama ?? ($r->nama_lengkap ?? null);
            $prodi = $r->Prodi ?? $r->prodi ?? '';
            if (!$id) continue;
            $label = trim("$nim - $name - $prodi", ' -');
            $opt[$id] = $label;
        }
        return $opt;
    }

    function insert_record($data)
    {
        return self::insert($data);
    }

    function update_by_id($data, $id)
    {
        return self::where('ID_Anggota', $id)->update($data);
    }

    function delete_by_id($id)
    {
        return self::where('ID_Anggota', $id)->delete();
    }
}
