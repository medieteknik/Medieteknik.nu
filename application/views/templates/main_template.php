<!DOCTYPE html>

<!-- START head -->
<html lang="sv">
	<head>
		<meta charset="utf-8">
		<meta name="description" content="<?php echo $head_description; ?>">
		<meta name="author" content="<?php echo $head_author; ?>">

		<!-- responsive -->
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title><?php echo $head_title; ?></title>

		<!-- <link rel="stylesheet" href="<?php echo base_url(); ?>web/css/reset.min.css" type="text/css" media="screen" /> -->
		<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">

	    <!-- <link rel="stylesheet" href="<?php echo base_url(); ?>web/css/style.css" type="text/css" /> -->

		<!-- load less -->
		<link rel="stylesheet/less" type="text/css" href="<?php echo base_url(); ?>web/css/style.less" />
		<script src="<?php echo base_url(); ?>web/js/libs/less.js" type="text/javascript"></script>

	    <!-- Load DropZone -->
	    <link rel="stylesheet" href="<?php echo base_url(); ?>web/css/dropzone.css" type="text/css" />

		<link rel="shortcut icon" href="<?php echo base_url(); ?>/web/img/favicon.ico" />
		<link rel="apple-touch-icon" href="<?php echo base_url(); ?>web/img/apple-touch-icon/apple-touch-icon-precomposed.png" />
		<link rel="apple-touch-icon" sizes="72x72" href="<?php echo base_url(); ?>web/img/apple-touch-icon/apple-touch-icon-72x72-precomposed.png" />
		<link rel="apple-touch-icon" sizes="114x114" href="<?php echo base_url(); ?>web/img/apple-touch-icon/apple-touch-icon-114x114-precomposed.png" />
	</head>
	<!-- END head -->
	<body>
		<div class="page-wrap">
			<!-- START header -->
			<header id="main-header">
				<div class="container">
					<div class="row">
						<div class="col-sm-6">
							<!-- logo and page title -->
							<?php echo anchor("/","<img id=\"main-header-logo\" src=\"".base_url()."web/img/mt-logo-header.png\" alt=\"Medieteknik.nu\" />"); ?>
							<h1>Civilingenjör i Medieteknik</h1>
							<h2>Tekniska högskolan vid Linköpings Universitet</h2>
						</div>
						<div class="col-sm-6">
							<!-- small user area -->
							<div class="pull-right hidden-xs header-box" id="lang-control">
								<?php
								if(substr(site_url(), -2, 2)=='en')
									echo anchor(substr(site_url(), 0, -2).'se'.uri_string(),
										"<img src=\"".base_url()."web/img/flags/se_big.png\" class=\"img-circle\" />".$misc_swedish_native);
								else
									echo anchor(substr(site_url(), 0, -2).'en'.uri_string(),
										"<img src=\"".base_url()."web/img/flags/gb_big.png\" class=\"img-circle\" />".$misc_english_native);

								?>
							</div>
							<div class="pull-right hidden-xs header-box" id="header-user">
								<?php
								// vary info depending on user info
								if($this->login->is_logged_in())
								{
									// get gravatar
									$gravatar = $this->login->get_gravatar();
									$gravatar = 'http://www.gravatar.com/avatar/'.$gravatar.'?s=30';

									// nice profile link with images and shit
									$profile_link = '<img src="'.$gravatar.'" class="img-circle" />'.$this->login->get_name();
									echo anchor('user', $profile_link).
										anchor('user/logout', $menu_logout);
								}
								else
								{
									echo anchor('user/login/redir/'.base64_encode(uri_string()),$menu_login);
								}
								?>
							</div>
						</div>
					</div>
				</div><!-- end .container -->
			</header>
			<!-- END header -->

			<!-- START main -->
			<div class="wrapper">
				<?php
				// if we have carousel, display it here
				echo isset($carousel_content) ? $carousel_content : '';
				?>
				<div class="container">
					<?php echo $menu; ?>
				</div>
				<div class="container">
					<div class="row">
						<div class="col-sm-9" id="main-content">
							<?php echo $main_content; ?>
						</div>
						<div class="col-sm-3" id="sidebar-content">
							<?php echo $sidebar_content; ?>
						</div>
					</div>
				</div>

				<div id="main-content" class="clearfix">
					<div id="main-left">

					</div>
					<div id="main-right">

					</div>
				</div>
			</div>
			<!-- END main -->
		</div>

		<!-- START footer -->
		<footer id="main-footer">
			<div class="wrapper">
				<div class="left">
					<div class="block">
						<h1><?php echo $lang['footer_contact']; ?></h1>
						<a href="mailto:info@medieteknik.nu">info@medieteknik.nu</a>
					</div>
					<div class="block">
					 	<h1><?php echo $lang['footer_info']; ?></h1>
					 	<?php echo anchor("/about/website", $lang['footer_aboutsite']); ?><br>
					 	<?php echo anchor("/about/cookies", $lang['footer_cookies']); ?>
					</div>
				</div>
				<div class="right">
					<a href="http://linkedin.com/groups?gid=5159466" class="linkedin"></a>
					<a href="http://facebook.com/mtsektionen" class="facebook"></a>
					<a href="http://twitter.com/mtsektionen" class="twitter"></a>
				</div>
			</div>
		</footer>
		<!-- END footer -->
		<!-- JavaScript at the bottom for fast page loading -->

		<!-- Grab Google CDNs jQuery, with a protocol relative URL; fall back to local if offline -->
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>
		<script>window.jQuery || document.write('<script src="<?php echo base_url(); ?>web/js/libs/jquery.min.js"><\/script>')</script>

		<!-- Load Bootstrap from it's CDN -->
		<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>

		<!-- scripts concatenated and minified via ant build script-->
		<script type="text/javascript" src="<?php echo base_url(); ?>web/js/script.js"></script>
		<!-- end scripts-->
	</body>
</html>


