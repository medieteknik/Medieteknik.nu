
<div class="main-box clearfix">
	<h2>variabeltest</h2>
	<p>

data = {data}
<br><br>
<?php echo site_url(); ?><br />
<?php  echo uri_string(); ?><br />
<?php echo current_url(); ?><br />
<?php  echo base_url(); ?><br />

URI String (1 to 5):<br />
1: <?php echo $this->uri->segment(1); ?><br />
2: <?php echo $this->uri->segment(2); ?><br />
3: <?php echo $this->uri->segment(3); ?><br />
4: <?php echo $this->uri->segment(4); ?><br />
5: <?php echo $this->uri->segment(5); ?>

<br><br>
<?php echo CI_VERSION; ?>
<hr></p>
</div>
