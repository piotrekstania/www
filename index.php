<?php

require('RntUsers.php');


try {
	$s = new RntUsers();

	if($s->isLogin()) {
		$form = '<form action="index.php" method="post">
							<input type="hidden" name="type" value="logout">
		  				<button type="submit">wyloguj</button>
						</form>';

			$form .= '<br>
				<form action="index.php" method="post">
					<input type="hidden" name="type" value="adduser">
					user: <input type="text" name="user"><br>
			  	pass: <input type="text" name="pass"><br>
					session_time: <input type="number" name="session_time"><br>
			  	<button type="submit">dodaj</button>
			</form>
				<br>';

			} else {

			$form = '
				<form action="index.php" method="post">
					<input type="hidden" name="type" value="login">
					user: <input type="text" name="user"><br>
					pass: <input type="text" name="pass"><br>
					<button type="submit">zaloguj</button>
			</form>
				';



			}


			echo "<br>" . $s->getMessage() . '<br>';
			echo $form;


}catch(Exception $e) {
	echo $e->getMessage();
}
?>
