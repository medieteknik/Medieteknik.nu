<?php

echo '
<div class="main-box clearfix">
	<h2>',get_full_name($user),'</h2>
	<ul>
		<li>Web: ',$user->web,'</li>
		<li>linkedin: ',$user->linkedin,'</li>
	</ul>
	<p>',$user->presentation,'</p>
</div>';

