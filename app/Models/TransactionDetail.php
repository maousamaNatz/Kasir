<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    protected $fillable = ['transaction_id', 'product_id', 'jumlah', 'harga_satuan', 'diskon', 'subtotal'];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class); // Pastikan relasi ini ada
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
