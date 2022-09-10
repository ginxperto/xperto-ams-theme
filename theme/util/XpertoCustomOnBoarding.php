<?php


add_action('after_switch_theme', 'create_page_on_theme_activation');

function xperto_auto_pages()
{
    // pages to create
    $pages = array(
        array(
            'name' => 'home',
            'title' => wp_strip_all_tags('Home'),
            'content' => "",
        ),
        array(
            'name' => 'community',
            'title' => wp_strip_all_tags('Community'),
            'content' => "",
        ),
        array(
            'name' => 'members',
            'title' => wp_strip_all_tags('Members'),
            'content' => "",
        ),
        array(
            'name' => 'profile',
            'title' => wp_strip_all_tags('Profile'),
            'content' => "",
        ),
    );

    // append generic props
    $template = array(
        'post_type' => 'page',
        'post_status' => 'publish',
        'post_author' => 1
    );

    // loop and generate
    foreach ($pages as $page) {
        $my_pages = array(
            'post_name' => $page['name'],
            'post_title' => $page['title'],
            'post_content' => $page['content']
        );

        // merge the props
        $my_page = array_merge($my_pages, $template);

        // only create the page it doesn't exists
        if (get_page_by_title($my_page['post_name']) == null) {
            // create the page
            wp_insert_post($my_page);
        }
    }
}

function xperto_auto_admin_menu()
{
    $menu_name = "Sidebar Menu";
    // Does the menu exist already?
    $menu_exists = wp_get_nav_menu_object($menu_name);

    // If it doesn't exist, let's create it.
    if (!$menu_exists) {
        $menu_id = wp_create_nav_menu($menu_name);
        //then get the menu object by its name
        $menu = get_term_by('name', $menu_name, 'nav_menu');
        $menu_id = $menu->term_id;

        // get home page
        $home = get_page_by_title("home");
        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' =>  __('Home'),
            'menu-item-object' => 'page',
            'menu-item-object-id' => $home->ID,
            'menu-item-type' => 'post_type',
            'menu-item-classes' => 'menu-home',
            'menu-item-status' => 'publish'
        ));

        // get community page
        $community = get_page_by_title("community");
        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' =>  __('Community'),
            'menu-item-object' => 'page',
            'menu-item-object-id' => $community->ID,
            'menu-item-type' => 'post_type',
            'menu-item-classes' => 'menu-community',
            'menu-item-status' => 'publish'
        ));

        // get members page
        $members = get_page_by_title("members");
        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' =>  __('Members'),
            'menu-item-object' => 'page',
            'menu-item-object-id' => $members->ID,
            'menu-item-type' => 'post_type',
            'menu-item-classes' => 'menu-members',
            'menu-item-status' => 'publish'
        ));
    } else {
        $menu_id = $menu_exists->term_id;
    }

    // Getting new theme's theme location settings
    $locations = get_theme_mod('nav_menu_locations');

    // assign the generated menu_id to the theme location
    $locations['xperto-sidebar-menu'] = $menu_id;

    // update the theme mod to attach the menu
    set_theme_mod('nav_menu_locations', $locations);
}

function xperto_auto_org_admin_menu()
{
    $menu_name = "Org Admin Menu";
    // Does the menu exist already?
    $menu_exists = wp_get_nav_menu_object($menu_name);

    // If it doesn't exist, let's create it.
    if (!$menu_exists) {
        $menu_id = wp_create_nav_menu($menu_name);
        //then get the menu object by its name
        $menu = get_term_by('name', $menu_name, 'nav_menu');
        $menu_id = $menu->term_id;

        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' =>  __('Edit Org Information'),
            'menu-item-classes' => 'menu-org-admin-edit-info',
            'menu-item-url' => admin_url('/admin.php?page=memberpress-options#mepr-info'),
            'menu-item-status' => 'publish'
        ));

        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' =>  __('Modify Membership Types'),
            'menu-item-classes' => 'menu-org-admin-edit-membertypes',
            'menu-item-url' => admin_url('/edit.php?post_type=memberpressproduct'),
            'menu-item-status' => 'publish'
        ));

        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' =>  __('Manage Org Members'),
            'menu-item-classes' => 'menu-org-admin-edit-members',
            'menu-item-url' => admin_url('/admin.php?page=memberpress-members'),
            'menu-item-status' => 'publish'
        ));

        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' =>  __('View Reports'),
            'menu-item-classes' => 'menu-org-admin-view-reports',
            'menu-item-url' => admin_url('/admin.php?page=memberpress-reports'),
            'menu-item-status' => 'publish'
        ));
    } else {
        $menu_id = $menu_exists->term_id;
    }

    // Getting new theme's theme location settings
    $locations = get_theme_mod('nav_menu_locations');

    // assign the generated menu_id to the theme location
    $locations['xperto-orgadmin-menu'] = $menu_id;

    // update the theme mod to attach the menu
    set_theme_mod('nav_menu_locations', $locations);
}

function xperto_auto_categories()
{
    if (!term_exists('pinned')) {
        wp_insert_term(
            'Pinned',
            'category',
            array(
                'description' => 'Pinned announcements',
                'slug'        => 'pinned'
            )
        );
    }
}

function xperto_auto_homepage_settings()
{
    $home = get_page_by_title("home");
    update_option('page_on_front', $home->ID);
    update_option('show_on_front', 'page');

    // Set the blog page
    $community = get_page_by_title("community");
    update_option('page_for_posts', $community->ID);
}

function xperto_auto_mepr_fields()
{
    if (class_exists('MeprOptions')) {
        $mepr_options = MeprOptions::fetch();

        if (isset($mepr_options->show_fields_logged_in_purchases)) {
            // disable fields if user is already logged in
            $mepr_options->show_fields_logged_in_purchases = false;

            // try to update the options
            $mepr_options->store(false);
        }
    }
}

function xperto_auto_mepr_custom_fields()
{
    if (class_exists('MeprOptions')) {
        $mepr_options = MeprOptions::fetch();

        if (isset($mepr_options->custom_fields)) {
            $custom_fields = $mepr_options->custom_fields;
            $fields = array();

            // profile picture
            if (!custom_field_exists($custom_fields, 'mepr_profile_picture')) {
                $fields[] = (object) array(
                    'field_key' => 'mepr_profile_picture',
                    'field_name' => 'Profile Picture',
                    'field_type' => 'file',
                    'default_value' => '',
                    'show_on_signup' => true,
                    'show_in_account' => true,
                    'required' => true,
                    'options' => array()
                );
            }

            // profile banner
            if (!custom_field_exists($custom_fields, 'mepr_profile_banner')) {
                $fields[] = (object) array(
                    'field_key' => 'mepr_profile_banner',
                    'field_name' => 'Profile Banner',
                    'field_type' => 'file',
                    'default_value' => '',
                    'show_on_signup' => false,
                    'show_in_account' => true,
                    'required' => false,
                    'options' => array()
                );
            }

            // about
            if (!custom_field_exists($custom_fields, 'mepr_about')) {
                $fields[] = (object) array(
                    'field_key' => 'mepr_about',
                    'field_name' => 'About',
                    'field_type' => 'textarea',
                    'default_value' => '',
                    'show_on_signup' => false,
                    'show_in_account' => true,
                    'required' => false,
                    'options' => array()
                );
            }

            // phone number
            if (!custom_field_exists($custom_fields, 'mepr_phone_number')) {
                $fields[] = (object) array(
                    'field_key' => 'mepr_phone_number',
                    'field_name' => 'Phone Number',
                    'field_type' => 'tel',
                    'default_value' => '',
                    'show_on_signup' => false,
                    'show_in_account' => true,
                    'required' => false,
                    'options' => array()
                );
            }

            // chapter
            if (!custom_field_exists($custom_fields, 'mepr_chapter')) {
                $fields[] = (object) array(
                    'field_key' => 'mepr_chapter',
                    'field_name' => 'Chapter',
                    'field_type' => 'dropdown',
                    'default_value' => '',
                    'show_on_signup' => true,
                    'show_in_account' => true,
                    'required' => true,
                    'options' => array(
                        array(
                            'option_name' => 'Sample Chapter',
                            'option_value' => 'sample_chapter'
                        )
                    )
                );
            }

            // facebook
            if (!custom_field_exists($custom_fields, 'mepr_facebook')) {
                $fields[] = (object) array(
                    'field_key' => 'mepr_facebook',
                    'field_name' => 'Facebook',
                    'field_type' => 'url',
                    'default_value' => 'https://facebook.com/',
                    'show_on_signup' => false,
                    'show_in_account' => true,
                    'required' => false,
                    'options' => array()
                );
            }

            // twitter
            if (!custom_field_exists($custom_fields, 'mepr_twitter')) {
                $fields[] = (object) array(
                    'field_key' => 'mepr_twitter',
                    'field_name' => 'Twitter',
                    'field_type' => 'url',
                    'default_value' => 'https://twitter.com/',
                    'show_on_signup' => false,
                    'show_in_account' => true,
                    'required' => false,
                    'options' => array()
                );
            }

            // linkedin
            if (!custom_field_exists($custom_fields, 'mepr_linkedin')) {
                $fields[] = (object) array(
                    'field_key' => 'mepr_linkedin',
                    'field_name' => 'LinkedIn',
                    'field_type' => 'url',
                    'default_value' => 'https://linkedin.com/in/',
                    'show_on_signup' => false,
                    'show_in_account' => true,
                    'required' => false,
                    'options' => array()
                );
            }

            // merge everything
            $mepr_options->custom_fields = array_merge($custom_fields, $fields);

            // try to update the options
            $mepr_options->store(false);
        }
    }
}

function custom_field_exists($custom_fields, $field_key)
{
    foreach ($custom_fields as $cfield) {
        // it exists
        if ($cfield->field_key == $field_key) return true;
    }
    return false;
}

function xperto_auto_mepr_pages()
{
    if (class_exists('MeprOptions')) {
        $mepr_options = MeprOptions::fetch();

        if (isset($mepr_options->redirect_on_unauthorized)) {
            // force redirect for all unauthorized
            $mepr_options->redirect_on_unauthorized = true;
            $mepr_options->unauthorized_redirect_url = home_url('/?loginaction=xpertoOauthLogin');
            $mepr_options->redirect_non_singular = true;

            // try to update the options
            $mepr_options->store(false);
        }
    }
}

function xperto_auto_mepr_accounts()
{
    if (class_exists('MeprOptions')) {
        $mepr_options = MeprOptions::fetch();

        if (isset($mepr_options->pro_rated_upgrades)) {
            // disable proration
            $mepr_options->pro_rated_upgrades = false;

            // try to update the options
            $mepr_options->store(false);
        }
    }
}

function xperto_auto_mepr_general()
{
    if (class_exists('MeprOptions')) {
        $mepr_options = MeprOptions::fetch();

        if (isset($mepr_options->currency_code)) {
            // disable proration
            $mepr_options->currency_code = "PHP";
        }

        if (isset($mepr_options->currency_symbol)) {
            // disable proration
            $mepr_options->currency_symbol = "₱";
        }

        // try to update the options
        $mepr_options->store(false);
    }
}

function xperto_auto_group($hook)
{
    $screen = get_current_screen();

    // newly created
    if ($hook == 'post-new.php' && $screen->post_type != 'memberpressgroup') {
        // we don't do anything here
        return;
    }
    wp_enqueue_script('xperot-admin-script', get_template_directory_uri() . '/js/xperto_mepr_admin.js');
}
add_action('admin_enqueue_scripts', 'xperto_auto_group');

function create_page_on_theme_activation()
{
    // MUST BE FIRST TO USE IN MENU CREATION BELOW
    xperto_auto_pages();
    xperto_auto_admin_menu();
    xperto_auto_org_admin_menu();
    xperto_auto_categories();
    xperto_auto_homepage_settings();
    xperto_auto_mepr_fields();
    xperto_auto_mepr_custom_fields();
    xperto_auto_mepr_pages();
    xperto_auto_mepr_accounts();
    xperto_auto_mepr_general();
}
