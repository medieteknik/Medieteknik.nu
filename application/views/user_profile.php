<?php

// empty variable
$editbutton = "";

// check if user is viewing it's own profile
if($is_logged_in) {
	$editbutton = anchor('/user/edit_profile/', $lang['profile_edit']);
}

echo '
<div class="main-box clearfix profile">',
gravatarimg($user, 81, ' style="margin:10px 10px 0; float: left;"'),
	'<h2>',get_full_name($user),' ',$editbutton,'</h2>
	<div class="profile-content">
		<div class="profile-links">
			',profilelinks('web', $user),'
			',profilelinks('linkedin', $user),'
			',profilelinks('twitter', $user),'
		</div>
		<div class="clearfix"></div>
		<p>',text_format($user->presentation),'</p>
	</div>
</div><!-- close .main-box -->';
?>
