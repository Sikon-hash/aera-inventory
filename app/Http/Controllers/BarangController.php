<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $barang = Barang::when($search, fn($q) => $q->where('nama_barang','like',"%$search%"))
                        ->paginate(10);
        return view('barang.index', compact('barang','search'));
    }

    public function create() { return view('barang.create'); }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:100',
            'kategori'    => 'required|string|max:50',
            'satuan'      => 'required|string|max:20',
            'stok'        => 'required|integer|min:0',
            'stok_minimum'=> 'required|integer|min:0',
        ]);
        Barang::create($request->all());
        return redirect()->route('barang.index')->with('success','Barang berhasil ditambahkan!');
    }

    public function edit(Barang $barang) { return view('barang.edit', compact('barang')); }

    public function update(Request $request, Barang $barang)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:100',
            'kategori'    => 'required|string|max:50',
            'satuan'      => 'required|string|max:20',
            'stok_minimum'=> 'required|integer|min:0',
        ]);
        $barang->update($request->only(['nama_barang','kategori','satuan','stok_minimum']));
        return redirect()->route('barang.index')->with('success','Barang berhasil diupdate!');
    }

    public function destroy(Barang $barang)
    {
        $barang->delete();
        return redirect()->route('barang.index')->with('success','Barang berhasil dihapus!');
    }
}
