import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/View/Resources/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    darkMode: 'class', // Enable dark mode dengan class
    
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            // 🆕 CUSTOM COLORS COFFEE THEME
            colors: {
                coffee: {
                    50: '#FAFAFA',   // Milk Foam (lightest)
                    100: '#EFEBE9',  // Cream
                    200: '#D7CCC8',  // Light Latte
                    300: '#BCAAA4',  // Latte
                    400: '#A1887F',  // Medium Latte
                    500: '#8D6E63',  // Cappuccino
                    600: '#6D4C41',  // Coffee (main)
                    700: '#5D4037',  // Dark Coffee
                    800: '#4E342E',  // Espresso
                    900: '#3E2723',  // Dark Espresso
                },
                caramel: {
                    400: '#E6B873',
                    500: '#D7A86E',
                    600: '#C89862',
                },
                'black-coffee': '#1A1A1A', // Custom dark mode bg
            },
        },
    },

    plugins: [forms],
};