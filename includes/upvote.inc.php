<?php

	session_start();

	if (isset($_GET['image']) && isset($_SESSION['u_uid']))
	{
		include_once 'dbh.inc.php';

		$imgID = $_GET['image'];

		$sql = "SELECT * FROM images WHERE image_id='$imgID'";
		$check = $conn->prepare($sql);
		$check->execute();
		$row = $check->fetch(PDO::FETCH_ASSOC);
		if (!$row)
		{
			header("Location: ../index.php?error");
			exit();	
		}
		else
		{
			$liker = $_SESSION['u_uid'];
			$sql = "SELECT COUNT(*) FROM likes WHERE likes_imgID='$imgID' AND likes_liker='$liker'";
			$check = $conn->prepare($sql);
			$check->execute();
			$row = $check->fetchColumn();
			if ($row > 0)
			{
				$sql = "DELETE FROM likes WHERE likes_imgID='$imgID' AND likes_liker='$liker'";
				$conn->exec($sql);
				header("Location: ../view_img.php?image=".$imgID);
				exit();
			}
			else
			{
				$op = $row['image_uid'];
				$sql = "INSERT INTO likes (likes_op, likes_liker, likes_imgID) VALUES ('$op', '$liker', '$imgID');";
				$stmt = $conn->prepare($sql);
				$stmt->execute();
				header("Location: ../view_img.php?image=".$imgID);
				exit();
			}
		}
	}
	else
	{
		header("Location: ../index.php?please_login");
		exit();
	}

?>