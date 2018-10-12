<?php /* Nazwa: Zarządzanie użytkownikami */ ?>
<?php
	require_once($_SERVER ['DOCUMENT_ROOT'].'czy_zalogowany.php');	
?>

<div class="container tutul_widok text-uppercase"><dt class="tytul_widok_napis">wybierz jeden z elementów</dt></div>

<?php gdzie_jestem(); ?>

<div class="container strona_cala">
	<div class="strona_tlo">
		<div class="strona_l">
			<?php 
				$lista_zakladek = lista_modulow_stron_zakladek('zakladki', 'strony', 'zarzadzanie_uzytkownikami'); 
				foreach($lista_zakladek as $z){				
					echo '<div id="'.$z['link'].'" data-modul="'.$z['modul'].'" data-zakladka="'.$z['link'].'" title="'.$z['nazwa'].'" class="aktywny przycisk_border zakladka text-uppercase przeladuj_widok">'.$z['nazwa'].'</div>';											
				}
			?>
		</div>
		<div class="strona_p">
			<div id="zawartosc_strona_p"> 
				
			</div>
		</div>
						
		
		<div class="clear_b"></div>		
	</div>
</div>