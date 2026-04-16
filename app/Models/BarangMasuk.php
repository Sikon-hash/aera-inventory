<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    protected $table = 'barang_masuk';
    protected $primaryKey = 'id_barang_masuk';
    protected $fillable = [
        'id_barang',
        'id_supplier',
        'id_user',
        'tanggal_masuk',
        'jumlah_masuk',
        'harga_satuan',
        'keterangan'
    ];

    // ← Pastikan 3 fungsi relasi ini ada semua
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'id_barang');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'id_supplier', 'id_supplier');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}