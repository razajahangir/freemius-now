<?php

class General_Settings {

	public static function register_ajax_actions() {

		add_action( 'wp_ajax_verify_freemius_keys', 'General_Settings::verify_freemius_keys' );
		add_action( 'wp_ajax_disconnect_freemius', 'General_Settings::disconnect_freemius' );
	}

	public static function create_menus() {

		add_menu_page( 'Freemius Now', 'Freemius Now', 'manage_options', 'freemius_now', 'General_Settings::render_freemius_now', 'dashicons-smiley', '10' );
		// add_submenu_page( 'freemius_now', '', '', 'manage_options', 'freemius_now', '__return_null' );
		// remove_submenu_page( 'freemius_now', 'freemius_now' );
	}

	public static function register_settings_fields() {

		register_setting( 'fnow_general_settings_group', 'fnow_developer_id' );
		register_setting( 'fnow_general_settings_group', 'fnow_public_key' );
		register_setting( 'fnow_general_settings_group', 'fnow_secret_key' );
	}

	public static function render_freemius_now() {

		require_once FNOW_ROOT_PATH . '/views/fnow-general-settings.php';

	}

	public static function admin_settings_scripts() {

		wp_register_script( 'freemius_now_scripts', FNOW_ROOT_URL . 'assets/js/freemius-functions.js', false, '1.0.0', true );
		wp_enqueue_script( 'freemius_now_scripts' );

		wp_localize_script(
			'freemius_now_scripts',
			'freemius_now_scripts',
			array(
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'connection_nonce'    => wp_create_nonce( 'freemius_connection_nonce' ),
				'connection_state'    => get_option( 'fnow_connected' ),
			)
		);
	}

	public static function verify_freemius_keys() {

		if ( ! isset( $_POST['connection_nonce'] ) && ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['connection_nonce'] ) ), 'freemius_connection_nonce' ) ) {
			exit;
		}

		$form_data = $_POST;

		require_once FNOW_ROOT_PATH . '/classes/class-freemius-now-api.php';
		$freemius_api = Freemius_Now_Api::init( $form_data['keys']['developer_id'], $form_data['keys']['public_key'], $form_data['keys']['secret_key'] );

		$result = $freemius_api->Api( '/plugins.json' );
		if ( is_array( $result->plugins ) ) {
			$error_data = array( 'status' => 'success' );
			update_option( 'fnow_connected', 'true' );
			wp_die( wp_json_encode( $error_data ) );
		}

		if ( isset( $result->error ) ) {
			$error_data = array( 'status' => 'error', 'code' => $result->error->code );
			update_option( 'fnow_connected', 'false' );
			wp_die( wp_json_encode( $error_data ) );
		}

	}

	public static function disconnect_freemius() {

		if ( ! isset( $_POST['connection_nonce'] ) && ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['connection_nonce'] ) ), 'freemius_connection_nonce' ) ) {
			exit;
		}

		update_option( 'fnow_connected', false );
		$error_data = array( 'status' => 'success' );
		wp_die( wp_json_encode( $error_data ) );

	}

}
