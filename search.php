<?php

	session_start();
	
	require_once("config/config.php");
	require_once("config/cleaning.php");

	$searchVar = NULL;
	$lectureId = NULL;
	$sessionId = NULL;
	$sessionOn = false;
	$slideNum = 0;

	if (isset($_POST['lecture_id'])) {
		$searchVar = checkForSingleQuote($_POST['lecture_id']);
	}

	if ($searchVar != NULL) {

		$qry = "SELECT * FROM sessions WHERE idinfo = '$searchVar'";
		$result = mysql_query($qry);

		if ($result) {
			while ($row = mysql_fetch_array($result)) {
				$lectureId = $row['idlecture'];
				$slideNum = $row['idnumber'];
				$sessionId = $row['idsession'];
				if ($row['closed'] == 0) {
					$sessionOn = true;
				}
			}
		}

	}
	
?>
<head>
	<title>Inte-Lecture</title>
	<link rel="stylesheet" type="text/css" href="css/main.css" />
	<!--<link rel="icon" type="image/png" href="imgs/logo.png"/>  Still have to make a logo -->
	<script type="text/javascript" src="js/viewingPresentation.js"></script>
</head>
<body>
	<?php require_once("template/top.php"); ?>
	
	<div class="container content">
		<a href="index.php">Back</a>
			<?php
				if (!isset($lectureId) || $sessionOn == false) {
					echo "<h1>Apologies, but it appears that the session you are trying to view either does not exist or has closed.</h1>";
				}
				else {
					$qry = "SELECT * FROM lecture WHERE idlecture = '$lectureId'";
					$result = mysql_query($qry);

					// Getting the Title of the lecture.
					if ($result) {
						$data = mysql_fetch_assoc($result);
						echo "<h1 class='presenting-title' id='lecture_name' name='".$lectureId."'>".str_replace("\\'", "&#039;", $data['name'])."</h1>";
						echo "<div id='session' name='".$sessionId."'></div>";
					}

					// Getting the current slide of the lecture.
					$qry = "SELECT * FROM lectureInfo WHERE idlecture = '".$lectureId."' AND idnumber = '".$slideNum."';";
					
					$result = mysql_query($qry);
					if ($result) {
						$row = mysql_fetch_assoc($result);
						echo "<div class='slide'><div id='slide' name='".$row['idnumber']."' class='html-slide'>".str_replace("\\'", "&#039;", $row['content'])."</div>";
						
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
						if ($questionResult) {
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
						echo "</div>";
					}

				}
				
			?>
		</div>
	</div>
	
</body>