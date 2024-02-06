const defaultTheme = require('tailwindcss/defaultTheme')

/** @type {import('tailwindcss').Config} */
export default {
  darkMode: 'class',
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./vendor/spatie/laravel-support-bubble/config/**/*.php",
    "./vendor/spatie/laravel-support-bubble/resources/views/**/*.blade.php",
  ],
  theme: {
    extend: {
        fontFamily: {
            sans: ['Inter', ...defaultTheme.fontFamily.sans],
        },
        colors: {
            'aluminum': '#f8f8f8',
            'platinum': '#e5e5e5',
            'silver': '#f0f0f0',
            'matte': '#1f1f1f',
            'night': '#141414',
            'gloss': '#262626',
            'flat': '#1a1a1a',
            'blue': {
                DEFAULT: '#0067E0',
                'mid': '#4B9FFF',
                'dark': '#004392',
                'light': '#76B5FF',
            }
        }
    },
  },
  plugins: [
    require('@tailwindcss/typography'),
  ],
}
