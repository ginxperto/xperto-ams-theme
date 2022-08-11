// Set flag to include Preflight conditionally based on the build target.
const includePreflight = ('editor' === process.env._TW_TARGET) ? false : true;

module.exports = {
	presets: [
		// Manage Tailwind Typography's configuration in a separate file.
		require('./tailwind-typography.config.js'),
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
				'xperto-orange': '	hsl(26, 100%, 53%)',
				'xperto-navy-blue': 'hsl(201, 66%, 27%)',
				'xperto-orange-base-20': 'hsl(26, 100%, 63%)',
				'xperto-orange-base-plus-10': 'hsl(26, 88%, 48%)',
				'xperto-orange-light-90': 'hsl(25, 100%, 95%)',
				'xperto-neutral-light-2': 'hsl(0, 0%, 96%)',
				'xperto-neutral-mid-1': 'hsl(0, 0%, 65%)',
				'xperto-neutral-dark-1': 'hsl(0, 0%, 15%)',
				'xperto-success-base': 'hsl(85, 53%, 50%)',
				'xperto-success-light-80': 'hsl(87, 53%, 93%)',
			},
			boxShadow: {
				'right': '1px 0px 0px rgba(229, 229, 229, 1)',
				'bottom': '0px 1px 0px rgba(229, 229, 229, 1)'
			},
			backgroundImage: {
				'xperto-custom-header': 'linear-gradient(360deg, #262626 0%, rgba(38, 38, 38, 60%) 43.96%)'
			}
		},
		screens: {
			sm: '576px',
			md: '768px',
			lg: '992px',
			xl: '1200px'
		},
		aspectRatio: {
			'3/1': '3 / 1',
		}
	},
	corePlugins: {
		// Disable Preflight base styles in CSS targeting the editor.
		preflight: includePreflight,
		container: false
	},
	plugins: [
		// Add Tailwind Typography.
		require('@tailwindcss/typography'),

		// Extract colors and widths from `theme.json`.
		require('@_tw/themejson')(require('../theme/theme.json')),

		// Uncomment below to add additional first-party Tailwind plugins.
		require('@tailwindcss/aspect-ratio'),
		// require( '@tailwindcss/forms' ),
		// require( '@tailwindcss/line-clamp' ),
		function ({ addComponents }) {
			addComponents({
				'.container': {
					maxWidth: '100%',
					'@screen sm': {
						maxWidth: '576px',
					},
					'@screen md': {
						maxWidth: '768px',
					},
					'@screen lg': {
						maxWidth: '992px',
					},
					'@screen xl': {
						maxWidth: '1200px',
					},
				}
			})
		}
	],
};
