
<div id="login-status">

<?php
$current_user = $this->basic_auth->get_logged_in_user();

if ($current_user):
?>
	User: <?=$current_user?> | <?=  anchor('authenticate/logout', 'Logout')?>
<?php	
else:
?>
	<?=anchor('authenticate/login', 'Login')?>
<?php
endif;
?>
</div>

