jQuery(document).ready(function() {
    fnow_freemius_constructor();
    fnow_register_events();
});

function fnow_register_events() {
    jQuery('#fnow_connect_freemius').click(fnow_connect_freemius);
}