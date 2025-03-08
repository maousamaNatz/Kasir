<template>
    <div class="container mx-auto p-4">
      <h1 class="text-2xl font-bold mb-4">Edit Product</h1>
      <form @submit.prevent="submit">
        <div class="mb-4">
          <label>Kode Barang</label>
          <input v-model="form.kode_barang" type="text" class="border p-2 w-full" />
        </div>
        <div class="mb-4">
          <label>Nama Barang</label>
          <input v-model="form.nama_barang" type="text" class="border p-2 w-full" />
        </div>
        <div class="mb-4">
          <label>Harga</label>
          <input v-model="form.harga" type="number" class="border p-2 w-full" />
        </div>
        <div class="mb-4">
          <label>Stok</label>
          <input v-model="form.stok" type="number" class="border p-2 w-full" />
        </div>
        <div class="mb-4">
          <label>Kategori</label>
          <input v-model="form.kategori" type="text" class="border p-2 w-full" />
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
      </form>
    </div>
  </template>

  <script>
  export default {
    props: {
      product: Object,
    },
    data() {
      return {
        form: { ...this.product },
      };
    },
    methods: {
      submit() {
        this.$inertia.put(route('products.update', this.product.id), this.form);
      },
    },
  };
  </script>
