<?php

	// Starting session and getting required files.
	session_start();
	
	require_once("config/config.php");
	require_once("config/cleaning.php");
	
	$lectureId = $_GET['ld'];
	
	$qry = "UPDATE sessions SET closed = '1' WHERE idlecture = '".$lectureId."';";
	$result = mysql_query($qry);
	
	if ($result) {
		echo "<SUCCESS>";
		exit();
	} else {
		echo "BOO";
		exit();
	}
	
?>