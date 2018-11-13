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

			$width = imagesx($sticker);
			$height = imagesy($sticker);

			$new_h = imagesy($img) / 2;
			$new_w = imagesy($img) * $width / $height / 2;

			$sticker_resize = imagecreatetruecolor($new_w, $new_h);
			imagealphablending($sticker_resize, false);
			imagesavealpha($sticker_resize, true);
			imagecopyresampled($sticker_resize, $sticker, 0, 0, 0, 0, $new_w, $new_h, $width, $height);

			imagealphablending($img, true);
			imagesavealpha($img, true);
			imagecopy($img, $sticker_resize, imagesx($img) - $new_w, 0, 0, 0, $new_w, $new_h);
			
			imagepng($img, 'save.png');
			$img = file_get_contents('save.png');
		}
		if ($yolo == 1)
		{
			$sticker = imagecreatefrompng("../imgs/yolo.png");
			$img = imagecreatefromstring($img);

			$width = imagesx($sticker);
			$height = imagesy($sticker);

			$new_h = imagesy($img) / 4;
			$new_w = imagesy($img) * $width / $height / 4;

			$sticker_resize = imagecreatetruecolor($new_w, $new_h);
			imagealphablending($sticker_resize, false);
			imagesavealpha($sticker_resize, true);
			imagecopyresampled($sticker_resize, $sticker, 0, 0, 0, 0, $new_w, $new_h, $width, $height);

			imagealphablending($img, true);
			imagesavealpha($img, true);
			imagecopy($img, $sticker_resize, 0, 0, 0, 0, $new_w, $new_h);
			
			imagepng($img, 'save.png');
			$img = file_get_contents('save.png');
		}
		if ($emoji == 1)
		{
			$sticker = imagecreatefrompng("../imgs/emoji.png");
			$img = imagecreatefromstring($img);

			$width = imagesx($sticker);
			$height = imagesy($sticker);

			$img_w = imagesx($img);
			$img_h = imagesy($img);

			$new_h = imagesy($img) / 2;
			$new_w = imagesy($img) * $width / $height / 2;

			$sticker_resize = imagecreatetruecolor($new_w, $new_h);
			imagealphablending($sticker_resize, false);
			imagesavealpha($sticker_resize, true);
			imagecopyresampled($sticker_resize, $sticker, 0, 0, 0, 0, $new_w, $new_h, $width, $height);

			imagealphablending($img, true);
			imagesavealpha($img, true);
			imagecopy($img, $sticker_resize, $img_w - $new_w, $img_h - $new_h, 0, 0, $new_w, $new_h);
			
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