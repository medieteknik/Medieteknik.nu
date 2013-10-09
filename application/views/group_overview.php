<?php


foreach($groups as $group)
{
	do_dump($group);
	echo 	'<div class="main-box clearfix">
				<h2>',$group->name,'</h2>',
				text_format($group->description);
	echo '<ul class="user-list">';
	foreach($group->members as $member) {
		echo 	gravatarimg($member, 50),
				'<li>',
					anchor('user/profile/'.$member->user_id, get_full_name($member)),' - ', $member->position,
				'</li>';
	}
	echo '</ul><!-- .user-list -->';
	echo '</div>';
}
