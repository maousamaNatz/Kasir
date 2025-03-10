<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return Inertia::render('Cashier/Index', [
            'products' => $products,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.jumlah' => 'required|integer|min:1',
            'bayar' => 'required|numeric|min:' . $request->total,
            'total' => 'required|numeric',
        ]);

        DB::beginTransaction();
        try {
            $transaction = Transaction::create([
                'kode_transaksi' => 'TRX' . time(),
                'user_id' => auth()->id(),
                'total' => $request->total,
                'bayar' => $request->bayar,
                'kembali' => $request->bayar - $request->total,
                'metode_pembayaran' => 'tunai',
                'status' => 'completed',
                'waktu_transaksi' => now(),
            ]);

            foreach ($request->items as $item) {
                $product = Product::find($item['product_id']);
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $item['product_id'],
                    'jumlah' => $item['jumlah'],
                    'harga_satuan' => $product->harga,
                    'subtotal' => $item['jumlah'] * $product->harga,
                ]);
                $product->decrement('stok', $item['jumlah']);
            }

            DB::commit();

            return redirect()->route('cashier.index')->with('message', [
                'type' => 'success',
                'text' => 'Transaksi berhasil! Struk tersedia.',
                'struk' => $this->generateStruk($transaction),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('message', [
                'type' => 'error',
                'text' => 'Gagal menyimpan transaksi: ' . $e->getMessage(),
            ]);
        }
    }

    private function generateStruk($transaction)
    {
        $struk = "====================================\n";
        $struk .= "          TOKO SERBA ADA           \n";
        $struk .= "------------------------------------\n";
        $struk .= "Kode Transaksi   : {$transaction->kode_transaksi}\n";
        $struk .= "Kasir            : {$transaction->user->name}\n";
        $struk .= "Waktu            : {$transaction->waktu_transaksi->format('d-m-Y H:i')}\n";
        $struk .= "------------------------------------\n";
        $struk .= "Item             Qty   Harga    Total\n";

        foreach ($transaction->details as $detail) {
            $struk .= sprintf(
                "%-15s %-5d %-8d %-8d\n",
                $detail->product->nama_barang,
                $detail->jumlah,
                $detail->harga_satuan,
                $detail->subtotal
            );
        }

        $struk .= "------------------------------------\n";
        $struk .= "Total                    : " . number_format($transaction->total, 0) . "\n";
        $struk .= "Bayar (Tunai)            : " . number_format($transaction->bayar, 0) . "\n";
        $struk .= "Kembali                  : " . number_format($transaction->kembali, 0) . "\n";
        $struk .= "====================================\n";
        $struk .= "       Terima Kasih atas Belanja Anda!\n";

        return $struk;
    }
}