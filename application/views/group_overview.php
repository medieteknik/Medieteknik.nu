<?php 


foreach($groups as $group)
{
	//do_dump($group);
	echo 	'<div class="main-box clearfix">
				<h2>',$group->name,'</h2>',
				text_format($group->description);
	echo '<ul class = "clearfix">';
	foreach($group->members as $member) {
		echo '<li class = "clearfix">';
		echo 	gravatarimg($member, 81, ' style="margin:10px 10px 0; float: left;"'),
				'<p>',
					get_full_name($member),' - ', $member->position,
				'</p>';
		echo '</li>';
	}
	echo '</ul>';
	echo '</div>';
}
