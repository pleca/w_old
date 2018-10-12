<?php
	require_once($_SERVER ['DOCUMENT_ROOT'].'czy_zalogowany.php');
	
	$bilet = htmlspecialchars($_GET['bilet']);
	$login = htmlspecialchars($_GET['uzytkownik']);
	
	$uzytkownik_dane = $db->pobierz_ogolne_zapytanie('uzytkownik', 'data_link_aktywacyjny, id, imie, nazwisko, login', 'login = "'.$login.'" AND link_aktywacyjny = "'.$bilet.'"');
		
?>

<div class="container tutul_widok text-uppercase"><dt class="tytul_widok_napis">USTAW NOWE HASŁO</dt></div>
<div class="container panel_logowania">
	<div class="panel_logowania_tlo">
		<div id="panel_logowania_formularz" class="biale_tlo reset_hasla" data-bilet="<?php echo $bilet; ?>" data-element_id="<?php echo $uzytkownik_dane->id; ?>">
			
			<?php 
				if(is_null($uzytkownik_dane)){
					echo '<p class="bg-danger">PODANY LINK JEST NIEAKTUALNY!!!</p>';	
					echo '<p class="bg-danger margin_t_10">SKORZYSTAJ PONOWNIE Z OPCJI "ZAPOMNIAŁEM HASŁA"</p>';					
					echo '<div class="margin_t_10 plt_wyslij powrot_do_strony_glownej text-uppercase">POWRÓT DO STRONY GŁÓWNEJ</div>';
					
				}else{
					
					$data_aktualna = strtotime(date("Y-m-d H:i:s")); 
					$data_baza = strtotime($uzytkownik_dane->data_link_aktywacyjny);
					
					$roznica_dat = ($data_aktualna - $data_baza) / (60);
					
					if($roznica_dat > 30){
						echo '<p class="bg-danger">PODANY LINK STRACIŁ WAŻNOŚĆ!!!</p>';							
						echo '<p class="bg-danger margin_t_10">SKORZYSTAJ PONOWNIE Z OPCJI "ZAPOMNIAŁEM HASŁA"</p>';
						echo '<div class="margin_t_10 plt_wyslij powrot_do_strony_glownej text-uppercase">POWRÓT DO STRONY GŁÓWNEJ</div>';
						
						$db->aktualizuj_wartosc('uzytkownik', array('link_aktywacyjny' => 'null'), $uzytkownik_dane->id);
						dodaj_wpis_histori($uzytkownik_id->id, 'uzytkownik_id', 'Wygasł link', '', $data_aktualna, 'uzytkownik_historia_zmian');
						
					}else{
					
			?>
			
					<input disabled type="text" class="pole_input uzytkownik_login pole_input_fokus  margin_b_10" data-wartosc_domyslna="<?php echo $uzytkownik_dane->login; ?>" value="<?php echo $uzytkownik_dane->login; ?>">
					<input disabled type="text" class="pole_input uzytkownik_imie pole_input_fokus margin_b_10" data-wartosc_domyslna="<?php echo $uzytkownik_dane->imie; ?>" value="<?php echo $uzytkownik_dane->imie; ?>">
					<input disabled type="text" class="pole_input uzytkownik_nazwisko pole_input_fokus margin_b_10" data-wartosc_domyslna="<?php echo $uzytkownik_dane->nazwisko; ?>" value="<?php echo $uzytkownik_dane->nazwisko; ?>">
					<input class="pole_input pole_input_fokus haslo uzytkownik_haslo margin_b_10" placeholder="Hasło użytkownika" type="password">
					<input class="pole_input pole_input_fokus haslo uzytkownik_powtorz_haslo margin_b_10" placeholder="Powtórz hasło użytkownika" type="password">
					<div class="plt_wyslij reset_hasla_przycisk text-uppercase">ZAPISZ</div>
				
			<?php 	} 
				} ?>
		</div>
	</div>
</div>