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
    },
  },
  plugins: [
    //
  ],
}
