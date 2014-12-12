<?php

	session_start();
	
	require_once("config/config.php");
	require_once("config/cleaning.php");

?>
<head>
	<title>Inte-Lecture</title>
	<link rel="stylesheet" type="text/css" href="css/main.css" />
	<!--<link rel="icon" type="image/png" href="imgs/logo.png"/>  Still have to make a logo -->
	<script type="text/javascript" src="js/edit-slide.js"></script>
</head>
<body>
	<?php require_once("template/top.php"); ?>
	
	<div class="container content">
		<p class="descriptor">Note: Updating this lecture will remove previous presentations information, including answers.</p>
		<a href="edit.php">Back</a>
			<?php
				$error = false;
				
				$lectureId = checkForSingleQuote($_POST['lectureId']);
				$qry = "SELECT * FROM lecture WHERE idlecture = '".$lectureId."' AND iduser = '".$_SESSION['SESS_USER_ID']."';";
				
				$lectureName;
				$result = mysql_query($qry);
				if ($result) {
					while ($row = mysql_fetch_assoc($result)) {
						$lectureName = $row['name'];
						echo "<div class='lecture-name'>";
						echo "<input type='text' maxlength='30' id='lecture-name' name='lecture-name' value='".str_replace("\\'", "&#039;", $lectureName)."' />";
						echo "</div>";
						echo "<div visibility='hidden' style='height:0px;' id='lectureId' name='".$lectureId."'></div>";
						echo "<div id='slides'>";
					}
				} else {
					$error = true;
				}
				
				$qry = "SELECT * FROM lectureInfo WHERE idlecture = '".$lectureId."';";
				$result = mysql_query($qry);
				if ($result) {
					$count = 1;
					while ($row = mysql_fetch_assoc($result)) {
						echo "<div class='slide'><textarea name='slide".$count."' id='slide".$count."' placeholder='<h1>Title</h1> <h2>Sub-Heading</h2> <p>Content</p>' ></textarea>
								<div class='counter' id='slide".$count."-count'>256</div><div class='html-slide' id='slide".$count."-html-div'>";
								echo $row['content'];
								echo "</div>";
						$questionQuery = "SELECT * FROM questions WHERE idlecture = '".$lectureId."' AND idnumber = '".$row['idnumber']."';";
						$questionResult = mysql_query($questionQuery);
						if (mysql_num_rows($questionResult) > 0) {
								echo "<div class='slide-questions'>";
								echo "<input type='button' class='questions-active' value='Remove Questions' id='slide".$count."-question'>";
								echo "<div class='create-questions' id='slide".$count."-questions'>";
								echo "<label for='answer'/>Answer:</label>";
								echo "<select name='slide".$count."-answer'>";
								echo "<option value='1'>1</option>";
								echo "<option value='2'>2</option>";
								echo "<option value='3'>3</option>";
								echo "<option value='4'>4</option>";
								echo "</select>";
								$qCount = 1;
								while ($qRow = mysql_fetch_assoc($questionResult)) {
									echo "<input type='text' maxlength='45' name='question".$qCount."' value='".str_replace("\\'", "&#039;", $qRow['question'])."'/>";
									$qCount++;
								}
								echo "</div>";
								echo "</div>";
						} else {
							echo "<div class='slide-questions'>";
							echo "<input type='button' class='questions-not-active' value='Add Question' id='slide".$count."-question'/>";
							echo "</div>";
						}
						echo "</div>";
						$count++;
					}
				} else {
					$error = true;
				}
			?>
			
		
		</div>
		<div class="two-buttons">
			<input type="button" name="add-slide" id="add-slide" value="Add Slide" />
			<input type="submit" name="submit-lecture" id="submit-lecture" value="Submit" />
		</div>
	</div>
	
</body>