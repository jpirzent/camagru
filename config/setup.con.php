<?php

	function cr_comments($conn)
	{
		$sql = "CREATE TABLE `comments` (
			`com_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			`com_imgID` int(11) NOT NULL,
			`com_text` varchar(256) NOT NULL,
			`com_commenter` varchar(256) NOT NULL
			)";
		
		try
		{
			$create = $conn->prepare($sql);
			$create->execute();
		}
		catch(PDOException $e)
		{
			echo "<script type='text/javascript'>alert(". $e->getMessage().");</script>";
		}
		
	}


	function cr_users($conn)
	{
		$sql = "CREATE TABLE `users` (
			`user_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			`user_first` varchar(256) NOT NULL,
			`user_last` varchar(256) NOT NULL,
			`user_email` varchar(256) NOT NULL,
			`user_uid` varchar(256) NOT NULL,
			`user_pwd` varchar(256) NOT NULL,
			`user_verified` tinyint(1) NOT NULL DEFAULT '0',
			`user_key` varchar(256) NOT NULL,
			`user_notif` int(1) NOT NULL DEFAULT '1'
			)";
	
		try
		{
			$create = $conn->prepare($sql);
			$create->execute();
		}
		catch(PDOException $e)
		{
			echo "<script type='text/javascript'>alert(". $e->getMessage().");</script>";
		}
	}


	function cr_likes($conn)
	{
		$sql = "CREATE TABLE `likes` (
			`likes_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			`likes_op` varchar(256) NOT NULL,
			`likes_liker` varchar(256) NOT NULL,
			`likes_imgID` int(11) NOT NULL
			)";

		try
		{
			$create = $conn->prepare($sql);
			$create->execute();
		}
		catch(PDOException $e)
		{
			echo "<script type='text/javascript'>alert(". $e->getMessage().");</script>";
		}
	}

	function cr_images($conn)
	{
		$sql = "CREATE TABLE `images` (
			`image_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			`image_img` longblob NOT NULL,
			`image_created` datetime NOT NULL,
			`image_uid` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
			`image_orig` longblob NOT NULL
			)";
		
		try
		{
			$create = $conn->prepare($sql);
			$create->execute();
		}
		catch(PDOException $e)
		{
			echo "<script type='text/javascript'>alert(". $e->getMessage().");</script>";
		}
	}
?>
