/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./app/views/**/*.php", "./app/views/*.php"],
  theme: {
    extend: {
      colors: {
        blush: {
          50: '#fff8f8',
          100: '#fff1f2',
          200: '#ffe0e3',
          300: '#ffc5cc',
          400: '#ff9aa4',
        },
        coral: {
          DEFAULT: '#C41E3A',
          hover: '#A61530',
          light: '#E8344F',
          50: '#FFF1F3',
          100: '#FFE0E4',
          200: '#FFC5CC',
        },
        raspberry: {
          DEFAULT: '#bf4c7d',
          800: '#993a62',
        },
        charcoal: {
          DEFAULT: '#1a1a1a',
          light: '#555555',
        },
        // Legacy fallbacks for admin pages
        gold: {
          50: '#fffbeb',
          500: '#f59e0b',
          600: '#d97706',
          DEFAULT: '#C41E3A',
        },
        forest: {
          600: '#16a34a',
          700: '#15803d',
          800: '#166534',
          DEFAULT: '#1a1a1a',
        },
        ink: {
          DEFAULT: '#1a1a1a',
        },
        paper: {
          DEFAULT: '#ffffff',
        }
      },
      fontFamily: {
        serif: ['Playfair Display', 'Georgia', 'serif'],
        sans: ['Montserrat', 'Arial', 'sans-serif'],
        script: ['"Great Vibes"', 'cursive'],
      },
      boxShadow: {
        'soft': '0 10px 40px -10px rgba(0,0,0,0.08)',
        'card': '0 2px 20px rgba(0,0,0,0.06)',
      },
      borderRadius: {
        'none': '0px',
      },
      keyframes: {
        'slide-up': {
          '0%': { transform: 'translateY(20px)', opacity: '0' },
          '100%': { transform: 'translateY(0)', opacity: '1' },
        },
        'fade-in': {
          '0%': { opacity: '0' },
          '100%': { opacity: '1' },
        },
        'marquee': {
          '0%': { transform: 'translateX(0%)' },
          '100%': { transform: 'translateX(-50%)' },
        }
      },
      animation: {
        'slide-up': 'slide-up 0.6s ease-out',
        'fade-in': 'fade-in 0.4s ease-out',
        'marquee': 'marquee 30s linear infinite',
      }
    },
  },
  plugins: [],
}
