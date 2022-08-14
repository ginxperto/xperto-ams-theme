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
		console.log("outside click");
		sidebar.classList.add("-translate-x-full");
		return;
	}
});

/**
 * Search Input toggles
 */
const searchInput = document.getElementById("search-input");
const searchIcon = document.getElementById("search-icon-right");

searchInput.addEventListener("focus", () => {
	searchIcon.classList.add("hidden");
});

searchInput.addEventListener("input", () => {
	searchIcon.classList.add("hidden");
});

searchInput.addEventListener("focusout", () => {
	searchIcon.classList.remove("hidden");
})
