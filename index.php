<?php
	include_once 'header.php';
?>
<section class="header-container">
	<div class="header-bar">
		<h2>Home</h2>
	</div>
<?php

	if (isset($_SESSION['u_id']))
	{
		echo '<div class="video-class">
			<video id="video" width="640" height="480">Video is Loading</video>
			<canvas id="canvas" style="display:none;" width="640" height="480">Canvas Is Loading</canvas>
			<input type="button" value="Take the Shot!!" id="snap">
			<input type="button" value="Cancel" id="delete_snap">
		</div>';
	}
	else
	{
		echo '<p class="webcam-error">
				Please Login/Signup To access the Webcam
			</p>';
	}
	

?>


</section>
<?php
	include_once 'footer.php';
?>