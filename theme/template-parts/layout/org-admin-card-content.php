<?php if (current_user_can('manage_options')) { ?>
    <!-- Make this same height on higher resolution -->
    <div id="org-admin-menu" class="flex flex-col items-center w-full bg-xperto-orange-light-90 border border-xperto-orange p-6 rounded-lg">
        <span class="w-full text-xperto-neutral-dark-1 font-bold text-2xl">
            <?php esc_html_e('Org Admin Tools', 'xperto-ams'); ?>
        </span>
        <?php
        wp_nav_menu(
            array(
                'container' => '',
                'theme_location' => 'xperto-orgadmin-menu',
                'items_wrap' => '<ul id="" class="space-y-0 mt-3 w-full">%3$s</ul>',
                'walker' => new XpertoCustomOrgAdminNavWalker, // imported via functions.php
            )
        );
        ?>
    </div>
<?php } ?>