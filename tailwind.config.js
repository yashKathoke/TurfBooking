/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [/** @type {import('tailwindcss').Config} */
    module.exports = {
      content: ["*.html"],
      theme: {
        extend: {},
      },
      plugins: [],
    }],
  theme: {
    extend: {},
  },
  plugins: [],
}




module.exports = {
  theme: {
    extend: {
      keyframes: {
        slideUp: {
          '0%': { transform: 'translateY(100%)', opacity: '0' },
          '100%': { transform: 'translateY(0)', opacity: '1' },
        },
      },
      animation: {
        slideUp1: 'slideUp 1s ease-out forwards',
        slideUp2: 'slideUp 2s ease-out forwards 1s',  // Starts after 1 second
        slideUp3: 'slideUp 3s ease-out forwards 2s',  // Starts after 2 seconds
        slideUp4: 'slideUp 4s ease-out forwards 3s',  // Starts after 3 seconds
      },
    },
  },
  plugins: [],
};



