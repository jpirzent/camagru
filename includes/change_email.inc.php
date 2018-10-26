<?php

    if (isset($_POST['submit']))
    {
        include_once 'dbh.inc.php';

        $uid = $_POST['uid'];
        $pwd = $_POST['pwd'];
        $email = $_POST['email'];

        if (empty($uid) || empty($pwd) || empty($email))
        {
            header("Location: ../change_email.php?change=emptyfields");
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
				header("Location: ../change_email.php?change=wrong_username");
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
					$hashpwdcheck = password_verify($pwd, $row['user_pwd']);
					if ($hashpwdcheck == FALSE)
					{
						header("Location: ../change_email.php?change=incorrect_pwd");
						exit();
                    }
                    else if ($hashpwdcheck == TRUE)
                    {
                        $sql = "UPDATE users SET user_email='$email' WHERE user_uid='$uid'";
						$stmt = $conn->prepare($sql);
						$stmt->execute();
						header("Location: ../index.php?change=successfull");
						exit();
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