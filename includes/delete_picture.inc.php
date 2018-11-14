<?php

	session_start();

	if (isset($_GET['img']) && is_numeric($_GET['img']) && isset($_SESSION['u_uid']))
	{
		include_once 'dbh.inc.php';
		$imgID = $_GET['img'];
		
		//Delete the image
		try
		{
			$sql = "DELETE FROM images WHERE image_id=:imgID";
			$stmt = $conn->prepare($sql);
			$stmt->bindParam(":imgID", $imgID);
			$stmt->execute();
		}
		catch (PDOException $var)
		{
			echo $var->getMessage();
		}

		//Delete all asociated comments
		try
		{
			$sql = "DELETE FROM comments WHERE com_imgID=:imgID";
			$stmt = $conn->prepare($sql);
			$stmt->bindParam(":imgID", $imgID);
			$stmt->execute();
		}
		catch (PDOException $var)
		{
			echo $var->getMessage();
		}

		//Delete all associated likes
		try
		{
			$sql = "DELETE FROM likes WHERE likes_imgID=:imgID";
			$stmt = $conn->prepare($sql);
			$stmt->bindParam(":imgID", $imgID);
			$stmt->execute();
		}
		catch (PDOException $var)
		{
			echo $var->getMessage();
		}
		
		header("Location: ../user_home.php?DeleteSuccess");
		exit();	
	}
	else
	{
		header("Location: ../user_home.php?error");
		exit();
	}

?>