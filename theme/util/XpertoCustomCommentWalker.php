<?php

if (!class_exists('XpertoCustomCommentWalker')) {
    class XpertoCustomCommentWalker extends Walker_Comment
    {
        public function start_el(&$output, $comment, $depth = 0, $args = array(), $id = 0)
        {
            // Our custom 'xperto' comment format
            if ('xperto' === $args['format']) {
                $depth++;
                $GLOBALS['comment_depth'] = $depth;
                $GLOBALS['comment'] = $comment;

                // Start output buffering
                ob_start();

                // Let's use the native html5 comment template
                $this->html5_comment($comment, $depth, $args);

                // Our modifications (wrap <time> with <span>)
                $output .= str_replace(
                    ['<time ', '</time>'],
                    ['<span><time ', '</time></span>'],
                    ob_get_clean()
                );
            } else {
                // Fallback for the native comment formats
                parent::start_el($output, $comment, $depth, $args, $id);
            }
        }

        /**
         * Output a comment in the HTML5 format.
         *
         * @access protected
         * @since 3.6.0
         *
         * @see wp_list_comments()
         *
         * @param object $comment Comment to display.
         * @param int    $depth   Depth of comment.
         * @param array  $args    An array of arguments.
         */
        protected function html5_comment($comment, $depth, $args)
        {
            $tag = ('div' === $args['style']) ? 'div' : 'li';
            $mepr_user = null;

            // if its already loaded
            if (class_exists('MeprUser')) :
                $rc = new ReflectionClass('MeprUser');

                // instantiate via reflection
                $mepr_user = $rc->newInstanceArgs(array($comment->user_id));
            endif;
?>
            <<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class($this->has_children ? 'parent' : '', $comment); ?>>
                <article id="div-comment-<?php comment_ID(); ?>" class="comment-body group">
                    <footer class="comment-meta">
                        <div class="comment-author vcard flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <?php
                                // * OUR ENHANCEMENT

                                // we have a memberpress user loaded
                                if ($mepr_user && (get_class($mepr_user) === MeprUser::class)) {
                                    // get custom fields
                                    $profile = $mepr_user->custom_profile_values();
                                    // load only if exists
                                    if (!empty($profile['mepr_profile_picture'])) { ?>
                                        <img src="<?php echo $profile['mepr_profile_picture']; ?>" class="rounded-full border border-xperto-neutral-light-1 w-14 h-14 inline-block" />
                                    <?php
                                    } else {
                                        // else get default avater as fallback
                                        echo get_avatar($mepr_user->ID, 56, '', 'avatar', array('class' => 'rounded-full inline-block'));
                                    }
                                } else {
                                    // else get default avater as fallback
                                    ?>
                                    <?php if (0 != $args['avatar_size']) echo get_avatar($comment, $args['avatar_size']); ?>
                                <?php } ?>
                            </div>
                            <div class="flex-1 min-w-0">
                                <?php printf(__('%s'), sprintf('<b class="fn">%s</b>', get_comment_author_link($comment))); ?>

                                <div class="comment-metadata text-xperto-neutral-mid-1">
                                    <a href="<?php echo esc_url(get_comment_link($comment, $args)); ?>" class="hover:text-xperto-orange">
                                        <time datetime="<?php comment_time('c'); ?>">
                                            <?php
                                            /* translators: 1: comment date, 2: comment time */
                                            printf(__('%1$s at %2$s'), get_comment_date('', $comment), get_comment_time());
                                            ?>
                                        </time>
                                    </a>
                                    <?php edit_comment_link(__('Edit'), '<span class="text-xperto-orange hover:text-xperto-orange xl:hidden edit-link group-hover:inline-block">', '</span>'); ?>
                                </div><!-- .comment-metadata -->
                            </div>
                        </div><!-- .comment-author -->

                        <?php if ('0' == $comment->comment_approved) : ?>
                            <p class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.'); ?></p>
                        <?php endif; ?>
                    </footer><!-- .comment-meta -->

                    <div class="comment-content py-4 text-black">
                        <?php comment_text(); ?>
                    </div><!-- .comment-content -->

                    <?php
                    comment_reply_link(array_merge($args, array(
                        'add_below' => 'div-comment',
                        'depth'     => $depth,
                        'max_depth' => $args['max_depth'],
                        'before'    => '<div class="reply">',
                        'after'     => '</div>'
                    )));
                    ?>
                </article><!-- .comment-body -->
    <?php
        }
    }
}
