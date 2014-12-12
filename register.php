<?php 

	session_start();
	
	require_once('config/config.php');
	//require_once('config/cleaning.php');
	
?>
	<head>
		<title>Inte-Lecture</title>
		<link rel="stylesheet" type="text/css" href="css/main.css" />
		<!--<link rel="icon" type="image/png" href="imgs/logo.png"/>  Still have to make a logo -->
		<script type="text/javascript" src="js/register.js"></script>
	</head>
	<body>
		<?php require_once('template/top.php'); ?>
		<div class="container content">
			<p>When you register you will gain access to the amazing services that Inte-Lecture provides.</p>
			<p>You may notice that we do not ask for your credit card information.  This is because Inte-Lecture is completely free!</p>
			
			<p>We believe that Inte-Lecture is a service that users should be able to have free access to as teaching tools are incredibly important.</p>
			<p>We do not want someone to not use our service just because there would be a price tag on it.</p>
			
			<p>Have fun!</p>
			<br />
			<div class="register-form">
				<p class="center-important">Registration</p>
				<table class="register-table">
					<tbody>
						<tr>
							<td>
								<input required id="email" type="email" name="email" placeholder="Email" />
							</td>
						</tr>
						<tr>
							<td>
								<input required id="password" type="password" name="password" placeholder="Password" />
							</td>
						</tr>
						<tr>
							<td>
								<input required id="password_conf" type="password" name="password_conf" placeholder="Password Confirmation" />
							</td>
						</tr>
						<tr>
							<td>
								<input type="button" value="Register" id="but_register" />
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</body>