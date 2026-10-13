import { ref } from 'vue';

const isDark = ref(false);

export function useTheme() {
    const initTheme = () => {
        try {
            const saved = localStorage.getItem('theme');
            if (saved === 'dark' || (!saved && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                isDark.value = true;
                document.documentElement.classList.add('dark');
            } else {
                isDark.value = false;
                document.documentElement.classList.remove('dark');
            }
        } catch (e) {
            console.warn('LocalStorage error reading theme:', e);
        }
    };

    const toggleTheme = () => {
        const nextValue = !isDark.value;
        const targetTheme = nextValue ? 'dark' : 'light';

        const apply = () => {
            isDark.value = nextValue;
            if (nextValue) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
            try {
                localStorage.setItem('theme', targetTheme);
            } catch (e) {}
        };

        if (document.startViewTransition) {
            document.documentElement.setAttribute('data-theme-transition', nextValue ? 'to-dark' : 'to-light');
            document.startViewTransition(apply);
        } else {
            apply();
        }
    };

    return { isDark, initTheme, toggleTheme };
}
