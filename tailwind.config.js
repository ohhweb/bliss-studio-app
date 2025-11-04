const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
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
            // --- ADD THIS CUSTOM COLOR PALETTE ---
            colors: {
                'primary': '#111827',   // Dark blue-gray for backgrounds
                'secondary': '#1F2937', // Slightly lighter gray for cards
                'accent': '#FB8C00',    // Golden-orange for buttons and highlights
            },
        },
    },

    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/aspect-ratio'),
        require('tailwind-scrollbar-hide'),
    ],
};