<?php
	include_once 'header.php';
?>
	<section class="header-container">
		<div class="header-bar">
			<h2>Change_Email</h2>
		</div>
	</section>
	<form class="user-form" action="includes/change_email.inc.php" method="POST">
		<input type="text" name="uid" placeholder="Username">
		<input type="text" name="email" placeholder="E-mail">
		<input type="password" name="pwd" placeholder="Password">
		<button type="submit" name="submit">Change_Email</button>
	</form>
<?php
	include_once 'footer.php';
?>