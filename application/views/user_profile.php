<?php

// empty variable
$editbutton = "";

// check if user is viewing it's own profile
if($is_logged_in) {
	$editbutton = anchor('/user/edit_profile/', $lang['profile_edit']);
}

$readweb = str_replace(array('http://', 'https://'), '', $user->web);

echo '
<div class="main-box clearfix profile">',
	'<div class="row">',
		'<div class="col-sm-3">',
			'<p>',gravatarimg($user, 300, ' class="img-responsive img-circle"'),'</p>',
		'</div>',
		'<div class="col-sm-6">',
			'<h3>',get_full_name($user),' ',$editbutton,'</h3>',
			'<ul class="profilelinks list-inline">',
				($user->linkedin ? '<li><a href="'.$user->linkedin.'" target="_blank">LinkedIn</a></li>': ''),
				($user->twitter ? '<li><a href="https://twitter.com/'.$user->twitter.'" target="_blank">Twitter @'.$user->twitter.'</a></li>': ''),
				($user->web ? '<li><a href="'.$user->web.'" target="_blank">'.$readweb.'</a></li>': ''),
			'</ul>',
			'<p>',text_format($user->presentation),'</p>',
		'</div>',
	'</div>','
</div><!-- close .main-box -->';
?>
