<?php
/**
 * Template Name: Gracias por tu Compra
 */

get_header(); ?>

<div class="container mx-auto py-12 px-4 mt-56 pt-40">
    <div class="h-56">vacio</div>
    <h1 class="text-3xl font-bold text-green-600 mb-4">¡Gracias por tu compra!</h1>

    <?php
    $order_id = get_query_var('order-received');
    if ($order_id) {
        $order = wc_get_order($order_id);
        if ($order) :
    ?>
            <p class="text-lg text-gray-700 mb-6">Tu pedido #<?php echo $order->get_id(); ?> ha sido recibido.</p>

            <div class="bg-white shadow-md rounded-lg p-6 max-w-lg mx-auto">
                <h2 class="text-xl font-semibold mb-3">Detalles del Pedido</h2>
                <ul class="text-left">
                    <li><strong>Fecha:</strong> <?php echo wc_format_datetime($order->get_date_created()); ?></li>
                    <li><strong>Total:</strong> <?php echo $order->get_formatted_order_total(); ?></li>
                    <li><strong>Método de Pago:</strong> <?php echo wp_kses_post($order->get_payment_method_title()); ?></li>
                </ul>
            </div>

            <a href="<?php echo wc_get_page_permalink('shop'); ?>" class="mt-6 inline-block bg-blue-500 text-white px-4 py-2 rounded">
                Seguir Comprando
            </a>
    <?php
        endif;
    } else {
        echo '<p class="text-gray-500">No se encontró información del pedido.</p>';
    }
    ?>
</div>

<?php get_footer(); ?>
