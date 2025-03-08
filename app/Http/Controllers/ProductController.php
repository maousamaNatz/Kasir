<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return Inertia::render('Products/Index', ['products' => $products]);
    }

    public function create()
    {
        return Inertia::render('Products/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_barang' => 'required|string|unique:products',
            'nama_barang' => 'required|string',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'kategori' => 'nullable|string',
        ]);

        Product::create($validated);
        return redirect()->route('products.index')->with('message', 'Product created successfully');
    }

    public function edit(Product $product)
    {
        return Inertia::render('Products/Edit', ['product' => $product]);
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'kode_barang' => 'string|unique:products,kode_barang,' . $product->id,
            'nama_barang' => 'string',
            'harga' => 'numeric',
            'stok' => 'integer',
            'kategori' => 'nullable|string',
        ]);

        $product->update($validated);
        return redirect()->route('products.index')->with('message', 'Product updated successfully');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('message', 'Product deleted successfully');
    }
}