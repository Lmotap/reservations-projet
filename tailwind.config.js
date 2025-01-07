module.exports = {
    content: [
      "./app/**/*.{php,html,js}"
    ],
    theme: {
      extend: {
        colors: {
          black: '#333333',
          white: '#ffffff',
          lightgray: '#f5f5f5',
          mediumgray: '#cccccc',
          darkgray: '#4a4a4a',
        },
        fontFamily: {
          'sans': ['Montserrat', 'Helvetica', 'sans-serif']
        }
      }
    },
    plugins: [
      require('@tailwindcss/forms')
    ],
}