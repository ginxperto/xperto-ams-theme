// Set flag to include Preflight conditionally based on the build target.
const includePreflight = ( 'editor' === process.env._TW_TARGET ) ? false : true;

module.exports = {
	presets: [
		// Manage Tailwind Typography's configuration in a separate file.
		require( './tailwind-typography.config.js' ),
	],
	content: [
		// Ensure changes to PHP files and `theme.json` trigger a rebuild.
		'./theme/**/*.php',
		'./theme/theme.json',
	],
	theme: {
		// Extend the default Tailwind theme.
		extend: {
			colors: {
				xpertoOrange: '	hsl(26, 100%, 53%)',
				xpertoNavyBlue: 'hsl(201, 66%, 27%)',
				xpertoOrangeLight90: 'hsl(25, 100%, 95%)',
				xpertoNeutralDark1: 'hsl(0, 0%, 15%)',
				xpertoNeutralMid1: 'hsl(0, 0%, 65%)',
				xpertoSuccessLight80: 'hsl(87, 53%, 93%)'
			},
			boxShadow: {
				'left': '1px 0px 0px rgba(229, 229, 229, 1)'
			}
		},
		screen: {
			sm: '480px',
			md: '768px',
			lg: '976px',
			xl: '1440px'
		}
	},
	corePlugins: {
		// Disable Preflight base styles in CSS targeting the editor.
		preflight: includePreflight,
	},
	plugins: [
		// Add Tailwind Typography.
		require( '@tailwindcss/typography' ),

		// Extract colors and widths from `theme.json`.
		require( '@_tw/themejson' )( require( '../theme/theme.json' ) ),

		// Uncomment below to add additional first-party Tailwind plugins.
		// require( '@tailwindcss/aspect-ratio' ),
		// require( '@tailwindcss/forms' ),
		// require( '@tailwindcss/line-clamp' ),
	],
};
