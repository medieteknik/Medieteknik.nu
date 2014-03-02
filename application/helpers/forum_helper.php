<?php
/**
* The following functions are used in the forum
*/

function render_forum($cats)
{
	echo '<ul class="forum list-unstyled">';
	foreach($cats as $cat)
	{
		echo '<li>',anchor('forum/category/'.$cat->slug, $cat->title);
		if(isset($cat->sub_categories) && count($cat->sub_categories) > 0)
		{
			render_forum($cat->sub_categories);
		}
	}
	echo '</ul>';
}

function render_breadcrumbs($cats)
{
	$counter = count($cats);

	echo '<ol class="breadcrumb hidden-xs">';
	echo '<li>',anchor('forum/', 'Forum');

	foreach(array_reverse($cats) as $key => $cat)
	{
		$counter--;
		echo '<li'.($counter == 0 ? ' class="active"': '').'>',anchor('forum/category/'.$cat->slug, $cat->title);
	}
	echo '</ol>';
}
