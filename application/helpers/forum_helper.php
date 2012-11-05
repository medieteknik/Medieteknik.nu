<?php
/**
* The following functions are used in the forum
*/

function render_forum($cats) 
{
	echo '<ul class="forum">';
	foreach($cats as $cat) 
	{
		echo '<li>',anchor('forum/category/'.$cat->id, $cat->title);
		if(isset($cat->sub_categories) && count($cat->sub_categories) > 0) 
		{
			render_forum($cat->sub_categories);
		}
	}
	echo '</ul>';
}

function render_breadcrumbs($cats){
	$spacer = '<span class="spacer">>> </span>';
	echo '<ul class="breadcrumbs clearfix">';
	echo '<li>',anchor('forum/', 'Forum');
	foreach(array_reverse($cats) as $key => $cat)
	{
		//if($key) 
		echo '<li>',$spacer,anchor('forum/category/'.$cat->id, $cat->title);
	}
	echo '</ul>';
}