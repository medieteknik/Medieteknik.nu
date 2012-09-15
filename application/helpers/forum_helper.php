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
