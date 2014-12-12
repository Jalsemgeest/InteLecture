<?php

	session_start();
	
	require_once("config/config.php");
	require_once("config/cleaning.php");

	$lectureId = checkForSingleQuote($_POST['ld']);
	$slide = checkForSingleQuote($_POST['s']);
	
	$content;
	
	$qry = "SELECT * FROM lectureInfo WHERE idlecture = '".$lectureId."' AND idnumber = '".$slide."';";
	$result = mysql_query($qry);
	
	if (mysql_num_rows($result) > 0) {
		$data = mysql_fetch_assoc($result);
		$content = $data['content'];
	}
	
	echo "<div class='html-slide'>";
	echo str_replace("\\'", "&#039;", $content);
	echo "</div>";
	echo "<div class='slide-questions'>";
	
	$qry = "SELECT * FROM questions WHERE idlecture = '".$lectureId."' AND idnumber = '".$slide."' ORDER BY idquestion;";
	$result = mysql_query($qry);
	
	if (mysql_num_rows($result) > 0) {
		while ($row = mysql_fetch_array($result)) {
			echo "<input type='button' class='questions-not-active view-slide' value='".str_replace("\\'", "&#039;", $row['question'])."'/>";
		}
	}
	echo "</div></div>";
	
	$qry = "UPDATE sessions SET idnumber='".$slide."' WHERE idlecture='".$lectureId."';";
	$result = mysql_query($qry);
	if (!$result) {
		echo "ERROR";
	}
	
?>