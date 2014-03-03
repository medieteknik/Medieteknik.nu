<div id="big-carousel" class="carousel slide" data-ride="carousel">
	<!-- Indicators -->
	<ol class="carousel-indicators">
		<li data-target="#big-carousel" data-slide-to="0" class="active"></li>
		<li data-target="#big-carousel" data-slide-to="1"></li>
	</ol>

	<!-- Wrapper for slides -->
	<div class="carousel-inner">
		<div class="item active darkbg">
			<div class="container">
				<div class="row">
					<div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
						<h1 class="text-center">
							Civilingenjör i Medieteknik – en utbildning för dig?
						</h1>
					</div>
				</div>
				<div class="row">
					<div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
						<iframe src="//player.vimeo.com/video/73557097?title=0&amp;byline=0&amp;portrait=0&amp;color=a6a6a6"
							width="100%" height="360" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
					</div>
				</div>
			</div>
		</div>
		<?php
		$photos = array(
					array(
						'file' => 'campus-1-peter-modin-liu.jpg',
						'photo' => 'Peter Modin, LiU',
						'link' => 'http://liu.se'
						 ),
					array(
						'file' => 'campus-2-peter-modin-liu.jpg',
						'photo' => 'Peter Modin, LiU',
						'link' => 'http://liu.se'
						 ),
					array(
						'file' => 'campus-3-peter-modin-liu.jpg',
						'photo' => 'Peter Modin, LiU',
						'link' => 'http://liu.se'
						 ),
					array(
						'file' => 'campus-bibl.jpg',
						'photo' => 'Norrköpings stadsbibliotek',
						'link' => 'http://www.flickr.com/photos/gamle_swartzen/486774017/'
						 )
				  );
		$img = rand(0, count($photos)-1);
		?>
		<div class="item photo">
			<div class="image" style="background-image: url(<?php echo base_url().'web/img/campus/'.$photos[$img]['file']; ?>);"></div>
			<div class="carousel-caption">
				<h1>Linköpings universitet &ndash; Campus Norrköping</h1>
				<p class="lead">
					Civilingenjör i Medieteknik på Linköpings universitet ges på Campus Norrköping &ndash; Sveriges bästa studentstad 2013.<br />
					<a href="<?php echo $photos[$img]['link']; ?>" target="_blank">Foto: <?php echo $photos[$img]['photo']; ?></a>
				</p>
			</div>
		</div>
	</div>

	<!-- Controls -->
	<a class="left carousel-control hidden-sm hidden-xs" href="#big-carousel" data-slide="prev">
		<span class="glyphicon glyphicon-chevron-left"></span>
	</a>
	<a class="right carousel-control hidden-sm hidden-xs" href="#big-carousel" data-slide="next">
		<span class="glyphicon glyphicon-chevron-right"></span>
	</a>
</div>
