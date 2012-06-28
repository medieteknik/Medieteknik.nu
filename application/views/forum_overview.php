

<?php 
foreach($categories_array as $cat) {
	echo "<h2>".$cat->title . "</h2>";
	foreach($cat->sub_categories as $subcat) {
		echo '<div class="main-box clearfix">';
		echo '<div class="oneThird"><h2>'.$subcat->title.'</h2><p>'.$subcat->description.'</p></div>';
		echo '	<div class="twoThirds">';
					if(count($subcat->threads) > 0) {
						echo '<ul class="box-list">';
						foreach($subcat->threads as $thread) {
							echo '<li>'.anchor('forum/thread/'.$thread->id,$thread->topic).'</li>';
						}
						echo '</ul>';
					} else {
						echo '<p>'.$lang['forum_nothreads'].'</p>';
						
					}
		echo '</div></div>';
	}
}

/*
 
 <h1><?php echo $lang['forum_forum']; ?></h1>
 
foreach($categories_array as $cat) {
	echo "<h2>".$cat->title . "</h2>";
	echo '<div class="main-box clearfix">';
	foreach($cat->sub_categories as $subcat) {
		echo '<div class="clearfix"><div class="oneThird"><h2>'.$subcat->title.'</h2><p>'.$subcat->description.'</p></div>';
		echo '	<div class="twoThirds">';
					//<p>
					//	Lorizzle uhuh ... yih! sizzle amet, consectetizzle adipiscing uhuh ... yih!. I saw beyonces tizzles and my pizzle went crizzle crackalackin velizzle, you son of a bizzle volutpizzle, suscipit owned, gravida vizzle, its fo rizzle. Pellentesque bow wow wow tortizzle. Doggy check it out. Crackalackin izzle dolizzle shut the shizzle up fizzle dizzle sure. Ass pellentesque shizzlin dizzle izzle turpizzle. Dizzle bow wow wow tortor. Pellentesque gizzle rhoncizzle things. In dope habitasse platea dictumst. Donec dapibizzle. Im in the shizzle izzle fo, pretizzle eu, izzle crunk, eleifend vitae, nunc. We gonna chung suscipizzle. Integer shut the shizzle up crunk sizzle purus.
					//</p>
					//echo '<p>';var_dump($subcat->threads);echo '</p>';
					if(count($subcat->threads) > 0) {
						echo '<ul class="box-list">';
						foreach($subcat->threads as $thread) {
							echo '<li>'.anchor('forum/thread/'.$thread->id,$thread->topic).'</li>';
						}
						echo '</ul>';
					} else {
						echo '<p>inga trådar</p>';
						
					}
		echo '</div></div>';
		//echo $subcat->title . " - " .$subcat->description. "<br/>";
	}
	echo "</div>";
}
* 
<div class="main-box featured clearfix">
    <div class="oneThird">
        <h2>Civilingenjör i Medieteknik – en utbildning för dig?</h2>
        <p>
            Aenean tincidunt dui lacus. Ut tincidunt auctor tellus id fermentum. Donec eget turpis augue. Mauris at ipsum est. Donec pharetra adipiscing rhoncus. Ut non condimentum leo. 
        </p>
    </div>
    <img class="twoThirds" src="images/carouselle.png"/>
</div>
echo '<p>
						Lorizzle uhuh ... yih! sizzle amet, consectetizzle adipiscing uhuh ... yih!. I saw beyonces tizzles and my pizzle went crizzle crackalackin velizzle, you son of a bizzle volutpizzle, suscipit owned, gravida vizzle, its fo rizzle. Pellentesque bow wow wow tortizzle. Doggy check it out. Crackalackin izzle dolizzle shut the shizzle up fizzle dizzle sure. Ass pellentesque shizzlin dizzle izzle turpizzle. Dizzle bow wow wow tortor. Pellentesque gizzle rhoncizzle things. In dope habitasse platea dictumst. Donec dapibizzle. Im in the shizzle izzle fo, pretizzle eu, izzle crunk, eleifend vitae, nunc. We gonna chung suscipizzle. Integer shut the shizzle up crunk sizzle purus.
					</p>';
*/

?>
