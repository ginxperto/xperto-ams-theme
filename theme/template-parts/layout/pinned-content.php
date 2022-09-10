<?php

/**
 * Template part for displaying the header content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package xperto-ams
 */

?>

<?php
$args = array(
    'post_type' => 'post',
    'post_status' => 'publish',
    'category_name' => 'pinned',
    'posts_per_page' => 5,
);
$arr_posts = new WP_Query($args);

if ($arr_posts->have_posts()) :

    while ($arr_posts->have_posts()) :
        $arr_posts->the_post();
?>
        <article id="post-<?php the_ID(); ?>" <?php post_class('flex flex-col space-y-6 xl:flex-row xl:space-y-0 xl:space-x-3'); ?>>
            <?php
            if (has_post_thumbnail()) :
                $attr = array(
                    'class' => 'object-cover w-full rounded-lg xl:rounded-none xl:w-32 xl:h-24' // tailwind css
                );
                the_post_thumbnail('thumbnail', $attr);
            endif;
            ?>
            <header class="entry-header xl:hidden">
                <h1 class="entry-title text-xperto-neutral-dark-1 font-bold text-2xl m-0"><?php the_title(); ?></h1>
            </header>
            <div class="entry-content font-normal mt-0 flex-1">
                <p class="font-normal m-0 mb-6 xl:mb-3">
                    <?php
                    $excerpt = get_the_excerpt();
                    $excerpt = substr($excerpt, 0, 100); // Only display first 100 characters of excerpt
                    $result = substr($excerpt, 0, strrpos($excerpt, ' '));
                    echo $result;
                    ?>
                </p>
                <a href="<?php the_permalink(); ?>" class="text-xperto-orange font-normal hover:text-xperto-orange-base-20">Read More</a>
            </div>
        </article>
<?php
    endwhile;
endif;
?>