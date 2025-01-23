<?php
/**
 * Simple product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/simple.php.
 *
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Verificamos si el producto es comprable
if ( ! $product->is_purchasable() ) {
    return;
}

echo wc_get_stock_html( $product ); // Muestra información sobre el stock.

if ( $product->is_in_stock() ) :

    // Si el usuario NO está logueado
    if ( ! is_user_logged_in() ) : ?>

        
        <!-- Desactivamos el botón "Add to Cart" -->
        <button type="button" class="single_add_to_cart_button button alt flex items-center px-6 py-3 bg-gray-400 text-white font-semibold rounded-lg cursor-not-allowed">
            <!-- Icono del carrito -->
            <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l3 9h9l3-9h2M9 14h6M10 20h4"></path>
            </svg>
            Agregar al carrito
        </button>

		<div class="text-center mt-4">
            <!-- Mensaje pidiendo iniciar sesión -->
            <p class="text-red-500 font-semibold">
                Para agregar este producto al carrito, debes <a href="<?php echo esc_url( wp_login_url( get_permalink() ) ); ?>" class="text-blue-600 hover:text-blue-800">iniciar sesión</a> primero.
            </p>
        </div>

    <?php else : ?>

        <?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>

        <form class="cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data'>
            <?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>
			
			<div class="flex items-center gap-2 py-8">
				<!-- Texto "Cantidad:" -->
				<label for="quantity" class="text-gray-700 font-semibold">Cantidad:</label>
				<?php
            	do_action( 'woocommerce_before_add_to_cart_quantity' );

            woocommerce_quantity_input(
                array(
					'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
					'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
					'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(),
					'classes'     => 'w-16 text-center bg-gray-100 border-2 border-gray-200 rounded-md p-2 focus:outline-none focus:ring-1 focus:ring-verde' 
				)
            );

            do_action( 'woocommerce_after_add_to_cart_quantity' );
            ?>
			</div>
            <!-- Botón Add to Cart con icono y animación en hover -->
            <button type="submit" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" class="single_add_to_cart_button button alt flex items-center px-6 py-3 bg-verde text-white font-ubuntu rounded-lg transition transform hover:bg-magenta ">
                <!-- Icono del carrito -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 mr-2">
  <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
</svg>



                <?php echo esc_html( $product->single_add_to_cart_text() ); ?>
            </button>

            <?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
        </form>

        <?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>

    <?php endif; ?>

<?php endif; ?>
