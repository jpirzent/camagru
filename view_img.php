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
		
		$sql = "SELECT COUNT(*) FROM likes WHERE likes_imgID='$imgID'";
		$check = $conn->prepare($sql);
		$check->execute();
		$row1 = $check->fetchColumn();
		

		$sql = "SELECT * FROM comments WHERE com_imgID='$imgID'";
		$check = $conn->prepare($sql);
		$check->execute();
		$row2 = $check->fetchAll(PDO::FETCH_ASSOC);
		if (!$row)
		{
			echo "no image found";
		}
		else
		{
			$imgData = $row['image_img'];
			$imgName = $row['image_uid'];
			$imgDate = $row['image_created'];

			if ($row1 == 0)
			{
				$likes = 0;
			}
			else
			{
				$likes = $row1;
			}

			echo '<h1 class="gallery-h1">'.$imgName.'</h1>';
			echo '<a href="view_img.php?image='.$imgID.'"><img class="gallery-img" src="data:image/jpeg;base64,'.str_replace(" ", "+", base64_encode($imgData)).'"></a>';
			echo '<p class="gallery-date">Posted: '.$imgDate.'</p>';
			echo '<a href="includes/upvote.inc.php?image='.$imgID.'"><img src="imgs/upvote.png" alt="Upvote" title="Upvote" class="gallery-upvote"></a>';
			echo '<p class="gallery-date">no. of Likes: '.$likes.'</p>';
			echo '<form action="includes/submit_comment.inc.php" id="comment-form" class="comment-form" method="post">';
			echo '<textarea name="comment" form="comment-form" placeholder="Enter Your Comment Here"></textarea>';
			echo "<input type='hidden' value='$imgID' name='image'>";
			echo '<input type="submit">';
			echo '</form>';
			echo '<div class="comment-layout">';

			foreach ($row2 as $result)
			{
				$commenter = $result['com_commenter'];
				$comment = $result['com_text'];
				
				echo '<h1>';
				echo $commenter;
				echo ':</h1>';
				echo '<p>> ';
				echo $comment;
				echo '</p>';
			}
			echo '</div>';
		}
	}

?>

<?php
	include_once 'footer.php';
?>