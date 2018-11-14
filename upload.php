<?php
	 session_start();
?>

<?php
	if (isset($_SESSION['u_uid']))
	{
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
		<h2>Upload A Picture</h2>
	</div>

<div class="overlay-imgs">
	<h1>Filters</h1>
	<button onclick="display_img(1)"><img src="./imgs/metal.png" alt="metal" title="metal"></button>
	<button onclick="display_img(2)"><img src="./imgs/yolo.png" alt="yolo" title="yolo"></button>
	<button onclick="display_img(3)"><img src="./imgs/emoji.png" alt="emoji" title="emoji"></button>
</div>

<div class="upload-form">
Select an image to upload
	<img src="./imgs/metal.png" alt="metal" title="metal" class="upload-metal" id="metal">
	<img src="./imgs/yolo.png" alt="yolo" title="yolo" class="upload-yolo" id="yolo">
	<img src="./imgs/emoji.png" alt="emoji" title="emoji" class="upload-emoji" id="emoji">
	<input type="file" name="image" id="upload" onchange="displayimg(event)">
	<canvas id="upload-img" class="upload-img"></canvas>
	<input type="button" value="UPLOAD" id="img-upload" onclick="save_img()">
</div>

<div class="previous-imgs" id="prev">
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
			echo '<img src="data:image/png;base64,'.$img.'">';
		}
	}

?>

</section>
<div id="response">

</div>
<?php
	include_once 'footer.php';
?>

<?php
	}
	else
	{
		header("Location: index.php?PleaseLoginIn");
		exit();
	}
?>