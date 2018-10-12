<?php
	require($_SERVER ['DOCUMENT_ROOT'].'czy_zalogowany.php');
	
	$id = (isset($_POST['id'])) ? htmlspecialchars($_POST['id']) : '' ;
	$tab = (isset($_POST['tab'])) ? htmlspecialchars($_POST['tab']) : '' ;
	$wynik = $db->pobierz_wiersz('uzytkownik', 'id', $id);
	
	$lista_przyznanych_modulow_edytuj = pobierz_liste_uprawnien('uzytkownik_uprawnienia_moduly_id', 'uzytkownik_id_uzytkownik_uprawnienia_moduly_id', $id);
	
	$lista_przyznanych_stron_edytuj = pobierz_liste_uprawnien('uzytkownik_uprawnienia_strony_id', 'uzytkownik_id_uzytkownik_uprawnienia_strony_id', $id);
	
	$lista_przyznanych_zakladek_edytuj = pobierz_liste_uprawnien('uzytkownik_uprawnienia_zakladki_id', 'uzytkownik_id_uzytkownik_uprawnienia_zakladki_id', $id);
	
	$lista_przyznanych_uprawnien = pobierz_liste_uprawnien('uzytkownik_uprawnienia_id', 'uzytkownik_id_uzytkownik_uprawnienia_id', $id);
	
	
?>

<div class="uzytkownik_szczegoly" data-element_id="<?php echo $id; ?>" data-widok="<?php
	echo ($tab === 'aktywni') ? 'aktywni' : 'usunieci' ;
?>">
	<div class="text-uppercase">
		<span>szczegóły użytkownika(<?php echo $id; ?>)</span>
		<?php 
			if($tab === 'aktywni'){
				if(in_array(3, $uzytkownik->__get('_lista_przyznanych_uprawnien'))){
					echo '<i class="fa fa-trash uzytkownik_usun_przycisk" aria-hidden="true" title="Czy jesteś pewnien?" data-placement="left" data-toggle="popover" data-content="<button type=\'button\' class=\'width_100 uzytkownik_usun btn btn-danger\'>TAK</button>"></i>';						
				}
			}
			
			if($tab === 'usunieci'){
				if(in_array(4, $uzytkownik->__get('_lista_przyznanych_uprawnien'))){
					echo '<i class="fa fa-undo uzytkownik_przywroc_przycisk" aria-hidden="true" title="Czy jesteś pewnien?" data-placement="left" data-toggle="popover" data-content="<button type=\'button\' class=\'width_100 uzytkownik_przywroc btn btn-danger\'>TAK</button>"></i>';
				}
			}
		?>
		<i class="fa fa-sign-out uzytkownik_wymus_wylogowanie margin_right_5" aria-hidden="true" title="Czy jesteś pewnien?" data-placement="left" data-toggle="popover" data-content="<button type='button' class='width_100 uzytkownik_wymus_wylogowanie_przycisk btn btn-danger'>TAK</button>"></i>
		<div class="clear_b"></div>
	</div>
</div>

<?php 
	$zablokowane = '';

	if(!in_array(2, $uzytkownik->__get('_lista_przyznanych_uprawnien'))){ 
		$zablokowane = 'disabled';
	} 
?>

	<ul class="nav nav-tabs" role="tablist">
		<li role="presentation" class="active"><a href="#ogolne" aria-controls="ogolne" role="tab" data-toggle="tab">Ogólne</a></li>
		<?php if(in_array(32, $uzytkownik->__get('_lista_przyznanych_uprawnien'))){ ?>
			<li role="presentation"><a href="#szczegoly" aria-controls="szczegoly" role="tab" data-toggle="tab">Szczegóły</a></li>
		<?php } ?>
		<?php if(in_array(5, $uzytkownik->__get('_lista_przyznanych_uprawnien'))){ ?>
			<li role="presentation"><a href="#uprawnienia" aria-controls="uprawnienia" role="tab" data-toggle="tab">Uprawnienia</a></li>
		<?php } ?>
		<?php if(in_array(9, $uzytkownik->__get('_lista_przyznanych_uprawnien'))){ ?>
			<li role="presentation"><a href="#historia" aria-controls="historia" role="tab" data-toggle="tab">Historia</a></li>
		<?php } ?>
		
	</ul>
	<div class="tab-content">
		<div role="tabpanel" class="tab-pane active" id="ogolne">
			<div class="input_50p">
				<div class="form-group">
					<input class="form-control pole_input_fokus uzytkownik_imie" <?php echo $zablokowane; ?> placeholder="Imię" type="text" data-wartosc_domyslna = "<?php echo $wynik->imie; ?>" value="<?php echo $wynik->imie; ?>" >
					<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
				</div>
				<div class="form-group">
					<input class="form-control pole_input_fokus uzytkownik_nazwisko" <?php echo $zablokowane; ?> placeholder="Nazwisko" type="text" data-wartosc_domyslna = "<?php echo $wynik->nazwisko; ?>" value="<?php echo $wynik->nazwisko; ?>">
					<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
				</div>
				<div class="form-group">
					<input class="form-control pole_input_fokus uzytkownik_login" disabled placeholder="Login" type="text" value="<?php echo $wynik->login; ?>">
				</div>
				<div class="form-group pole_email">
					<input class="form-control pole_input_fokus uzytkownik_email" <?php echo $zablokowane; ?> placeholder="Adres email" type="email" data-wartosc_domyslna = "<?php echo $wynik->email; ?>" value="<?php echo $wynik->email; ?>">
					<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
				</div>
				<div class="form-group">
					<input class="form-control pole_input_fokus uzytkownik_telefon" <?php echo $zablokowane; ?> placeholder="Telefon (kom)" type="tel" data-wartosc_domyslna = "<?php echo $wynik->telefon; ?>" value="<?php echo $wynik->telefon; ?>">
					<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
				</div>
				<div class="clear_b"></div>
				<?php if(in_array(2, $uzytkownik->__get('_lista_przyznanych_uprawnien'))){ ?>	
					<div class="form-group pole_haslo">
						<input class="form-control pole_input_fokus uzytkownik_haslo" placeholder="****************" type="password" value="">
						<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
					</div>
					<div class="form-group pole_haslo">
						<input class="form-control pole_input_fokus uzytkownik_haslo_powtorz" placeholder="****************" type="password" value="">
						<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
					</div>
				<?php } ?>
				<div class="clear_b"></div>
				<?php if(in_array(2, $uzytkownik->__get('_lista_przyznanych_uprawnien'))){ ?>	
					<button type="button" class="btn btn-default btn-block text-uppercase aktualizuj uzytkownik_aktualizuj">Zapisz zmiany</button>
				<?php } ?>
			</div>
		</div>
		<?php if(in_array(32, $uzytkownik->__get('_lista_przyznanych_uprawnien'))){ ?>	
			<div role="tabpanel" class="tab-pane" id="szczegoly">
				<div class="input_25p">
					<div class="form-group">
						<span>Data ostatnigo logowania</span>
						<input class="form-control pole_input_fokus" disabled type="text" value="<?php echo $wynik->data_ostatniego_logowania; ?>" >				
					</div>
					<div class="form-group">
						<span>Data wysłania linku</span>
						<input class="form-control pole_input_fokus" disabled type="text" value="<?php echo $wynik->data_link_aktywacyjny; ?>" >				
					</div>
					<div class="form-group">
						<span>Data zmiany hasła</span>
						<input class="form-control pole_input_fokus" disabled type="text" value="<?php echo $wynik->data_zmiana_hasla; ?>" >				
					</div>
					<div class="form-group">
						<span>Login PCE</span>
						<input class="form-control pole_input_fokus" disabled type="text" value="<?php echo $wynik->login_pce_id; ?>" >				
					</div>
					<div class="clear_b"></div>
				</div>
				
			</div>
		<?php } ?>
		<?php if(in_array(5, $uzytkownik->__get('_lista_przyznanych_uprawnien'))){ ?>	
			<div role="tabpanel" class="tab-pane" id="uprawnienia">
				<?php 
					$uzytkownik_grupa_id = $db->pobierz_wartosc('uzytkownik_grupy_id', 'uzytkownik', 'id', $id);
					$uzytkownik_grupa_wartosc = $db->pobierz_wartosc('wartosc', 'uzytkownik_grupy', 'id', $uzytkownik_grupa_id->uzytkownik_grupy_id);
				?>
				<div class="uprawnienia_grupy">Grupa:<span class="uzytkownik_grupy_nazwa"><?php echo $uzytkownik_grupa_wartosc->wartosc; ?></span></div>
				<div class="dropdown uprawnienia_grupy_dropdown">
					<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
						Lista grup użytkowników
						<span class="margin_l_10 caret"></span>
					</button>
					<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
						<?php 
						
							$lista_uzytkownik_grupy = $db->pobierz_wiersze('uzytkownik_grupy', 'czy_usuniety', '0');
							while ($poj_uzytkownik_grupy = $lista_uzytkownik_grupy->fetch_object()) {
								echo '<li id="uzytkownik_grupa_'.$poj_uzytkownik_grupy->id.'" class="uzytkownik_grupa_opcja dropdown-menu_opcja cursor_p '.(($uzytkownik_grupa_id->uzytkownik_grupy_id == $poj_uzytkownik_grupy->id) ? 'aktywna' : '' ).'" data-wartosc="'.$poj_uzytkownik_grupy->wartosc.'" data-element_id="'.$poj_uzytkownik_grupy->id.'">';
									echo '<i class="fa fa-check" aria-hidden="true"></i>';
									echo $poj_uzytkownik_grupy->wartosc;
								echo '</li>';
							}
						?>										
					</ul>
				</div>
				<div class="clear_b margin_b_10"></div>
				
				<div class="uzytkownik_uprawnienia_lista">
					<?php 
						
						
						//$lista_modulow = $db->pobierz_wiersze('uzytkownik_uprawnienia_moduly', 'czy_usuniety', '0');
						$lista_modulow = $db->pobierz_wartosci_where('uzytkownik_uprawnienia_moduly', 'czy_usuniety = 0', 'ORDER BY wartosc ASC' );
						
						while ($poj_lista_modulow = $lista_modulow->fetch_object()) {
							$lista_stron = $db->pobierz_wartosci_where('uzytkownik_uprawnienia_strony', 'czy_usuniety = 0 AND uzytkownik_uprawnienia_moduly_id ='.$poj_lista_modulow->id );
							
							echo '<div class="pojedynczy_modul col-md-6">';
								echo '<div class="panel panel-default">';
									echo '<div class="panel-heading cursor_p uprawnienia_panel"><p class="panel_heading_tytul poj_lista_modul">'.$poj_lista_modulow->wartosc.'</p><i data-element_id="'.$poj_lista_modulow->id.'" class="aktualizuj_uprawnienie poj_modul fa fa'.((in_array($poj_lista_modulow->id, $lista_przyznanych_modulow_edytuj)) ? '-check' : '' ).'-square-o" aria-hidden="true"></i><div class="clear_b"></div></div>';
									echo '<div class="panel-body">';
										echo '<ul class="media-list">';
											if(!is_null($lista_stron)){
												while ($poj_lista_stron = $lista_stron->fetch_object()) {
													$lista_zakladek = $db->pobierz_wartosci_where('uzytkownik_uprawnienia_zakladki', 'czy_usuniety = 0 AND uzytkownik_uprawnienia_strony_id ='.$poj_lista_stron->id, 'ORDER BY wartosc ASC' );
													echo '<li class="media">';
														echo '<div class="media-body">';
															echo '<div class="cursor_p media-heading margin_t_10 poj_lista_stron_heading well well-sm"><p class="panel_heading_tytul poj_lista_stron">'.$poj_lista_stron->wartosc.'<p><i data-element_id="'.$poj_lista_stron->id.'" class="aktualizuj_uprawnienie poj_strona fa fa'.((in_array($poj_lista_stron->id, $lista_przyznanych_stron_edytuj)) ? '-check' : '' ).'-square-o" aria-hidden="true"></i><div class="clear_b"></div></div>';
															echo '<div class="lista_zakladek_na_stronie">';
															
															$lista_uprawnien_strony = $db->pobierz_wartosci_where('uzytkownik_uprawnienia', 'czy_usuniety = 0 AND uzytkownik_uprawnienia_strony_id ='.$poj_lista_stron->id, 'ORDER BY wartosc ASC' );	
															if(!is_null($lista_uprawnien_strony)){
																echo '<ul class="list-group">';
																while ($poj_lista_uprawnien_strony = $lista_uprawnien_strony->fetch_object()) {
																	echo '<li class="list-group-item cursor_p"><p class="list_heading_tytul">'.$poj_lista_uprawnien_strony->wartosc.'</p><i data-element_id="'.$poj_lista_uprawnien_strony->id.'" class="aktualizuj_uprawnienie poj_uprawnienie fa fa'.((in_array($poj_lista_uprawnien_strony->id, $lista_przyznanych_uprawnien)) ? '-check' : '' ).'-square-o" aria-hidden="true"></i><div class="clear_b"></div></li>';
																}
																echo '</ul>';
															}
															
															
																if(!is_null($lista_zakladek)){
																	while ($poj_lista_zakladek = $lista_zakladek->fetch_object()) {
																		$lista_uprawnien = $db->pobierz_wartosci_where('uzytkownik_uprawnienia', 'czy_usuniety = 0 AND uzytkownik_uprawnienia_zakladki_id ='.$poj_lista_zakladek->id, 'ORDER BY wartosc ASC' );													
																		echo '<div class="media">';
																			echo '<div class="media-left"></div>';
																			echo '<div class="media-body">';
																				echo '<div class="cursor_p margin_t_10 media-heading  well well-sm"><p class="panel_heading_tytul poj_lista_zakladek">'.$poj_lista_zakladek->wartosc.'</p><i data-element_id="'.$poj_lista_zakladek->id.'" class="aktualizuj_uprawnienie poj_zakladka fa fa'.((in_array($poj_lista_zakladek->id, $lista_przyznanych_zakladek_edytuj)) ? '-check' : '' ).'-square-o" aria-hidden="true"></i><div class="clear_b"></div></div>';
																				if(!is_null($lista_uprawnien)){
																					echo '<div class="lista_uprawnien_na_zakladce">';
																						echo '<div class="media">';
																							echo '<div class="media-left"></div>';
																							echo '<div class="media-body poj_lista_uprawnien">';
																								echo '<ul class="list-group">';
																									while ($poj_lista_uprawnien = $lista_uprawnien->fetch_object()) {
																										echo '<li class="list-group-item cursor_p"><p class="list_heading_tytul">'.$poj_lista_uprawnien->wartosc.'</p><i data-element_id="'.$poj_lista_uprawnien->id.'" class="aktualizuj_uprawnienie poj_uprawnienie fa fa'.((in_array($poj_lista_uprawnien->id, $lista_przyznanych_uprawnien)) ? '-check' : '' ).'-square-o" aria-hidden="true"></i><div class="clear_b"></div></li>';
																									}
																								echo '</ul>';
																							echo '</div>';
																						echo '</div>';
																					echo '</div>';
																				}
																			echo '</div>';
																		echo '</div>';
																	}
																}
															echo '</div>';
														echo '</div>';
													echo '</li>';
												}
											}else{
												$lista_zakladek = $db->pobierz_wartosci_where('uzytkownik_uprawnienia_zakladki', 'czy_usuniety = 0 AND uzytkownik_uprawnienia_moduly_id ='.$poj_lista_modulow->id , 'ORDER BY wartosc ASC');
												if(!is_null($lista_zakladek)){
													while ($poj_lista_zakladek = $lista_zakladek->fetch_object()) {
														$lista_uprawnien = $db->pobierz_wartosci_where('uzytkownik_uprawnienia', 'czy_usuniety = 0 AND uzytkownik_uprawnienia_zakladki_id ='.$poj_lista_zakladek->id , 'ORDER BY wartosc ASC');													
														echo '<div class="media zakladki_lista">';
															echo '<div class="media-left"></div>';
															echo '<div class="media-body">';
																echo '<div class="cursor_p margin_t_10 media-heading  well well-sm"><p class="panel_heading_tytul poj_lista_zakladek">'.$poj_lista_zakladek->wartosc.'</p><i data-element_id="'.$poj_lista_zakladek->id.'" class="aktualizuj_uprawnienie poj_zakladka fa fa'.((in_array($poj_lista_zakladek->id, $lista_przyznanych_zakladek_edytuj)) ? '-check' : '' ).'-square-o" aria-hidden="true"></i><div class="clear_b"></div></div>';
																echo '<div class="lista_uprawnien_na_zakladce">';
																	echo '<div class="media">';
																		echo '<div class="media-left"></div>';
																		echo '<div class="media-body poj_lista_uprawnien">';
																			echo '<ul class="list-group">';
																				while ($poj_lista_uprawnien = $lista_uprawnien->fetch_object()) {
																					echo '<li class="list-group-item cursor_p"><p class="list_heading_tytul">'.$poj_lista_uprawnien->wartosc.'</p><i data-element_id="'.$poj_lista_uprawnien->id.'" class="aktualizuj_uprawnienie poj_uprawnienie fa fa'.((in_array($poj_lista_uprawnien->id, $lista_przyznanych_uprawnien)) ? '-check' : '' ).'-square-o" aria-hidden="true"></i><div class="clear_b"></div></li>';
																				}
																			echo '</ul>';
																		echo '</div>';
																	echo '</div>';
																echo '</div>';
															echo '</div>';
														echo '</div>';
													}
												}
											}
										echo '</ul>';
									echo '</div>';
								echo '</div>';
							echo '</div>';
						}
						
					?>
					<div class="clear_b"></div>
	
				</div>
				
			</div>
		<?php } ?>
		
		<?php if(in_array(9, $uzytkownik->__get('_lista_przyznanych_uprawnien'))){ ?>	
			<div role="tabpanel" class="tab-pane" id="historia">
				<?php 
				
					zakladka_historia('uzytkownik_historia_zmian', 'uzytkownik_id', $db, $id);
										
				?>														
			</div>
		<?php } ?>
	</div>
