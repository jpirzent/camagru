<?php
	session_start();

	if (isset($_SESSION['u_uid']))
	{
		include_once 'dbh.inc.php';

		$img = $_POST['img'];
		$img_orig = $_POST['img'];
		$uid = $_SESSION['u_uid'];

		$img_orig = str_replace("data:image/png;base64,", "", $img);
		$img = str_replace(" ", "+", $img);
		$img = base64_decode(str_replace("data:image/png;base64,", "", $img));

		$metal = $_POST['metal'];
		$yolo = $_POST['yolo'];
		$emoji = $_POST['emoji'];

		if ($metal == 1)
		{
			$sticker = imagecreatefrompng("../imgs/metal.png");
			$img = imagecreatefromstring($img);
			$size = getimagesize("../imgs/metal.png");

			imagealphablending($img, true);
			imagesavealpha($img, true);
			imagesavealpha($sticker, true);
			imagecopy($img, $sticker, 400, 20, 0, 0, $size[0], $size[1]);
			imagepng($img, 'save.png');
			$img = file_get_contents('save.png');
		}
		if ($yolo == 1)
		{
			$sticker = imagecreatefrompng("../imgs/yolo.png");
			$img = imagecreatefromstring($img);
			$size = getimagesize("../imgs/yolo.png");

			imagealphablending($img, true);
			imagesavealpha($img, true);
			imagesavealpha($sticker, true);
			imagecopy($img, $sticker, 50, 50, 0, 0, $size[0], $size[1]);
			imagepng($img, 'save.png');
			$img = file_get_contents('save.png');
		}
		if ($emoji == 1)
		{
			$sticker = imagecreatefrompng("../imgs/emoji.png");
			$img = imagecreatefromstring($img);
			$size = getimagesize("../imgs/emoji.png");

			imagealphablending($img, true);
			imagesavealpha($img, true);
			imagesavealpha($sticker, true);
			imagecopy($img, $sticker, 450, 300, 0, 0, $size[0], $size[1]);
			imagepng($img, 'save.png');
			$img = file_get_contents('save.png');
		}
		try
		{
			$sql = "SELECT COUNT(*) FROM users WHERE user_uid=:username LIMIT 1";
			$check = $conn->prepare($sql);
			$check->bindParam(":username", $uid);
			$check->execute();
			$row = $check->fetchColumn();
		}
		catch (PDOException $var)
		{
			echo $var->getMessage();
		}

		if ($row == 1)
		{
			$img = base64_encode($img);
			$img = preg_replace("/ /", "+", $img);
			$time = date("Y-m-d H:i:s");

			try
			{
				$sql = "INSERT into images (image_img, image_created, image_uid, image_orig) VALUES (:img, :timer, :username, :img_orig)";
				$upload = $conn->prepare($sql);
				$upload->bindParam(":img", $img);
				$upload->bindParam(":timer", $time);
				$upload->bindParam(":username", $uid);
				$upload->bindParam(":img_orig", $img_orig);
				$upload->execute();
			}
			catch (PDOException $var)
			{
				echo $var->getMessage();
			}	
			echo "image uploaded succesfully";
		}
	}
	else echo "error";
?>