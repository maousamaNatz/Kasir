<?php
namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Services\ProductService;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        $products = $this->productService->getAllProducts();
        return Inertia::render('Products/index', [
            'products' => $products,
        ]);
    }
    public function create()
    {
        return Inertia::render('Products/create');
    }
    public function edit($id)
    {
        $product = $this->productService->getProductById($id);
        return Inertia::render('Products/edit', [
            'product' => $product,
        ]);
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_barang' => 'required|string|unique:products,kode_barang|max:255',
            'nama_barang' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0|max:9999999999999.99', // Sesuai decimal(15,2)
            'stok' => 'required|integer|min:0',
            'kategori' => 'nullable|string|max:255',
        ]);

        $product = $this->productService->createProduct($validated);

        return redirect()->route('products.index')->with('message', [
            'type' => 'success',
            'text' => "Produk {$product->nama_barang} berhasil ditambahkan!",
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'kode_barang' => 'required|string|max:255|unique:products,kode_barang,' . $id,
            'nama_barang' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0|max:9999999999999.99', // Sesuai decimal(15,2)
            'stok' => 'required|integer|min:0',
            'kategori' => 'nullable|string|max:255',
        ]);

        $product = $this->productService->updateProduct($id, $validated);

        return redirect()->route('products.index')->with('message', [
            'type' => 'success',
            'text' => "Produk {$product->nama_barang} berhasil diperbarui!",
        ]);
    }

    public function destroy($id)
    {
        $this->productService->deleteProduct($id);
        return redirect()->route('products.index')->with('message', [
            'type' => 'success',
            'text' => 'Produk berhasil dihapus!',
        ]);
    }
}