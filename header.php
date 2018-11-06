<?php
	 session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>Camagru</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="stylesheet.css" />
	<script src="./display-image.js" type="text/javascript"></script>
</head>
<body>
	
<header>
	<nav>
		<div class="header-bar">
			<ul>
				<li><a href="index.php">_Home_</a></li>
				<?php
					if (isset($_SESSION['u_id']))
					{
						echo '<li><a href="upload.php">_Upload_</a></li>';
						echo '<li><a href="Webcam.php">_Webcam_</a></li>';
					}
				?>
			</ul>
			<div class="login-div">
			<a href="user_home.php"></a>
				<?php
					if (isset($_SESSION['u_id']))
					{
						echo '<form action="includes/logout.inc.php" method="POST">
								<button type="submit" name="submit">Logout</button>
								<a href="user_home.php" class="user_a">User</a>
							</form>';
					}
					else
					{
						echo '<form action="includes/login.inc.php" method="POST">
								<input type="text" name="uid" placeholder="username">
								<input type="password" name="pwd" placeholder="password">
								<button type="submit" name="submit">Login</button>
								</form>
								<a href="forgot_pwd.php">Forgot_Password?</a>
								<a href="signup.php">Sign Up</a>';
					}
				?>
			</div>
		</div>
	</nav>
</header>