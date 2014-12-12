<?php

	session_start();
	
	require_once("config/config.php");
	require_once("config/cleaning.php");

	$lectureId = $_POST['lectureId'];
	
		$now = date('Y-m-d H:i:s');
	
	$md5Hash = md5($now . "123654" . $lectureId);
	
	$qry = "SELECT * FROM sessions WHERE idlecture = '".$lectureId."' AND closed = '0';";
	$result = mysql_query($qry);
	
	if (mysql_num_rows($result) > 0) {
		$data = mysql_fetch_assoc($result);
		$md5Hash = $data['idinfo'];
		
		$update = "UPDATE sessions SET idnumber='1' WHERE idlecture='".$lectureId."';";
		$result = mysql_query($update);
		if (!$result) {
			echo "Ugh oh.";
		}
	} else {	
		$qry = "INSERT INTO sessions(idlecture, startdate, closed, idinfo, idnumber) VALUES('".$lectureId."', '".$now."', '0', '".$md5Hash."', '1');";
		$result = mysql_query($qry);
		if (!$result) {
			die("Fatal Error.");
		}
	}
	
?>
<head>
	<title>Inte-Lecture</title>
	<link rel="stylesheet" type="text/css" href="css/main.css" />
	<!--<link rel="icon" type="image/png" href="imgs/logo.png"/>  Still have to make a logo -->
	<script type="text/javascript" src="js/presenting.js"></script>
</head>
<body>
	<?php require_once("template/top.php"); ?>
	
	<div class="container content">
		<p class="descriptor">Here is the key to your lecture: <?php echo $md5Hash; ?></p>
		<a href="present.php">Back</a>
		
			<?php
				
				$qry = "SELECT COUNT(*) as total FROM lectureInfo WHERE idlecture='".$lectureId."';";
				$result = mysql_query($qry);
				$data = mysql_fetch_assoc($result);
				
				echo "<div name='".$data['total']."' id='slides'>";
				
				$qry = "SELECT * FROM lecture WHERE iduser = '".$_SESSION['SESS_USER_ID']."' AND idlecture = '".$lectureId."';";
				
				$result = mysql_query($qry);
				if ($result) {
					while ($row = mysql_fetch_assoc($result)) {
						echo "<h1 class='presenting-title' id='lecture_name' name='".$lectureId."'>".str_replace("\\'", "&#039;", $row['name'])."</h1>";
					}
					
					$qry = "SELECT * FROM lectureInfo WHERE idlecture = '".$lectureId."' AND idnumber = '1';";
					
					$result = mysql_query($qry);
					if ($result) {
						$row = mysql_fetch_assoc($result);
						echo "<div id='slide' class='slide'><div class='html-slide'>".str_replace("\\'", "&#039;", $row['content'])."</div>";
						
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
					
				}
				
			?>
		</div>
		<div class="two-buttons">
			<input type="button" name="previous" id="previous" value="Previous" class="disabled" disabled/>
			<input type="button" name="next" id="next" value="Next" />
		</div>
	</div>
	
</body>