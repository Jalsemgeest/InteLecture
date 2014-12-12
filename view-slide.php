<?php

	session_start();
	
	require_once("config/config.php");
	require_once("config/cleaning.php");

?>
<head>
	<title>Inte-Lecture</title>
	<link rel="stylesheet" type="text/css" href="css/main.css" />
	<!--<link rel="icon" type="image/png" href="imgs/logo.png"/>  Still have to make a logo -->
	<script type="text/javascript" src="js/create.js"></script>
</head>
<body>
	<?php require_once("template/top.php"); ?>
	
	<div class="container content">
		<a href="edit.php">Back</a>
		<div id="slides">
			<?php
				$error = false;
				
				$lectureId = checkForSingleQuote($_POST['lectureId']);
				$qry = "SELECT * FROM lecture WHERE idlecture = '".$lectureId."' AND iduser = '".$_SESSION['SESS_USER_ID']."';";
				
				$lectureName;
				$result = mysql_query($qry);
				if ($result) {
					while ($row = mysql_fetch_assoc($result)) {
						$lectureName = $row['name'];
						echo "<h1 class='lecture-heading'>".str_replace("\\'", "&#039;", $lectureName)."</h1>";
					}
				} else {
					$error = true;
				}
				
				$qry = "SELECT * FROM lectureInfo WHERE idlecture = '".$lectureId."';";
				$result = mysql_query($qry);
				if ($result) {
					while ($row = mysql_fetch_assoc($result)) {
						echo "<div class='slide'><div class='html-slide'><p>".str_replace("\\'", "&#039;", $row['content'])."</p></div>";
						$questionQuery = "SELECT * FROM questions WHERE idlecture = '".$lectureId."' AND idnumber = '".$row['idnumber']."';";
						$questionResult = mysql_query($questionQuery);
						if ($questionResult) {
							echo "<div class='slide-questions'>";
							while ($qRow = mysql_fetch_assoc($questionResult)) {
								echo "<input type='button' class='questions-not-active view-slide' value='".str_replace("\\'", "&#039;", $qRow['question'])."'/>";
							}
							echo "</div>";
						}
						echo "</div>";
					}
				} else {
					$error = true;
				}
			?>
			
		
		</div>
	</div>
	
</body>