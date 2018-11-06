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
<section class="header-container">
	<div class="header-bar">
		<h2>Webcam</h2>
	</div>
<div class="overlay-imgs">
	<h1>Filters</h1>
	<img src="./imgs/cigarette.png" alt="cig" title="cigarette">
	<img src="./imgs/hat.png" alt="hat" title="hat">
	<img src="./imgs/glasses.png" alt="glasses" title="glasses">
</div>
<?php

	if (isset($_SESSION['u_id']))
	{
		echo '<div class="video-class">
			<video id="video" width="640" height="480">Video is Loading</video>
			<canvas id="canvas" style="display:none;" width="640" height="480">Canvas Is Loading</canvas>
			<input type="button" value="Take the Shot!!" id="snap">
			<input type="button" value="Cancel" id="delete_snap">
			<input type="button" value="Save" id="save_img" onclick="save_img()">
		</div>';
	}
	else
	{
		echo '<p class="webcam-error">
				Please Login/Signup To access the Webcam
			</p>';
	}
	

?>
<form method="post" name="save_img-form">
	<input name="hidden-data" id="hidden-data" type="hidden">
</form>


<div class="previous-imgs">
	<h1>Previous Posts</h1>
<?php
	include_once 'includes/dbh.inc.php';
	
	$uid = $_SESSION['u_uid'];
	$sql = "SELECT * FROM images WHERE image_uid='$uid'";
	$feed = $conn->prepare($sql);
	$feed->execute();
	$res = $feed->fetchALL(PDO::FETCH_ASSOC);
	if ($res)
	{
		foreach ($res as $row)
		{
			$imgData = $row['image_img'];
			$imgID = $row['image_id'];
			echo '<a href="view_img.php?image='.$imgID.'"><img src="data:image/jpeg;base64,'.str_replace(" ", "+", base64_encode($imgData)).'"></a>';
		}
	}

?>


</div>



</section>
<?php
	include_once 'footer.php';
?>