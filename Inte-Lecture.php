<?php

	session_start();
	
	require_once('config/config.php');
	require_once('config/cleaning.php');

?>

<head>
	<title>Inte-Lecture</title>
	<link rel="stylesheet" type="text/css" href="css/main.css" />
	<!--<link rel="icon" type="image/png" href="imgs/logo.png"/>  Still have to make a logo -->
	<script type="text/javascript" src="js/scripting.js"></script>
	
</head>
<body>
	<div class="background"></div>
	<?php require_once('template/top.php'); ?>
	
	<div class="container content">
		<?php 
		if ($_SESSION['SESS_LOGGED_IN'] != NULL) { ?>
			<p>Welcome!</p>
			<?php //Have the User ID. ?>
	
		<?php }
		else  { ?>
			<h1 class="heading-intro">Welcome to Inte-Lecture!</h1>
			<p>Intelecture is about creating a learning environment that helps with hands on learning styles.</p>
			<?php
			} ?>
	</div>
	
	<!--<footer>
		<p><i>Copyright &copy 2014 CISC 282</i></p>
		<p><i>All Rights Reserved</i></p>
	</footer>-->
</body>
