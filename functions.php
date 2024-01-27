<?php

include_once('inc/inc_config.php');
include_once('inc/inc_login.php');
include_once('inc/inc_scripts.php');


function filterNameCategory($array)
{
  $newArray = array_map(function ($item) {
    return $item->name;
  }, $array);

  $chaveCases = array_search("Cases", $newArray);

  if ($chaveCases !== false) {
    unset($newArray[$chaveCases]);
  }

  $newArray = array_values($newArray);

  return $newArray;
}

function my_cptui_add_post_type_to_search($query)
{
  if (is_admin()) {
    return;
  }

  if ($query->is_search() && function_exists('cptui_get_post_type_slugs')) {
    $cptui_post_types = cptui_get_post_type_slugs();
    $query->set(
      'post_type',
      array_merge(
        array('post'), // May also want to add the 'page' post type.
        $cptui_post_types
      )
    );
  }
}

function mytheme_customize_register($wp_customize)
{
  //All our sections, settings, and controls will be added here
  $wp_customize->add_setting('facebook_app_id', array(
    'default'   => '',
    'transport' => 'refresh',
  ));

  $wp_customize->add_setting('facebook_app_secret', array(
    'default'   => '',
    'transport' => 'refresh',
  ));
}

/**
 * Remover prefixo da categoria
 *
 * @param string $title
 *
 * @return string
 */
function prefix_category_title($title)
{
  if (is_category()) {
    $title = single_cat_title('', false);
  }

  return $title;
}

add_action('customize_register', 'mytheme_customize_register');

add_filter('pre_get_posts', 'my_cptui_add_post_type_to_search');
add_filter('get_the_archive_title', 'prefix_category_title');

function wpb_custom_new_menu()
{
  register_nav_menu('menu-header', __('Menu Header'));
  register_nav_menu('menu-footer', __('Menu Footer'));
}
add_action('init', 'wpb_custom_new_menu');
