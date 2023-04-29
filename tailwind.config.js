const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        fontSize: {

            xs: '0.6rem',
            sm:'0.8rem',
            xl: '1.25rem',
            '2xl': '1.563rem',
            '3xl': '1.953rem',
            '4xl': '2.441rem',
            '5xl': '3.052rem',

          },
        screens:{
            'xs':{'min': '360px', 'max': '600px'},
            'sm': {'min': '640px', 'max': '767px'},
            // => @media (min-width: 640px and max-width: 767px) { ... }

            'md': {'min': '768px', 'max': '1023px'},
            // => @media (min-width: 768px and max-width: 1023px) { ... }

            'lg': {'min': '1024px', 'max': '1279px'},
            // => @media (min-width: 1024px and max-width: 1279px) { ... }

            'xl': {'min': '1280px', 'max': '1535px'},
            // => @media (min-width: 1280px and max-width: 1535px) { ... }

            '2xl': {'min': '1536px'},
        },

        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            colors:{
                bg:'#fefbff',
                bg_container:"#dde1ff44",
                btn:'#3854c4',
                link:'#3854c4',
            },
        },
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography'),    require('tailwind-scrollbar')({ nocompatible: true })],
};
