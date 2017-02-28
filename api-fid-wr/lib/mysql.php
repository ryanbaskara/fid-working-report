<?php 
	function connect_db() {
		$server = 'localhost';
		$user = 'idfuucom_admin';
		$pass = 'fid123!!';
		$database = 'idfuucom_wr';
		$connection = new mysqli($server, $user, $pass, $database);
		return $connection;
	}
?>