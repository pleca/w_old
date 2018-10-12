<?php /* Nazwa: Lista Wokand */ ?>
<?php
	require_once($_SERVER ['DOCUMENT_ROOT'].'czy_zalogowany.php');

	function wygeneruj_liste($tytul, $lista_wynikow, $uzytkownik, $nazwa_klasa_tabela){
		if(!is_null($lista_wynikow)){
			echo '<div class="panel panel-default">';
				echo '<div class="panel-heading cursor_p">'.$tytul.'<span class="badge">'.$lista_wynikow->num_rows.'</span></div>';
				echo '<div class="panel-body">';
		
								echo '<div class="table-responsive moja_tabela">';
										echo '<table id="" class="'.$nazwa_klasa_tabela.' table_data_table table table-striped table-hover">';
											echo '<thead>';
												echo '<tr>';
													echo '<th class="ukryj">ID</th>';
													echo '<th class="ukryj">Nazwa</th>';
													echo '<th class="ukryj">Koniec</th>';
													echo '<th class="col-md-1">Data</th>';
													echo '<th class="col-md-1">Początek</th>';													
													echo '<th class="col-md-2">Nr sprawy</th>';
													echo '<th class="col-md-2">Prowadzący</th>';
													echo '<th class="ukryj">Sąd nazwa</th>';
													echo '<th class="col-md-2">Sąd-Miasto</th>';
													echo '<th class="col-md-2">Wokanda-Miasto</th>';
													echo '<th class="col-md-1">Powód</th>';
													echo '<th class="col-md-1">Sygnatura</th>';
													echo '<th class="col-md-1">Sybstytut</th>';
													echo '<th class="col-md-1">Uprawnienie</th>';
													echo '<th class="ukryj"></th>';
												echo '</tr>';
											echo '</thead>';
											echo '<tbody>';
													while ($poj_lista_wynikow = $lista_wynikow->fetch_object()) {
                                                        $style = '';

                                                        if($poj_lista_wynikow->slownik_wokanda_etap_id == 5
                                                            || $poj_lista_wynikow->slownik_wokanda_etap_id == 9
                                                            || $poj_lista_wynikow->slownik_wokanda_etap_id == 8){
                                                            $style = 'style="color:#FFF; background:rgba(92, 184, 92, 0.7);"';
                                                        }else if($poj_lista_wynikow->slownik_wokanda_etap_id == 3 || $poj_lista_wynikow->slownik_wokanda_etap_id == 4)
                                                        {
                                                            $style = 'style="color:#FFF; background:rgb(234, 160, 1);"';
                                                        }

														echo '<tr '.$style.' class="'.((in_array(24, $uzytkownik->__get('_lista_przyznanych_uprawnien'))) ? 'wokanda_edytuj' : '' ).'" data-toggle="tooltip" data-placement="top" title="'.$poj_lista_wynikow->sad_nazwa.'" data-element_id="'.$poj_lista_wynikow->id.'">';
															echo '<td class="ukryj">'.$poj_lista_wynikow->id.'</td>';
															echo '<td class="ukryj">'.$poj_lista_wynikow->nazwa.'</td>';

															$poj_lista_wokand_data_start = explode(' ',$poj_lista_wynikow->start);
															$poj_lista_wokand_data_stop = explode(' ',$poj_lista_wynikow->stop);
                                                            echo '<td class="ukryj">'.$poj_lista_wokand_data_stop[1].'</td>';

															if($poj_lista_wynikow->sprawa_trudna == 1){
                                                                echo '<td class="col-md-1 sprawa_trudna"><span class="ukryj">'.str_replace('-','',$poj_lista_wokand_data_start[0]).'</span>'.$poj_lista_wokand_data_start[0].'</td>';
                                                                echo '<td class="col-md-1 sprawa_trudna">'.$poj_lista_wokand_data_start[1].'</td>';
                                                                echo '<td class="col-md-2 sprawa_trudna">'.$poj_lista_wynikow->sprawa_pce_numer.'</td>';
                                                                echo '<td class="col-md-2 sprawa_trudna">'.$poj_lista_wynikow->sprawa_prawnik.'</td>';
                                                                echo '<td class="ukryj">'.$poj_lista_wynikow->sad_nazwa.'</td>';
                                                                echo '<td class="col-md-2 sprawa_trudna">'.$poj_lista_wynikow->sad_miasto.'</td>';
                                                                echo '<td class="col-md-2 sprawa_trudna">'.$poj_lista_wynikow->wokanda_miasto.'</td>';
                                                                echo '<td class="col-md-1 sprawa_trudna">'.$poj_lista_wynikow->klient_imie.' '.$poj_lista_wynikow->klient_nazwisko.'</td>';
                                                                echo '<td class="col-md-1 sprawa_trudna">'.$poj_lista_wynikow->sygnatura_akt.'</td>';
                                                                echo '<td class="col-md-1 sprawa_trudna">'.$poj_lista_wynikow->substytut_nazwisko.' '.$poj_lista_wynikow->substytut_imie.'</td>';
                                                                echo '<td class="col-md-1 sprawa_trudna">'.$poj_lista_wynikow->substytut_uprawnienie.'</td>';
                                                                echo '<td class="col-md-1" style="background-color: white; border: none"><i class="fa fa-exclamation" style="color:red; font-size: 26px" aria-hidden="true"></i></td>';
                                                            }else {
                                                                echo '<td class="col-md-1"><span class="ukryj">' . str_replace('-', '', $poj_lista_wokand_data_start[0]) . '</span>' . $poj_lista_wokand_data_start[0] . '</td>';
                                                                echo '<td class="col-md-1">' . $poj_lista_wokand_data_start[1] . '</td>';
                                                                echo '<td class="col-md-2">' . $poj_lista_wynikow->sprawa_pce_numer . '</td>';
                                                                echo '<td class="col-md-2">' . $poj_lista_wynikow->sprawa_prawnik . '</td>';
                                                                echo '<td class="ukryj">' . $poj_lista_wynikow->sad_nazwa . '</td>';
                                                                echo '<td class="col-md-2">' . $poj_lista_wynikow->sad_miasto . '</td>';
                                                                echo '<td class="col-md-2">' . $poj_lista_wynikow->wokanda_miasto . '</td>';
                                                                echo '<td class="col-md-2">' . $poj_lista_wynikow->klient_imie . ' ' . $poj_lista_wynikow->klient_nazwisko . '</td>';
                                                                echo '<td class="col-md-1">' . $poj_lista_wynikow->sygnatura_akt . '</td>';
                                                                echo '<td class="col-md-1">'.$poj_lista_wynikow->substytut_nazwisko.' '.$poj_lista_wynikow->substytut_imie.'</td>';
                                                                echo '<td class="col-md-1">'.$poj_lista_wynikow->substytut_uprawnienie.'</td>';
                                                                echo '<td class="ukryj"></td>';
                                                            }
														echo '</tr>';
													};
												
											echo '</tbody>';
										echo '</table>';
									echo '</div>';
								
							echo '</div>';
						echo '</div>';
						
		};
	}
	
?>

	<ul class="nav nav-tabs" role="tablist">
		<li role="presentation" class="active"><a href="#aktywni" aria-controls="aktywni" role="tab" data-toggle="tab">Aktywne</a></li>
		<?php if(in_array(17, $uzytkownik->__get('_lista_przyznanych_uprawnien'))){ ?>	
			<li role="presentation"><a href="#usunieci" aria-controls="usunieci" role="tab" data-toggle="tab">Usunięte</a></li>
		<?php } ?>
		<li role="presentation" class=""><a href="#filtruj" class="filtruj_tab" aria-controls="filtruj" role="tab" data-toggle="tab">Filtruj</a></li>
	</ul> 
	
	<div class="tab-content">
		<div role="tabpanel" class="tab-pane active" id="aktywni">
			<?php 
				$wartosci = array(
						'uzytkownik_id_tmp' => $uzytkownik->__get('_id')
						,'czy_usuniety_tmp' => '0'
						,'lista' => 'moje'
						,'id' => '0'
						,'nazwa' => ''
						,'start' => ''
						,'stop' => ''
						,'potwierdzony_termin' => ''
						,'sad_miasto' => ''
						,'wokanda_miasto' => ''
						,'wokanda_prowadzacy' => ''
						,'sygnatura_akt' => ''
						,'klient_imie' => ''
						,'klient_nazwisko' => ''
						,'sprawa_pce_numer' => ''
						,'imie_substytut'  => ''
						,'nazwisko_substytu' => ''
						,'substytut_votum' => ''
						,'sprawa_druga_strona' => ''
						,'sprawa_prawnik_prowadzacy' => ''
						,'faktura_numer' => ''
						,'faktura_zrealizowana' => ''
						,'koszt_ponosi_votum' => ''
                        ,'wokanda_etap' => ''
                        ,'wokanda_etap2' => ''
                        ,'wokanda_etap_sprawy' => ''
                        ,'wokanda_rodzaj' => ''
                        ,'wps_od' => ''
                        ,'wps_do' => ''
                        ,'sprawa_trudna' => ''
                        ,'substytut_uprawnienie' => ''
				);
				$lista_wokand = $db->wywolaj_procedure('wokanda_lista_wokand_moje_wszystkie', $wartosci);
				wygeneruj_liste('Moje wokandy', $lista_wokand, $uzytkownik, 'tabela_lista_wokand');
				
				
				if(in_array(23, $uzytkownik->__get('_lista_przyznanych_uprawnien'))){
					$wartosci_wszystkich = array(
							'uzytkownik_id_tmp' => $uzytkownik->__get('_id')
							,'czy_usuniety_tmp' => '0'
							,'lista' => ''
							,'id' => '0'
							,'nazwa' => ''
							,'start' => ''
							,'stop' => ''
							,'potwierdzony_termin' => ''
							,'sad_miasto' => ''
							,'wokanda_miasto' => ''
							,'wokanda_prowadzacy' => ''
							,'sygnatura_akt' => ''
							,'klient_imie' => ''
							,'klient_nazwisko' => ''
							,'sprawa_pce_numer' => ''
							,'imie_substytut'  => ''
							,'nazwisko_substytu' => ''
							,'substytut_votum' => ''
							,'sprawa_druga_strona' => ''
							,'sprawa_prawnik_prowadzacy' => ''
							,'faktura_numer' => ''
							,'faktura_zrealizowana' => ''
							,'koszt_ponosi_votum' => ''
                            ,'wokanda_etap' => ''
                            ,'wokanda_etap2' => ''
                            ,'wokanda_etap_sprawy' => ''
                            ,'wokanda_rodzaj' => ''
                            ,'wps_od' => ''
                            ,'wps_do' => ''
                            ,'sprawa_trudna' => ''
                            ,'substytut_uprawnienie' => ''
					);
					$lista_wokand_wszystkich = $db->wywolaj_procedure('wokanda_lista_wokand_moje_wszystkie', $wartosci_wszystkich);													
					wygeneruj_liste('Pozostałe wokandy', $lista_wokand_wszystkich, $uzytkownik,'tabela_lista_wokand');
				}
			?>
		</div>
		<div role="tabpanel" class="tab-pane" id="usunieci">
			<?php
				$wartosci = array(
						'uzytkownik_id_tmp' => $uzytkownik->__get('_id')
						,'czy_usuniety_tmp' => '1'
						,'lista' => 'moje'
						,'id' => '0'
						,'nazwa' => ''
						,'start' => ''
						,'stop' => ''
						,'potwierdzony_termin' => ''
						,'sad_miasto' => ''
						,'wokanda_miasto' => ''
						,'wokanda_prowadzacy' => ''
						,'sygnatura_akt' => ''
						,'klient_imie' => ''
						,'klient_nazwisko' => ''
						,'sprawa_pce_numer' => ''
						,'imie_substytut'  => '' 
						,'nazwisko_substytu' => ''
						,'substytut_votum' => ''
						,'sprawa_druga_strona' => ''
						,'sprawa_prawnik_prowadzacy' => ''
						,'faktura_numer' => ''
						,'faktura_zrealizowana' => ''
						,'koszt_ponosi_votum' => ''
                        ,'wokanda_etap' => ''
                        ,'wokanda_etap2' => ''
                        ,'wokanda_etap_sprawy' => ''
                        ,'wps_od' => ''
                        ,'wps_do' => ''
                        ,'wokanda_rodzaj' => ''
                        ,'sprawa_trudna' => ''
                        ,'substytut_uprawnienie' => ''
				);
				$lista_wokand = $db->wywolaj_procedure('wokanda_lista_wokand_moje_wszystkie', $wartosci);
				wygeneruj_liste('Moje wokandy', $lista_wokand, $uzytkownik,'tabela_lista_wokand');
				
				if(in_array(23, $uzytkownik->__get('_lista_przyznanych_uprawnien'))){
					$wartosci_wszystkich = array(
							'uzytkownik_id_tmp' => $uzytkownik->__get('_id')
							,'czy_usuniety_tmp' => '1'
							,'lista' => ''
							,'id' => '0'
							,'nazwa' => ''
							,'start' => ''
							,'stop' => ''
							,'potwierdzony_termin' => ''
							,'sad_miasto' => ''
							,'wokanda_miasto' => ''
							,'wokanda_prowadzacy' => ''
							,'sygnatura_akt' => ''
							,'klient_imie' => ''
							,'klient_nazwisko' => ''
							,'sprawa_pce_numer' => ''
							,'imie_substytut'  => '' 
							,'nazwisko_substytu' => ''
							,'substytut_votum' => ''
							,'sprawa_druga_strona' => ''
							,'sprawa_prawnik_prowadzacy' => ''
							,'faktura_numer' => ''
							,'faktura_zrealizowana' => ''
							,'koszt_ponosi_votum' => ''
                            ,'wokanda_etap' => ''
                            ,'wokanda_etap2' => ''
                            ,'wokanda_etap_sprawy' => ''
                            ,'wokanda_rodzaj' => ''
                            ,'wps_od' => ''
                            ,'wps_do' => ''
                            ,'sprawa_trudna' => ''
                            ,'substytut_uprawnienie' => ''
					);
					
					$lista_wokand_wszystkich = $db->wywolaj_procedure('wokanda_lista_wokand_moje_wszystkie', $wartosci_wszystkich);													
					wygeneruj_liste('Pozostałe wokandy', $lista_wokand_wszystkich, $uzytkownik,'tabela_lista_wokand');
				}
			
			?>
		</div>
		<div role="tabpanel" class="tab-pane" id="filtruj">
		<div class="filtry ">
			<div>
                <div class="well well-sm margin_b_10 width_100">
                    <div class="width_100 margin_b_10">Wokanda etap I</div>
                    <?php
                        $wokanda_etap = $db->pobierz_wiersze('slownik_wokanda_etap', 'czy_usuniety', 0);
                        while($element = $wokanda_etap->fetch_object()){
                            ?>
                                <div class="btn btn-default margin_b_10 zaznaczOdznaczEtapWokandy wokandaEtap" type="submit" data-element_id="<?php echo $element->id; ?>"><?php echo $element->wartosc; ?></div>
                            <?php
                        }
                    ?>
                </div>
                <div class="well well-sm margin_b_10 width_100">
                    <div class="width_100 margin_b_10">Wokanda etap II</div>
                    <?php
                    $wokanda_etap_2 = $db->pobierz_wiersze('slownik_wokanda_etap_2', 'czy_usuniety', 0);
                    while($element = $wokanda_etap_2->fetch_object()){
                        ?>
                        <div class="btn btn-default margin_b_10 zaznaczOdznaczEtap2Wokandy wokanda2Etap" type="submit" data-element_id="<?php echo $element->id; ?>"><?php echo $element->wartosc; ?></div>
                        <?php
                    }
                    ?>
                </div>
                <div class="well well-sm margin_b_10 width_100">
                    <div class="width_100 margin_b_10">Wokanda etap sprawy</div>
                    <?php
                    $wokanda_etap_sprawy = $db->pobierz_wiersze('slownik_wokanda_etap_sprawy', 'czy_usuniety', 0);
                    while($element = $wokanda_etap_sprawy->fetch_object()){
                        ?>
                        <div class="btn btn-default margin_b_10 zaznaczOdznaczEtapSprawy wokandaEtap" type="submit" data-element_id="<?php echo $element->id; ?>"><?php echo $element->wartosc; ?></div>
                        <?php
                    }
                    ?>
                </div>
                <div class="well well-sm margin_b_10 width_100">
                    <div class="width_100 margin_b_10">Wokanda Rodzaj</div>
                    <?php
                    $wokanda_rodzaj = $db->pobierz_wiersze('slownik_wokanda_rodzaj', 'czy_usuniety', 0);
                    while($element = $wokanda_rodzaj->fetch_object()){
                        ?>
                        <div class="btn btn-default margin_b_10 zaznaczOdznaczRodzajWokandy wokandaRodzaj" type="submit" data-element_id="<?php echo $element->id; ?>"><?php echo $element->wartosc; ?></div>
                        <?php
                    }
                    ?>
                </div>
				<div class="well well-sm margin_b_10">
					<span>Wokanda</span>
					<div class="input_zwykly">
						<div class="form-group col-md-12">
							<input type="text" class="form-control fid_wokanda fprm wokanda_filtruj_enter" data-kolumna="id" value="" placeholder="ID">
						</div>
						<div class="form-group col-md-12">
							<input type="text" class="form-control fnazwa_wokanda fprm wokanda_filtruj_enter" data-kolumna="nazwa" value="" placeholder="Nazwa">
						</div>
						<div class="form-group col-md-12">
							<input type="text" class="form-control datepicker fdata_wokanda_od fprm wokanda_filtruj_enter " data-kolumna="start" value="" placeholder="Data od">
						</div>
						<div class="form-group col-md-12">
							<input type="text" class="form-control datepicker fdata_wokanda_do fprm wokanda_filtruj_enter " data-kolumna="stop" value="" placeholder="Data do">
						</div>
                        <div class="form-group col-md-12">
                            <input type="text" class="form-control fmiasto_wokanda fprm wokanda_filtruj_enter" data-kolumna="wokanda_miasto" value="" placeholder="Miasto">
                        </div>
                        <div class="form-group col-md-12">
                                <div id="wokanda_prowadzacy" class="dropdown">
                                    <button  class="btn btn-default dropdown-toggle" type="button" style="width:100%" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                        <span class="element_grupa_opcja_naglowek wokanda_prowadzacy-wybrany float_l fprm" data-kolumna="wokanda_prowadzacy"  value="" >Osoba z Wokand</span>
                                        <span class="caret float_r"></span>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                        <li id="wokanda_prowadzacy_0" class="wokanda_prowadzacy_opcja element_grupa_opcja  dropdown-menu_opcja cursor_p " data-wartosc="Osoba z Wokand" data-element_id="">Osoba z Wokand</li>
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
                                        <script>
                                            $('.element_grupa_opcja').on('click', function(){
                                              var value = $(this).data('element-id');
                                              $('.wokanda_prowadzacy-wybrany').attr('value',value);
                                            });
                                        </script>
                                    </ul>
                                </div>
                        </div>
						<div class="form-group col-md-12">
							<span><i class="ikona_zaznacz fa fa-square-o potwierdzony_termin_f" aria-hidden="true"></i> Powierdzony termin</span>
							<div class="potwierdzony_termin_opcje">
								<span>TAK <i class="ikona_zaznacz fa fa-square-o potwierdzony_termin_o pto_tak" data-opcja="1" aria-hidden="true"></i></span>
								<span>NIE <i class="ikona_zaznacz zaznaczony fa fa-check-square-o potwierdzony_termin_o pto_nie" data-opcja="0" aria-hidden="true"></i></span>
							</div>
						</div>
						
						<div class="clear_b"></div>
					</div>
				</div>
				<div class="well well-sm margin_b_10">
					<span>Sąd</span>
					<div class="input_zwykly margin_b_10">
						<div class="form-group col-md-12">
							<input type="text" class="form-control fmiasto_sad fprm wokanda_filtruj_enter" data-kolumna="sad_miasto" value="" placeholder="Miasto">
						</div>
						<div class="form-group col-md-12">
							<input type="text" class="form-control fsygnatura_wokanda fprm wokanda_filtruj_enter" data-kolumna="sygnatura_akt" value="" placeholder="Sygnatura">
						</div>
						
						<div class="clear_b"></div>
					</div>
                    <span>WPS całościowy</span>
                    <div class="input_zwykly">
                        <div class="form-group col-md-12">
                            <input type="text" class="form-control fmiasto_wokanda fprm wokanda_filtruj_enter" data-kolumna="wps_od" value="" placeholder="WPS od">
                        </div>
                        <div class="form-group col-md-12">
                            <input type="text" class="form-control fsygnatura_wokanda fprm wokanda_filtruj_enter" data-kolumna="wps_do" value="" placeholder="WPS do">
                        </div>

                        <div class="clear_b"></div>
                    </div>
				</div>
				<div class="well well-sm margin_b_10">
					<span>Klient/sprawa</span>
					<div class="input_zwykly">
						<div class="form-group col-md-12">
							<input type="text" class="form-control fklient_imie_wokanda fprm wokanda_filtruj_enter" data-kolumna="klient_imie" value="" placeholder="Klient imię">
						</div>
						<div class="form-group col-md-12">
							<input type="text" class="form-control fklient_nazwisko_wokanda fprm wokanda_filtruj_enter" data-kolumna="klient_nazwisko" value="" placeholder="Klient nazwisko">
						</div>
						<div class="form-group col-md-12">
							<input type="text" class="form-control fklient_nr_sprawy_wokanda fprm wokanda_filtruj_enter" data-kolumna="sprawa_pce_numer" value="" placeholder="Numer sprawy PCE">
						</div>
						<div class="form-group col-md-12">
							<input type="text" class="form-control fklient_druga_strona fprm wokanda_filtruj_enter" data-kolumna="sprawa_druga_strona" value="" placeholder="Druga strona">
						</div>
						<div class="form-group col-md-12">
							<input type="text" class="form-control fklient_prawnik_prowadzacy fprm wokanda_filtruj_enter" data-kolumna="sprawa_prawnik_prowadzacy" value="" placeholder="Prawnik prowadzący">
						</div>
						<div class="clear_b"></div>
					</div>
				</div>
				<div class="well well-sm margin_b_10">
					<span>Substytut</span>
					<div class="input_zwykly">
						<div class="form-group col-md-12">
							<input type="text" class="form-control fsubstytut_imie_wokanda fprm wokanda_filtruj_enter" data-kolumna="imie_substytut" value="" placeholder="Substytut imię">
						</div>
						<div class="form-group col-md-12">
							<input type="text" class="form-control fsubstytut_nazwisko_wokanda fprm wokanda_filtruj_enter" data-kolumna="nazwisko_substytu" value="" placeholder="Substytut nazwisko">
						</div>
						<div class="form-group col-md-12">
							<input type="text" class="form-control fsubstytut_numer_faktury fprm wokanda_filtruj_enter" data-kolumna="faktura_numer" value="" placeholder="Numer faktury">
						</div>
						<div class="form-group col-md-12">
							<span><i class="ikona_zaznacz fa fa-square-o czy_votum" aria-hidden="true"></i>Substytut z Kancelarii</span>
							<div class="czy_votum_opcje">
								<span>TAK <i class="ikona_zaznacz fa fa-square-o czy_votum_o czv_tak" data-opcja="1" aria-hidden="true"></i></span>
								<span>NIE <i class="ikona_zaznacz zaznaczony fa fa-check-square-o czy_votum_o czv_nie" data-opcja="0" aria-hidden="true"></i></span>
							</div>	
						</div>
						<div class="form-group col-md-12">
							<span><i class="ikona_zaznacz fa fa-square-o faktura_zrealizowana" aria-hidden="true"></i>Faktura zrealizowana</span>
							<div class="faktura_zrealizowana_opcje">
								<span>TAK <i class="ikona_zaznacz fa fa-square-o faktura_zrealizowana_o fzv_tak" data-opcja="1" aria-hidden="true"></i></span>
								<span>NIE <i class="ikona_zaznacz zaznaczony fa fa-check-square-o faktura_zrealizowana_o fzv_nie" data-opcja="0" aria-hidden="true"></i></span>
							</div>	
						</div>
						<div class="form-group col-md-12">
							<span><i class="ikona_zaznacz fa fa-square-o koszt_ponosi_votum" aria-hidden="true"></i>Koszt ponosi VOTUM</span>
							<div class="koszt_ponosi_votum_opcje">
								<span>TAK <i class="ikona_zaznacz fa fa-square-o koszt_ponosi_votum_o fzkpv_tak" data-opcja="1" aria-hidden="true"></i></span>
								<span>NIE <i class="ikona_zaznacz zaznaczony fa fa-check-square-o koszt_ponosi_votum_o fzkpv_nie" data-opcja="0" aria-hidden="true"></i></span>
							</div>	
						</div>
						<div class="clear_b"></div>
					</div>
				</div>

			</div>
			<div class="clear_b margin_b_10"></div>
			<button type="button" class="margin_b_10 btn btn-default przycisk_zapisz_zmiany filtruj_wokandy  btn-block text-uppercase" data-akcja="wokanda_filtruj" >FILTRUJ</button>
		</div>
		<div id="filtry_wyniki_wokanda" class="filtry_wyniki ">
            <div id="grid5"></div>
			<script>

            </script>
			<?php
			echo '<div class="panel panel-default">';
				echo '<div class="panel-heading aktywny cursor_p">Wyniki<span class="badge">0</span></div>';
					echo '<div class="panel-body" style="display:block">';
						echo '<div class="table-responsive moja_tabela">';
							echo '<table id="" class="tabela_lista_wokand_filtruj table_data_table table table-striped table-hover">';
								echo '<thead>';
									echo '<tr data-element_id="0">';
										echo '<th class="ukryj">ID</th>';
										echo '<th class="ukryj">Nazwa</th>';
										echo '<th class="ukryj">Koniec</th>';						
										echo '<th class="col-md-1">Data</th>';
										echo '<th class="col-md-1">Początek</th>';
										echo '<th class="col-md-2">Nr sprawy</th>';
										echo '<th class="ukryj">Sąd nazwa</th>';
										echo '<th class="col-md-2">Sąd-Miasto</th>';
										echo '<th class="col-md-2">Wokanda-Miasto</th>';
										echo '<th class="col-md-2">Prowadzący</th>';
										echo '<th class="col-md-1">Powód</th>';
										echo '<th class="col-md-1">Sygnatura</th>';
										echo '<th class="col-md-1">Sybstytut</th>';
										echo '<th class="col-md-1">Uprawnienie</th>';
										//echo '<th class="col-md-1"><i class="fa ikona_zaznacz_w zaznacz_wszystkie_wyniki fa-square-o" aria-hidden="true"></i></th>';
									echo '</tr>';
								echo '</thead>';
								echo '<tbody>';
									
								echo '</tbody>';
							echo '</table>';
						echo '</div>';
					echo '</div>';
				echo '</div>';
			?>
		</div>
			<div class="clear_b"></div>
			
		</div>
	</div>	