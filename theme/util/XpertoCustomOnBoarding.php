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

function create_page_on_theme_activation()
{
    // MUST BE FIRST TO USE IN MENU CREATION BELOW
    xperto_auto_pages();

    xperto_auto_admin_menu();
    xperto_auto_org_admin_menu();

    xperto_auto_categories();

    xperto_auto_homepage_settings();
}
