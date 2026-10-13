<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import Badge from '@/Components/UI/Badge.vue';
import { useWhatsApp } from '@/Composables/useWhatsApp';

const props = defineProps({
    service: {
        type: Object,
        required: true,
    },
});

const { bookingUrl } = useWhatsApp();

const serviceTitle = computed(() => props.service.name || props.service.title || '');
const categoryTitle = computed(() => props.service.category?.name || props.service.category || 'Layanan');
const serviceDescription = computed(() => props.service.short_description || props.service.description || props.service.desc || '');
const estimatedDuration = computed(() => props.service.duration_estimate || props.service.estimated_duration || '1-3 Jam');

const imageUrl = computed(() => {
    if (props.service.image_url) return props.service.image_url;
    if (props.service.img) return props.service.img;
    if (props.service.image_path) {
        return props.service.image_path.startsWith('http')
            ? props.service.image_path
            : `/storage/${props.service.image_path.replace(/^\/+/, '')}`;
    }
    return 'https://images.unsplash.com/photo-1618934116136-16d28f184b10?w=600&h=400&fit=crop&auto=format';
});

const badgeValue = computed(() => {
    return props.service.badge?.value || props.service.badge || (props.service.warranty_period ? 'Bergaransi' : null);
});
</script>

<template>
    <div class="rounded-2xl overflow-hidden transition-all duration-300 group flex flex-col h-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xs hover:border-blue-300 dark:hover:border-blue-700 hover:-translate-y-1 hover:shadow-md">
        <!-- Top Image Cover -->
        <Link :href="`/servis/${service.slug || service.id}`" class="relative overflow-hidden block shrink-0 h-[180px] bg-slate-100 dark:bg-slate-800">
            <img
                :src="imageUrl"
                :alt="serviceTitle"
                loading="lazy"
                decoding="async"
                @error="$event.target.src = 'https://images.unsplash.com/photo-1618934116136-16d28f184b10?w=600&h=400&fit=crop&auto=format'"
                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
            >
            <Badge v-if="badgeValue" :type="badgeValue" variant="corner" />
        </Link>

        <!-- Content -->
        <div class="p-5 flex flex-col flex-1">
            <!-- Top Category & Duration -->
            <div class="flex items-center justify-between gap-2 mb-1.5">
                <span class="text-xs font-semibold text-blue-600 dark:text-blue-400">
                    {{ categoryTitle }}
                </span>
                <span class="inline-flex items-center gap-1 text-[11px] font-medium text-slate-500 dark:text-slate-400 bg-slate-100 dark:bg-slate-800 px-2 py-0.5 rounded-md">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M12 6v6l4 2"/>
                    </svg>
                    <span>{{ estimatedDuration }}</span>
                </span>
            </div>

            <!-- Service Title -->
            <Link :href="`/servis/${service.slug || service.id}`" class="no-underline text-slate-900 dark:text-slate-100 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                <h3 class="font-bold text-slate-900 dark:text-slate-100 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition text-[0.95rem] leading-snug line-clamp-2 mb-2">
                    {{ serviceTitle }}
                </h3>
            </Link>

            <!-- Service Description -->
            <p class="text-xs leading-relaxed text-slate-500 dark:text-slate-400 line-clamp-3 mb-5">
                {{ serviceDescription }}
            </p>

            <!-- Action Links -->
            <div class="mt-auto pt-3 border-t border-slate-100 dark:border-slate-800/80 flex items-center justify-between gap-3">
                <Link
                    :href="`/servis/${service.slug || service.id}`"
                    class="text-xs font-semibold text-slate-700 dark:text-slate-300 hover:text-blue-600 dark:hover:text-blue-400 inline-flex items-center gap-1 no-underline transition-colors"
                >
                    <span>Lihat Detail</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/>
                    </svg>
                </Link>

                <a
                    :href="bookingUrl(serviceTitle)"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold no-underline shadow-xs hover:shadow-sm transition-all active:scale-95"
                >
                    <span>Booking</span>
                </a>
            </div>
        </div>
    </div>
</template>
