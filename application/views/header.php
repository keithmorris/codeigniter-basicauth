<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">

		<title><?=$title?></title>
		<meta name="description" content="">
		<meta name="author" content="">

		<meta name="viewport" content="width=device-width,initial-scale=1">
		
		<script type="text/javascript" src="http://crypto-js.googlecode.com/files/2.3.0-crypto-md5.js"></script>
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>

		<link href='http://fonts.googleapis.com/css?family=Droid+Sans' rel='stylesheet' type='text/css'>
		
		<style type="text/css">
			html { font-size: 62.5%; overflow-y: scroll; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
			body { margin: 0; font-size: 1.3em; line-height: 1.231; }
			body, button, input, select, textarea { font-family: 'Droid Sans', sans-serif; color: #222; }
			
			header nav ul {
				padding-left: 0;
			}
			
			header nav li {
				display: inline;
				padding-right: .5em;
			}
			
			#main-container {
				width: 960px;
				margin: 1em auto;
			}
			
			h1#main-title {
				font-size: 2.5em;
			}
			
			#content {
				padding: 1em;
				border: .1em #ccc solid;
				-webkit-box-shadow: 0 0 8px #D0D0D0;
			}
						
			#status ul {
				list-style: none;
				margin: 0;
				padding: 0;
			}
			
			.error {
				padding: 1em;
				border: .1em #b44 solid;
				background-color: #fee;
				margin: 0 0 .5em 0;
			}
			
			.success {
				padding: 1em;
				border: .1em #494 solid;
				background-color: #efe;
				margin: 0 0 .5em 0;
			}
			
			#login-form label,input {
				display: block;
			}
			
			#login-form input[type='submit'] {
				
			}
			
			input[type='text'],input[type='password'] {
				margin-bottom: 1em;
				font-size: 1.2em;
				height: 2em;
				width: 20em;
				padding-left: .5em;
			}
			
			input[type='checkbox'] {
				margin-bottom: 1em;
			}
			
			#form-container {
				width: 30em;
				margin: 0 auto;
				padding: 1em;
			}
			
			#login-status {
				text-align: right;
				margin-bottom: 1em;
				padding-bottom: .5em;
				border-bottom: .1em #ccc solid;
			}
			
			#main-footer {
				border-bottom: 1px #ccc solid;
				margin-bottom: 2em;
			}
			
		</style>

	</head>

	<body>
		<div id="main-container">
			<header>
				<h1 id="main-title">BasicAuth</h1>
				<nav>
					<ul>
						<li><?=anchor('example/index', 'Home')?></li>
						<li><?=anchor('example/unrestricted', 'Unrestricted')?></li>
						<li><?=anchor('example/restricted', 'Restricted')?></li>
						<li><?=anchor('example/adminsonly', 'Admins Only')?></li>
						<li><?=anchor('authenticate/hashpassword', 'MD5 Password Hash Utility')?></li>
					</ul>
				</nav>
			</header>
			
			<div id="content">
				

			

