jQuery( document ).ready(
	function() {
		
		var datatable = null;
		fnow_freemius_constructor();
		fnow_checkout_constructor();
		fnow_register_events();
	}
);

function fnow_register_events() {
	jQuery( '#fnow_connect_freemius' ).click( fnow_freemius_connection_handler );
	jQuery( '.fnow_settings_field' ).keyup( fnow_show_hide_freemius_connect_button );
	jQuery( '#fnow_select_plugin' ).change( fnow_new_plugin_selected );
	jQuery( '#fnow_select_plan' ).change( fnow_new_plan_selected );
	jQuery( '#fnow_generate_button' ).click( fnow_generate_buy_button );
	jQuery( document ).on( 'click', '.fnow_delete_button', fnow_delete_buy_button );
	jQuery('.fnow_copy_shortcode').click( fnow_copy_to_clipboard );
}