<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBarang = Barang::count();
        $totalMasukBulanIni = BarangMasuk::whereMonth('tanggal_masuk', now()->month)->sum('jumlah_masuk');
        $totalKeluarBulanIni = BarangKeluar::whereMonth('tanggal_keluar', now()->month)->sum('jumlah_keluar');
        $stokKritis = Barang::whereColumn('stok', '<=', 'stok_minimum')->count();

        $barang = Barang::orderBy('stok')->take(10)->get();
        $recentMasuk = BarangMasuk::with('barang','supplier')->latest()->take(5)->get();
        $recentKeluar = BarangKeluar::with('barang')->latest()->take(5)->get();

        return view('dashboard', compact(
            'totalBarang','totalMasukBulanIni','totalKeluarBulanIni',
            'stokKritis','barang','recentMasuk','recentKeluar'
        ));
    }
}