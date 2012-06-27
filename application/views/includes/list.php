<div class="main-box">
    <h2><?php echo $title; ?></h2>
    <ul class="box-list">
		<?php
		foreach($items as $item) {
			echo '<li>'.$item['title'].'<span>'.$item['data'].'</span></li>';
		}
		?>
    </ul>
</div>