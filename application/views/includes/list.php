<div class="main-box box-body clearfix">
    <h2><?php echo $title; ?></h2>
    <ul class="box-list list-unstyled">
		<?php
		foreach($items as $item) {

			$data = '';

			if(isset($item['data']) && $item['data'] != '') {
				$data = '<span>'.($item['data']).'</span>';
			}

			$text = ($item['title']).$data;

			if(isset($item['href']) && $item['href'] != '') {
				echo '<li>',anchor($item['href'], $text),'</li>';
			} else {
				echo '<li>',$text,'</li>';
			}
		}
		?>
    </ul>
</div>
