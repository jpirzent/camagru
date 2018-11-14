<?php
	if (isset($_SESSION['u_uid']))
	{
		include_once 'header.php';
?>
<section class="header-container">
	<div class="header-bar">
		<h2>Preferences</h2>
	</div>
</section>
<?php

	if($_SESSION['u_notif'] == 1)
	{
		echo '<form class="preferences-form" action="includes/change_notif.inc.php" method="POST">
			<button type="submit" name="submit">Turn_Off_Post_Notification</button>
			</form>';
	}
	else
	{
		echo '<form class="preferences-form" action="includes/change_notif.inc.php" method="POST">
			<button type="submit" name="submit">Turn_On_Post_Notification</button>
			</form>';
	}

?>

<?php
		include_once 'footer.php';
	}
	else
	{
		header("Location: index.php?PleaseLoginIn");
		exit();
	}
?>