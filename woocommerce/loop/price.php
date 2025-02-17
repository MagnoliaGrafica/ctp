<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;
?>

<?php if ( $price_html = $product->get_price_html() ) : ?>
	<h3 class="price text-center font-ubuntu text-magenta py-2 text-xl"><?php echo $price_html; ?></h3>
<?php endif; ?>
