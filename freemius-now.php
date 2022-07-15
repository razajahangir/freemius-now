<?php
/**
 * Freemius Now
 *
 * @package           Freemius Now
 * @author            Raza Jahangir
 * @copyright         2022 Raza Jahangir
 * @license           GPL-2.0-or-later
 *
 * Plugin Name: Freemius Now
 * Plugin URI: https://razajahangir.com/freemius-now
 * Description: A simple plugin to intgrate freemius buy now buttons on your website using shortcodes
 * Version: 1.0.0
 * Requires at least: 5.0
 * Requires PHP: 5.6
 * Author: Raza Jahangir
 * Author URI: https://razajahangir.dev
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: fnow
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'FNOW_ROOT_PATH', plugin_dir_path( __FILE__ ) );
define( 'FNOW_ROOT_URL', plugin_dir_url( __FILE__ ) );

require_once FNOW_ROOT_PATH . 'vendor/freemius/Freemius.php';
require_once FNOW_ROOT_PATH . 'vendor/freemius/FreemiusBase.php';
require_once FNOW_ROOT_PATH . '/classes/class-general-settings.php';
require_once FNOW_ROOT_PATH . '/classes/class-checkout-shortcode.php';
require_once FNOW_ROOT_PATH . '/classes/class-checkout-button-generator.php';


/**
 * Call Admin Scripts */
function include_admin_scripts() {

	General_Settings::admin_settings_scripts();
	Checkout_Button_Generator::admin_settings_scripts();

	/**
	 * Enqueue Main.JS file that handles everything JS related in the plugin */
	wp_register_script( 'fnow_main_scripts', FNOW_ROOT_URL . 'assets/js/main.js', false, '1.0.0', true );
	wp_enqueue_script( 'fnow_main_scripts' );

	wp_enqueue_style( 'fnow_backend_styles', FNOW_ROOT_URL . 'assets/css/backend-styles.css' );
	wp_enqueue_style( 'fnow_checkout_datatables', 'https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css' );
	wp_enqueue_script( 'fnow_checkout_datatables', 'https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js' );

}
add_action( 'admin_enqueue_scripts', 'include_admin_scripts' );

/**
 * Admin Menu Initialized */
function admin_menu_initialized() {
	General_Settings::create_menus();
	Checkout_Button_Generator::create_menus();
}
add_action( 'admin_menu', 'admin_menu_initialized' );

/**
 * Admin Initialized */
function admin_initialized() {

	General_Settings::register_settings_fields();
	General_Settings::register_ajax_actions();

	Checkout_Button_Generator::register_ajax_actions();
}
add_action( 'admin_init', 'admin_initialized' );

/**
 * Site Initialized */
function site_initialized() {

	add_shortcode( 'fnow_btn', 'Checkout_Shortcode::register_checkout_shortcode' );

}
add_action( 'init', 'site_initialized' );

/**
 * Call Site Scripts */
function include_site_scripts() {

	Checkout_Shortcode::call_site_scripts();

}
add_action( 'wp_enqueue_scripts', 'include_site_scripts' );