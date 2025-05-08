<?php

/**
 * Funções principais do tema wp-template
 *
 * Este arquivo contém as principais funções e hooks do tema.
 * Inclui arquivos de configuração, login e scripts.
 *
 * @package wp-template
 * @version 1.0.0
 */

include_once('inc/inc_config.php');
include_once('inc/inc_login.php');
include_once('inc/inc_scripts.php');

/**
 * Filtra nomes de categorias para remover a categoria escolhida  
 *
 * @param array $array Array de objetos de categoria
 * @param string $nameCategory Nome da categoria a ser removida
 * @return array Array filtrado com nomes de categorias
 */
function filterNameCategory($array, $nameCategory)
{
  if (!is_array($array)) {
    return array();
  }

  $newArray = array_map(function ($item) {
    return isset($item->name) ? sanitize_text_field($item->name) : '';
  }, $array);

  $chaveCases = array_search($nameCategory, $newArray);

  if ($chaveCases !== false) {
    unset($newArray[$chaveCases]);
  }

  $newArray = array_values($newArray);

  return $newArray;
}

/**
 * Adiciona custom post types às consultas de pesquisa
 *
 * @param WP_Query $query Objeto da consulta
 * @return void
 */
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

/**
 * Registra configurações no customizer do WordPress
 *
 * @param WP_Customize_Manager $wp_customize Objeto do customizer
 * @return void
 */
function mytheme_customize_register($wp_customize)
{
  //All our sections, settings, and controls will be added here
  $wp_customize->add_setting('facebook_app_id', array(
    'default'   => '',
    'transport' => 'refresh',
    'sanitize_callback' => 'sanitize_text_field',
  ));

  $wp_customize->add_setting('facebook_app_secret', array(
    'default'   => '',
    'transport' => 'refresh',
    'sanitize_callback' => 'sanitize_text_field',
  ));
}

/**
 * Remove o prefixo "Categoria:" do título de arquivos de categoria
 *
 * @param string $title O título original
 * @return string O título modificado
 */
function prefix_category_title($title)
{
  if (is_category()) {
    $title = single_cat_title('', false);
  }

  return $title;
}

/**
 * Adiciona nonce aos formulários de busca
 *
 * @param string $form O formulário de busca
 * @return string O formulário modificado com nonce
 */
function add_search_form_nonce($form)
{
  $nonce = wp_create_nonce('search_form_nonce');
  $form = str_replace('</form>', '<input type="hidden" name="search_nonce" value="' . $nonce . '" /></form>', $form);
  return $form;
}

/**
 * Adiciona nonces aos formulários para proteção CSRF
 *
 * Implementa nonces em formulários de comentários e busca para
 * prevenir ataques Cross-Site Request Forgery.
 * 
 * @return void
 */
function add_security_to_forms()
{
  // Adicionar nonce aos formulários de comentários
  add_action('comment_form', function () {
    wp_nonce_field('comment_nonce_action', 'comment_nonce_field');
  });

  // Adicionar nonce aos formulários de busca
  add_filter('get_search_form', 'add_search_form_nonce');
}

/**
 * Verifica nonces em requisições POST e GET
 *
 * Valida os nonces em formulários para prevenir ataques CSRF.
 * Interrompe a execução se a verificação falhar.
 * 
 * @return void
 */
function verify_form_nonces()
{
  // Verificar nonce de comentários
  if (isset($_POST['comment_nonce_field']) && !wp_verify_nonce($_POST['comment_nonce_field'], 'comment_nonce_action')) {
    die(__('Falha na verificação de segurança', 'theme-textdomain'));
  }

  // Verificar nonce de busca
  if (isset($_GET['s']) && isset($_GET['search_nonce']) && !wp_verify_nonce($_GET['search_nonce'], 'search_form_nonce')) {
    die(__('Falha na verificação de segurança', 'theme-textdomain'));
  }
}

/**
 * Registra menus personalizados para o tema
 *
 * Registra os menus de cabeçalho e rodapé para uso com wp_nav_menu().
 * 
 * @return void
 */
function wpb_custom_new_menu()
{
  register_nav_menu('menu-header', __('Menu Header', 'theme-textdomain'));
  register_nav_menu('menu-footer', __('Menu Footer', 'theme-textdomain'));
}

// Hooks
add_action('customize_register', 'mytheme_customize_register');
add_action('init', 'add_security_to_forms');
add_action('init', 'verify_form_nonces');
add_action('init', 'wpb_custom_new_menu');

add_filter('pre_get_posts', 'my_cptui_add_post_type_to_search');
add_filter('get_the_archive_title', 'prefix_category_title');
