/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./src/**/*.php",
    ],
    theme: {
        extend: {},
    },
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
        require('autoprefixer'),
    ],
}
