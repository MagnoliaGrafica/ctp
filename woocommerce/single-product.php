<?php
/**
 * La plantilla para mostrar productos individuales en una sola columna.
 *
 * @package WooCommerce/Templates
 * @version 1.6.4
 */

defined('ABSPATH') || exit;

get_header(); ?>

<div class="container mx-auto py-8 ">
    <div id="product-<?php the_ID(); ?>" <?php wc_product_class('space-y-8', $product); ?>>
        <?php

        global $product;
        if (!is_a($product, 'WC_Product')) {
            $product = wc_get_product(get_the_ID());
        }

        /**
         * Hook: woocommerce_before_single_product.
         *
         * @hooked wc_print_notices - 10
         */
        do_action('woocommerce_before_single_product');

        if (post_password_required()) {
            echo get_the_password_form(); // Mostrar el formulario si el producto está protegido con contraseña.
            return;
        }
        ?>
        <section id="breadcrumbs" class="pt-36 mt-32 ">
        <div class="bg-gray-100 p-4 ">
        <nav class="max-w-7xl mx-auto">
            <ol class="flex space-x-4 text-sm text-gray-700">
                <li>
                    <a href="<?php echo home_url(); ?>" class="hover:text-blue-600">Inicio</a>
                </li>
                <li>
                    <span class="mx-2">/</span>
                    <a href="<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>" class="hover:text-blue-600">Tienda</a>
                </li>

                <?php if (is_product_category()) : ?>
                    <!-- Si estamos en una categoría de producto, mostrar el nombre de la categoría -->
                    <li>
                        <span class="mx-2">/</span>
                        <a href="<?php echo get_term_link( get_queried_object() ); ?>" class="hover:text-blue-600"><?php single_term_title(); ?></a>
                    </li>
                <?php elseif (is_product()) : ?>
                    <!-- Si estamos en un producto, mostrar "Tienda" solo una vez -->
                    <!-- Este bloque solo se ejecuta cuando es un producto -->
                    <li>
                        <span class="mx-2">/</span>
                        <span class="text-gray-500"><?php the_title(); ?></span>
                    </li>
                <?php endif; ?>
            </ol>
        </nav>
    </div>
</section>


        <section class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-7xl mx-auto">
        <div class="product-image">
            <?php
            /**
             * Hook: woocommerce_before_single_product_summary.
             *
             * @hooked woocommerce_show_product_sale_flash - 10
             * @hooked woocommerce_show_product_images - 20
             */
            do_action('woocommerce_before_single_product_summary');
            ?>
        </div>

        <div class="product-summary ">
            <?php
            /**
             * Hook: woocommerce_single_product_summary.
             *
             * @hooked woocommerce_template_single_title - 5
             * @hooked woocommerce_template_single_rating - 10
             * @hooked woocommerce_template_single_price - 10
             * @hooked woocommerce_template_single_excerpt - 20
             * @hooked woocommerce_template_single_add_to_cart - 30
             * @hooked woocommerce_template_single_meta - 40
             * @hooked woocommerce_template_single_sharing - 50
             */
            do_action('woocommerce_single_product_summary');
            ?>
        </div>
        </section>

        <div class="product-additional-info max-w-7xl mx-auto pt-24 ">
            <?php
            /**
             * Hook: woocommerce_after_single_product_summary.
             *
             * @hooked woocommerce_output_product_data_tabs - 10
             * @hooked woocommerce_upsell_display - 15
             * @hooked woocommerce_output_related_products - 20
             */
            do_action('woocommerce_after_single_product_summary');
            ?>
        </div>

        <?php do_action('woocommerce_after_single_product'); ?>
    </div>
</div>

<?php get_footer(); ?>
