module.exports = {
  purge: [
    './storage/framework/views/*.php',
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],
  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {
      container: {
        center: true,
        padding: '2rem',
      },
      minHeight: {
        '5': '6.25rem',
        '0': '0',
        '1/4': '25%',
        '1/2': '50%',
        '3/4': '75%',
        'full': '100%',
      },
      height: {
        'fit': 'fit-content'
      },
      width: {
        'fit': 'fit-content'
      },
      maxHeight: {
        '75': '75vh'
      },
    },
  },
  variants: {
    extend: {
      backgroundColor: ['disabled']
    },
  },
  plugins: [],
}
