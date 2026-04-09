<?php

namespace App\Http\Controllers;

use App\Models\{BarangMasuk, Barang, Supplier};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangMasukController extends Controller
{
    public function index()
    {
        $data = BarangMasuk::with('barang','supplier','user')->latest()->paginate(10);
        return view('barang-masuk.index', compact('data'));
    }

    public function create()
    {
        $barang = Barang::all();
        $supplier = Supplier::all();
        return view('barang-masuk.create', compact('barang','supplier'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_barang'    => 'required|exists:barang,id_barang',
            'id_supplier'  => 'required|exists:supplier,id_supplier',
            'tanggal_masuk'=> 'required|date',
            'jumlah_masuk' => 'required|integer|min:1',
            'harga_satuan' => 'nullable|integer|min:0',
        ]);

        DB::transaction(function() use ($request) {
            BarangMasuk::create([
                'id_barang'    => $request->id_barang,
                'id_supplier'  => $request->id_supplier,
                'id_user'      => auth()->id(),
                'tanggal_masuk'=> $request->tanggal_masuk,
                'jumlah_masuk' => $request->jumlah_masuk,
                'harga_satuan' => $request->harga_satuan ?? 0,
                'keterangan'   => $request->keterangan,
            ]);
            // Update stok
            Barang::where('id_barang', $request->id_barang)
                  ->increment('stok', $request->jumlah_masuk);
        });

        return redirect()->route('barang-masuk.index')->with('success','Barang masuk berhasil dicatat!');
    }

    public function destroy(BarangMasuk $barangMasuk)
    {
        DB::transaction(function() use ($barangMasuk) {
            Barang::where('id_barang', $barangMasuk->id_barang)
                  ->decrement('stok', $barangMasuk->jumlah_masuk);
            $barangMasuk->delete();
        });
        return redirect()->route('barang-masuk.index')->with('success','Data dihapus!');
    }
}
