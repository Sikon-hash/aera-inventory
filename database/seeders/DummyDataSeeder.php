<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        // suplie
        $suppliers = [
            ['nama_supplier' => 'CV. Maju Jaya Frozen',    'alamat' => 'Jl. Raya Surabaya No. 12', 'no_telepon' => '081234567890'],
            ['nama_supplier' => 'UD. Sumber Rejeki',        'alamat' => 'Jl. Pahlawan No. 45',      'no_telepon' => '082345678901'],
            ['nama_supplier' => 'PT. Frozen Nusantara',     'alamat' => 'Jl. Industri No. 7',       'no_telepon' => '083456789012'],
        ];

        foreach ($suppliers as $s) {
            DB::table('supplier')->insert(array_merge($s, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        // barang
        $barang = [
            ['nama_barang' => 'MDM Ayam',       'kategori' => 'Ayam',    'satuan' => 'kg',   'stok' => 150, 'stok_minimum' => 20],
            ['nama_barang' => 'Ceker Ayam',      'kategori' => 'Ayam',    'satuan' => 'kg',   'stok' => 80,  'stok_minimum' => 15],
            ['nama_barang' => 'Dada Fillet',     'kategori' => 'Ayam',    'satuan' => 'kg',   'stok' => 60,  'stok_minimum' => 10],
            ['nama_barang' => 'Paha Fillet',     'kategori' => 'Ayam',    'satuan' => 'kg',   'stok' => 45,  'stok_minimum' => 10],
            ['nama_barang' => 'Udang Kupas',     'kategori' => 'Seafood', 'satuan' => 'kg',   'stok' => 30,  'stok_minimum' => 10],
            ['nama_barang' => 'Cumi-cumi',       'kategori' => 'Seafood', 'satuan' => 'kg',   'stok' => 25,  'stok_minimum' => 10],
            ['nama_barang' => 'Nugget Ayam',     'kategori' => 'Olahan',  'satuan' => 'pack', 'stok' => 100, 'stok_minimum' => 20],
            ['nama_barang' => 'Sosis Sapi',      'kategori' => 'Olahan',  'satuan' => 'pack', 'stok' => 75,  'stok_minimum' => 15],
            ['nama_barang' => 'Bakso Sapi',      'kategori' => 'Olahan',  'satuan' => 'pack', 'stok' => 8,   'stok_minimum' => 15], // stok kritis
            ['nama_barang' => 'Dimsum Ayam',     'kategori' => 'Olahan',  'satuan' => 'pack', 'stok' => 5,   'stok_minimum' => 10], // stok kritis
        ];

        foreach ($barang as $b) {
            DB::table('barang')->insert(array_merge($b, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        // barang masuk
        $barangMasukData = [
            // id_barang, id_supplier, id_user, tanggal, jumlah, harga_satuan
            [1, 1, 1, Carbon::now()->subDays(2),  50, 15000],
            [2, 1, 1, Carbon::now()->subDays(3),  30, 8000],
            [3, 2, 2, Carbon::now()->subDays(5),  25, 25000],
            [4, 2, 2, Carbon::now()->subDays(7),  20, 22000],
            [5, 3, 2, Carbon::now()->subDays(8),  15, 45000],
            [7, 1, 2, Carbon::now()->subDays(10), 40, 12000],
            [8, 3, 2, Carbon::now()->subDays(12), 30, 18000],
            [1, 1, 1, Carbon::now()->subMonth()->subDays(2), 60, 14000],
            [3, 2, 2, Carbon::now()->subMonth()->subDays(5), 30, 24000],
            [6, 3, 2, Carbon::now()->subMonth()->subDays(8), 20, 35000],
        ];

        foreach ($barangMasukData as $m) {
            DB::table('barang_masuk')->insert([
                'id_barang'    => $m[0],
                'id_supplier'  => $m[1],
                'id_user'      => $m[2],
                'tanggal_masuk'=> $m[3],
                'jumlah_masuk' => $m[4],
                'harga_satuan' => $m[5],
                'keterangan'   => 'Data dummy',
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);
        }

        // barang keluar
        $barangKeluarData = [
            // id_barang, id_user, tanggal, jumlah
            [1, 2, Carbon::now()->subDays(1),  10],
            [2, 2, Carbon::now()->subDays(2),  5],
            [3, 2, Carbon::now()->subDays(3),  8],
            [7, 2, Carbon::now()->subDays(4),  12],
            [8, 2, Carbon::now()->subDays(5),  6],
            [4, 2, Carbon::now()->subDays(6),  7],
            [1, 2, Carbon::now()->subMonth()->subDays(3), 15],
            [5, 2, Carbon::now()->subMonth()->subDays(6), 8],
            [7, 2, Carbon::now()->subMonth()->subDays(9), 20],
        ];

        foreach ($barangKeluarData as $k) {
            DB::table('barang_keluar')->insert([
                'id_barang'     => $k[0],
                'id_user'       => $k[1],
                'tanggal_keluar'=> $k[2],
                'jumlah_keluar' => $k[3],
                'keterangan'    => 'Data dummy',
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
        }

        // opname
        DB::table('stock_opname')->insert([
            [
                'id_barang'      => 9,
                'id_user'        => 1,
                'tanggal_opname' => Carbon::now()->subDays(3),
                'stok_sistem'    => 8,
                'stok_fisik'     => 7,
                'selisih'        => -1,
                'keterangan'     => 'Ada 1 pack rusak',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'id_barang'      => 10,
                'id_user'        => 1,
                'tanggal_opname' => Carbon::now()->subDays(3),
                'stok_sistem'    => 5,
                'stok_fisik'     => 5,
                'selisih'        => 0,
                'keterangan'     => 'Stok sesuai',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
        ]);

        $this->command->info('✅ Data dummy berhasil dibuat!');
    }
}