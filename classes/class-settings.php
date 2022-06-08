<?php

class FreemiusNowSettings {

	public static function create_general_settings_menu() {

		add_menu_page('Freemius Now', 'Freemius Now', 'manage_options', 'freemius_now', 'FreemiusNowSettings::render_freemius_now', 'dashicons-smiley', '10');
	}

	public static function register_settings_fields() { 

		register_setting( 'fnow_general_settings_group', 'fnow_developer_id' );
		register_setting( 'fnow_general_settings_group', 'fnow_public_key' );
		register_setting( 'fnow_general_settings_group', 'fnow_secret_key' );
	}

	public static function render_freemius_now() {
		
		require_once FNOW_ROOT_PATH . '/views/fnow-options.php';

	}

	public static function admin_settings_scripts(){

		wp_register_script( 'freemius_now_scripts', FNOW_ROOT_URL . 'assets/js/freemius-functions.js', false, '1.0.0' );
		wp_enqueue_script( 'freemius_now_scripts' );
	}
	 
} 