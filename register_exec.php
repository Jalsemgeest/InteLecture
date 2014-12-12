<?php

	session_start();
	
	require_once("config/config.php");
	require_once("config/cleaning.php");
	
	$email = checkForSingleQuote($_POST['email']);
	$pass = checkForSingleQuote($_POST['password']);
	$pass_conf = checkForSingleQuote($_POST['password_conf']);
	
	// Passwords do not match.
	if ($pass != $pass_conf) {
		exit();
	}
	
	$qry = "SELECT COUNT(*) AS total FROM users WHERE email='".$email."';";
	
	$result = mysql_query($qry);
	$number = NULL;
	if (mysql_fetch_assoc($result)['total'] != 0) {
		exit();
	}
	
	$password_hash = md5("987654321" . $pass . "123456789");
	
	$qry = "INSERT INTO users(email, password) VALUES('" . $email . "','" . $password_hash . "');";

	$result = mysql_query($qry);
	if ($result) {
		echo "<SUCCESS>";
		exit();
	} else {
		exit();
	}
	
?>