<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangKeluar extends Model
{
    protected $table = 'barang_keluar';
    protected $primaryKey = 'id_barang_keluar';
    protected $fillable = [
        'id_barang',
        'id_user',
        'tanggal_keluar',
        'jumlah_keluar',
        'keterangan'
    ];

    // ← Pastikan 2 relasi ini ada
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'id_barang');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}