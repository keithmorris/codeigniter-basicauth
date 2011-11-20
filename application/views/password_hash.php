
<div id="form-container">
	
	<h2>MD5 String Hash Utility</h2>
	<p>
		Please enter a string (password) below to have it MD5 hashed.
	</p>

	<form id="hash-form" action="">
		<label for="string-to-hash">String to Hash</label>
		<input id="string-to-hash" type="password" name="username" placeholder="Enter a Password to MD5 Hash" />
		<label for="mask-password">Mask Password?</label>
		<input id="mask-password" type="checkbox" name="mask-password" checked />
		<label for="hashed-string">MD5 Hash</label>
		<input id="hashed-string" type="text" />
	</form>
</div>

<script type="text/javascript">
	$(function() 
	{  
		function hashPhrase()
		{
			stringToHash = $('#string-to-hash').val();
			$('#hashed-string').val(Crypto.MD5(stringToHash));
		}
		
		$("#string-to-hash").live('keyup', hashPhrase);  
		
		$('#hashed-string').click(function() {
			$(this).focus();
			$(this).select();
		});
	});
	
	$('#mask-password').change(function() {
		var type;
		
		if (this.checked) 
			type = 'password';
		else
			type = 'text';
		
		$('#string-to-hash').replaceWith('<input id="string-to-hash" type="' + type + '" name="string-to-hash" value="' + $('#string-to-hash').val() + '" placeholder="Enter a Password to MD5 Hash" />');
	});
</script>
