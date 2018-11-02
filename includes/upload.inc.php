<?php

	session_start();

	if (isset($_POST['submit']) && isset($_SESSION['u_uid']))
	{
		include_once 'dbh.inc.php';

		$checkimg = getimagesize($_FILES['image']['tmp_name']);
		if ($checkimg == false)
		{
			header("Location: ../upload.php?please_select_an_image_to_upload");
			exit();
		}
		else
		{
			$img = $_FILES['image']['tmp_name'];
			$imgcont = addslashes(file_get_contents($img));
			$datatime = date("Y-m-d H:i:s");
			$uid = $_SESSION['u_uid'];
			$sql = "INSERT into images (image_img, image_created, image_uid) VALUES ('$imgcont', '$datatime', '$uid')";
			$conn->exec($sql);
			header("Location: ../index.php?image_upload=successful");
			exit();
		}
	}
	else
	{
		header("Location: ../index.php?error");
		exit();
	}

?>