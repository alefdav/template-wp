<?php

// LOGO LOGIN
function custom_login_logo()
{
    echo '<style type="text/css">
            h1 a { background-image: url(' .get_bloginfo('template_directory').'/assets/icons/favicon-96x96.png) !important;}
          </style>';
}

function my_login_logo_url()
{
    return home_url();
}

function my_login_logo_url_title()
{
    return get_option( 'blogname' );
}

function my_expiration_filter($seconds, $user_id, $remember)
{
    $expiration = 10*12*30*24*60*60; //UPDATE HERE;

    if (PHP_INT_MAX - time() < $expiration) {
        //Fix to a little bit earlier!
        $expiration =  PHP_INT_MAX - time() - 5;
    }

    return $expiration;
}

add_action('login_head', 'custom_login_logo');

add_filter('login_headerurl', 'my_login_logo_url');
add_filter('login_headertitle', 'my_login_logo_url_title');
add_filter('auth_cookie_expiration', 'my_expiration_filter', 99, 3);
