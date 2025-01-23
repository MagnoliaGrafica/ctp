<?php
/**
 * Single Product tabs
 *
 * @package WooCommerce/Templates
 * @version 3.8.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback, and priority.
 *
 * @see woocommerce_default_product_tabs()
 */
$tabs = apply_filters( 'woocommerce_product_tabs', [] );

if ( ! empty( $tabs ) ) : ?>

    <div class="woocommerce-tabs wc-tabs-wrapper mt-6">
        <ul class="tabs wc-tabs flex space-x-6  text-gray-700 font-medium font-ubuntu " role="tablist">
            <?php foreach ( $tabs as $key => $tab ) : ?>
                <li class="<?php echo esc_attr( $key ); ?>_tab" id="tab-title-<?php echo esc_attr( $key ); ?>" role="tab">
                    <a href="#tab-<?php echo esc_attr( $key ); ?>" class="border-b border-gray-300  text-xl py-2 px-4 hover:text-magenta hover:border-magenta transition" aria-controls="tab-<?php echo esc_attr( $key ); ?>">
                        <?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', esc_html( $tab['title'] ), $key ); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
        <?php foreach ( $tabs as $key => $tab ) : ?>
            <div class="woocommerce-Tabs-panel woocommerce-Tabs-panel--<?php echo esc_attr( $key ); ?> panel entry-content wc-tab hidden" id="tab-<?php echo esc_attr( $key ); ?>" role="tabpanel">
                <?php if ( isset( $tab['callback'] ) ) {
                    call_user_func( $tab['callback'], $key, $tab );
                } ?>
            </div>
        <?php endforeach; ?>
    </div>

<?php endif; ?>
