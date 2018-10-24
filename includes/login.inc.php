<?php
    session_start();
if (isset($_POST['submit']))
{
    include 'dbh.inc.php';
    
    $uid = $_POST['uid'];
    $pwd = $_POST['pwd'];
    if (empty($uid) || empty($pwd))
    {
        header("Location: ../index.php?login=empty");
		exit();
    }
    else
    {
        $sql = "SELECT * FROM users WHERE user_uid='$uid' OR user_email='$uid'";
        $res = mysqli_query($conn, $sql);
        $resCheck = mysqli_num_rows($res);
        if ($resCheck == 0)
        {
            header("Location: ../signup.php?login=error");
		    exit();
        }
        else
        {
            if ($row = mysqli_fetch_assoc($res))
            {
                $hashpwdcheck = password_verify($pwd, $row['user_pwd']);
                if ($hashpwdcheck == FALSE)
                {
                    header("Location: ../index.php?login=error");
	                exit();
                }
                else if ($hashpwdcheck == TRUE)
                {
                    $_SESSION['u_id'] = $row['user_id'];
                    $_SESSION['u_first'] = $row['user_first'];
                    $_SESSION['u_last'] = $row['user_last'];
                    $_SESSION['u_email'] = $row['user_email'];
					$_SESSION['u_uid'] = $row['user_uid'];
                    header("Location: ../index.php?login=success");
                	exit();
                }
            }
        }
    }
}
else
{
    header("Location: ../index.php?login=error");
	exit();
}
?>