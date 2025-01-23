/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./woocommerce/**/*.php",
    "./*.php",
    "./**/*.php", // Incluye subdirectorios
    "./assets/js/**/*.js", // Si usas JavaScript
    "./assets/css/**/*.css", // Tus archivos CSS adicionales
  ],
  theme: {
    extend: {
      colors: {
        verde: "#00b573",
        magenta: "#e52e66",
        negro: "#122636",
        gris: "#ededed"
      },
      fontFamily: {
        ubuntu: ['Ubuntu', 'sans-serif'], // Agregar la fuente Ubuntu
    },
    },
  },
  plugins: [],
};
