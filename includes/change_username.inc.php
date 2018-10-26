<?php

	session_start();
	
	if (isset($_POST['submit']))
	{
		include_once 'dbh.inc.php';

		$newuid = $_POST['newuid'];
		$olduid = $_POST['olduid'];
		$pwd = $_POST['pwd'];

		if (empty($newuid) || empty($olduid) || empty($pwd))
		{
			header("Location: ../change_username.php?change=empty");
			exit();
		}
		else
		{

			$sql = "SELECT COUNT(*) FROM users WHERE user_uid='$olduid'";
			$stmt = $conn->prepare($sql);
			$stmt->execute();
			$resCheck = $stmt->fetchColumn();

			if ($resCheck == 0)
			{
				header("Location: ../signup.php?login=error");
				exit();
			}
			else
			{

				try
				{
					$sql = "SELECT * FROM users WHERE user_uid='$olduid'";
					$check = $conn->prepare($sql);
					$check->execute();
					$row = $check->fetch(PDO::FETCH_ASSOC);
				}
				catch (PDOException $var)
				{
					echo $var->getMessage();
				}
				if ($row)
				{
					$hashpwdcheck = password_verify($pwd, $row['user_pwd']);
					if ($hashpwdcheck == FALSE)
					{
						header("Location: ../change_username.php?change=incorrectpassword");
						exit();
					}
					else if ($hashpwdcheck == TRUE)
					{
						$sql = "UPDATE users SET user_uid='$newuid' WHERE user_uid='$olduid'";
						$stmt = $conn->prepare($sql);
						$stmt->execute();
						$_SESSION['uid'] = $newuid;
						header("Location: ../change_username.php?change=successfull");
						exit();
					}
				}
			}
		}
	}
	else
	{
		header("Location: ../change_username.php?change=error");
		exit();
	}

?>