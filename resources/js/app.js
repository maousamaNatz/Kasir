import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});

 // Judul Utama dengan background gradasi
 console.log(
    '%c Welcome to LALO SNACK! 🍿',
    'background: linear-gradient(90deg, #4CAF50, #8BC34A); color: white; font-size: 22px; font-weight: bold; padding: 10px 20px; border-radius: 6px;'
  );
  // Informasi Perlindungan Website

  console.log(
    '%c Website ini dilindungi dari serangan XSS, CSRF, SQL Injection, dan skrip berbahaya lainnya.',
    'color: #FF9800; font-size: 16px; padding: 6px;'
  );

  // Pencatatan Aktivitas Mencurigakan
  console.log(
    '%c Setiap aktivitas mencurigakan akan direkam dan dilaporkan kepada pihak berwenang.',
    'color: #FF5722; font-size: 16px; padding: 6px;'
  );

  // Pesan Etika Penggunaan
  console.log(
    '%c Mohon gunakan website ini dengan bijak dan patuhi etika digital 🙏',
    'color: #2196F3; font-size: 16px; padding: 6px;'
  );

  // Peringatan tambahan untuk penyalahgunaan sistem
  console.log(
    '%c Peringatan: Aksi yang berkaitan dengan serangan XSS atau penyalahgunaan sistem lainnya tidak akan ditoleransi.',
    'color: #9C27B0; font-size: 14px; padding: 6px;'
  );
