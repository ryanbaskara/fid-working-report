<?php 
	if ($_GET['year'] > 2100 || $_GET['year'] < 2000 || $_GET['month'] < 1 || $_GET['month'] > 13) {
		header("Location: /admin-wr/working-report/".date("m")."/".date("Y"));
	}
?>