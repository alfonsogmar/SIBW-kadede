<?php
	function get_ip_address() {
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} else {
			if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
				$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			} else {
				$ip = $_SERVER['REMOTE_ADDR'];
			}
		}
		return $ip;
	}

	/*Funciones de validación*/
	function validateEmail($emailAddress) {
		$mailRegex = '/[\w-]+@([\w-]+\.)+[\w-]+/';
		$match = preg_match($mailRegex, $emailAddress);
		return $match;
	}
?>
