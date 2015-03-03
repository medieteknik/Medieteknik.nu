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

				// nice profile link with images and shit
				$profile_link = gravatarimg($gravatar, 30, ' class="img-circle"').$this->login->get_name();

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
				<!-- <li><?php echo anchor("about", $menu_about); ?></li> -->
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $menu_about; ?> <b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><?php echo anchor("about", $menu_about); ?></li>
						<li><?php echo anchor("about/applicant", $menu_applicants); ?></li>
						<li><?php echo anchor("about/business", $menu_businesses); ?></li>
					</ul>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $menu_association; ?> <b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><?php echo anchor("association", $menu_association); ?></li>
						<li><?php echo anchor("association/board", $menu_board); ?></li>
						<li><?php echo anchor("association/committee", $menu_committees); ?></li>
						<li><?php echo anchor("association/web", $menu_webgroup); ?></li>
						<li><?php echo anchor("association/mette", "Mette"); ?></li>
						<li><?php echo anchor("association/homemission", $menu_homemission); ?></li>

						<li><?php echo anchor("https://alumni.liu.se/Portal/Public/Default.aspx", $menu_alumnus); ?></li>
						<li><?php echo anchor("association/documents", $menu_documents); ?></li>
					</ul>
				</li>
				<li><?php echo anchor("about/mtd", $menu_mtd); ?></li>
				<li><?php echo anchor("forum", $menu_forum); ?></li>

				<?php
				$class = ' class="visible-xs"';
				// Language select
				if(substr(site_url(), -2, 2)=='en')
					echo '<li'.$class.'>'.anchor(substr(site_url(), 0, -2).'se'.uri_string(),
						"<img src=\"".base_url()."web/img/flags/se_big.png\" class=\"flag img-circle\"/>".$misc_swedish_native).'</li>';
				else
					echo '<li'.$class.'>'.anchor(substr(site_url(), 0, -2).'en'.uri_string(),
						"<img src=\"".base_url()."web/img/flags/gb_big.png\" class=\"flag img-circle\"/>".$misc_english_native).'</li>';

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
