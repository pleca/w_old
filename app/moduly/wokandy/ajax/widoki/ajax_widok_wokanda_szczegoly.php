<?php
	require_once($_SERVER ['DOCUMENT_ROOT'].'czy_zalogowany.php');
		
	$tab = (isset($_POST['tab'])) ? htmlspecialchars($_POST['tab']) : 'szczegoly_wokanda' ;
	$id = (isset($_POST['id'])) ? htmlspecialchars($_POST['id']) : '' ;
	
						
	//$wokanda = $db->pobierz_wiersz('wokanda', 'id', $id);

    $wokanda = $db->wywolaj_procedure('wokanda_pobierz_wokande', array('id' => $id));
    $wokanda = $wokanda->fetch_object();
	$naglowek_napis = '<span>szczegóły wokandy('.$id.')</span>';
	$miasto = $db->pobierz_wiersz('slownik_miasto', 'id', $wokanda->slownik_miasto_id);
	$aktualny_etap = $db->pobierz_wiersz('slownik_wokanda_etap', 'id', $wokanda->etap_id);
    $aktualny_etap_2 = $db->pobierz_wiersz('slownik_wokanda_etap_2', 'id', $wokanda->etap_2_id);
    $aktualny_etap_sprawy = $db->pobierz_wiersz('slownik_wokanda_etap_sprawy', 'id', $wokanda->etap_sprawy_id);
	$aktualny_rodzaj = $db->pobierz_wiersz('slownik_wokanda_rodzaj', 'id', $wokanda->rodzaj_id);
	$aktualny_prowadzacy = $db->pobierz_wiersz('wokanda_id_uzytkownik_id', 'wokanda_id', $wokanda->id);
	$aktualny_prowadzacy = $db->pobierz_wiersz('uzytkownik', 'id', $aktualny_prowadzacy->uzytkownik_id);

	$sprawa = $db->pobierz_wiersz('wokanda_sprawa', 'id', $wokanda->wokanda_sprawa_id_glowna);
	$sprawa_pce_numer = '';
	$sprawa_pce_id = '';
	$klient_imie = '';
	$klient_nazwisko = '';
	$sprawa_prawnik = '';
	$sprawa_druga_strona = '';
	$sprawa_pelnomocnik_glowny = '';
	$sprawa_pelnomocnik_kairp = '';
	$sprawa_wps = '';
	$sprawa_wpz = '';
	$slownik_wokanda_typ_umowy_id = '';
	$sprawa_zgoda_na_substytuta = '0';
	
	if(!is_null($sprawa)){
		$sprawa_pce_numer = $sprawa->sprawa_pce_numer;
		$sprawa_pce_id = $sprawa->sprawa_pce_id;
		$klient_imie = $sprawa->klient_imie;
		$klient_nazwisko = $sprawa->klient_nazwisko;
		$sprawa_prawnik = $sprawa->sprawa_prawnik;
		$sprawa_druga_strona = $sprawa->sprawa_druga_strona;
		$sprawa_pelnomocnik_glowny = $sprawa->sprawa_pelnomocnik_glowny;
		$sprawa_pelnomocnik_kairp = $sprawa->sprawa_pelnomocnik_kairp;
		$sprawa_wps = $sprawa->sprawa_wps;
		$sprawa_wpz = $sprawa->sprawa_wpz;
		$slownik_wokanda_typ_umowy_id = $sprawa->slownik_wokanda_typ_umowy_id;
		$sprawa_zgoda_na_substytuta = $sprawa->sprawa_zgoda_na_substytuta;
	}
	
	$zablokowany = 'disabled';
	
	if(in_array(21, $uzytkownik->__get('_lista_przyznanych_uprawnien'))){
		$zablokowany = '';
	}
?>
<div class="widok_edycja_wokandy">
	<div class="element_szczegoly" data-element_id="<?php echo $id; ?>" data-widok="<?php echo $tab; ?>">
        <div class="text-uppercase">
            <div class="wokanda_duplikuj_wokande_przycisk" aria-hidden="true" title="<center>Skopiować wokandę?</center>" data-placement="left" data-toggle="popover" data-content="<button type='button' class='width_100 wokanda_duplikuj btn btn-danger'>TAK</button>">Kopiuj</div>
            <div class="clear_b"></div>
        </div>
        <div class="text-uppercase">
			<?php 
				echo $naglowek_napis;
				if($tab === 'aktywni' || $tab ==='filtruj'){
					if(in_array(20, $uzytkownik->__get('_lista_przyznanych_uprawnien'))){
						echo '<i class="fa fa-trash wokanda_usun_przycisk" aria-hidden="true" title="Czy jesteś pewnien?" data-placement="left" data-toggle="popover" data-content="<button type=\'button\' class=\'width_100 wokanda_usun btn btn-danger\'>TAK</button>"></i>';						
					}
				}
				if($tab === 'usunieci'){
					if(in_array(22, $uzytkownik->__get('_lista_przyznanych_uprawnien'))){
						echo '<i class="fa fa-undo wokanda_przywroc_przycisk" aria-hidden="true" title="Czy jesteś pewnien?" data-placement="left" data-toggle="popover" data-content="<button type=\'button\' class=\'width_100 wokanda_przywroc btn btn-danger\'>TAK</button>"></i>';
					}
				}

			if(in_array(21, $uzytkownik->__get('_lista_przyznanych_uprawnien'))){
				if(in_array(31, $uzytkownik->__get('_lista_przyznanych_uprawnien'))){
				
					$uzytkownik_login_pce = $db->pobierz_wartosc('login_pce_id', 'uzytkownik', 'id', $uzytkownik->__get('_id'));
					if($uzytkownik_login_pce->login_pce_id != ''){
				?>		
						<div class="wokanda_wyslij_do_pce_przycisk" aria-hidden="true" title="<center>Jesteś pewien, że chcesz<br/>wysłać dane do PCE?</center>" data-placement="left" data-toggle="popover" data-content="<button type='button' class='width_100 wokanda_wyslij_do_pce btn btn-danger'>TAK</button>">Wyślij dane do PCE</div>
			
			<?php 		}
					} 
				}
			?>
			<div class="clear_b"></div>
		</div>
	</div>
	<ul class="nav nav-tabs" role="tablist">
			<li role="presentation" class="active"><a href="#ogolne" aria-controls="ogolne" role="tab" data-toggle="tab">Ogólne</a></li>
			<?php if(in_array(18, $uzytkownik->__get('_lista_przyznanych_uprawnien'))){ ?>
				<li role="presentation"><a href="#historia" aria-controls="historia" role="tab" data-toggle="tab">Historia</a></li>
			<?php } ?>
	</ul>
	<div class="tab-content wokanda_szczegoly ">
		<div role="tabpanel" class="tab-pane active" id="ogolne"> 
			<div class="panel panel-default margin_b_10">
				<div class="panel-heading aktywny cursor_p">Termin</div>
				<div class="panel-body" style="display:block">
				<?php 
					$data_poczatek = explode(' ',$wokanda->start);
					$czas_poczatek = explode(':', $data_poczatek[1]);

					$data_koniec = explode(' ',$wokanda->stop);
					$czas_koniec = explode(':', $data_koniec[1]);
				?>
					<div class="well well-sm">
						<div class="input_25p">
							<div class="form-group">
								<label for="data_start">Data początek</label>
								<input id="data_start" type="text" <?php echo $zablokowany; ?> class="wymagane form-control data start" data-kolumna="start" data-wartosc_domyslna="<?php echo $data_poczatek[0]; ?>" value="<?php echo $data_poczatek[0]; ?>" placeholder="Data początku rozprawy">
							</div>
							<div class="form-group">
								<label for="data_start_godzina">&nbsp;</label>
								<input id="data_start_godzina" type="text" <?php echo $zablokowany; ?> class="wymagane form-control" data-wartosc_domyslna="<?php echo $czas_poczatek[0].':'.$czas_poczatek[1]; ?>" value="<?php echo $czas_poczatek[0].':'.$czas_poczatek[1]; ?>" placeholder="Godzina początku rozprawy">
							</div>
							<div class="form-group">
								<label for="data_stop">Data koniec</label>
								<input id="data_stop" type="text" <?php echo $zablokowany; ?> class="wymagane form-control data stop" data-kolumna="stop" data-wartosc_domyslna="<?php echo $data_koniec[0]; ?>" value="<?php echo $data_koniec[0]; ?>" placeholder="Data końca rozprawy">
							</div>
							<div class="form-group">
								<label for="data_stop_godzina">&nbsp;</label>
								<input id="data_stop_godzina" type="text" <?php echo $zablokowany; ?> class="wymagane form-control" data-wartosc_domyslna="<?php echo $czas_koniec[0].':'.$czas_koniec[1]; ?>" value="<?php echo $czas_koniec[0].':'.$czas_koniec[1]; ?>" placeholder="Data końca rozprawy">
							</div>
							<div class="clear_b"></div>
							<div class="form-group margin_b_0 margin_t_0 potwierdzony_termin_pole">
								<div><span>Potwierdzona godzina <i  class="potwierdzony_termin <?php echo ($wokanda->potwierdzony_termin == 1) ? 'zaznaczony' : '' ; ?>  <?php echo ($zablokowany === 'disabled') ? 'ikona_nie_zaznacz' : 'ikona_zaznacz' ; ?> fa float_r fa<?php echo ($wokanda->potwierdzony_termin == 1) ? '-check' : '' ; ?>-square-o" aria-hidden="true"></i></span></div>
							</div>
							<div class="clear_b"></div>
						</div>
					</div>
                    <div class="input_50p">
<!--                        <div class="form-group">-->
<!--                            <label for="wokanda_nazwa">Nazwa</label>-->
<!--                            <input id="wokanda_nazwa" type="text" class="wymagane form-control wokanda_nazwa prm" data-kolumna="nazwa" value="--><?php //echo $wokanda->nazwa; ?><!--" placeholder="Nazwa wokandy">-->
<!--                        </div>-->
                    </div>
                    <div class="input_50p">
                        <div class="form-group">
                            <label for="wokanda_nazwa">Nazwa</label>

                            <div id="wokanda_nazwa_miasto" class="dropdown">
                                <div class="form-group miasto_nazwa_pole wyszukaj_like_pole">
                                    <input class="form-control pole_input_fokus miasto_nazwa wyszukaj_like prm" data-kolumna="slownik_miasto_id" data-szukaj_po="nazwa" data-tabela="slownik_miasto" placeholder="Nazwa" type="text" data-wartosc_domyslna ="<?php echo $miasto->nazwa; ?>" data-miasto-id="<?php echo $miasto->id ?>" value="<?php echo $miasto->nazwa; ?>" >
                                    <span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="input_50p">
						<div class="form-group">
							<label for="wokanda_etap">Etap I</label>
							<?php if($zablokowany === 'disabled'){
								echo '<input id="wokanda_etap" type="text" disabled class="form-control" value="'.$aktualny_etap->wartosc.'">';
							}else{ ?>			
								<div id="wokanda_etap" class="dropdown">															
									<button  class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
										<span class="element_grupa_opcja_naglowek wokanda_etap_wybrany float_l prm" data-kolumna="slownik_wokanda_etap_id" data-wartosc_domyslna="<?php echo $aktualny_etap->wartosc; ?>" value="<?php echo $aktualny_etap->id; ?>"><?php echo $aktualny_etap->wartosc; ?></span>
										<span class="caret float_r"></span>
									</button>
									<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
										<?php 
											$lista_wokanda_etap = $db->pobierz_wartosci_where('slownik_wokanda_etap', 'czy_usuniety = 0');
											
											while (	$poj_lista_wokanda_etap = $lista_wokanda_etap->fetch_object()) {
												echo '<li id="wokanda_etap_'.$poj_lista_wokanda_etap->id.'" class="wokanda_etap_opcja element_grupa_opcja  dropdown-menu_opcja cursor_p '.( ($poj_lista_wokanda_etap->id === $wokanda->etap_id) ? 'aktywna' : '' ).'" data-wartosc="'.mb_ucfirst($poj_lista_wokanda_etap->wartosc).'" data-element_id="'.$poj_lista_wokanda_etap->id.'">';
													echo '<i class="fa fa-check" aria-hidden="true"></i>';
													echo mb_ucfirst($poj_lista_wokanda_etap->wartosc);
												echo '</li>';
											}
											
										?>
									</ul>
								</div>
							<?php } ?>
						</div>
						<div class="form-group">
							<label for="wokanda_rodzaj">Rodzaj</label>
							<?php if($zablokowany === 'disabled'){
								echo '<input id="wokanda_rodzaj" type="text" disabled class="form-control" value="'.$aktualny_rodzaj->wartosc.'">';
							}else{ ?>
								<div id="wokanda_rodzaj" class="dropdown">															
									<button  class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
										<span class="element_grupa_opcja_naglowek wokanda_rodzaj_wybrany float_l prm" data-kolumna="slownik_wokanda_rodzaj_id" data-wartosc_domyslna="<?php echo $aktualny_rodzaj->wartosc; ?>" value="<?php echo $aktualny_rodzaj->id; ?>"><?php echo $aktualny_rodzaj->wartosc; ?></span>
										<span class="caret float_r"></span>
									</button>
									<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
										<?php 
											$lista_wokanda_rodzaj = $db->pobierz_wartosci_where('slownik_wokanda_rodzaj', 'czy_usuniety = 0');
											
											while (	$poj_lista_wokanda_rodzaj = $lista_wokanda_rodzaj->fetch_object()) {
												echo '<li id="wokanda_rodzaj_'.$poj_lista_wokanda_rodzaj->id.'" class="wokanda_rodzaj_opcja element_grupa_opcja  dropdown-menu_opcja cursor_p '.( ($poj_lista_wokanda_rodzaj->id === $wokanda->rodzaj_id) ? 'aktywna' : '' ).'" data-wartosc="'.mb_ucfirst($poj_lista_wokanda_rodzaj->wartosc).'" data-element_id="'.$poj_lista_wokanda_rodzaj->id.'">';
													echo '<i class="fa fa-check" aria-hidden="true"></i>';
													echo mb_ucfirst($poj_lista_wokanda_rodzaj->wartosc);
												echo '</li>';
											}
											
										?>
									</ul>
								</div>
							<?php } ?>
						</div>
                        <div class="form-group">
                            <label for="wokanda_etap">Etap II</label>
                            <?php if($zablokowany === 'disabled'){
                                echo '<input id="wokanda_etap" type="text" disabled class="form-control" value="'.$aktualny_etap_2->wartosc.'">';
                            }else{ ?>
                                <div id="wokanda_etap" class="dropdown">
                                    <button  class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                        <span class="element_grupa_opcja_naglowek wokanda_etap_2_wybrany float_l prm" data-kolumna="slownik_wokanda_etap_2_id" data-wartosc_domyslna="<?php echo $aktualny_etap_2->wartosc; ?>" value="<?php echo $aktualny_etap_2->id; ?>"><?php echo $aktualny_etap_2->wartosc; ?></span>
                                        <span class="caret float_r"></span>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                        <?php
                                        $lista_wokanda_etap_2 = $db->pobierz_wartosci_where('slownik_wokanda_etap_2', 'czy_usuniety = 0');

                                        while (	$poj_lista_wokanda_etap_2 = $lista_wokanda_etap_2->fetch_object()) {
                                            echo '<li id="wokanda_etap_'.$poj_lista_wokanda_etap_2->id.'" class="wokanda_etap_2_opcja element_grupa_opcja  dropdown-menu_opcja cursor_p '.( ($poj_lista_wokanda_etap_2->id === $wokanda->etap_2_id) ? 'aktywna' : '' ).'" data-wartosc="'.mb_ucfirst($poj_lista_wokanda_etap_2->wartosc).'" data-element_id="'.$poj_lista_wokanda_etap_2->id.'">';
                                            echo '<i class="fa fa-check" aria-hidden="true"></i>';
                                            echo mb_ucfirst($poj_lista_wokanda_etap_2->wartosc);
                                            echo '</li>';
                                        }

                                        ?>
                                    </ul>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="input_50p">
                            <div class="form-group">
                                <label for="wokanda_prowadzacy">Osoba z Wokand</label>
                                <?php if($zablokowany === 'disabled'){
                                    echo '<input id="wokanda_prowadzacy" type="text" disabled class="form-control" value="'.$aktualny_prowadzacy->imie .' '. $aktualny_prowadzacy->nazwisko.'">';
                                }else{ ?>
                                <div id="wokanda_prowadzacy" class="dropdown">
                                    <button  class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                        <span class="element_grupa_opcja_naglowek wokanda_prowadzacy-wybrany float_l prm" data-kolumna="wokanda_prowadzacy" data-wartosc_domyslna="<?php echo $aktualny_prowadzacy->imie .' '. $aktualny_prowadzacy->nazwisko ?>" value="<?php echo $aktualny_prowadzacy->id; ?>"><?php echo $aktualny_prowadzacy->imie .' '. $aktualny_prowadzacy->nazwisko ?></span>
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
                                <?php } ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="wokanda_etap">Etap sprawy</label>
                            <?php if($zablokowany === 'disabled'){
                                echo '<input id="wokanda_etap" type="text" disabled class="form-control" value="'.$aktualny_etap_2->wartosc.'">';
                            }else{ ?>
                                <div id="wokanda_etap" class="dropdown">
                                    <button  class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                        <span class="element_grupa_opcja_naglowek wokanda_etap_2_wybrany float_l prm" data-kolumna="slownik_wokanda_etap_sprawy_id" data-wartosc_domyslna="<?php echo $aktualny_etap_sprawy->wartosc; ?>" value="<?php echo $aktualny_etap_sprawy->id; ?>"><?php echo $aktualny_etap_sprawy->wartosc; ?></span>
                                        <span class="caret float_r"></span>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                        <?php
                                        $lista_wokanda_etap_sprawy = $db->pobierz_wartosci_where('slownik_wokanda_etap_sprawy', 'czy_usuniety = 0');

                                        while (	$poj_lista_wokanda_etap_sprawy = $lista_wokanda_etap_sprawy->fetch_object()) {
                                            echo '<li id="wokanda_etap_'.$poj_lista_wokanda_etap_sprawy->id.'" class="wokanda_etap_sprawy_opcja element_grupa_opcja  dropdown-menu_opcja cursor_p '.( ($poj_lista_wokanda_etap_sprawy->id === $aktualny_etap_sprawy->id) ? 'aktywna' : '' ).'" data-wartosc="'.mb_ucfirst($poj_lista_wokanda_etap_sprawy->wartosc).'" data-element_id="'.$poj_lista_wokanda_etap_sprawy->id.'">';
                                            echo '<i class="fa fa-check" aria-hidden="true"></i>';
                                            echo mb_ucfirst($poj_lista_wokanda_etap_sprawy->wartosc);
                                            echo '</li>';
                                        }
                                        ?>
                                    </ul>
                                </div>
                            <?php } ?>
                        </div>
					</div>
				</div>
			</div>
			
			<div class="panel panel-default wokanda_szczegoly_sad_dane">
                <i data-toggle="tooltip" data-placement="left" title="Dodaj sąd" class="fa fa-plus dodajSadPopUp" aria-hidden="true"></i>
				<div id="slownik_sad_id" class="panel-heading cursor_p prm" data-kolumna="slownik_sad_id" value="<?php echo $wokanda->slownik_sad_id; ?>">Sąd</div>
				<div class="panel-body" >
					
					<?php 
						$id_sad = $wokanda->slownik_sad_id;
						$sad = $db->pobierz_wiersz('slownik_sad', 'id', $id_sad);
						$sad_miasto = $db->pobierz_wiersz('slownik_miasto', 'id', $sad->miasto_id);
						$aktualne_woj = $db->pobierz_wartosc('nazwa', 'slownik_wojewodztwo', 'id', $sad_miasto->wojewodztwo_id);
						$sad_typ = $db->pobierz_wiersz('slownik_sad_typ', 'id', $sad->slownik_sad_typ_id);
						?><div class="input_50p">
							<?php if($zablokowany === 'disabled'){
									echo '<input type="text" disabled class="lista_typow_sadow form-control" value="'.$sad_typ->wartosc.'">';
								}else{ ?>
									<div class="dropdown lista_typow_sadow">
										<button class="btn btn-default dropdown-toggle" disabled type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
											<span class="element_grupa_opcja_naglowek sad_typ " data-wartosc_domyslna="<?php echo $sad_typ->id; ?>" value="<?php echo $sad_typ->id; ?>" ><?php echo mb_ucfirst($sad_typ->wartosc); ?></span>
											<span class="caret"></span>
										</button>
										<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
									    	<?php 					
												$lista_typow = $db->pobierz_wiersze('slownik_sad_typ', 'czy_usuniety', '0');
												while ($poj_lista_typow = $lista_typow->fetch_object()) {
													echo '<li id="sad_typ_'.$poj_lista_typow->id.'" class="typ_grupa_opcja element_grupa_opcja  dropdown-menu_opcja cursor_p '.( ($poj_lista_typow->id === $sad->slownik_sad_typ_id) ? 'aktywna' : '' ).'" data-wartosc="'.mb_ucfirst($poj_lista_typow->wartosc).'" data-element_id="'.$poj_lista_typow->id.'">';
														echo '<i class="fa fa-check" aria-hidden="true"></i>';
														echo mb_ucfirst($poj_lista_typow->wartosc);
													echo '</li>';
												}
											?>
								 		</ul>
									</div>
							<?php } ?>
							<div class="form-group sad_nazwa_pole wyszukaj_like_pole">
								<input class="form-control pole_input_fokus sad_nazwa  wyszukaj_like" data-szukaj_po="nazwa" data-tabela="slownik_sad" placeholder="Nazwa" type="text" data-wartosc_domyslna ="<?php echo $sad->nazwa ?>" value="<?php echo $sad->nazwa ?>" >
								<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
							</div>
							<div class="form-group sad_ulica_pole">
								<input class="form-control pole_input_fokus sad_ulica" placeholder="Ulica" disabled type="text" data-wartosc_domyslna ="<?php echo $sad->ulica ?>" value="<?php echo $sad->ulica ?>" >
								<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
							</div>
							<div class="form-group">
								<input class="form-control pole_input_fokus sad_miasto" placeholder="Miasto" disabled type="text" data-miasto_id="<?php echo $sad->miasto_id ?>" data-wartosc_domyslna ="<?php echo $sad_miasto->nazwa; ?>" value="<?php echo $sad_miasto->nazwa; ?>" >
								<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>					
							</div>				
							<div class="form-group sad_kod_pocztowy_pole">
								<input class="form-control pole_input_fokus sad_kod_pocztowy" placeholder="Kod pocztowy" disabled type="text" data-wartosc_domyslna ="<?php echo $sad->kod_pocztowy; ?>" value="<?php echo $sad->kod_pocztowy; ?>" >
								<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
							</div>
							<?php if($zablokowany === 'disabled'){
									echo '<input type="text" disabled class="lista_wojewodztw form-control" value="'.mb_ucfirst($aktualne_woj->nazwa).'">';
								}else{ ?>
									<div class="dropdown lista_wojewodztw">
										<button class="btn btn-default dropdown-toggle" disabled type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
									    	<span class="element_grupa_opcja_naglowek nazwa_woj sad_wojewodztwo " data-wartosc_domyslna="<?php echo $sad_miasto->wojewodztwo_id; ?>" value="<?php echo $sad_miasto->wojewodztwo_id; ?>" ><?php echo mb_ucfirst($aktualne_woj->nazwa); ?></span>
											<span class="caret"></span>
										</button>
										<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
									    	<?php 					
												$lista_wojewodztw = $db->pobierz_wiersze('slownik_wojewodztwo', 'czy_usuniety', '0');
												while ($poj_lista_wojewodztw = $lista_wojewodztw->fetch_object()) {
													echo '<li id="wojewodztwo_'.$poj_lista_wojewodztw->id.'" class="woj_grupa_opcja element_grupa_opcja  dropdown-menu_opcja cursor_p '.( ($poj_lista_wojewodztw->id === $sad_miasto->wojewodztwo_id) ? 'aktywna' : '' ).'" data-wartosc="'.mb_ucfirst($poj_lista_wojewodztw->nazwa).'" data-element_id="'.$poj_lista_wojewodztw->id.'">';
														echo '<i class="fa fa-check" aria-hidden="true"></i>';
														echo mb_ucfirst($poj_lista_wojewodztw->nazwa);
													echo '</li>';
												}
											?>
								 		</ul>
									</div>
								<?php } ?>
								<div class="clear_b"></div>
								<div class="well well-sm margin_t_10">
									<div class="form-group ">
										<input class="form-control pole_input_fokus wokanda_sala prm" data-kolumna="sala" placeholder="Sala" <?php echo $zablokowany; ?> type="text" data-wartosc_domyslna ="<?php echo $wokanda->sala; ?>" value="<?php echo $wokanda->sala; ?>" >
										<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
									</div>
									<div class="form-group ">
										<input class="form-control pole_input_fokus wokanda_sygnatura prm" data-kolumna="sygnatura_akt" placeholder="Sygnatura Akt" <?php echo $zablokowany; ?> type="text" data-wartosc_domyslna ="<?php echo $wokanda->sygnatura_akt; ?>" value="<?php echo $wokanda->sygnatura_akt; ?>" >
										<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
									</div>
									<div class="clear_b"></div>
								</div>
						</div>
				
				</div>
			</div>	            
			   
			<div class="panel panel-default">
				<div class="panel-heading cursor_p wokanda_sprawa_id_glowna" data-element_id="<?php echo $wokanda->wokanda_sprawa_id_glowna; ?>">Dane ogólne</div>
				<div class="panel-body" >
				
				 <ul class="nav nav-tabs" role="tablist">
				    <li role="presentation" class="active"><a href="#sprawa_glowna_tab" aria-controls="sprawa_glowna_tab" role="tab" data-toggle="tab">Sprawa główna</a></li>
				 	<li role="presentation" class=""><a href="#sprawy_powiazane_tab" aria-controls="sprawy_powiazane_tab" role="tab" data-toggle="tab">Sprawy powiązane</a></li>
				 
				 </ul>
				
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane active" id="sprawa_glowna_tab">
						<!-- sprawa glowna -->
							<i class="float_r fa fa-search wyszukaj_klienta cursor_p" data-akcja="sprawa_glowna" aria-hidden="true"></i>
							<div class="ukryte_pola">
								<input type="text" disabled class="form-control sprawa_pce_id prm" data-kolumna="sprawa_pce_id" value="<?php echo $sprawa_pce_id; ?>">
							</div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <i class="float_r fa fa-refresh odswiez_sprawe_z_pce cursor_p" alt="odśwież" data-akcja="sprawa_glowna_odswiez" aria-hidden="true"></i>
                                </div>
                            </div>
								<div class="input_zwykly">
									<div class="form-group col-md-4">
										<input type="text" <?php echo $zablokowany; ?> class="form-control klient_imie prm" data-kolumna="klient_imie" value="<?php echo $klient_imie; ?>" placeholder="Imię">
									</div>
									<div class="form-group col-md-5">
										<input type="text" <?php echo $zablokowany; ?> class="form-control klient_nazwisko prm" data-kolumna="klient_nazwisko" value="<?php echo $klient_nazwisko; ?>" placeholder="Nazwisko">
									</div>
									<div class="form-group col-md-3">
										<input type="text" disabled class="form-control klient_nr_sprawy prm" data-kolumna="sprawa_pce_numer" value="<?php echo $sprawa_pce_numer; ?>" placeholder="Numer sprawy">
									</div>
									<div class="clear_b"></div>			
								</div>
							
							<div class="well well-sm margin_t_10">
								<div class="input_zwykly">
									<div class="form-group col-md-4">
										<input type="text" <?php echo $zablokowany; ?> class="form-control prawnik_prowadzacy_sprawe prm" data-kolumna="sprawa_prawnik" value="<?php echo $sprawa_prawnik; ?>" placeholder="Prawnik prowadzący">
									</div>
									<div class="form-group col-md-4">
										<input type="text" <?php echo $zablokowany; ?> class="form-control druga_strona prm" data-kolumna="sprawa_druga_strona" value="<?php echo $sprawa_druga_strona; ?>" placeholder="Druga strona">
									</div>
									<div class="form-group col-md-4" data-kolumna="sprawa_pelnomocnik_glowny">
                                        <select class="form-control pełnomocnik_glowny prm" <?php echo $zablokowany; ?> data-kolumna="sprawa_pelnomocnik_glowny">
                                            <option value="" disabled <?php if($sprawa_pelnomocnik_glowny == '') echo 'selected'?>>Pełnomocnik Główny</option>
                                            <option value="Łebek Andrzej" <?php if($sprawa_pelnomocnik_glowny == 'Łebek Andrzej') echo 'selected'?> >Łebek Andrzej</option>
                                            <option value="Łebek Aniela" <?php if($sprawa_pelnomocnik_glowny == 'Łebek Aniela') echo 'selected'?>>Łebek Aniela</option>
                                        </select>
<!--										<input type="text" --><?php //echo $zablokowany; ?><!-- class="form-control pełnomocnik_glowny prm" data-kolumna="sprawa_pelnomocnik_glowny" value="--><?php //echo $sprawa_pelnomocnik_glowny; ?><!--" placeholder="Pełnomocnik główny">-->
									</div>
									<div class="clear_b"></div>
								</div>
								<div class="input_zwykly">
									<div class="form-group col-md-4">
										<input type="text" <?php echo $zablokowany; ?> class="form-control pelnomocnik_substytucyjny_kairp prm" data-kolumna="sprawa_pelnomocnik_kairp"" value="<?php echo $sprawa_pelnomocnik_kairp; ?>" placeholder="Pełnomocnik substytucyjny z KAIRP">
									</div>
									<div class="form-group col-md-2">
										<input type="text" <?php echo $zablokowany; ?> class="form-control wps prm" data-kolumna="sprawa_wps" value="<?php echo $sprawa_wps; ?>" placeholder="Wps">
									</div>
                                    <div class="form-group col-md-2">
                                        <input type="text" <?php echo $zablokowany; ?> class="form-control wpz prm" data-kolumna="sprawa_wpz" value="<?php echo $sprawa_wpz; ?>" placeholder="Wpz">
                                    </div>
									<div class="form-group col-md-4">
										<?php if($zablokowany === 'disabled'){
											echo '<input type="text" disabled class="lista_typow_umow_klienta form-control" value="typ_umowy">';
										}else{ ?>
											<div class="float_r dropdown lista_typow_umow_klienta width_100">
												<?php 
													$sprawa_typ_umowy = $db->pobierz_wiersz('slownik_wokanda_typ_umowy', 'id', $slownik_wokanda_typ_umowy_id);
													$sprawa_typ_umowy_wartosc = 'Typ umowy';
													
													if(!is_null($sprawa_typ_umowy)){
														$sprawa_typ_umowy_wartosc = $sprawa_typ_umowy->wartosc;
														$slownik_wokanda_typ_umowy_id = $sprawa_typ_umowy->id;
													}
												?>
												<button class="width_100 btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
											    	<span class="element_grupa_opcja_naglowek float_l prm typ_umowy_id" data-kolumna="slownik_wokanda_typ_umowy_id" data-wartosc_domyslna="<?php echo $slownik_wokanda_typ_umowy_id; ?>" value="<?php echo $slownik_wokanda_typ_umowy_id; ?>" ><?php echo mb_ucfirst($sprawa_typ_umowy_wartosc); ?></span>
													<span class="caret float_r"></span>
												</button>
												<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
											    	<?php 					
														$lista_klient_typ_umowy = $db->pobierz_wiersze('slownik_wokanda_typ_umowy', 'czy_usuniety', '0');
														if(!is_null($lista_klient_typ_umowy)){
															while ($poj_lista_klient_typ_umowy = $lista_klient_typ_umowy->fetch_object()) {
																echo '<li class="typ_umowy_grupa_opcja element_grupa_opcja  dropdown-menu_opcja cursor_p '.( ($slownik_wokanda_typ_umowy_id == $poj_lista_klient_typ_umowy->id) ? 'aktywna' : '' ).'" data-wartosc="'.mb_ucfirst($poj_lista_klient_typ_umowy->wartosc).'" data-element_id="'.$poj_lista_klient_typ_umowy->id.'">';
																echo '<i class="fa fa-check" aria-hidden="true"></i>';
																echo mb_ucfirst($poj_lista_klient_typ_umowy->wartosc);
																echo '</li>';
															}
														}					
													?>
										 		</ul>
											</div>
										<?php } ?>
									</div>
									<div class="clear_b"></div>
								</div>	
								<div class="input_zwykly">
									<div class="form-group col-md-6 float_l">
										<span class="margin_t_6 float_l">Klient zwolniony z opłat: </span>
										<?php
                                        $substytut_kwota = $wokanda->substytut_kwota;

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
									
								</div>	
								<div class="clear_b"></div>
								<div class="input_zwykly">
									<div class="form-group margin_b_0  float_l">
										<div><span>Zgoda na substytuta <i  class="sprawa_zgoda_na_substytuta <?php echo ($sprawa_zgoda_na_substytuta == '1') ? 'zaznaczony' : '' ; ?> <?php echo ($zablokowany === 'disabled') ? 'ikona_nie_zaznacz' : 'ikona_zaznacz' ; ?> fa fa<?php echo ($sprawa_zgoda_na_substytuta == '1') ? '-check' : '' ; ?>-square-o" aria-hidden="true"></i></span></div>
										<div><span>Sprawa karna <i  class="wokanda_sprawa_karna <?php echo ($wokanda->sprawa_karna == '1') ? 'zaznaczony' : '' ; ?> <?php echo ($zablokowany === 'disabled') ? 'ikona_nie_zaznacz' : 'ikona_zaznacz' ; ?> fa fa<?php echo ($wokanda->sprawa_karna == '1') ? '-check' : '' ; ?>-square-o" aria-hidden="true"></i></span></div>
										<div><span>Sprawa trudna <i  class="wokanda_sprawa_trudna <?php echo ($wokanda->sprawa_trudna == '1') ? 'zaznaczony' : '' ; ?> <?php echo ($zablokowany === 'disabled') ? 'ikona_nie_zaznacz' : 'ikona_zaznacz' ; ?> fa fa<?php echo ($wokanda->sprawa_trudna == '1') ? '-check' : '' ; ?>-square-o" aria-hidden="true"></i></span></div>
                                        <div class="">suma WPS: <span class="suma_wps"><?php echo $wokanda->wps_suma; ?></span>zł</div>
									</div>										
									<div class="clear_b"></div>
								</div>			
							</div>
							<!-- end sprawa glowna -->
						</div>
						<div role="tabpanel" class="tab-pane" id="sprawy_powiazane_tab">
							<i class="float_r fa fa-search wyszukaj_klienta cursor_p" data-akcja="sprawa_powiazana" aria-hidden="true"></i>
							<div class="table-responsive moja_tabela">
								<table id="" class="tabela_lista_spraw_powiazanych table_data_table table table-striped table-hover">
									<thead>
										<tr>
											<th class="col-md-2">Numer sprawy PCE</th>
											<th class="col-md-3">Klient</th>
											<th class="col-md-3">Prawnik</th>
											<th class="col-md-2">Druga strona</th>
											<th class="col-md-1">WPS</th>
											<th class="col-md-1"></th>
										</tr>
									</thead>
									<tbody class="lista_spraw_powiazanych_dodanych" data-liczba_spraw_powiazanych="0">		
										<?php 
											$lsp_wartosci = array(
													'wokanda_id' => $wokanda->id
											);
										
											$lista_spraw_powiazanych = $db->wywolaj_procedure('wokanda_pobierz_sprawy_powiazane', $lsp_wartosci);
                                            $cost = $lista_spraw_powiazanych->num_rows == 0 ? $substytut_kwota : $substytut_kwota/$lista_spraw_powiazanych->num_rows;
											if(!is_null($lista_spraw_powiazanych)){
												while ($poj_lista_spraw_powiazanych = $lista_spraw_powiazanych->fetch_object()) {
													echo '<tr data-numer_sprawy="'.$poj_lista_spraw_powiazanych->sprawa_pce_numer.'">';
														echo '<td class="col-md-2">'.$poj_lista_spraw_powiazanych->sprawa_pce_numer.'</td>';
														echo '<td class="col-md-3">'.$poj_lista_spraw_powiazanych->klient_imie.' '.$poj_lista_spraw_powiazanych->klient_nazwisko.'</td>';
														echo '<td class="col-md-3">'.$poj_lista_spraw_powiazanych->sprawa_prawnik.'</td>';
														echo '<td class="col-md-2">'.$poj_lista_spraw_powiazanych->sprawa_druga_strona.'</td>';
														echo '<td class="col-md-1">'.$poj_lista_spraw_powiazanych->sprawa_wps.'</td>';
														echo '<td class="col-md-1"><i data-sprawa_powiazana_id='.$poj_lista_spraw_powiazanych->id.' class="usun_klienta_powiazany_do_wokandy fa fa-eraser" aria-hidden="true"></i></td>';
													echo '</tr>';
												}
											}
										?>										
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php
				$substytut_id = $wokanda->substytut_id;
				$substytut_nazwisko = '';
				$substytut_imie = '';
				$substytut_uprawnienia = '';
				$substytut_ulica = '';
				$substytut_miasto = '';
				$substytut_wojewodztwo = '';
				$substytut_forma_platnosci = '';
				$substytut_forma_platnosci_id = '0';
				$substytut_forma_platnosci_wartosc = 'Forma płatności';
				$czy_votum = '0';
				
				$email = '';
				$email2 = '';
				$nr_telefonu = '';
								
				$faktura_wplynela = $wokanda->faktura_wplynela;
				$faktura_oplacona = $wokanda->faktura_oplacona;
				$faktura_numer = $wokanda->faktura_numer;
				$substytut_wyslano_dokumenty = $wokanda->wyslano_dokumenty;
				$substytut_otrzymano_notatke = $wokanda->otrzymano_notatke;
				$potwierdzony_substytut = $wokanda->potwierdzony_substytut;

				$usluga_wykonana = $wokanda->usluga_wykonana;
				$koszt_ponosi_votum = $wokanda->koszt_ponosi_votum;
				
				if($wokanda->slownik_substytut_forma_platnosci_id != '0'){
					$substytut_forma_platnosci = $db->pobierz_wiersz('slownik_substytut_forma_platnosci', 'id', $wokanda->slownik_substytut_forma_platnosci_id);
					$substytut_forma_platnosci_id = $substytut_forma_platnosci->id;
					$substytut_forma_platnosci_wartosc = $substytut_forma_platnosci->wartosc;
				}

				if(!is_null($substytut_id) && $substytut_id != '0'){
					$substytut_baza = $db->pobierz_wiersz('substytut', 'id', $substytut_id);
					$substytut_nazwisko = $substytut_baza->nazwisko;
					$substytut_imie = $substytut_baza->imie;					
					$substytut_uprawnienia = $db->pobierz_wiersz('slownik_substytut_uprawnienia', 'id', $substytut_baza->slownik_substytut_uprawnienia_id);
					$substytut_uprawnienia = $substytut_uprawnienia->wartosc;					
					$substytut_ulica = $substytut_baza->ulica;
					$substytut_miasto = $db->pobierz_wiersz('slownik_miasto', 'id', $substytut_baza->slownik_miasto_id);
					$substytut_wojewodztwo = $db->pobierz_wiersz('slownik_wojewodztwo', 'id', $substytut_miasto->wojewodztwo_id);
					$substytut_miasto = $substytut_miasto->nazwa;		
					$substytut_wojewodztwo = $substytut_wojewodztwo->nazwa;																			
					$email = $substytut_baza->email;
					$email2 = $substytut_baza->email2;
					$nr_telefonu = $substytut_baza->nr_telefonu;
					$czy_votum = $substytut_baza->czy_votum;
					
				}
				
			?>
							
			<div class="panel panel-default">
				<div class="panel-heading cursor_p dane_substytuta"  data-element_id="<?php echo $substytut_id; ?>">Dane Substytuta</div>
				<div class="panel-body ds_tresc_ogolna" >
				<div class="well well-sm ">
					<div class="input_zwykly">

							<div><span>Substytut z Kancelarii <i  class="<?php echo ($czy_votum == '1') ? 'zaznaczony' : '' ; ?> ikona_niezaznacz fa fa<?php echo ($czy_votum == '1') ? '-check' : '' ; ?>-square-o czy_votum_s" aria-hidden="true"></i></span></div>

					</div>
					<div class="input_zwykly">
						<div class="form-group col-md-4 wyszukaj_like_pole">
							<input type="text" class="form-control nazwisko_susbstytuta wyszukaj_like" data-szukaj_po="nazwa" data-tabela="substytut" value="<?php echo $substytut_nazwisko; ?>" placeholder="Nazwisko substytuta">
						</div>
						<div class="form-group col-md-4">
							<input type="text" class="form-control imie_susbstytuta" disabled value="<?php echo $substytut_imie; ?>" placeholder="Imię substytuta">
						</div>
						<div class="form-group col-md-4">
							<input type="text" class="form-control substytut_uprawnienia" disabled value="<?php echo $substytut_uprawnienia; ?>" placeholder="Uprawnienia">
						</div>
						<div class="clear_b"></div>
					</div>
					<div class="input_zwykly">
						<div class="form-group col-md-4">
							<input type="text" class="form-control substytut_ulica" disabled value="<?php echo $substytut_ulica; ?>" placeholder="Ulica">
						</div>
						<div class="form-group col-md-4">
							<input type="text" class="form-control substytut_miasto" disabled value="<?php echo $substytut_miasto; ?>" placeholder="Miasto">
						</div>
						<div class="form-group col-md-4">
							<input type="text" class="form-control substytut_wojewodztwo" disabled value="<?php echo $substytut_wojewodztwo; ?>" placeholder="Wojewodztwo">
						</div>
						<div class="clear_b"></div>
					</div>

					<div class="input_zwykly">
						<div class="form-group col-md-4">
							<div><span>Wysłano dokumenty <i  class="<?php echo ($substytut_wyslano_dokumenty == '1') ? 'zaznaczony' : '' ; ?> ikona_zaznacz fa fa<?php echo ($substytut_wyslano_dokumenty == '1') ? '-check' : '' ; ?>-square-o wyslano_dokumenty" aria-hidden="true"></i></span></div>
							<div><span>Otrzymano notatkę <i  class="<?php echo ($substytut_otrzymano_notatke == '1') ? 'zaznaczony' : '' ; ?> ikona_zaznacz fa fa<?php echo ($substytut_otrzymano_notatke == '1') ? '-check' : '' ; ?>-square-o otrzymano_notatke" aria-hidden="true"></i></span></div>
							<div><span>Potwierdzony substytut <i  class="<?php echo ($potwierdzony_substytut == '1') ? 'zaznaczony' : '' ; ?> ikona_zaznacz fa fa<?php echo ($potwierdzony_substytut == '1') ? '-check' : '' ; ?>-square-o potwierdzony_substytut" aria-hidden="true"></i></span></div>
							<div><span>Usługa wykonana <i  class="<?php echo ($usluga_wykonana == '1') ? 'zaznaczony' : '' ; ?> ikona_zaznacz fa fa<?php echo ($usluga_wykonana == '1') ? '-check' : '' ; ?>-square-o usluga_wykonana" aria-hidden="true"></i></span></div>
						</div>
						<div class="form-group col-md-4 koszt_substytuta_pola">
                            <label>Koszt</label>
							<input type="text" class="form-control koszt_substytuta prm" data-kolumna="substytut_kwota" value="<?php  echo round($substytut_kwota, 2); ?>" placeholder="Kwota">
							<input type="text" disabled class="form-control koszt_substytuta_opis " data-kolumna="" value="NETTO">
						</div>

                        <div class="form-group col-md-4 koszt_na_sprawe_pola">
                            <label>Koszt / sprawa</label>
                            <input type="text" class="form-control koszt_na_sprawe prm" data-kolumna="sprawa_koszt" value="<?php  echo round($cost, 2); ?>" placeholder="Kwota">
                            <input type="text" disabled class="form-control koszt_na_sprawe_opis " data-kolumna="" value="NETTO">
                        </div>
						<div class="form-group col-md-4">
							<div class="float_r dropdown forma_platnosci_substytut width_100">
									<button class="width_100 btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
								    	<span class="forma_platnosci_substytut_nazwa element_grupa_opcja_naglowek float_l prm" data-kolumna="slownik_substytut_forma_platnosci_id" data-wartosc_domyslna="<?php echo $substytut_forma_platnosci_id; ?>" value="<?php echo $substytut_forma_platnosci_id; ?>" ><?php echo mb_ucfirst($substytut_forma_platnosci_wartosc); ?></span>
										<span class="caret float_r"></span>
									</button>
									<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
								    	<?php 					
											$lista_substytut_forma_platnosci = $db->pobierz_wiersze('slownik_substytut_forma_platnosci', 'czy_usuniety', '0');
											if(!is_null($lista_substytut_forma_platnosci)){
												while ($poj_lista_substytut_forma_platnosci = $lista_substytut_forma_platnosci->fetch_object()) {
													echo '<li id="substytut_forma_platnosci_'.$poj_lista_substytut_forma_platnosci->id.'" class=" element_grupa_opcja  dropdown-menu_opcja cursor_p '.( ($wokanda->slownik_substytut_forma_platnosci_id == $poj_lista_substytut_forma_platnosci->id) ? 'aktywna' : '' ).'" data-wartosc="'.mb_ucfirst($poj_lista_substytut_forma_platnosci->wartosc).'" data-element_id="'.$poj_lista_substytut_forma_platnosci->id.'">';
													echo '<i class="fa fa-check" aria-hidden="true"></i>';
													echo mb_ucfirst($poj_lista_substytut_forma_platnosci->wartosc);
													echo '</li>';
												}
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
								<div>Email: <span class="emai_substytut"><?php echo $email; ?></span></div>
								<div>Email prywatny: <span class="emai2_substytut"><?php echo $email2; ?></span></div>
								<div>Telefon: <span class="telefon_substytut"><?php echo $nr_telefonu; ?></span></div>
								<div class="clear_b"></div>
							</div>
						</div>
						
						<div class="well substytut_faktury float_l well-sm margin_t_10">
							<div class="input_zwykly">
								<div class="form-group col-md-5">
									<div><span>Faktura wpłyneła <i  class="<?php echo ($faktura_wplynela == '1') ? 'zaznaczony' : '' ; ?> ikona_zaznacz fa fa<?php echo ($faktura_wplynela == '1') ? '-check' : '' ; ?>-square-o faktura_wplynela" aria-hidden="true"></i></span></div>
									<div><span>Faktura opłacona <i  class="<?php echo ($faktura_oplacona == '1') ? 'zaznaczony' : '' ; ?> ikona_zaznacz fa fa<?php echo ($faktura_oplacona == '1') ? '-check' : '' ; ?>-square-o faktura_oplacona" aria-hidden="true"></i></span></div>
									<div><span>Koszt ponosi VOTUM <i  class="<?php echo ($koszt_ponosi_votum == '1') ? 'zaznaczony' : '' ; ?> ikona_zaznacz fa fa<?php echo ($koszt_ponosi_votum == '1') ? '-check' : '' ; ?>-square-o koszt_ponosi_votum" aria-hidden="true"></i></span></div>
								</div>
								<div class="form-group col-md-7">
									<input type="text" class="form-control faktura_numer_substytuta prm" data-kolumna="faktura_numer" value="<?php echo $wokanda->faktura_numer; ?>" placeholder="Numer faktury">
								</div>
								<div class="clear_b"></div>
							</div>
						</div>
						
						<div class="well float_l well-sm margin_t_10">
							<div>Pomocnik substytuta</div>
							<div class="input_100p">
								<div class="form-group col-md-4">
									<input type="text"  class="form-control pomocnik_imie_nazwisko prm" data-kolumna="substytut_pomocnik" value="<?php echo $wokanda->substytut_pomocnik; ?>" placeholder="Pomocnik imię i nazwisko">
								</div>
								<div class="form-group col-md-5">
									<input type="text"  class="form-control pomocnik_email prm" data-kolumna="substytut_pomocnik_mail" value="<?php echo $wokanda->substytut_pomocnik_mail; ?>" placeholder="Pomocnik adres email">
								</div>
								<div class="clear_b"></div>			
							</div>
							<div class="clear_b"></div>	
						</div>
						
						<div class="well substytut_faktury float_l well-sm margin_t_10">
							<div class="input_zwykly">
								<div class="form-group col-md-12">
									<textarea class="dodatkowe_dane_do_fv form-control prm" data-kolumna="dodatkowe_dane_do_fv" value="<?php echo (!empty($wokanda->dodatkowe_dane_do_fv)) ? $wokanda->dodatkowe_dane_do_fv : '' ; ?>" placeholder="Dodatkowe dane do FV..."><?php echo (!empty($wokanda->dodatkowe_dane_do_fv)) ? $wokanda->dodatkowe_dane_do_fv : '' ; ?></textarea>
								</div>
								<div class="clear_b"></div>
							</div>
						</div>

                        <div class="well float_l well-sm margin_t_10 width_100">
                            <div class="input_zwykly">
                                <div class="form-group col-md-12">
                                    <textarea class=" form-control prm" data-kolumna="substytut_komentarz" value="<?php echo (!empty($wokanda->substytut_komentarz)) ? $wokanda->substytut_komentarz : '' ; ?>" placeholder="Treść komantarza..."><?php echo (!empty($wokanda->substytut_komentarz)) ? $wokanda->substytut_komentarz : '' ; ?></textarea>
                                </div>
                                <div class="clear_b"></div>
                            </div>
                        </div>
						
						<div class="clear_b"></div>
					</div>


				</div>
			</div>
			<?php if(in_array(21, $uzytkownik->__get('_lista_przyznanych_uprawnien'))){ ?>
				<button type="button" data-parent_class="widok_edycja_wokandy" class="btn btn-default wokanda_zapisz przycisk_zapisz_zmiany btn-block text-uppercase  ">Zapisz zmiany</button>
			<?php } ?>
		</div>
		<?php 
			if(in_array(18, $uzytkownik->__get('_lista_przyznanych_uprawnien'))){	
				echo '<div role="tabpanel" class="tab-pane " id="historia">';				
					zakladka_historia('wokanda_historia_zmian', 'wokanda_id', $db, $id);							 								
				echo '</div>';
		 	} 
		 ?>
	</div>
</div>