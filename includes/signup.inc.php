<?php
	if (isset($_POST['submit'])) 
	{
		include_once 'dbh.inc.php';

		$first = $_POST['first'];
		$last = $_POST['last'];
		$email = $_POST['email'];
		$uid = $_POST['uid'];
		$pwd = $_POST['pwd'];

		if (empty($first) || empty($last) || empty($email) || empty($uid) || empty($pwd))
		{
			header("Location: ../signup.php?signup=empty");
			exit();
		}
		else
		{
			if (!preg_match("/^[a-zA-Z]*$/", $first) || !preg_match("/^[a-zA-Z]*$/", $last))
			{
				header("Location: ../signup.php?signup=invalid-names");
				exit();
			}
			else
			{
				if (!filter_var($email, FILTER_VALIDATE_EMAIL))
				{
					header("Location: ../signup.php?signup=invalid-email");
					exit();
				}
				else
				{
					$sql = "SELECT COUNT(*) FROM users WHERE user_uid='$uid'";

					$stmt = $conn->prepare($sql);
					$stmt->execute();
					$resCheck = $stmt->fetchColumn();
					if ($resCheck > 0)
					{
						header("Location: ../signup.php?signup=invalid-username");
						exit();
					}
					else
					{
						if (preg_match( '~[A-Z]~', $pwd) && preg_match( '~[a-z]~', $pwd) && preg_match( '~\d~', $pwd) && (strlen( $pwd) > 8))
						{
							$hashpwd = password_hash($pwd, PASSWORD_DEFAULT);
							$key = mt_rand(1000,9999);
							$key .= $uid;
							$hkey = hash('whirlpool', $key);
							$sql = "INSERT INTO users (user_first, user_last, user_email, user_uid, user_pwd, user_key) VALUES ('$first', '$last', '$email', '$uid', '$hashpwd', '$hkey');";
							try
							{
								$conn->exec($sql);
								echo "new record created successfully";
							}
							catch(PDOException $e)
							{
								echo $sql . "<br>" . $e->getMessage();
							}
							$subject = "Account Verification";
							$msg = "
							<html>
							<head>
							<title>Camagru Account Verification</title>
							</head>
							<body>
							<p>Please follow the link bellow to Verify your Account</p><br />
							<a href='http://localhost:8080/camagru/includes/verify.inc.php?key=".$hkey."'>Verify Account</a>
							</body>
							</html>
							";
							$head = "MIME-Version: 1.0" . "\r\n";
							$head .= "Content-type:text/html;charset=UTF-8" . "\r\n";
							mail($email, $subject, $msg, $head);
							header("Location: ../index.php?signup=success");
							exit();
						}
						else
						{
							header("Location: ../signup.php?signup=invalidpassword");
							exit();
						}
					}
				}
			}
		}
	}
	else
	{
		header("Location: ../index.php");
		exit(); 
	} 