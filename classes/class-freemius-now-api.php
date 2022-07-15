<?php

class Freemius_Now_Api {

	public static function init( $scope_id, $public_key, $secret_key ) {

		// Init SDK.
		$freemius_api = new Freemius_Api( 'developer', $scope_id, $public_key, $secret_key );

		return $freemius_api;
	}

	public static function get_plugins() {

				
	}
}
