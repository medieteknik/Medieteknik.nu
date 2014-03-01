	<nav class="navbar navbar-default" role="navigation" id="main-nav">
	<div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<?php
			if($this->login->is_logged_in())
			{
				// get gravatar
				$gravatar = $this->login->get_gravatar();
				$gravatar = 'http://www.gravatar.com/avatar/'.$gravatar.'?s=34';

				// nice profile link with images and shit
				$profile_link = '<img src="'.$gravatar.'" class="img-circle" /> '.$this->login->get_name();
				echo '<a class="navbar-brand visible-xs" href="'.base_url().'user">'.$profile_link.'</a>';
			}
			else {
				echo '<a class="navbar-brand visible-xs logged-out" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">'.$menu_menu.'</a>';
			}
			?>
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
				<li><?php echo anchor("", $menu_home); ?></li>
				<li><?php echo anchor("news/archive", $menu_news); ?></li>
				<li><?php echo anchor("about", $menu_about); ?></li>
				<li><?php echo anchor("association", $menu_association); ?></li>
				<li><?php echo anchor("mtd", $menu_mtd); ?></li>
				<li><?php echo anchor("forum", $menu_forum); ?></li>

				<?php
				$class = ' class="visible-xs"';
				// Language select
				if(substr(site_url(), -2, 2)=='en')
					echo '<li'.$class.'>'.anchor(substr(site_url(), 0, -2).'se'.uri_string(),
						"<img src=\"".base_url()."web/img/flags/se_big.png\" class=\"img-circle\"/>".$misc_swedish_native).'</li>';
				else
					echo '<li'.$class.'>'.anchor(substr(site_url(), 0, -2).'en'.uri_string(),
						"<img src=\"".base_url()."web/img/flags/gb_big.png\" class=\"img-circle\"/>".$misc_english_native).'</li>';

				// login/logout
				if($this->login->is_logged_in())
					echo '<li'.$class.'>'.anchor('user/logout',$menu_logout).'</li>';
				else
				{
					echo '<li'.$class.'>'.anchor('user/login/redir/'.urlencode(base64_encode(uri_string())),$menu_login).'</li>';
				}
				?>
			</ul>
		</div><!-- /.navbar-collapse -->
	</div><!-- /.container-fluid -->
</nav>
