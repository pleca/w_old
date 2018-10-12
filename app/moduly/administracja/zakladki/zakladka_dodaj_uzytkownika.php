<?php /* Nazwa: Dodaj użytkownika */ ?>
<?php
	require_once($_SERVER ['DOCUMENT_ROOT'].'czy_zalogowany.php');	
?>

<div class="input_50p">
	<div class="form-group">
		<input class="form-control pole_input_fokus uzytkownik_imie" placeholder="Imię" type="text">
		<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
	</div>
	<div class="form-group">
		<input class="form-control pole_input_fokus uzytkownik_nazwisko" placeholder="Nazwisko" type="text">
		<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
	</div>
	<div class="form-group">
		<input class="form-control pole_input_fokus uzytkownik_login" placeholder="Login" type="text">
		<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
	</div>
	<div class="form-group pole_email">
		<input class="form-control pole_input_fokus uzytkownik_email" placeholder="Adres email" type="email">
		<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
	</div>
	<div class="form-group">
		<input class="form-control pole_input_fokus uzytkownik_telefon" placeholder="Telefon (kom)" type="tel">
		<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
	</div>
	<div class="clear_b"></div>
	
	<div class="form-group pole_haslo">
		<input class="form-control pole_input_fokus uzytkownik_haslo" placeholder="Hasło" type="password">
		<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
	</div>
	<div class="form-group pole_haslo">
		<input class="form-control pole_input_fokus uzytkownik_haslo_powtorz" placeholder="Powtórz hasło" type="password">
		<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
	</div>
	<div class="clear_b"></div>
	<?php if(in_array(1, $uzytkownik->__get('_lista_przyznanych_uprawnien'))){ ?>
		<button type="button" class="btn btn-default btn-block text-uppercase dodaj uzytkownik_dodaj">Dodaj</button>
	<?php } ?>
</div>  