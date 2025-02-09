<?php
/**
 * Template Name: Mi Cuenta
 */

if (!is_user_logged_in()) {
    wp_redirect(wp_login_url());
    exit;
}

get_header(); ?>

<div class="container mx-auto py-12 px-4 mt-56 pt-40">
    <div class="h-56">vacio</div>
    <h1 class="text-3xl font-bold mb-6">Mi Cuenta</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Perfil del Usuario -->
        <div class="bg-white p-6 shadow rounded-lg">
            <h2 class="text-xl font-semibold mb-4">Información Personal</h2>
            <?php $current_user = wp_get_current_user(); ?>
            <p><strong>Nombre:</strong> <?php echo esc_html($current_user->display_name); ?></p>
            <p><strong>Email:</strong> <?php echo esc_html($current_user->user_email); ?></p>
            <a href="<?php echo wc_get_account_endpoint_url('edit-account'); ?>" class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded">Editar Perfil</a>
        </div>

        <!-- Pedidos -->
        <div class="bg-white p-6 shadow rounded-lg col-span-2">
            <h2 class="text-xl font-semibold mb-4">Mis Pedidos</h2>
            <?php
            $customer_orders = wc_get_orders(array(
                'customer' => get_current_user_id(),
                'limit'    => 5,
            ));

            if (!empty($customer_orders)) : ?>
                <table class="w-full border-collapse border border-gray-200">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="p-3 border">Pedido</th>
                            <th class="p-3 border">Fecha</th>
                            <th class="p-3 border">Total</th>
                            <th class="p-3 border">Estado</th>
                            <th class="p-3 border">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($customer_orders as $order) : ?>
                            <tr>
                                <td class="p-3 border">#<?php echo $order->get_id(); ?></td>
                                <td class="p-3 border"><?php echo wc_format_datetime($order->get_date_created()); ?></td>
                                <td class="p-3 border"><?php echo $order->get_formatted_order_total(); ?></td>
                                <td class="p-3 border"><?php echo wc_get_order_status_name($order->get_status()); ?></td>
                                <td class="p-3 border text-center">
                                    <a href="<?php echo $order->get_view_order_url(); ?>" class="bg-blue-500 text-white px-3 py-1 rounded">Ver</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else : ?>
                <p class="text-gray-500">No tienes pedidos recientes.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Cerrar sesión -->
    <div class="mt-6 text-center">
        <a href="<?php echo wc_logout_url(); ?>" class="bg-red-500 text-white px-4 py-2 rounded">Cerrar Sesión</a>
    </div>
</div>

<?php get_footer(); ?>