<script setup>
import { computed, onMounted, onUnmounted, ref, watch } from 'vue';

const props = defineProps({
    align: {
        type: String,
        default: 'right',
        validator: (value) => ['left', 'right', 'center'].includes(value)
    },
    width: {
        type: [String, Number],
        default: '48'
    },
    contentClasses: {
        type: Array,
        default: () => ['py-1', 'bg-white']
    },
    closeOnClickOutside: {
        type: Boolean,
        default: true
    },
    closeOnEsc: {
        type: Boolean,
        default: true
    },
    disabled: {
        type: Boolean,
        default: false
    }
});

const emit = defineEmits(['open', 'close']);

const open = ref(false);
const dropdownRef = ref(null);

// Handle keyboard events
const handleKeydown = (e) => {
    if (!props.closeOnEsc) return;

    if (open.value && e.key === 'Escape') {
        closeDropdown();
    }
};

// Handle click outside
const handleClickOutside = (e) => {
    if (!props.closeOnClickOutside) return;

    if (dropdownRef.value && !dropdownRef.value.contains(e.target)) {
        closeDropdown();
    }
};

const openDropdown = () => {
    if (props.disabled) return;
    open.value = true;
    emit('open');
};

const closeDropdown = () => {
    open.value = false;
    emit('close');
};

const toggleDropdown = () => {
    if (open.value) {
        closeDropdown();
    } else {
        openDropdown();
    }
};

// Lifecycle hooks
onMounted(() => {
    document.addEventListener('keydown', handleKeydown);
    document.addEventListener('click', handleClickOutside);
});

onUnmounted(() => {
    document.removeEventListener('keydown', handleKeydown);
    document.removeEventListener('click', handleClickOutside);
});

// Watch for disabled prop changes
watch(() => props.disabled, (newValue) => {
    if (newValue && open.value) {
        closeDropdown();
    }
});

const widthClass = computed(() => {
    const widthMap = {
        '48': 'w-48',
        '56': 'w-56',
        '64': 'w-64',
        '72': 'w-72'
    };
    return widthMap[props.width.toString()] || `w-[${props.width}px]`;
});

const alignmentClasses = computed(() => {
    const alignMap = {
        'left': 'ltr:origin-top-left rtl:origin-top-right start-0',
        'right': 'ltr:origin-top-right rtl:origin-top-left end-0',
        'center': 'origin-top transform -translate-x-1/2 left-1/2'
    };
    return alignMap[props.align] || 'origin-top';
});

const dropdownClasses = computed(() => {
    return [
        'absolute z-50 mt-2 rounded-md shadow-lg',
        widthClass.value,
        alignmentClasses.value,
        props.disabled ? 'opacity-50 cursor-not-allowed' : ''
    ];
});
</script>

<template>
    <div class="relative" ref="dropdownRef">
        <div @click="toggleDropdown" :class="{ 'cursor-not-allowed': disabled }">
            <slot name="trigger" :open="open" :disabled="disabled" />
        </div>

        <!-- Full Screen Dropdown Overlay -->
        <div v-show="open" class="fixed inset-0 z-40 bg-black/10" @click="closeDropdown" />

        <transition
            enter-active-class="transition ease-out duration-200"
            enter-from-class="transform opacity-0 scale-95"
            enter-to-class="transform opacity-100 scale-100"
            leave-active-class="transition ease-in duration-75"
            leave-from-class="transform opacity-100 scale-100"
            leave-to-class="transform opacity-0 scale-95"
        >
            <div
                v-show="open"
                :class="dropdownClasses"
                style="display: none;"
                @click.stop
            >
                <div
                    class="rounded-md ring-1 ring-black ring-opacity-5"
                    :class="contentClasses"
                >
                    <slot name="content" :close="closeDropdown" />
                </div>
            </div>
        </transition>
    </div>
</template>
