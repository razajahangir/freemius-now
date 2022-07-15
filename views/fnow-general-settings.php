
<div class="wrap">
<h1>Freemius Now <span class="dashicons dashicons-smiley"></span> </h1>
<hr/>
<h3> General Settings </h3>
	<form method="post" action="options.php" id="fnow_freemius_connect_form"> 
	<?php
	settings_fields( 'fnow_general_settings_group' );
	do_settings_sections( 'fnow_general_settings_group' );
	?>
	<p> <i> 💡 You can find these keys on <a target="_blank" href="https://dashboard.freemius.com/#!/profile/"> My Profile Page </a> on Freemius dahboard. </i> </p>
	<table class="form-table">
		<tr valign="top">
		<th scope="row">Scope ID</th>
		<td><input type="text" class="fnow_settings_field" name="fnow_developer_id" value="<?php echo esc_attr( get_option( 'fnow_developer_id' ) ); ?>" /></td>
		</tr>
		<tr valign="top">
		<th scope="row">Public Key</th>
		<td><input type="text" class="fnow_settings_field" name="fnow_public_key" value="<?php echo esc_attr( get_option( 'fnow_public_key' ) ); ?>" /></td>
		</tr>
		<tr valign="top">
		<th scope="row">Secret Key</th>
		<td><input type="text" class="fnow_settings_field" name="fnow_secret_key" value="<?php echo esc_attr( get_option( 'fnow_secret_key' ) ); ?>" /></td>
		</tr>
		<tr valign="top">
		<th scope="row"></th>
		<td><button class="button button-primary" data-action="connect" id="fnow_connect_freemius"> Connect Freemius </button></td>
		</tr>
	</table>
</form>
</div>
