<template>
    <div class="container mx-auto p-4">
      <h1 class="text-2xl font-bold mb-4">Transactions</h1>
      <Link :href="route('transactions.create')" class="bg-blue-500 text-white px-4 py-2 rounded">Add Transaction</Link>
      <table class="min-w-full mt-4">
        <thead>
          <tr>
            <th class="px-4 py-2">Kode Transaksi</th>
            <th class="px-4 py-2">User</th>
            <th class="px-4 py-2">Total</th>
            <th class="px-4 py-2">Status</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="transaction in transactions" :key="transaction.id">
            <td class="border px-4 py-2">{{ transaction.kode_transaksi }}</td>
            <td class="border px-4 py-2">{{ transaction.user.name }}</td>
            <td class="border px-4 py-2">{{ transaction.total }}</td>
            <td class="border px-4 py-2">{{ transaction.status }}</td>
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
      transactions: Array,
    },
  };
  </script>
