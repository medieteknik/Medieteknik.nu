<header>
	<h2><?php echo $lang['email_forum_verify_title']; ?></h2>
</header>
<main>
	<p style="margin: 5px 15px; color: #666;">
		<?php echo $lang['email_hello'].', '.$data['name']; ?>!
	</p>
	<p>
		<?php echo $lang['email_forum_verify_explanation']; ?>
	</p>
	<p style="margin: 5px 15px; color: #666;">
		<?php
		$link = 'forum/verify/'.urlencode($data['email']).'/'.$data['hash'];
		echo anchor($link, $lang['email_forum_verify_confirm'], array('class' => 'button'));
		?>
	</p>
	<p style="margin: 5px 15px; color: #666;">
		<small>
			<?php echo $lang['email_forum_verify_ifitdoesntwork'].'{unwrap}'.base_url($link).'{/unwrap}'; ?>
		</small>
	</p>
	<p style="margin: 5px 15px; color: #666;">
		<?php echo $lang['email_byebye']; ?>,<br>
		<?php echo $lang['email_assoc']; ?>
	</p>
</main>
