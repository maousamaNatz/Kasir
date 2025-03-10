<template>
    <DashboardLayout>
        <div class="container mx-auto p-4">
            <div class="max-w-3xl mx-auto">
                <div class="flex items-center justify-between mb-6">
                    <h1 class="text-2xl font-bold">Tambah Produk Baru</h1>
                    <Link :href="route('products.index')" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded transition-colors duration-200">
                        Kembali
                    </Link>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <form @submit.prevent="submit">
                        <div class="mb-6">
                            <label for="kode_barang" class="block text-sm font-medium text-gray-700 mb-1">Kode Barang</label>
                            <input
                                id="kode_barang"
                                v-model="form.kode_barang"
                                type="text"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                            />
                            <div v-if="form.errors.kode_barang" class="text-red-500 text-sm mt-1">
                                {{ form.errors.kode_barang }}
                            </div>
                        </div>

                        <div class="mb-6">
                            <label for="nama_barang" class="block text-sm font-medium text-gray-700 mb-1">Nama Barang</label>
                            <input
                                id="nama_barang"
                                v-model="form.nama_barang"
                                type="text"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                            />
                            <div v-if="form.errors.nama_barang" class="text-red-500 text-sm mt-1">
                                {{ form.errors.nama_barang }}
                            </div>
                        </div>

                        <div class="mb-6">
                            <label for="harga" class="block text-sm font-medium text-gray-700 mb-1">Harga</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">Rp</span>
                                </div>
                                <input
                                    id="harga"
                                    v-model="form.harga"
                                    type="number"
                                    min="0"
                                    class="pl-12 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                                />
                            </div>
                            <div v-if="form.errors.harga" class="text-red-500 text-sm mt-1">
                                {{ form.errors.harga }}
                            </div>
                        </div>

                        <div class="mb-6">
                            <label for="stok" class="block text-sm font-medium text-gray-700 mb-1">Stok</label>
                            <input
                                id="stok"
                                v-model="form.stok"
                                type="number"
                                min="0"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                            />
                            <div v-if="form.errors.stok" class="text-red-500 text-sm mt-1">
                                {{ form.errors.stok }}
                            </div>
                        </div>

                        <div class="mb-6">
                            <label for="kategori" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                            <input
                                id="kategori"
                                v-model="form.kategori"
                                type="text"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                            />
                            <div v-if="form.errors.kategori" class="text-red-500 text-sm mt-1">
                                {{ form.errors.kategori }}
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button
                                type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md transition-colors duration-200"
                                :disabled="form.processing"
                            >
                                {{ form.processing ? 'Menyimpan...' : 'Simpan Produk' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </DashboardLayout>
</template>

<script setup>
import DashboardLayout from '@/Layouts/Dashboard.Layouts.vue';
import { useForm, Link } from '@inertiajs/vue3';

const form = useForm({
    kode_barang: '',
    nama_barang: '',
    harga: 0,
    stok: 0,
    kategori: '',
});

const submit = () => {
    form.post(route('products.store'));
};
</script>
