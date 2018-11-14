<?php
	include_once 'header.php';
?>


<?php

	if (isset($_GET['image']))
	{
		include_once 'includes/dbh.inc.php';
		$imgID = $_GET['image'];

		try
		{
			$sql = "SELECT * FROM images WHERE image_id=:imgID";
			$check = $conn->prepare($sql);
			$check->bindParam(":imgID", $imgID);
			$check->execute();
			$row = $check->fetch(PDO::FETCH_ASSOC);
		}
		catch(PDOException $e)
		{
			echo $sql . "<br>" . $e->getMessage();
		}

		try
		{
			$sql = "SELECT COUNT(*) FROM likes WHERE likes_imgID=:imgID";
			$check = $conn->prepare($sql);
			$check->bindParam(":imgID", $imgID);
			$check->execute();
			$row1 = $check->fetchColumn();
		}
		catch(PDOException $e)
		{
			echo $sql . "<br>" . $e->getMessage();
		}	

		try
		{
			$sql = "SELECT * FROM comments WHERE com_imgID=:imgID";
			$check = $conn->prepare($sql);
			$check->bindParam(":imgID", $imgID);
			$check->execute();
			$row2 = $check->fetchAll(PDO::FETCH_ASSOC);
		}
		catch(PDOException $e)
		{
			echo $sql . "<br>" . $e->getMessage();
		}	
		if (!$row)
		{
			echo "no image found";
		}
		else
		{
			$imgData = $row['image_img'];
			$imgDate = $row['image_created'];
			$img = str_replace(" ", "+", $imgData);

			if ($row1 == 0)
			{
				$likes = 0;
			}
			else
			{
				$likes = $row1;
			}

            echo '<img class="user-img" src="data:image/jpeg;base64,'.$img.'">';
			echo '<a href="includes/delete_picture.inc.php?img='.$imgID.'" class="delete-button">Delete Post</a>';
			echo '<a href="includes/delete_editing.inc.php?img='.$imgID.'" class="delete-button">Delete Editing</a>';
			echo '<p class="user_date">Posted: '.$imgDate.'</p>';
			echo '<p class="user_date">no. of Likes: '.$likes.'</p>';
			echo '<div class="comment-layout">';

			foreach ($row2 as $result)
			{
				$commenter = $result['com_commenter'];
				$comment = $result['com_text'];
				$comment = addslashes($comment);
				$commenter = addslashes($commenter);

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
	else
	{
		header("Location: index.php?PleaseLoginIn");
		exit();
	}

?>
<?php
	include_once 'footer.php';
?>