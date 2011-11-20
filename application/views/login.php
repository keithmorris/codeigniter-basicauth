
<div id="form-container">
	
	<h2>Login Form</h2>

	<form id="login-form" action="<?=base_url('authenticate/login')?>" method="post">
		<label for="username">Username</label>
		<input id="username" type="text" name="username" placeholder="Enter Username" />
		<label for="password">Password</label>
		<input id="password" type="password" name="password" placeholder="Enter Password" />
		<input type="submit" name="submit" value="Submit" />
	</form>
	<p>
		After you login, you will be redirected to <strong><?=base_url($redirect)?></strong>
	</p>

</div>

