<?php

class Checkout_Shortcode {

	public static function register_checkout_shortcode( $atts ) {

		if ( ! is_admin() ) {

			$fnow_plan = $atts['plan'];
			$fnow_plugin = $atts['plugin'];

			ob_start();
			$payment_type = get_post_meta( $wpep_current_form_id, 'wpep_square_payment_type', true );
			require FNOW_ROOT_PATH . 'views/fnow-checkout-button-render.php';
			return ob_get_clean();

		}

	}


	public static function call_site_scripts() {

		wp_register_script( 'fnow_freemius_checkout', 'https://checkout.freemius.com/checkout.min.js', array( 'jquery' ), '1.0.0', true );
		wp_enqueue_script( 'fnow_freemius_checkout' );

	}
}