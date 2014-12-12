/*
	session_start();

	echo "Here?";
	/*
	require_once("config/config.php");
	require_once("config/cleaning.php");
	
	$json = file_get_contents('php://input');
	
	$slides_end = strrpos($json, '}DIVIDER{');
	
	$slides = str_replace("\\", "", substr($json, 1, $slides_end));
		
	$questions = str_replace("\\", "", substr($json, ($slides_end + 8), -1));
	
	$slides = json_decode($slides, true);
	
	$questions = json_decode($questions, true);
	
	$lecture_name = checkForSingleQuote($slides['lecture_name']);
	$userId = $_SESSION['SESS_USER_ID'];
	
	//echo $userId;
	/*
	$lectureId;

	$qry = "INSERT INTO lecture(iduser, name) VALUES('".$userId."', '".$lecture_name."');";
	
	$result = mysql_query($qry);
	
	if (!$result) {
		echo "IN HERE";
		exit();
	}
	
	$qry = "SELECT * FROM lecture WHERE iduser = '".$userId."' AND name = '".$lecture_name."';";
	echo $qry;
	
	$result = mysql_query($qry);
	if ($result) {
		while ($row = mysql_fetch_assoc($result)) {
			$lectureId = $row['idlecture'];
		}
	} else {
		exit();
	}
	echo $lectureInfo;
	// Adding the slides to the database:
	//$num_of_slides = $slides['slide_num'];
	//echo $num_of_slides;
	/*for ($i = 0; $i < $num_of_slides; $i++) {
		$slide_num = $slides['slides'][$i]['slide'];
		$content = $slides['slides'][$i]['content'];
		$qry "INSERT INTO lectureInfo(idlecture, idnumber, content) VALUES('".$lectureId."', '".$slide_num."', '".$content."');";
		echo $qry;
		/*$result = mysql_query($qry);
		if (!$result) {
			exit();
		}*/
	}
	/*
	$i = 0;
	
	// Largest case.
	while ($i < sizeof($questions['questions'])) {
		$qSlide = substr($questions['questions'][$i]['question'], 5);
		$qAnswer = $questions['questions'][$i]['answer'];
		$question1 = $questions['questions'][$i]['question1'];
		$question2 = $questions['questions'][$i]['question2'];
		$question3 = $questions['questions'][$i]['question3'];
		$question4 = $questions['questions'][$i]['question4'];
		
		$qry;
		if ($qAnswer == 1) {
			$qry = "INSERT INTO questions(idlecture, question, answer, idnumber) VALUES('".$lectureId."', '".$question1."', '1', '".$qSlide."');";
		} else {
			$qry = "INSERT INTO questions(idlecture, question, answer, idnumber) VALUES('".$lectureId."', '".$question1."', '0', '".$qSlide."');";
		}

		$result = mysql_query($qry);
		if (!$result) { exit(); }

		if ($qAnswer == 2) {
			$qry = "INSERT INTO questions(idlecture, question, answer, idnumber) VALUES('".$lectureId."', '".$question2."', '1', '".$qSlide."');";
		} else {
			$qry = "INSERT INTO questions(idlecture, question, answer, idnumber) VALUES('".$lectureId."', '".$question2."', '0', '".$qSlide."');";
		}

		$result = mysql_query($qry);
		if (!$result) { exit(); }

		if ($qAnswer == 3) {
			$qry = "INSERT INTO questions(idlecture, question, answer, idnumber) VALUES('".$lectureId."', '".$question3."', '1', '".$qSlide."');";
		} else {
			$qry = "INSERT INTO questions(idlecture, question, answer, idnumber) VALUES('".$lectureId."', '".$question3."', '0', '".$qSlide."');";
		}

		$result = mysql_query($qry);
		if (!$result) { exit(); }

		if ($qAnswer == 4) {
			$qry = "INSERT INTO questions(idlecture, question, answer, idnumber) VALUES('".$lectureId."', '".$question4."', '1', '".$qSlide."');";
		} else {
			$qry = "INSERT INTO questions(idlecture, question, answer, idnumber) VALUES('".$lectureId."', '".$question4."', '0', '".$qSlide."');";
		}

		$result = mysql_query($qry);
		if (!$result) { exit(); }
		
		$i++;
	}
	
	echo "<SUCCESS>";
	exit();
	
	//echo $slides['lecture_name'];
	
	//print_r($questions);
	
	//echo sizeof($questions['questions']);
	
	//echo $questions['questions'][0]['question'];
	//echo $questions['questions'][0]['answer'];
	
	
	*/