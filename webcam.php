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
				<?php
					if (isset($_SESSION['u_id']))
					{
						echo '<form action="includes/logout.inc.php" method="POST">
								<button type="submit" name="submit" class="logout-button">Logout</button>
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
	<button onclick="display_img(1)"><img src="./imgs/metal.png" alt="metal" title="metal"></button>
	<button onclick="display_img(2)"><img src="./imgs/yolo.png" alt="yolo" title="yolo"></button>
	<button onclick="display_img(3)"><img src="./imgs/emoji.png" alt="emoji" title="emoji"></button>
</div>



<?php

	if (isset($_SESSION['u_id']))
	{
		echo '<div class="video-class">
			<img src="./imgs/metal.png" alt="metal" title="metal" class="img-metal" id="metal">
			<img src="./imgs/yolo.png" alt="yolo" title="yolo" class="img-yolo" id="yolo">
			<img src="./imgs/emoji.png" alt="emoji" title="emoji" class="img-emoji" id="emoji">
			<video id="video">Video is Loading</video>
			<canvas id="canvas" style="display:none;">Canvas Is Loading</canvas>
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


<div class="previous-imgs">
	<h1>Previous Posts</h1>
<?php
	include_once 'includes/dbh.inc.php';
	
	$uid = $_SESSION['u_uid']; 
	try
	{
		$sql = "SELECT * FROM images WHERE image_uid=:user";
		$feed = $conn->prepare($sql);
		$feed->bindParam(":user", $uid);
		$feed->execute();
		$res = $feed->fetchALL(PDO::FETCH_ASSOC);
	}
	catch(PDOException $e)
	{
		echo $sql . "<br>" . $e->getMessage();
	}

	if ($res)
	{
		foreach ($res as $row)
		{
			$imgData = $row['image_img'];
			$imgID = $row['image_id'];
			$img = str_replace(" ", "+", $imgData);
			echo '<a href="view_img.php?image='.$imgID.'"><img src="data:image/png;base64,'.$img.'"></a>';
		}
	}

?>


</div>



</section>
<div id="response">

</div>
<?php
	include_once 'footer.php';
?>