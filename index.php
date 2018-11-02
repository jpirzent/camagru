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
	<script src="./camera.js" type="text/javascript"></script>
</head>
<body>
	
<header>
	<nav>
		<div class="header-bar">
			<ul>
				<li><a href="index.php">_Home_</a></li>
				<li><a href="gallery.php">_Gallery_</a></li>
				<?php
					if (isset($_SESSION['u_id']))
					{
						echo '<li><a href="upload.php">_Upload_</a></li>';
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
<section class="header-container">
	<div class="header-bar">
		<h2>Home</h2>
	</div>
<?php

	if (isset($_SESSION['u_id']))
	{
		echo '<div class="video-class">
			<video id="video" width="640" height="480">Video is Loading</video>
			<canvas id="canvas" style="display:none;" width="640" height="480">Canvas Is Loading</canvas>
			<input type="button" value="Take the Shot!!" id="snap">
			<input type="button" value="Cancel" id="delete_snap">
		</div>';
	}
	else
	{
		echo '<p class="webcam-error">
				Please Login/Signup To access the Webcam
			</p>';
	}
	

?>


</section>
<?php
	include_once 'footer.php';
?>