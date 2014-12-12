<?php

	session_start();
	
	unset($_SESSION['SESS_LOGGED_IN']);
	unset($_SESSION['SESS_EMAIL']);
	unset($_SESSION['SESS_USER_ID']);
	
	header("location:index.php");
	exit();

?>