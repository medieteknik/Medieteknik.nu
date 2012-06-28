<div class="main-box">
    <h2><?php echo $title; ?></h2>
    <ul class="box-list">
		<?php
		foreach($items as $item) {
			//echo '<li><a href="'.$item['href'].'">'.$item['title'].'</a></li>';
			echo '<li>'.anchor($item['href'],$item['title']).'</li>';
		}
		?>
    </ul>
</div>
