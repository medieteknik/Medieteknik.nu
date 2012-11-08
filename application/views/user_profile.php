<?php

$editbutton = "";
$editstyle = "";


if($is_logged_in) {
	if(isset($_GET['edit'])){
	}
	$editbutton = '<a href="?edit" onclick="return false;">'.$lang['profile_edit'].'</a>';
	$editstyle = '';
}

echo '
<div class="main-box clearfix profile">
	<h2>',get_full_name($user),' ',$editbutton,'</h2>
	<div class="profile-content">
		<div class="profile-links">
			',profilelinks('web', $user),'
			',profilelinks('linkedin', $user),'
			',profilelinks('twitter', $user),'
		</div>
		<p>',$user->presentation,'</p>
	</div>
</div><!-- close .main-box -->';
?>
