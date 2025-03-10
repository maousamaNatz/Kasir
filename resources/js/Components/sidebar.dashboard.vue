<script setup>
import { inject } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';

const isSidebarOpen = inject('isSidebarOpen');
const closeSidebar = inject('closeSidebar');
const page = usePage();

// Fungsi untuk memeriksa apakah rute saat ini aktif
const isActiveRoute = (routeName) => {
    return route().current(routeName); // Menggunakan route().current() secara langsung
};
</script>

<template>
    <aside :class="[
        'fixed md:relative inset-y-0 left-0 w-64 bg-white border-r border-stone-200 z-30 transition-transform duration-300',
        isSidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'
    ]">
        <div class="p-5">
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center">
                    <svg class="h-6 w-6 text-blue-600 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    <span class="text-xl font-semibold text-stone-800">KasirKu</span>
                </div>
                <button @click="closeSidebar" class="p-1 rounded-md hover:bg-stone-100 lg:hidden">
                    <svg class="h-5 w-5 text-stone-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <nav>
                <ul class="space-y-2">
                    <li>
                        <Link :href="route('dashboard')" class="flex items-center p-2 rounded-lg"
                            :class="{ 'bg-blue-50 text-blue-600': isActiveRoute('dashboard'), 'text-stone-600 hover:bg-stone-50 transition-colors duration-200': !isActiveRoute('dashboard') }">
                            <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                            </svg>
                            <span class="font-medium">Dashboard</span>
                        </Link>
                    </li>
                    <li>
                        <Link :href="route('products.index')" class="flex items-center p-2 rounded-lg"
                            :class="{ 'bg-blue-50 text-blue-600': isActiveRoute('products.index'), 'text-stone-600 hover:bg-stone-50 transition-colors duration-200': !isActiveRoute('products.index') }">
                            <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            <span class="font-medium">Produk</span>
                        </Link>
                    </li>
                    <li>
                        <Link :href="route('transactions.index')" class="flex items-center p-2 rounded-lg"
                            :class="{ 'bg-blue-50 text-blue-600': isActiveRoute('transactions.index'), 'text-stone-600 hover:bg-stone-50 transition-colors duration-200': !isActiveRoute('transactions.index') }">
                            <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 012-2h2a2 2 0 012 2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            <span class="font-medium">Transaksi</span>
                        </Link>
                    </li>
                    <li>
                        <Link :href="route('reports.index')" class="flex items-center p-2 rounded-lg"
                            :class="{ 'bg-blue-50 text-blue-600': isActiveRoute('reports.index'), 'text-stone-600 hover:bg-stone-50 transition-colors duration-200': !isActiveRoute('reports.index') }">
                            <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            <span class="font-medium">Laporan</span>
                        </Link>
                    </li>
                    <li>
                        <Link :href="route('settings.index')" class="flex items-center p-2 rounded-lg"
                            :class="{ 'bg-blue-50 text-blue-600': isActiveRoute('settings.index'), 'text-stone-600 hover:bg-stone-50 transition-colors duration-200': !isActiveRoute('settings.index') }">
                            <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                            </svg>
                            <span class="font-medium">Pengaturan</span>
                        </Link>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>
</template>
