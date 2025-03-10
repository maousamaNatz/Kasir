<template>
    <DashboardLayout>
        <div class="container mx-auto p-4">
            <div v-if="$page.props.flash && $page.props.flash.message" :class="`mb-4 p-4 rounded ${$page.props.flash.message.type === 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'}`">
                {{ $page.props.flash.message.text }}
            </div>

            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold">Daftar Produk</h1>
                <Link :href="route('products.create')" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded transition-colors duration-200">
                    Tambah Produk Baru
                </Link>
            </div>

            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode Barang</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Barang</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stok</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="product in products" :key="product.id" class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ product.kode_barang }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ product.nama_barang }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rp {{ formatCurrency(product.harga) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ product.stok }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ product.kategori }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <Link :href="route('products.edit', product.id)" class="text-blue-600 hover:text-blue-900 mr-4">Edit</Link>
                                <button @click="deleteProduct(product.id)" class="text-red-600 hover:text-red-900">Hapus</button>
                            </td>
                        </tr>
                        <tr v-if="products.length === 0">
                            <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">Tidak ada produk yang tersedia</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </DashboardLayout>
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3';
import DashboardLayout from '@/Layouts/Dashboard.Layouts.vue';

const props = defineProps({
    products: Array,
});

const formatCurrency = (value) => {
    return new Intl.NumberFormat('id-ID').format(value);
};

const deleteProduct = (id) => {
    if (confirm('Apakah Anda yakin ingin menghapus produk ini?')) {
        router.delete(route('products.destroy', id));
    }
};
</script>
