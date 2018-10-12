<?php /* Nazwa: Lista Substytutów */ ?>
<?php 	require_once($_SERVER ['DOCUMENT_ROOT'].'czy_zalogowany.php');	
		
	function wygeneruj_tabelke($lista_wynikow, $uzytkownik, $db){
		if(!is_null($lista_wynikow)){
				?>
							<div class="table-responsive moja_tabela">
								<table id="" class="tabela_lista_substytutow table_data_table table table-striped table-hover">
									<thead>
										<tr>
											<th class="col-md-1">ID</th>
											<th class="col-md-2">Nazwisko</th>
											<th class="col-md-2">Imię</th>
											<th class="col-md-1">Koszt</th>
											<th class="col-md-2">Forma</th>
											<th class="col-md-2">Telefon</th>
											<th class="col-md-2">Email</th>
											<th class="col-md-2">Miejscowość</th>
											<th class="ukryj"></th>
										</tr>
									</thead>
									<tbody>														
										<?php 
											while ($poj_sub = $lista_wynikow->fetch_object()) {
												$sub_forma_nazwa = $db-> pobierz_wartosc('wartosc', 'slownik_substytut_forma_platnosci', 'id', $poj_sub->forma_platnosci_id_domyslna);
                                                $sub_miasto_nazwa = $db-> pobierz_wartosc('nazwa', 'slownik_miasto', 'id', $poj_sub->slownik_miasto_id);
												echo '<tr class="';
													if(in_array(26, $uzytkownik->__get('_lista_przyznanych_uprawnien'))){
														echo 'substytut_edytuj cursor_p';
													}
												echo '" data-element_id="'.$poj_sub->id.'">';
													echo '<td class="col-md-1">'.$poj_sub->id.'</td>';
													echo '<td class="col-md-2">'.$poj_sub->nazwisko.'</td>';
													echo '<td class="col-md-2">'.$poj_sub->imie.'</td>';
													echo '<td class="col-md-1">'.$poj_sub->koszt_stawiennictwa_domyslny.'</td>';
													echo '<td class="col-md-2">'.mb_ucfirst($sub_forma_nazwa->wartosc).'</td>';
													echo '<td class="col-md-2">'.$poj_sub->nr_telefonu.'</td>';
													echo '<td class="col-md-2">'.$poj_sub->email.'</td>';
													echo '<td class="col-md-2">'.mb_ucfirst($sub_miasto_nazwa->nazwa).'</td>';
													echo '<td class="ukryj"></td>';
												echo '</tr>';
											}
										?>
									</tbody>
								</table>
							</div>
				<?php
			}else{
				echo 'Brak danych...';
			}
	}
	
	
	?>
	
	<ul class="nav nav-tabs" role="tablist">
		<li role="presentation" class="active"><a href="#aktywni" aria-controls="aktywni" role="tab" data-toggle="tab">Aktywni</a></li>
		<?php if(in_array(25, $uzytkownik->__get('_lista_przyznanych_uprawnien'))){ ?>	
			<li role="presentation"><a href="#usunieci" aria-controls="usunieci" role="tab" data-toggle="tab">Usunięci</a></li>
		<?php } ?>
		<?php if(in_array(27, $uzytkownik->__get('_lista_przyznanych_uprawnien'))){ ?>	
			<li role="presentation"><a href="#dodaj_substytuta" aria-controls="dodaj_substytuta" role="tab" data-toggle="tab">Dodaj substytuta</a></li>
		<?php } ?>
	</ul> 
	
	<div class="tab-content">
		<div role="tabpanel" class="tab-pane active" id="aktywni">
			<?php 
			
				
						
				$lista_substytutow = $db->pobierz_wartosci_where('substytut', 'czy_usuniety = 0');

				wygeneruj_tabelke($lista_substytutow, $uzytkownik, $db);

				
			?>
		</div>
		<?php if(in_array(25, $uzytkownik->__get('_lista_przyznanych_uprawnien'))){ ?>	
			<div role="tabpanel" class="tab-pane" id="usunieci">
				<?php 
					$lista_substytutow = $db->pobierz_wartosci_where('substytut', 'czy_usuniety = 1');
				
					wygeneruj_tabelke($lista_substytutow, $uzytkownik, $db);
					
				?>
			</div>
		<?php } ?>
		<?php if(in_array(27, $uzytkownik->__get('_lista_przyznanych_uprawnien'))){ ?>	
			<div role="tabpanel" class="tab-pane" id="dodaj_substytuta">
					<div class="input_zwykly">
						<div class="form-group col-md-4">
							<input type="text" class="form-control substytut_nazwisko" value="" placeholder="Nazwisko">
						</div>
						<div class="form-group col-md-4">
							<input type="text" class="form-control substytut_imie" value="" placeholder="Imię">
						</div>
						<div class="form-group col-md-4">
							<div class="float_r dropdown  width_100">
								<button class="width_100 btn substytut_uprawnienia btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
							    	<span class="substytut_uprawnienia_nazwa  element_grupa_opcja_naglowek float_l" data-wartosc_domyslna="" value="" >Uprawnienia</span>
									<span class="caret float_r"></span>
								</button>
								<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
							    	<?php 					
										$lista_substytut_uprawnienia = $db->pobierz_wiersze('slownik_substytut_uprawnienia', 'czy_usuniety', '0');
										while ($poj_lista_substytut_uprawnienia = $lista_substytut_uprawnienia->fetch_object()) {
											echo '<li id="substytut_forma_platnosci_'.$poj_lista_substytut_uprawnienia->id.'" class=" element_grupa_opcja  dropdown-menu_opcja cursor_p " data-wartosc="'.mb_ucfirst($poj_lista_substytut_uprawnienia->wartosc).'" data-element_id="'.$poj_lista_substytut_uprawnienia->id.'">';
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
							<input type="text" class="form-control substytut_ulica" value="" placeholder="Ulica">
						</div>
						<div class="form-group col-md-4">
							<input type="text" class="form-control substytut_miasto" value="" placeholder="Miasto">
						</div>
						<div class="form-group col-md-4">
							<?php lista_wojewodz(); ?>
						</div>
						<div class="clear_b"></div>
					</div>
					<div class="input_zwykly">
						<div class="form-group col-md-2">
							<input type="text" class="form-control substytut_kod_pocztowy" value="" placeholder="Kod pocztowy">
						</div>
						<div class="form-group col-md-5">
							<input type="email" class="form-control email_substytut" value="" placeholder="Email firmowy">
						</div>
						<div class="form-group col-md-5">
							<input type="text" class="form-control email2_substytut" value="" placeholder="Email prywatny">
						</div>
						<div class="clear_b"></div>
					</div>
					<div class="input_zwykly">
						<div class="form-group col-md-4">
							<input type="text" class="form-control telefon_substytut" value="" placeholder="Telefon">
						</div>
						<div class="form-group col-md-4 koszt_substytuta_pola">
							<input type="text" class="form-control substytut_koszt_stawiennictwa_domyslny" value="" placeholder="Kwota">
							<input type="text" disabled class="form-control koszt_substytuta_opis " data-kolumna="" value="NETTO">
						</div>
						<div class="form-group col-md-4">
							<div class="float_r dropdown forma_platnosci_substytut width_100">
								<button class="width_100 btn btn-default substytut_forma_platnosci_id_domyslna dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
							    	<span class="forma_platnosci_nazwa  element_grupa_opcja_naglowek float_l" data-wartosc_domyslna="" value="" >Forma płatności</span>
									<span class="caret float_r"></span>
								</button>
								<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
							    	<?php 					
										$lista_klient_typ_umowy = $db->pobierz_wiersze('slownik_substytut_forma_platnosci', 'czy_usuniety', '0');
										while ($poj_lista_klient_typ_umowy = $lista_klient_typ_umowy->fetch_object()) {
											echo '<li id="substytut_forma_platnosci_'.$poj_lista_klient_typ_umowy->id.'" class=" element_grupa_opcja  dropdown-menu_opcja cursor_p '.( (false) ? 'aktywna' : '' ).'" data-wartosc="'.mb_ucfirst($poj_lista_klient_typ_umowy->wartosc).'" data-element_id="'.$poj_lista_klient_typ_umowy->id.'">';
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
							<textarea placeholder="Opis..." class="form-control opis_substytuta" data-wartosc_domyslna="<?php echo $substytut->opis; ?>" value="<?php echo $substytut->opis; ?>"></textarea>
						</div>
						<div class="clear_b"></div>
							<div class="form-group margin_t_10">
							<span>Substytut z Kancelarii</span>
							<i class="votum_substytut ikona_zaznacz fa fa-square-o" aria-hidden="true"></i>
						</div>
						<div class="clear_b"></div>
						<?php if(in_array(27, $uzytkownik->__get('_lista_przyznanych_uprawnien'))){ ?>
							<div class="margin_t_10"></div>
							<button type="button" class="btn btn-default substytut_dodaj  przycisk_zapisz_zmiany  btn-block text-uppercase  ">Dodaj</button>
						<?php } ?>
				</div>
				
				
			</div>
		<?php } ?>
	</div>	