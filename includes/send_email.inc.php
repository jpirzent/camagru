<?php
	session_start();
	if (isset($_SESSION['u_uid']) && isset($_SESSION['u_email']))
	{
		$subject = "Account Verification";
		$email = $_SESSION['u_email'];
		$msg = "
		<html>
		<head>
		<title>Camagru Account Verification</title>
		</head>
		<body>
		<p>Please follow the link bellow to Verify your Account</p><br />
		<a href='http://localhost:8080/camagru/includes/verify.inc.php'>Verify Account</a>
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
	else
	{
		header("Location: ../index.php?login-error");
		exit();
	}

?>