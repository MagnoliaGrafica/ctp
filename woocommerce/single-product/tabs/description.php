<?php
defined( 'ABSPATH' ) || exit;

global $post;

$heading = apply_filters( 'woocommerce_product_description_heading', __( 'Product Description', 'woocommerce' ) );

the_content(); 
?>
