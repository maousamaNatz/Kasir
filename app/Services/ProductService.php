<?php

namespace App\Services;

use App\Models\Product;
use App\Helpers\CurrencyHelper;

class ProductService
{
    protected $currencyHelper;

    public function __construct(CurrencyHelper $currencyHelper)
    {
        $this->currencyHelper = $currencyHelper;
    }

    public function getAllProducts()
    {
        return Product::all()->map(function ($product) {
            return [
                'id' => $product->id,
                'kode_barang' => $product->kode_barang,
                'nama_barang' => $product->nama_barang,
                'deskripsi' => $product->deskripsi,
                'harga' => $this->currencyHelper->formatForDisplay($product->harga), // Format untuk tampilan
                'stok' => $product->stok,
                'kategori' => $product->kategori,
            ];
        });
    }

    public function createProduct(array $data)
    {
        $data['harga'] = $this->currencyHelper->filterForDatabase($data['harga']); // Filter sebelum simpan
        return Product::create($data);
    }

    public function updateProduct($id, array $data)
    {
        $product = Product::findOrFail($id);
        $data['harga'] = $this->currencyHelper->filterForDatabase($data['harga']); // Filter sebelum update
        $product->update($data);
        return $product;
    }

    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
    }
}