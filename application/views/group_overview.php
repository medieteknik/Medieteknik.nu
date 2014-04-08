<?php

$most_recent_group = end($group_years);

foreach($groups as $group)
{
	//do_dump($group);
	echo 	'<div class="main-box box-body clearfix">
				<h2>',$group->name,'</h2>',
				text_format($group->description);
	echo '<div class = "row">';
	foreach($group->members as $member) {
		// Show only member of this year (most recent year)
		if($member->start_year == $most_recent_group->start_year)
		{
			echo '<div class = "col-sm-3 clearfix">',
					'<p>', '<center>',
					gravatarimg($member, 300, ' class="img-responsive img-circle"'),
					'</center>','</p>',
					'<p class="text-center">',
					'<strong>',	$member->position,'</strong> - ',
					anchor('user/profile/'.$member->user_id, get_full_name($member)),
					'</p>',
					'<p class="text-center">',
					($member->email ? mailto($member->email) : ""),
					'</p>';
			echo '</div>';
		}
	}
	echo '</div>';
	echo '</div>';
}
