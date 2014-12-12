<?php

	session_start();
	
	require_once("config/config.php");
	require_once("config/cleaning.php");

?>
<head>
	<title>Inte-Lecture</title>
	<link rel="stylesheet" type="text/css" href="css/main.css" />
	<!--<link rel="icon" type="image/png" href="imgs/logo.png"/>  Still have to make a logo -->
	<script type="text/javascript" src="js/edit.js"></script>
</head>
<body>
	<?php require_once("template/top.php"); ?>
	
	<div class="container content">
		<p class="descriptor">This allows you to edit/view the lectures you have created!</p>
		<ul id='lectures'>
			<?php
				$qry = "SELECT * FROM lecture WHERE iduser = '".$_SESSION['SESS_USER_ID']."';";
				
				$result = mysql_query($qry);
				$one = false;
				if ($result) {
					while ($row = mysql_fetch_assoc($result)) {
						$lectureName = $row['name'];
						$lectureId = $row['idlecture'];
						
						$getNumSlides = "SELECT COUNT(*) as total FROM lectureInfo WHERE idlecture = '".$lectureId."';";
						$getting = mysql_query($getNumSlides);
						$number_of_slides = 0;
						if ($getting) {
							$data = mysql_fetch_assoc($getting);
							$number_of_slides = $data['total'];
						}
						$aQry = "SELECT * FROM answers WHERE idlecture = '".$lectureId."';";
						$aResult = mysql_query($aQry);
						$answer = false;
						if (mysql_num_rows($aResult) > 0) {
							$answer = true;
						}

						echo "<li class='lecture_lists' id='".$lectureId."'>";
							echo "<div class='lecture_lists_inner'>";
								echo "<h1>". str_replace("\\'", "&#039;", $lectureName) . "</h1><div class='num_of_slides_inner'>Number of slides: ". $number_of_slides."</div>";
								echo "<input type='button' class='questions-not-active' name='view-slide".$lectureId."' id='view-slide".$lectureId."' value='View Slides' />";
								echo "<input type='submit' class='questions-not-active' name='edit-slide".$lectureId."' id='edit-slide".$lectureId."' value='Edit Slides' />";
								if ($answer) {
									echo "<input type='submit' class='questions-not-active' name='answer-slide".$lectureId."' id='answer-slide".$lectureId."' value='Answers' />";
								}
							echo "</div>";
						echo "</li>";
						$one = true;
					}
				}
				
			?>
		</ul>
		
			<?php
				if ($one == false) {
					echo "<h1>You do not have any lectures yet! Click <a href='create.php'>here</a> to create one.</h1>";
				}
			?>
	</div>
	
</body>