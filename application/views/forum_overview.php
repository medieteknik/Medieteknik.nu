<h1><?php echo $common_lang['groups_title']; ?></h1>

<?php 
foreach($categories_array as $cat) {
	echo $cat->title . "<br/>";
}

?>