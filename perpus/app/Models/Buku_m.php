<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku_m extends Model
{

    function get_records($criteria = '')
    {
        $result = self::select('*')
            ->when($criteria, function ($query, $criteria) {
                return $query->where('ID_Buku', $criteria);
            })
            ->get();
        return $result;
    }

    function insert_record($data)
    {
        $result = self::insert($data);
        return $result;
    }

    function update_by_id($data, $id)
    {
        $result = self::where('ID_Buku', $id)
            ->update($data);
        return $result;
    }

    function delete_by_id($id)
    {
        $result = self::where('ID_Buku', $id)
            ->delete();
        return $result;
    }

    /**
     * Return array suitable for a select input: [id => label]
     */
    function opt_buku()
    {
        $rows = self::select('*')->get();
        $opt = ['' => '-Pilih buku-'];
        foreach ($rows as $r) {
            $id = $r->ID_Buku ?? $r->id ?? null;
            $title = $r->Judul ?? $r->Judul_Buku ?? $r->judul ?? $r->nama ?? $r->Nama_Buku ?? null;
            if (!$id) continue;
            $opt[$id] = $title ?? ('Buku ' . $id);
        }
        return $opt;
    }

    use HasFactory;
    protected $table = 'mst_buku';
    protected $primaryKey = 'ID_Buku';
    public $timestamps = false;


}
