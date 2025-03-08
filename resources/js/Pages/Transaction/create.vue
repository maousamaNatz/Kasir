<template>
    <div class="container mx-auto p-4">
      <h1 class="text-2xl font-bold mb-4">Create Transaction</h1>
      <form @submit.prevent="submit">
        <div class="mb-4">
          <label>User</label>
          <select v-model="form.user_id" class="border p-2 w-full">
            <option v-for="user in users" :key="user.id" :value="user.id">{{ user.name }}</option>
          </select>
        </div>
        <div v-for="(detail, index) in form.details" :key="index" class="mb-4 flex">
          <select v-model="detail.product_id" class="border p-2 w-1/2 mr-2">
            <option v-for="product in products" :key="product.id" :value="product.id">{{ product.nama_barang }}</option>
          </select>
          <input v-model="detail.jumlah" type="number" class="border p-2 w-1/2" placeholder="Jumlah" />
          <button type="button" @click="removeDetail(index)" class="ml-2 text-red-500">Remove</button>
        </div>
        <button type="button" @click="addDetail" class="bg-green-500 text-white px-4 py-2 rounded mb-4">Add Item</button>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save</button>
      </form>
    </div>
  </template>

  <script>
  export default {
    props: {
      products: Array,
      users: Array,
    },
    data() {
      return {
        form: {
          user_id: '',
          details: [{ product_id: '', jumlah: 1 }],
        },
      };
    },
    methods: {
      addDetail() {
        this.form.details.push({ product_id: '', jumlah: 1 });
      },
      removeDetail(index) {
        this.form.details.splice(index, 1);
      },
      submit() {
        this.$inertia.post(route('transactions.store'), this.form);
      },
    },
  };
  </script>
