<?php
	session_start();
	if (isset($_SESSION["username"]) || (isset($_GET['key']) && $_GET['key'] =='reg')) {
		$token = bin2hex(random_bytes(16));

		for ($i=1; $i < 10; $i++) {
			$t1 = substr($token, 0, $i);
			$t2 = substr($token, $i, 32-$i);
			$token = $t2.strrev($t1);
		}
		echo $token;
	}
?>