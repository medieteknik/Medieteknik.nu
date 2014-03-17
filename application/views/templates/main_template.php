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
										$misc_swedish_native);
								else
									echo anchor(substr(site_url(), 0, -2).'en'.uri_string(),
										$misc_english_native);

								?>
							</div>
							<div class="pull-right hidden-xs header-box" id="header-user">
								<?php
								// vary info depending on user info
								if($this->login->is_logged_in())
								{
									// get gravatar
									$gravatar = $this->login->get_gravatar();

									// nice profile link with images and shit
									$profile_link = gravatarimg($gravatar, 30, ' class="img-circle"').$this->login->get_name();
									echo anchor('user', $profile_link).
										anchor('user/logout', $menu_logout);
								}
								else
								{
									echo anchor('user/login/redir/'.urlencode(base64_encode(uri_string())),$menu_login);
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
						<div class="col-sm-8 col-md-9" id="main-content">
							<?php echo $main_content; ?>
						</div>
						<div class="col-sm-4 col-md-3" id="sidebar-content">
							<?php echo $sidebar_content; ?>
						</div>
					</div>
				</div>
			</div>
			<!-- END main -->
		</div>

		<!-- START footer -->
		<footer id="main-footer">
			<div class="wrapper">
				<div class="container">
					<div class="row">
						<div class="col-sm-3">
							<h1><?php echo $lang['footer_contact']; ?></h1>
							<p>
								<a href="mailto:info@medieteknik.nu" target="_blank">info@medieteknik.nu</a>
							</p>
							<p>
								MT-sektionen<br />
								Kårhuset Trappan<br />
								601 74 Norrköping<br />
								Sweden
							</p>
						</div>
						<div class="col-sm-3">
							<h1><?php echo $lang['footer_info']; ?></h1>
							<ul class="list-unstyled">
								<li><?php echo anchor("/about/website", $lang['footer_aboutsite']); ?></li>
								<li><?php echo anchor("/about/cookies", $lang['footer_cookies']); ?></li>
							</ul>
						</div>
						<div class="col-sm-3">
							<h1><?php echo $lang['footer_links']; ?></h1>
							<ul class="list-unstyled">
								<li><?php echo anchor('http://liu.se/medieteknik', $lang['footer_mtliu'], 'target="_blank"'); ?></li>
								<li><?php echo anchor('http://medieteknikdagarna.se/', $lang['menu_mtd'], 'target="_blank"'); ?></li>
								<li><?php echo anchor('http://github.com/medieteknik', $lang['footer_github'], 'target="_blank"'); ?></li>
							</ul>
						</div>
						<div class="col-sm-3" id="follow">
							<h1><?php echo $lang['footer_follow']; ?></h1>
							<a href="http://linkedin.com/groups?gid=5159466" class="linkedin" target="_blank"></a>
							<a href="http://facebook.com/mtsektionen" class="facebook" target="_blank"></a>
							<a href="http://twitter.com/mtsektionen" class="twitter" target="_blank"></a>
						</div>
					</div>
				</div>
			</div>
		</footer>
		<!-- END footer -->
		<!-- JavaScript at the bottom for fast page loading -->

		<!-- Grab jQuery CDNs jQuery, with a protocol relative URL; fall back to local if offline -->
		<script src="//code.jquery.com/jquery-2.1.0.min.js"></script>
		<script>window.jQuery || document.write('<script src="<?php echo base_url(); ?>web/js/libs/jquery.min.js"><\/script>')</script>

		<!-- Load Bootstrap from it's CDN -->
		<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
		<!-- Load our javascripts -->
		<script type="text/javascript" src="<?php echo base_url(); ?>web/js/script.js"></script>
		<?php
		if(isset($extra_javascripts) && is_array($extra_javascripts) && count($extra_javascripts) > 0)
		{
			foreach ($extra_javascripts as $script)
				echo '<script type="text/javascript" src="'.base_url().'web/js/'.$script.'"></script>';
		}
		?>
		<!-- end scripts-->
	</body>
</html>
