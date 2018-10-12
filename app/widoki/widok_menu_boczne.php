<?php 
	require($_SERVER ['DOCUMENT_ROOT'].'czy_zalogowany.php');
?>

<div class="wysun_menu affix cursor_p">
	<div class="wysun_menu_kreska"></div>
	<div class="wysun_menu_kreska"></div>
	<div class="wysun_menu_kreska"></div>
</div>
<div class="menu affix">
	<div class="menu_naglowek">
		<p>Witaj</p>
		<p class="menu_naglowek_imie_nazwisko"><?php echo '<span class="mnin_imie">'.$uzytkownik->__get('_imie').'</span> <span class="mnin_nazwisko">'.$uzytkownik->__get('_nazwisko').'</span>'; ?></p>
	</div>
		
	<div class="menu_kreska"></div>
			
	<div class="menu_opcje">
					
		<?php 
			$lista_modulow = lista_modulow_stron_zakladek('moduly'); 
			foreach($lista_modulow as $m){
				$modul_id = $db->pobierz_wartosc('id', 'uzytkownik_uprawnienia_moduly', 'wartosc_uproszczona', $m);
				if(in_array($modul_id->id, $uzytkownik->__get('_lista_przyznanych_modulow'))){
					echo '<div data-modul="'.$m.'" class="przycisk_menu_boczne text-center modul text-uppercase przeladuj_widok">'.$m.'</div>';
				}
			}
		?>
						
					
		<div class="clear_b"></div>
	</div> 

	<div class="menu_kreska"></div>
	<div class="wyloguj przycisk_szary text-center">WYLOGUJ</div>
</div>
