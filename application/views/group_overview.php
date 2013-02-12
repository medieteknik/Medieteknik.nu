<?php 


foreach($groups as $group)
{
	//do_dump($group);
	echo 	'<div class="main-box clearfix">
				<h2>',$group->name,'</h2>',
				text_format($group->description);
	foreach($group->members as $member) {
		echo 	gravatarimg($member, 81, ' style="margin:10px 10px 0; float: left;"'),
				'<p>',
					get_full_name($member),' - ', $member->position,
				'</p>';
	}
	echo '</div>';
}
