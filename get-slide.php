<?php
	
	session_start();

	require_once("config/config.php");
	require_once("config/cleaning.php");

	$lectureId = checkForSingleQuote($_POST['ld']);

	$sessionId = checkForSingleQuote($_POST['s']);

	$slideNumFromClient = checkForSingleQuote($_POST['in']);

	$qry = "SELECT * FROM sessions WHERE idsession = '".$sessionId."' AND idlecture = '".$lectureId."' AND closed = '0';";
	$result = mysql_query($qry);

	$slideNum = NULL;

	if ($result) {
		if (mysql_num_rows($result) == 0) {
			echo "<CLOSED>";
			exit();
		}
		$data = mysql_fetch_assoc($result);
		$slideNum = $data['idnumber'];
	} else {
		echo "<ERROR>";
		exit();
	}
	//echo $slideNum . " " . $slideNumFromClient;
	if ($slideNum == $slideNumFromClient) {
		echo "<SAME_SLIDE>";
		exit();
	}

	// Getting the current slide of the lecture.
	$qry = "SELECT * FROM lectureInfo WHERE idlecture = '".$lectureId."' AND idnumber = '".$slideNum."';";
	
	$result = mysql_query($qry);
	if ($result) {
		$row = mysql_fetch_assoc($result);
		echo "<div id='slide' name='".$row['idnumber']."' class='html-slide'>".str_replace("\\'", "&#039;", $row['content'])."</div>";
		
		// Search for any potential answers the user has chosen before.
		$aQry = "SELECT * FROM answers WHERE idlecture='".$lectureId."' AND idnumber = '".$slideNum."';";
		$aResult = mysql_query($aQry);
		
		$answer = null;
		
		if (mysql_num_rows($aResult) > 0) {
			$data = mysql_fetch_assoc($aResult);
			$answer = $data['idquestion'];
		}
		
		$questionQuery = "SELECT * FROM questions WHERE idlecture = '".$lectureId."' AND idnumber = '".$row['idnumber']."';";
		$questionResult = mysql_query($questionQuery);
		if (mysql_num_rows($questionResult) > 0) {
			$count = 1;
			while ($qRow = mysql_fetch_assoc($questionResult)) {
				if ($count == 1) {
					echo "<div class='slide-questions'>";
				}
				// If they have not yet answered a question.
				if ($answer == null) {					
					echo "<input type='button' id='answer_".$count."' name='".$qRow['idquestion']."' class='questions-not-active view-slide' value='".str_replace("\\'", "&#039;", $qRow['question'])."'/>";
				}
				// If they have answered a question.
				else {
					if ($answer == $qRow['idquestion']) {
						echo "<input type='button' id='answer_".$count."' name='".$qRow['idquestion']."' class='questions-active answered-button' value='".str_replace("\\'", "&#039;", $qRow['question'])."' disabled/>";
					}
					else {
						echo "<input type='button' id='answer_".$count."' name='".$qRow['idquestion']."' class='questions-active view-slide' value='".str_replace("\\'", "&#039;", $qRow['question'])."' disabled/>";
					}
				}
				$count++;
			}
			echo "</div>";
		}
	}


?>