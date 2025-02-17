<?php
get_header(); ?>

<div class="container mx-auto py-12 px-4">

<section id="breadcrumbs" class=" mt-36 ">
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

    <!-- Carrusel de productos destacados -->
    <div class="mb-8">
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <?php
                $featured_args = array(
                    'post_type'      => 'product',
                    'posts_per_page' => 5,
                    'meta_key'       => '_featured',
                    'meta_value'     => 'yes'
                );
                $featured_query = new WP_Query($featured_args);
                while ($featured_query->have_posts()) : $featured_query->the_post();
                    global $product;
                ?>
                    <div class="swiper-slide">
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail('medium', ['class' => 'w-full h-60 object-cover rounded-lg']); ?>
                            <h3 class="text-lg font-semibold mt-2"><?php the_title(); ?></h3>
                        </a>
                    </div>
                <?php endwhile;
                wp_reset_postdata(); ?>
            </div>
        </div>
    </div>

    <!-- Grid de productos -->
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
        <?php if (woocommerce_product_loop()) : ?>
            <?php while (have_posts()) : the_post(); ?>
                <?php wc_get_template_part('content', 'product'); ?>
            <?php endwhile; ?>
        <?php else : ?>
            <p class="text-center text-gray-500">No hay productos disponibles.</p>
        <?php endif; ?>
    </div>
</div>

<!-- Botón flotante "Ver carrito" -->
<div id="cart-button" class="hidden fixed bottom-4 right-4 bg-blue-600 text-white px-4 py-2 rounded-lg shadow-lg">
    <a href="<?php echo wc_get_cart_url(); ?>">Ver carrito</a>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let cartButton = document.getElementById("cart-button");

        document.body.addEventListener("added_to_cart", function() {
            cartButton.classList.remove("hidden");
        });
    });

    // Inicializar Swiper.js para el carrusel
    var swiper = new Swiper('.swiper-container', {
        loop: true,
        slidesPerView: 1,
        autoplay: {
            delay: 3000,
        }
    });
</script>

<?php get_footer(); ?>
