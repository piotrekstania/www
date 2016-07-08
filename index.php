<?php

require('RntSession.php');

$s = new RntSession();

if($s->isLogin()) {

	$form = '
		<form action="index.php" method="post">
	  	<button type="submit" name="logout" value="true">wyloguj</button>
	</form>
		';

} else {

$form = '
	<form action="index.php" method="post">
  	user: <input type="text" name="login"><br>
  	pass: <input type="text" name="pass"><br>
  	<button type="submit">zaloguj</button>
</form>
	';

}

if($s->isAdmin()) echo "Admin";
else echo "noAdmin";

echo "<br>" . $s->getMessage() . '<br>';
echo $form;




?>
