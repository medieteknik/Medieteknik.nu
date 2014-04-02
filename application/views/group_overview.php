<?php

$most_recent_group = end($group_years);

foreach($groups as $group)
{
	//do_dump($group);
	echo 	'<div class="main-box box-body clearfix">
				<h2>',$group->name,'</h2>',
				text_format($group->description);
	echo '<ul class = "row">';
	foreach($group->members as $member) {
		// Show only member of this year (most recent year)
		if($member->start_year == $most_recent_group->start_year)
		{
			echo '<li class = "list-unstyled clearfix">',
					'<div class="col-sm-2">',
					gravatarimg($member, 300, ' class="img-responsive img-circle"'),
					'</div>',
					'<div class="col-sm-10">',
					'<strong>',	$member->position,'</strong> - ', get_full_name($member),
					'</div>';
			echo '</li><br />';
		}
	}
	echo '</ul>';
	echo '</div>';
}
