/** @type {import('tailwindcss').Config} */
export default {
    content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme:{
        extend: {
            colors: {
                'primary': '{#ff49db',
                'secondary': '#6b7280',
            },
            
        },

    },
    plugins : [
        require('@tailwindcss/forms'),
    ],
}

