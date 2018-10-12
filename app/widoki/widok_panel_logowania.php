<?php
	require_once($_SERVER ['DOCUMENT_ROOT'].'czy_zalogowany.php');
	
?>
<div class="container tutul_widok text-uppercase"><dt class="tytul_widok_napis">WPROWADŹ NAZWE UŻYTKOWNIKA I HASŁO</dt></div>
<div class="container panel_logowania">
	<div class="panel_logowania_tlo">
		<div class="plt_l pull-left">
			<div id="panel_logowania_formularz" class="biale_tlo">
				<?php 
					require_once 'widok_zaloguj.php';
				?>
			</div>			
		</div>
		<div class="plt_p pull-right">
			<div id="zaloguj" data-widok="zaloguj" class="przycisk_border aktywny text-uppercase panel_logowania przeladuj_widok">ZALOGUJ</div>
			<div id="zapomnialem_hasla" data-widok="zapomnialem_hasla" class="przycisk_border text-uppercase panel_logowania przeladuj_widok">ZAPOMNIAŁEM HASŁA</div>
			<?php  
				// echo '<div id="zarejestruj_sie" data-widok="zarejestruj_sie" class="przycisk_border text-uppercase panel_logowania przeladuj_widok">ZAREJESTRUJ SIĘ</div>';
			?>
		</div>
		<div class="clear_b"></div>		
	</div>
</div>
