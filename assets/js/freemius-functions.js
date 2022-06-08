function fnow_freemius_constructor() {

    fnow_show_hide_freemius_connect_button();

}

function fnow_connect_freemius(event){
    event.preventDefault();
    
    
}

function fnow_show_hide_freemius_connect_button() {

    var keysStatus = fnow_determine_keys_presence();
    
    if ( false === keysStatus ) {
        jQuery('#fnow_connect_freemius').hide();
    }

    if ( true === keysStatus ) {
        jQuery('#fnow_connect_freemius').show();
    }

}

function fnow_determine_keys_presence() {

    var keysStatus = true;

    jQuery('.fnow_settings_field').each(function(){

        if ( '' === jQuery(this).val() ) {
            keysStatus = false;
        }

    });

    return keysStatus;

}