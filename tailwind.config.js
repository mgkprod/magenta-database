import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import aspectRatio from '@tailwindcss/aspect-ratio';

const colors = require('tailwindcss/colors')

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',

    content: [
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
        './resources/js/**/*.js',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },

            colors: {
                primary: colors.indigo,
                'gray': {
                    ...colors.neutral,
                    'darkest': '#181818',
                    'darker': '#282828',
                    'dark': '#424242',
                    'default': '#b3b3b3',
                    'light': '#bcbcbc',
                    'lighter': '#d7d8d6',
                    'lightest': '#e9e9e9',
                },

                'white': '#ffffff',
                'black': '#121212',

                // PrimeVue "neutral"
                'neutral': {
                    0: colors.neutral[50],
                    100: colors.neutral[950],
                },
            },

           container: {
                center: true,
                padding: '1rem',
            }
        },
    },

    plugins: [
        aspectRatio
    ],
};
