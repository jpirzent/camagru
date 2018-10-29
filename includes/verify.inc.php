<?php

	include_once 'dbh.inc.php';

	if (isset($_GET['key']))
	{
		$key = $_GET['key'];
		$sql = "SELECT COUNT(*) FROM users WHERE user_key='$key'";
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
				$sql = "SELECT * FROM users WHERE user_key='$key'";
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
				$sql = "UPDATE users SET user_verified='1' WHERE user_key='$key'";
				$stmt = $conn->prepare($sql);
				$stmt->execute();
				header("Location: ../index.php?verification=success");
				exit();
			}
		}
	}
	else
	{
		header("Location: ../index.php?login-error");
		exit();
	}

?>