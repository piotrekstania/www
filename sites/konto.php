<?php
if(!$user->isLogin()) {
	header("Location: /logowanie");
	die();
}
?>


<div class="mdl-grid" style="max-width:1000px;">


	<div class="mdl-card mdl-cell mdl-cell--8-col mdl-cell--2-offset-desktop mdl-shadow--4dp">

		<form action="/konto" method="post">
			<input type="hidden" name="type" value="change_pass">

			<div class="mdl-card__title" style="background-color: #607d8b;">
				<h2 class="mdl-card__title-text rnt-card-title-text">Zmiana hasła</h2>
			</div>

			<div class="mdl-card__supporting-text">

				<div class="rnt-login-textfiled mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
					<input class="mdl-textfield__input" type="password" id="old_pass" name="old_pass">
					<label class="mdl-textfield__label" for="old_pass">Stare hasło</label>
				</div>

				<div class="rnt-login-textfiled mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
					<input class="mdl-textfield__input" type="password" id="new_pass" name="new_pass">
					<label class="mdl-textfield__label" for="new_pass">Nowe hasło</label>
				</div>

				<div class="rnt-login-textfiled mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
					<input class="mdl-textfield__input" type="password" id="conf_pass" name="conf_pass">
					<label class="mdl-textfield__label" for="conf_pass">Potwierdź hasło</label>
				</div>

				<button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" type="submit" style="float:right; margin-bottom:10px;">Zmień hasło</button>

			</div>
		</form>
	</div>



<?php
	if(!$user->isAdmin()) {
		echo "</div>";
		return;
	}
?>


<div class="mdl-card mdl-cell mdl-cell--8-col mdl-cell--2-offset-desktop mdl-shadow--4dp">
	<div class="mdl-card__title" style="background-color: #607d8b;">
		<h2 class="mdl-card__title-text rnt-card-title-text">Użytkownicy</h2>
	</div>

	<div class="mdl-card__supporting-text" style="overflow: auto;">
		<table class="mdl-data-table mdl-js-data-table" style="width:100%;">

			<thead>
				<tr>
					<?php
						$list = $user->getUsers();

						foreach($list[0] as $key=>$value) {
							echo '<th class="mdl-data-table__cell--non-numeric">' . $key . '</th>';
						}

						echo '<th>Usuwanie</th>';
					?>
				</tr>
			</thead>

			<tbody>
				<?php
					foreach($list as $key=>$value){
						echo '<tr>';
						foreach($value as $key2=>$value2){
							echo '<td class="mdl-data-table__cell--non-numeric">' . $value2 . '</td>';
						}

						$id = $value['ID'];
						$en = "";
						$mes = "'Usunąć użytkownika o ID: " . $id . "?'";

						if($id == 1) $en = "disabled";

						echo '<td>
							<form action="/konto" method="post" onsubmit="return confirm(' . $mes . ');">
								<input type="hidden" name="type" value="remove_user">
								<input type="hidden" name="id" value="' . $id . '">
								<button class="mdl-button mdl-js-button mdl-button--accent" type="submit" ' . $en . '>usuń</button>
							</form>
							</td>';

							echo '</tr>';
						}
				?>
			</tbody>
		</table>
	</div>
</div>




<div class="mdl-card mdl-cell mdl-cell--8-col mdl-cell--2-offset-desktop mdl-shadow--4dp">

	<form action="/konto" method="post">
		<input type="hidden" name="type" value="add_user">

		<div class="mdl-card__title" style="background-color: #607d8b;">
			<h2 class="mdl-card__title-text rnt-card-title-text">Dodaj użytkownika</h2>
		</div>

		<div class="mdl-card__supporting-text">

			<div class="rnt-login-textfiled mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
				<input class="mdl-textfield__input" type="text" id="user" name="user">
				<label class="mdl-textfield__label" for="user">Nazwa użytkownika</label>
			</div>

			<div class="rnt-login-textfiled mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
				<input class="mdl-textfield__input" type="text" id="pass" name="pass">
				<label class="mdl-textfield__label" for="pass">Hasło</label>
			</div>

			<button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" type="submit" style="float:right; margin-bottom:10px;">Dodaj użytkownika</button>

		</div>
	</form>
</div>



</div>
