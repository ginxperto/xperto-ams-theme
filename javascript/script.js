/**
 * The JavaScript code you place here will be processed by esbuild, and the
 * output file will be created at `../theme/js/script.min.js` and enqueued in
 * `../theme/functions.php`.
 *
 * For esbuild documentation, please see:
 * https://esbuild.github.io/
 */

const btn = document.querySelector("#mobile-menu-button");
const sidebar = document.querySelector("#main-sidebar");
let isSidebarOpen = false;

// add our event listener for the click
btn.addEventListener("click", () => {
	sidebar.classList.toggle("-translate-x-full");
});

// close sidebar if user clicks outside of the sidebar
document.addEventListener("click", (event) => {
	const isButtonClick = btn === event.target || btn.contains(event.target);
	const isOutsideClick =
		sidebar !== event.target && !sidebar.contains(event.target);

	// bail out if sidebar isnt open
	if (sidebar.classList.contains("-translate-x-full")) return;

	// check to see if user clicks outside the sidebar
	if (!isButtonClick && isOutsideClick) {
		sidebar.classList.add("-translate-x-full");
		return;
	}
});

const button = document.querySelector("#user-menu");
const tooltip = document.querySelector("#user-menu-popover");

// add our event listener for the click
button.addEventListener("click", () => {
	// tooltip.classList.toggle("opacity-0 -scale-100");
	tooltip.classList.toggle("hidden");
	tooltip.classList.toggle("flex");
});

document.addEventListener("click", (event) => {
	const isPopupButtonClick =
		button === event.target || button.contains(event.target);
	const isOutsideClick =
		tooltip !== event.target && !tooltip.contains(event.target);

	// bail out if tooltip isnt open
	if (tooltip.classList.contains("hidden")) return;

	// check to see if user clicks outside the tooltip
	if (!isPopupButtonClick && isOutsideClick) {
		tooltip.classList.add("hidden");
		return;
	}
});
