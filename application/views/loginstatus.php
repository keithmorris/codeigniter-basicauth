<?php

$current_user = $this->basic_auth->get_logged_in_user();

if ($current_user):
?>
	<div id="login-status">
		User: <?=$current_user?> | <?=  anchor('authenticate/logout', 'Logout')?>
	</div>
<?php	
endif;



