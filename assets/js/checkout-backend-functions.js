function fnow_checkout_constructor() {

    datatable = jQuery( '#table_id' ).DataTable({
        searching: false,
        paging: false,
        info: false,
        language: {
            "emptyTable": "No checkout buttons found"
        }
    });
}

function fnow_new_plugin_selected() {

    jQuery('#fnow_select_plan').attr( 'disabled', true );

    jQuery('#fnow_generate_button').attr( 'disabled', true );
    jQuery('#fnow_select_plan').empty();
    jQuery('#fnow_select_plan').append( '<option>Select Plan</option>' );
    
    jQuery('#fnow_plan_loading').show();
    jQuery('#fnow_plan_loading').animate({opacity:1},200);

    var fnow_plugin_id = jQuery(this).val();

    var data = {
		'action': 'fnow_fetch_plans',
		'plugin_id': fnow_plugin_id
	};

	jQuery.post(ajaxurl, data, function(plans) {
		plans = JSON.parse( plans );
        jQuery('#fnow_plan_loading').hide();

        jQuery.each( plans, function( key, value ) {

            jQuery('#fnow_select_plan').attr( 'disabled', false );
            jQuery('#fnow_select_plan').append( `<option value='${value.id}'>${value.title}</option>` );
    
        });
	});
}


function fnow_new_plan_selected() {

    jQuery('#fnow_generate_button').attr( 'disabled', false );
    
}

function fnow_generate_buy_button() {

    var plugin_id         =  jQuery('#fnow_select_plugin').val();
    var plan_id           =  jQuery('#fnow_select_plan').val();

    var plugin_title      =  jQuery('#fnow_select_plugin option:selected').text();
    var plan_title        =  jQuery('#fnow_select_plan option:selected').text();

    var plugin_public_key =  jQuery('#fnow_select_plugin option:selected').attr('data-pk');
    var key = jQuery('#table_id tbody tr').length;

    datatable.row.add( [
        `${plugin_title}`,
        `${plan_title}`,
        `<button> Copy Shortcode </button> <button class='fnow_delete_button' data-id='${key}'> Delete </button>`
    ] ).draw();


    // jQuery('#table_id tbody').append(` <td> <button> Copy Shortcode </button>  </td> </tr>`);

    var data = {
		'action': 'fnow_save_buy_button',
		'plugin_id': plugin_id,
        'plan_id': plan_id,
        'plugin_title': plugin_title,
        'plan_title': plan_title,
        'plugin_public_key': plugin_public_key
	};

	jQuery.post(ajaxurl, data, function(response) {

        if ( 'success' === response ) {
            return;
        }
	});

}

function fnow_delete_buy_button() {

    jQuery(this).closest('tr').hide();
    var data = {
		'action': 'fnow_delete_buy_button',
		'button_id': jQuery(this).attr('data-id'),
	};

	jQuery.post(ajaxurl, data, function(response) {

        if ( 'success' === response ) {

            delete_response = response;
        }

	});

    datatable.row( jQuery(this).parents('tr') ).remove().draw();
    
}

function fnow_copy_to_clipboard() {

    var val_to_copy = jQuery(this).data('shortcode');
    var aux = document.createElement("input");
    aux.setAttribute("value", val_to_copy);
    document.body.appendChild(aux);
    aux.select();
    document.execCommand("copy");
    document.body.removeChild(aux);
  
}