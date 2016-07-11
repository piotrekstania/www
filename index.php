<?php

function build_table($array){
    // start table
    $html = '<table>';
    // header row
    $html .= '<tr>';
    foreach($array[0] as $key=>$value){
            $html .= '<th>' . $key . '</th>';
        }
    $html .= '</tr>';

    // data rows
    foreach( $array as $key=>$value){
        $html .= '<tr>';
        foreach($value as $key2=>$value2){
            $html .= '<td>' . $value2 . '</td>';
        }
        $html .= '</tr>';
    }

    // finish table and return it

    $html .= '</table>';
    return $html;
}

require('RtUsers.php');

$s = new RtUsers();

if($s->isLogin()) {
	$form = '<form action="index.php" method="post">
						<input type="hidden" name="type" value="logout">
	  				<button type="submit">wyloguj</button>
					</form>';

	$form .= '<br>';

	$form .= '<form action="index.php" method="post">
						<input type="hidden" name="type" value="change_pass">
						old: <input type="text" name="old_pass"><br>
						new1: <input type="password" name="new_pass_1"><br>
						new2: <input type="password" name="new_pass_2"><br>
	  				<button type="submit">zmień</button>
					</form>';

					if($s->isAdmin()){
						$form .= '<br>
							<form action="index.php" method="post">
								<input type="hidden" name="type" value="add_user">
								user: <input type="text" name="user"><br>
						  	pass: <input type="text" name="pass"><br>
						  	<button type="submit">dodaj</button>
						</form><br>';

						$form .= build_table($s->getUsers());

						$form .= '<br>
							<form action="index.php" method="post">
								<input type="hidden" name="type" value="remove_user">
								id: <input type="text" name="id"><br>
						  	<button type="submit">usuń</button>
						</form><br>';

					}


		} else {
		$form = '
			<form action="index.php" method="post">
				<input type="hidden" name="type" value="login">
				user: <input type="text" name="user"><br>
				pass: <input type="password" name="pass"><br>
				<button type="submit">zaloguj</button>
		</form>';
		}


		echo "<br>" . $s->getMessage() . '<br>';
		echo "zalogowany jako " . $s->getUserName() . "<br>";
		echo $form;

?>
