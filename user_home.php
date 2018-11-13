
<?php
	include_once 'header.php';
?>
<section class="header-container">
	<div class="header-bar">
		<h2>User_Home</h2>
	</div>
</section>
<div class="modify-user">
	<a href="change_details.php">Modify Details</a>
	<a href="preferences.php">Preferences</a>
</div>

<section class="header-container">
	<div class="header-bar">
		<h2>Your Posts</h2>
	</div>
</section>

<?php
	include_once 'includes/dbh.inc.php';
	
	$uid = $_SESSION['u_uid'];
	
	try
	{
		$sql = "SELECT * FROM images WHERE image_uid=:user";
		$feed = $conn->prepare($sql);
		$feed->bindParam(":user", $uid);
		$feed->execute();
		$res = $feed->fetchALL(PDO::FETCH_ASSOC);
	}
	catch(PDOException $e)
	{
		echo $sql . "<br>" . $e->getMessage();
	}

	if ($res)
	{
		foreach ($res as $row)
		{
			$imgData = $row['image_img'];
			$imgDate = $row['image_created'];
			$imgID = $row['image_id'];
			$img = str_replace(" ", "+", $imgData);
			echo '<a href="user_img.php?image='.$imgID.'"><img class="gallery-img" src="data:image/jpeg;base64,'.$img.'"></a>';
			echo '<p class="gallery-date">Posted: '.$imgDate.'</p>';
			echo '<hr class="gallery-hr">';	
		}
	}

?>

<?php
	include_once 'footer.php';
?>