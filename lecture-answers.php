<?php

	session_start();
	
	require_once("config/config.php");
	require_once("config/cleaning.php");

?>
<head>
	<title>Inte-Lecture</title>
	<link rel="stylesheet" type="text/css" href="css/main.css" />
	<!--<link rel="icon" type="image/png" href="imgs/logo.png"/>  Still have to make a logo -->
</head>
<body>
	<?php require_once("template/top.php"); ?>
	
	<div class="container content">
		<p class="descriptor">This allows you to see who has answered the questions in your lectures</p>
			<?php
				$lectureId = checkForSingleQuote($_POST['lectureId']);
				$qry = "SELECT * FROM lecture WHERE idlecture = '".$lectureId."' AND iduser = '".$_SESSION['SESS_USER_ID']."';";
				$result = mysql_query($qry);

				if (mysql_num_rows($result) > 0) {
					$data = mysql_fetch_assoc($result);
					echo "<h1>". str_replace("\\'", "&#039;", $data['name']) . "</h1>";
					// Grab all the questions associated with the lecture Id.  
					$questions = "SELECT * FROM lectureInfo WHERE idlecture = '".$lectureId."';";
					$qResults = mysql_query($questions);

					if (!$qResults) {
						echo "<h1>Error.</h1>";
						exit();
					}

					while ($qData = mysql_fetch_array($qResults)) {
						// Check if there are associated questions in the questions table.
						$qCheck = "SELECT * FROM questions WHERE idlecture = '".$lectureId."' AND idnumber = '".$qData['idnumber']."';";
						$qCheckR = mysql_query($qCheck);
						if (mysql_num_rows($qCheckR) > 0) {
							echo "<div class='slide'> <div class='html-slide'>" . str_replace("\\'", "&#039;", $qData['content']) . "</div></div>";
							echo "<table class='answer-table'>";

							// There are questions associated with this slide.  So lets grab them and print them out.
							while ($cData = mysql_fetch_array($qCheckR)) {
								echo "<tr class='answer'><th colspan='2' class='answer-data'><strong>".str_replace("\\'", "&#039;", $cData['question'])."</strong></th></tr>";
								// While there are questions.  Lets get the questions and we'll query their id with the answers table.
								$aQry = "SELECT * FROM answers WHERE idlecture = '".$lectureId."' AND idQuestion = '".$cData['idquestion']."';";
								$aResult = mysql_query($aQry);
								$count = 1;
								if (mysql_num_rows($aResult) > 0) {
									while ($aData = mysql_fetch_array($aResult)) {
										// Now we need to find out who the user is who selected this.  Best way to do so is get their email.
										$getUser = "SELECT * FROM users WHERE iduser = '".$aData['iduser']."';";
										$userResult = mysql_query($getUser);
										$userData = mysql_fetch_assoc($userResult);
										echo "<tr class='answer-user'><td class='user-data'>".$count."</td><td class='user-data'>" . str_replace("\\'", "&#039;", $userData['email']) . "</td></tr>";
										$count++;
									}
								}

							}
							echo "</table>";
						}
					}
						// Grab all the answers associated with the lecture Id.
				}
				else {
					echo "<h1>It appears there was an error when you were trying to view the lecture answers.</h1>";
				}
			?>
	</div>
	
</body>