<?php

$button = "";
if($is_logged_in) {
	$button = "knappdata";
}

echo '
<div class="main-box clearfix profile">
	<h2>',get_full_name($user),'</h2>
	<div class="profile-content">
		<a href="',$user->web,'" target="_blank" class="profile-link">
			<span class="link-descr">Web</span> <br />
			<span class="link-link">
				',$user->web,'
			</span>
		</a>
		<a href="',$user->linkedin,'" target="_blank" class="profile-link">
			<span class="link-descr">Linkedin</span>
			<span class="link-link"> <br />
				',$user->linkedin,'
			</span>
		</a>
		<a href="http://twitter.com/',$user->twitter,'" target="_blank" class="profile-link">
			<span class="link-descr">Twitter</span>
			<span class="link-link"> <br />
				@',$user->twitter,'
			</span>
		</a>
		<p>',$user->presentation,'</p>
	</div>
</div><!-- close .main-box -->';

