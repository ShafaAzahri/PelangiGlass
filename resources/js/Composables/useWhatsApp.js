import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

export function useWhatsApp() {
    const page = usePage();

    const cleanNumber = computed(() => {
        return page.props.contact?.whatsapp || '6281390288875';
    });

    const displayPhone = computed(() => {
        return page.props.contact?.phone_display || '0813-9028-8875';
    });

    const buildUrl = (message = '') => {
        const text = encodeURIComponent(message || 'Halo Pelangi Glass, saya ingin konsultasi.');
        return `https://wa.me/${cleanNumber.value}?text=${text}`;
    };

    const bookingUrl = (serviceName = '') => {
        const msg = serviceName
            ? `Halo Pelangi Glass, saya ingin booking layanan: ${serviceName}.`
            : 'Halo Pelangi Glass, saya ingin booking jadwal service.';
        return buildUrl(msg);
    };

    const productInquiryUrl = (productName = '') => {
        const msg = `Halo Pelangi Glass, apakah produk "${productName}" tersedia untuk mobil saya?`;
        return buildUrl(msg);
    };

    return { cleanNumber, displayPhone, buildUrl, bookingUrl, productInquiryUrl };
}
