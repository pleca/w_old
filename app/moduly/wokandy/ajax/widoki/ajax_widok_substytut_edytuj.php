<?php
	require_once($_SERVER ['DOCUMENT_ROOT'].'czy_zalogowany.php');
	
	$id = (isset($_POST['id'])) ? htmlspecialchars($_POST['id']) : '' ;
	$tab = (isset($_POST['tab'])) ? htmlspecialchars($_POST['tab']) : '' ;
	
	$substytut = $db->pobierz_wiersz('substytut', 'id', $id);
	$substytut_forma_platnosci = $db->pobierz_wiersz('slownik_substytut_forma_platnosci', 'id', $substytut->forma_platnosci_id_domyslna);
	$substytut_uprawnienia = $db->pobierz_wiersz('slownik_substytut_uprawnienia', 'id', $substytut->slownik_substytut_uprawnienia_id);
	$substytut_miasto = $db->pobierz_wiersz('slownik_miasto', 'id', $substytut->slownik_miasto_id);
	$substytut_wojewodztwo = $db->pobierz_wiersz('slownik_wojewodztwo', 'id', $substytut_miasto->wojewodztwo_id);
	
?>
	
	<div class="element_szczegoly" data-element_id="<?php echo $id; ?>" data-widok="<?php echo $tab; ?>">
		<div class="text-uppercase">
			<span>szczegóły substytuta(<?php echo $id; ?>)</span>
			<?php 
				if($tab === 'aktywni'){
					if(in_array(12, $uzytkownik->__get('_lista_przyznanych_uprawnien'))){
						echo '<i class="fa fa-trash substytut_usun_przycisk" aria-hidden="true" title="Czy jesteś pewnien?" data-placement="left" data-toggle="popover" data-content="<button type=\'button\' class=\'width_100 substytut_usun btn btn-danger\'>TAK</button>"></i>';						
					}
				}
				
				if($tab === 'usunieci'){
					if(in_array(13, $uzytkownik->__get('_lista_przyznanych_uprawnien'))){
						echo '<i class="fa fa-undo substytut_przywroc_przycisk" aria-hidden="true" title="Czy jesteś pewnien?" data-placement="left" data-toggle="popover" data-content="<button type=\'button\' class=\'width_100 substytut_przywroc btn btn-danger\'>TAK</button>"></i>';
					}
				}
			?>
			<div class="clear_b"></div>
		</div>
	</div>

	<ul class="nav nav-tabs" role="tablist">
		<li role="presentation" class="active"><a href="#ogolne" aria-controls="ogolne" role="tab" data-toggle="tab">Ogólne</a></li>
		<?php if(in_array(30, $uzytkownik->__get('_lista_przyznanych_uprawnien'))){ ?>
			<li role="presentation"><a href="#historia" aria-controls="historia" role="tab" data-toggle="tab">Historia</a></li>
		<?php } ?>
	</ul>
	<div class="tab-content">
		<div role="tabpanel" class="tab-pane active szczegoly_substytut" id="ogolne"> 
			<div class="input_zwykly">
						<div class="form-group col-md-4">
							<input type="text" class="form-control substytut_nazwisko" data-wartosc_domyslna="<?php echo $substytut->nazwisko; ?>" value="<?php echo $substytut->nazwisko; ?>" placeholder="Nazwisko">
						</div>
						<div class="form-group col-md-4">
							<input type="text" class="form-control substytut_imie" data-wartosc_domyslna="<?php echo $substytut->imie; ?>" value="<?php echo $substytut->imie; ?>" placeholder="Imię">
						</div>
						<div class="form-group col-md-4">
							<div class="float_r dropdown  width_100">
								<button class="width_100 btn substytut_uprawnienia btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
							    	<span class="substytut_uprawnienia_nazwa  element_grupa_opcja_naglowek float_l" data-wartosc_domyslna="<?php echo $substytut->slownik_substytut_uprawnienia_id; ?>" value="<?php echo $substytut->slownik_substytut_uprawnienia_id; ?>" ><?php echo $substytut_uprawnienia->wartosc; ?></span>
									<span class="caret float_r"></span>
								</button>
								<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
							    	<?php 					
										$lista_substytut_uprawnienia = $db->pobierz_wiersze('slownik_substytut_uprawnienia', 'czy_usuniety', '0');
										while ($poj_lista_substytut_uprawnienia = $lista_substytut_uprawnienia->fetch_object()) {
											echo '<li id="substytut_forma_platnosci_'.$poj_lista_substytut_uprawnienia->id.'" class=" element_grupa_opcja  dropdown-menu_opcja cursor_p '.(($substytut->slownik_substytut_uprawnienia_id == $poj_lista_substytut_uprawnienia->id) ? 'aktywna' : '').'" data-wartosc="'.mb_ucfirst($poj_lista_substytut_uprawnienia->wartosc).'" data-element_id="'.$poj_lista_substytut_uprawnienia->id.'">';
												echo '<i class="fa fa-check" aria-hidden="true"></i>';
												echo mb_ucfirst($poj_lista_substytut_uprawnienia->wartosc);
											echo '</li>';
										}
									?>
						 		</ul>
							</div>
						</div>
						<div class="clear_b"></div>
					</div>
					
					<div class="input_zwykly">
						<div class="form-group col-md-4">
							<input type="text" class="form-control substytut_ulica" data-wartosc_domyslna="<?php echo $substytut->ulica; ?>" value="<?php echo $substytut->ulica; ?>" placeholder="Ulica">
						</div>
						<div class="form-group col-md-4">
							<input type="text" class="form-control substytut_miasto" data-wartosc_domyslna="<?php echo $substytut_miasto->nazwa; ?>" value="<?php echo $substytut_miasto->nazwa; ?>" placeholder="Miasto">
						</div>
						<div class="form-group col-md-4">
							<?php lista_wojewodz($substytut_miasto->wojewodztwo_id, $substytut_wojewodztwo->nazwa); ?>
						</div>
						<div class="clear_b"></div>
					</div>
					<div class="input_zwykly">
						<div class="form-group col-md-2">
							<input type="text" class="form-control substytut_kod_pocztowy" data-wartosc_domyslna="<?php echo $substytut->kod_pocztowy; ?>" value="<?php echo $substytut->kod_pocztowy; ?>" placeholder="Kod pocztowy">
						</div>
						<div class="form-group col-md-5">
							<input type="email" class="form-control email_substytut" data-wartosc_domyslna="<?php echo $substytut->email; ?>" value="<?php echo $substytut->email; ?>" placeholder="Email firmowy">
						</div>
						<div class="form-group col-md-5">
							<input type="text" class="form-control email2_substytut" data-wartosc_domyslna="<?php echo $substytut->email2; ?>" value="<?php echo $substytut->email2; ?>" placeholder="Email prywatny">
						</div>
						<div class="clear_b"></div>
					</div>
					<div class="input_zwykly">
						<div class="form-group col-md-4">
							<input type="text" class="form-control telefon_substytut" data-wartosc_domyslna="<?php echo $substytut->nr_telefonu; ?>" value="<?php echo $substytut->nr_telefonu; ?>" placeholder="Telefon">
						</div>
						<div class="form-group col-md-4 koszt_substytuta_pola">
							<input type="text" class="form-control substytut_koszt_stawiennictwa_domyslny" data-wartosc_domyslna="<?php echo $substytut->koszt_stawiennictwa_domyslny; ?>" value="<?php echo $substytut->koszt_stawiennictwa_domyslny; ?>" placeholder="Kwota">
							<input type="text" disabled class="form-control koszt_substytuta_opis " data-kolumna="" value="NETTO">
						</div>
						<div class="form-group col-md-4">
							<div class="float_r dropdown forma_platnosci_substytut width_100">
								<button class="width_100 btn btn-default substytut_forma_platnosci_id_domyslna dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
							    	<span class="forma_platnosci_nazwa  element_grupa_opcja_naglowek float_l" data-wartosc_domyslna="<?php echo $substytut->forma_platnosci_id_domyslna; ?>" value="<?php echo $substytut->forma_platnosci_id_domyslna; ?>" ><?php echo $substytut_forma_platnosci->wartosc; ?></span>
									<span class="caret float_r"></span>
								</button>
								<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
							    	<?php 					
										$lista_klient_typ_umowy = $db->pobierz_wiersze('slownik_substytut_forma_platnosci', 'czy_usuniety', '0');
										while ($poj_lista_klient_typ_umowy = $lista_klient_typ_umowy->fetch_object()) {
											echo '<li id="substytut_forma_platnosci_'.$poj_lista_klient_typ_umowy->id.'" class=" element_grupa_opcja  dropdown-menu_opcja cursor_p '.( ($substytut->forma_platnosci_id_domyslna == $poj_lista_klient_typ_umowy->id) ? 'aktywna' : '' ).'" data-wartosc="'.mb_ucfirst($poj_lista_klient_typ_umowy->wartosc).'" data-element_id="'.$poj_lista_klient_typ_umowy->id.'">';
												echo '<i class="fa fa-check" aria-hidden="true"></i>';
												echo mb_ucfirst($poj_lista_klient_typ_umowy->wartosc);
											echo '</li>';
										}
									?>
						 		</ul>
							</div>
						</div>
						<div class="clear_b"></div>
						
					</div>	
					<div class="input_zwykly">
						<div class="form-group col-md-12">
							<textarea placeholder="Opis..." class="form-control opis_substytuta" data-wartosc_domyslna="<?php echo $substytut->opis; ?>" value="<?php echo $substytut->opis; ?>"><?php echo $substytut->opis; ?></textarea>
						</div>
						<div class="clear_b"></div>
						<div class="form-group margin_t_10">
							<span>Substytut z Kancelarii</span>
							<i class="votum_substytut <?php echo ($substytut->czy_votum == 1) ? 'zaznaczony' : '' ; ?> ikona_zaznacz fa fa<?php echo ($substytut->czy_votum == 1) ? '-check' : '' ; ?>-square-o" aria-hidden="true"></i>
						</div>
						<div class="clear_b"></div>
						
						<?php if(in_array(26, $uzytkownik->__get('_lista_przyznanych_uprawnien'))){ ?>
							<div class="margin_t_10"></div>
							<button type="button" class="btn btn-default substytut_aktualizuj  przycisk_zapisz_zmiany  btn-block text-uppercase  ">Zapisz zmiany</button>
						<?php } ?>
					</div>
						
		</div>
		<div role="tabpanel" class="tab-pane " id="historia">
			<?php 
				if(in_array(15, $uzytkownik->__get('_lista_przyznanych_uprawnien'))){
					zakladka_historia('substytut_historia_zmian', 'substytut_id', $db, $id);
				}				 				
			?>
		</div>
	</div>