<?php
	require($_SERVER ['DOCUMENT_ROOT'].'czy_zalogowany.php');	
?>

<div class="container tutul_widok text-uppercase"><dt class="tytul_widok_napis">wybierz jeden z elementów</dt></div>

<?php gdzie_jestem(); ?>

<div class="container strona_cala">
	<div class="strona_tlo">
		
		<?php 
			
			$lista_modulow = lista_modulow_stron_zakladek('moduly'); 
			foreach($lista_modulow as $m){
				$modul_id = $db->pobierz_wartosc('id', 'uzytkownik_uprawnienia_moduly', 'wartosc_uproszczona', $m);

				if(in_array($modul_id->id, $uzytkownik->__get('_lista_przyznanych_modulow'))){
					echo '<div data-modul="'.$m.'" class="przycisk_border modul text-uppercase przeladuj_widok">'.$m.'</div>';
				}				
			}
		?>
		
		<div class="clear_b"></div>		
	</div>
</div>