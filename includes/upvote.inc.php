<?php

	session_start();

	if (isset($_GET['image']) && isset($_SESSION['u_uid']))
	{
		include_once 'dbh.inc.php';

		$imgID = $_GET['image'];

		try
		{
			$sql = "SELECT * FROM images WHERE image_id=:imgID";
			$check = $conn->prepare($sql);
			$check->bindParam(":imgID", $imgID);
			$check->execute();
			$row = $check->fetch(PDO::FETCH_ASSOC);
		}
		catch(PDOException $e)
		{
			echo $sql . "<br>" . $e->getMessage();
		}

		if (!$row)
		{
			header("Location: ../index.php?error");
			exit();	
		}
		else
		{
			$liker = $_SESSION['u_uid'];

			try
			{
				$sql = "SELECT COUNT(*) FROM likes WHERE likes_imgID=:imgID AND likes_liker=:liker";
				$check = $conn->prepare($sql);
				$check->bindParam(":imgID", $imgID);
				$check->bindParam(":liker", $liker);
				$check->execute();
				$row = $check->fetchColumn();
			}
			catch(PDOException $e)
			{
				echo $sql . "<br>" . $e->getMessage();
			}

			if ($row > 0)
			{
				try
				{
					$sql = "DELETE FROM likes WHERE likes_imgID=:imgID AND likes_liker=:liker";
					$check = $conn->prepare($sql);
					$check->bindParam(":imgID", $imgID);
					$check->bindParam(":liker", $liker);
					$check->execute();
					header("Location: ../view_img.php?image=".$imgID);
					exit();
				}
				catch(PDOException $e)
				{
					echo $sql . "<br>" . $e->getMessage();
				}	

			}
			else
			{
				$op = $row['image_uid'];

				try
				{
					$sql = "INSERT INTO likes (likes_op, likes_liker, likes_imgID) VALUES (:op, :liker, :imgID);";
					$stmt = $conn->prepare($sql);
					$stmt->bindParam(":op", $op);
					$stmt->bindParam(":liker", $liker);
					$stmt->bindParam(":imgID", $imgID);
					$stmt->execute();
					header("Location: ../view_img.php?image=".$imgID);
					exit();
				}
				catch(PDOException $e)
				{
					echo $sql . "<br>" . $e->getMessage();
				}
			}
		}
	}
	else
	{
		header("Location: ../index.php?please_login");
		exit();
	}

?>