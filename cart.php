<?php
/**
 * Template Name: Carrito
 */

get_header(); ?>

<div class="container mx-auto py-12 px-4 pt-52">
    <h1 class="text-3xl font-bold mb-6">Carrito de Compras</h1>

    <?php if (WC()->cart->is_empty()) : ?>
        <p class="text-gray-500">Tu carrito está vacío.</p>
        <a href="<?php echo wc_get_page_permalink('shop'); ?>" class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded">Ir a la tienda</a>
    <?php else : ?>
        <form action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
            <table class="w-full border-collapse border border-gray-200">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="p-3 border">Producto</th>
                        <th class="p-3 border">Precio</th>
                        <th class="p-3 border">Cantidad</th>
                        <th class="p-3 border">Subtotal</th>
                        <th class="p-3 border">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) :
                        $product = $cart_item['data'];
                        $product_permalink = get_permalink($product->get_id()); ?>
                        <tr>
                            <td class="p-3 border">
                                <a href="<?php echo esc_url($product_permalink); ?>" class="text-blue-500">
                                    <?php echo $product->get_name(); ?>
                                </a>
                            </td>
                            <td class="p-3 border">$<?php echo number_format($cart_item['line_subtotal'], 2); ?></td>
                            <td class="p-3 border">
                                <input type="number" name="cart[<?php echo $cart_item_key; ?>][qty]" value="<?php echo esc_attr($cart_item['quantity']); ?>" class="w-16 border rounded px-2">
                            </td>
                            <td class="p-3 border">$<?php echo number_format($cart_item['line_total'], 2); ?></td>
                            <td class="p-3 border text-center">
                                <button type="submit" name="update_cart" value="<?php echo esc_attr($cart_item_key); ?>" class="bg-green-500 text-gray-500 px-2 py-1 rounded">Actualizar</button>
                                <a href="<?php echo esc_url(wc_get_cart_remove_url($cart_item_key)); ?>" class="bg-red-500 text-white px-2 py-1 rounded">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="mt-6 flex justify-between">
                <button type="submit" name="update_cart" class="bg-blue-500 text-red-400 px-4 py-2 rounded">Actualizar carrito</button>
                <a href="<?php echo wc_get_checkout_url(); ?>" class="bg-green-500 text-blue-600 px-4 py-2 rounded">Ir a pagar</a>
            </div>
        </form>
    <?php endif; ?>
</div>

<?php get_footer(); ?>
