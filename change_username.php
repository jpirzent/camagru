<?php
	 session_start();
?>

<?php
	if (isset($_SESSION['u_uid']))
	{
		include_once 'header.php';
?>
	<section class="header-container">
		<div class="header-bar">
			<h2>Change_Username</h2>
		</div>
	</section>
	<form class="user-form" action="includes/change_username.inc.php" method="POST">
		<input type="text" name="olduid" placeholder="Old Username">
		<input type="text" name="newuid" placeholder="New Username">
		<input type="password" name="pwd" placeholder="Password">
		<button type="submit" name="submit">Change Username</button>
	</form>
<?php
		include_once 'footer.php';
	}
	else
	{
		header("Location: index.php?PleaseLoginIn");
		exit();
	}
?>