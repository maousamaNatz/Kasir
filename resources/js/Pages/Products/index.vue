<template>
    <div class="container mx-auto p-4">
      <h1 class="text-2xl font-bold mb-4">Products</h1>
      <Link :href="route('products.create')" class="bg-blue-500 text-white px-4 py-2 rounded">Add Product</Link>
      <table class="min-w-full mt-4">
        <thead>
          <tr>
            <th class="px-4 py-2">Kode Barang</th>
            <th class="px-4 py-2">Nama Barang</th>
            <th class="px-4 py-2">Harga</th>
            <th class="px-4 py-2">Stok</th>
            <th class="px-4 py-2">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="product in products" :key="product.id">
            <td class="border px-4 py-2">{{ product.kode_barang }}</td>
            <td class="border px-4 py-2">{{ product.nama_barang }}</td>
            <td class="border px-4 py-2">{{ product.harga }}</td>
            <td class="border px-4 py-2">{{ product.stok }}</td>
            <td class="border px-4 py-2">
              <Link :href="route('products.edit', product.id)" class="text-blue-500">Edit</Link>
              <button @click="deleteProduct(product.id)" class="text-red-500 ml-2">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </template>

  <script>
  import { Link } from '@inertiajs/vue3';

  export default {
    components: { Link },
    props: {
      products: Array,
    },
    methods: {
      deleteProduct(id) {
        if (confirm('Are you sure?')) {
          this.$inertia.delete(route('products.destroy', id));
        }
      },
    },
  };
  </script>
