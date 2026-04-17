<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\StockOpname;
use Illuminate\Http\Request;

class StockOpnameController extends Controller
{
    public function index()
    {
        $data = StockOpname::with('barang', 'user')  // pastikan kedua relationship ada
                    ->latest()
                    ->paginate(10);
                    
        return view('stock-opname.index', compact('data'));
    }

    public function create()
    {
        $barang = Barang::all();
        return view('stock-opname.create', compact('barang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_barang'      => 'required|exists:barang,id_barang', 
            'tanggal_opname' => 'required|date',
            'stok_sistem'    => 'required|integer|min:0',
            'stok_fisik'     => 'required|integer|min:0',
            'keterangan'     => 'nullable|string',
        ]);

        StockOpname::create([
            'id_barang'      => $request->id_barang,  
            'id_user'        => auth()->id(),
            'tanggal_opname' => $request->tanggal_opname,
            'stok_sistem'    => $request->stok_sistem,
            'stok_fisik'     => $request->stok_fisik,
            'selisih'        => $request->stok_fisik - $request->stok_sistem,
            'keterangan'     => $request->keterangan,
        ]);

        return redirect()->route('stock-opname.index')
                         ->with('success', 'Stock opname berhasil dicatat!');
    }

    public function destroy(StockOpname $stockOpname)
    {
        $stockOpname->delete();
        return redirect()->route('stock-opname.index')
                         ->with('success', 'Data stock opname berhasil dihapus!');
    }
}