<?php
/**
 * Template Name: Checkout
 */

get_header(); ?>

<div class="container mx-auto py-12 px-4 mt-56 pt-40">
    <div class="h-56">vacio</div>
    <h1 class="text-3xl font-bold mb-6">Finalizar Compra</h1>

    <?php if (!WC()->cart->is_empty()) : ?>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white p-6 shadow rounded-lg">
                <h2 class="text-xl font-semibold mb-4">Detalles de Facturación</h2>
                <?php echo do_shortcode('[woocommerce_checkout]'); ?>
            </div>
            <div class="bg-gray-100 p-6 shadow rounded-lg">
                <h2 class="text-xl font-semibold mb-4">Resumen del Pedido</h2>
                <table class="w-full border-collapse border border-gray-200">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="p-3 border">Producto</th>
                            <th class="p-3 border">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) :
                            $product = $cart_item['data']; ?>
                            <tr>
                                <td class="p-3 border">
                                    <?php echo $product->get_name(); ?> x <?php echo esc_html($cart_item['quantity']); ?>
                                </td>
                                <td class="p-3 border">$<?php echo number_format($cart_item['line_total'], 2); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr class="font-semibold">
                            <td class="p-3 border">Total</td>
                            <td class="p-3 border">$<?php echo number_format(WC()->cart->get_total(''), 2); ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    <?php else : ?>
        <p class="text-gray-500">Tu carrito está vacío.</p>
        <a href="<?php echo wc_get_page_permalink('shop'); ?>" class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded">Volver a la tienda</a>
    <?php endif; ?>
</div>

<?php get_footer(); ?>
