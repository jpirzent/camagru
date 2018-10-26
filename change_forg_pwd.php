<?php
	include_once 'header.php';
?>
<section class="header-container">
	<div class="header-bar">
		<h2>Change_Password</h2>
	</div>
</section>

<form class="user-form" action="includes/change_forg_pwd.inc.php" method="POST">
	<input type="text" name="uid" placeholder="Username">
	<input type="password" name="newpwd" placeholder="New_Password">
	<button type="submit" name="submit">Change_Password</button>
</form>

<?php
	include_once 'footer.php';
?>