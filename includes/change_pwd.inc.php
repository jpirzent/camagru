<?php

	if (isset($_POST['submit']))
	{
		include_once 'dbh.inc.php';

		$uid = $_POST['uid'];
		$oldpwd = $_POST['oldpwd'];
		$newpwd = $_POST['newpwd'];

		if (empty($uid) || empty($oldpwd) || empty($newpwd))
		{
			header("Location: ../change_pwd.php?change=emptyfields");
			exit();
		}
		else
		{
			try
			{
				$sql = "SELECT COUNT(*) FROM users WHERE user_uid=:username";
				$stmt = $conn->prepare($sql);
				$stmt->bindParam(":username", $uid);
				$stmt->execute();
				$resCheck = $stmt->fetchColumn();
			}
			catch (PDOException $var)
			{
				echo $var->getMessage();
			}	
			if ($resCheck == 0)
			{
				header("Location: ../change_pwd.php?change=wrong_username");
				exit();
			}
			else
			{
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
					$hashpwdcheck = password_verify($oldpwd, $row['user_pwd']);
					if ($hashpwdcheck == FALSE)
					{
						header("Location: ../change_pwd.php?change=incorrect_pwd");
						exit();
					}
					else if ($hashpwdcheck == TRUE)
					{
						try
						{
							$hashpwd = password_hash($newpwd, PASSWORD_DEFAULT);
							$sql = "UPDATE users SET user_pwd=:hashpwd WHERE user_uid=:username";
							$stmt = $conn->prepare($sql);
							$stmt->bindParam(":hashpwd", $hashpwd);
							$stmt->bindParam(":username", $uid);
							$stmt->execute();
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
		}
	}
	else
	{
		header("Location: ../change_pwd.php?change=error");
		exit();
	}

?>