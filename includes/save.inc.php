<?php
	session_start();

	if (isset($_SESSION['u_uid']))
	{
		include_once 'dbh.inc.php';

		$img = $_POST['img'];
		$img = str_replace("data:image/png;base64,", "", $img);
		$uid = $_SESSION['u_uid'];

		$sql = "SELECT COUNT(*) FROM users WHERE user_uid='$uid' LIMIT 1";
		$check = $conn->prepare($sql);
		$check->execute();
		$row = $check->fetchColumn();
		if ($row == 1)
		{
			$time = date("Y-m-d H:i:s");
			$sql = "INSERT into images (image_img, image_created, image_uid) VALUES ('$img', '$time', '$uid')";
			$upload = $conn->prepare($sql);
			$upload->execute();
		}
	}
?>