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
		<p class="descriptor">This allows you to create a lecture, along with questions for the lecture slides.</p>
		<h1 class="center-important">You SHOULD use HTML</h1>
		<p>This means you can use tags like: <strong>paragraphs</strong>, <strong>headings</strong>, <strong>breaks</strong>, etc.</p>
		<p>Note: Given how we parse the values, you cannot enter back slashes (\).</p>
		<div class="lecture-name">
			<input type="text" maxlength="30" id="lecture-name" name="lecture-name" placeholder="Lecture Name" />
		</div>
		<div id="slides">
			<div class="slide">
				<textarea name="slide1" id="slide1" placeholder="<h1>Title</h1> <h2>Sub-Heading</h2> <p>Content</p>" ></textarea>
				<div class="counter" id="slide1-count">256</div>
				<div class="html-slide">
					<p id="slide1-html"></p>
				</div>
				<div class="slide-questions">
					<input type="button" class="questions-not-active" value="Add Question" id="slide1-question"/>
				</div>
			</div>
			
		
		</div>
		<div class="two-buttons">
			<input type="button" name="add-slide" id="add-slide" value="Add Slide" />
			<input type="submit" name="submit-lecture" id="submit-lecture" value="Submit" />
		</div>
	</div>
	
</body>