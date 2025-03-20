<?php

function head_styles()
{
    wp_deregister_script('jquery');
    // wp_deregister_style('contact-form-7');
    wp_deregister_style('newsletter');
    wp_deregister_script('wp-embed');

    $assets = array(
        'js' => get_template_directory_uri() . '/dist/js/scripts.js',
        'css' => get_template_directory_uri() . '/dist/css/styles.css',
    );

    // Registrar o CSS gerado pelo webpack
    wp_register_style('theme-css', $assets['css'], array(), filemtime(get_template_directory() . '/dist/css/styles.css'));
    wp_enqueue_style('theme-css');

    // Registrar scripts com atributos async/defer para melhor performance
    wp_register_script('theme-js', $assets['js'], array(), filemtime(get_template_directory() . '/dist/js/scripts.js'), true);
    wp_enqueue_script('theme-js');
    
    // Adicionar atributo async ao script
    add_filter('script_loader_tag', 'add_async_attribute', 10, 2);
}

/**
 * Adiciona atributo async aos scripts para carregamento assíncrono
 * 
 * @param string $tag    Tag HTML do script
 * @param string $handle Identificador do script
 * 
 * @return string Tag HTML modificada
 */
function add_async_attribute($tag, $handle) {
    // Lista de scripts para carregar assíncronamente
    $scripts_to_async = array('theme-js');
    
    // Se o script estiver na lista, adiciona o atributo async
    if (in_array($handle, $scripts_to_async)) {
        return str_replace(' src', ' async defer src', $tag);
    }
    
    return $tag;
}

function disable_embeds_tiny_mce_plugin($plugins)
{
    return array_diff($plugins, array('wpembed'));
}

function disable_embeds_rewrites($rules)
{
    foreach ($rules as $rule => $rewrite) {
        if (false !== strpos($rewrite, 'embed=true')) {
            unset($rules[$rule]);
        }
    }

    return $rules;
}

function disable_emojis_tinymce($plugins)
{
    if (is_array($plugins)) {
        return array_diff($plugins, array('wpemoji'));
    }

    return array();
}

function disable_emojis_remove_dns_prefetch($urls, $relation_type)
{
    if ('dns-prefetch' == $relation_type) {
        /** This filter is documented in wp-includes/formatting.php */
        $emoji_svg_url = apply_filters('emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/');

        $urls = array_diff($urls, array($emoji_svg_url));
    }

    return $urls;
}

/**
 * Implementa lazy loading de imagens
 */
function add_lazy_loading_to_images($content) {
    // Não aplicar no painel admin
    if (is_admin()) {
        return $content;
    }
    
    // Verificar se o conteúdo contém imagens
    if (!strpos($content, '<img')) {
        return $content;
    }
    
    // Substituir atributos da tag <img>
    $content = preg_replace('/<img(.*?)src="(.*?)"(.*?)>/i', '<img$1src="data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 1 1\'%3E%3C/svg%3E" data-src="$2"$3 loading="lazy">', $content);
    
    // Adicionar script para carregar as imagens quando entrarem na viewport
    if (!wp_script_is('lazy-load-script', 'enqueued')) {
        wp_register_script('lazy-load-script', '', array(), null, true);
        wp_enqueue_script('lazy-load-script');
        
        $lazy_script = "
            document.addEventListener('DOMContentLoaded', function() {
                var lazyImages = [].slice.call(document.querySelectorAll('img[data-src]'));
                
                if ('IntersectionObserver' in window) {
                    let lazyImageObserver = new IntersectionObserver(function(entries, observer) {
                        entries.forEach(function(entry) {
                            if (entry.isIntersecting) {
                                let lazyImage = entry.target;
                                lazyImage.src = lazyImage.dataset.src;
                                lazyImage.removeAttribute('data-src');
                                lazyImageObserver.unobserve(lazyImage);
                            }
                        });
                    });
                    
                    lazyImages.forEach(function(lazyImage) {
                        lazyImageObserver.observe(lazyImage);
                    });
                } else {
                    // Fallback para navegadores que não suportam IntersectionObserver
                    lazyImages.forEach(function(lazyImage) {
                        lazyImage.src = lazyImage.dataset.src;
                        lazyImage.removeAttribute('data-src');
                    });
                }
            });
        ";
        
        wp_add_inline_script('lazy-load-script', $lazy_script);
    }
    
    return $content;
}

function disable_items()
{
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    add_filter('tiny_mce_plugins', 'disable_emojis_tinymce');
    add_filter('wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2);
    remove_action('rest_api_init', 'wp_oembed_register_route');
    add_filter('embed_oembed_discover', '__return_false');
    remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);
    remove_action('wp_head', 'wp_oembed_add_discovery_links');
    remove_action('wp_head', 'wp_oembed_add_host_js');
    add_filter('tiny_mce_plugins', 'disable_embeds_tiny_mce_plugin');
    add_filter('rewrite_rules_array', 'disable_embeds_rewrites');
    remove_filter('pre_oembed_result', 'wp_filter_pre_oembed_result', 10);
    
    // Remover versões de recursos para melhorar cache
    function remove_version_from_style_js($src) {
        if (strpos($src, 'ver=')) {
            $src = remove_query_arg('ver', $src);
        }
        return $src;
    }
    add_filter('style_loader_src', 'remove_version_from_style_js', 9999);
    add_filter('script_loader_src', 'remove_version_from_style_js', 9999);
    
    // Remover meta tags desnecessárias
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'rsd_link');
}

/**
 * Automatically set the image Title, Alt-Text, Caption & Description upon upload
 *
 * @param $post_ID
 *
 * @return void
 */
function my_set_image_meta_upon_image_upload( $post_ID )
{
	// Check if uploaded file is an image, else do nothing
	if ( wp_attachment_is_image( $post_ID ) ) {

		$my_image_title = get_post( $post_ID )->post_title;

		// Sanitize the title:  remove hyphens, underscores & extra spaces:
		$my_image_title = preg_replace( '%\s*[-_\s]+\s*%', ' ',  $my_image_title );

		// Sanitize the title:  capitalize first letter of every word (other letters lower case):
		$my_image_title = ucwords( strtolower( $my_image_title ) );

		// Create an array with the image meta (Title, Caption, Description) to be updated
		// Note:  comment out the Excerpt/Caption or Content/Description lines if not needed
		$my_image_meta = array(
			'ID'		=> $post_ID,			// Specify the image (ID) to be updated
			'post_title'	=> $my_image_title,		// Set image Title to sanitized title
			 //'post_excerpt'	=> $my_image_title,		// Set image Caption (Excerpt) to sanitized title
			 //'post_content'	=> $my_image_title,		// Set image Description (Content) to sanitized title
		);

		// Set the image Alt-Text
		update_post_meta( $post_ID, '_wp_attachment_image_alt', $my_image_title );

		// Set the image meta (e.g. Title, Excerpt, Content)
		wp_update_post( $my_image_meta );
	}
}

/**
 * Implementa cache de consultas ao banco de dados
 */
function cache_database_queries() {
    global $wpdb;
    
    // Ativar cache de consultas
    $wpdb->query('SET SESSION query_cache_type = ON');
    
    // Adicionar objetos de cache para consultas comuns
    wp_cache_add_global_groups(array('posts', 'categories', 'terms', 'users'));
}

add_action('wp_enqueue_scripts', 'head_styles', 100);
add_action('add_attachment', 'my_set_image_meta_upon_image_upload');
add_action('init', 'disable_items');
add_action('init', 'cache_database_queries');
add_filter('the_content', 'add_lazy_loading_to_images', 99);
