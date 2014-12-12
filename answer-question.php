<?php
	
	session_start();

	require_once("config/config.php");
	require_once("config/cleaning.php");

	$lectureId = checkForSingleQuote($_POST['ld']);

	$questionId = checkForSingleQuote($_POST['idq']);

	$slideNum = checkForSingleQuote($_POST['in']);

	$qry = "SELECT * FROM answers WHERE idnumber='".$slideNum."' AND iduser = '".$_SESSION['SESS_USER_ID']." AND idlecture = '".$lectureId."';";
	$result = mysql_query($qry);

	if (mysql_num_rows($result) > 0) {
		echo "<ANSWERED>";
		exit();
	}

	// They have not already answers the question.
	$qry = "INSERT INTO answers(iduser, idquestion, idlecture, idnumber) VALUES('".$_SESSION['SESS_USER_ID']."','".$questionId."','".$lectureId."','".$slideNum."');";
	$result = mysql_query($qry);

	if ($result) {
		echo "<SUCCESS>";
		exit();
	}
	echo "<FAILURE>";
	exit();

?>
