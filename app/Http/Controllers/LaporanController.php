<?php

namespace App\Http\Controllers;

use App\Models\{BarangMasuk, BarangKeluar, Barang};
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->bulan ?? now()->month;
        $tahun = $request->tahun ?? now()->year;

        $masuk = BarangMasuk::with('barang','supplier')
            ->whereMonth('tanggal_masuk', $bulan)
            ->whereYear('tanggal_masuk', $tahun)
            ->get();

        $keluar = BarangKeluar::with('barang')
            ->whereMonth('tanggal_keluar', $bulan)
            ->whereYear('tanggal_keluar', $tahun)
            ->get();

        $stokBarang = Barang::all();

        return view('laporan.index', compact('masuk','keluar','stokBarang','bulan','tahun'));
    }
}   