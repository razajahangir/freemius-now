function fnow_freemius_constructor() {
	
	fnow_show_hide_freemius_connect_button();

	if ( 'true' === freemius_now_scripts.connection_state ){
		fnow_freemius_connected();
	}

	if ( 'false' === freemius_now_scripts.connection_state ){
		fnow_freemius_disconnected();
	}
	
}

function fnow_freemius_connection_handler(event) {
	event.preventDefault();

	var action = jQuery( '#fnow_connect_freemius' ).data('action');

	if ( 'connect' === action ) {
		fnow_connect_freemius();
	}

	if ( 'disconnect' === action ) {
		fnow_disconnect_freemius();
	}	
}

function fnow_show_hide_freemius_connect_button() {

	var keysStatus = fnow_determine_keys_presence();

	if ( false === keysStatus ) {
		jQuery( '#fnow_connect_freemius' ).hide();
	}

	if ( true === keysStatus ) {
		jQuery( '#fnow_connect_freemius' ).show();
	}

}

function fnow_determine_keys_presence() {

	var keysStatus = true;

	jQuery( '.fnow_settings_field' ).each(
		function(){

			if ( '' === jQuery( this ).val() ) {
				keysStatus = false;
			}

		}
	);

	return keysStatus;

}

function fnow_freemius_connected() {

	jQuery('.fnow_settings_field').each(function () {
		if ( 'fnow_developer_id' !== jQuery(this).attr('name') ) {
			jQuery(this).attr('type', 'password');
		}
		jQuery(this).attr('disabled', 'true');
		jQuery( '#fnow_connect_freemius' ).attr('data-action', 'disconnect');
	});

	jQuery('#fnow_connect_freemius').text('Disconnect Freemius');

}

function fnow_connect_freemius() {

	const form = document.querySelector('#fnow_freemius_connect_form');
	const formData = new FormData(form);

	var data = {
		'action': 'verify_freemius_keys',
		'keys': {
			'developer_id': formData.get('fnow_developer_id'),
			'public_key': formData.get('fnow_public_key'),
			'secret_key': formData.get('fnow_secret_key')
		},
		'connection_nonce': freemius_now_scripts.connection_nonce
	};

	jQuery.post(
		freemius_now_scripts.ajax_url,
		data,
		function(response) {

			response = JSON.parse(response);
			if ( 'success' === response.status ) {
				jQuery('#fnow_freemius_connect_form').submit();
				fnow_freemius_connection_success();
			}
		}
	);
}

function fnow_freemius_disconnected() {

	jQuery('.fnow_settings_field').each(function () {
		if ( 'fnow_developer_id' !== jQuery(this).attr('name') ) {
			jQuery(this).attr('type', 'text');
		}
		jQuery(this).attr('disabled', 'false');
		jQuery( '#fnow_connect_freemius' ).attr('data-action', 'disconnect');
	});

	jQuery('#fnow_connect_freemius').text('Connect Freemius');

}

function fnow_disconnect_freemius() {

	var data = {
		'action': 'disconnect_freemius',
		'connection_nonce': freemius_now_scripts.connection_nonce
	};

	jQuery.post(
		freemius_now_scripts.ajax_url,
		data,
		function(response) {

			response = JSON.parse(response);
			if ( 'success' === response.status ) {
				location.reload();				
			}
		}
	);
}
