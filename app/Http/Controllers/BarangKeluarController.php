<?php

namespace App\Http\Controllers;

use App\Models\{BarangKeluar, Barang};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangKeluarController extends Controller
{
    public function index()
    {
        $data = BarangKeluar::with('barang','user')->latest()->paginate(10);
        return view('barang-keluar.index', compact('data'));
    }

    public function create()
    {
        $barang = Barang::where('stok', '>', 0)->get();
        return view('barang-keluar.create', compact('barang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_barang'     => 'required|exists:barang,id_barang',
            'tanggal_keluar'=> 'required|date',
            'jumlah_keluar' => 'required|integer|min:1',
        ]);

        $barang = Barang::findOrFail($request->id_barang);
        if ($barang->stok < $request->jumlah_keluar) {
            return back()->withErrors(['jumlah_keluar' => 'Stok tidak mencukupi! Stok saat ini: ' . $barang->stok]);
        }

        DB::transaction(function() use ($request) {
            BarangKeluar::create([
                'id_barang'     => $request->id_barang,
                'id_user'       => auth()->id(),
                'tanggal_keluar'=> $request->tanggal_keluar,
                'jumlah_keluar' => $request->jumlah_keluar,
                'keterangan'    => $request->keterangan,
            ]);
            Barang::where('id_barang', $request->id_barang)
                  ->decrement('stok', $request->jumlah_keluar);
        });

        return redirect()->route('barang-keluar.index')->with('success','Barang keluar berhasil dicatat!');
    }

    public function destroy(BarangKeluar $barangKeluar)
    {
        DB::transaction(function() use ($barangKeluar) {
            Barang::where('id_barang', $barangKeluar->id_barang)
                  ->increment('stok', $barangKeluar->jumlah_keluar);
            $barangKeluar->delete();
        });
        return redirect()->route('barang-keluar.index')->with('success','Data dihapus!');
    }
}