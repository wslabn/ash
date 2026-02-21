/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        'mary-kay-pink': '#E91E63',
        'purple-accent': '#9C27B0',
      },
    },
  },
  plugins: [],
}
