<!DOCTYPE html>

<html lang="sv">
<head>
	<meta charset="utf-8">
	<meta name="description" content="Medietekniksektionens officiella hemsida">
	<meta name="author" content="Medietekniks Webbutskott">
	
	<title><?php if(isset($title)) echo $title; else echo "Medieteknik Sektionen"; ?></title>
	
	<link rel="stylesheet" href="<?php echo base_url(); ?>web/css/reset.css" type="text/css" media="screen">
	<link rel="stylesheet" href="<?php echo base_url(); ?>web/css/base.css" type="text/css" media="screen">
	
	<link rel="shortcut icon" href="/web/img/favicon.ico" />
	<link rel="apple-touch-icon" href="<?php echo base_url(); ?>web/img/apple-touch-icon/apple-touch-icon-precomposed.png" />
	<link rel="apple-touch-icon" sizes="72x72" href="<?php echo base_url(); ?>web/img/apple-touch-icon/apple-touch-icon-72x72-precomposed.png" />
	<link rel="apple-touch-icon" sizes="114x114" href="<?php echo base_url(); ?>web/img/apple-touch-icon/apple-touch-icon-114x114-precomposed.png" />
</head>
<body>
	<?php if(isset($container) && $container === true) { 
		echo '<div id="container">';
	}
	?>