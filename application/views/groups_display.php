<h1><?php echo $common_lang['groups_title']; ?></h1>

<?php 
foreach($groups_array as $group) {
	echo '<ul>';
		echo '<li>'.anchor('group/info/'.compact_name($group->group_name),$group->group_name).'</li>';
	echo '</ul>';
}
?>