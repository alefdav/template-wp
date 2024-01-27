<?php

// CONFIGURAÇÃO BASICA
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
show_admin_bar(false);
remove_action('wp_head', 'wp_generator');

function setup_theme()
{
    add_theme_support('title-tag');
    add_theme_support( 'post-thumbnails' );

    register_nav_menus();
}

function wpse66093_no_admin_access()
{
    global $current_user;

    $redirect = isset($_GET['redirect_to']) ? $_GET['redirect_to'] : home_url('/');

    if (strpos($redirect, 'wp-login.php ') !== false) {
        $redirect = home_url('/');
    }

    if (user_can($current_user, "subscriber") && (!DOING_AJAX || (DOING_AJAX && DOING_AJAX !== true))) {
        exit(wp_redirect($redirect));
    }
}

/**
 * Configuração de emails
 *
 * @param $original_email_address
 *
 * @return string
 */
// function wpb_sender_email($original_email_address)
// {
//     return 'email@email.com.br';
// }

// function wpb_sender_name($original_email_from)
// {
//     return 'NOME EMAIL';
// }

function no_register_link($url)
{
    return '';
}

add_action('after_setup_theme', 'setup_theme');
add_action('admin_init', 'wpse66093_no_admin_access', 100);
// add_filter('wp_mail_from', 'wpb_sender_email');
// add_filter('wp_mail_from_name', 'wpb_sender_name');
add_filter('register', 'no_register_link');
