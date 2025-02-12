<?php
defined('ABSPATH') || exit;
do_action('woocommerce_before_checkout_form', $checkout);

// Si el usuario no puede comprar
if (!$checkout->is_registration_enabled() && WC()->cart->is_empty()) {
    return;
}
?>

<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data" aria-label="<?php echo esc_attr__( 'Checkout', 'woocommerce' ); ?>">

	<?php if ( $checkout->get_checkout_fields() ) : ?>

		<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

		<div class="mt-4" id="customer_details">
			<div>
				<?php do_action( 'woocommerce_checkout_billing' ); ?>
			</div>

			<div>
				<?php do_action( 'woocommerce_checkout_shipping' ); ?>
			</div>
		</div>

		<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

	<?php endif; ?>
	
	<?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>


	<!--<div class="my-4">
        <h3 id="order_review_heading" class="text-lg font-ubuntu text-verde"><?php esc_html_e( 'Your order', 'woocommerce' ); ?></h3>
    </div>-->

	
	<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

	<div id="order_review" class="woocommerce-checkout-review-order">
		<?php do_action( 'woocommerce_checkout_order_review' ); ?>
	</div>

	<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>

</form>

<?php do_action('woocommerce_after_checkout_form', $checkout); ?>
