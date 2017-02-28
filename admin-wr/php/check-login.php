<?php 

	session_start();

	if (!isset($_SESSION['user']) || !isset($_SESSION['fullname'])) {

		//redirect to login page

		header('location:/admin-wr/login');

	}

?>