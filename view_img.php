<?php
	include_once 'header.php';
?>


<?php

	if (isset($_GET['image']))
	{
		include_once 'includes/dbh.inc.php';

		$imgID = $_GET['image'];
		$sql = "SELECT * FROM images WHERE image_id='$imgID'";
		$check = $conn->prepare($sql);
		$check->execute();
		$row = $check->fetch(PDO::FETCH_ASSOC);
		if (!$row)
		{
			echo "no image found";
		}
		else
		{
			$imgData = $row['image_img'];
			$imgName = $row['image_uid'];
			$imgDate = $row['image_created'];
			$imgLikes = $row['image_likes'];

			echo '<h1 class="gallery-h1">'.$imgName.'</h1>';
			echo '<a href="view_img.php?image='.$imgID.'"><img class="gallery-img" src="data:image/jpeg;base64,'.str_replace(" ", "+", base64_encode($imgData)).'"></a>';
			echo '<p class="gallery-date">Posted: '.$imgDate.'</p>';
			echo '<a href="includes/upvote.php?image='.$imgID.'"><img src="imgs/upvote.png" alt="Upvote" title="Upvote" class="gallery-upvote"></a>';
			echo '<p class="gallery-date">no. of Likes: '.$imgLikes.'</p>';
		}
	}

?>

<?php
	include_once 'footer.php';
?>