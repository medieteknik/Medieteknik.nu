<header>
	<h2 style="color: #666; margin: 15px;">
		<?php echo $lang['email_forum_verify_title']; ?>
	</h2>
</header>
<main>
	<p style="margin: 15px; color: #666;">
		<?php echo $lang['email_hello'].', '.$data['name']; ?>!
	</p>
	<p style="margin: 15px; color: #666;">
		<?php echo $lang['email_forum_verify_explanation']; ?>
	</p>
	<p style="margin: 15px; color: #666;">
		<?php
		$link = 'forum/verify/'.urlencode($data['email']).'/'.$data['hash'];
		echo anchor($link, $lang['email_forum_verify_confirm'], array('style' => 'margin:0; padding: 10px 16px; font-size: 18px; border-radius: 6px; text-decoration: none; background-color: #f4f4f4; border: 1px solid #aaaaaa;'));
		?>
	</p>
	<p style="margin: 15px; color: #666;">
		<small>
			<?php echo $lang['email_forum_verify_ifitdoesntwork'].'{unwrap}'.base_url($link).'{/unwrap}'; ?>
		</small>
	</p>
	<p style="margin: 15px; color: #666;">
		<?php echo $lang['email_byebye']; ?>,<br>
		<?php echo $lang['email_assoc']; ?>
	</p>
</main>
