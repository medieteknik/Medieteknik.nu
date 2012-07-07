Användare<br/><br/>

<?php
foreach ($users as $user) {
	echo $user->first_name . "<br/>";
	
}

echo "<br/><br/><br/><pre>";
var_dump($users);
echo "</pre>";

