<?php
echo '<!DOCTYPE html>

<!-- START head -->
<html lang="sv">
<head>
	<meta charset="utf-8">
	<meta name="description" content="',$head_description,'">
	<meta name="author" content="', $head_author, '">
	
	<title>', $head_title, '</title>
	
	<link rel="stylesheet" href="', base_url(),'web/css/style.css" type="text/css" media="screen">
	
	<link rel="shortcut icon" href="', base_url(), '/web/img/favicon.ico" />
	<link rel="apple-touch-icon" href="', base_url(), 'web/img/apple-touch-icon/apple-touch-icon-precomposed.png" />
	<link rel="apple-touch-icon" sizes="72x72" href="', base_url(). 'web/img/apple-touch-icon/apple-touch-icon-72x72-precomposed.png" />
	<link rel="apple-touch-icon" sizes="114x114" href="', base_url(), 'web/img/apple-touch-icon/apple-touch-icon-114x114-precomposed.png" />
</head>
<body>
<!-- END head -->

<!-- START header -->
<header id="main-header">
	<div class="wrapper">
		<a href="', base_url(), '"><img id="main-header-logo" src="', base_url(), 'web/img/mt-logo-header.png" alt="Medieteknik.nu" /></a>
		<h1>Civilingenjör i Medieteknik</h1>
		<h2>Tekniska högskolan vid Linköpings Universitet</h2>
	</div>
</header>
<!-- END header -->

<!-- START main -->
<div class="wrapper">',
	$menu,
	'<div id="main-content">
		<div id="main-left">',
			$main_content,
		'</div>
		<div id="main-right">',
			$sidebar_content.
		'</div>
	</div>
</div>
<!-- END main -->

</body>
</html>
';

/*
	<!-- JavaScript at the bottom for fast page loading -->

	<!-- Grab Google CDNs jQuery, with a protocol relative URL; fall back to local if offline -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="<?php echo base_url(); ?>web/js/libs/jquery.min.js"><\/script>')</script>


	<!-- scripts concatenated and minified via ant build script-->
	<script type="text/javascript" src="<?php echo base_url(); ?>web/js/script.js"></script>
	<!-- end scripts-->
*/
