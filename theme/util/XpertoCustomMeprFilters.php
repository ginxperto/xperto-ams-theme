<?php

function xperto_account_home_label($title)
{
    return 'Account Details';
}
add_filter('mepr-account-nav-home-label', 'xperto_account_home_label');
