<?php

	include_once 'dbh.inc.php';

	session_start();
	if (isset($_SESSION['u_uid']) && isset($_SESSION['u_email']) && $_SESSION['sent_email'] == 1)
	{
		$uid = $_SESSION['u_uid'];


		$sql = "SELECT COUNT(*) FROM users WHERE user_uid='$uid'";
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
				$sql = "SELECT * FROM users WHERE user_uid='$uid'";
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
				$sql = "UPDATE users SET user_verified='1' WHERE user_uid='$uid'";
				$stmt = $conn->prepare($sql);
				$stmt->execute();
				$_SESSION['verify'] = 1;
				header("Location: ../signup.php?verification=success");
				exit();
			}
		}
	}
	else
	{
		//header("Location: ../index.php?login-error");
		echo "uid = ".$_SESSION['u_uid']."<br>email = ".$_SESSION['u_email']."<br>";
		exit();
	}

?>