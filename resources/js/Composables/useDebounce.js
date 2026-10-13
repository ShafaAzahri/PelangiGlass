import { ref, watch } from 'vue';

export function useDebounce(sourceValue, delay = 300) {
    const debouncedValue = ref(sourceValue.value);
    let timeoutId = null;

    watch(sourceValue, (newVal) => {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => {
            debouncedValue.value = newVal;
        }, delay);
    });

    return debouncedValue;
}
