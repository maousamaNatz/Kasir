<?php
namespace App\Services;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Transaction;
use App\Models\TransactionDetail;

class DashboardService
{
    /**
     * Menghitung statistik dashboard
     */
    public function getStatistics()
    {
        $startDate = Carbon::now()->subDays(30);
        $prevStartDate = Carbon::now()->subDays(60);

        // Statistik saat ini
        $totalPenjualan = Transaction::where('status', 'completed')
            ->where('waktu_transaksi', '>=', $startDate)
            ->sum('total');
        $totalTransaksi = Transaction::where('status', 'completed')
            ->where('waktu_transaksi', '>=', $startDate)
            ->count();
        $totalProdukTerjual = TransactionDetail::whereHas('transaction', function ($query) use ($startDate) {
            $query->where('status', 'completed')->where('waktu_transaksi', '>=', $startDate);
        })->sum('jumlah');
        $totalPelangganBaru = User::where('role', 'kasir')
            ->where('created_at', '>=', $startDate)
            ->count();

        // Statistik periode sebelumnya
        $prevTotalPenjualan = Transaction::where('status', 'completed')
            ->whereBetween('waktu_transaksi', [$prevStartDate, $startDate])
            ->sum('total');
        $prevTotalTransaksi = Transaction::where('status', 'completed')
            ->whereBetween('waktu_transaksi', [$prevStartDate, $startDate])
            ->count();
        $prevTotalProduk = TransactionDetail::whereHas('transaction', function ($query) use ($prevStartDate, $startDate) {
            $query->where('status', 'completed')->whereBetween('waktu_transaksi', [$prevStartDate, $startDate]);
        })->sum('jumlah');
        $prevPelangganBaru = User::where('role', 'kasir')
            ->whereBetween('created_at', [$prevStartDate, $startDate])
            ->count();

        // Fungsi untuk menghitung persentase
        $calculatePercentage = fn($current, $prev) => $prev > 0 ? round((($current - $prev) / $prev) * 100, 1) : ($current > 0 ? 100 : 0);

        return [
            'totalPenjualan' => (float)$totalPenjualan,
            'totalTransaksi' => $totalTransaksi,
            'totalProdukTerjual' => $totalProdukTerjual,
            'totalPelangganBaru' => $totalPelangganBaru,
            'persentasePenjualan' => $calculatePercentage($totalPenjualan, $prevTotalPenjualan),
            'persentaseTransaksi' => $calculatePercentage($totalTransaksi, $prevTotalTransaksi),
            'persentaseProduk' => $calculatePercentage($totalProdukTerjual, $prevTotalProduk),
            'persentasePelanggan' => $calculatePercentage($totalPelangganBaru, $prevPelangganBaru),
        ];
    }

    /**
     * Mengambil data untuk chart
     */
    public function getChartData()
    {
        $startDate = Carbon::now()->subDays(30);

        // Data untuk chart mingguan
        $weeklySales = Transaction::where('status', 'completed')
            ->where('waktu_transaksi', '>=', Carbon::now()->subDays(7))
            ->selectRaw('DAYNAME(waktu_transaksi) as day, SUM(total) as total')
            ->groupBy('day')
            ->orderByRaw('FIELD(day, "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday")')
            ->pluck('total', 'day')
            ->all();

        // Data untuk chart kategori
        $categorySales = TransactionDetail::whereHas('transaction', function ($query) use ($startDate) {
            $query->where('status', 'completed')->where('waktu_transaksi', '>=', $startDate);
        })
            ->join('products', 'transaction_details.product_id', '=', 'products.id')
            ->selectRaw('products.kategori, SUM(transaction_details.jumlah) as total')
            ->groupBy('products.kategori')
            ->pluck('total', 'kategori')
            ->all();

        return [
            'weeklySales' => [
                'labels' => ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
                'data' => array_values(array_merge(
                    array_fill(0, 7, 0),
                    [
                        'Monday' => 0, 'Tuesday' => 0, 'Wednesday' => 0, 'Thursday' => 0,
                        'Friday' => 0, 'Saturday' => 0, 'Sunday' => 0
                    ],
                    $weeklySales
                ))
            ],
            'categories' => [
                'labels' => array_keys($categorySales),
                'data' => array_values($categorySales),
            ],
        ];
    }

    /**
     * Mengambil transaksi terbaru
     */
    public function getRecentTransactions()
    {
        $transaksiTerbaru = Transaction::with(['user'])
            ->where('status', 'completed')
            ->orderBy('waktu_transaksi', 'desc')
            ->take(5)
            ->get();

        return $transaksiTerbaru->map(function ($transaksi) {
            return [
                'id' => $transaksi->kode_transaksi,
                'pelanggan' => $transaksi->user->name ?? 'Tidak Diketahui',
                'tanggal' => Carbon::parse($transaksi->waktu_transaksi)->format('d/m/Y H:i'),
                'jumlah' => (float)$transaksi->total,
                'status' => ucfirst($transaksi->status),
            ];
        });
    }

    /**
     * Mengambil produk terlaris
     */
    public function getTopProducts()
    {
        $startDate = Carbon::now()->subDays(30);

        $produkTerlaris = TransactionDetail::whereHas('transaction', function ($query) use ($startDate) {
            $query->where('status', 'completed')->where('waktu_transaksi', '>=', $startDate);
        })
            ->join('products', 'transaction_details.product_id', '=', 'products.id')
            ->selectRaw('products.nama_barang as nama, products.kategori, products.harga, SUM(transaction_details.jumlah) as total_terjual')
            ->groupBy('products.nama_barang', 'products.kategori', 'products.harga')
            ->orderByDesc('total_terjual')
            ->take(5)
            ->get();

        return $produkTerlaris->map(function ($item) {
            return [
                'nama' => $item->nama,
                'kategori' => $item->kategori,
                'harga' => (float)$item->harga,
                'terjual' => $item->total_terjual,
            ];
        });
    }
}
