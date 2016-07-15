<?php
/*
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
*/

require('RtUsers.php');

$users = new RtUsers();
?>

<!doctype html>
<!--
  Material Design Lite
  Copyright 2015 Google Inc. All rights reserved.

  Licensed under the Apache License, Version 2.0 (the "License");
  you may not use this file except in compliance with the License.
  You may obtain a copy of the License at

      https://www.apache.org/licenses/LICENSE-2.0

  Unless required by applicable law or agreed to in writing, software
  distributed under the License is distributed on an "AS IS" BASIS,
  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
  See the License for the specific language governing permissions and
  limitations under the License
-->
<html lang="pl">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Panel HPS521">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <title>Otech - HPS521</title>

    <link rel="shortcut icon" href="images/favicon.png">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.1.3/material.cyan-light_blue.min.css">
    <link rel="stylesheet" href="styles.css">
  </head>

	<body>
	<div class="demo-layout mdl-layout mdl-js-layout mdl-layout--fixed-drawer mdl-layout--fixed-header">

		<header class="demo-header mdl-layout__header mdl-color--grey-100 mdl-color-text--grey-600">
			<div class="mdl-layout__header-row">
				<span class="mdl-layout-title">Home</span>
				<div class="mdl-layout-spacer"></div>

				<button class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon" id="hdrbtn">
					<i class="material-icons">more_vert</i>
				</button>

				<ul class="mdl-menu mdl-js-menu mdl-js-ripple-effect mdl-menu--bottom-right" for="hdrbtn">
					<li class="mdl-menu__item">About</li>
					<li class="mdl-menu__item">Contact</li>
					<li class="mdl-menu__item">Legal information</li>
				</ul>

			</div>
		</header>






		<div class="demo-drawer mdl-layout__drawer mdl-color--blue-grey-900 mdl-color-text--blue-grey-50">

			<header class="demo-drawer-header">


					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
	    			<input class="mdl-textfield__input" type="text" id="user">
	    			<label class="mdl-textfield__label" for="user">Login</label>
	  			</div>

					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
	    			<input class="mdl-textfield__input" type="password" id="pass">
	    			<label class="mdl-textfield__label" for="pass">Hasło</label>
	  			</div>


			</header>


			<nav class="demo-navigation mdl-navigation mdl-color--blue-grey-800">
				<a class="mdl-navigation__link" href=""><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">home</i>Home</a>
				<a class="mdl-navigation__link" href=""><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">inbox</i>Inbox</a>
				<a class="mdl-navigation__link" href=""><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">delete</i>Trash</a>
				<a class="mdl-navigation__link" href=""><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">report</i>Spam</a>
				<a class="mdl-navigation__link" href=""><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">forum</i>Forums</a>
				<a class="mdl-navigation__link" href=""><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">flag</i>Updates</a>
				<a class="mdl-navigation__link" href=""><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">local_offer</i>Promos</a>
				<a class="mdl-navigation__link" href=""><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">shopping_cart</i>Purchases</a>
				<a class="mdl-navigation__link" href=""><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">people</i>Social</a>
				<div class="mdl-layout-spacer"></div>
				<a class="mdl-navigation__link" href=""><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">help_outline</i><span class="visuallyhidden">Help</span></a>
			</nav>
		</div>






		<main class="mdl-layout__content mdl-color--grey-100">

			<div class="mdl-grid demo-content">

			</div>
		</main>

	</div>


		<script src="https://code.getmdl.io/1.1.3/material.min.js"></script>
	</body>
</html>
