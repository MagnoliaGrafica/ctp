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

// Agregar el campo "Sindicato" al formulario de registro
function agregar_campo_sindicato_registro() {
    ?>
    <p class="form-row form-row-wide">
        <label for="sindicato"><?php _e('Sindicato', 'woocommerce'); ?><span class="required">*</span></label>
        <input type="text" class="input-text" name="sindicato" id="sindicato" value="<?php if (!empty($_POST['sindicato'])) echo esc_attr($_POST['sindicato']); ?>" />
    </p>
    <?php
}
add_action('woocommerce_register_form', 'agregar_campo_sindicato_registro');

// Validar el campo en el registro
function validar_campo_sindicato($errors, $username, $email) {
    if (empty($_POST['sindicato'])) {
        $errors->add('error_sindicato', __('El campo sindicato es obligatorio.', 'woocommerce'));
    }
    return $errors;
}
add_filter('woocommerce_registration_errors', 'validar_campo_sindicato', 10, 3);

// Guardar el campo en los datos del usuario
function guardar_campo_sindicato($customer_id) {
    if (isset($_POST['sindicato'])) {
        update_user_meta($customer_id, 'sindicato', sanitize_text_field($_POST['sindicato']));
    }
}
add_action('woocommerce_created_customer', 'guardar_campo_sindicato');

// **** Agregar campo en la pestaña "General" del producto
function agregar_campo_sindicatos_permitidos() {
    global $post;
    $sindicatos_permitidos = get_post_meta($post->ID, '_sindicatos_permitidos', true);
    ?>
    <div class="options_group">
        <p class="form-field">
            <label for="sindicatos_permitidos"><?php _e('Sindicatos Permitidos', 'woocommerce'); ?></label>
            <input type="text" id="sindicatos_permitidos" name="sindicatos_permitidos" value="<?php echo esc_attr($sindicatos_permitidos); ?>" placeholder="Ejemplo: Sindicato A, Sindicato B" />
            <span class="description"><?php _e('Ingrese los sindicatos que pueden comprar este producto, separados por comas.', 'woocommerce'); ?></span>
        </p>
    </div>
    <?php
}
add_action('woocommerce_product_options_general_product_data', 'agregar_campo_sindicatos_permitidos');

// Guardar el valor del campo cuando se guarda el producto
function guardar_campo_sindicatos_permitidos($post_id) {
    if (isset($_POST['sindicatos_permitidos'])) {
        update_post_meta($post_id, '_sindicatos_permitidos', sanitize_text_field($_POST['sindicatos_permitidos']));
    }
}
add_action('woocommerce_process_product_meta', 'guardar_campo_sindicatos_permitidos');

// Bloquear compra si el usuario no pertenece a un sindicato permitido
function restringir_productos_segun_sindicato($purchasable, $product) {
    if (is_user_logged_in()) {
        $user_id = get_current_user_id();
        $sindicato_usuario = get_user_meta($user_id, 'sindicato', true);
        $sindicatos_permitidos = get_post_meta($product->get_id(), '_sindicatos_permitidos', true);

        if (!empty($sindicatos_permitidos)) {
            $sindicatos_permitidos_array = array_map('trim', explode(',', $sindicatos_permitidos));
            if (!in_array($sindicato_usuario, $sindicatos_permitidos_array)) {
                return false; // Restringe la compra si el sindicato del usuario no está en la lista
            }
        }
    }
    return $purchasable;
}
add_filter('woocommerce_is_purchasable', 'restringir_productos_segun_sindicato', 10, 2);

// Mostrar mensaje si el producto no está disponible para el sindicato del usuario
function mensaje_producto_restringido() {
    global $product;

    if (is_user_logged_in()) {
        $user_id = get_current_user_id();
        $sindicato_usuario = get_user_meta($user_id, 'sindicato', true);
        $sindicatos_permitidos = get_post_meta($product->get_id(), '_sindicatos_permitidos', true);

        if (!empty($sindicatos_permitidos)) {
            $sindicatos_permitidos_array = array_map('trim', explode(',', $sindicatos_permitidos));
            if (!in_array($sindicato_usuario, $sindicatos_permitidos_array)) {
                echo '<p style="color: red; font-weight: bold;">Este producto no está disponible para su sindicato.</p>';
            }
        }
    }
}
add_action('woocommerce_single_product_summary', 'mensaje_producto_restringido', 25);


// Agregar una nueva columna "Sindicato" en la lista de clientes de WooCommerce
function agregar_columna_sindicato_woocommerce($columns) {
    // Eliminar la columna del código postal si existe
    if (isset($columns['billing_postcode'])) {
        unset($columns['billing_postcode']);
    }

    // Agregar la columna "Sindicato"
    $columns['sindicato'] = __('Sindicato', 'woocommerce');
    
    return $columns;
}
add_filter('manage_users_columns', 'agregar_columna_sindicato_woocommerce');

// Mostrar el valor del campo "Sindicato" en la columna de clientes
function mostrar_columna_sindicato_woocommerce($value, $column_name, $user_id) {
    if ($column_name === 'sindicato') {
        $sindicato = get_user_meta($user_id, 'sindicato', true);
        return !empty($sindicato) ? esc_html($sindicato) : __('No asignado', 'woocommerce');
    }
    return $value;
}
add_filter('manage_users_custom_column', 'mostrar_columna_sindicato_woocommerce', 10, 3);


// Hacer la columna "Sindicato" ordenable
function hacer_columna_sindicato_ordenable($columns) {
    $columns['sindicato'] = 'sindicato';
    return $columns;
}
add_filter('manage_users_sortable_columns', 'hacer_columna_sindicato_ordenable');


// Agregar un filtro en la lista de clientes para buscar por sindicato
function filtro_sindicato_clientes_woocommerce($query) {
    global $pagenow;

    if (is_admin() && 'users.php' === $pagenow && isset($_GET['sindicato']) && !empty($_GET['sindicato'])) {
        $query->set('meta_key', 'sindicato');
        $query->set('meta_value', sanitize_text_field($_GET['sindicato']));
    }
}
add_action('pre_get_users', 'filtro_sindicato_clientes_woocommerce');


// Agregar la columna "Sindicato" en la lista de clientes de WooCommerce
function agregar_columna_sindicato_clientes_wc($columns) {
    $columns['sindicato'] = __('Sindicato', 'woocommerce');
    return $columns;
}
add_filter('manage_woocommerce_page_wc-admin_customers_columns', 'agregar_columna_sindicato_clientes_wc');


// Mostrar el valor del campo "Sindicato" en la tabla de clientes
function mostrar_columna_sindicato_clientes_wc($column, $customer) {
    if ($column === 'sindicato') {
        $user_id = $customer->get_id();
        $sindicato = get_user_meta($user_id, 'sindicato', true);
        echo !empty($sindicato) ? esc_html($sindicato) : __('No asignado', 'woocommerce');
    }
}
add_action('manage_woocommerce_page_wc-admin_customers_custom_column', 'mostrar_columna_sindicato_clientes_wc', 10, 2);


// Hacer la columna "Sindicato" ordenable en WooCommerce → Clientes
function hacer_columna_sindicato_ordenable_wc($columns) {
    $columns['sindicato'] = 'sindicato';
    return $columns;
}
add_filter('manage_woocommerce_page_wc-admin_customers_sortable_columns', 'hacer_columna_sindicato_ordenable_wc');


// Agregar un filtro en WooCommerce → Clientes para buscar por sindicato
function filtro_sindicato_clientes_wc($query_args) {
    if (!empty($_GET['sindicato'])) {
        $query_args['meta_key']   = 'sindicato';
        $query_args['meta_value'] = sanitize_text_field($_GET['sindicato']);
    }
    return $query_args;
}
add_filter('woocommerce_customer_query_args', 'filtro_sindicato_clientes_wc');

