<?php

class Checkout_Button_Generator {

	public static function register_ajax_actions() {

		add_action( 'wp_ajax_fnow_fetch_plans', 'Checkout_Button_Generator::fetch_plans' );
		add_action( 'wp_ajax_fnow_save_buy_button', 'Checkout_Button_Generator::save_buy_button' );
		add_action( 'wp_ajax_fnow_delete_buy_button', 'Checkout_Button_Generator::delete_buy_button' );
	}

	public static function create_menus() {

		add_submenu_page( 'freemius_now', 'Buy Button Generator', 'Checkout / Buy ', 'manage_options', 'button_generator', 'Checkout_Button_Generator::render_freemius_now' );
	}

	public static function register_settings_fields() {

	}

	public static function render_freemius_now() {

		require_once FNOW_ROOT_PATH . '/views/fnow-checkout-button-generator.php';

	}

	public static function admin_settings_scripts() {

		wp_register_script( 'fnow_checkout_functions', FNOW_ROOT_URL . 'assets/js/checkout-backend-functions.js', false, '1.0.0', true );
		wp_enqueue_script( 'fnow_checkout_functions' );
	}

	public function fetch_plans() {

		$post_var       = $_POST;
		$fnow_plugin_id = sanitize_text_field( $post_var['plugin_id'] );
		$plugin_option_name    = 'fnow_' . $fnow_plugin_id;

		$fnow_connected = get_option( 'fnow_connected', false );

		if ( $fnow_connected ) {
			$scope_id   = get_option( 'fnow_developer_id', false );
			$public_key = get_option( 'fnow_public_key', false );
			$secret_key = get_option( 'fnow_secret_key', false );
			$response   = get_transient( $plugin_option_name );

			require_once FNOW_ROOT_PATH . '/classes/class-freemius-now-api.php';

			if ( ! $response ) {

				$freemius_api    = Freemius_Now_Api::init( $scope_id, $public_key, $secret_key );
				$response        = $freemius_api->Api( '/plugins/' . $fnow_plugin_id . '/plans.json' );
				if ( isset( $response->plans ) ) {
					set_transient( $plugin_option_name, $response, 60 * 180 );
					update_option( $plugin_option_name, $response );
				}

				if ( isset( $response->error ) ) {
					$response = get_option( $plugin_option_name, false );
				}
			}

			echo wp_json_encode( $response->plans );
			wp_die();
		}

	}

	function save_buy_button() {

		$post_var = $_POST;
		unset( $post_var['action'] );

		$fnow_buttons = get_option( 'fnow_buy_buttons', false );

		if ( false === $fnow_buttons ) {
			$fnow_buttons = array();
		}

		array_push( $fnow_buttons, $post_var );
		update_option( 'fnow_buy_buttons', $fnow_buttons );

		wp_die();
	}


	function delete_buy_button() {

		$post_vars = $_POST;
		$button_id = $post_vars['button_id'];
		$fnow_buttons = get_option( 'fnow_buy_buttons', false );
		unset( $fnow_buttons[ $button_id ] );

		update_option( 'fnow_buy_buttons', $fnow_buttons );
		wp_die('success');
	}
}
