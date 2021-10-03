module.exports = {
  purge: { content: ["./public/**/*.html", "./src/**/*.vue"] },
  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {
      minWidth: {
        '8': '2rem',
      }
    },
  },
  variants: {
    extend: {},
  },
  plugins: [],
};
