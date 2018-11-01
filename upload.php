<?php
	include_once 'header.php';
?>
<section class="header-container">
	<div class="header-bar">
		<h2>Upload A Picture</h2>
	</div>

<form action="includes/upload.inc.php" method="post" enctype="multipart/form-data" class="upload-form">
Select an image to upload
	<input type="file" name="image">
	<input type="submit" name="submit" value="UPLOAD">
</form>

</section>
<?php
	include_once 'footer.php';
?>