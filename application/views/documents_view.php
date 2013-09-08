<?php 
echo '<div class="main-box clearfix">';
echo '<ul class = "clearfix">';
foreach ($documents as $doc) {
	echo '<li class = "document clearfix"><i class = "-icon-document"></i>'. $doc->document_original_filename . '</li>';
}
echo '</ul>';
echo '</div>';