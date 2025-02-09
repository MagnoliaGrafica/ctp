<?php
/**
 * Theme Name: CuidaTuPlata2025
 * Description: Un theme para WordPress con soporte para WooCommerce y TailwindCSS.
 * Author: Rodrigo Salgado
 * Version: 1.0
 */

// Cargar estilos y scripts
function mi_theme_enqueue_assets() {

     // Cargar Google Fonts
     wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500;700&display=swap', [], null);

    // Cargar TailwindCSS compilado
    wp_enqueue_style('tailwindcss', get_template_directory_uri() . '/assets/css/tailwind.min.css', [], '1.0');

    // Cargar script principal (opcional)
    wp_enqueue_script('main-js', get_template_directory_uri() . '/assets/js/main.js', [], '1.0', true);
}
add_action('wp_enqueue_scripts', 'mi_theme_enqueue_assets');

// Soporte para WooCommerce
function mi_theme_add_woocommerce_support() {
    add_theme_support('woocommerce');
}
add_action('after_setup_theme', 'mi_theme_add_woocommerce_support');

// Soporte para otras características de WordPress
function mi_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
    register_nav_menus([
        'primary' => __('Menú Principal', 'mi-theme'),
    ]);
}
add_action('after_setup_theme', 'mi_theme_setup');

// desactivar estilos de WooCommerce
add_filter('woocommerce_enqueue_styles', function($enqueue_styles) {
    unset($enqueue_styles['woocommerce-general']); // Desactiva los estilos generales
    unset($enqueue_styles['woocommerce-layout']);  // Desactiva los estilos de diseño
    unset($enqueue_styles['woocommerce-smallscreen']); // Desactiva los estilos para pantallas pequeñas
    return $enqueue_styles;
});

// Eliminar la categoría en la página de un solo producto
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );


// funcion para productos VIP
function ocultar_productos_para_no_vip($query) {
    if (!is_admin() && is_shop() && !current_user_can('vip_user')) {
        $query->set('tax_query', array(
            array(
                'taxonomy' => 'product_cat',
                'field'    => 'slug',
                'terms'    => array('vip'), // Categoría oculta para usuarios sin "VIP"
                'operator' => 'NOT IN',
            ),
        ));
    }
}
add_action('pre_get_posts', 'ocultar_productos_para_no_vip');

// 1. Crear el rol "VIP User"
function agregar_rol_vip() {
    add_role('vip_user', 'Cliente VIP', array(
        'read' => true,
        'edit_posts' => false,
        'delete_posts' => false,
    ));
}
add_action('init', 'agregar_rol_vip');

// 2. Asignar el rol "VIP User" a clientes manualmente
function asignar_vip_a_usuario($user_id) {
    $user = new WP_User($user_id);
    $user->add_role('vip_user');
}

// 3. Ejemplo: Agregar VIP a un usuario cuando se registre
/*function hacer_vip_nuevos_clientes($user_id) {
    $user = new WP_User($user_id);
    if ($user->roles[0] === 'customer') { // Si el usuario es cliente
        $user->add_role('vip_user');
    }
}
add_action('user_register', 'hacer_vip_nuevos_clientes');*/

