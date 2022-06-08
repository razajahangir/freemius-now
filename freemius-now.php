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

require_once FNOW_ROOT_PATH . '/classes/class-settings.php';

/* Call Admin Scripts */
function include_admin_scripts() {

	FreemiusNowSettings::admin_settings_scripts();

	/* Register and Enqueues Main.js */
	wp_register_script( 'fnow_main_scripts', FNOW_ROOT_URL . 'assets/js/main.js', false, '1.0.0' );
	wp_enqueue_script( 'fnow_main_scripts' );

}
add_action( 'admin_enqueue_scripts', 'include_admin_scripts' );

/* Admin Menu Initialized */
function admin_menu_initialized() {
	FreemiusNowSettings::create_general_settings_menu();
}
add_action( 'admin_menu', 'admin_menu_initialized' );

/* Admin Initialized */
function admin_initialized() {
	FreemiusNowSettings::register_settings_fields();
}
add_action( 'admin_init', 'admin_initialized' );
