<?php
	include_once 'header.php';
?>
<section class="header-container">
	<div class="header-bar">
		<h2>Verify_Account</h2>
	</div>
</section>

<?php
	if ($_SESSION['verify'] == 0)
	{
		echo '<div class="verify-div">
				<a href="includes/send_email.inc.php">Send_Verification_Email</a>
				</div>';
	}
	else
	{
		echo '<div class="verify-div">
				<p>You have already Verified Your account!</p>
				</div>';
	}
?>

<?php
	include_once 'footer.php';
?>