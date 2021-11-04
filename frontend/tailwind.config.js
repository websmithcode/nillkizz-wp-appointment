module.exports = {
  purge: { content: ["./public/**/*.html", "./src/**/*.vue"] },
  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {
      colors: {
        primary: '#04a7bd',
        secondary: '#005b6a'
      },
      minWidth: {
        8: "2rem",
      },
    },
  },
  variants: {
    extend: {},
  },
  plugins: [],
};
