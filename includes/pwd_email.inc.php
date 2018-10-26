<?php

	if(isset($_POST['submit']))
	{
		include_once 'dbh.inc.php';
		
		$email = $_POST['email'];
		$uid = $_POST['uid'];

		if (empty($email) || empty($uid))
		{
			header("Location: ../forgot_pwd.php?change=emptyfields");
			exit();
		}
		else
		{
			$sql = "SELECT COUNT(*) FROM users WHERE user_uid='$uid'";
			$stmt = $conn->prepare($sql);
			$stmt->execute();
			$resCheck = $stmt->fetchColumn();
			
			if ($resCheck == 0)
			{
				header("Location: ../change_pwd.php?change=wrong_username");
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
					if (strcmp($uid, $row['user_uid']) == 0 && strcmp($email, $row['user_email']) == 0)
					{
						$subject = "Change Password";
						$email = $email;
						$msg = "
						<html>
						<head>
						<title>Camagru Change Password</title>
						</head>
						<body>
						<p>Please follow the link bellow to Change your Password</p><br />
						<a href='http://localhost:8080/camagru/change_forg_pwd.php'>Change Password</a>
						</body>
						</html>
						";
						$head = "MIME-Version: 1.0" . "\r\n";
						$head .= "Content-type:text/html;charset=UTF-8" . "\r\n";
						mail($email, $subject, $msg, $head);
						$_SESSION['sent_email'] = 1;
						header("Location: ../index.php?email-sent");
						exit();
					}
				}
			}
		}
	}

?>