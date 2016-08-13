<?php
require('php/RntUsers.php');

$user = new RntUsers();
$message = $user->getMessage();

$sitesDir = "sites/";

if(isset($_GET['site'])) {

	if(file_exists($sitesDir . $_GET['site'] . ".php")) {
		$site = $_GET['site'];
		$file = $sitesDir . $_GET['site'] . ".php";
	} else {
		$site = "Błąd 404";
		$message = "Podana strona nie istnieje";
		$file = null;
	}

} else {
	$site = 'panel';
	$file = $sitesDir . $site . ".php";
}

if(($site == "logowanie") && $user->isLogin()) {
	header("Location: /panel");
	die();
}

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
		<?php if(strpos($site, "404")) echo '<meta http-equiv="refresh" content="3;url=/"/>' ?>
    <title>Nazwa maszyny</title>

    <link rel="shortcut icon" href="/images/icon.png">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.1.3/material.blue_grey-pink.min.css">

		<style>

			html, body {
				font-family: 'Roboto', 'Helvetica', sans-serif;
			}
			.rnt-login-textfiled {
				width: 100%;
			}
			.rnt-card-title-text {
				font-weight: 400;
				color: white;
			}
			.rnt-layout .rnt-header .mdl-textfield {
			  padding: 0px;
			  margin-top: 41px;
			}
			.rnt-layout .rnt-header .mdl-textfield .mdl-textfield__expandable-holder {
			  bottom: 19px;
			}
			.rnt-layout .mdl-layout__header .mdl-layout__drawer-button {
			  color: rgba(0, 0, 0, 0.54);
			}
			.mdl-layout__drawer .avatar {
			  margin-bottom: 16px;
			}
			.rnt-drawer {
			  border: none;
			}
			/* iOS Safari specific workaround */
			.rnt-drawer .mdl-menu__container {
			  z-index: -1;
			}
			.rnt-drawer .rnt-navigation {
			  z-index: -2;
			}
			/* END iOS Safari specific workaround */
			.rnt-drawer .mdl-menu .mdl-menu__item {
			  display: -webkit-flex;
			  display: -ms-flexbox;
			  display: flex;
			  -webkit-align-items: center;
			      -ms-flex-align: center;
			          align-items: center;
			}
			.rnt-drawer-header {
			  box-sizing: border-box;
			  display: -webkit-flex;
			  display: -ms-flexbox;
			  display: flex;
			  -webkit-flex-direction: column;
			      -ms-flex-direction: column;
			          flex-direction: column;
			  -webkit-justify-content: flex-end;
			      -ms-flex-pack: end;
			          justify-content: flex-end;
			  padding: 16px;
			}
			.rnt-avatar-dropdown {
			  display: -webkit-flex;
			  display: -ms-flexbox;
			  display: flex;
			  position: relative;
			  -webkit-flex-direction: row;
			      -ms-flex-direction: row;
			          flex-direction: row;
			  -webkit-align-items: center;
			      -ms-flex-align: center;
			          align-items: center;
			  width: 100%;
				justify-content: center;
			}

			.rnt-navigation {
			  -webkit-flex-grow: 1;
			      -ms-flex-positive: 1;
			          flex-grow: 1;
			}
			.rnt-layout .rnt-navigation .mdl-navigation__link {
			  display: -webkit-flex !important;
			  display: -ms-flexbox !important;
			  display: flex !important;
			  -webkit-flex-direction: row;
			      -ms-flex-direction: row;
			          flex-direction: row;
			  -webkit-align-items: center;
			      -ms-flex-align: center;
			          align-items: center;
			  color: rgba(255, 255, 255, 0.56);
			  font-weight: 500;
			}
			.rnt-layout .rnt-navigation .mdl-navigation__link:hover {
			  background-color: #00BCD4;
			  color: #37474F;
			}
			.rnt-navigation .mdl-navigation__link .material-icons {
			  font-size: 24px;
			  color: rgba(255, 255, 255, 0.56);
			  margin-right: 32px;
			}

		</style>
  </head>

	<body>
		<div class="rnt-layout mdl-layout mdl-js-layout mdl-layout--fixed-drawer mdl-layout--fixed-header">

			<header class="rnt-header mdl-layout__header mdl-color--grey-100 mdl-color-text--grey-600">
				<div class="mdl-layout__header-row">
					<span class="mdl-layout-title"><?php echo ucfirst($site); ?></span>
					<div class="mdl-layout-spacer"></div>
				</div>
			</header>


			<div class="rnt-drawer mdl-layout__drawer mdl-color--blue-grey-900 mdl-color-text--blue-grey-50">

				<header class="rnt-drawer-header">
					<div class="rnt-avatar-dropdown">
						<?php
							if($user->isLogin()) {

								echo '<span>' . $user->getUserName() . '</span>';
								echo
									'<div class="mdl-layout-spacer"></div>

									<button class="mdl-button mdl-js-button mdl-button--icon" onclick="location.href=' . "'/konto'" . ';" id="button-konto">
										<i class="material-icons">settings</i>
									</button>
									<div class="mdl-tooltip" for="button-konto">Ustawienia konta</div>

									<div style="width:10px;"></div>

									<form action="/" method="post" id="logout">
										<input type="hidden" name="type" value="logout">
										<button class="mdl-button mdl-js-button mdl-button--icon" onclick="logout.submit();" id="button-logout">
	  									<i class="material-icons">power_settings_new</i>
										</button>
										<div class="mdl-tooltip" for="button-logout">Wyloguj</div>
									</form>';

							} else {
								echo '<button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" onclick="location.href=' . "'logowanie'" . ';">Zaloguj się</button>';
							}
						?>
					</div>
				</header>


				<nav class="rnt-navigation mdl-navigation mdl-color--blue-grey-800">
					<a class="mdl-navigation__link" href="/panel"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">dashboard</i>Panel</a>
					<a class="mdl-navigation__link" href="/archiwum"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">archive</i>Archiwum</a>
					<a class="mdl-navigation__link" href="/ustawienia"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">settings</i>Ustawienia</a>
					<div class="mdl-layout-spacer"></div>
					<a class="mdl-navigation__link" href="/kontakt"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">contact_phone</i>Kontakt</a>
					<a class="mdl-navigation__link" href="/licencje"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">copyright</i>Licencje</a>
				</nav>

			</div>



			<main class="mdl-layout__content mdl-color--grey-100">
					<?php if(file_exists($file)) include_once($file); ?>
			</main>

		</div>


		<script src="https://code.getmdl.io/1.1.3/material.min.js"></script>

		<?php
			if($message) {
				echo '<div id="toast" class="mdl-js-snackbar mdl-snackbar">
								<div class="mdl-snackbar__text"></div>
								<button type="button" class="mdl-snackbar__action"></button>
							</div>

							<script>
								function message() {
									var notification = document.getElementById("toast");
									notification.MaterialSnackbar.showSnackbar(
										{
	    								message: "' . $message . '",
											timeout: 2000
	  								}
									);
								}
								window.onload = message;
							</script>';
			}
		?>
	</body>
</html>
