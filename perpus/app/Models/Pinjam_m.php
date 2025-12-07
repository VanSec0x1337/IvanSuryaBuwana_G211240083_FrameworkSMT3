<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pinjam_m extends Model
{
    use HasFactory;

    protected $table = 'pinjam';
    protected $primaryKey = 'ID_Pinjam';
    public $timestamps = false;

    protected $fillable = [
        'ID_Anggota',
        'ID_Buku',
        'tgl_pinjam',
        'tgl_kembali',
    ];

    function insert_record($data)
    {
        // use insert to match the tutorial screenshot (returns boolean)
        return self::insert($data);
    }

    function update_by_id($data, $id)
    {
        return self::where('ID_Pinjam', $id)->update($data);
    }

    function delete_by_id($id)
    {
        return self::where('ID_Pinjam', $id)->delete();
    }
}
