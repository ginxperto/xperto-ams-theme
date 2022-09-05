<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package xperto-ams
 */

?>


<article id="post-<?php the_ID(); ?>" <?php post_class('bg-white flex flex-col rounded-lg xl:flex-row xl:rounded-none w-full items-stretch'); ?>>
    <?php
    $attr = array(
        'class' => 'w-full rounded-t-lg self-stretch xl:rounded-none xl:w-1/3' // tailwind css
    );
    $img_attr = array(
        'class' => 'object-cover w-full rounded-t-lg self-stretch xl:rounded-none xl:h-full' // tailwind css
    );

    if(has_post_thumbnail()):
        xperto_ams_post_thumbnail($attr, $img_attr);
    else:
        ?>
    <a href="<?php the_permalink(); ?>" class="<?php echo $attr['class']; ?> flex flex-col justify-center items-center bg-gradient-to-t from-xperto-orange to-xperto-orange-base-20 self-stretch">
        <div class="p-10 xl:p-0 xl:min-h-[200px]">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="<?php echo $img_attr['class']; ?> w-20 text-white">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z" />
            </svg>
        </div>
    </a>
    <?php
    endif;
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
