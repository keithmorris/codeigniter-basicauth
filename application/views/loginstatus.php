<?php 
	$current_user = $this->basic_auth->get_logged_in_user();
?>

<div id="login-status">

<?php if ($current_user): ?>
	User: <?=$current_user?> | <?=  anchor('authenticate/logout', 'Logout')?>
<?php else: ?>
	<?=anchor('authenticate/login', 'Login')?>
<?php endif; ?>

</div>

