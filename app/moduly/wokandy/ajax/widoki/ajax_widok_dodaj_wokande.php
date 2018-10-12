
<?php
	require_once($_SERVER ['DOCUMENT_ROOT'].'czy_zalogowany.php');
		
	$tab = (isset($_POST['tab'])) ? htmlspecialchars($_POST['tab']) : 'nowa_wokanda' ;	
			
	$data_poczatek = (isset($_POST['data'])) ? htmlspecialchars($_POST['data']) : date('Y-m-d') ;
	$czas_poczatek = (isset($_POST['czas'])) ? htmlspecialchars($_POST['czas']) : date('H:i') ;
	$data_koniec = date('Y-m-d');
	$czas_koniec = date('H:i');
	
	if($data_poczatek != '' && $czas_poczatek != ''){
		$data_koniec = $data_poczatek;
		$czas_koniec = strtotime($czas_poczatek) + 3600;
		$czas_koniec = date('H:i',$czas_koniec);
		
	}
?>
<div class="widok_dodaj_wokande">

	<div class="element_szczegoly" data-element_id="" data-widok="">
		<div class="text-uppercase">
			Nowa wokanda
		</div>
	</div>
	<div class="wokanda_szczegoly ">
			<div class="panel panel-default">
				<div class="panel-heading aktywny cursor_p">Termin</div>
				<div class="panel-body" style="display:block">
					<div class="well well-sm">
						<div class="input_25p">
							<div class="form-group">
								<label for="data_start">Data początek</label>
								<input id="data_start" type="text" class="wymagane form-control data start" data-kolumna="start" data-wartosc_domyslna="<?php echo $data_poczatek; ?>" value="<?php echo $data_poczatek; ?>" placeholder="Data początku rozprawy">
							</div>
							<div class="form-group">
								<label for="data_start_godzina">&nbsp;</label>
								<input id="data_start_godzina" type="text" class="wymagane form-control" data-wartosc_domyslna="<?php echo $czas_poczatek; ?>" value="<?php echo $czas_poczatek; ?>" placeholder="Godzina początku rozprawy">
							</div>
							<div class="form-group">
								<label for="data_stop">Data koniec</label>
								<input id="data_stop" type="text" class="wymagane form-control data stop" data-kolumna="stop" data-wartosc_domyslna="<?php echo $data_koniec; ?>" value="<?php echo $data_koniec; ?>" placeholder="Data końca rozprawy">
							</div>
							<div class="form-group">
								<label for="data_stop_godzina">&nbsp;</label>
								<input id="data_stop_godzina" type="text" class="wymagane form-control" data-wartosc_domyslna="<?php echo $czas_koniec; ?>" value="<?php echo $czas_koniec; ?>" placeholder="Data końca rozprawy">
							</div>
							<div class="clear_b"></div>
							<div class="form-group margin_b_0 margin_t_0" style="display:none;">
								<span>Potwierdzony termin <i class="ikona_niezaznacz fa fa-square-o potwierdzony_termin" aria-hidden="true"></i></span>
							</div>
							<div class="clear_b"></div>
						</div>
					</div>
					<div class="input_50p">
<!--						<div class="form-group">-->
<!--							<label for="wokanda_nazwa">Nazwa</label>-->
<!--							<input id="wokanda_nazwa" type="text" class="wymagane form-control wokanda_nazwa prm" data-kolumna="nazwa" value="" placeholder="Nazwa wokandy">-->
<!--						</div>-->
					</div>
                    <div class="input_50p">
                        <div class="form-group">
                            <label for="wokanda_nazwa">Nazwa</label>
                            <div id="wokanda_nazwa_miasto" class="dropdown">
                                <div class="form-group miasto_nazwa_pole wyszukaj_like_pole">
                                    <input class="form-control pole_input_fokus miasto_nazwa wyszukaj_like prm" data-kolumna="slownik_miasto_id" data-szukaj_po="nazwa" data-tabela="slownik_miasto" placeholder="Nazwa" type="text" data-miasto-id="" value="" >
                                    <span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="input_50p">
						<div class="form-group">
							<label for="wokanda_etap">Etap I</label>
							<div id="wokanda_etap" class="dropdown">															
								<button  class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
									<span class="element_grupa_opcja_naglowek wokanda_etap_wybrany float_l prm" data-kolumna="slownik_wokanda_etap_id" data-wartosc_domyslna="" value="">Wybierz etap</span>
									<span class="caret float_r"></span>
								</button>
								<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
									<?php 
										$lista_wokanda_etap = $db->pobierz_wartosci_where('slownik_wokanda_etap', 'czy_usuniety = 0');
										while (	$poj_lista_wokanda_etap = $lista_wokanda_etap->fetch_object()) {
											echo '<li id="wokanda_etap_'.$poj_lista_wokanda_etap->id.'" class="wokanda_etap_opcja element_grupa_opcja  dropdown-menu_opcja cursor_p " data-wartosc="'.mb_ucfirst($poj_lista_wokanda_etap->wartosc).'" data-element_id="'.$poj_lista_wokanda_etap->id.'">';
												echo '<i class="fa fa-check" aria-hidden="true"></i>';
												echo mb_ucfirst($poj_lista_wokanda_etap->wartosc);
											echo '</li>';
										}
										
									?>
								</ul>
							</div>
						</div>
						<div class="form-group">
							<label for="wokanda_rodzaj">Rodzaj</label>
							<div id="wokanda_rodzaj" class="dropdown">															
								<button  class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
									<span class="element_grupa_opcja_naglowek wokanda_rodzaj_wybrany float_l prm" data-kolumna="slownik_wokanda_rodzaj_id" data-wartosc_domyslna="" value="">Wybierz rodzaj</span>
									<span class="caret float_r"></span>
								</button>
								<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
									<?php 
										$lista_wokanda_rodzaj = $db->pobierz_wartosci_where('slownik_wokanda_rodzaj', 'czy_usuniety = 0');
										
										while (	$poj_lista_wokanda_rodzaj = $lista_wokanda_rodzaj->fetch_object()) {
											echo '<li id="wokanda_rodzaj_'.$poj_lista_wokanda_rodzaj->id.'" class="wokanda_rodzaj_opcja element_grupa_opcja  dropdown-menu_opcja cursor_p " data-wartosc="'.mb_ucfirst($poj_lista_wokanda_rodzaj->wartosc).'" data-element_id="'.$poj_lista_wokanda_rodzaj->id.'">';
												echo '<i class="fa fa-check" aria-hidden="true"></i>';
												echo mb_ucfirst($poj_lista_wokanda_rodzaj->wartosc);
											echo '</li>';
										}
										
									?>
								</ul>
							</div>
						</div>
                        <div class="form-group">
                            <label for="wokanda_etap">Etap II</label>
                            <div id="wokanda_etap" class="dropdown">
                                <button  class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <span class="element_grupa_opcja_naglowek wokanda_etap_wybrany float_l prm" data-kolumna="slownik_wokanda_etap_2_id" data-wartosc_domyslna="" value="">Wybierz etap</span>
                                    <span class="caret float_r"></span>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <?php
                                    $lista_wokanda_etap_2 = $db->pobierz_wartosci_where('slownik_wokanda_etap_2', 'czy_usuniety = 0');

                                    while (	$poj_lista_wokanda_etap_2 = $lista_wokanda_etap_2->fetch_object()) {
                                        echo '<li id="wokanda_etap_2_'.$poj_lista_wokanda_etap_2->id.'" class="wokanda_etap_2_opcja element_grupa_opcja  dropdown-menu_opcja cursor_p " data-wartosc="'.mb_ucfirst($poj_lista_wokanda_etap_2->wartosc).'" data-element_id="'.$poj_lista_wokanda_etap_2->id.'">';
                                        echo '<i class="fa fa-check" aria-hidden="true"></i>';
                                        echo mb_ucfirst($poj_lista_wokanda_etap_2->wartosc);
                                        echo '</li>';
                                    }

                                    ?>
                                </ul>
                            </div>
                        </div>
                        <div class="input_50p">
                            <div class="form-group">
                                <label for="wokanda_prowadzacy">Osoba z Wokand</label>
                                <div id="wokanda_prowadzacy" class="dropdown">
                                    <button  class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                        <span class="element_grupa_opcja_naglowek wokanda_prowadzacy float_l prm" data-kolumna="wokanda_prowadzacy" data-wartosc_domyslna="" value="">Prowadzący</span>
                                        <span class="caret float_r"></span>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                        <?php
                                        $prowadzacy = array();
                                        $uprawnieni = $db->pobierz_wartosci_where('uzytkownik_id_uzytkownik_uprawnienia_id', 'uzytkownik_uprawnienia_id = 33');
                                        while($poj_lista_uprawnionych = $uprawnieni->fetch_object()){
                                            $lista_wokanda_prowadzacy = $db->pobierz_wartosci_where('uzytkownik', 'id = '.$poj_lista_uprawnionych->uzytkownik_id);
                                            array_push($prowadzacy, $lista_wokanda_prowadzacy->fetch_object());
                                        }

                                        for( $i = 0; $i<count($prowadzacy); $i++){
                                            echo '<li id="wokanda_prowadzacy_'.$prowadzacy[$i]->id.'" class="wokanda_prowadzacy_opcja element_grupa_opcja  dropdown-menu_opcja cursor_p " data-wartosc="'.mb_ucfirst($prowadzacy[$i]->imie).' '.mb_ucfirst($prowadzacy[$i]->nazwisko).'" data-element_id="'.$prowadzacy[$i]->id.'">';
                                            echo '<i class="fa fa-check" aria-hidden="true"></i>';
                                            echo mb_ucfirst($prowadzacy[$i]->imie).' '.mb_ucfirst($prowadzacy[$i]->nazwisko);
                                            echo '</li>';
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="wokanda_etap">Etap Sprawy</label>
                            <div id="wokanda_etap" class="dropdown">
                                <button  class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <span class="element_grupa_opcja_naglowek wokanda_etap_sprawy_wybrany float_l prm" data-kolumna="slownik_wokanda_etap_sprawy_id" data-wartosc_domyslna="" value="">Wybierz etap</span>
                                    <span class="caret float_r"></span>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <?php
                                    $lista_wokanda_etap_sprawy = $db->pobierz_wartosci_where('slownik_wokanda_etap_sprawy', 'czy_usuniety = 0');

                                    while (	$poj_lista_wokanda_etap_sprawy = $lista_wokanda_etap_sprawy->fetch_object()) {
                                        echo '<li id="wokanda_etap_sprawy_'.$poj_lista_wokanda_etap_sprawy->id.'" class="wokanda_etap_sprawy_opcja element_grupa_opcja  dropdown-menu_opcja cursor_p " data-wartosc="'.mb_ucfirst($poj_lista_wokanda_etap_sprawy->wartosc).'" data-element_id="'.$poj_lista_wokanda_etap_sprawy->id.'">';
                                        echo '<i class="fa fa-check" aria-hidden="true"></i>';
                                        echo mb_ucfirst($poj_lista_wokanda_etap_sprawy->wartosc);
                                        echo '</li>';
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
					</div>
				</div>
			</div>
			
			<div class="panel panel-default aktywny wokanda_szczegoly_sad_dane">
                <i data-toggle="tooltip" data-placement="left" title="Dodaj sąd" class="padding_0 hover_none fa fa-plus dodajSadPopUp" aria-hidden="true"></i>
				<div id="slownik_sad_id" class="panel-heading cursor_p prm" data-kolumna="slownik_sad_id" value="">Sąd</div>
				<div class="panel-body dane_sadu" style="display: block;">
				
						<div class="input_50p">
							<div class="dropdown lista_typow_sadow">
							<button class="btn btn-default dropdown-toggle" disabled type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
							<span class="element_grupa_opcja_naglowek sad_typ " data-wartosc_domyslna="" value="" >Typ</span>
													<span class="caret"></span>
								</button>
								<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
							    	<?php
										$lista_typow = $db->pobierz_wiersze('slownik_sad_typ', 'czy_usuniety', '0');
										while ($poj_lista_typow = $lista_typow->fetch_object()) {
											echo '<li id="sad_typ_'.$poj_lista_typow->id.'" class="typ_grupa_opcja element_grupa_opcja  dropdown-menu_opcja cursor_p " data-wartosc="'.mb_ucfirst($poj_lista_typow->wartosc).'" data-element_id="'.$poj_lista_typow->id.'">';
												echo '<i class="fa fa-check" aria-hidden="true"></i>';
												echo mb_ucfirst($poj_lista_typow->wartosc);
											echo '</li>';
										}
									?>
						 		</ul>
							</div>
							<div class="form-group sad_nazwa_pole wyszukaj_like_pole">
								<input class="form-control pole_input_fokus sad_nazwa wyszukaj_like" data-szukaj_po="nazwa" data-tabela="slownik_sad" placeholder="Nazwa" type="text" data-wartosc_domyslna ="" value="" >
								<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
							</div>
							<div class="form-group sad_ulica_pole">
								<input class="form-control pole_input_fokus sad_ulica" disabled placeholder="Ulica" type="text" data-wartosc_domyslna ="" value="" >
								<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
							</div>
							<div class="form-group">
								<input class="form-control pole_input_fokus sad_miasto" disabled placeholder="Miasto" type="text" data-miasto_id="" data-wartosc_domyslna ="" value="" >
								<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>					
							</div>				
							<div class="form-group sad_kod_pocztowy_pole">
								<input class="form-control pole_input_fokus sad_kod_pocztowy" disabled placeholder="Kod pocztowy" type="text" data-wartosc_domyslna ="" value="" >
								<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
							</div>
							<div class="dropdown lista_wojewodztw">
									<button class="btn btn-default dropdown-toggle" disabled type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
								    	<span class="element_grupa_opcja_naglowek nazwa_woj sad_wojewodztwo " data-wartosc_domyslna="" value="" >Wybierz wojewodztwo</span>
										<span class="caret"></span>
									</button>
									<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
								    	<?php 					
											$lista_wojewodztw = $db->pobierz_wiersze('slownik_wojewodztwo', 'czy_usuniety', '0');
											while ($poj_lista_wojewodztw = $lista_wojewodztw->fetch_object()) {
												echo '<li id="wojewodztwo_'.$poj_lista_wojewodztw->id.'" class="woj_grupa_opcja element_grupa_opcja  dropdown-menu_opcja cursor_p " data-wartosc="'.mb_ucfirst($poj_lista_wojewodztw->nazwa).'" data-element_id="'.$poj_lista_wojewodztw->id.'">';
													echo '<i class="fa fa-check" aria-hidden="true"></i>';
													echo mb_ucfirst($poj_lista_wojewodztw->nazwa);
												echo '</li>';
											}
										?>
							 		</ul>
								</div>
								<div class="clear_b"></div>
								<div class="well well-sm margin_t_10">
									<div class="form-group ">
										<input class="form-control pole_input_fokus wokanda_sala prm" data-kolumna="sala" placeholder="Sala" type="text" data-wartosc_domyslna ="" value="" >
										<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
									</div>
									<div class="form-group ">
										<input class="form-control pole_input_fokus wokanda_sygnatura prm" data-kolumna="sygnatura_akt" placeholder="Sygnatura Akt" type="text" data-wartosc_domyslna ="" value="" >
										<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
									</div>
									<div class="clear_b"></div>
								</div>
						</div>
				
				</div>
			</div>	            
			   
			<div class="panel panel-default ukryj">
				<div class="panel-heading cursor_p wokanda_sprawa_id_glowna" data-element_id="">Dane ogólne</div>
				<div class="panel-body" >
					<i data-toggle="modal" data-target="#myModal" class="float_r fa fa-search wyszukaj_klienta" data-akcja="sprawa_glowna" aria-hidden="true"></i>
					<div class="ukryte_pola">
						<input type="text" disabled class="form-control sprawa_pce_id_pce prm" data-kolumna="sprawa_pce_id" value="">
					</div>
						<div class="input_zwykly">
							<div class="form-group col-md-4">
								<input type="text"  class="form-control klient_imie prm" data-kolumna="klient_imie" value="" placeholder="Imię">
							</div>
							<div class="form-group col-md-5">
								<input type="text"  class="form-control klient_nazwisko prm" data-kolumna="klient_nazwisko" value="" placeholder="Nazwisko">
							</div>
							<div class="form-group col-md-3">
								<input type="text"  class="form-control klient_nr_sprawy prm" data-kolumna="sprawa_pce_numer" value="" placeholder="Numer sprawy">
							</div>
							<div class="clear_b"></div>			
						</div>
					
					<div class="well well-sm margin_t_10">
						<div class="input_zwykly">
							<div class="form-group col-md-4">
								<input type="text" class="form-control prawnik_prowadzacy_sprawe prm" data-kolumna="sprawa_prawnik" value="" placeholder="Prawnik prowadzący">
							</div>
							<div class="form-group col-md-4">
								<input type="text" class="form-control druga_strona prm" value="" data-kolumna="sprawa_druga_strona" placeholder="Druga strona">
							</div>
							<div class="form-group col-md-4">
								<input type="text" class="form-control pełnomocnik_glowny prm" value="" data-kolumna="sprawa_pelnomocnik_glowny" placeholder="Pełnomocnik główny">
							</div>
							<div class="clear_b"></div>
						</div>
						<div class="input_zwykly">
							<div class="form-group col-md-5">
								<input type="text" class="form-control pelnomocnik_substytucyjny_kairp prm" data-kolumna="sprawa_pelnomocnik_kairp" value="" placeholder="Pełnomocnik substytucyjny z KAIRP">
							</div>
							<div class="form-group col-md-3">
								<input type="text" class="form-control wps prm" data-kolumna="sprawa_wps" value="" placeholder="Wps">
							</div>
							<div class="form-group col-md-4">
								<div class="float_r dropdown lista_typow_umow_klienta width_100">
									<button class="width_100 btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
								    	<span class="element_grupa_opcja_naglowek float_l prm" data-kolumna="slownik_wokanda_typ_umowy_id" data-wartosc_domyslna="" value="" >Typ umowy</span>
										<span class="caret float_r"></span>
									</button>
									<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
								    	<?php 					
											$lista_klient_typ_umowy = $db->pobierz_wiersze('slownik_wokanda_typ_umowy', 'czy_usuniety', '0');
											if(!is_null($lista_klient_typ_umowy)){
												while ($poj_lista_klient_typ_umowy = $lista_klient_typ_umowy->fetch_object()) {
													echo '<li class="typ_umowy_grupa_opcja element_grupa_opcja  dropdown-menu_opcja cursor_p '.( (false) ? 'aktywna' : '' ).'" data-wartosc="'.mb_ucfirst($poj_lista_klient_typ_umowy->wartosc).'" data-element_id="'.$poj_lista_klient_typ_umowy->id.'">';
													echo '<i class="fa fa-check" aria-hidden="true"></i>';
													echo mb_ucfirst($poj_lista_klient_typ_umowy->wartosc);
													echo '</li>';
												}
											}					
										?>
							 		</ul>
								</div>
							</div>								
							<div class="clear_b"></div>
						</div>
						<div class="input_zwykly">
									<div class="form-group col-md-4 float_l">
										<span class="margin_t_10 float_l">Klient zwolniony z opłat: </span>
										<?php 
										$slownik_wokanda_klient_koszty_id = $wokanda->slownik_wokanda_klient_koszty_id;
										$wokanda_klient_koszty = $db->pobierz_wiersz('slownik_wokanda_klient_koszty', 'id', $slownik_wokanda_klient_koszty_id);
										$wokanda_klient_koszty_wartosc = $wokanda_klient_koszty->wartosc;
										
										if($zablokowany === 'disabled'){
											echo '<input type="text" disabled class=" form-control" value="'.$wokanda_klient_koszty_wartosc.'">';
										}else{ ?>
											<div class=" dropdown lista_wokanda_klient_koszty float_l ">
												<button class="width_100 btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
											    	<span class="element_grupa_opcja_naglowek float_l prm" data-kolumna="slownik_wokanda_klient_koszty_id" data-wartosc_domyslna="<?php echo $slownik_wokanda_klient_koszty_id; ?>" value="<?php echo $slownik_wokanda_klient_koszty_id; ?>" ><?php echo mb_ucfirst($wokanda_klient_koszty_wartosc); ?></span>
													<span class="caret float_r"></span>
												</button>
												<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
											    	<?php 					
														$lista_wokanda_klient_koszty = $db->pobierz_wiersze('slownik_wokanda_klient_koszty', 'czy_usuniety', '0');
														if(!is_null($lista_wokanda_klient_koszty)){
															while ($poj_lista_wokanda_klient_koszty = $lista_wokanda_klient_koszty->fetch_object()) {
																echo '<li class="typ_umowy_grupa_opcja element_grupa_opcja  dropdown-menu_opcja cursor_p '.( ($slownik_wokanda_klient_koszty_id == $poj_lista_wokanda_klient_koszty->id) ? 'aktywna' : '' ).'" data-wartosc="'.mb_ucfirst($poj_lista_wokanda_klient_koszty->wartosc).'" data-element_id="'.$poj_lista_wokanda_klient_koszty->id.'">';
																echo '<i class="fa fa-check" aria-hidden="true"></i>';
																echo mb_ucfirst($poj_lista_wokanda_klient_koszty->wartosc);
																echo '</li>';
															}
														}					
													?>
										 		</ul>
											</div>
										<?php } ?>
										<div class="clear_b"></div>
									</div>
									<div class="form-group margin_b_0  float_l">
										<span>Zgoda na substytuta <i  class="sprawa_zgoda_na_substytuta <?php echo (false) ? 'zaznaczony' : '' ; ?> ikona_zaznacz fa fa-square-o" aria-hidden="true"></i></span>
									</div>										
									<div class="clear_b"></div>
								</div>
						
					</div>
					
				</div>
			</div>
			
			<div class="panel panel-default ukryj">
				<div class="panel-heading cursor_p dane_substytuta"  data-element_id="">Dane Substytuta</div>
				<div class="panel-body" >
				<div class="well well-sm">
					<div class="input_zwykly">
						
							<div><span>Substytut z VOTUM <i  class="czy_votum_s ikona_niezaznacz fa fa-square-o" aria-hidden="true"></i></span></div>
						
					</div>
					<div class="input_zwykly">
						<div class="form-group col-md-4 wyszukaj_like_pole">
							<input type="text" class="form-control nazwisko_susbstytuta wyszukaj_like" data-szukaj_po="nazwa" data-tabela="substytut" value="" placeholder="Nazwisko substytuta">
						</div>
						<div class="form-group col-md-4">
							<input type="text" class="form-control imie_susbstytuta" disabled value="" placeholder="Imię substytuta">
						</div>
						<div class="form-group col-md-4">
							<input type="text" class="form-control substytut_uprawnienia" disabled value="" placeholder="Uprawnienia">
						</div>
						<div class="clear_b"></div>
					</div>
					<div class="input_zwykly">
						<div class="form-group col-md-4">
							<input type="text" class="form-control substytut_ulica" disabled value="" placeholder="Ulica">
						</div>
						<div class="form-group col-md-4">
							<input type="text" class="form-control substytut_miasto" disabled value="" placeholder="Miasto">
						</div>
						<div class="form-group col-md-4">
							<input type="text" class="form-control substytut_wojewodztwo" disabled value="" placeholder="Wojewodztwo">
						</div>
						<div class="clear_b"></div>
					</div>
					<div class="input_zwykly">
						<div class="form-group col-md-4">
							<div><span>Wysłano dokumenty <i  class="ikona_zaznacz fa fa-square-o wyslano_dokumenty" aria-hidden="true"></i></span></div>
							<div><span>Otrzymano notatkę <i  class="ikona_zaznacz fa fa-square-o otrzymano_notatke" aria-hidden="true"></i></span></div>
							<div><span>Potwierdzony substytut <i  class="ikona_zaznacz fa fa-square-o potwierdzony_substytut" aria-hidden="true"></i></span></div>
							<div><span>Usługa wykonana <i  class="ikona_zaznacz fa fa-square-o usluga_wykonana" aria-hidden="true"></i></span></div>
						
						</div>
						<div class="form-group col-md-4 koszt_substytuta_pola">
							<input type="text" class="form-control koszt_substytuta prm" data-kolumna="substytut_kwota" value="" placeholder="Kwota">
							<input type="text" disabled class="form-control koszt_substytuta_opis " data-kolumna="" value="NETTO">
							
						</div>
						<div class="form-group col-md-4">
							<div class="float_r dropdown forma_platnosci_substytut width_100">
									<button class="width_100 btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
								    	<span class="forma_platnosci_substytut_nazwa element_grupa_opcja_naglowek float_l prm" data-kolumna="slownik_substytut_forma_platnosci_id" data-wartosc_domyslna="" value="" >Forma płatności</span>
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
					</div>
					<div class="substytut_dodatkowe_opcje width_100">
						<div class="well float_l well-sm margin_t_10">
							<div class="input_zwykly">
								<div>Email: <span class="emai_substytut"></span></div>
								<div>Email prywatny: <span class="emai2_substytut"></span></div>
								<div>Telefon: <span class="telefon_substytut"></span></div>
								<div class="clear_b"></div>
							</div>
						</div>
						
						<div class="well substytut_faktury float_l well-sm margin_t_10">
							<div class="input_zwykly">
								<div class="form-group col-md-4">
							
									<div><span>Faktura wpłyneła <i  class=" ikona_zaznacz fa fa-square-o faktura_wplynela" aria-hidden="true"></i></span></div>
									<div><span>Faktura opłacona <i  class=" ikona_zaznacz fa fa-square-o faktura_oplacona" aria-hidden="true"></i></span></div>
									<div><span>Koszt ponosi VOTUM <i  class=" ikona_zaznacz fa fa-square-o koszt_ponosi_votum" aria-hidden="true"></i></span></div>
								
								</div>
								<div class="form-group col-md-8">
									<input type="text" class="form-control faktura_numer_substytuta prm" data-kolumna="faktura_numer" value="" placeholder="Numer faktury">
								</div>
								<div class="clear_b"></div>
							</div>																				
						</div>
						
						<div class="well substytut_faktury float_l well-sm margin_t_10">
							<div class="input_zwykly">
								<div class="form-group col-md-12">
									<textarea class="dodatkowe_dane_do_fv form-control prm" data-kolumna="dodatkowe_dane_do_fv" placeholder="Dodatkowe dane do FV..."></textarea>
								</div>
								<div class="clear_b"></div>
							</div>
						</div>

                        <div class="well float_l well-sm margin_t_10 width_100">
                            <div class="input_zwykly">
                                <div class="form-group col-md-12">
                                    <textarea class=" form-control prm" data-kolumna="substytut_komentarz" value="" placeholder="Treść komantarza..."></textarea>
                                </div>
                                <div class="clear_b"></div>
                            </div>
                        </div>
						
						<div class="clear_b"></div>
					</div>
						
					<div class="well float_l well-sm width_100 margin_t_10">
						<div>Pomocnik substytuta</div>
						<div class="input_50p">
							<div class="form-group col-md-4">
								<input type="text"  class="form-control pomocnik_imie_nazwisko prm" data-kolumna="substytut_pomocnik" value="" placeholder="Pomocnik imię i nazwisko">
							</div>
							<div class="form-group col-md-5">
								<input type="text"  class="form-control pomocnik_email prm" data-kolumna="substytut_pomocnik_mail" value="" placeholder="Pomocnik adres email">
							</div>
							<div class="clear_b"></div>			
						</div>
					</div>	
					
			
					
				</div>
			</div>
			<div class="clear_b margin_t_10"></div>
			<?php if(in_array(9, $uzytkownik->__get('_lista_przyznanych_zakladek'))){ ?>
				<button type="button" data-parent_class="widok_dodaj_wokande" class=" btn btn-default przycisk_zapisz_zmiany wokanda_zapisz btn-block text-uppercase wokanda_dodaj_nowa ">Dodaj</button>
			<?php } ?>
</div>
</div>