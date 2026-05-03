import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // Brand - Primary (Eco)
                eco: {
                    50: '#D1FAE5',
                    200: '#6EE7B7',
                    500: '#10B981',
                    DEFAULT: '#059669', // 600
                    700: '#047857',
                    800: '#065F46',
                },
                // Brand - Secondary (Finance)
                finance: {
                    50: '#DBEAFE',
                    200: '#93C5FD',
                    500: '#3B82F6',
                    DEFAULT: '#2563EB', // 600
                    700: '#1D4ED8',
                    800: '#1E40AF',
                },
                // Brand - Accent (Reward)
                reward: {
                    50: '#EDE9FE',
                    200: '#C4B5FD',
                    400: '#8B5CF6',
                    DEFAULT: '#7C3AED', // 600
                    700: '#6D28D9',
                    800: '#4C1D95',
                },
                // Semantic - Warning
                warning: {
                    50: '#FFF7ED',
                    DEFAULT: '#EA580C',
                    700: '#C2410C',
                    800: '#9A3412',
                },
            },
        },
    },
    plugins: [forms],
};