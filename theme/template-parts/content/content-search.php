<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package xperto-ams
 */

?>


<article id="post-<?php the_ID(); ?>" <?php post_class('w-full bg-white flex flex-col rounded-lg xl:flex-row xl:rounded-none'); ?>>
    <?php
    $attr = array(
        'class' => 'w-full rounded-t-lg self-stretch xl:rounded-none xl:w-1/3' // tailwind css
    );
    $img_attr = array(
        'class' => 'object-cover w-full rounded-t-lg self-stretch xl:rounded-none xl:h-full' // tailwind css
    );

    xperto_ams_post_thumbnail($attr, $img_attr);
    ?>
    <div class="p-5 xl:w-2/3">
        <header>
            <?php
            if ('post' === get_post_type()) :
            ?>
                <div class="mb-4">
                    <span class="text-xperto-neutral-mid-2"> / </span> 
                    <?php
                    xperto_ams_posted_by();
                    xperto_ams_posted_on();
                    ?>
                </div>
            <?php endif; ?>
            <?php
            if (is_singular()) :
                the_title('<h1 class="entry-title text-black text-lg font-bold mb-2 mx-0 hover:text-xperto-orange">', '</h1>');
            else :
                the_title('<h2 class="entry-title text-black text-lg font-bold mb-2 mx-0 hover:text-xperto-orange"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
            endif;
            ?>
            <div class="mb-4">
                <?php xperto_ams_entry_category(); ?>
                <?php xperto_ams_entry_tag(); ?>
            </div>
        </header>

        <div class="entry-content">
            <?php
            $excerpt = get_the_excerpt();
            $excerpt = substr($excerpt, 0, 100); // Only display first 100 characters of excerpt
            $result = substr($excerpt, 0, strrpos($excerpt, ' '));
            echo $result . "...";

            wp_link_pages(
                array(
                    'before' => '<div>' . esc_html__('Pages:', 'xperto-ams'),
                    'after'  => '</div>',
                )
            );
            ?>
        </div>
    </div>
</article><!-- #post-<?php the_ID(); ?> -->
