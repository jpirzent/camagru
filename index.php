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
    $sql = "SELECT * FROM images";
    $check = $conn->prepare($sql);
    $check->execute();
    $result = $check->fetchAll(PDO::FETCH_ASSOC);
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
        echo '<h1 class="gallery-h1">'.$imgName.'</h1>';
        echo '<a href="view_img.php?image='.$imgID.'"><img class="gallery-img" src="data:image/jpeg;base64,'.str_replace(" ", "+", base64_encode($imgData)).'"></a>';
        echo '<p class="gallery-date">Posted: '.$imgDate.'</p>';
        echo '<hr class="gallery-hr">';
    }

?>


<?php
    include_once 'footer.php';
?>