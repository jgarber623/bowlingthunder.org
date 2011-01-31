<?php
	function get_url_contents( $url ) {
		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $ch, CURLOPT_TIMEOUT, 5 );
		$file_contents = curl_exec( $ch );
		curl_close( $ch );

		return $file_contents;
	}
?>