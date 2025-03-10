<template>
    <div class="flex min-h-screen bg-gray-50">
        <div v-if="isSidebarOpen" @click="closeSidebar" class="fixed inset-0 bg-black bg-opacity-30 z-20 lg:hidden transition-opacity duration-300"></div>
        <sidebar :is-open="isSidebarOpen" @toggle-sidebar="toggleSidebar" />
        <div class="flex-1 flex flex-col w-full">
            <navbar :is-open="isSidebarOpen" @toggle-sidebar="toggleSidebar" />
            <main class="flex-1 p-5 lg:p-8">
                <slot />
            </main>
        </div>
    </div>
</template>

<script setup>
import { ref, provide } from 'vue';
import sidebar from '@/Components/sidebar.dashboard.vue';
import navbar from '@/Components/navbar.dashboard.vue';

const isSidebarOpen = ref(false);

const toggleSidebar = () => {
    isSidebarOpen.value = !isSidebarOpen.value;
};

const closeSidebar = () => {
    isSidebarOpen.value = false;
};

// Menyediakan state untuk komponen child
provide('isSidebarOpen', isSidebarOpen);
provide('toggleSidebar', toggleSidebar);
provide('closeSidebar', closeSidebar);

</script>
