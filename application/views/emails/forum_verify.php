<header>
	<h2><?php echo $lang['email_forum_verify_title']; ?></h2>
</header>
<main>
	<p>
		<?php echo $lang['email_hello'].', '.$data['name']; ?>!
	</p>
	<p>
		<?php echo $lang['email_forum_verify_explanation']; ?>
	</p>
	<p>
		<?php
		$link = 'forum/verify/'.urlencode($data['email']).'/'.$data['hash'];
		echo anchor($link, $lang['email_forum_verify_confirm'], array('class' => 'button'));
		?>
	</p>
	<p>
		<small>
			<?php echo $lang['email_forum_verify_ifitdoesntwork'].'{unwrap}'.base_url($link).'{/unwrap}'; ?>
		</small>
	</p>
	<p>
		<?php echo $lang['email_byebye']; ?>,<br>
		<?php echo $lang['email_assoc']; ?>
	</p>
</main>
