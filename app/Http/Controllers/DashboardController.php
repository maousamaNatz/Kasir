<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\TransactionDetail;
use App\Services\DashboardService;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index()
    {
        $user = Auth::user();

        // Panggil service untuk semua data
        $stats = $this->dashboardService->getStatistics();
        $chartData = $this->dashboardService->getChartData();
        $transaksiTerbaru = $this->dashboardService->getRecentTransactions();
        $produkTerlaris = $this->dashboardService->getTopProducts();

        return Inertia::render('Dashboard', [
            'statistik' => $stats,
            'chartData' => $chartData,
            'transaksiTerbaru' => $transaksiTerbaru,
            'produkTerlaris' => $produkTerlaris,
        ]);
    }

    /**
     * Menampilkan grafik pendapatan per hari dalam seminggu terakhir
     */
    public function grafikPendapatan()
    {
        $tanggalMulai = Carbon::now()->subDays(7);
        $tanggalSelesai = Carbon::now();

        $pendapatanHarian = Transaction::whereBetween('waktu_transaksi', [$tanggalMulai, $tanggalSelesai])
            ->selectRaw('DATE(waktu_transaksi) as tanggal, SUM(total) as total_pendapatan')
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        return response()->json($pendapatanHarian);
    }

    /**
     * Menampilkan produk terlaris
     */
    public function produkTerlaris()
    {
        $produkTerlaris = TransactionDetail::selectRaw('product_id, SUM(jumlah) as total_terjual')
            ->with('product')
            ->groupBy('product_id')
            ->orderByDesc('total_terjual')
            ->take(10)
            ->get();

        return response()->json($produkTerlaris);
    }
}
