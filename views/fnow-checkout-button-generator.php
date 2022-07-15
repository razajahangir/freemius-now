<?php

$fnow_connected = get_option( 'fnow_connected', false );

if ( $fnow_connected ) {
	$scope_id   = get_option( 'fnow_developer_id', false );
	$public_key = get_option( 'fnow_public_key', false );
	$secret_key = get_option( 'fnow_secret_key', false );
	$response   = get_transient( 'fnow_plugins_fetched' );

	$fetched_plugins = '';

	if ( ! $response ) {
		require_once FNOW_ROOT_PATH . '/classes/class-freemius-now-api.php';

		$freemius_api    = Freemius_Now_Api::init( $scope_id, $public_key, $secret_key );
		$response        = $freemius_api->Api( '/plugins.json' );

		if ( isset( $response->plugins ) ) {
			set_transient( 'fnow_plugins_fetched', $response, 60 * 180 );
			update_option( 'fnow_plugins', $response );
		}

		if ( isset( $response->error ) ) {
			$response = get_option( 'fnow_plugins', false );
		}
	}

	if ( $response ) {
		foreach ( $response->plugins as $fnow_plugin ) {
			$fetched_plugins .= '<option data-pk="' . $fnow_plugin->public_key . '" value="' . $fnow_plugin->id . '"> ' . $fnow_plugin->title . '</option>';
		}
	}
}


$fnow_buttons = get_option( 'fnow_buy_buttons', false );

foreach ( $fnow_buttons as $key => $fnow_button ) {

	$fnow_shortcode   = '[fnow_btn plan="' . $fnow_button['plan_id'] . '" plugin="' . $fnow_button['plugin_id'] . '"]';
	$buy_now_buttons .= '<tr> <td>' . $fnow_button['plugin_title'] . '</td> <td>' . $fnow_button['plan_title'] . "</td> <td> <button class='fnow_copy_shortcode' data-shortcode='" . $fnow_shortcode . "'> Copy Shortcode </button> <button class='fnow_delete_button' data-id='" . $key . "'> Delete </button> </td> </tr>";
}


?>
<div class="wrap">
<h1>Freemius Now <span class="dashicons dashicons-smiley"></span> </h1>
<hr/>
<h3> Checkout / Buy Button Generator </h3>
<p> <i> 💡 You can find these keys on <a target="_blank" href="https://dashboard.freemius.com/#!/profile/"> My Profile Page </a> on Freemius dahboard. </i> </p>
	<table>
		<tr>
		<th> Plugin </th>
		<th> Plan </th>
		</tr>
		<tr>
		<td> <label> <select id="fnow_select_plugin"> <option> Select Plugin</option> <?php echo nl2br( $fetched_plugins ); ?> </select> </label> </td>
		<td> <select id="fnow_select_plan" disabled> <option> Select Plan</option> </select> </td>
		<td> <button id="fnow_generate_button" class="button button-primary" disabled> Generate Button </button> </td>
		</tr>	
		<tr>
			<td> </td>
			<td style="text-align: center;"> <span id="fnow_plan_loading" style="display: none;"> Loading ... </span> </td>
		</tr>
	</table>
	<hr/>

		<table id="table_id" class="display">
		<thead>
			<tr>
				<th>Plugin</th>
				<th>Plan</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
		<?php echo $buy_now_buttons; ?>
		</tbody>
	</table> 

</div>
