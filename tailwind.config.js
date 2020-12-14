const { fontFamily } = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors')

module.exports = {
    purge: {
        // enabled: true,
        content: [
            "app/**/*.php",
            "resources/**/*.html",
            "resources/**/*.js",
            "resources/**/*.jsx",
            "resources/**/*.ts",
            "resources/**/*.tsx",
            "resources/**/*.php",
            "resources/**/*.vue",
            "resources/**/*.twig",
        ],
        options: {
            // defaultExtractor: (content) => content.match(/[\w-/.:]+(?<!:)/g) || [],
            whitelistPatterns: [/-active$/, /-enter$/, /-leave-to$/, /show$/],
        },
    },
    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter var', ...fontFamily.sans],
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
    ],
};
