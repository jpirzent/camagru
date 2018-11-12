<?php

	session_start();

	if (isset($_POST['submit']) && isset($_SESSION['u_uid']))
	{
		include_once 'dbh.inc.php';

		$uid = $_SESSION['u_uid'];

		try
		{
			$sql = "SELECT * FROM users WHERE user_uid=:username";
			$check = $conn->prepare($sql);
			$check->bindParam(":username", $uid);
			$check->execute();
			$row = $check->fetch(PDO::FETCH_ASSOC);
		}
		catch (PDOException $var)
		{
			echo $var->getMessage();
		}
		if ($row)
		{
			if ($row['user_notif'] == 1)
			{
				try
				{
					$sql = "UPDATE users SET user_notif='0' WHERE user_uid=:username";
					$stmt = $conn->prepare($sql);
					$stmt->bindParam(":username", $uid);
					$stmt->execute();
					$_SESSION['u_notif'] = 0;
					header("Location: ../index.php?change=successfull");
					exit();
				}
				catch (PDOException $var)
				{
					echo $var->getMessage();
				}	
			}
			else
			{
				try
				{
					$sql = "UPDATE users SET user_notif='1' WHERE user_uid=:username";
					$stmt = $conn->prepare($sql);
					$stmt->bindParam(":username", $uid);
					$stmt->execute();
					$_SESSION['u_notif'] = 1;
					header("Location: ../index.php?change=successfull");
					exit();
				}
				catch (PDOException $var)
				{
					echo $var->getMessage();
				}	
			}
		}
	}
	else
	{
		header("Location: ../index.php?change-error");
		exit();
	}

?>