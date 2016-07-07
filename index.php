<?php

require('RntSession.php');

$s = new RntSession();

if($s->isLogin()) {
	echo 'User: ' . $s->getUserName() . '<br>';
	echo 'Info: ' . $s->getMessage() . '<br>';

	echo '
		<form action="index.php" method="post">
	  	<button type="submit" name="logout">wyloguj</button>
	</form>
		';

} else {
	echo 'User: ' . $s->getUserName() . '<br>';
	echo 'Info: ' . $s->getMessage() . '<br>';

echo '
	<form action="index.php" method="post">
  	user: <input type="text" name="login"><br>
  	pass: <input type="text" name="pass"><br>
  	<button type="submit">zaloguj</button>
</form>
	';

}


?>
