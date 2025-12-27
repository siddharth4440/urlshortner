module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./node_modules/flowbite/**/*.js" // Add this line
  ],
  theme: {
    extend: {},
  },
  plugins: [
    require('flowbite/plugin') // Add this line
  ],
};
