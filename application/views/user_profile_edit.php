<?php
echo form_open('user/profile/'.$user->id.'/runedit'),
'<div class="main-box clearfix profile">
	<h2>Redigera konto</h2>
	<div class="profile-content">
		<div class="profile-links">
			',profilelinks('web', $user),'
			',profilelinks('linkedin', $user),'
			',profilelinks('twitter', $user),'
		</div>
		<p>',$user->presentation,'</p>
	</div>
</div><!-- close .main-box -->',
form_close();
