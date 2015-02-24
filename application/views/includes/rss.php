<div class="main-box box-body clearfix">
    <h2><?php echo $title; ?></h2>
    <ul class="box-list list-unstyled">
    <?php
    foreach($feed as $item) {

      $data = '';

      if(isset($item['data']) && $item['data'] != '') {
        $data = '<span>'.($item['data']).'</span>';
      }

      $text = ($item['title']).$data;

      if(isset($item['link']) && $item['link'] != '') {
        echo '<li>',anchor($item['link'], $text),'</li>';
      } else {
        echo '<li>',$text,'</li>';
      }
    }
    ?>
    </ul>
    <p>Flöde från <?php echo anchor("http://exjobba.se", "Xamera"); ?></P>
</div>
