<?php

/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package xperto-ams
 */

// force user to login
if (!is_user_logged_in()) {
	wp_redirect(home_url('?loginaction=xpertoOauthLogin'));
	exit();
}

get_header();

$search_val = null;


if (isset($_GET['member_name'])) {
	$search_val = $_GET['member_name'];

}
?>
<main id="primary" class="w-full flex flex-col items-start">
	<div class="container flex flex-col items-start p-4 space-y-6 w-full max-w-[1200px] md:p-8 xl:mx-auto">
		<h3 class="text-4xl text-xperto-neutral-dark-1 font-bold w-full">Members</h3>
		<div class="flex items-start p-6 rounded-lg bg-white w-full">
			<form role="search" method="get" id="search-form" action="<?php echo esc_url(home_url('/members')); ?>" class="flex flex-col-reverse md:space-x-4 md:items-center md:flex-row space-y-0 input-group items-center w-full">
				<div class="w-full flex flex-row items-center space-x-4 mt-4 md:w-auto md:mt-0">
					<span class="">Sort by:</span>
					<select name="order_by" id="members-sort-by" class="block border border-xperto-neutral-light-1 text-sm p-2.5 rounded-lg focus:bg-white focus:ring-xperto-orange-focus focus-visible:outline-xperto-orange-focus">
						<option value="created_at" <?php echo isset($_GET['order_by']) && $_GET['order_by'] == 'created_at' ? 'selected' : ''; ?>>Recently Joined</option>
						<option value="display_name" <?php echo isset($_GET['order_by']) && $_GET['order_by'] == 'display_name' ? 'selected' : ''; ?>>Display Name</option>
					</select>
				</div>
				<div class=" flex flex-1 relative w-full group">
				<input type="search" class="form-control w-full px-4 py-3 bg-xperto-neutral-light-2 text-xperto-neutral-mid-2 text-sm rounded-lg p-2.5 focus:bg-white focus:ring-xperto-orange-focus focus-visible:outline-xperto-orange-focus" placeholder="Search" aria-label="search" name="member_name" id="search-input" value="<?php echo esc_attr($_GET['member_name']); ?>" required minlength="3" />
					<div id="search-icon" class="flex relative px-4 inset-y-0 right-0 items-center pr-3 pointer-events-none group-focus-within:hidden group-focus:hidden">
						<svg aria-hidden="true" class="w-5 h-5 text-xperto-orange" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
							<path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
						</svg>
					</div>
				</div>
			</form>
		</div>
		<!-- toolbar -->
		<?php if (isset($_GET['member_name'])) : ?>
			<h4 class="text-xl text-xperto-neutral-dark-1 w-full">Results for "<?php echo $_GET['member_name'] ?>"</h4>
		<?php endif; ?>
		<?php get_template_part('template-parts/layout/members', 'content'); ?>
	</div>
</main>
<?php
// important to enquque footer js
get_footer();
