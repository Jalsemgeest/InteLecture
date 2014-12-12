<?php
	
	session_start();
	
	require_once('config/config.php');
	require_once('config/cleaning.php');

	$email = checkForSingleQuote($_POST['email']);
	$password = checkForSingleQuote($_POST['password']);
	
	$password_hash = md5("987654321" . $password . "123456789");
	
	$qry = "SELECT * FROM users WHERE email='".$email."' AND password='".$password_hash."';";
	
	$result = mysql_query($qry);
	
	if ($result) {
		$data = mysql_fetch_assoc($result);
		$_SESSION['SESS_LOGGED_IN'] = TRUE;
		$_SESSION['SESS_EMAIL'] = $data['email'];
		$_SESSION['SESS_USER_ID'] = $data['iduser'];
		header("location:index.php");
		exit();
	}
	
	//header("location:index.php");
	//exit();
?>