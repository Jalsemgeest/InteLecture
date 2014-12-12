<nav class="navbar-fixed-top" id="main-nav" role="navigation">
        <div class="container">
            <div class="main-nav">
                <ul class="navbar-nav">
					<?php if (basename($_SERVER['PHP_SELF']) == "register.php") { ?>
						<li><a href="index.php">BACK</a></li>
						<li><a href="">REGISTER</a></li>
					<?php } else if ($_SESSION['SESS_LOGGED_IN'] == NULL) { ?>
						<li><a class="login" href="">SIGN IN</i></a></li>
						<li><form action="login.php" method="post"></li>
						<li><input required type="text" name="email" placeholder="Email"/></li>
						<li><input required type="password" name="password" placeholder="Password" /></li>
						<li><input type="submit" value="Sign in" /></form></li>
						<li><a class="register" href="register.php">REGISTER</i></a></li>
					<?php } else { ?>
						<li><form action="search.php" method="post"></li>
						<li><input type="text" name="lecture_id" placeholder="Lecture ID"/></li>
						<li><input type="submit" value="Search" /></form></li>
						<li><a href="create.php">CREATE</i></a></li>
						<li><a href="edit.php">EDIT/VIEW</i></a></li>
						<li><a href="present.php">PRESENT</i></a></li>
						<li><a href="logout.php">LOGOUT</i></a></li>
					<?php } ?>
                </ul>
            </div>
        </div>
    </nav>