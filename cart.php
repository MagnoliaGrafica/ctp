<?php
/**
 * Template Name: Carrito
 */

get_header(); ?>

<div class="container mx-auto py-12 px-4 pt-52">
    <h1 class="text-3xl font-bold mb-6 font-ubuntu text-verde">Carrito de Compras</h1>

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
                                <button type="submit" name="update_cart" value="<?php echo esc_attr($cart_item_key); ?>" class="text-gray-500 px-2 hover:underline">Actualizar</button>
                                <a href="<?php echo esc_url(wc_get_cart_remove_url($cart_item_key)); ?>" class="text-red-500 px-2 hover:underline">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="mt-6 flex justify-between">
                <button type="submit" name="update_cart" class=" border border-gray-600 text-gray-500 px-4 py-2 rounded-full hover:bg-verde hover:text-white hover:border-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 inline mr-2">
  <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
</svg>

                    Actualizar carrito
                </button>
                <a href="<?php echo wc_get_checkout_url(); ?>" class="bg-green-500 text-white font-ubuntu px-4 py-2 rounded-full hover:bg-magenta">
                    Ir a pagar
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 inline">
  <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
</svg>


                </a>
            </div>
        </form>
    <?php endif; ?>
</div>
<?php get_footer(); ?>