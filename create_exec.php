<?php

	// Starting session and getting required files.
	session_start();
	
	require_once("config/config.php");
	require_once("config/cleaning.php");
	
	// Reading in the JSON object being passed from the javascript.
	$json = file_get_contents('php://input');
	
	$noslashes = str_replace("\\", "", $json);
	
	// Getting the difference between the slides information and the questions information.
	$slides_end = strrpos($noslashes, '}DIVIDER{');
	
	// Replacing the forward slashes with nothing.
	$slides = substr($noslashes, 1, $slides_end);
	$questions = substr($noslashes, ($slides_end + 8), -1);
	
	// Decoding the JSON Object
	$slides = json_decode($slides, true);
	$questions = json_decode($questions, true);
	
	// Getting the lecture name and userId
	$lecture_name = checkForSingleQuote($slides['lecture_name']);
	$userId = checkForSingleQuote($_SESSION['SESS_USER_ID']);
	
	// Creating the lectureId variable to be used later
	$lectureId;

	// Information checks out.  Inserting the name into the database.
	$qry = "INSERT INTO lecture(iduser, name) VALUES('".$userId."', '".$lecture_name."');";
	
	// Run the query.
	$result = mysql_query($qry);
	
	if (!$result) {
		// Just exit as if the query failed information probably doesn't exist in the database.
		exit();
	}
	
	// Get the lectureId from the database.
	$qry = "SELECT * FROM lecture WHERE iduser = '".$userId."' AND name = '".$lecture_name."';";
	
	// Run the query.
	$result = mysql_query($qry);
	if ($result) {
		while ($row = mysql_fetch_assoc($result)) {
			$lectureId = $row['idlecture'];
		}
	} else {
		exit();
	}
	
	// Adding the slides to the database:
	// Seeing how many slides there are.
	$num_of_slides = $slides['slide_num'];

	// Iterating through the array of slides.
	for ($i = 0; $i < $num_of_slides; $i++) {
		// Getting the slide number and slide content.
		$slide_num = checkForSingleQuote(substr($slides['slides'][$i]['slide'], 5));
		$content = checkForSingleQuote($slides['slides'][$i]['content']);
		// Inserting number and content into database.
		$qry = "INSERT INTO lectureInfo(idlecture, idnumber, content) VALUES('".$lectureId."', '".$slide_num."', '".str_replace(">n<", "><", str_replace(">nn<", "><", $content))."');";
		$result = mysql_query($qry);
		if (!$result) {
			exit();
		}
	}
	
	$i = 0;
	
	// Largest case.
	while ($i < sizeof($questions['questions'])) {
		// Getting all the information for the current question.  Slide num, answer, question1/2/3/4.
		$qSlide = checkForSingleQuote(substr($questions['questions'][$i]['question'], 5));
		$qAnswer = checkForSingleQuote($questions['questions'][$i]['answer']);
		$question1 = checkForSingleQuote($questions['questions'][$i]['question1']);
		$question2 = checkForSingleQuote($questions['questions'][$i]['question2']);
		$question3 = checkForSingleQuote($questions['questions'][$i]['question3']);
		$question4 = checkForSingleQuote($questions['questions'][$i]['question4']);
		
		// Create qry variable.
		// Ifs are required to see if one is the answer or not.
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
	
	// Echo <SUCCESS> to Javascript to know it worked.
	echo "<SUCCESS>";
	exit();
	
?>