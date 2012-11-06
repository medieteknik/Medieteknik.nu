<?php

$editbutton = "";
$editstyle = "";
if($is_logged_in) {
	$editbutton = '<a href="#edit" onclick="return false;">'.$lang['edit_profile'].'</a>';
	$editstyle = '';
}

$web = profilelinks('web', $user);
$twitter = profilelinks('twitter', $user);
$linkedin = profilelinks('linkedin', $user);

echo '
<div class="main-box clearfix profile">
	<h2>',get_full_name($user),' ',$editbutton,'</h2>
	<div class="profile-content">
		<div class="profile-links">
			',$web,'
			',$linkedin,'
			',$twitter,'
		</div>
		<p>',$user->presentation,'</p>
	</div>
</div><!-- close .main-box -->';
?>
