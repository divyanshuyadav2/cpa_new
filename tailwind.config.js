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
                pharma: {
                    navy: '#0b2b30',      // Deep dark forest teal (sidebar background)
                    navyLight: '#143c43', // Selected list item hover teal
                    teal: '#0a6470',      // Medium brand teal
                    mint: '#03c3a5',      // Minty cyan highlight / status icons
                    gold: '#03c3a5',      // Alias to prevent breaking gold references
                    light: '#f1f8f7',     // Ultra light teal background tint
                    accent: '#7c3aed',    // Purple primary actions
                    accentHover: '#6d28d9'// Darker purple hover
                }
            },
            fontFamily: {
                sans: ['Outfit', 'Inter', 'sans-serif'],
            }
        },
    },
    plugins: [],
}
