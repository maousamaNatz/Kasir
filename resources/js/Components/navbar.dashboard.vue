<script setup>
import { ref, inject, onMounted, onUnmounted } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';

const isSidebarOpen = inject('isSidebarOpen');
const toggleSidebar = inject('toggleSidebar');
const isDropdownOpen = ref(false);

// Mengambil data user dari Inertia
const user = usePage().props.auth.user;

const toggleDropdown = () => {
    isDropdownOpen.value = !isDropdownOpen.value;
};

const closeDropdown = (event) => {
    // Jika klik di luar dropdown, tutup dropdown
    const dropdown = document.getElementById('userDropdown');
    const dropdownMenu = document.getElementById('userMenu');

    if (dropdown && dropdownMenu && !dropdown.contains(event.target) && !dropdownMenu.contains(event.target)) {
        isDropdownOpen.value = false;
    }
};

// Fungsi untuk logout
const logout = () => {
    router.post(route('logout'));
};

// Tambahkan event listener untuk klik di luar
onMounted(() => {
    document.addEventListener('click', closeDropdown);
});

onUnmounted(() => {
    document.removeEventListener('click', closeDropdown);
});
</script>

<template>
    <header class="bg-white border-b border-stone-200 sticky top-0 z-20">
        <div class="px-4 py-3 flex items-center justify-between">
            <button @click="toggleSidebar" class="lg:hidden p-2 rounded-md hover:bg-stone-100">
                <svg class="h-6 w-6 text-stone-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
            <div class="relative ml-auto">
                <button id="userDropdown" @click.stop="toggleDropdown" class="flex items-center gap-2 p-2 rounded-lg hover:bg-stone-100 transition-colors duration-200">
                    <span class="text-stone-700 font-medium hidden sm:inline">{{ user.name }}</span>
                    <div class="h-8 w-8 rounded-full overflow-hidden bg-blue-100 flex items-center justify-center">
                        <img v-if="user.profile_photo_url" :src="user.profile_photo_url" alt="Profile Photo" class="h-8 w-8 object-cover">
                        <svg v-else class="h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </button>
                <div id="userMenu" v-show="isDropdownOpen" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 border border-stone-100 z-50 transition-all duration-200 transform origin-top-right">
                    <Link :href="route('profile.show')" class="block px-4 py-2 text-sm text-stone-700 hover:bg-stone-50 transition-colors duration-200">
                        Profil
                    </Link>
                    <Link v-if="$page.props.jetstream.hasApiFeatures" :href="route('api-tokens.index')" class="block px-4 py-2 text-sm text-stone-700 hover:bg-stone-50 transition-colors duration-200">
                        API Tokens
                    </Link>
                    <hr class="my-1 border-stone-100">
                    <button @click="logout" class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-stone-50 transition-colors duration-200">
                        Logout
                    </button>
                </div>
            </div>
        </div>
    </header>
</template>
