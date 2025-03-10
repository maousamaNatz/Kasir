<script setup>
import { onMounted, onUnmounted, ref, watch } from "vue";
import { usePage } from "@inertiajs/vue3";
import DashboardLayout from "@/Layouts/Dashboard.Layouts.vue";
import Chart from "chart.js/auto";

const isLoading = ref(true);
const error = ref(null);

const props = usePage().props;
const statistik = ref(props.statistik || {});
const transaksiTerbaru = ref(props.transaksiTerbaru || []);
const produkTerlaris = ref(props.produkTerlaris || []);
const chartData = ref(props.chartData || {
    weeklySales: { labels: [], data: [] },
    categories: { labels: [], data: [] },
});

const defaultStatistik = {
    totalPenjualan: 0,
    persentasePenjualan: 0,
    totalTransaksi: 0,
    persentaseTransaksi: 0,
    totalProdukTerjual: 0,
    persentaseProduk: 0,
    totalPelangganBaru: 0,
    persentasePelanggan: 0,
};

statistik.value = { ...defaultStatistik, ...statistik.value };

let salesChart = null;
let categoryChart = null;

const initCharts = () => {
    const salesCanvas = document.getElementById("salesChart");
    const categoryCanvas = document.getElementById("categoryChart");

    if (!salesCanvas || !categoryCanvas) {
        error.value = "Elemen chart tidak ditemukan di DOM";
        return;
    }

    try {
        if (salesChart) salesChart.destroy();
        if (categoryChart) categoryChart.destroy();

        salesChart = new Chart(salesCanvas, {
            type: "line",
            data: {
                labels: chartData.value.weeklySales.labels,
                datasets: [{
                    label: "Penjualan",
                    data: chartData.value.weeklySales.data,
                    borderColor: "#2563eb",
                    backgroundColor: "rgba(37, 99, 235, 0.1)",
                    tension: 0.4,
                    fill: true,
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: (value) => `Rp ${new Intl.NumberFormat("id-ID").format(value)}`,
                        },
                    },
                },
            },
        });

        categoryChart = new Chart(categoryCanvas, {
            type: "doughnut",
            data: {
                labels: chartData.value.categories.labels,
                datasets: [{
                    data: chartData.value.categories.data,
                    backgroundColor: ["#2563eb", "#10b981", "#f59e0b", "#6b7280"],
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: "right" },
                },
            },
        });
    } catch (err) {
        error.value = "Gagal menginisialisasi chart: " + err.message;
    }
};

onMounted(() => {
    setTimeout(() => {
        isLoading.value = false;
        // Panggil initCharts setelah DOM diperbarui
        setTimeout(() => initCharts(), 0);
    }, 500);
});

onUnmounted(() => {
    if (salesChart) salesChart.destroy();
    if (categoryChart) categoryChart.destroy();
});

const timeFilter = ref("Minggu");
const toggleTimeFilter = (filter) => {
    timeFilter.value = filter;
    // TODO: Implementasi filter waktu dengan API call jika diperlukan
};

// Watch isLoading untuk memastikan chart diinisialisasi setelah loading selesai
watch(isLoading, (newValue) => {
    if (!newValue) {
        setTimeout(() => initCharts(), 0); // Pastikan DOM sudah diperbarui
    }
});
</script>

<template>
    <DashboardLayout>
        <div v-if="isLoading" class="fixed inset-0 bg-gray-100 bg-opacity-75 flex items-center justify-center z-50">
            <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-blue-500"></div>
        </div>

        <div v-else class="space-y-8">
            <h1 class="text-xl font-semibold text-stone-800 mb-6">Dashboard</h1>

            <div v-if="error" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                {{ error }}
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <div v-for="(stat, key) in [
                    { title: 'Total Penjualan', value: statistik.totalPenjualan, percent: statistik.persentasePenjualan, isCurrency: true },
                    { title: 'Transaksi', value: statistik.totalTransaksi, percent: statistik.persentaseTransaksi },
                    { title: 'Produk Terjual', value: statistik.totalProdukTerjual, percent: statistik.persentaseProduk },
                    { title: 'Pelanggan Baru', value: statistik.totalPelangganBaru, percent: statistik.persentasePelanggan },
                ]" :key="key" class="bg-white rounded-xl p-5 border border-stone-100 hover:shadow-md transition-shadow">
                    <p class="text-sm text-stone-500">{{ stat.title }}</p>
                    <h3 class="text-xl font-bold text-stone-800 mt-1">
                        {{ stat.isCurrency ? "Rp" : "" }} {{ new Intl.NumberFormat("id-ID").format(stat.value) }}
                    </h3>
                    <p class="text-xs mt-2 flex items-center gap-1" :class="stat.percent >= 0 ? 'text-green-600' : 'text-red-600'">
                        <svg v-if="stat.percent >= 0" class="h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                        <svg v-else class="h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" />
                        </svg>
                        {{ Math.abs(stat.percent) }}%
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <div class="bg-white rounded-xl p-6 border border-stone-100">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-base font-semibold text-stone-800">Penjualan Mingguan</h2>
                        <div class="flex gap-2">
                            <button @click="toggleTimeFilter('Minggu')" :class="[timeFilter === 'Minggu' ? 'bg-blue-500 text-white' : 'bg-blue-50 text-blue-600', 'px-2 py-1 text-xs rounded-md hover:bg-blue-100']">
                                Minggu
                            </button>
                            <button @click="toggleTimeFilter('Bulan')" :class="[timeFilter === 'Bulan' ? 'bg-blue-500 text-white' : 'bg-stone-50 text-stone-600', 'px-2 py-1 text-xs rounded-md hover:bg-stone-100']">
                                Bulan
                            </button>
                        </div>
                    </div>
                    <div class="chart-container">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>
                <div class="bg-white rounded-xl p-6 border border-stone-100">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-base font-semibold text-stone-800">Kategori Produk</h2>
                        <button class="px-2 py-1 text-xs bg-stone-50 text-stone-600 rounded-md hover:bg-stone-100">Export</button>
                    </div>
                    <div class="chart-container">
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white rounded-xl p-6 border border-stone-100">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-base font-semibold text-stone-800">Transaksi Terbaru</h2>
                        <a href="#" class="text-sm text-blue-600 hover:underline">Lihat Semua</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="border-b border-stone-100">
                                    <th class="px-3 py-2 text-left text-xs font-medium text-stone-500">ID</th>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-stone-500">Pelanggan</th>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-stone-500">Tanggal</th>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-stone-500">Jumlah</th>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-stone-500">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-stone-100">
                                <tr v-for="transaksi in transaksiTerbaru" :key="transaksi.id" class="hover:bg-stone-50 transition-colors duration-200">
                                    <td class="px-3 py-2 text-stone-600">{{ transaksi.id }}</td>
                                    <td class="px-3 py-2 text-stone-600">{{ transaksi.pelanggan }}</td>
                                    <td class="px-3 py-2 text-stone-600">{{ transaksi.tanggal }}</td>
                                    <td class="px-3 py-2 font-medium text-stone-800">
                                        Rp {{ new Intl.NumberFormat("id-ID").format(transaksi.jumlah) }}
                                    </td>
                                    <td class="px-3 py-2">
                                        <span class="px-2 py-1 text-xs rounded-full" :class="{
                                            'bg-green-100 text-green-700': transaksi.status === 'Completed',
                                            'bg-yellow-100 text-yellow-700': transaksi.status === 'Pending',
                                            'bg-red-100 text-red-700': transaksi.status === 'Cancelled',
                                        }">
                                            {{ transaksi.status }}
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="bg-white rounded-xl p-6 border border-stone-100">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-base font-semibold text-stone-800">Produk Terlaris</h2>
                        <a href="#" class="text-sm text-blue-600 hover:underline">Lihat Semua</a>
                    </div>
                    <div class="space-y-3">
                        <div v-for="produk in produkTerlaris" :key="produk.nama" class="flex items-center p-2 rounded-lg hover:bg-stone-50 transition-colors duration-200">
                            <div class="h-10 w-10 rounded-lg bg-stone-50 flex items-center justify-center mr-3">
                                <svg class="h-5 w-5 text-stone-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-sm font-medium text-stone-800">{{ produk.nama }}</h3>
                                <p class="text-xs text-stone-500">{{ produk.kategori }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-stone-800">
                                    Rp {{ new Intl.NumberFormat("id-ID").format(produk.harga) }}
                                </p>
                                <p class="text-xs text-stone-500">{{ produk.terjual }} terjual</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </DashboardLayout>
</template>

<style scoped>
.chart-container {
    position: relative;
    height: 300px;
    width: 100%;
}
</style>
