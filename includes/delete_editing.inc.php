<?php

	session_start();

	if (isset($_SESSION['u_uid']) && isset($_GET['img']))
	{
		include_once 'dbh.inc.php';
		$imgID = $_GET['img'];

		try
		{
			$sql = "SELECT * FROM images WHERE image_id=:imgID";
			$select = $conn->prepare($sql);
			$select->bindParam(":imgID", $imgID);
			$select->execute();
			$row = $select->fetch(PDO::FETCH_ASSOC);
		}
		catch (PDOException $var)
		{
			echo $var->getMessage();
		}	
		if ($row)
		{
			$img_new = $row['image_orig'];
			try
			{
				$sql = "UPDATE images SET image_img=:img WHERE image_id=:imgID";
				$change = $conn->prepare($sql);
				$change->bindParam(":img", $img_new);
				$change->bindParam(":imgID", $imgID);
				$change->execute();
				header("Location: ../user_home.php?editing_changed");
				exit();
			}
			catch (PDOException $var)
			{
				echo $var->getMessage();
			}	
		}
	}
	else
	{
		header("Location: ../user_home.php?error");
		exit();
	}

?>