<?php

echo '
<div class="main-box clearfix profile">
	<h2>',get_full_name($user),'</h2>
		<div class="profile-content">
		<div class="profile-link">
			<span class="link-descr">Web</span>
			<span class="link-link">
				<a href="',$user->web,'" target="_blank">',$user->web,'</a>
			</span>
		</div><!-- close .profile-link -->
		<div class="profile-link">
			<span class="link-descr">Linkedin</span>
			<span class="link-link">
				<a href="',$user->linkedin,'" target="_blank">',$user->linkedin,'</a>
			</span>
		</div><!-- close .profile-link -->
		<p>',$user->presentation,'</p>
	</div>
</div><!-- close .main-box -->';

