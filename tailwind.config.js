import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';
import plugin from 'tailwindcss/plugin';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [
        forms,
        typography,

        // Clases para field-sizing (incluido en v4 pero no en esta v3 de tailwind)
        plugin(({ addUtilities }) => {
        addUtilities({
            '.field-sizing-content': { 'field-sizing': 'content' },
            '.field-sizing-fixed':   { 'field-sizing': 'fixed' },
        });
        }),
    ],
};
