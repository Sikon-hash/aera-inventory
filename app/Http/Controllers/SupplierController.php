<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;

class SupplierController extends Controller
{
    public function index()
{
    $supplier = Supplier::paginate(10);
    return view('supplier.index', compact('supplier'));
}

public function create() { return view('supplier.create'); }

public function store(Request $request)
{
    $request->validate(['nama_supplier' => 'required|string|max:100']);
    Supplier::create($request->all());
    return redirect()->route('supplier.index')->with('success','Supplier berhasil ditambahkan!');
}

public function edit(Supplier $supplier) { return view('supplier.edit', compact('supplier')); }

public function update(Request $request, Supplier $supplier)
{
    $request->validate(['nama_supplier' => 'required|string|max:100']);
    $supplier->update($request->all());
    return redirect()->route('supplier.index')->with('success','Supplier berhasil diupdate!');
}

public function destroy(Supplier $supplier)
{
    $supplier->delete();
    return redirect()->route('supplier.index')->with('success','Supplier dihapus!');
}
}