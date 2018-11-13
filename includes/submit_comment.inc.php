<?php

	session_start();

	if (isset($_POST['comment']) && isset($_POST['image']) && isset($_SESSION['u_uid']))
	{
		$imgID = $_POST['image'];
		$comment = $_POST['comment'];
		$commenter = $_SESSION['u_uid'];

		include_once 'dbh.inc.php';
		if (empty($comment))
		{
			header("Location: ../view_img.php?image=".$imgID);
			exit();	
		}
		try
		{
			$sql = "INSERT INTO comments (com_imgID, com_text, com_commenter) VALUES (:imgID, :comment, :commenter);";
			$stmt = $conn->prepare($sql);
			$stmt->bindParam(":imgID", $imgID);
			$stmt->bindParam(":comment", $comment);
			$stmt->bindParam(":commenter", $commenter);
			$stmt->execute();
		}
		catch(PDOException $e)
		{
			echo $sql . "<br>" . $e->getMessage();
		}	

		try
		{
			$sql = "SELECT * FROM images WHERE image_id=:imgID";
			$stmt = $conn->prepare($sql);
			$stmt->bindParam(":imgID", $imgID);
			$stmt->execute();
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
		}
		catch(PDOException $e)
		{
			echo $sql . "<br>" . $e->getMessage();
		}

		if ($row)
		{
			$uid = $row['image_uid'];
			
			try
			{
				$sql = "SELECT * FROM users WHERE user_uid = :username";
				$stmt = $conn->prepare($sql);
				$stmt->bindParam(":username", $uid);
				$stmt->execute();
				$row = $stmt->fetch(PDO::FETCH_ASSOC);
			}
			catch(PDOException $e)
			{
				echo $sql . "<br>" . $e->getMessage();
			}	
			if ($row)
			{
				if ($row['user_notif'] == 1)
				{
					$email = $row['user_email'];

					$subject = "Comment Notification";
					$msg = "
					<html>
					<head>
					<title>Camagru Comment Notification</title>
					</head>
					<body>
					<p>Someone Posted a comment on one of your posts. Login to see the comment</p><br />
					</body>
					</html>
					";
					$head = "MIME-Version: 1.0" . "\r\n";
					$head .= "Content-type:text/html;charset=UTF-8" . "\r\n";
					mail($email, $subject, $msg, $head);
					$_SESSION['sent_email'] = 1;
					header("Location: ../view_img.php?image=".$imgID);
					exit();	
				}
				else
				{
					header("Location: ../view_img.php?image=".$imgID);
					exit();
				}
			}
		}
	}
	else
	{
		header("Location: ../index.php?error");
		exit();
	}

?>