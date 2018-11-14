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
			try
			{
				$sql = "SELECT COUNT(*) FROM users WHERE user_uid=:username";
				$stmt = $conn->prepare($sql);
				$stmt->bindParam(":username", $olduid);
				$stmt->execute();
				$resCheck = $stmt->fetchColumn();
			}
			catch (PDOException $var)
			{
				echo $var->getMessage();
			}	
			if ($resCheck == 0)
			{
				header("Location: ../signup.php?login=error");
				exit();
			}
			else
			{
				try
				{
					$sql = "SELECT * FROM users WHERE user_uid=:username";
					$check = $conn->prepare($sql);
					$check->bindParam(":username", $olduid);
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
						try
						{
							$sql = "UPDATE users SET user_uid=:nuid WHERE user_uid=:ouid";
							$stmt = $conn->prepare($sql);
							$stmt->bindParam(":nuid", $newuid);
							$stmt->bindParam(":ouid", $olduid);
							$stmt->execute();
							$_SESSION['uid'] = $newuid;

							$sql = "UPDATE images SET image_uid=:nuid WHERE image_uid=:ouid";
							$stmt = $conn->prepare($sql);
							$stmt->bindParam(":nuid", $newuid);
							$stmt->bindParam(":ouid", $olduid);
							$stmt->execute();
							header("Location: ../user_home.php?change=successfull");
							exit();
						}
						catch (PDOException $var)
						{
							echo $var->getMessage();
						}	
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