<div class="mdl-grid" style="max-width:1000px;">
	<div class="mdl-card mdl-cell mdl-cell--8-col mdl-shadow--4dp mdl-cell--2-offset-desktop mdl-cell--middle">

		<form action="/logowanie" method="post">
			<input type="hidden" name="type" value="login">

		<div class="mdl-card__title" style="background-color: #607d8b;">
    	<h2 class="mdl-card__title-text rnt-card-title-text">Logowanie</h2>
  	</div>

	  <div class="mdl-card__supporting-text">

			<div class="rnt-login-textfiled mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
    		<input class="mdl-textfield__input" type="text" id="user" name="user" autofocus>
    		<label class="mdl-textfield__label" for="user">Nazwa użytkownika</label>
  		</div>

			<div class="rnt-login-textfiled mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
    		<input class="mdl-textfield__input" type="password" id="pass" name="pass">
    		<label class="mdl-textfield__label" for="pass">Hasło</label>
  		</div>

			<button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" type="submit" style="float:right; margin-bottom:10px;">Zaloguj się</button>

	  </div>

		</form>

	</div>
</div>
