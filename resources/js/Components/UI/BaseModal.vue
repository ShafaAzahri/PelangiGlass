<script setup>
import { onMounted, onUnmounted, watch } from 'vue';

const props = defineProps({
    show: { type: Boolean, default: false },
    maxWidth: { type: String, default: '2xl' }, // 'sm' | 'md' | 'lg' | '2xl' | '4xl'
});

const emit = defineEmits(['close']);

const close = () => emit('close');

const handleKeyDown = (e) => {
    if (e.key === 'Escape' && props.show) {
        close();
    }
};

watch(() => props.show, (val) => {
    if (val) {
        document.body.style.overflow = 'hidden';
    } else {
        document.body.style.overflow = '';
    }
});

onMounted(() => window.addEventListener('keydown', handleKeyDown));
onUnmounted(() => {
    window.removeEventListener('keydown', handleKeyDown);
    document.body.style.overflow = '';
});
</script>

<template>
    <Teleport to="body">
        <Transition
            enter-active-class="transition ease-out duration-200"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition ease-in duration-150"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div v-if="show" class="fixed inset-0 z-50 overflow-y-auto px-4 py-6 sm:px-0 flex items-center justify-center">
                <!-- Backdrop -->
                <div class="fixed inset-0 bg-slate-950/80 backdrop-blur-xs transition-opacity" @click="close" />

                <!-- Modal Dialog -->
                <div
                    class="relative bg-white dark:bg-slate-900 rounded-2xl overflow-hidden shadow-2xl border border-slate-200 dark:border-slate-800 transform transition-all w-full z-10"
                    :class="{
                        'max-w-sm': maxWidth === 'sm',
                        'max-w-md': maxWidth === 'md',
                        'max-w-lg': maxWidth === 'lg',
                        'max-w-2xl': maxWidth === '2xl',
                        'max-w-4xl': maxWidth === '4xl',
                    }"
                >
                    <slot />
                </div>
            </div>
        </Transition>
    </Teleport>
</template>
