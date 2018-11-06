<?php

	session_start();

	if (isset($_GET['img']) && is_numeric($_GET['img']))
	{
		include_once 'dbh.inc.php';
		$imgID = $_GET['img'];
		
		//Delete the image
		$sql = "DELETE FROM images WHERE image_id='$imgID'";
		$conn->exec($sql);

		//Delete all asociated comments
		$sql = "DELETE FROM comments WHERE com_imgID='$imgID'";
		$conn->exec($sql);

		//Delete all associated likes
		$sql = "DELETE FROM likes WHERE likes_imgID='$imgID'";
		$conn->exec($sql);
		header("Location: ../user_home.php?DeleteSuccess");
		exit();	
	}
	else
	{
		header("Location: ../user_home.php?error");
		exit();
	}

?>