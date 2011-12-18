<?php 

// only one group in reality, just using for loop to get away from the array :P
foreach($group_info as $group) {
	echo '<h1>'.$group->group_name.'</h1>';
	echo '<p>'.$group->description.'</p>';
}
?>