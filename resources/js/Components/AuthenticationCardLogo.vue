<script setup>
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const logo = ref('KasirKu');
</script>

<template>
    <Link :href="'/'">
        <h1 class="text-2xl font-bold">{{ logo }}</h1>
    </Link>
</template>
