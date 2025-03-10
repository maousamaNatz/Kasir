<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import { usePage } from '@inertiajs/vue3';
import DashboardLayout from '@/Layouts/Dashboard.Layouts.vue';

export default {
  components: { AppLayout, DashboardLayout },
  props: {
    products: Array,
  },
  data() {
    return {
      cart: [],
      bayar: 0,
    };
  },
  computed: {
    total() {
      return this.cart.reduce((sum, item) => sum + item.subtotal, 0);
    },
  },
  methods: {
    addToCart(product) {
      const existing = this.cart.find(item => item.product_id === product.id);
      if (existing) {
        existing.jumlah++;
        existing.subtotal = existing.jumlah * existing.harga;
      } else {
        this.cart.push({
          product_id: product.id,
          nama_barang: product.nama_barang,
          harga: product.harga,
          jumlah: 1,
          subtotal: product.harga,
        });
      }
    },
    removeFromCart(index) {
      this.cart.splice(index, 1);
    },
    updateSubtotal(index) {
      const item = this.cart[index];
      item.subtotal = item.jumlah * item.harga;
    },
    submitTransaction() {
      if (this.cart.length === 0) {
        alert('Keranjang kosong!');
        return;
      }
      this.$inertia.post(route('cashier.store'), {
        items: this.cart,
        total: this.total,
        bayar: this.bayar,
      });
    },
  },
};
</script>

<template>
  <DashboardLayout>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
          <h2 class="text-2xl font-bold mb-4">Sistem Kasir</h2>

          <!-- Daftar Produk dan Keranjang -->
          <div class="grid grid-cols-2 gap-6">
            <div>
              <h3 class="text-lg font-semibold">Daftar Produk</h3>
              <ul class="mt-2">
                <li v-for="product in products" :key="product.id" class="mb-2">
                  {{ product.nama_barang }} - Rp {{ product.harga }}
                  <button @click="addToCart(product)" class="ml-2 bg-blue-500 text-white px-2 py-1 rounded">Tambah</button>
                </li>
              </ul>
            </div>
            <div>
              <h3 class="text-lg font-semibold">Keranjang</h3>
              <table class="w-full mt-2">
                <thead>
                  <tr>
                    <th>Nama</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Subtotal</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(item, index) in cart" :key="index">
                    <td>{{ item.nama_barang }}</td>
                    <td>
                      <input type="number" v-model="item.jumlah" min="1" class="w-16" @change="updateSubtotal(index)">
                    </td>
                    <td>Rp {{ item.harga }}</td>
                    <td>Rp {{ item.subtotal }}</td>
                    <td>
                      <button @click="removeFromCart(index)" class="text-red-500">Hapus</button>
                    </td>
                  </tr>
                </tbody>
              </table>

              <div class="mt-4">
                <p>Total: Rp {{ total }}</p>
                <label class="block mt-2">Bayar (Tunai):</label>
                <input type="number" v-model="bayar" class="border p-2 w-full" />
                <p v-if="bayar >= total">Kembali: Rp {{ bayar - total }}</p>
              </div>

              <button @click="submitTransaction" class="mt-4 bg-green-500 text-white px-4 py-2 rounded" :disabled="bayar < total">
                Selesaikan Transaksi
              </button>
            </div>
          </div>

          <!-- Tampilkan Struk -->
          <div v-if="$page.props.flash.message && $page.props.flash.message.struk" class="mt-6">
            <h3 class="text-lg font-semibold">Struk Pembayaran</h3>
            <pre class="bg-gray-100 p-4 rounded">{{ $page.props.flash.message.struk }}</pre>
          </div>
        </div>
      </div>
    </div>
  </DashboardLayout>
</template>
