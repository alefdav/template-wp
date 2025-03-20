<?php

// LOGO LOGIN
function custom_login_logo()
{
    echo '<style type="text/css">
            h1 a { background-image: url(' . esc_url(get_bloginfo('template_directory')) . '/assets/icons/favicon-96x96.png) !important;}
          </style>';
}

function my_login_logo_url()
{
    return esc_url(home_url());
}

function my_login_logo_url_title()
{
    return esc_attr(get_option('blogname'));
}

function my_expiration_filter($seconds, $user_id, $remember)
{
    // Define o tempo de expiração para 10 anos se "lembrar-me" estiver marcado, caso contrário usa o padrão
    if ($remember) {
        $expiration = 10*12*30*24*60*60; // 10 anos

        if (PHP_INT_MAX - time() < $expiration) {
            //Fix to a little bit earlier!
            $expiration = PHP_INT_MAX - time() - 5;
        }
        
        return $expiration;
    }
    
    return $seconds; // Mantém o padrão se "lembrar-me" não estiver marcado
}

/**
 * Limita tentativas de login malsucedidas para prevenir ataques de força bruta
 */
function limit_login_attempts($user, $username, $password) {
    if (empty($username)) {
        return $user;
    }
    
    // Obtém o IP do usuário
    $ip = $_SERVER['REMOTE_ADDR'];
    
    // Define as configurações
    $max_attempts = 5; // Máximo de tentativas
    $lockout_time = 15 * MINUTE_IN_SECONDS; // 15 minutos de bloqueio
    
    // Checa se o IP está bloqueado
    $lockout_expires = get_transient('login_lockout_' . $ip);
    
    if ($lockout_expires) {
        // IP está bloqueado
        $time_left = $lockout_expires - time();
        
        if ($time_left > 0) {
            // Ainda está no período de bloqueio
            return new WP_Error(
                'too_many_attempts',
                sprintf(
                    __('<strong>ERRO</strong>: Muitas tentativas de login. Por favor, tente novamente em %d minutos.', 'theme-textdomain'),
                    ceil($time_left / 60)
                )
            );
        }
        
        // O bloqueio expirou, remove o transient
        delete_transient('login_lockout_' . $ip);
    }
    
    // Se a autenticação falhar
    if (is_wp_error($user)) {
        // Incrementa o contador de tentativas
        $login_attempts = get_transient('login_attempts_' . $ip) ? get_transient('login_attempts_' . $ip) : 0;
        $login_attempts++;
        
        set_transient('login_attempts_' . $ip, $login_attempts, DAY_IN_SECONDS);
        
        // Se exceder o número máximo de tentativas, bloqueia o IP
        if ($login_attempts >= $max_attempts) {
            set_transient('login_lockout_' . $ip, time() + $lockout_time, $lockout_time);
            set_transient('login_attempts_' . $ip, 0, DAY_IN_SECONDS); // Zera o contador
            
            return new WP_Error(
                'too_many_attempts',
                __('<strong>ERRO</strong>: Muitas tentativas de login. Por favor, tente novamente em 15 minutos.', 'theme-textdomain')
            );
        }
    } else {
        // Login bem-sucedido, remove o contador de tentativas
        delete_transient('login_attempts_' . $ip);
    }
    
    return $user;
}

/**
 * Oculta mensagens de erro na tela de login que podem revelar informações confidenciais
 */
function custom_login_error_message() {
    return __('Credenciais inválidas. Por favor, tente novamente.', 'theme-textdomain');
}

// Desabilita a API XML-RPC que pode ser usada para ataques de força bruta
add_filter('xmlrpc_enabled', '__return_false');

// Adiciona cabeçalho X-Frame-Options para evitar clickjacking
function add_security_headers() {
    header('X-Frame-Options: SAMEORIGIN');
    header('X-XSS-Protection: 1; mode=block');
    header('X-Content-Type-Options: nosniff');
}

add_action('login_head', 'custom_login_logo');
add_action('login_init', 'add_security_headers');
add_filter('authenticate', 'limit_login_attempts', 30, 3);
add_filter('login_errors', 'custom_login_error_message');

add_filter('login_headerurl', 'my_login_logo_url');
add_filter('login_headertitle', 'my_login_logo_url_title');
add_filter('auth_cookie_expiration', 'my_expiration_filter', 99, 3);
