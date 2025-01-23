<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header>
    <!-- Navbar -->
    <nav id="navbar" class="fixed w-full bg-white/50 backdrop-blur-md shadow-md transition-transform duration-300 transform-gpu z-50">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <!-- Logo -->
            <a href="<?php echo home_url(); ?>">
                <?php if (is_front_page()): ?>
                    <!-- Logo para la página de inicio -->
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo_ctp.png" alt="Logo" class="h-36 inline-block">
                <?php else: ?>
                    <!-- Logo para las páginas interiores -->
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo_ctp2.png" alt="Logo" class="h-36 inline-block">
                <?php endif; ?>
            </a>

            <!-- Navigation Links -->
            <?php
            wp_nav_menu([
                'theme_location' => 'primary', // Ubicación del menú
                'container'      => false, // Evita contenedores adicionales
                'menu_class'     => 'hidden md:flex space-x-6 text-gray-700 font-medium', // Clases para Tailwind
                'fallback_cb'    => false, // Evita mostrar un menú predeterminado
            ]);
            ?>

            <!-- Cart Button -->
            <div class="flex items-center space-x-4">
                <a href="<?php echo wc_get_cart_url(); ?>" class="relative text-gray-700 hover:text-blue-600 transition-colors">
                    <!-- Cart Icon -->
                    
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-7">
  <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
</svg>

                    <!-- Item Count -->
                    <?php $cart_count = WC()->cart->get_cart_contents_count(); ?>
                    <?php if ($cart_count > 0): ?>
                        <span class="absolute top-3 right-0 bg-magenta text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">
                            <?php echo $cart_count; ?>
                        </span>
                    <?php endif; ?>
                </a>

                <!-- Mobile Menu Button -->
                <button id="menu-btn" class="md:hidden flex items-center text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden bg-white md:hidden shadow-md">
            <?php
            wp_nav_menu([
                'theme_location' => 'primary',
                'container'      => false,
                'menu_class'     => 'space-y-4 p-4 text-gray-700 font-medium', // Clases para Tailwind
                'fallback_cb'    => false,
            ]);
            ?>
        </div>
    </nav>
</header>



