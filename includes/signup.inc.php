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
					/* $res = mysqli_query($conn, $sql);
					$resCheck = mysqli_num_rows($res); */

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
						$hashpwd = password_hash($pwd, PASSWORD_DEFAULT);
						$sql = "INSERT INTO users (user_first, user_last, user_email, user_uid, user_pwd) VALUES ('$first', '$last', '$email', '$uid', '$hashpwd');";
						try
						{
							$conn->exec($sql);
							echo "new record created successfully";
						}
						catch(PDOException $e)
    					{
							echo $sql . "<br>" . $e->getMessage();
						}
						header("Location: ../signup.php?signup=success");
						exit();
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