const defaultTheme = require('tailwindcss/defaultTheme')

module.exports = {
    content: [
      './views/**/*.twig',
      './blocks/**/*.twig',
      './blocks/**/*.php',
      './functions/**/*.php',
      './patterns/**/*.php',
    ],
    media: false, // or 'media' or 'class'
    theme: {
      extend: {
        fontFamily: {
          'poppins': [
            '"Poppins"',
            ...defaultTheme.fontFamily.sans,
          ],
          'trenda': [
            '"TrendaIGDisplay-Regular"',
            ...defaultTheme.fontFamily.sans,
          ],
          'trenda-light': [
            '"TrendaIGDisplay-Light"',
            ...defaultTheme.fontFamily.sans,
          ],
          'trenda-semibold': [
            '"TrendaIGDisplay-Semibold"',
            ...defaultTheme.fontFamily.sans,
          ],
          'trenda-bold': [
            '"TrendaIGDisplay-Bold"',
            ...defaultTheme.fontFamily.sans,
          ],
        },
        colors: {
          "primary": '#00283c',
          "secondary": '#ff0069', // not accessible on white ( 3.84 : 1 )
          "tertiary": '#ffd602',
          "accent": '#00d6e6',
          "grey": '#f2f2f2',
          "grey-dark": '#555',
          "black": '#000',
          "white": '#FFF',
          "light-blue": '#b4e3e5',

          // From original site
          // "link": '#007a82',
          "link-hover": '#e80060',
          "link-hover-reverse": '#00dae8',

          "error": '#c02b0a',

          // From Zeplin
          "link": '#0061f3',
          "family-blue": '#00d6f2',
        }
      },
    },
    variants: {
      extend: {},
    },
    plugins: [
      require('@tailwindcss/typography'),
    ],
}
