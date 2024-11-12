import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        screens: {
            'xs': {'min': '360px', 'max': '639px'},
            'sm': {'min': '640px', 'max': '767px'},
            'md': {'min': '768px', 'max': '1023px'},
            'lg': {'min': '1024px', 'max': '1279px'},
            'xl': {'min': '1280px', 'max': '1535px'},
            '2xl': {'min': '1536px'},
            ...defaultTheme.screens,
        },
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            fontSize: {
                xxxs: '.6rem',
                xxs: '.7rem',
            },
            colors: {
                web: {
                    primary: '#23211f',
                    secondary: '#F2BC1B',
                    third: '#8C030E',
                    fourth: '#A67A53',
                    fifth: '#BF8D50',
                },
                admin: {
                    primary: '#0d0d0d',
                    secondary: '#f2d129',
                    third: '#773e02',
                    fourth: '#BFA38A',
                    fifth: '#F2DCEC',
                    green: '#00af70'
                },
            },
        },
    },

    plugins: [
        forms, typography,
        function ({addUtilities}) {
            const newUtilities = {
                '.content-h': {
                    height: 'calc(100vh - 64px)',
                },
                '.h-100vh': {
                    height: '100vh',
                },
                '.w-stock-mobile': {
                    width: 'calc(100% - 75px)',
                },
            };

            addUtilities(newUtilities, ['responsive', 'hover']);
        }
    ],
};
