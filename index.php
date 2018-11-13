<?php
	include_once 'header.php';
?>
	<section class="header-container">
		<div class="header-bar">
			<h2>Feed</h2>
		</div>
	</section>

<?php

	include_once 'includes/dbh.inc.php';

	if (!isset($_GET['curr']))
	{
		$offset = 0;
	}
	else
	{
		$offset = $_GET['curr'];
	}

	$offset = $offset * 5;

	try
	{
		$sql = "SELECT * FROM images LIMIT $offset, 5";
		$check = $conn->prepare($sql);
		$check->execute();
		$result = $check->fetchAll(PDO::FETCH_ASSOC);
	}
	catch(PDOException $e)
	{
		echo $sql . "<br>" . $e->getMessage();
	}

	try
	{
		$sql = "SELECT COUNT(*) FROM images";
		$check = $conn->prepare($sql);
		$check->execute();
	}
	catch(PDOException $e)
	{
		echo $sql . "<br>" . $e->getMessage();
	}

	$posts = $check->fetchColumn();
	$pagination = $posts / 5;
	if (!$result)
	{
		echo "no image found";
	}
	else foreach ($result as $row)
    {
        $imgData = $row['image_img'];
        $imgName = $row['image_uid'];
        $imgDate = $row['image_created'];
		$imgID = $row['image_id'];
		$imgName = addslashes($imgName);
        $img = str_replace(" ", "+", $imgData);
        echo '<h1 class="gallery-h1">'.$imgName.'</h1>';
        echo '<a href="view_img.php?image='.$imgID.'"><img class="gallery-img" src="data:image/png;base64,'.$img.'"></a>';
        echo '<p class="gallery-date">Posted: '.$imgDate.'</p>';
        echo '<hr class="gallery-hr">';
    }
	echo '<div class="pagination">';
	for ($x = 0; $x <= $pagination; $x++)
	{
		$temp = $x + 1;
		echo '<a href="index.php?curr='.$x.'">'.$temp.'</a>';
	}
	echo '</div>';

?>


<?php
	include_once 'footer.php';
?>