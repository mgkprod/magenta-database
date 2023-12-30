const { fontFamily } = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors')

module.exports = {
    purge: {
        enabled: true,
        content: [
            "resources/**/*.js",
            "resources/**/*.php",
            "resources/**/*.vue"
        ],
        options: {
            safelist: ["dark"],
        },
    },
    darkMode: 'class',
    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...fontFamily.sans],
            },
            colors: {
                'primary': { ...colors.indigo },
                'gray': {
                    ...colors.trueGray,
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
            }
        },
        container: {
            center: true,
            padding: "1rem",
        },
    },
    variants: {},
    plugins: [
        require('@tailwindcss/aspect-ratio'),
        require('@tailwindcss/forms'),
    ],
};
