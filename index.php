<?php

function build_table($array){
    // start table
    $html = '<table style="text-align: end;">';
    // header row
    $html .= '<tr>';
    foreach($array[0] as $key=>$value){
            $html .= '<th style="padding-right: 50px;">' . $key . '</th>';
        }
    $html .= '</tr>';

    // data rows
    foreach( $array as $key=>$value){
        $html .= '<tr>';
        foreach($value as $key2=>$value2){
            $html .= '<td style="padding-right: 50px;">' . $value2 . '</td>';
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
	$form = 'Zalogowany jako: ' . $s->getUserName() . '<br>';
	$form .= '<form action="index.php" method="post">
						<input type="hidden" name="type" value="logout">
	  				<button type="submit">wyloguj</button>
					</form>';

	$form .= '<br>';

	$form .= '<form action="index.php" method="post">
						<input type="hidden" name="type" value="change_pass">
						old: <input type="text" name="old_pass"><br>
						new: <input type="password" name="new_pass"><br>
						new: <input type="password" name="conf_pass"><br>
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

						if($x = $s->getUsers()) $form .= build_table($x);

						$form .= '<br>
							<form action="index.php" method="post">
								<input type="hidden" name="type" value="remove_user">
								id: <input type="text" name="id"><br>
						  	<button type="submit">usuń</button>
						</form><br>';

					}


		} else {
				$form = 'Niezalogowany<br>';
		$form .= '
			<form action="index.php" method="post">
				<input type="hidden" name="type" value="login">
				user: <input type="text" name="user"><br>
				pass: <input type="password" name="pass"><br>
				<button type="submit">zaloguj</button>
		</form>';
		}


		echo $s->getMessage() . '<br><br>';
		echo "<a href='index.php'>Index</a><br>";
		echo $form;


?>

<!doctype html>
<html>

<head>

	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="https://code.getmdl.io/1.1.3/material.indigo-pink.min.css">
	<script defer src="https://code.getmdl.io/1.1.3/material.min.js"></script>


</head>

<body>

	<div class="mdl-grid main-grid" id="main-grid">



		<div class="mdl-card mdl-shadow--6dp mdl-cell mdl-cell--4-col card">

			<div class="mdl-card__title" style="background-color:blue;">
				<h2 class="mdl-card__title-text">Zmiana hasła</h2>
			</div>

			<div class="mdl-card__supporting-text card-supporting-text">

				<form action="index.php" method="post">

					<input type="hidden" name="type" value="change_pass">

					<table class="mdl-data-table mdl-js-data-tabl">
  					<tbody>
    					<tr>
      					<td class="mdl-data-table__cell--non-numeric">Hasło</td>
      					<td style="width:100%;"><input type="password" name="old_pass"></td>
    					</tr>

							<tr>
      					<td class="mdl-data-table__cell--non-numeric">Nowe hasło</td>
      					<td><input type="password" name="new_pass"></td>
    					</tr>

							<tr>
      					<td class="mdl-data-table__cell--non-numeric">Potwierdź hasło</td>
      					<td><input type="password" name="new_pass1"></td>
    					</tr>

  					</tbody>
					</table>


					<button class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent" type="submit" style="float:right; margin-top:20px;">Zmień hasło</button>

				</form>

			</div>

		</div>



	</div>



</body>

</html>
