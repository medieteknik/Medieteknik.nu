<h1><?php echo $common_lang['groups_title']; ?></h1>

<?php 
foreach($tweet_array as $tweet) 
{
	echo '<div style="background-color: #'.$tweet->user->profile_sidebar_fill_color.';"><img src="'.$tweet->user->profile_image_url.'" />'.$tweet->user->screen_name . ": " . $tweet->text . "</div>";
}

//echo "<pre>";
//var_dump($tweet_array);
//echo "</pre>";



foreach($images_array as $img) 
{
	$fullsize = $img->get_filepath(true);
	$img->set_crop("zoom");
	echo '<a href="'.base_url().$fullsize.'">'.$img->get_img_tag().'</a>';	
}

foreach($groups_array as $group) 
{
	echo '<ul>';
		echo '<li>'.anchor('group/info/'.compact_name($group->group_name),$group->group_name).'</li>';
	echo '</ul>';
}
