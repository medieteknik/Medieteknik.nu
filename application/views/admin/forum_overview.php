<?php
if($message == 'success')
	echo '<div class="alert alert-success">'.$lang['misc_done'].'</div>';
if($message == 'fail')
	echo '<div class="alert alert-danger">'.$lang['error_error'].'</div>';
?>

<div class="main-box clearfix">
	<h2><?php echo $lang['admin_forum']; ?></h2>
</div>
<?php
if(count($reports) > 0)
{
	?>
	<div class="main-box clearfix margin-top">
		<h3>
			<?php echo $lang['admin_forum_reported']; ?>
		</h3>
		<?php
		foreach ($reports as $report) {
			?>
			<h5>
				<?php
				echo readable_date($report->report_date, $lang).', '.$report->lukasid.' '.
					$lang['admin_forum_reported_by'].' '.$report->p_lukasid.'s '.$lang['misc_post'].' '.
					anchor('forum/thread/'.$report->topic_id.'#replyid-'.$report->reply_id, $lang['admin_forum_show_post']);
				?>
			</h5>
			<div class="row">
				<div class="col-sm-9">
					<p>
						<?php echo news_excerpt(text_format($report->reply, '<p>','</p>', TRUE), 200); ?>...
					</p>
				</div>
				<div class="col-sm-3">
					<p>
						<?php
						echo anchor('admin/forum/remove_report/'.$report->id, '<span class="glyphicon glyphicon-trash"></span> '.$lang['admin_forum_remove'], array('class' => 'btn btn-danger btn-sm btn-block'));
						?>
					</p>
				</div>
			</div>
			<?php
		}
		?>
	</div>
	<?php
}
?>
