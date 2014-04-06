<html>
	<head>
		<style>
			body {
				width: 100%;
				background-color: #f4f4f4;
				color: #666;
			}
			body p {
				margin: 5px 15px;
			}
			body footer {
				background-color: #E8E8E9;
			}
			body footer p {
				line-height: 30px;
			}
		</style>
	</head>
	<body>
		<?php echo $message; ?>
		<footer>
			<p>
				<?php echo base_url('web/img/email_logo.png'); ?> <a href="<?php echo base_url(); ?>">medieteknik.nu</a>
			</p>
		</footer>
	</body>
</html>
