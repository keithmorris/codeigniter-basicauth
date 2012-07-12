<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">

		<title><?=$title?></title>
		<meta name="description" content="">
		<meta name="author" content="">

		<meta name="viewport" content="width=device-width,initial-scale=1">
		
		<script type="text/javascript" src="<?=base_url('/assets/js/lib/2.3.0-crypto-md5.js')?>"></script>
		<script type="text/javascript" src="<?=base_url()?>assets/js/lib/jquery.min.js"></script>

		<link href='<?=base_url('assets/css/lib/droid-sans.css')?>' rel='stylesheet' type='text/css'>
		<link href='<?=base_url('assets/css/styles.css')?>' rel='stylesheet' type='text/css'>

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
						<li><?=anchor('utilities/hashpassword', 'MD5 Password Hash Utility')?></li>
					</ul>
				</nav>
			</header>
			
			<div id="content">
				

			

