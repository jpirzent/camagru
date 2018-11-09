<?php
	include_once 'header.php';
?>
<section class="header-container">
	<div class="header-bar">
		<h2>Upload A Picture</h2>
	</div>

<div class="overlay-imgs">
	<h1>Filters</h1>
	<button onclick="display_img(1)"><img src="./imgs/cigarette.png" alt="cig" title="cigarette"></button>
	<button onclick="display_img(2)"><img src="./imgs/hat.png" alt="hat" title="hat"></button>
	<button onclick="display_img(3)"><img src="./imgs/glasses.png" alt="glasses" title="glasses"></button>
</div>

<form action="includes/upload.inc.php" method="post" enctype="multipart/form-data" class="upload-form">
Select an image to upload
	<img src="./imgs/cigarette.png" alt="cig" title="cigarette" class="upload-cig" id="cig">
	<img src="./imgs/hat.png" alt="hat" title="hat" class="upload-hat" id="hat">
	<img src="./imgs/glasses.png" alt="glasses" title="glasses" class="upload-glasses" id="glasses">
	<input type="file" name="image" id="upload" onchange="displayimg(event)">
	<img id="myimage" class="upload-img">
	<input type="submit" name="submit" value="UPLOAD" id="img-upload">
</form>

<div class="previous-imgs">
	<h1>Previous Posts</h1>
<?php
	include_once 'includes/dbh.inc.php';
	
	$uid = $_SESSION['u_uid'];
	$sql = "SELECT * FROM images WHERE image_uid='$uid'";
	$feed = $conn->prepare($sql);
	$feed->execute();
	$res = $feed->fetchALL(PDO::FETCH_ASSOC);
	if ($res)
	{
		foreach ($res as $row)
		{
			$imgData = $row['image_img'];
			$imgID = $row['image_id'];
			$img = str_replace(" ", "+", $imgData);
			echo '<a href="view_img.php?image='.$imgID.'"><img src="data:image/png;base64,'.$img.'"></a>';
		}
	}

?>

</section>
<?php
	include_once 'footer.php';
?>