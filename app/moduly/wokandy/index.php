<?php
	require_once($_SERVER ['DOCUMENT_ROOT'].'czy_zalogowany.php');	
		
?>

<div class="container tutul_widok text-uppercase"><dt class="tytul_widok_napis">wybierz jeden z elementów</dt></div>

<?php gdzie_jestem(); ?>

<div class="container strona_cala">
	<div class="strona_tlo">
		
		<?php 
			$lista_stron =  lista_modulow_stron_zakladek('strony');
			foreach($lista_stron as $s){
				echo '<div id="'.$s['link'].'" data-modul="'.$s['modul'].'" data-strona="'.$s['link'].'" title="'.$s['nazwa'].'" class="przycisk_border strona text-uppercase przeladuj_widok">'.$s['nazwa'].'</div>';
				
			}
		?>
				
		<div class="clear_b"></div>		 
	</div>
</div>
</div>