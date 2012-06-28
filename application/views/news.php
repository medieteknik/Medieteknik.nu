
<div class="filter-bar clearfix">
    <h2>Filtrera:</h2>
    <ul>
        <li><a><?php echo $news_news; ?></a></li>
        <li><a><?php echo $news_socialmedia; ?></a></li>
        <li><a><?php echo $news_studentprojects; ?></a></li>
        <li><a><?php echo $news_activethreads; ?></a></li>
    </ul>                    
</div>		
<div class="main-box news clearfix">
    <div class="twoThirds">
        <h2>MidsommarphesTen</h2>
		<p>
            Aenean tincidunt dui lacus. Ut tincidunt auctor tellus id fermentum. Donec eget turpis augue. Mauris at ipsum est. Donec pharetra adipiscing rhoncus. Ut non condimentum leo. Vestibulum leo velit, aliquam in auctor id, elementum sit amet sapien. Donec id lacus sed odio tincidunt facilisis nec in massa.
        </p>
		<p>
            Aenean tincidunt dui lacus. Ut tincidunt auctor tellus id fermentum. Donec eget turpis augue. Mauris at ipsum est. Donec pharetra adipiscing rhoncus. Ut non condimentum leo. Vestibulum leo velit, aliquam in auctor id, elementum sit amet sapien. Donec id lacus sed odio tincidunt facilisis nec in massa.
        </p>
    </div>
    <img class="oneThird" src="<?php echo base_url(); ?>web/img/feedItem1.png"/>
</div>
<div class="main-box news">
    <h2>Overallsinvigning med Mette</h2>
    <p>
            Aenean tincidunt dui lacus. Ut tincidunt auctor tellus id fermentum. Donec eget turpis augue. Mauris at ipsum est. Donec pharetra adipiscing rhoncus. Ut non condimentum leo. Vestibulum leo velit, aliquam in auctor id, elementum sit amet sapien. Donec id lacus sed odio tincidunt facilisis nec in massa.
    </p>
</div>
<div class="main-box news clearfix">
    <img class="twoThirds" src="<?php echo base_url(); ?>web/img/feedItem2.png"/>
    <div class="oneThird">
        <h2>Välkommen till Campus</h2>
        <p>
            Aenean tincidunt dui lacus. Ut tincidunt auctor tellus id fermentum. Donec eget turpis augue. Mauris at ipsum est. 
        </p>
        <p>
            Aenean tincidunt dui lacus. Ut tincidunt auctor tellus id fermentum. Donec eget turpis augue. Mauris at ipsum est. 
        </p>
        <p>
            Aenean tincidunt dui lacus. Ut tincidunt auctor tellus id fermentum. Donec eget turpis augue. Mauris at ipsum est. 
        </p>
    </div>                    
</div>

<?php 
foreach($news_array as $news_item) {
	echo '<div class="main-box news clearfix">';
		echo '<h2>'.$news_item->title.'</h2>';
		echo '<p>'.$news_item->text.'</p>';
		echo '<pre>';
		var_dump($news_item);
		echo '</pre>';
	echo '</div>';
}

/*
echo '<p>'.$news_author.': '.get_full_name($news_item).'</p>';
echo '<p>'.readable_date($news_item->date, $common_lang).'</p>';
*/

?>
