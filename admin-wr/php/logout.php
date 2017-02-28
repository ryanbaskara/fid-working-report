<?php

	session_start();

	session_destroy();

	// header to login page

	header('Location: /admin-wr/login');

?>